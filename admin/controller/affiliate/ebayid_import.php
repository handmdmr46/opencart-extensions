<?php
class ControllerAffiliateEbayidImport extends Controller {
	public function index() {
		$this->language->load('affiliate/csv_import');
		$this->document->setTitle($this->language->get('heading_title_ebayid_import'));
		$this->load->model('affiliate/csv_import');
		$this->document->addScript('view/javascript/event_scheduler/codebase/dhtmlxscheduler.js');
    	$this->document->addScript('view/javascript/event_scheduler/codebase/ext/dhtmlxscheduler_year_view.js');
    	$this->document->addStyle('view/javascript/event_scheduler/codebase/dhtmlxscheduler.css');

		$this->getForm();
	}

	protected function getForm() {
	    // Breadcrumbs
	    $this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
       		'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
       		'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title_ebayid_import'),
       		'href'      => $this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'], 'SSL'),
       		'separator' => ' :: '
		);

	   	// Language
		$this->data['heading_title']                    = $this->language->get('heading_title_ebayid_import');
		$this->data['button_import']                    = $this->language->get('button_import');
		$this->data['button_cancel']                    = $this->language->get('button_cancel');
		$this->data['button_clear_dates']               = $this->language->get('button_clear_dates');
		$this->data['button_reload']                    = $this->language->get('button_reload');
		$this->data['button_clear_products']            = $this->language->get('button_clear_products');
		$this->data['button_edit_linked_products']      = $this->language->get('button_edit_linked_products');
		$this->data['button_edit_unlinked_products']    = $this->language->get('button_edit_unlinked_products');
		$this->data['button_activate_linked_products']  = $this->language->get('button_activate_linked_products');
		$this->data['button_set_ebay_profile']          = $this->language->get('button_set_ebay_profile');
		$this->data['text_ebay_start_from']             = $this->language->get('text_ebay_start_from');
		$this->data['text_ebay_start_from_help']        = $this->language->get('text_ebay_start_from_help');
		$this->data['text_ebay_start_to']               = $this->language->get('text_ebay_start_to');
		$this->data['text_ebay_start_to_help']          = $this->language->get('text_ebay_start_to_help');
		$this->data['text_no_dates']                    = $this->language->get('text_no_dates');
		$this->data['text_user_token']                  = $this->language->get('text_user_token');
		$this->data['text_developer_id']                = $this->language->get('text_developer_id');
		$this->data['text_application_id']              = $this->language->get('text_application_id');
		$this->data['text_certification_id']            = $this->language->get('text_certification_id');
		$this->data['text_compat_level']                = $this->language->get('text_compat_level');
		$this->data['text_none']                        = $this->language->get('text_none');
		$this->data['text_compat_help']                 = $this->language->get('text_compat_help');
		$this->data['text_confirm_clear_dates']         = $this->language->get('text_confirm_clear_dates');
		$this->data['text_site_id']                     = $this->language->get('text_site_id');
		$this->data['text_start_dates']                 = $this->language->get('text_start_dates');
		$this->data['text_start_dates_help']            = $this->language->get('text_start_dates_help');
		$this->data['text_product_links']               = $this->language->get('text_product_links');
		$this->data['text_linked_products']             = $this->language->get('text_linked_products');
		$this->data['text_unlinked_products']           = $this->language->get('text_unlinked_products');
		$this->data['text_product_title']               = $this->language->get('text_product_title');
		$this->data['text_product_id']                  = $this->language->get('text_product_id');
		$this->data['text_ebay_item_id']                = $this->language->get('text_ebay_item_id');
		$this->data['text_linked_product_pagination']   = $this->language->get('text_linked_product_pagination');
		$this->data['text_unlinked_product_pagination'] = $this->language->get('text_unlinked_product_pagination');
		$this->data['text_select'] 						= $this->language->get('text_select');

	    // Error
	    if (isset($this->session->data['error'])) {
	      $this->data['error'] = $this->session->data['error'];
	      unset($this->session->data['error']);
	    } else {
	      $this->data['error'] = '';
	    }

	    if (isset($this->session->data['error_start_date'])) {
	      $this->data['error_start_date'] = $this->session->data['error_start_date'];
	      unset($this->session->data['error_start_date']);
	    } else {
	      $this->data['error_start_date'] = '';
	    }

	    if (isset($this->session->data['error_end_date'])) {
	      $this->data['error_end_date'] = $this->session->data['error_end_date'];
	      unset($this->session->data['error_end_date']);
	    } else {
	      $this->data['error_end_date'] = '';
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

	    if (isset($this->session->data['error_compatability_level'])) {
	      $this->data['error_compatability_level'] = $this->session->data['error_compatability_level'];
	      unset($this->session->data['error_compatability_level']);
	    } else {
	      $this->data['error_compatability_level'] = '';
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
	    $this->data['import_ids'] = $this->url->link('affiliate/ebayid_import/importIds', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['clear_dates'] = $this->url->link('affiliate/ebayid_import/clearDates', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['reload'] = $this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['edit_linked_products'] = $this->url->link('affiliate/ebayid_import/editLinkedProducts', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['edit_unlinked_products'] = $this->url->link('affiliate/ebayid_import/editUnlinkedProducts', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['clear_products'] = $this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['activate_linked_products'] = $this->url->link('affiliate/ebayid_import/activatProductLinks', 'token=' . $this->session->data['token'] . $url, 'SSL');
	    $this->data['set_ebay_profile'] = $this->url->link('affiliate/ebayid_import/setEbayProfile', 'token=' . $this->session->data['token'] . $url, 'SSL');

	    $profiles                        = $this->model_affiliate_csv_import->getEbayProfile();
	    $this->data['ebay_sites']        = $this->model_affiliate_csv_import->getEbaySiteIds();
	    $this->data['compat_levels']     = $this->model_affiliate_csv_import->getEbayCompatibilityLevels();
	    $this->data['dates']             = $this->model_affiliate_csv_import->getEbayImportStartDates();
	    // Profiles
	    if (!empty($profiles)) {
	      $this->data['developer_id'] = $profiles['developer_id'];
	    } else {
	      $this->data['developer_id'] = '';
	    }

	    if (!empty($profiles)) {
	      $this->data['application_id'] = $profiles['application_id'];
	    } else {
	      $this->data['application_id'] = '';
	    }

	    if (!empty($profiles)) {
	      $this->data['certification_id'] = $profiles['certification_id'];
	    } else {
	      $this->data['certification_id'] = '';
	    }

	    if (!empty($profiles)) {
	      $this->data['user_token'] = $profiles['user_token'];
	    } else {
	      $this->data['user_token'] = '';
	    }

	    if (!empty($profiles)) {
	      $this->data['site_id'] = $profiles['site_id'];
	    } else {
	      $this->data['site_id'] = '';
	    }

	    if(!empty($profiles)) {
	      $this->data['compat'] = $profiles['compat'];
	    } else {
	      $this->data['compat'] = '';
	    }

	    $this->template = 'affiliate/ebayid_import.tpl';

	    $this->children = array(
	      'common/header',
	      'common/footer'
	    );

	    $this->response->setOutput($this->render());
	}

    public  function importIds() {
	    $this->language->load('affiliate/csv_import');
		$this->document->setTitle($this->language->get('heading_title_ebayid_import'));
		$this->load->model('affiliate/csv_import');

	    if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validateEbayIdImport() == 1) {

	      $this->model_affiliate_csv_import->setEbayImportStartDates($this->request->post);

	      $call_name = 'GetSellerList';

	      $ebay_call = new Ebaycall($this->request->post['developer_id'], $this->request->post['application_id'], $this->request->post['certification_id'], $this->request->post['compatability_level'], $this->request->post['site_id'], $call_name);

	      $xml  = '<?xml version="1.0" encoding="utf-8"?>';
	      $xml .= '<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
	      $xml .= '<RequesterCredentials>';
	      $xml .= '<eBayAuthToken>' . $this->request->post['user_token'] . '</eBayAuthToken>';
	      $xml .= '</RequesterCredentials>';
	      $xml .= '<Pagination ComplexType="PaginationType">';
	      $xml .= '<EntriesPerPage>200</EntriesPerPage>';
	      $xml .= '<PageNumber>1</PageNumber>';
	      $xml .= '</Pagination>';
	      $xml .= '<GranularityLevel>Coarse</GranularityLevel>';
	      $xml .= '<StartTimeFrom>' . $this->request->post['start_date'] . 'T01:35:27.000Z</StartTimeFrom>';
	      $xml .= '<StartTimeTo>' . $this->request->post['end_date'] . 'T01:35:27.000Z</StartTimeTo>';
	      $xml .= '<WarningLevel>Low</WarningLevel>';
	      $xml .= '<OutputSelector>PaginationResult</OutputSelector>';
	      $xml .= '<OutputSelector>ItemArray.Item.Title</OutputSelector>';
	      $xml .= '<OutputSelector>ItemArray.Item.ItemID</OutputSelector>';
	      $xml .= '</GetSellerListRequest>';

	      $xml_response = $ebay_call->sendHttpRequest($xml);

	      if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
	        $this->session->data['error'] = $this->language->get('error_ebay_call');
	        $url = '';
	        if (isset($this->request->get['page'])) {
	          $url .= '&page=' . $this->request->get['page'];
	        }
	        $this->redirect($this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	      }

	      $doc_response = new DomDocument();

	      $doc_response->loadXML($xml_response);

	      $message = $doc_response->getElementsByTagName('Ack');
	      

	      if($message->item(0)->nodeValue == 'Failure') {
	      	$severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
	      	$error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
	      	$short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
	      	$long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;
	        $this->session->data['error'] = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;
	        $url = '';
	        if (isset($this->request->get['page'])) {
	          $url .= '&page=' . $this->request->get['page'];
	        }
	        $this->redirect($this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	      }

	      $titles = $doc_response->getElementsByTagName('Title');
	      $item_ids = $doc_response->getElementsByTagName('ItemID');
	      $number_pages = $doc_response->getElementsByTagName('TotalNumberOfPages');
	      $number_entries = $doc_response->getElementsByTagName('TotalNumberOfEntries');
	      $import_data = array();

	      foreach ($titles as $title) {
	        $import_data['title'][] = $title->nodeValue;
	      }

	      foreach ($item_ids as $item_id) {
	        $import_data['id'][] = $item_id->nodeValue;
	      }

	      $page_count = intval($number_pages->item(0)->nodeValue);
	      $total_entries = intval($number_entries->item(0)->nodeValue);

	      if($page_count > 1) {
	        for($i = 2; $i <= $page_count; $i++) {
	          $ebay_call = new Ebaycall($this->request->post['developer_id'], $this->request->post['application_id'], $this->request->post['certification_id'], $this->request->post['compatability_level'], $this->request->post['site_id'], $call_name);

	          $xml  = '<?xml version="1.0" encoding="utf-8"?>';
	          $xml .= '<GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
	          $xml .= '<RequesterCredentials>';
	          $xml .= '<eBayAuthToken>' . $this->request->post['user_token'] . '</eBayAuthToken>';
	          $xml .= '</RequesterCredentials>';
	          $xml .= '<Pagination ComplexType="PaginationType">';
	          $xml .= '<EntriesPerPage>200</EntriesPerPage>';
	          $xml .= '<PageNumber>' . $i . '</PageNumber>';
	          $xml .= '</Pagination>';
	          $xml .= '<GranularityLevel>Coarse</GranularityLevel>';
	          $xml .= '<StartTimeFrom>' . $this->request->post['start_date'] . 'T01:35:27.000Z</StartTimeFrom>';
	          $xml .= '<StartTimeTo>' . $this->request->post['end_date'] . 'T01:35:27.000Z</StartTimeTo>';
	          $xml .= '<WarningLevel>Low</WarningLevel>';
	          $xml .= '<OutputSelector>PaginationResult</OutputSelector>';
	          $xml .= '<OutputSelector>ItemArray.Item.Title</OutputSelector>';
	          $xml .= '<OutputSelector>ItemArray.Item.ItemID</OutputSelector>';
	          $xml .= '</GetSellerListRequest>';

	          $xml_response = $ebay_call->sendHttpRequest($xml);

	          if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
	            $this->session->data['error'] = $this->language->get('error_ebay_call');
	            $url = '';
	            if (isset($this->request->get['page'])) {
	              $url .= '&page=' . $this->request->get['page'];
	            }
	            $this->redirect($this->url->link('', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	          }

	          foreach ($titles as $title) {
	            $import_data['title'][] = $title->nodeValue;
	          }

	          foreach ($item_ids as $item_id) {
	            $import_data['id'][] = $item_id->nodeValue;
	          }
	        }
	      }

	      $match      = 0;
	      $ebay_id    = array();
	      $product_id = array();
	      $unlinked   = $this->model_affiliate_csv_import->getCsvImportProducts();

	      foreach($unlinked as $product){
	        foreach(array_combine($import_data['id'], $import_data['title']) as $item_id => $ebay_title) {
	          if ($product['title'] === $ebay_title) {
	            $ebay_id[]    = $item_id;
	            $product_id[] = $product['product_id'];
	            $match++;
	          }
	        }
	      }
	      $data = array_combine($product_id,$ebay_id); //array_combine($keys,$values)
	      $this->model_affiliate_csv_import->addEbayListingProductLink($data);
	      $this->session->data['success'] = $this->language->get('success_import');
	      $this->redirect($this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'], 'SSL'));
	      $this->response->setOutput(json_encode($json));
	    }
	    $this->getForm();
    }

    public function setEbayProfile() {
	    $this->language->load('affiliate/csv_import');
		$this->document->setTitle($this->language->get('heading_title_ebayid_import'));
		$this->load->model('affiliate/stock_control');

	    if ($this->validateSaveEbayProfile() == 1) {	        	        	        
	        $this->model_affiliate_stock_control->setEbayProfile($this->request->post);
    		$this->session->data['success'] = $this->language->get('success_profile');
    		$this->redirect($this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'], 'SSL'));
	    } 
	    $this->redirect($this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'], 'SSL'));    	
    }

    protected function validateSaveEbayProfile() {
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

    protected function validateEbayIdImport() {
    	$boolean = 1;

	    if ((utf8_strlen($this->request->post['start_date']) < 1) || (utf8_strlen($this->request->post['start_date']) > 10)) {
	        $this->session->data['error_start_date'] = $this->language->get('error_start_date');
	        $this->session->data['error'] = $this->language->get('error');
	        $true = 0;
	    }

	    if ((utf8_strlen($this->request->post['end_date']) < 1) || (utf8_strlen($this->request->post['end_date']) > 10)) {
	        $this->session->data['error_end_date'] = $this->language->get('error_end_date');
	        $this->session->data['error'] = $this->language->get('error');
	        $true = 0;
	    }

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

    public  function clearDates() {
	    $this->language->load('affiliate/csv_import');
		$this->document->setTitle($this->language->get('heading_title_ebayid_import'));
		$this->load->model('affiliate/csv_import');

	    $this->model_affiliate_csv_import->deleteEbayImportStartDates();

	    $this->session->data['success'] = $this->language->get('success_clear_dates');

	    $this->redirect($this->url->link('affiliate/ebayid_import', 'token=' . $this->session->data['token'], 'SSL'));
    }

}// end class

