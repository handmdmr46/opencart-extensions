<?php
class ControllerSaleOrderMaster extends Controller {
	private $error = array();

  	public function index() {
		$this->language->load('sale/order');

		$this->document->setTitle($this->language->get('heading_title_master'));

		$this->load->model('sale/order');

    	$this->getList();
  	}
	
  	public function delete() {
		$this->language->load('sale/order');

		$this->document->setTitle($this->language->get('heading_title_master'));

		$this->load->model('sale/order');

    	if (isset($this->request->post['selected']) && ($this->validateDelete())) {
			foreach ($this->request->post['selected'] as $order_id) {
				$this->model_sale_order->deleteOrder($order_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}
			
			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
												
			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}
			
			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}
						
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
			
			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}
													
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/order', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getList();
  	}

  	protected function getList() {
  		// Filter
		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = null;
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}

		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = null;
		}
		
		if (isset($this->request->get['filter_total'])) {
			$filter_total = $this->request->get['filter_total'];
		} else {
			$filter_total = null;
		}
		
		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
											
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		// Breadcrumbs
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title_master'),
			'href'      => $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

   		// Buttons
		$this->data['invoice'] = $this->url->link('sale/order_master/invoice', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete']  = $this->url->link('sale/order_master/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data = array(
			'filter_order_id'        => $filter_order_id,
			'filter_customer'	     => $filter_customer,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_total'           => $filter_total,
			'filter_date_added'      => $filter_date_added,
			'filter_date_modified'   => $filter_date_modified,
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		// Orders
		$this->data['orders'] = array();
		/*$order_total = $this->model_sale_order->getTotalOrders($data);
		$results = $this->model_sale_order->getOrders($data);*/

		// master orders
		$order_total = $this->model_sale_order->getTotalMasterOrders($data);
		$results = $this->model_sale_order->getMasterOrders($data);

    	foreach ($results as $result) {
			// [view]
			$action = array();			
			$action[] = array(
				'text' => $this->language->get('text_view'),
				'href' => $this->url->link('sale/order_master/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
			);
			
			$this->data['orders'][] = array(
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'status'        => $result['status'],
				'total'         => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'selected'      => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
				'action'        => $action
			);
		}

		// Language
		$this->data['heading_title']        = $this->language->get('heading_title_master');
		$this->data['text_no_results']      = $this->language->get('text_no_results');
		$this->data['text_missing']         = $this->language->get('text_missing');
		$this->data['column_order_id']      = $this->language->get('column_order_id');
		$this->data['column_customer']      = $this->language->get('column_customer');
		$this->data['column_status']        = $this->language->get('column_status');
		$this->data['column_total']         = $this->language->get('column_total');
		$this->data['column_date_added']    = $this->language->get('column_date_added');
		$this->data['column_date_modified'] = $this->language->get('column_date_modified');
		$this->data['column_action']        = $this->language->get('column_action');
		$this->data['button_invoice']       = $this->language->get('button_invoice');
		$this->data['button_insert']        = $this->language->get('button_insert');
		$this->data['button_delete']        = $this->language->get('button_delete');
		$this->data['button_filter']        = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];
		
		// Error
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		// Success
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		// Filter
		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
											
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_order']         = $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$this->data['sort_customer']      = $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$this->data['sort_status']        = $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$this->data['sort_total']         = $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$this->data['sort_date_added']    = $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

		// Filter
		$url = '';

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}
											
		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}
		
		if (isset($this->request->get['filter_total'])) {
			$url .= '&filter_total=' . $this->request->get['filter_total'];
		}
					
		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}
		
		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination        = new Pagination();
		$pagination->total = $order_total;
		$pagination->page  = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text  = $this->language->get('text_pagination');
		$pagination->url   = $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination']             = $pagination->render();
		
		$this->data['filter_order_id']        = $filter_order_id;
		$this->data['filter_customer']        = $filter_customer;
		$this->data['filter_order_status_id'] = $filter_order_status_id;
		$this->data['filter_total']           = $filter_total;
		$this->data['filter_date_added']      = $filter_date_added;
		$this->data['filter_date_modified']   = $filter_date_modified;

		$this->load->model('localisation/order_status');
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		$this->data['sort']           = $sort;
		$this->data['order']          = $order;

		$this->template = 'sale/order_list_master.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render());
  	}
	
   	protected function validateDelete() {
    	if (!$this->user->hasPermission('modify', 'sale/order')) {
			$this->error['warning'] = $this->language->get('error_permission');
    	}

		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
	
	public function country() {
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}
		
	public function info() {
		$this->load->model('sale/order');

		if (isset($this->request->get['order_id'])) {
			$order_id = $this->request->get['order_id'];
		} else {
			$order_id = 0;
		}

		$order_info = $this->model_sale_order->getMasterOrder($order_id);

		if ($order_info) {
			$this->language->load('sale/order');

			$this->document->setTitle($this->language->get('heading_title_master'));

			// Language
			$this->data['heading_title']                           = $this->language->get('heading_title_master');
			$this->data['text_order_id']                           = $this->language->get('text_order_id');
			$this->data['text_invoice_no']                         = $this->language->get('text_invoice_no');
			$this->data['text_invoice_date']                       = $this->language->get('text_invoice_date');
			$this->data['text_store_name']                         = $this->language->get('text_store_name');
			$this->data['text_store_url']                          = $this->language->get('text_store_url');		
			$this->data['text_customer']                           = $this->language->get('text_customer');
			$this->data['text_customer_group']                     = $this->language->get('text_customer_group');
			$this->data['text_email']                              = $this->language->get('text_email');
			$this->data['text_telephone']                          = $this->language->get('text_telephone');
			$this->data['text_fax']                                = $this->language->get('text_fax');
			$this->data['text_total']                              = $this->language->get('text_total');
			$this->data['text_reward']                             = $this->language->get('text_reward');		
			$this->data['text_order_status']                       = $this->language->get('text_order_status');
			$this->data['text_comment']                            = $this->language->get('text_comment');
			$this->data['text_affiliate']                          = $this->language->get('text_affiliate');
			$this->data['text_commission']                         = $this->language->get('text_commission');
			$this->data['text_ip']                                 = $this->language->get('text_ip');
			$this->data['text_forwarded_ip']                       = $this->language->get('text_forwarded_ip');
			$this->data['text_user_agent']                         = $this->language->get('text_user_agent');
			$this->data['text_accept_language']                    = $this->language->get('text_accept_language');
			$this->data['text_date_added']                         = $this->language->get('text_date_added');
			$this->data['text_date_modified']                      = $this->language->get('text_date_modified');			
			$this->data['text_firstname']                          = $this->language->get('text_firstname');
			$this->data['text_lastname']                           = $this->language->get('text_lastname');
			$this->data['text_company']                            = $this->language->get('text_company');
			$this->data['text_company_id']                         = $this->language->get('text_company_id');
			$this->data['text_tax_id']                             = $this->language->get('text_tax_id');
			$this->data['text_address_1']                          = $this->language->get('text_address_1');
			$this->data['text_address_2']                          = $this->language->get('text_address_2');
			$this->data['text_city']                               = $this->language->get('text_city');
			$this->data['text_postcode']                           = $this->language->get('text_postcode');
			$this->data['text_zone']                               = $this->language->get('text_zone');
			$this->data['text_zone_code']                          = $this->language->get('text_zone_code');
			$this->data['text_country']                            = $this->language->get('text_country');
			$this->data['text_shipping_method']                    = $this->language->get('text_shipping_method');
			$this->data['text_payment_method']                     = $this->language->get('text_payment_method');	
			$this->data['text_download']                           = $this->language->get('text_download');
			$this->data['text_wait']                               = $this->language->get('text_wait');
			$this->data['text_generate']                           = $this->language->get('text_generate');
			$this->data['text_reward_add']                         = $this->language->get('text_reward_add');
			$this->data['text_reward_remove']                      = $this->language->get('text_reward_remove');
			$this->data['text_commission_add']                     = $this->language->get('text_commission_add');
			$this->data['text_commission_remove']                  = $this->language->get('text_commission_remove');
			$this->data['text_credit_add']                         = $this->language->get('text_credit_add');
			$this->data['text_credit_remove']                      = $this->language->get('text_credit_remove');
			$this->data['text_country_match']                      = $this->language->get('text_country_match');
			$this->data['text_country_code']                       = $this->language->get('text_country_code');
			$this->data['text_high_risk_country']                  = $this->language->get('text_high_risk_country');
			$this->data['text_distance']                           = $this->language->get('text_distance');
			$this->data['text_ip_region']                          = $this->language->get('text_ip_region');
			$this->data['text_ip_city']                            = $this->language->get('text_ip_city');
			$this->data['text_ip_latitude']                        = $this->language->get('text_ip_latitude');
			$this->data['text_ip_longitude']                       = $this->language->get('text_ip_longitude');
			$this->data['text_ip_isp']                             = $this->language->get('text_ip_isp');
			$this->data['text_ip_org']                             = $this->language->get('text_ip_org');
			$this->data['text_ip_asnum']                           = $this->language->get('text_ip_asnum');
			$this->data['text_ip_user_type']                       = $this->language->get('text_ip_user_type');
			$this->data['text_ip_country_confidence']              = $this->language->get('text_ip_country_confidence');
			$this->data['text_ip_region_confidence']               = $this->language->get('text_ip_region_confidence');
			$this->data['text_ip_city_confidence']                 = $this->language->get('text_ip_city_confidence');
			$this->data['text_ip_postal_confidence']               = $this->language->get('text_ip_postal_confidence');
			$this->data['text_ip_postal_code']                     = $this->language->get('text_ip_postal_code');
			$this->data['text_ip_accuracy_radius']                 = $this->language->get('text_ip_accuracy_radius');
			$this->data['text_ip_net_speed_cell']                  = $this->language->get('text_ip_net_speed_cell');
			$this->data['text_ip_metro_code']                      = $this->language->get('text_ip_metro_code');
			$this->data['text_ip_area_code']                       = $this->language->get('text_ip_area_code');
			$this->data['text_ip_time_zone']                       = $this->language->get('text_ip_time_zone');
			$this->data['text_ip_region_name']                     = $this->language->get('text_ip_region_name');
			$this->data['text_ip_domain']                          = $this->language->get('text_ip_domain');
			$this->data['text_ip_country_name']                    = $this->language->get('text_ip_country_name');
			$this->data['text_ip_continent_code']                  = $this->language->get('text_ip_continent_code');
			$this->data['text_ip_corporate_proxy']                 = $this->language->get('text_ip_corporate_proxy');
			$this->data['text_anonymous_proxy']                    = $this->language->get('text_anonymous_proxy');
			$this->data['text_proxy_score']                        = $this->language->get('text_proxy_score');
			$this->data['text_is_trans_proxy']                     = $this->language->get('text_is_trans_proxy');
			$this->data['text_free_mail']                          = $this->language->get('text_free_mail');
			$this->data['text_carder_email']                       = $this->language->get('text_carder_email');
			$this->data['text_high_risk_username']                 = $this->language->get('text_high_risk_username');
			$this->data['text_high_risk_password']                 = $this->language->get('text_high_risk_password');
			$this->data['text_bin_match']                          = $this->language->get('text_bin_match');
			$this->data['text_bin_country']                        = $this->language->get('text_bin_country');
			$this->data['text_bin_name_match']                     = $this->language->get('text_bin_name_match');
			$this->data['text_bin_name']                           = $this->language->get('text_bin_name');
			$this->data['text_bin_phone_match']                    = $this->language->get('text_bin_phone_match');
			$this->data['text_bin_phone']                          = $this->language->get('text_bin_phone');
			$this->data['text_customer_phone_in_billing_location'] = $this->language->get('text_customer_phone_in_billing_location');
			$this->data['text_ship_forward']                       = $this->language->get('text_ship_forward');
			$this->data['text_city_postal_match']                  = $this->language->get('text_city_postal_match');
			$this->data['text_ship_city_postal_match']             = $this->language->get('text_ship_city_postal_match');
			$this->data['text_score']                              = $this->language->get('text_score');
			$this->data['text_explanation']                        = $this->language->get('text_explanation');
			$this->data['text_risk_score']                         = $this->language->get('text_risk_score');
			$this->data['text_queries_remaining']                  = $this->language->get('text_queries_remaining');
			$this->data['text_maxmind_id']                         = $this->language->get('text_maxmind_id');
			$this->data['text_error']                              = $this->language->get('text_error');			
			$this->data['column_product']                          = $this->language->get('column_product');
			$this->data['column_model']                            = $this->language->get('column_model');
			$this->data['column_quantity']                         = $this->language->get('column_quantity');
			$this->data['column_price']                            = $this->language->get('column_price');
			$this->data['column_total']                            = $this->language->get('column_total');
			$this->data['column_download']                         = $this->language->get('column_download');
			$this->data['column_filename']                         = $this->language->get('column_filename');
			$this->data['column_remaining']                        = $this->language->get('column_remaining');
			$this->data['column_seller']                           = $this->language->get('column_seller');			
			$this->data['entry_order_status']                      = $this->language->get('entry_order_status');
			$this->data['entry_notify']                            = $this->language->get('entry_notify');
			$this->data['entry_comment']                           = $this->language->get('entry_comment');
			$this->data['button_invoice']                          = $this->language->get('button_invoice');
			$this->data['button_cancel']                           = $this->language->get('button_cancel');
			$this->data['button_add_history']                      = $this->language->get('button_add_history');
			$this->data['tab_order']                               = $this->language->get('tab_order');
			$this->data['tab_payment']                             = $this->language->get('tab_payment');
			$this->data['tab_shipping']                            = $this->language->get('tab_shipping');
			$this->data['tab_product']                             = $this->language->get('tab_product');
			$this->data['tab_history']                             = $this->language->get('tab_history');
			$this->data['tab_fraud']                               = $this->language->get('tab_fraud');
			$this->data['column_ebay_response']                    = $this->language->get('column_ebay_response');
			$this->data['tab_stock_control']                       = $this->language->get('tab_stock_control');
		
			$this->data['token'] = $this->session->data['token'];

			$url = '';

			// Filters
			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}
			
			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}
												
			if (isset($this->request->get['filter_order_status_id'])) {
				$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
			}
			
			if (isset($this->request->get['filter_total'])) {
				$url .= '&filter_total=' . $this->request->get['filter_total'];
			}
						
			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}
			
			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			// Breadcrumbs
			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title_master'),
				'href'      => $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . $url, 'SSL'),				
				'separator' => ' :: '
			);

			// Buttons
			$this->data['invoice'] = $this->url->link('sale/order_master/invoice', 'token=' . $this->session->data['token'] . '&order_id=' . (int)$this->request->get['order_id'], 'SSL');
			$this->data['cancel'] = $this->url->link('sale/order_master', 'token=' . $this->session->data['token'] . $url, 'SSL');

			// OrderID - InvoiceNo - CustomerID
			$this->data['order_id'] = $this->request->get['order_id'];			
			if ($order_info['invoice_no']) {
				$this->data['invoice_no'] = $order_info['invoice_prefix'] . $order_info['invoice_no'];
			} else {
				$this->data['invoice_no'] = '';
			}									
			if ($order_info['customer_id']) {
				$this->data['customer'] = $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $order_info['customer_id'], 'SSL');
			} else {
				$this->data['customer'] = '';
			}

			// Customer Group
			$this->load->model('sale/customer_group');
			$customer_group_info = $this->model_sale_customer_group->getCustomerGroup($order_info['customer_group_id']);
			if ($customer_group_info) {
				$this->data['customer_group'] = $customer_group_info['name'];
			} else {
				$this->data['customer_group'] = '';
			}

			// Order Info 
			$this->data['ip']                 = $order_info['ip'];
			$this->data['forwarded_ip']       = $order_info['forwarded_ip'];
			$this->data['user_agent']         = $order_info['user_agent'];
			$this->data['accept_language']    = $order_info['accept_language'];
			$this->data['date_added']         = date($this->language->get('date_format_short'), strtotime($order_info['date_added']));
			$this->data['date_modified']      = date($this->language->get('date_format_short'), strtotime($order_info['date_modified']));		
			$this->data['payment_firstname']  = $order_info['payment_firstname'];
			$this->data['payment_lastname']   = $order_info['payment_lastname'];
			$this->data['payment_company']    = $order_info['payment_company'];
			$this->data['payment_company_id'] = $order_info['payment_company_id'];
			$this->data['payment_tax_id']     = $order_info['payment_tax_id'];
			$this->data['payment_address_1']  = $order_info['payment_address_1'];
			$this->data['payment_address_2']  = $order_info['payment_address_2'];
			$this->data['payment_city']       = $order_info['payment_city'];
			$this->data['payment_postcode']   = $order_info['payment_postcode'];
			$this->data['payment_zone']       = $order_info['payment_zone'];
			$this->data['payment_zone_code']  = $order_info['payment_zone_code'];
			$this->data['payment_country']    = $order_info['payment_country'];			
			$this->data['shipping_firstname'] = $order_info['shipping_firstname'];
			$this->data['shipping_lastname']  = $order_info['shipping_lastname'];
			$this->data['shipping_company']   = $order_info['shipping_company'];
			$this->data['shipping_address_1'] = $order_info['shipping_address_1'];
			$this->data['shipping_address_2'] = $order_info['shipping_address_2'];
			$this->data['shipping_city']      = $order_info['shipping_city'];
			$this->data['shipping_postcode']  = $order_info['shipping_postcode'];
			$this->data['shipping_zone']      = $order_info['shipping_zone'];
			$this->data['shipping_zone_code'] = $order_info['shipping_zone_code'];
			$this->data['shipping_country']   = $order_info['shipping_country'];
			$this->data['store_name']         = $order_info['store_name'];
			$this->data['store_url']          = $order_info['store_url'];
			$this->data['firstname']          = $order_info['firstname'];
			$this->data['lastname']           = $order_info['lastname'];
			$this->data['email']              = $order_info['email'];
			$this->data['telephone']          = $order_info['telephone'];
			$this->data['fax']                = $order_info['fax'];
			$this->data['comment']            = nl2br($order_info['comment']);
			$this->data['shipping_method']    = $order_info['shipping_method'];
			$this->data['payment_method']     = $order_info['payment_method'];
			$this->data['total']              = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value']);		

			if ($order_info['total'] < 0) {
				$this->data['credit'] = $order_info['total'];
			} else {
				$this->data['credit'] = 0;
			}
			
			// Reward - Credit
			$this->load->model('sale/customer');					
			$this->data['credit_total'] = $this->model_sale_customer->getTotalTransactionsByOrderId($this->request->get['order_id']); 
			$this->data['reward_total'] = $this->model_sale_customer->getTotalCustomerRewardsByOrderId($this->request->get['order_id']);			
			$this->data['reward'] = $order_info['reward'];		

			// Affiliate
			// $this->data['affiliate_firstname'] = $order_info['affiliate_firstname'];
			// $this->data['affiliate_lastname'] = $order_info['affiliate_lastname'];			
			// if ($order_info['affiliate_id']) {
			// 	$this->data['affiliate'] = $this->url->link('sale/affiliate/update', 'token=' . $this->session->data['token'] . '&affiliate_id=' . $order_info['affiliate_id'], 'SSL');
			// } else {
			//	$this->data['affiliate'] = '';
			// }
			$this->data['affiliate'] = '';
			
			// Commission
			$this->load->model('sale/affiliate');			
			$this->data['commission_total'] = $this->model_sale_affiliate->getTotalTransactionsByOrderId($this->request->get['order_id']);
			$this->data['commission'] = $this->currency->format($order_info['commission'], $order_info['currency_code'], $order_info['currency_value']);
			
			// Order Status		
			$this->load->model('localisation/order_status');
			$order_status_info = $this->model_localisation_order_status->getOrderStatus($order_info['order_status_id']);
			if ($order_status_info) {
				$this->data['order_status'] = $order_status_info['name'];
			} else {
				$this->data['order_status'] = '';
			}

			// Products
			$this->data['products'] = array();
			$products = $this->model_sale_order->getOrderProducts($this->request->get['order_id']);
			foreach ($products as $product) {
				
				// Options
				$option_data = array();
				$options = $this->model_sale_order->getOrderOptions($this->request->get['order_id'], $product['order_product_id']);
				foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);
					} else {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.')),
							'type'  => $option['type'],
							'href'  => $this->url->link('sale/order/download', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&order_option_id=' . $option['order_option_id'], 'SSL')
						);						
					}
				}

				
				if($product['affiliate_id'] == 0) {
					$this->data['products'][] = array(
						'order_product_id'    => $product['order_product_id'],
						'product_id'          => $product['product_id'],
						'name'                => $product['name'],
						'model'               => $product['model'],
						'option'              => $option_data,
						'quantity'            => $product['quantity'],
						'price'               => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'               => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
						'href'                => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], 'SSL'),
						'ebay_response'       => $product['ebay_response'],
						'affiliate_firstname' => 'Kenny',
						'affiliate_lastname'  => 'Shinn'
					);
				} else {
					$affiliate_info = $this->model_sale_order->getAffiliateInfo($product['affiliate_id']);
					$this->data['products'][] = array(
						'order_product_id'    => $product['order_product_id'],
						'product_id'          => $product['product_id'],
						'name'                => $product['name'],
						'model'               => $product['model'],
						'option'              => $option_data,
						'quantity'            => $product['quantity'],
						'price'               => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'               => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value']),
						'href'                => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $product['product_id'], 'SSL'),
						'ebay_response'       => $product['ebay_response'],
						'affiliate_firstname' => $affiliate_info['firstname'],
						'affiliate_lastname'  => $affiliate_info['lastname']
					);
				}
				
			}
		    
		    // Vouchers
			$this->data['vouchers'] = array();				
			$vouchers = $this->model_sale_order->getOrderVouchers($this->request->get['order_id']);			 
			foreach ($vouchers as $voucher) {
				$this->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value']),
					'href'        => $this->url->link('sale/voucher/update', 'token=' . $this->session->data['token'] . '&voucher_id=' . $voucher['voucher_id'], 'SSL')
				);
			}
			
			// Order Totals
			$this->data['totals'] = $this->model_sale_order->getOrderTotals($this->request->get['order_id']);

			// Downloads
			$this->data['downloads'] = array();
			foreach ($products as $product) {
				$results = $this->model_sale_order->getOrderDownloads($this->request->get['order_id'], $product['order_product_id']);
				foreach ($results as $result) {
					$this->data['downloads'][] = array(
						'name'      => $result['name'],
						'filename'  => $result['mask'],
						'remaining' => $result['remaining']
					);
				}
			}
			
			// Order Status
			$this->data['order_statuses']  = $this->model_localisation_order_status->getOrderStatuses();
			$this->data['order_status_id'] = $order_info['order_status_id'];

			// Fraud
			$this->load->model('sale/fraud');			
			$fraud_info = $this->model_sale_fraud->getFraud($order_info['order_id']);			
			if ($fraud_info) {
				$this->data['country_match'] = $fraud_info['country_match'];
				
				if ($fraud_info['country_code']) {
					$this->data['country_code'] = $fraud_info['country_code'];
				} else {
					$this->data['country_code'] = '';
				}
				
				$this->data['high_risk_country'] = $fraud_info['high_risk_country'];
				$this->data['distance'] = $fraud_info['distance'];
				
				if ($fraud_info['ip_region']) {
					$this->data['ip_region'] = $fraud_info['ip_region'];
				} else {
					$this->data['ip_region'] = '';
				}
								
				if ($fraud_info['ip_city']) {
					$this->data['ip_city'] = $fraud_info['ip_city'];
				} else {
					$this->data['ip_city'] = '';
				}
				
				$this->data['ip_latitude'] = $fraud_info['ip_latitude'];
				$this->data['ip_longitude'] = $fraud_info['ip_longitude'];

				if ($fraud_info['ip_isp']) {
					$this->data['ip_isp'] = $fraud_info['ip_isp'];
				} else {
					$this->data['ip_isp'] = '';
				}
				
				if ($fraud_info['ip_org']) {
					$this->data['ip_org'] = $fraud_info['ip_org'];
				} else {
					$this->data['ip_org'] = '';
				}
								
				$this->data['ip_asnum'] = $fraud_info['ip_asnum'];
				
				if ($fraud_info['ip_user_type']) {
					$this->data['ip_user_type'] = $fraud_info['ip_user_type'];
				} else {
					$this->data['ip_user_type'] = '';
				}
				
				if ($fraud_info['ip_country_confidence']) {
					$this->data['ip_country_confidence'] = $fraud_info['ip_country_confidence'];
				} else {
					$this->data['ip_country_confidence'] = '';
				}
												
				if ($fraud_info['ip_region_confidence']) {
					$this->data['ip_region_confidence'] = $fraud_info['ip_region_confidence'];
				} else {
					$this->data['ip_region_confidence'] = '';
				}
				
				if ($fraud_info['ip_city_confidence']) {
					$this->data['ip_city_confidence'] = $fraud_info['ip_city_confidence'];
				} else {
					$this->data['ip_city_confidence'] = '';
				}
				
				if ($fraud_info['ip_postal_confidence']) {
					$this->data['ip_postal_confidence'] = $fraud_info['ip_postal_confidence'];
				} else {
					$this->data['ip_postal_confidence'] = '';
				}
				
				if ($fraud_info['ip_postal_code']) {
					$this->data['ip_postal_code'] = $fraud_info['ip_postal_code'];
				} else {
					$this->data['ip_postal_code'] = '';
				}
								
				$this->data['ip_accuracy_radius'] = $fraud_info['ip_accuracy_radius'];
				
				if ($fraud_info['ip_net_speed_cell']) {
					$this->data['ip_net_speed_cell'] = $fraud_info['ip_net_speed_cell'];
				} else {
					$this->data['ip_net_speed_cell'] = '';
				}
								
				$this->data['ip_metro_code'] = $fraud_info['ip_metro_code'];
				$this->data['ip_area_code'] = $fraud_info['ip_area_code'];
				
				if ($fraud_info['ip_time_zone']) {
					$this->data['ip_time_zone'] = $fraud_info['ip_time_zone'];
				} else {
					$this->data['ip_time_zone'] = '';
				}

				if ($fraud_info['ip_region_name']) {
					$this->data['ip_region_name'] = $fraud_info['ip_region_name'];
				} else {
					$this->data['ip_region_name'] = '';
				}				
				
				if ($fraud_info['ip_domain']) {
					$this->data['ip_domain'] = $fraud_info['ip_domain'];
				} else {
					$this->data['ip_domain'] = '';
				}
				
				if ($fraud_info['ip_country_name']) {
					$this->data['ip_country_name'] = $fraud_info['ip_country_name'];
				} else {
					$this->data['ip_country_name'] = '';
				}	
								
				if ($fraud_info['ip_continent_code']) {
					$this->data['ip_continent_code'] = $fraud_info['ip_continent_code'];
				} else {
					$this->data['ip_continent_code'] = '';
				}
				
				if ($fraud_info['ip_corporate_proxy']) {
					$this->data['ip_corporate_proxy'] = $fraud_info['ip_corporate_proxy'];
				} else {
					$this->data['ip_corporate_proxy'] = '';
				}
								
				$this->data['anonymous_proxy'] = $fraud_info['anonymous_proxy'];
				$this->data['proxy_score'] = $fraud_info['proxy_score'];
				
				if ($fraud_info['is_trans_proxy']) {
					$this->data['is_trans_proxy'] = $fraud_info['is_trans_proxy'];
				} else {
					$this->data['is_trans_proxy'] = '';
				}	
							
				$this->data['free_mail'] = $fraud_info['free_mail'];
				$this->data['carder_email'] = $fraud_info['carder_email'];
				
				if ($fraud_info['high_risk_username']) {
					$this->data['high_risk_username'] = $fraud_info['high_risk_username'];
				} else {
					$this->data['high_risk_username'] = '';
				}
							
				if ($fraud_info['high_risk_password']) {
					$this->data['high_risk_password'] = $fraud_info['high_risk_password'];
				} else {
					$this->data['high_risk_password'] = '';
				}		
				
				$this->data['bin_match'] = $fraud_info['bin_match'];

				if ($fraud_info['bin_country']) {
					$this->data['bin_country'] = $fraud_info['bin_country'];
				} else {
					$this->data['bin_country'] = '';
				}	
								
				$this->data['bin_name_match'] = $fraud_info['bin_name_match'];
				
				if ($fraud_info['bin_name']) {
					$this->data['bin_name'] = $fraud_info['bin_name'];
				} else {
					$this->data['bin_name'] = '';
				}	
								
				$this->data['bin_phone_match'] = $fraud_info['bin_phone_match'];

				if ($fraud_info['bin_phone']) {
					$this->data['bin_phone'] = $fraud_info['bin_phone'];
				} else {
					$this->data['bin_phone'] = '';
				}	
				
				if ($fraud_info['customer_phone_in_billing_location']) {
					$this->data['customer_phone_in_billing_location'] = $fraud_info['customer_phone_in_billing_location'];
				} else {
					$this->data['customer_phone_in_billing_location'] = '';
				}	
												
				$this->data['ship_forward'] = $fraud_info['ship_forward'];

				if ($fraud_info['city_postal_match']) {
					$this->data['city_postal_match'] = $fraud_info['city_postal_match'];
				} else {
					$this->data['city_postal_match'] = '';
				}	
				
				if ($fraud_info['ship_city_postal_match']) {
					$this->data['ship_city_postal_match'] = $fraud_info['ship_city_postal_match'];
				} else {
					$this->data['ship_city_postal_match'] = '';
				}	
								
				$this->data['score'] = $fraud_info['score'];
				$this->data['explanation'] = $fraud_info['explanation'];
				$this->data['risk_score'] = $fraud_info['risk_score'];
				$this->data['queries_remaining'] = $fraud_info['queries_remaining'];
				$this->data['maxmind_id'] = $fraud_info['maxmind_id'];
				$this->data['error'] = $fraud_info['error'];
			} else {
				$this->data['maxmind_id'] = '';
			}
			
			// Load Template View
			$this->template = 'sale/order_info_master.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);
			$this->response->setOutput($this->render());
		} else {
			$this->language->load('error/not_found');
			$this->document->setTitle($this->language->get('heading_title'));			
			$this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['text_not_found'] = $this->language->get('text_not_found');			
			$this->data['breadcrumbs'] = array();
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);		
			$this->template = 'error/not_found.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);	
			$this->response->setOutput($this->render());
		}	
	}

	public function createInvoiceNo() {
		$this->language->load('sale/order');

		$json = array();
		
     	if (!$this->user->hasPermission('modify', 'sale/order')) {
      		$json['error'] = $this->language->get('error_permission'); 
		} elseif (isset($this->request->get['order_id'])) {
			$this->load->model('sale/order');
			
			$invoice_no = $this->model_sale_order->createInvoiceNo($this->request->get['order_id']);
			
			if ($invoice_no) {
				$json['invoice_no'] = $invoice_no;
			} else {
				$json['error'] = $this->language->get('error_action');
			}
		}

		$this->response->setOutput(json_encode($json));
  	}

	public function history() {
    	$this->language->load('sale/order');
		
		$this->data['error'] = '';
		$this->data['success'] = '';
		
		$this->load->model('sale/order');
	
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!$this->user->hasPermission('modify', 'sale/order')) { 
				$this->data['error'] = $this->language->get('error_permission');
			}
			
			if (!$this->data['error']) { 
				$this->model_sale_order->addOrderHistory($this->request->get['order_id'], $this->request->post);
				
				$this->data['success'] = $this->language->get('text_success');
			}
		}
				
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_notify'] = $this->language->get('column_notify');
		$this->data['column_comment'] = $this->language->get('column_comment');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  
		
		$this->data['histories'] = array();
			
		$results = $this->model_sale_order->getOrderHistories($this->request->get['order_id'], ($page - 1) * 10, 10);
      		
		foreach ($results as $result) {
        	$this->data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
        		'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
        	);
      	}			
		
		$history_total = $this->model_sale_order->getTotalOrderHistories($this->request->get['order_id']);
			
		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('sale/order/history', 'token=' . $this->session->data['token'] . '&order_id=' . $this->request->get['order_id'] . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'sale/order_history.tpl';		
		
		$this->response->setOutput($this->render());
  	}
			
  	public function invoice() {
		$this->language->load('sale/order');

		$this->data['title'] ;

		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = HTTPS_SERVER;
		} else {
			$this->data['base'] = HTTP_SERVER;
		}

		$this->data['direction'] = $this->language->get('direction');
		$this->data['language'] = $this->language->get('code');

		$this->data['text_invoice'] = $this->language->get('text_invoice');

		$this->data['text_order_id'] = $this->language->get('text_order_id');
		$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
		$this->data['text_invoice_date'] = $this->language->get('text_invoice_date');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_telephone'] = $this->language->get('text_telephone');
		$this->data['text_fax'] = $this->language->get('text_fax');
		$this->data['text_to'] = $this->language->get('text_to');
		$this->data['text_company_id'] = $this->language->get('text_company_id');
		$this->data['text_tax_id'] = $this->language->get('text_tax_id');		
		$this->data['text_ship_to'] = $this->language->get('text_ship_to');
		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');

		$this->data['column_product'] = $this->language->get('column_product');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_comment'] = $this->language->get('column_comment');

		$this->load->model('sale/order');

		$this->load->model('setting/setting');

		$this->data['orders'] = array();

		$orders = array();

		if (isset($this->request->post['selected'])) {
			$orders = $this->request->post['selected'];
		} elseif (isset($this->request->get['order_id'])) {
			$orders[] = $this->request->get['order_id'];
		}

		foreach ($orders as $order_id) {
			$order_info = $this->model_sale_order->getOrder($order_id);

			if ($order_info) {
				$store_info = $this->model_setting_setting->getSetting('config', $order_info['store_id']);
				
				if ($store_info) {
					$store_address = $store_info['config_address'];
					$store_email = $store_info['config_email'];
					$store_telephone = $store_info['config_telephone'];
					$store_fax = $store_info['config_fax'];
				} else {
					$store_address = $this->config->get('config_address');
					$store_email = $this->config->get('config_email');
					$store_telephone = $this->config->get('config_telephone');
					$store_fax = $this->config->get('config_fax');
				}
				
				if ($order_info['invoice_no']) {
					$invoice_no = $order_info['invoice_prefix'] . $order_info['invoice_no'];
				} else {
					$invoice_no = '';
				}
				
				if ($order_info['shipping_address_format']) {
					$format = $order_info['shipping_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['shipping_firstname'],
					'lastname'  => $order_info['shipping_lastname'],
					'company'   => $order_info['shipping_company'],
					'address_1' => $order_info['shipping_address_1'],
					'address_2' => $order_info['shipping_address_2'],
					'city'      => $order_info['shipping_city'],
					'postcode'  => $order_info['shipping_postcode'],
					'zone'      => $order_info['shipping_zone'],
					'zone_code' => $order_info['shipping_zone_code'],
					'country'   => $order_info['shipping_country']
				);

				$shipping_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				if ($order_info['payment_address_format']) {
					$format = $order_info['payment_address_format'];
				} else {
					$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
				}

				$find = array(
					'{firstname}',
					'{lastname}',
					'{company}',
					'{address_1}',
					'{address_2}',
					'{city}',
					'{postcode}',
					'{zone}',
					'{zone_code}',
					'{country}'
				);

				$replace = array(
					'firstname' => $order_info['payment_firstname'],
					'lastname'  => $order_info['payment_lastname'],
					'company'   => $order_info['payment_company'],
					'address_1' => $order_info['payment_address_1'],
					'address_2' => $order_info['payment_address_2'],
					'city'      => $order_info['payment_city'],
					'postcode'  => $order_info['payment_postcode'],
					'zone'      => $order_info['payment_zone'],
					'zone_code' => $order_info['payment_zone_code'],
					'country'   => $order_info['payment_country']
				);

				$payment_address = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

				$product_data = array();

				$products = $this->model_sale_order->getOrderProducts($order_id);

				foreach ($products as $product) {
					$option_data = array();

					$options = $this->model_sale_order->getOrderOptions($order_id, $product['order_product_id']);

					foreach ($options as $option) {
						if ($option['type'] != 'file') {
							$value = $option['value'];
						} else {
							$value = utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.'));
						}
						
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $value
						);								
					}

					$product_data[] = array(
						'name'     => $product['name'],
						'model'    => $product['model'],
						'option'   => $option_data,
						'quantity' => $product['quantity'],
						'price'    => $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $order_info['currency_code'], $order_info['currency_value']),
						'total'    => $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $order_info['currency_code'], $order_info['currency_value'])
					);
				}
				
				$voucher_data = array();
				
				$vouchers = $this->model_sale_order->getOrderVouchers($order_id);

				foreach ($vouchers as $voucher) {
					$voucher_data[] = array(
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $order_info['currency_code'], $order_info['currency_value'])			
					);
				}
					
				$total_data = $this->model_sale_order->getOrderTotals($order_id);

				$this->data['orders'][] = array(
					'order_id'	         => $order_id,
					'invoice_no'         => $invoice_no,
					'date_added'         => date($this->language->get('date_format_short'), strtotime($order_info['date_added'])),
					'store_name'         => $order_info['store_name'],
					'store_url'          => rtrim($order_info['store_url'], '/'),
					'store_address'      => nl2br($store_address),
					'store_email'        => $store_email,
					'store_telephone'    => $store_telephone,
					'store_fax'          => $store_fax,
					'email'              => $order_info['email'],
					'telephone'          => $order_info['telephone'],
					'shipping_address'   => $shipping_address,
					'shipping_method'    => $order_info['shipping_method'],
					'payment_address'    => $payment_address,
					'payment_company_id' => $order_info['payment_company_id'],
					'payment_tax_id'     => $order_info['payment_tax_id'],
					'payment_method'     => $order_info['payment_method'],
					'product'            => $product_data,
					'voucher'            => $voucher_data,
					'total'              => $total_data,
					'comment'            => nl2br($order_info['comment'])
				);
			}
		}

		$this->template = 'sale/order_invoice.tpl';

		$this->response->setOutput($this->render());
	}
}
?>
