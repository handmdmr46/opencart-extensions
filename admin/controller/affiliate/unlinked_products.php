<?php
class ControllerAffiliateUnlinkedProducts extends Controller {
	public function index() {
		$this->language->load('affiliate/stock_control');
		$this->document->setTitle($this->language->get('heading_title_unlinked_products'));
		$this->load->model('affiliate/stock_control');
		
		// $this->document->addScript('view/javascript/event_scheduler/codebase/dhtmlxscheduler.js');
  //   	$this->document->addScript('view/javascript/event_scheduler/codebase/ext/dhtmlxscheduler_year_view.js');
  //   	$this->document->addStyle('view/javascript/event_scheduler/codebase/dhtmlxscheduler.css');

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
       		'text'      => $this->language->get('heading_title_unlinked_products'),
       		'href'      => $this->url->link('affiliate/unlinked_products', 'token=' . $this->session->data['token'], 'SSL'),
       		'separator' => ' :: '
		);

		//Language
		$this->data['heading_title']       = $this->language->get('heading_title_unlinked_products');
		$this->data['button_edit']         = $this->language->get('button_edit');
		$this->data['button_cancel']       = $this->language->get('button_cancel');
		$this->data['button_link_product'] = $this->language->get('button_link_product');
		$this->data['text_ebay_item_id']   = $this->language->get('text_ebay_item_id');
		$this->data['text_product_id']     = $this->language->get('text_product_id');
		$this->data['text_product_title']  = $this->language->get('text_product_title');


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

	    $limit = 50;
	    $start = ($page - 1) * $limit;

	    // Buttons
	    $this->data['link_product'] = $this->url->link('affiliate/unlinked_products/linkProduct', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'] . $url, 'SSL');

	    // Variables	    
		$total                           = $this->model_affiliate_stock_control->getTotalUnlinkedProducts();
		$this->data['unlinked_products'] = $this->model_affiliate_stock_control->getUnlinkedProducts($start, $limit);

	    // Pagination
	    $pagination        = new Pagination();
	    $pagination->total = $total;
	    $pagination->page  = $page;
	    $pagination->limit = $limit;
	    $pagination->text  = $this->language->get('text_pagination');
	    $pagination->url   = $this->url->link('affiliate/unlinked_products', 'token=' . $this->session->data['token']  . '&page={page}' , 'SSL');

	    $this->data['pagination'] = $pagination->render();

	    $this->template = 'affiliate/unlinked_products.tpl';

	    $this->children = array(
	      'common/header',
	      'common/footer'
	    );

	    $this->response->setOutput($this->render());
	}

	public function linkProduct() {
			$this->language->load('affiliate/stock_control');
			$this->document->setTitle($this->language->get('heading_title_unlinked_products'));
			$this->load->model('affiliate/stock_control');

			$url = '';

			if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->post['selected']) /*&& $this->validateLinkProduct() == 1*/) {
				foreach ($this->request->post['selected'] as $product_id) {
					$ebay_item_id_str = $product_id . '_ebay_item_id';
					$ebay_item_id = $this->request->post[$ebay_item_id_str];
					$this->model_affiliate_stock_control->setProductLink($product_id, $ebay_item_id);
				}

				$this->session->data['success'] = $this->language->get('success_link_product');
				$this->redirect($this->url->link('affiliate/unlinked_products', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			}

			$this->session->data['error'] = $this->language->get('error_edit');
			$this->redirect($this->url->link('affiliate/unlinked_products', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}

	/*protected function validateLinkProduct() {
		$boolean = 1;

		foreach($this->request->post['selected'] as $pid) {	
			
				if ((utf8_strlen($pid . '_ebay_item_id') < 1) || (utf8_strlen($pid . '_ebay_item_id') > 12)) {
					$this->session->data['error'] = 'testing `validateLinkProduct()';
					$boolean = 0;
				}
			
			
		}
		return $boolean;
	}*/



}// end class