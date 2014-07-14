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

	    if (isset($this->session->data['reviseInventoryStatus'])) {
	    	$this->data['reviseInventoryStatus'] = $this->session->data['reviseInventoryStatus'];
	      	unset($this->session->data['reviseInventoryStatus']);
	    } else {
	      $this->data['reviseInventoryStatus'] = '';
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
	    $this->data['new_quantity'] = '';

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

		if($this->request->post['ebay_call_name'] == 'getOrders' && $this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateEbayProfile() == 1) {
			$this->session->data['getOrders'] = $this->model_affiliate_stock_control->getOrdersRequest();
		    $this->session->data['success'] = $this->language->get('success_get_orders');			
    		$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if($this->request->post['ebay_call_name'] == 'getItemQuantity' && $this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateEbayProfile() == 1) {
			$this->session->data['getItemQuantity'] = $this->model_affiliate_stock_control->getEbayItemQuantity($this->request->post['item_id']);
			$this->session->data['success'] = $this->language->get('success_get_item');		
    		$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));

		}

		if($this->request->post['ebay_call_name'] == 'endFixedPriceItem' && $this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateEbayProfile() == 1) {
			$this->endItem($this->request->post['item_id']);		
    		$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
		}

		if($this->request->post['ebay_call_name'] == 'reviseInventoryStatus' && $this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateEbayProfile() == 1) {
			$this->session->data['reviseInventoryStatus'] = $this->model_affiliate_stock_control->reviseEbayItemQuantity($this->request->post['item_id'], $this->request->post['new_quantity']);
			$this->session->data['success'] = $this->language->get('success_revise_item');
    		$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->session->data['error'] = $this->language->get('error');
    	$this->redirect($this->url->link('affiliate/stock_control', 'token=' . $this->session->data['token'], 'SSL'));
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