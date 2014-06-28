<?php
class ControllerAffiliateStockControl extends Controller {

	public function index() {
		$this->language->load('affiliate/csv_import');
		$this->document->setTitle($this->language->get('heading_title_csv_import'));
		$this->load->model('affiliate/csv_import');

		$this->stockControl();
	}

	protected function stockControl() {
		
	}




}
?>