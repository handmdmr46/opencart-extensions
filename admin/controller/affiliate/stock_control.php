<?php
class ControllerAffiliateStockControl extends Controller {
	public function index() {
		$this->language->load('affiliate/stock_control');
		$this->document->setTitle($this->language->get('heading_title_stock_control'));
		$this->load->model('affiliate/csv_import');
		// $this->load->model('affiliate/stock_control');
		
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
		$this->data['heading_title']       = $this->language->get('heading_title_stock_control');
		$this->data['button_ebay_call']    = $this->language->get('button_ebay_call');
		$this->data['button_load_profile'] = $this->language->get('button_load_profile');
		$this->data['button_edit_profile'] = $this->language->get('button_edit_profile');
		$this->data['button_cancel']       = $this->language->get('button_cancel');
		// $this->data['']                   = $this->language->get('');

		// Error
	    if (isset($this->session->data['error'])) {
	      $this->data['error'] = $this->session->data['error'];
	      unset($this->session->data['error']);
	    } else {
	      $this->data['error'] = '';
	    }

	    // Success
	    if (isset($this->session->data['success'])) {
	      $this->data['success'] = $this->session->data['success'];
	      unset($this->session->data['success']);
	    } else {
	      $this->data['success'] = '';
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
	    $this->data['import_ids'] = $this->url->link('affiliate/stock_control/ebayCall', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['load_profile'] = $this->url->link('affiliate/stock_control/loadProfile', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'] . $url, 'SSL');

		// Load Template for View
		$this->template = 'affiliate/stock_control.tpl';

	    $this->children = array(
	      'common/header',
	      'common/footer'
	    );

	    $this->response->setOutput($this->render());

	}


}
?>