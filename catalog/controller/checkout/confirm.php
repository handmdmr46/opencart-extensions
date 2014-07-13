<?php 
class ControllerCheckoutConfirm extends Controller { 
	public function index() {
		$redirect = '';
		
		if ($this->cart->hasShipping()) {
			// Validate if shipping address has been set.		
			$this->load->model('account/address');
	
			if ($this->customer->isLogged() && isset($this->session->data['shipping_address_id'])) {					
				$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);		
			} elseif (isset($this->session->data['guest'])) {
				$shipping_address = $this->session->data['guest']['shipping'];
			}
			
			if (empty($shipping_address)) {								
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}
			
			// Validate if shipping method has been set.	
			if (!isset($this->session->data['shipping_method'])) {
				$redirect = $this->url->link('checkout/checkout', '', 'SSL');
			}
		} else {
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
		}
		
		// Validate if payment address has been set.
		$this->load->model('account/address');
		
		if ($this->customer->isLogged() && isset($this->session->data['payment_address_id'])) {
			$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);		
		} elseif (isset($this->session->data['guest'])) {
			$payment_address = $this->session->data['guest']['payment'];
		}	
				
		if (empty($payment_address)) {
			$redirect = $this->url->link('checkout/checkout', '', 'SSL');
		}			
		
		// Validate if payment method has been set.	
		if (!isset($this->session->data['payment_method'])) {
			$redirect = $this->url->link('checkout/checkout', '', 'SSL');
		}
					
		// Validate cart has products and has stock.	
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$redirect = $this->url->link('checkout/cart');				
		}	
		
		// Validate minimum quantity requirments.			
		$products = $this->cart->getProducts();
				
		foreach ($products as $product) {
			$product_total = 0;
			
			// if products are the same increase the quantity	
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}		
			
			if ($product['minimum'] > $product_total) {
				$redirect = $this->url->link('checkout/cart');
				
				break;
			}				
		}
		
		if (!$redirect) {
			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
			 
			$this->load->model('setting/extension');
			
			$sort_order = array(); 
			
			$results = $this->model_setting_extension->getExtensions('total');
						
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				/*
				* $sort_order[0] = shipping_sort_order
				* $sort_order[1] = sub_total_sort_order
				* $sort_order[2] = tax_sort_order
				* $sort_order[3] = total_sort_order
				* $sort_order[4] = credit_sort_order
				* $sort_order[5] = handling_sort_order
				* $sort_order[6] = low_order_fee_sort_order
				* $sort_order[7] = coupon_sort_order
				* $sort_order[8] = reward_sort_order
				* $sort_order[9] = voucher_sort_order
				*/
			}
			
			array_multisort($sort_order, SORT_ASC, $results); // sorts array in ascending order
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					/*
					* shipping_status
					* sub_total_status
					* tax_status
					* total_status
					* credit_status
					* handling_status
					* low_order_fee_status
					* coupon_status
					* reward_status
					* voucher_status
					*/
					$this->load->model('total/' . $result['code']);
					/*
					* $this->load->model('total/shipping');
					* $this->load->model('total/sub_total');
					* $this->load->model('total/tax');
					* $this->load->model('total/total');
					* $this->load->model('total/credit');
					* $this->load->model('total/handling');
					* $this->load->model('total/low_order_fee');
					* $this->load->model('total/coupon');
					* $this->load->model('total/reward');
					* $this->load->model('total/voucher');
					*/
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					/*
					* $this->model_total_shipping->getTotal($total_data, $total, $taxes);
					* $this->model_total_sub_total->getTotal($total_data, $total, $taxes);
					* $this->model_total_tax->getTotal($total_data, $total, $taxes);
					* $this->model_total_total->getTotal($total_data, $total, $taxes);
					* $this->model_total_credit->getTotal($total_data, $total, $taxes);
					* $this->model_total_handling->getTotal($total_data, $total, $taxes);
					* $this->model_total_low_order_fee->getTotal($total_data, $total, $taxes);
					* $this->model_total_coupon->getTotal($total_data, $total, $taxes);
					* $this->model_total_reward->getTotal($total_data, $total, $taxes);
					* $this->model_total_voucher->getTotal($total_data, $total, $taxes);
					*/
				}
			}
			
			$sort_order = array(); 
		  
			foreach ($total_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
	
			array_multisort($sort_order, SORT_ASC, $total_data); // sorts array in ascending order
	
			$this->language->load('checkout/checkout');
			
			$data = array();
			
			$data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$data['store_id'] = $this->config->get('config_store_id');
			$data['store_name'] = $this->config->get('config_name');
			
			if ($data['store_id']) {
				$data['store_url'] = $this->config->get('config_url');		
			} else {
				$data['store_url'] = HTTP_SERVER;	
			}
			
			// Customer Logged -OR- Guest?
			if ($this->customer->isLogged()) {
				$data['customer_id'] = $this->customer->getId();
				$data['customer_group_id'] = $this->customer->getCustomerGroupId();
				$data['firstname'] = $this->customer->getFirstName();
				$data['lastname'] = $this->customer->getLastName();
				$data['email'] = $this->customer->getEmail();
				$data['telephone'] = $this->customer->getTelephone();
				$data['fax'] = $this->customer->getFax();
			
				$this->load->model('account/address');
				
				$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
			} elseif (isset($this->session->data['guest'])) {
				$data['customer_id'] = 0;
				$data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
				$data['firstname'] = $this->session->data['guest']['firstname'];
				$data['lastname'] = $this->session->data['guest']['lastname'];
				$data['email'] = $this->session->data['guest']['email'];
				$data['telephone'] = $this->session->data['guest']['telephone'];
				$data['fax'] = $this->session->data['guest']['fax'];
				
				$payment_address = $this->session->data['guest']['payment'];
			}
			
			// Payment 
			$data['payment_firstname']      = $payment_address['firstname'];
			$data['payment_lastname']       = $payment_address['lastname'];	
			$data['payment_company']        = $payment_address['company'];	
			$data['payment_company_id']     = $payment_address['company_id'];	
			$data['payment_tax_id']         = $payment_address['tax_id'];	
			$data['payment_address_1']      = $payment_address['address_1'];
			$data['payment_address_2']      = $payment_address['address_2'];
			$data['payment_city']           = $payment_address['city'];
			$data['payment_postcode']       = $payment_address['postcode'];
			$data['payment_zone']           = $payment_address['zone'];
			$data['payment_zone_id']        = $payment_address['zone_id'];
			$data['payment_country']        = $payment_address['country'];
			$data['payment_country_id']     = $payment_address['country_id'];
			$data['payment_address_format'] = $payment_address['address_format'];
		    
			// Payment Method
			if (isset($this->session->data['payment_method']['title'])) {
				$data['payment_method'] = $this->session->data['payment_method']['title'];
			} else {
				$data['payment_method'] = '';
			}
			
			if (isset($this->session->data['payment_method']['code'])) {
				$data['payment_code'] = $this->session->data['payment_method']['code'];
			} else {
				$data['payment_code'] = '';
			}
			
			// Shipping information			
			if ($this->cart->hasShipping()) {
				if ($this->customer->isLogged()) {
					$this->load->model('account/address');
					
					$shipping_address = $this->model_account_address->getAddress($this->session->data['shipping_address_id']);	
				} elseif (isset($this->session->data['guest'])) {
					$shipping_address = $this->session->data['guest']['shipping'];
				}			
				
				$data['shipping_firstname'] = $shipping_address['firstname'];
				$data['shipping_lastname'] = $shipping_address['lastname'];	
				$data['shipping_company'] = $shipping_address['company'];	
				$data['shipping_address_1'] = $shipping_address['address_1'];
				$data['shipping_address_2'] = $shipping_address['address_2'];
				$data['shipping_city'] = $shipping_address['city'];
				$data['shipping_postcode'] = $shipping_address['postcode'];
				$data['shipping_zone'] = $shipping_address['zone'];
				$data['shipping_zone_id'] = $shipping_address['zone_id'];
				$data['shipping_country'] = $shipping_address['country'];
				$data['shipping_country_id'] = $shipping_address['country_id'];
				$data['shipping_address_format'] = $shipping_address['address_format'];
			
				if (isset($this->session->data['shipping_method']['title'])) {
					$data['shipping_method'] = $this->session->data['shipping_method']['title'];
				} else {
					$data['shipping_method'] = '';
				}
				
				if (isset($this->session->data['shipping_method']['code'])) {
					$data['shipping_code'] = $this->session->data['shipping_method']['code'];
				} else {
					$data['shipping_code'] = '';
				}				
			} else {
				$data['shipping_firstname']      = '';
				$data['shipping_lastname']       = '';	
				$data['shipping_company']        = '';	
				$data['shipping_address_1']      = '';
				$data['shipping_address_2']      = '';
				$data['shipping_city']           = '';
				$data['shipping_postcode']       = '';
				$data['shipping_zone']           = '';
				$data['shipping_zone_id']        = '';
				$data['shipping_country']        = '';
				$data['shipping_country_id']     = '';
				$data['shipping_address_format'] = '';
				$data['shipping_method']         = '';
				$data['shipping_code']           = '';
			}
			
			$product_data = array();
			$affiliate_id = array();
			foreach ($this->cart->getProducts() as $product) {
				$affiliate_id[] = $product['affiliate_id'];

				// Options
				$option_data = array();
				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['option_value'];	
					} else {
						$value = $this->encryption->decrypt($option['option_value']);
					}	
					
					$option_data[] = array(
						'product_option_id'       => $option['product_option_id'],
						'product_option_value_id' => $option['product_option_value_id'],
						'option_id'               => $option['option_id'],
						'option_value_id'         => $option['option_value_id'],								   
						'name'                    => $option['name'],
						'value'                   => $value,
						'type'                    => $option['type']
					);					
				}
	           			     
				$product_data[] = array(
					'product_id'   => $product['product_id'],
					'name'         => $product['name'],
					'model'        => $product['model'],
					'option'       => $option_data,
					'download'     => $product['download'],
					'quantity'     => $product['quantity'],
					'subtract'     => $product['subtract'],
					'price'        => $product['price'],
					'total'        => $product['total'],
					'tax'          => $this->tax->getTax($product['price'], $product['tax_class_id']),
					'reward'       => $product['reward'],
					'affiliate_id' => $product['affiliate_id'] // added affiliate_id
				); 

			}
			
			// Gift Voucher
			$voucher_data = array();
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$voucher_data[] = array(
						'description'      => $voucher['description'],
						'code'             => substr(md5(mt_rand()), 0, 10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],						
						'amount'           => $voucher['amount']
					);
				}
			}  
			
			$data['products']       = $product_data;
			$data['vouchers']       = $voucher_data;
			$data['totals']         = $total_data;
			$data['comment']        = $this->session->data['comment'];
			$data['total']          = $total;
			$data['language_id']    = $this->config->get('config_language_id');
			$data['currency_id']    = $this->currency->getId();
			$data['currency_code']  = $this->currency->getCode();
			$data['currency_value'] = $this->currency->getValue($this->currency->getCode());
			$data['ip']             = $this->request->server['REMOTE_ADDR'];
			$data['affiliate_id']   = 0; // to prevent warning
			$data['commission']     = 0; // to prevent warning
			
			// forwarded_ip
			if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];	
			} elseif(!empty($this->request->server['HTTP_CLIENT_IP'])) {
				$data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];	
			} else {
				$data['forwarded_ip'] = '';
			}
			
			// user_agent
			if (isset($this->request->server['HTTP_USER_AGENT'])) {
				$data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];	
			} else {
				$data['user_agent'] = '';
			}
			
			// accept_language
			if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
				$data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];	
			} else {
				$data['accept_language'] = '';
			}
						
			// Add Master Order 
			$this->load->model('checkout/order');
			$this->session->data['order_id'] = $this->model_checkout_order->addMasterOrder($data);
			
		    // Display product total's -- confirm.tpl --	
			$this->data['column_name']     = $this->language->get('column_name');
			$this->data['column_model']    = $this->language->get('column_model');
			$this->data['column_quantity'] = $this->language->get('column_quantity');
			$this->data['column_price']    = $this->language->get('column_price');
			$this->data['column_total']    = $this->language->get('column_total');
			
			$this->data['products'] = array();
			foreach ($this->cart->getProducts() as $product) {
				
				// Options
				$option_data = array();	           
				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['option_value'];	
					} else {
						$filename = $this->encryption->decrypt($option['option_value']);						
						$value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
					}
										
					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}  
	 
				$this->data['products'][] = array(
					'product_id'    => $product['product_id'],
					'name'          => $product['name'],
					'model'         => $product['model'],
					'option'        => $option_data,
					'quantity'      => $product['quantity'],
					'subtract'      => $product['subtract'],
					'price'         => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))),
					'total'         => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']),
					'href'          => $this->url->link('product/product', 'product_id=' . $product['product_id']),
					'affiliate_id'  => $product['affiliate_id']
				); 
			} 
			
			// Gift Voucher
			$this->data['vouchers'] = array();
			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$this->data['vouchers'][] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'])
					);
				}
			}  
			
			// Order Totals for Confirm View			
			$this->data['totals'] = $total_data;
			// **** confirm payment and FINALIZE ORDER through payment module *****
			
			$this->data['payment'] = $this->getChild('payment/' . $this->session->data['payment_method']['code']);
		} else {
			$this->data['redirect'] = $redirect;
		}			
		
		// Add Affiliate Orders
		/*if($this->cart->countProducts() > 1) {
			foreach($this->cart->getProducts() as $product) {
				if($product['affiliate_id'] != 0) {
					$this->addAffiliateOrder($data);
				}
			}           
		}*/

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/checkout/confirm.tpl';
		} else {
			$this->template = 'default/template/checkout/confirm.tpl';
		}
		
		$this->response->setOutput($this->render());	
  	}
	
	/*public function addAffiliateOrder($data) {
		foreach($this->cart->getProducts() as $product) {
			$affiliate_id[] = $product['affiliate_id'];
		}
		$affiliate_id = array_count_values($affiliate_id);
		$data['affiliate_id'] = $affiliate_id;
		$data['session_shipping'] = $this->session->data['shipping_method']['cost'];
		$this->load->model('affiliate/dashboard_order_total');
		$this->model_affiliate_dashboard_order_total->addAffiliateOrders($data);
	}*/
	
	
	
	
	
	
              	
}
?>