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

	public function getTotalLinkedProducts() {
		//bikesalvage
		$count = $this->db->query("SELECT COUNT(*) AS `total` FROM " . DB_PREFIX . "product WHERE `linked` = '1' AND `affiliate_id` = '0'");

		return $count->row['total'];
	}

	public function getTotalUnlinkedProducts() {
		//bikesalvage
		$count = $this->db->query("SELECT COUNT(*) AS `total` FROM " . DB_PREFIX . "product WHERE `linked` = '0' AND `affiliate_id` = '0'");

		return $count->row['total'];
	}

	public function getLinkedProducts($start, $limit) {
		$sql = "SELECT    el.product_id,
	  			  		  el.ebay_item_id,
          		  		  pd.name
				FROM      " . DB_PREFIX . "ebay_listing el
				LEFT JOIN " . DB_PREFIX . "product_description pd ON (el.product_id = pd.product_id)
				WHERE     el.affiliate_id = '0'";

		if(isset($start) || isset($limit)) {
				if($start < 0) {
					$start = 0;
				}
				if($limit < 1) {
					$limit = 20;
				}

			    $sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		}

		$query = $this->db->query($sql);
		$product_data = array();

		foreach($query->rows as $data) {
				$product_data[] = array (
					'product_id'   => $data['product_id'],
					'ebay_item_id' => $data['ebay_item_id'],
					'title'        => $data['name'],
					'selected'     => isset($this->request->post['selected']) && in_array($data['product_id'], $this->request->post['selected'])
				);
		}

		return $product_data;

	}

	public function getUnlinkedProducts($start, $limit) {
		$sql = "SELECT   pd.name,
 					 	 pd.product_id
			    FROM     " . DB_PREFIX . "product_description pd
				WHERE    pd.product_id IN (
										   SELECT product_id p
                   					   	   FROM   " . DB_PREFIX . "product p
                   					   	   WHERE  p.status = '0'
                   					   	   AND    p.affiliate_id = '0'
                   					   	   AND 	  p.linked = '0'
                   					   	   )
				ORDER BY pd.name DESC";

		if(isset($start) || isset($limit)) {
			if($start < 0) {
				$start = 0;
			}
			if($limit < 1) {
				$limit = 20;
			}

		    $sql .= " LIMIT " . (int)$start . "," . (int)$limit;
		}

		$query_product = $this->db->query($sql);
		$product_data = array();

		foreach ($query_product->rows as $data) {
			$product_data[] = array(
				'product_id' => $data['product_id'],
				'title'      => $data['name'],
				'selected'   => isset($this->request->post['selected']) && in_array($data['product_id'], $this->request->post['selected'])
			);
		}

		return $product_data;

	}

	public function editLinkedProductEbayItemId($product_id, $ebay_id) {
		if (isset($ebay_id) ) {
			// $this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_product_link WHERE `product_id` = '" . $this->db->escape($product_id) . "' AND `affiliate_id` = '0'");
			// $this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_product_link
			// 				  SET `product_id` = '" . $this->db->escape($product_id) . "',
			// 				  	  `ebay_item_id` = '" . $this->db->escape($ebay_id) . "',
			// 				  	  `affiliate_id` = '0'");
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_listing SET ebay_item_id = '" . $this->db->escape($ebay_id) . "' WHERE product_id = '" . $this->db->escape($product_id) . "'");
		}


	}

	public function linkUnlinkedProduct($product_id, $ebay_id) {
		if (isset($ebay_id) ) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET linked = 1 WHERE product_id = '" . $this->db->escape($product_id) . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "ebay_listing SET ebay_item_id = '" . $this->db->escape($ebay_id) . "', product_id = '" . $this->db->escape($product_id) . "', affiliate_id = '0'");
		}


	}

} // end class
?>