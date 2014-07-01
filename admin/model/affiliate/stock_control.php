<?php
class ModelAffiliateStockControl extends Model {

	
	public function getEbayProfile($affiliate_id = 0) {
		$sql = "SELECT * FROM " . DB_PREFIX . "ebay_settings WHERE `affiliate_id` = '" . (int)$affiliate_id . "'";
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function setEbayProfile($data) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "ebay_settings WHERE affiliate_id = '0'");

		$this->db->query("INSERT INTO " . DB_PREFIX . "ebay_settings
						  SET		  `compat` = '" . (int)$data['compatability_level'] . "',
									  `user_token` = '" . $this->db->escape($data['user_token']) . "',
									  `application_id` = '" . $this->db->escape($data['application_id']) . "',
									  `developer_id` = '" . $this->db->escape($data['developer_id']) . "',
									  `certification_id` = '" . $this->db->escape($data['certification_id']) . "',
									  `site_id` = '" . $this->db->escape($data['site_id']) . "',
									  `affiliate_id` = '0'");
	}
	
	public function getEbayCompatibilityLevels() {
		$sql = "SELECT * FROM " . DB_PREFIX . "ebay_compatibility";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getEbaySiteIds() {
		$sql = "SELECT * FROM " . DB_PREFIX . "ebay_site_ids";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getEbayCallNames() {
		$call_names = array('getOrders', 'getItem', 'endFixedPriceItem', 'reviseInventoryStatus');
		return $call_names;
	}

} // end class
?>