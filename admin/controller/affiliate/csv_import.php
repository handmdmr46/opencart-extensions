<?php
class ControllerAffiliateCsvImport extends Controller {
	public function index() {
		$this->language->load('affiliate/csv_import');
		$this->document->setTitle($this->language->get('heading_title_csv_import'));
		$this->load->model('affiliate/csv_import');
		// $this->document->addStyle('view/stylesheet/tooltip.css');

		$this->import();
	}

	protected function import() {
		// Breadcrumbs
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title_csv_import'),
			'href'      => $this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		// Language
		$this->data['heading_title_csv_import'] = $this->language->get('heading_title_csv_import');
		$this->data['text_choose_file']         = $this->language->get('text_choose_file');
		$this->data['text_skip_image']          = $this->language->get('text_skip_image');
		$this->data['text_skip_image_help']     = $this->language->get('text_skip_image_help');
		$this->data['button_import']            = $this->language->get('button_import');
		$this->data['button_cancel']            = $this->language->get('button_cancel');
		$this->data['text_file_type']           = $this->language->get('text_file_type');
		$this->data['text_file_type_help']      = $this->language->get('text_file_type_help');
		$this->data['text_file_exchange']       = $this->language->get('text_file_exchange');
		$this->data['text_turbo_lister']        = $this->language->get('text_turbo_lister');
		$this->data['text_title']               = $this->language->get('text_title');
		$this->data['text_description']         = $this->language->get('text_description');
		$this->data['text_quantity']            = $this->language->get('text_quantity');
		$this->data['text_price']               = $this->language->get('text_price');
		$this->data['text_length']              = $this->language->get('text_length');
		$this->data['text_width']               = $this->language->get('text_width');
		$this->data['text_height']              = $this->language->get('text_height');
		$this->data['text_manufacturer']        = $this->language->get('text_manufacturer');
		$this->data['text_category']            = $this->language->get('text_category');
		$this->data['text_shipping_dom']        = $this->language->get('text_shipping_dom');
		$this->data['text_shipping_intl']       = $this->language->get('text_shipping_intl');
		$this->data['text_model']               = $this->language->get('text_model');
		$this->data['text_gallery_image']       = $this->language->get('text_gallery_image');
		$this->data['text_image']               = $this->language->get('text_image');
		$this->data['text_count']               = $this->language->get('text_count');
		$this->data['text_model']               = $this->language->get('text_model');
		$this->data['text_weight']              = $this->language->get('text_weight');
		$this->data['button_delete']            = $this->language->get('button_delete');
		$this->data['button_edit_list']         = $this->language->get('button_edit_list');
		$this->data['button_clear']             = $this->language->get('button_clear');
		$this->data['text_confirm']             = $this->language->get('text_confirm');
		$this->data['text_confirm_edit']        = $this->language->get('text_confirm_edit');
		$this->data['entry_select']             = $this->language->get('entry_select');
		$this->data['text_search_image']        = $this->language->get('text_search_image');
		$this->data['text_search_image_help']   = $this->language->get('text_search_image_help');		

		// used for js filter() in approval.tpl
		$this->data['token'] = $this->session->data['token'];

		// Error
		if (isset($this->session->data['error_file'])) {
			$this->data['error_warning'] = $this->session->data['error_file'];
			unset($this->session->data['error_file']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['error_validation'])) {
			$this->data['error_warning'] = $this->session->data['error_validation'];
			unset($this->session->data['error_validation']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['error_delete'])) {
			$this->data['error_warning'] = $this->session->data['error_delete'];
			unset($this->session->data['error_edit']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['error_edit'])) {
			$this->data['error_warning'] = $this->session->data['error_edit'];
			unset($this->session->data['error_edit']);
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

		if (isset($this->session->data['success_delete'])) {
    		$this->data['success'] = $this->session->data['success_delete'];
			unset($this->session->data['success_delete']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['success_edit'])) {
    		$this->data['success'] = $this->session->data['success_edit'];
			unset($this->session->data['success_edit']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['success_clear'])) {
    		$this->data['success'] = $this->session->data['success_clear'];
			unset($this->session->data['success_clear']);
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

		$limit = $this->config->get('config_admin_limit');
		$start = ($page - 1) * $limit;

        $this->data['import'] = $this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('affiliate/csv_import/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['edit'] = $this->url->link('affiliate/csv_import/edit', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['clear'] = $this->url->link('affiliate/csv_import/clear', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['loading'] = '';
		$this->data['csv'] = array();
		$this->data['csv_view'] = array();
		$csv_mimetypes = array(
			'text/csv',
			'text/plain',
			'application/csv',
			'text/comma-separated-values',
			'application/excel',
			'application/vnd.ms-excel',
			'application/vnd.msexcel',
			'text/anytext',
			'application/octet-stream',
			'application/txt',
       );

	   $this->data['manufacturers'] = $this->model_affiliate_csv_import->getManufacturers();
	   $this->data['domestic_shipping'] = $this->model_affiliate_csv_import->getDomesticShippingMethods();
	   $this->data['international_shipping'] = $this->model_affiliate_csv_import->getInternationalShippingMethods();

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
				  if (is_uploaded_file($this->request->files['csv']['tmp_name']) && in_array($this->request->files['csv']['type'], $csv_mimetypes)) {
					  $content = $this->request->files['csv']['tmp_name'];
				  } else {
					  $content = false;
					  $this->session->data['error_file'] = $this->language->get('error_file_type');
				      $this->redirect($this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
				  }

				  if ($this->validImport($content)) {

					  $csv = new Parsecsv();

					  $csv->auto($content);

					  foreach($csv->csvdata as $key => $row) {
							$this->data['csv'][] = array(
								'title'              => $csv->csvdata[$key]['Title'],
								'description'        => $csv->csvdata[$key]['Description'],
								'quantity'           => $csv->csvdata[$key]['Quantity'],
								'price'              => $csv->csvdata[$key]['StartPrice'],
								'item_id'            => $csv->csvdata[$key]['ItemID'],
								'image'              => $csv->csvdata[$key]['PicURL'],
								'weight'             => $csv->csvdata[$key]['WeightMinor'] / 16 + $csv->csvdata[$key]['WeightMajor'],
								'unit'               => $csv->csvdata[$key]['MeasurementUnit'],
								'length'             => $csv->csvdata[$key]['PackageLength'],
								'width'              => $csv->csvdata[$key]['PackageWidth'],
								'height'             => $csv->csvdata[$key]['PackageDepth'],
								'shipping_dom'       => $csv->csvdata[$key]['ShippingService-1:Option'],
								'shipping_intl'      => $csv->csvdata[$key]['IntlShippingService-1:Option'],
								'is_paypal'          => $csv->csvdata[$key]['PayPalAccepted'],
								'paypal_email'       => $csv->csvdata[$key]['PayPalEmailAddress'],
								'shipping_name_dom'  => '',
								'shipping_name_intl' => '',
								'manufacturer_id'    => '',
								'manufacturer_name'  => '',
								'category_id'        => '',
								'category_name'      => '',
								'gallery_images'     => '',
								'model'              => $csv->csvdata[$key]['CustomLabel']
							);
					  }

					  foreach($this->data['csv'] as $key => $row) {
						  // Get featured image
						  // $this->data['csv'][$key]['image'] = substr(parse_url($this->data['csv'][$key]['image'], PHP_URL_PATH), 1);
					  	$this->data['csv'][$key]['image'] = parse_url($this->data['csv'][$key]['image'], PHP_URL_PATH);

						  // Set Manufacturer ID from Title
						  if (stripos($this->data['csv'][$key]['title'],'honda') !== false) {
							  $this->data['csv'][$key]['manufacturer_id'] = 1;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'kawasaki') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 2;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'suzuki') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 3;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'yamaha') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 4;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'harley') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 7;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'indian') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 7;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'buell') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 7;
						  } elseif (preg_match('/^.*\b(a{1}t{1}k{1})\b.*$/i', $this->data['csv'][$key]['title'])){ // ATK
							  $this->data['csv'][$key]['manufacturer_id'] = 7;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'ducati') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'benelli') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } elseif (preg_match('/^.*\b(b{1}s{1}a{1})\b.*$/i', $this->data['csv'][$key]['title'])){ // BSA
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'triumph') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'norton') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'aermacchi') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'aprilia') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'ariel') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } elseif (stripos($this->data['csv'][$key]['title'], 'maico') !== false){
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } elseif (preg_match('/^.*\b(a{1}j{1}s{1})\b.*$/i', $this->data['csv'][$key]['title'])){ // AJS
							  $this->data['csv'][$key]['manufacturer_id'] = 8;
						  } else {
							  $this->data['csv'][$key]['manufacturer_id'] = 7;
						  }

						  // Set Category ID from Title and Manufacturer ID
						  if ($this->data['csv'][$key]['manufacturer_id'] == 1) {#Honda
							  strpos($this->data['csv'][$key]['title'], 'CB1000')  ? $this->data['csv'][$key]['category_id'] = 123 : '';
							  strpos($this->data['csv'][$key]['title'], 'CB125') ? $this->data['csv'][$key]['category_id'] = 112 : '';
							  strpos($this->data['csv'][$key]['title'], 'CB200') ? $this->data['csv'][$key]['category_id'] = 113 : '';
							  strpos($this->data['csv'][$key]['title'], 'CB300') ? $this->data['csv'][$key]['category_id'] = 117 : '';
							  strpos($this->data['csv'][$key]['title'], 'CB450') ? $this->data['csv'][$key]['category_id'] = 118 : '';
							  strpos($this->data['csv'][$key]['title'], 'CB550') ? $this->data['csv'][$key]['category_id'] = 119 : '';
							  strpos($this->data['csv'][$key]['title'], 'CB650') ? $this->data['csv'][$key]['category_id'] = 120 : '';
							  strpos($this->data['csv'][$key]['title'], 'CB750') ? $this->data['csv'][$key]['category_id'] = 121 : '';
							  strpos($this->data['csv'][$key]['title'], 'CB900') ? $this->data['csv'][$key]['category_id'] = 122 : '';
							  strpos($this->data['csv'][$key]['title'], 'CL175') ? $this->data['csv'][$key]['category_id'] = 114 : '';
							  strpos($this->data['csv'][$key]['title'], 'CR125') ? $this->data['csv'][$key]['category_id'] = 130 : '';
							  strpos($this->data['csv'][$key]['title'], 'CR250') ? $this->data['csv'][$key]['category_id'] = 131 : '';
							  strpos($this->data['csv'][$key]['title'], 'CR500') ? $this->data['csv'][$key]['category_id'] = 132 : '';
							  strpos($this->data['csv'][$key]['title'], 'CR80') ? $this->data['csv'][$key]['category_id'] = 129 : '';
							  strpos($this->data['csv'][$key]['title'], 'CX500') ? $this->data['csv'][$key]['category_id'] = 124 : '';
							  strpos($this->data['csv'][$key]['title'], 'GL1000') ? $this->data['csv'][$key]['category_id'] = 127 : '';
							  strpos($this->data['csv'][$key]['title'], 'GL1100') ? $this->data['csv'][$key]['category_id'] = 128 : '';
							  strpos($this->data['csv'][$key]['title'], 'GL1200') ? $this->data['csv'][$key]['category_id'] = 140 : '';
							  strpos($this->data['csv'][$key]['title'], 'GL1500') ? $this->data['csv'][$key]['category_id'] = 141 : '';
							  strpos($this->data['csv'][$key]['title'], 'GL500') ? $this->data['csv'][$key]['category_id'] = 125 : '';
							  strpos($this->data['csv'][$key]['title'], 'GL650') ? $this->data['csv'][$key]['category_id'] = 126 : '';
							  strpos($this->data['csv'][$key]['title'], 'ST1100') ? $this->data['csv'][$key]['category_id'] = 133 : '';
							  strpos($this->data['csv'][$key]['title'], 'ST1300') ? $this->data['csv'][$key]['category_id'] = 134 : '';
							  strpos($this->data['csv'][$key]['title'], 'XL125') ? $this->data['csv'][$key]['category_id'] = 115 : '';
							  strpos($this->data['csv'][$key]['title'], 'XL175') ? $this->data['csv'][$key]['category_id'] = 135 : '';
							  strpos($this->data['csv'][$key]['title'], 'XL185') ? $this->data['csv'][$key]['category_id'] = 116 : '';
							  strpos($this->data['csv'][$key]['title'], 'XL250') ? $this->data['csv'][$key]['category_id'] = 142 : '';
							  strpos($this->data['csv'][$key]['title'], 'XL500') ? $this->data['csv'][$key]['category_id'] = 139 : '';
							  strpos($this->data['csv'][$key]['title'], 'XR200') ? $this->data['csv'][$key]['category_id'] = 136 : '';
							  strpos($this->data['csv'][$key]['title'], 'XR250') ? $this->data['csv'][$key]['category_id'] = 137 : '';
							  strpos($this->data['csv'][$key]['title'], 'XR500') ? $this->data['csv'][$key]['category_id'] = 138 : '';
							  strpos($this->data['csv'][$key]['title'], 'VT1100') ? $this->data['csv'][$key]['category_id'] = 9999 : '';
							  #CL350, VT1100, NT650, CBR600, CBR600F1, VF750, VF750S
						  }
						  if($this->data['csv'][$key]['manufacturer_id'] == 2) {#Kawasaki
							  strpos($this->data['csv'][$key]['title'], 'G5') ? $this->data['csv'][$key]['category_id'] = 169 : '';
							  strpos($this->data['csv'][$key]['title'], 'KDX420') ? $this->data['csv'][$key]['category_id'] = 149 : '';
							  strpos($this->data['csv'][$key]['title'], 'KE175') ? $this->data['csv'][$key]['category_id'] = 171 : '';
							  strpos($this->data['csv'][$key]['title'], 'KE250') ? $this->data['csv'][$key]['category_id'] = 173 : '';
							  strpos($this->data['csv'][$key]['title'], 'KH250') ? $this->data['csv'][$key]['category_id'] = 167 : '';
							  strpos($this->data['csv'][$key]['title'], 'KH400') ? $this->data['csv'][$key]['category_id'] = 166 : '';
							  strpos($this->data['csv'][$key]['title'], 'KH500') ? $this->data['csv'][$key]['category_id'] = 168 : '';
							  strpos($this->data['csv'][$key]['title'], 'KLR') ? $this->data['csv'][$key]['category_id'] = 170 : '';
							  strpos($this->data['csv'][$key]['title'], 'KLX250') ? $this->data['csv'][$key]['category_id'] = 147 : '';
							  strpos($this->data['csv'][$key]['title'], 'KLX300') ? $this->data['csv'][$key]['category_id'] = 148 : '';
							  strpos($this->data['csv'][$key]['title'], 'KM100') ? $this->data['csv'][$key]['category_id'] = 172 : '';
							  strpos($this->data['csv'][$key]['title'], 'KX125') ? $this->data['csv'][$key]['category_id'] = 143 : '';
							  strpos($this->data['csv'][$key]['title'], 'KX250') ? $this->data['csv'][$key]['category_id'] = 145 : '';
							  strpos($this->data['csv'][$key]['title'], 'KX500') ? $this->data['csv'][$key]['category_id'] = 146 : '';
							  strpos($this->data['csv'][$key]['title'], 'KX80') ? $this->data['csv'][$key]['category_id'] = 144 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ1000') ? $this->data['csv'][$key]['category_id'] = 157 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ1100') ? $this->data['csv'][$key]['category_id'] = 158 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ1300') ? $this->data['csv'][$key]['category_id'] = 159 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ200') ? $this->data['csv'][$key]['category_id'] = 150 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ400') ? $this->data['csv'][$key]['category_id'] = 151 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ440') ? $this->data['csv'][$key]['category_id'] = 152 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ550') ? $this->data['csv'][$key]['category_id'] = 153 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ650') ? $this->data['csv'][$key]['category_id'] = 154 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ750') ? $this->data['csv'][$key]['category_id'] = 155 : '';
							  strpos($this->data['csv'][$key]['title'], 'KZ900') ? $this->data['csv'][$key]['category_id'] = 156 : '';
							  strpos($this->data['csv'][$key]['title'], 'VN1500') ? $this->data['csv'][$key]['category_id'] = 164 : '';
							  strpos($this->data['csv'][$key]['title'], 'VN2000') ? $this->data['csv'][$key]['category_id'] = 165 : '';
							  strpos($this->data['csv'][$key]['title'], 'VN700') ? $this->data['csv'][$key]['category_id'] = 160 : '';
							  strpos($this->data['csv'][$key]['title'], 'VN750') ? $this->data['csv'][$key]['category_id'] = 161 : '';
							  strpos($this->data['csv'][$key]['title'], 'VN800') ? $this->data['csv'][$key]['category_id'] = 162 : '';
							  strpos($this->data['csv'][$key]['title'], 'VN900') ? $this->data['csv'][$key]['category_id'] = 163 : '';
							  #EX250, F7
						  }
						  if($this->data['csv'][$key]['manufacturer_id'] == 3) {#Suzuki
							  strpos($this->data['csv'][$key]['title'], 'GN400') ? $this->data['csv'][$key]['category_id'] = 190 : '';
							  strpos($this->data['csv'][$key]['title'], 'GS1000') ? $this->data['csv'][$key]['category_id'] = 183 : '';
							  strpos($this->data['csv'][$key]['title'], 'GS300') ? $this->data['csv'][$key]['category_id'] = 192 : '';
							  strpos($this->data['csv'][$key]['title'], 'GS400') ? $this->data['csv'][$key]['category_id'] = 176 : '';
							  strpos($this->data['csv'][$key]['title'], 'GS450') ? $this->data['csv'][$key]['category_id'] = 177 : '';
							  strpos($this->data['csv'][$key]['title'], 'GS500') ? $this->data['csv'][$key]['category_id'] = 178 : '';
							  strpos($this->data['csv'][$key]['title'], 'GS550') ? $this->data['csv'][$key]['category_id'] = 179 : '';
							  strpos($this->data['csv'][$key]['title'], 'GS650') ? $this->data['csv'][$key]['category_id'] = 180 : '';
							  strpos($this->data['csv'][$key]['title'], 'GS750') ? $this->data['csv'][$key]['category_id'] = 181 : '';
							  strpos($this->data['csv'][$key]['title'], 'GS850') ? $this->data['csv'][$key]['category_id'] = 182 : '';
							  strpos($this->data['csv'][$key]['title'], 'GT380') ? $this->data['csv'][$key]['category_id'] = 185 : '';
							  strpos($this->data['csv'][$key]['title'], 'GT550') ? $this->data['csv'][$key]['category_id'] = 186 : '';
							  strpos($this->data['csv'][$key]['title'], 'GT750') ? $this->data['csv'][$key]['category_id'] = 187 : '';
							  strpos($this->data['csv'][$key]['title'], 'PE175') ? $this->data['csv'][$key]['category_id'] = 175 : '';
							  strpos($this->data['csv'][$key]['title'], 'PE250') ? $this->data['csv'][$key]['category_id'] = 189 : '';
							  strpos($this->data['csv'][$key]['title'], 'RM125') ? $this->data['csv'][$key]['category_id'] = 188 : '';
							  strpos($this->data['csv'][$key]['title'], 'RM250') ? $this->data['csv'][$key]['category_id'] = 189 : '';
							  strpos($this->data['csv'][$key]['title'], 'RM400') ? $this->data['csv'][$key]['category_id'] = 191 : '';
							  strpos($this->data['csv'][$key]['title'], 'RV125') ? $this->data['csv'][$key]['category_id'] = 199 : '';
							  strpos($this->data['csv'][$key]['title'], 'RV90') ? $this->data['csv'][$key]['category_id'] = 200 : '';
							  strpos($this->data['csv'][$key]['title'], 'T250') ? $this->data['csv'][$key]['category_id'] = 194 : '';
							  strpos($this->data['csv'][$key]['title'], 'T350') ? $this->data['csv'][$key]['category_id'] = 195 : '';
							  strpos($this->data['csv'][$key]['title'], 'T500') ? $this->data['csv'][$key]['category_id'] = 193 : '';
							  strpos($this->data['csv'][$key]['title'], 'TS125') ? $this->data['csv'][$key]['category_id'] = 196 : '';
							  strpos($this->data['csv'][$key]['title'], 'TS185') ? $this->data['csv'][$key]['category_id'] = 197 : '';
							  strpos($this->data['csv'][$key]['title'], 'TS250') ? $this->data['csv'][$key]['category_id'] = 198 : '';
							  # RM500, RM80
						  }
						  if($this->data['csv'][$key]['manufacturer_id'] == 4) {#Yamaha
							  strpos($this->data['csv'][$key]['title'], 'AT1') ? $this->data['csv'][$key]['category_id'] = 208 : '';
							  strpos($this->data['csv'][$key]['title'], 'CT1') ? $this->data['csv'][$key]['category_id'] = 209 : '';
							  strpos($this->data['csv'][$key]['title'], 'DT250') ? $this->data['csv'][$key]['category_id'] = 205 : '';
							  strpos($this->data['csv'][$key]['title'], 'FJ1200') ? $this->data['csv'][$key]['category_id'] = 224 : '';
							  strpos($this->data['csv'][$key]['title'], 'FZR600') ? $this->data['csv'][$key]['category_id'] = 225 : '';
							  strpos($this->data['csv'][$key]['title'], 'IT400') ? $this->data['csv'][$key]['category_id'] = 204 : '';
							  strpos($this->data['csv'][$key]['title'], 'MX250') ? $this->data['csv'][$key]['category_id'] = 207 : '';
							  strpos($this->data['csv'][$key]['title'], 'RT360') ? $this->data['csv'][$key]['category_id'] = 206 : '';
							  strpos($this->data['csv'][$key]['title'], 'SR500') ? $this->data['csv'][$key]['category_id'] = 213 : '';
							  strpos($this->data['csv'][$key]['title'], 'SRX') ? $this->data['csv'][$key]['category_id'] = 228 : '';
							  strpos($this->data['csv'][$key]['title'], 'TT500') ? $this->data['csv'][$key]['category_id'] = 211 : '';
							  strpos($this->data['csv'][$key]['title'], 'VMX1200') ? $this->data['csv'][$key]['category_id'] = 220 : '';
							  strpos($this->data['csv'][$key]['title'], 'XJ600') ? $this->data['csv'][$key]['category_id'] = 223 : '';
							  strpos($this->data['csv'][$key]['title'], 'XJ650') ? $this->data['csv'][$key]['category_id'] = 222 : '';
							  strpos($this->data['csv'][$key]['title'], 'XJ750') ? $this->data['csv'][$key]['category_id'] = 221 : '';
							  strpos($this->data['csv'][$key]['title'], 'XS1100') ? $this->data['csv'][$key]['category_id'] = 219 : '';
							  strpos($this->data['csv'][$key]['title'], 'XS360') ? $this->data['csv'][$key]['category_id'] = 214 : '';
							  strpos($this->data['csv'][$key]['title'], 'XS400') ? $this->data['csv'][$key]['category_id'] = 215 : '';
							  strpos($this->data['csv'][$key]['title'], 'XS500') ? $this->data['csv'][$key]['category_id'] = 216 : '';
							  strpos($this->data['csv'][$key]['title'], 'XS650') ? $this->data['csv'][$key]['category_id'] = 217 : '';
							  strpos($this->data['csv'][$key]['title'], 'XS750') ? $this->data['csv'][$key]['category_id'] = 218 : '';
							  strpos($this->data['csv'][$key]['title'], 'XT500') ? $this->data['csv'][$key]['category_id'] = 212 : '';
							  strpos($this->data['csv'][$key]['title'], 'XT550') ? $this->data['csv'][$key]['category_id'] = 230 : '';
							  strpos($this->data['csv'][$key]['title'], 'XT600') ? $this->data['csv'][$key]['category_id'] = 222 : '';
							  strpos($this->data['csv'][$key]['title'], 'YSR') ? $this->data['csv'][$key]['category_id'] = 210 : '';
							  strpos($this->data['csv'][$key]['title'], 'YZ125') ? $this->data['csv'][$key]['category_id'] = 202 : '';
							  strpos($this->data['csv'][$key]['title'], 'YZ250') ? $this->data['csv'][$key]['category_id'] = 203 : '';
							  strpos($this->data['csv'][$key]['title'], 'YZ80') ? $this->data['csv'][$key]['category_id'] = 201 : '';
							  strpos($this->data['csv'][$key]['title'], 'YZF1000') ? $this->data['csv'][$key]['category_id'] = 229 : '';
							  strpos($this->data['csv'][$key]['title'], 'YZF600') ? $this->data['csv'][$key]['category_id'] = 226 : '';
							  # YZ500
						  }
						  if($this->data['csv'][$key]['manufacturer_id'] == 8) {#British & European
							  strpos($this->data['csv'][$key]['title'], '900SS') ? $this->data['csv'][$key]['category_id'] = 244 : '';
							  strpos($this->data['csv'][$key]['title'], 'A65') ? $this->data['csv'][$key]['category_id'] = 242 : '';
							  stripos($this->data['csv'][$key]['title'], 'alpina') ? $this->data['csv'][$key]['category_id'] = 256 : '';
							  stripos($this->data['csv'][$key]['title'], 'ambassador') ? $this->data['csv'][$key]['category_id'] = 253 : '';
							  stripos($this->data['csv'][$key]['title'], 'blizzard') ? $this->data['csv'][$key]['category_id'] = 258 : '';
							  stripos($this->data['csv'][$key]['title'], 'bonneville') ? $this->data['csv'][$key]['category_id'] = 251 : '';
							  strpos($this->data['csv'][$key]['title'], 'C15') ? $this->data['csv'][$key]['category_id'] = 243 : '';
							  stripos($this->data['csv'][$key]['title'], 'california') ? $this->data['csv'][$key]['category_id'] = 254 : '';
							  stripos($this->data['csv'][$key]['title'], 'eldorado') ? $this->data['csv'][$key]['category_id'] = 252 : '';
							  preg_match('/^.*\b(e{1}x{1}c{1})\b.*$/i', $this->data['csv'][$key]['title']) ? $this->data['csv'][$key]['category_id'] = 245 : '';
							  strpos($this->data['csv'][$key]['title'], 'K100') ? $this->data['csv'][$key]['category_id'] = 237 : '';
							  strpos($this->data['csv'][$key]['title'], 'K75') ? $this->data['csv'][$key]['category_id'] = 236 : '';
							  stripos($this->data['csv'][$key]['title'], 'matador') ? $this->data['csv'][$key]['category_id'] = 255 : '';
							  preg_match('/^.*\b(m{1}x{1}c{1})\b.*$/i', $this->data['csv'][$key]['title']) ? $this->data['csv'][$key]['category_id'] = 246 : '';
							  stripos($this->data['csv'][$key]['title'], 'pursang') ? $this->data['csv'][$key]['category_id'] = 257 : '';
							  strpos($this->data['csv'][$key]['title'], 'R100') ? $this->data['csv'][$key]['category_id'] = 235 : '';
							  strpos($this->data['csv'][$key]['title'], 'R1100') ? $this->data['csv'][$key]['category_id'] = 239 : '';
							  strpos($this->data['csv'][$key]['title'], 'R1150') ? $this->data['csv'][$key]['category_id'] = 240 : '';
							  strpos($this->data['csv'][$key]['title'], 'R1200') ? $this->data['csv'][$key]['category_id'] = 241 : '';
							  strpos($this->data['csv'][$key]['title'], 'R75') ? $this->data['csv'][$key]['category_id'] = 232 : '';
							  strpos($this->data['csv'][$key]['title'], 'R80') ? $this->data['csv'][$key]['category_id'] = 233 : '';
							  strpos($this->data['csv'][$key]['title'], 'R90') ? $this->data['csv'][$key]['category_id'] = 234 : '';
							  strpos($this->data['csv'][$key]['title'], 'RSV1000') ? $this->data['csv'][$key]['category_id'] = 231 : '';
							  stripos($this->data['csv'][$key]['title'], 'speed triple') ? $this->data['csv'][$key]['category_id'] = 247 : '';
							  stripos($this->data['csv'][$key]['title'], 'speedtriple') ? $this->data['csv'][$key]['category_id'] = 247 : '';
							  strpos($this->data['csv'][$key]['title'], 'T110') ? $this->data['csv'][$key]['category_id'] = 248 : '';
							  strpos($this->data['csv'][$key]['title'], 'T120') ? $this->data['csv'][$key]['category_id'] = 249 : '';
							  strpos($this->data['csv'][$key]['title'], 'T140') ? $this->data['csv'][$key]['category_id'] = 250 : '';
							  #750 850 Commando
						  }
						  // if($this->data['csv'][$key]['manufacturer_id'] == 7) {}

						  /*
						  // Get gallery images from description
						  $data = array();
						
						  preg_match_all('/(https?).*?(jpg|png|gif)/i', $this->data['csv'][$key]['description'], $media);
						  foreach($media[0] as $img) {
							  if ($isFirst) {
							   $isFirst = false;
							   continue;
							 }
						     $img = substr( parse_url( $img, PHP_URL_PATH ), 1 );
						     $data[] = $img;
						  }
						  $this->data['csv'][$key]['gallery_images'] = $data;
						  */

						  // Clean up product description (Remove @@@@%, %0D & %0A)						  
						  $this->data['csv'][$key]['description'] = str_ireplace ('%0d', '', $this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_ireplace ('%0a', '', $this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_ireplace('@@@@%','', $this->data['csv'][$key]['description']);

						  /*
						  // Remove images
						  $this->data['csv'][$key]['description'] = preg_replace('/<img[^>]+\>/i', '', $this->data['csv'][$key]['description']);
						  */

						  // Remove HTML tags
						  $this->data['csv'][$key]['description'] = preg_replace('(\<(/?[^\>]+)\>)', '', $this->data['csv'][$key]['description']);

						  // Remove left over crap
						  $this->data['csv'][$key]['description'] = str_replace('Browse our many parts at:','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('GSMESS Bits!','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('We\'ve got great feedback from thousands of honest trades, so purchase with confidence!','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('Please understand that we do not know if this will fit your custom application, or other years/models other than those explicitly listed in the title and description, thank you.','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('International customers, sometimes you get hit with a ridiculous customs tax before taking delivery of your items; at that, I sympathize, though it\'s out of my control.','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('Yes, you have to pay import taxes.','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('Domestic customers, as always: No hidden charges. No small print. No hassle returns.','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('Other payment forms are still gladly accepted!','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('Please contact us after buying for payment details.','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('Customs fees for international buyers are the responsibility of the purchaser, please do not ask me to edit declaration values.','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('No hidden charges.','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('No small print.','',$this->data['csv'][$key]['description']);
						  $this->data['csv'][$key]['description'] = str_replace('No hassle returns.','',$this->data['csv'][$key]['description']);

						  /*
						  // Match model code
						  if(isset($this->request->post['search_models'])) {
						  	$model_matcher = '/([0-9]{6,7}\s?\D[0-9]{1,2})/i';
						  	preg_match($model_matcher,$this->data['csv'][$key]['description'],$model);
						  	$this->data['csv'][$key]['model'] = $model[1];
						  }
						  
						  // Remove model from description						  
						  $this->data['csv'][$key]['description'] = preg_replace($model_matcher,'',$this->data['csv'][$key]['description']);						  						  						  
						  */
						  
						  // Domestic shipping
						  if($this->data['csv'][$key]['shipping_dom'] == 'USPSPriorityFlatRateEnvelope'){
							  $this->data['csv'][$key]['shipping_dom'] = 4;
						  } elseif ($this->data['csv'][$key]['shipping_dom'] == 'USPSPriorityFlatRateBox'){
							  $this->data['csv'][$key]['shipping_dom'] = 5;
						  } elseif ($this->data['csv'][$key]['shipping_dom'] == 'USPSPriorityLargeFlatRateBox'){
							  $this->data['csv'][$key]['shipping_dom'] = 6;
						  } elseif ($this->data['csv'][$key]['shipping_dom'] == 'USPSFirstClass'){
							  $this->data['csv'][$key]['shipping_dom'] = 1;
						  } else {
							  $this->data['csv'][$key]['shipping_dom'] = 7;//Parcel Select
						  }

						  // International shipping
						  if($this->data['csv'][$key]['shipping_intl'] == 'USPSPriorityMailInternationalFlatRateEnvelope'){
							  $this->data['csv'][$key]['shipping_intl'] = 11;
						  } elseif($this->data['csv'][$key]['shipping_intl'] == 'USPSPriorityMailInternationalFlatRateBox'){
							  $this->data['csv'][$key]['shipping_intl'] = 12;
						  } elseif ($this->data['csv'][$key]['shipping_intl'] == 'USPSPriorityMailInternationalLargeFlatRateBox'){
							  $this->data['csv'][$key]['shipping_intl'] = 13;
						  } elseif ($this->data['csv'][$key]['shipping_intl'] == 'USPSFirstClassMailInternational'){
							  $this->data['csv'][$key]['shipping_intl'] = 9;
						  } else {
							  $this->data['csv'][$key]['shipping_intl'] = 10;//Priority International
						  }

						 $this->model_affiliate_csv_import->addCsvImportProduct($this->data['csv'][$key]);
					  }
					  $this->session->data['success'] = $this->language->get('text_csv_success');
					  $this->redirect($this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
				  } else {
					  $this->session->data['error_validation'] = $this->language->get('error_validation');
					  $this->redirect($this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
				  }
		}

		$this->data['csv_view'] = $this->model_affiliate_csv_import->getCsvImportProductInfo($start, $limit);

		if($this->data['csv_view']) {
		  $import_count = $this->model_affiliate_csv_import->getTotalCsvImportProducts();
		} else {
			$import_count = '';
		}

		$pagination = new Pagination();
		$pagination->total = $import_count;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token']  . '&page={page}' , 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'affiliate/csv_import.tpl';

		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());

	}

	public function clear() {
		$this->language->load('affiliate/csv_import');
		$this->load->model('affiliate/csv_import');
		$this->document->setTitle($this->language->get('heading_title_import_csv'));

		$url = '';

		if (isset($this->request->get['page'])) {
			  $url .= '&page=' . $this->request->get['page'];
		}

		$this->model_affiliate_csv_import->clearCsvImportTable();
		$this->session->data['success_clear'] = $this->language->get('success_clear');
    	$this->redirect($this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}

	public function edit() {
		$this->language->load('affiliate/csv_import');
		$this->load->model('affiliate/csv_import');
		$this->document->setTitle($this->language->get('heading_title_import_csv'));
		$url = '';

		if (isset($this->request->get['page'])) {
			  $url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $product_id) {
					$name_str           = $product_id . '_name';
					$description_str    = $product_id . '_description';
					$quantity_str       = $product_id . '_quantity';
					$price_str          = $product_id . '_price';
					$length_str         = $product_id . '_length';
					$width_str          = $product_id . '_width';
					$height_str         = $product_id . '_height';
					$category_str       = $product_id . '_category';
					$manufacturer_str   = $product_id . '_manufacturer';
					$weight_str         = $product_id . '_weight';
					$shipping_dom_str   = $product_id . '_shipping_dom';
					$shipping_intl_str  = $product_id . '_shipping_intl';
					$model_str          = $product_id . '_model';
					$featured_image_str = $product_id . '_featured_image';

				  $image_count = $this->model_affiliate_csv_import->getTotalGalleryImages($product_id);

				  $gallery_array = array();

				  for($i = 0; $i < $image_count; $i++) {
					  $gallery_array[] = ($product_id . '_gallery_image_' . $i);
				  }

					$name           = $this->request->post[$name_str];
					$description    = $this->request->post[$description_str];
					$quantity       = $this->request->post[$quantity_str];
					$price          = $this->request->post[$price_str];
					$lenght         = $this->request->post[$length_str];
					$width          = $this->request->post[$width_str];
					$height         = $this->request->post[$height_str];
					$category       = $this->request->post[$category_str];
					$manufacturer   = $this->request->post[$manufacturer_str];
					$weight         = $this->request->post[$weight_str];
					$shipping_dom   = $this->request->post[$shipping_dom_str];
					$shipping_intl  = $this->request->post[$shipping_intl_str];
					$model          = $this->request->post[$model_str];
					$featured_image = $this->request->post[$featured_image_str];

				  $gallery_images = array();

				  foreach($gallery_array as $value) {
				    $gallery_images[] = $this->request->post[$value];
				  }

				  $edit_data = array(
				  	'name'           => $name,
					'description'    => $description,
					'quantity'       => $quantity,
					'price'          => $price,
					'length'         => $lenght,
					'width'          => $width,
					'height'         => $height,
					'category'       => $category,
					'manufacturer'   => $manufacturer,
					'weight'         => $weight,
					'shipping_dom'   => $shipping_dom,
					'shipping_intl'  => $shipping_intl,
					'model'          => $model,
					'featured_image' => $featured_image,
					'gallery_images' => $gallery_images
				  );

				  $this->model_affiliate_csv_import->editCsvImportProductInfo($product_id, $edit_data);
			}

			$this->session->data['success_edit'] = $this->language->get('success_edit');
			$this->redirect($this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->session->data['error_edit'] = $this->language->get('error_edit');
    	$this->redirect($this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
  	}

  	public function delete() {
		$this->language->load('affiliate/csv_import');
		$this->load->model('affiliate/csv_import');
		$this->document->setTitle($this->language->get('heading_title_import_csv'));

		if (isset($this->request->post['selected'])) {
			$url = '';

			if (isset($this->request->get['page'])) {
				  $url .= '&page=' . $this->request->get['page'];
			}

			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_affiliate_csv_import->deleteProduct($product_id);
	  		}

			$this->session->data['success_delete'] = $this->language->get('success_delete');
			$this->redirect($this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->session->data['error_delete'] = $this->language->get('error_delete');
    	$this->redirect($this->url->link('affiliate/csv_import', 'token=' . $this->session->data['token'] . $url, 'SSL'));
  	}

	protected function validImport($content) {
		$csv = new Parsecsv();
		$csv->auto($content);
		$match = 0;
		foreach ($csv->titles as $value) {
			if($value == 'Title') {$match++;}
			if($value == 'Description') {$match++;}
			if($value == 'Quantity') {$match++;}
			if($value == 'ItemID') {$match++;}
			if($value == 'PicURL') {$match++;}
			if($value == 'WeightMinor') {$match++;}
			if($value == 'WeightMajor') {$match++;}
			if($value == 'MeasurementUnit') {$match++;}
			if($value == 'PackageLength') {$match++;}
			if($value == 'PackageWidth') {$match++;}
			if($value == 'PackageDepth') {$match++;}
			if($value == 'ShippingService-1:Option') {$match++;}
			if($value == 'IntlShippingService-1:Option') {$match++;}
			if($value == 'PayPalAccepted') {$match++;}
			if($value == 'PayPalEmailAddress') {$match++;}
		}

		if ($match == 15) {
			return true;
		} else {
			return false;
		}
	}


}// end class
