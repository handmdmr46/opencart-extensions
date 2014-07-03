<?php
class ControllerAffiliateStockControl extends Controller {
	public function index() {
		$this->language->load('affiliate/stock_control');
		$this->document->setTitle($this->language->get('heading_title_stock_control'));
		$this->load->model('affiliate/stock_control');
		
		// addScript and addStyle examples
		/*
		$this->document->addScript('view/javascript/event_scheduler/codebase/dhtmlxscheduler.js');
    	$this->document->addScript('view/javascript/event_scheduler/codebase/ext/dhtmlxscheduler_year_view.js');
    	$this->document->addStyle('view/javascript/event_scheduler/codebase/dhtmlxscheduler.css');
    	*/

		$this->init();
	}

	protected function init() {
		// Breadcrumbs
	    $this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title_stock_control'),
       		'href'      => $this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'),
       		'separator' => ' :: '
		);

		// Language
		$this->data['heading_title']              = $this->language->get('heading_title_stock_control');
		$this->data['heading_title_ebay_profile'] = $this->language->get('heading_title_ebay_profile');
		$this->data['heading_title_ebay_call']    = $this->language->get('heading_title_ebay_call');
		$this->data['button_ebay_call']           = $this->language->get('button_ebay_call');
		$this->data['button_set_ebay_profile']    = $this->language->get('button_set_ebay_profile');
		$this->data['button_cancel']              = $this->language->get('button_cancel');
		$this->data['text_ebay_user_token']       = $this->language->get('text_ebay_user_token');
		$this->data['text_developer_id']          = $this->language->get('text_developer_id');
		$this->data['text_application_id']        = $this->language->get('text_application_id');
		$this->data['text_certification_id']      = $this->language->get('text_certification_id');
		$this->data['text_compat_level']          = $this->language->get('text_compat_level');
		$this->data['text_compat_help']           = $this->language->get('text_compat_help');
		$this->data['text_site_id']               = $this->language->get('text_site_id');
		$this->data['text_none']                  = $this->language->get('text_none');
		$this->data['text_select']                = $this->language->get('text_select');
		$this->data['text_ebay_call_name']        = $this->language->get('text_ebay_call_name');
		$this->data['text_item_id']               = $this->language->get('text_item_id');

		// Error Handler
	    if (isset($this->session->data['error'])) {
	      $this->data['error'] = $this->session->data['error'];
	      unset($this->session->data['error']);
	    } else {
	      $this->data['error'] = '';
	    }

	    if (isset($this->session->data['error_user_token'])) {
	      $this->data['error_user_token'] = $this->session->data['error_user_token'];
	      unset($this->session->data['error_user_token']);
	    } else {
	      $this->data['error_user_token'] = '';
	    }

	    if (isset($this->session->data['error_developer_id'])) {
	      $this->data['error_developer_id'] = $this->session->data['error_developer_id'];
	      unset($this->session->data['error_developer_id']);
	    } else {
	      $this->data['error_developer_id'] = '';
	    }

	    if (isset($this->session->data['error_application_id'])) {
	      $this->data['error_application_id'] = $this->session->data['error_application_id'];
	      unset($this->session->data['error_application_id']);
	    } else {
	      $this->data['error_application_id'] = '';
	    }

	    if (isset($this->session->data['error_certification_id'])) {
	      $this->data['error_certification_id'] = $this->session->data['error_certification_id'];
	      unset($this->session->data['error_certification_id']);
	    } else {
	      $this->data['error_certification_id'] = '';
	    }

	    if (isset($this->session->data['error_site_id'])) {
	      $this->data['error_site_id'] = $this->session->data['error_site_id'];
	      unset($this->session->data['error_site_id']);
	    } else {
	      $this->data['error_site_id'] = '';
	    }

	    if (isset($this->session->data['error_ebay_call_name'])) {
	      $this->data['error_ebay_call_name'] = $this->session->data['error_ebay_call_name'];
	      unset($this->session->data['error_ebay_call_name']);
	    } else {
	      $this->data['error_ebay_call_name'] = '';
	    }

	    if (isset($this->session->data['error_compatability_level'])) {
	      $this->data['error_compatability_level'] = $this->session->data['error_compatability_level'];
	      unset($this->session->data['error_compatability_level']);
	    } else {
	      $this->data['error_compatability_level'] = '';
	    }

	    // Success Handler
	    if (isset($this->session->data['success'])) {
	      $this->data['success'] = $this->session->data['success'];
	      unset($this->session->data['success']);
	    } else {
	      $this->data['success'] = '';
	    }

	    // Session Variables
	    if (isset($this->session->data['getOrders'])) {
	    	$this->data['getOrders'] = $this->session->data['getOrders'];
	      	unset($this->session->data['getOrders']);
	    } else {
	      $this->data['getOrders'] = '';
	    }

	    if (isset($this->session->data['getItem'])) {
	    	$this->data['getItem'] = $this->session->data['getItem'];
	      	unset($this->session->data['getItem']);
	    } else {
	      $this->data['getItem'] = '';
	    }

	    if (isset($this->session->data['getItemTitle'])) {
	    	$this->data['getItemTitle'] = $this->session->data['getItemTitle'];
	      	unset($this->session->data['getItemTitle']);
	    } else {
	      $this->data['getItemTitle'] = '';
	    }

	    if (isset($this->session->data['getItemId'])) {
	    	$this->data['getItemId'] = $this->session->data['getItemId'];
	      	unset($this->session->data['getItemId']);
	    } else {
	      $this->data['getItemId'] = '';
	    }

	    if (isset($this->session->data['getItemQuantity'])) {
	    	$this->data['getItemQuantity'] = $this->session->data['getItemQuantity'];
	      	unset($this->session->data['getItemQuantity']);
	    } else {
	      $this->data['getItemQuantity'] = '';
	    }

	    // Page, Start & Limit -- pagination --
	    if (isset($this->request->get['page'])) {
	      $page = $this->request->get['page'];
	      $this->data['page'] = $this->request->get['page'];
	    } else {
	      $page = 1;
	      $this->data['page'] = 1;
	    }

	    $url = '';

	    if (isset($this->request->get['page'])) {
	      $url .= '&page=' . $this->request->get['page'];
	    }

	    $limit = 100;
	    $start = ($page - 1) * $limit;

		// Buttons
	    $this->data['ebay_call'] = $this->url->link('affiliate/stock_control/ebayCall', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['set_ebay_profile'] = $this->url->link('affiliate/stock_control/setEbayProfile', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'] . $url, 'SSL');

	    // Database
	    $profiles                        = $this->model_affiliate_stock_control->getEbayProfile();
	    $this->data['ebay_sites']        = $this->model_affiliate_stock_control->getEbaySiteIds();
	    $this->data['compat_levels']     = $this->model_affiliate_stock_control->getEbayCompatibilityLevels();
	    $this->data['ebay_call_names']   = $this->model_affiliate_stock_control->getEbayCallNames();

	    // Ebay Profile Variables 
	    if(!empty($profiles)) {
	      $this->data['user_token'] = $profiles['user_token'];
	    } else {
	      $this->data['user_token'] = '';
	    }

	    if(!empty($profiles)) {
	      $this->data['developer_id'] = $profiles['developer_id'];
	    } else {
	      $this->data['developer_id'] = '';
	    }

	    if(!empty($profiles)) {
	      $this->data['application_id'] = $profiles['application_id'];
	    } else {
	      $this->data['application_id'] = '';
	    }

	    if(!empty($profiles)) {
	      $this->data['certification_id'] = $profiles['certification_id'];
	    } else {
	      $this->data['certification_id'] = '';
	    }

	    if(!empty($profiles)) {
	      $this->data['site_id'] = $profiles['site_id'];
	    } else {
	      $this->data['site_id'] = '';
	    }

	    if(!empty($profiles)) {
	      $this->data['compat'] = $profiles['compat'];
	    } else {
	      $this->data['compat'] = '';
	    }

	    $this->data['item_id'] = '';

		// Load Template View
		$this->template = 'affiliate/stock_control.tpl';

	    $this->children = array(
	      'common/header',
	      'common/footer'
	    );

	    $this->response->setOutput($this->render());
	}

	public function ebayCall() {
		$this->language->load('affiliate/stock_control');
		$this->document->setTitle($this->language->get('heading_title_stock_control'));
		$this->load->model('affiliate/stock_control');
		if($this->validateEbayCall() != 1) {
			$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if($this->request->post['ebay_call_name'] == 'getOrders') {
			$this->getOrders();				
    		$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if($this->request->post['ebay_call_name'] == 'getItem') {
			$this->getItem($this->request->post['item_id']);			
    		$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));

		}

		if($this->request->post['ebay_call_name'] == 'endFixedPriceItem') {
			$this->endItem($this->request->post['item_id']);		
    		$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if($this->request->post['ebay_call_name'] == 'reviseInventoryStatus') {
			$this->session->data['success'] = $this->language->get('success_revise_item');
    		$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->session->data['error'] = $this->language->get('error');
    	$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
	}

	public function endItem($item_id) {
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateEbayProfile() == 1) {

			$call_name = 'endFixedPriceItem';
			$ebay_call = new Ebaycall($this->request->post['developer_id'], $this->request->post['application_id'], $this->request->post['certification_id'], $this->request->post['compatability_level'], $this->request->post['site_id'], $call_name);

			$xml = '<?xml version="1.0" encoding="utf-8"?>';			
			$xml .= '<EndFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
  			$xml .= '<ItemID>' . $item_id . '</ItemID>';
  			$xml .= '<EndingReason EnumType="EndReasonCodeType">NotAvailable</EndingReason>';
  			$xml .= '<RequesterCredentials><eBayAuthToken>' . $this->request->post['user_token'] . '</eBayAuthToken></RequesterCredentials>';    		  			
			$xml .= '</EndFixedPriceItemRequest>';

			$xml_response = $ebay_call->sendHttpRequest($xml);

	        if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
		        $this->session->data['error'] = $this->language->get('error_ebay_api_call');
		        $url = '';
		        if (isset($this->request->get['page'])) {
		          $url .= '&page=' . $this->request->get['page'];
		        }
		        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	        }

	        $doc_response = new DomDocument();
	        $doc_response->loadXML($xml_response);
	        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;
	        $severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
	        $error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
	        $short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
	        $long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;

	        if($message == 'Failure') {
		        $this->session->data['error'] = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;
		        $url = '';
		        if (isset($this->request->get['page'])) {
		          $url .= '&page=' . $this->request->get['page'];
		        }
		        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	        }

	        if($message->item(0)->nodeValue == 'Success') {
		        $this->session->data['success'] = $this->language->get('success_end_item');
		        $url = '';
		        if (isset($this->request->get['page'])) {
		          $url .= '&page=' . $this->request->get['page'];
		        }
		        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	        }

		}
	}

	public function setItemQuantity($quantity, $item_id) {
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateEbayProfile() == 1) {
			$call_name = 'reviseInventoryStatus';
			$ebay_call = new Ebaycall($this->request->post['developer_id'], $this->request->post['application_id'], $this->request->post['certification_id'], $this->request->post['compatability_level'], $this->request->post['site_id'], $call_name);

			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			$xml .= '<ReviseInventoryStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$xml .= '<WarningLevel>Low</WarningLevel>';
  			$xml .= '<InventoryStatus>';
    		$xml .= '<ItemID>' . $item_id . '</ItemID>';
    		$xml .= '<Quantity>' . $quantity . '</Quantity>';
  			$xml .= '</InventoryStatus>';
			$xml .= '</ReviseInventoryStatusRequest>';

			$xml_response = $ebay_call->sendHttpRequest($xml);

	        if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
		        $this->session->data['error'] = $this->language->get('error_ebay_api_call');
		        $url = '';
		        if (isset($this->request->get['page'])) {
		          $url .= '&page=' . $this->request->get['page'];
		        }
		        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	        }

	        $doc_response = new DomDocument();
	        $doc_response->loadXML($xml_response);
	        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;
	        $severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
	        $error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
	        $short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
	        $long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;

	        if($message == 'Failure') {
		        $this->session->data['error'] = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;
		        $url = '';
		        if (isset($this->request->get['page'])) {
		          $url .= '&page=' . $this->request->get['page'];
		        }
		        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	        }

	        
		}
	}

	public function getItem($item_id) {
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateEbayProfile() == 1) {
			$call_name = 'getItem';
			$ebay_call = new Ebaycall($this->request->post['developer_id'], $this->request->post['application_id'], $this->request->post['certification_id'], $this->request->post['compatability_level'], $this->request->post['site_id'], $call_name);
			
			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			$xml .= '<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$xml .= '<RequesterCredentials>';
			$xml .= '<eBayAuthToken>' . $this->request->post['user_token'] . '</eBayAuthToken>';
			$xml .= '</RequesterCredentials>';
			$xml .= '<ItemID>' . $item_id . '</ItemID>';
			$xml .= '<WarningLevel>Low</WarningLevel>';
            $xml .= '<OutputSelector>Title</OutputSelector>';
            $xml .= '<OutputSelector>ItemID</OutputSelector>';
            $xml .= '<OutputSelector>Quantity</OutputSelector>';
	        $xml .= '</GetItemRequest>';

	        $xml_response = $ebay_call->sendHttpRequest($xml);

	        if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
		        $this->session->data['error'] = $this->language->get('error_ebay_api_call');
		        $url = '';
		        if (isset($this->request->get['page'])) {
		          $url .= '&page=' . $this->request->get['page'];
		        }
		        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	        }

	        $doc_response = new DomDocument();
	        $doc_response->loadXML($xml_response);
	        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;
	        $severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
	        $error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
	        $short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
	        $long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;

	        if($message == 'Failure') {
		        $this->session->data['error'] = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;
		        $url = '';
		        if (isset($this->request->get['page'])) {
		          $url .= '&page=' . $this->request->get['page'];
		        }
		        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	        }

	        
	        $title = $doc_response->getElementsByTagName('Title')->item(0)->nodeValue;
	        $item_id = $doc_response->getElementsByTagName('ItemID')->item(0)->nodeValue;
	        $quantity = $doc_response->getElementsByTagName('Quantity')->item(0)->nodeValue;	
	        $this->session->data['getItem'] = array($title, $item_id, $quantity);

	        $this->session->data['getItemTitle'] = $title;
	        $this->session->data['getItemId'] = $item_id;
	        $this->session->data['getItemQuantity'] = $quantity;
	        $this->session->data['success'] = $this->language->get('success_get_item');
		}
	}

	public function getOrders() {
		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateEbayProfile() == 1) {
			$call_name = 'getOrders';
			$ebay_call = new Ebaycall($this->request->post['developer_id'], $this->request->post['application_id'], $this->request->post['certification_id'], $this->request->post['compatability_level'], $this->request->post['site_id'], $call_name);
			
			$xml = '<?xml version="1.0" encoding="utf-8"?>';
			$xml .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
			$xml .= '<RequesterCredentials>';
			$xml .= '<eBayAuthToken>' . $this->request->post['user_token'] . '</eBayAuthToken>';
			$xml .= '</RequesterCredentials>';
			$xml .= '<Pagination ComplexType="PaginationType">';
		    $xml .= '<EntriesPerPage>50</EntriesPerPage>';
			$xml .= '<PageNumber>1</PageNumber>';
			$xml .= '</Pagination>';			
			$xml .= '<WarningLevel>Low</WarningLevel>';
			$xml .= '<OutputSelector>PaginationResult</OutputSelector>';
			$xml .= '<OutputSelector>OrderArray.Order.OrderID</OutputSelector>';
			$xml .= '<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Item.ItemID</OutputSelector>';
			$xml .= '<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Item.Title</OutputSelector>';
			$xml .= '<OutputSelector>OrderArray.Order.TransactionArray.Transaction.QuantityPurchased</OutputSelector>';
			$xml .= '<CreateTimeFrom>2014-06-10T01:00:00.000Z</CreateTimeFrom>';
			$xml .= '<CreateTimeTo>2014-06-10T24:00:00.000Z</CreateTimeTo>';
			$xml .= '<OrderRole>Seller</OrderRole>';
			$xml .= '<OrderStatus>Completed</OrderStatus>';
			$xml .= '</GetOrdersRequest>';

			$xml_response = $ebay_call->sendHttpRequest($xml);

			if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
		        $this->session->data['error'] = $this->language->get('error_ebay_api_call');
		        $url = '';
		        if (isset($this->request->get['page'])) {
		          $url .= '&page=' . $this->request->get['page'];
		        }
		        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	        }

	        $doc_response = new DomDocument();
	        $doc_response->loadXML($xml_response);
	        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;
	        $severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
	        $error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
	        $short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
	        $long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;

	        if($message == 'Failure') {
		        $this->session->data['error'] = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;
		        $url = '';
		        if (isset($this->request->get['page'])) {
		          $url .= '&page=' . $this->request->get['page'];
		        }
		        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	        }

	        $titles = $doc_response->getElementsByTagName('Title');
	        $item_ids = $doc_response->getElementsByTagName('ItemID');
	        $qty_purchased = $doc_response->getElementsByTagName('QuantityPurchased');
	        $total_pages = $doc_response->getElementsByTagName('TotalNumberOfPages');
	        $page_count = intval($total_pages->item(0)->nodeValue);	        
	        $import_data = array();

	        foreach ($titles as $title) {
	          $import_data['title'][] = $title->nodeValue;
	        }

	        foreach ($item_ids as $item_id) {
	          $import_data['id'][] = $item_id->nodeValue;
	        }

	        foreach ($qty_purchased as $qty) {
	        	$import_data['qty_purchased'][] = $qty->nodeValue;
	        }

	        if($page_count > 1) {
	        	for($i = 2; $i <= $page_count; $i++) {
	        		$ebay_call = new Ebaycall($this->request->post['developer_id'], $this->request->post['application_id'], $this->request->post['certification_id'], $this->request->post['compatability_level'], $this->request->post['site_id'], $call_name);
	        		
	        		$xml = '<?xml version="1.0" encoding="utf-8"?>';
					$xml .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
					$xml .= '<RequesterCredentials>';
					$xml .= '<eBayAuthToken>' . $this->request->post['user_token'] . '</eBayAuthToken>';
					$xml .= '</RequesterCredentials>';
					$xml .= '<Pagination ComplexType="PaginationType">';
				    $xml .= '<EntriesPerPage>50</EntriesPerPage>';
					$xml .= '<PageNumber>' . $i . '</PageNumber>';
					$xml .= '</Pagination>';
					$xml .= '<DetailLevel>ReturnAll</DetailLevel>';
					$xml .= '<WarningLevel>Low</WarningLevel>';
					$xml .= '<OutputSelector>PaginationResult</OutputSelector>';
					$xml .= '<OutputSelector>OrderArray.Order.OrderID</OutputSelector>';
					$xml .= '<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Item.ItemID</OutputSelector>';
					$xml .= '<OutputSelector>OrderArray.Order.TransactionArray.Transaction.Item.Title</OutputSelector>';
					$xml .= '<OutputSelector>OrderArray.Order.TransactionArray.Transaction.QuantityPurchased</OutputSelector>';
					$xml .= '<CreateTimeFrom>2014-06-10T01:00:00.000Z</CreateTimeFrom>';
					$xml .= '<CreateTimeTo>2014-06-10T24:00:00.000Z</CreateTimeTo>';
					$xml .= '<OrderRole>Seller</OrderRole>';
					$xml .= '<OrderStatus>Completed</OrderStatus>';
					$xml .= '</GetOrdersRequest>';

					$xml_response = $ebay_call->sendHttpRequest($xml);

					if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
				        $this->session->data['error'] = $this->language->get('error_ebay_api_call');
				        $url = '';
				        if (isset($this->request->get['page'])) {
				          $url .= '&page=' . $this->request->get['page'];
				        }
				        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			        }

			        $doc_response = new DomDocument();
			        $doc_response->loadXML($xml_response);
			        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;
	        		$severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
	        		$error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
	        		$short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
	        		$long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;

	        		if($message == 'Failure') {
				        $this->session->data['error'] = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;
				        $url = '';
				        if (isset($this->request->get['page'])) {
				          $url .= '&page=' . $this->request->get['page'];
				        }
				        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			        }

			        foreach ($titles as $title) {
	             		$import_data['title'][] = $title->nodeValue;
	        		}

			        foreach ($item_ids as $item_id) {
			          	$import_data['id'][] = $item_id->nodeValue;
			        }

			        foreach ($quantity_purchased as $quantity) {
			        	$import_data['quantity_purchased'][] = $quantity->nodeValue;
			        }				        		        
			    }
		    }
		    
		    $this->session->data['getOrders'] = $import_data;	
		    $this->session->data['success'] = $this->language->get('success_get_orders');		    		    
		}
	}

    public function setEbayProfile() {
	    $this->language->load('affiliate/stock_control');
		$this->document->setTitle($this->language->get('heading_title_stock_control'));
		$this->load->model('affiliate/stock_control');

	    if ($this->validateEbayProfile() != 1) {
	        $this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
	    }

    	$this->model_affiliate_stock_control->setEbayProfile($this->request->post);
    	$this->session->data['success'] = $this->language->get('success_profile');
    	$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
    }

    protected function validateEbayProfile() {
	    $boolean = 1;

	    if ((utf8_strlen($this->request->post['user_token']) < 1) || (utf8_strlen($this->request->post['user_token']) > 872)) {
	        $this->session->data['error_user_token'] = $this->language->get('error_user_token');
	        $this->session->data['error'] = $this->language->get('error');
	        $boolean = 0;
	    }

	    if ((utf8_strlen($this->request->post['developer_id']) < 1) || (utf8_strlen($this->request->post['developer_id']) > 36)) {
	        $this->session->data['error_developer_id'] = $this->language->get('error_developer_id');
	        $this->session->data['error'] = $this->language->get('error');
	        $boolean = 0;
	    }

	    if ((utf8_strlen($this->request->post['certification_id']) < 1) || (utf8_strlen($this->request->post['certification_id']) > 36)) {
	        $this->session->data['error_certification_id'] = $this->language->get('error_certification_id');
	        $this->session->data['error'] = $this->language->get('error');
	        $boolean = 0;
	    }

	    if ((utf8_strlen($this->request->post['application_id']) < 1) || (utf8_strlen($this->request->post['application_id']) > 36)) {
	        $this->session->data['error_application_id'] = $this->language->get('error_application_id');
	        $this->session->data['error'] = $this->language->get('error');
	        $boolean = 0;
	    }

	    if($this->request->post['site_id'] == 999) {
	    	$this->session->data['error_site_id'] = $this->language->get('error_site_id');
	        $this->session->data['error'] = $this->language->get('error');
	        $boolean = 0;
	    }

	    if($this->request->post['compatability_level'] == 999) {
	    	$this->session->data['error_compatability_level'] = $this->language->get('error_compatability_level');
	        $this->session->data['error'] = $this->language->get('error');
	        $boolean = 0;
	    }

	    return $boolean;
    }

    protected function validateEbayCall() {
    	$boolean = 1;

    	if($this->request->post['ebay_call_name'] == 999) {
	    	$this->session->data['error_ebay_call_name'] = $this->language->get('error_ebay_call_name');
	        $this->session->data['error'] = $this->language->get('error');
	        $boolean = 0;
	    }

	    return $boolean;
    }


}
?>