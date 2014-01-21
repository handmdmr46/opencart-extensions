<?php
class ControllerAffiliateEbayidImport extends Controller {
	public function index() {
		$this->language->load('affiliate/csv_import');

		//breadcrumbs
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title_import_ebay'),
			'href'      => $this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		// language
		$this->document->setTitle($this->language->get('heading_title_ebayid_import'));
    	$this->data['heading_title_ebayid_import'] = $this->language->get('heading_title_ebayid_import');

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

		$this->load->model('affiliate/csv_import');

		$this->template = 'affiliate/ebayid_import.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());

	}

}// end class