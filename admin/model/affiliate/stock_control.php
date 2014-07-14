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
		$sql = "SELECT * FROM " . DB_PREFIX . "ebay_compatibility ORDER BY id DESC";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getEbaySiteIds() {
		$sql = "SELECT * FROM " . DB_PREFIX . "ebay_site_ids";
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getEbayCallNames() {
		$call_names = array('getOrders', 'getItemQuantity', 'endFixedPriceItem', 'reviseInventoryStatus');
		return $call_names;
	}

	public function getTotalLinkedProducts() {
		//bikesalvage
		$count = $this->db->query("SELECT COUNT(*) AS `total` FROM " . DB_PREFIX . "ebay_listing");

		return $count->row['total'];
	}

	public function getTotalUnlinkedProducts() {
		//bikesalvage
		$count = $this->db->query("SELECT COUNT(*) AS `total` FROM " . DB_PREFIX . "product WHERE `linked` = '0' AND `affiliate_id` = '0' AND `status` = '0'");

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
                   					   	   WHERE  p.affiliate_id = '0'
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

	public function setLinkedProductEbayItemId($product_id, $ebay_id) {
		if (isset($ebay_id) ) {			
			$this->db->query("UPDATE " . DB_PREFIX . "ebay_listing SET ebay_item_id = '" . $this->db->escape($ebay_id) . "' WHERE product_id = '" . $this->db->escape($product_id) . "'");
		}
	}

	public function setProductLink($product_id, $ebay_id) {
		if (isset($ebay_id) ) {
			$this->db->query("UPDATE " . DB_PREFIX . "product SET linked = 1, status = 1 WHERE product_id = '" . $this->db->escape($product_id) . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "ebay_listing SET ebay_item_id = '" . $this->db->escape($ebay_id) . "', product_id = '" . $this->db->escape($product_id) . "', affiliate_id = '0'");
		}
	}

	public function removeProductLink($product_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET linked = 0, status = 0 WHERE product_id = '" . $this->db->escape($product_id) . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "ebay_listing WHERE product_id = '" . $this->db->escape($product_id) . "'");
	}

	public function getOrdersRequest() {
		$call_name = 'GetOrders';
		$profile = $this->getEbayProfile();
		$ebay_call = new Ebaycall($profile['developer_id'], $profile['application_id'], $profile['certification_id'], $profile['compat'], $profile['site_id'], $call_name);
		
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$xml .= '<RequesterCredentials>';
		$xml .= '<eBayAuthToken>' . $profile['user_token'] . '</eBayAuthToken>';
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
			$this->language->load('affiliate/stock_control');
	        $response = $this->language->get('error_ebay_api_call');
	        return $response;
        }

        $doc_response = new DomDocument();
        $doc_response->loadXML($xml_response);
        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;
        

        if($message == 'Failure') {
        	$severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
        	$error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
        	$short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
        	$long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;
	        $response = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;
			return $response;
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
        		$ebay_call = new Ebaycall($profile['developer_id'], $profile['application_id'], $profile['certification_id'], $profile['compatability_level'], $profile['site_id'], $call_name);
        		
        		$xml = '<?xml version="1.0" encoding="utf-8"?>';
				$xml .= '<GetOrdersRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
				$xml .= '<RequesterCredentials>';
				$xml .= '<eBayAuthToken>' . $profile['user_token'] . '</eBayAuthToken>';
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
				   $this->language->load('affiliate/stock_control');
	     		   $response = $this->language->get('error_ebay_api_call');
	        	   return $response;
        		}	

		        $doc_response = new DomDocument();
		        $doc_response->loadXML($xml_response);
		        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;
        		
        		if($message == 'Failure') {
        			$severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
        			$error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
        			$short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
        			$long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;
	        		$response = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;
					return $response;
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

	    return $import_data;
	}

	public function getEbayItemQuantity($ebay_item_id) {
		$call_name = 'GetItem';
		$profile = $this->getEbayProfile();
		$ebay_call = new Ebaycall($profile['developer_id'], $profile['application_id'], $profile['certification_id'], $profile['compat'], $profile['site_id'], $call_name);
		
		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$xml .= '<RequesterCredentials>';
		$xml .= '<eBayAuthToken>' . $profile['user_token'] . '</eBayAuthToken>';
		$xml .= '</RequesterCredentials>';
		$xml .= '<ItemID>' . $ebay_item_id . '</ItemID>';
		$xml .= '<WarningLevel>Low</WarningLevel>';
        $xml .= '<OutputSelector>Title</OutputSelector>';
        $xml .= '<OutputSelector>ItemID</OutputSelector>';
        $xml .= '<OutputSelector>Quantity</OutputSelector>';
        $xml .= '</GetItemRequest>';

        $xml_response = $ebay_call->sendHttpRequest($xml);

        if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
        	$this->language->load('affiliate/stock_control');
	        $response = $this->language->get('error_ebay_api_call');
	        return $response;
        }

        $doc_response = new DomDocument();
        $doc_response->loadXML($xml_response);
        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;
        
        if($message == 'Failure') {
        	$severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
        	$error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
        	$short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
        	$long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;
	        $response = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;
			return $response;
        }
        
        $quantity = $doc_response->getElementsByTagName('Quantity')->item(0)->nodeValue;	
        return $quantity;
	}

	public function getProductQuantity($product_id) {
		$product_quantity = $this->db->query("SELECT quantity FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
		return $product_quantity->row['quantity'];
	}

	public function getEbayItemId($product_id) {
		$ebay_item_id = $this->db->query("SELECT ebay_item_id FROM " . DB_PREFIX . "ebay_listing WHERE product_id = '" . (int)$product_id . "'");
		return $ebay_item_id->row['ebay_item_id'];
	}
	// tested working
	public function reviseEbayItemQuantity($ebay_item_id, $new_quantity) {
		$call_name = 'ReviseInventoryStatus';
		$profile = $this->getEbayProfile();
		$ebay_call = new Ebaycall($profile['developer_id'], $profile['application_id'], $profile['certification_id'], $profile['compat'], $profile['site_id'], $call_name);

		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<ReviseInventoryStatusRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$xml .= '<RequesterCredentials>';
		$xml .= '<eBayAuthToken>' . $profile['user_token'] . '</eBayAuthToken>';
		$xml .= '</RequesterCredentials>';
		$xml .= '<WarningLevel>Low</WarningLevel>';
		$xml .= '<InventoryStatus>';
		$xml .= '<ItemID>' . $ebay_item_id . '</ItemID>';
		$xml .= '<Quantity>' . $new_quantity . '</Quantity>';
		$xml .= '</InventoryStatus>';
		$xml .= '</ReviseInventoryStatusRequest>';

		$xml_response = $ebay_call->sendHttpRequest($xml);

		$ebay_call_response = '';

        if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
	        $this->language->load('affiliate/stock_control');
	        $ebay_call_response = $this->language->get('error_ebay_api_call');	        
        }

        $doc_response = new DomDocument();
        $doc_response->loadXML($xml_response);
        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;                

        if($message == 'Failure') {
        	$severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
        	$error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
        	$short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
        	$long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;
	        $ebay_call_response = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;	        
        }

        if($message == 'Success') {
        	$ebay_call_response = $doc_response->getElementsByTagName('Timestamp')->item(0)->nodeValue;
        	$ebay_call_response .= '<br>' . $doc_response->getElementsByTagName('ItemID')->item(0)->nodeValue;
        	$ebay_call_response .= '<br>' .$doc_response->getElementsByTagName('StartPrice')->item(0)->nodeValue;
        	$ebay_call_response .= '<br>' .$doc_response->getElementsByTagName('Quantity')->item(0)->nodeValue;
        }

        return $ebay_call_response;
	}

	public function endEbayItem($ebay_item_id) {
		$call_name = 'EndFixedPriceItem';
		$profile = $this->getEbayProfile();
		$ebay_call = new Ebaycall($profile['developer_id'], $profile['application_id'], $profile['certification_id'], $profile['compatability_level'], $profile['site_id'], $call_name);

		$xml = '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<EndFixedPriceItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
		$xml .= '<ItemID>' . $ebay_item_id . '</ItemID>';
		$xml .= '<EndingReason EnumType="EndReasonCodeType">NotAvailable</EndingReason>';
		$xml .= '<RequesterCredentials>';
		$xml .= '<eBayAuthToken>' . $profile['user_token'] . '</eBayAuthToken>';
		$xml .= '</RequesterCredentials>';
		$xml .= '</EndFixedPriceItemRequest>';

		$xml_response = $ebay_call->sendHttpRequest($xml);

		$ebay_call_response = '';

        if(stristr($xml_response, 'HTTP 404') || $xml_response == '') {
	        $this->language->load('affiliate/stock_control');
	        $ebay_call_response = $this->language->get('error_ebay_api_call');	        
        }

        $doc_response = new DomDocument();
        $doc_response->loadXML($xml_response);
        $message = $doc_response->getElementsByTagName('Ack')->item(0)->nodeValue;                

        if($message == 'Failure') {
        	$severity_code = $doc_response->getElementsByTagName('SeverityCode')->item(0)->nodeValue;
        	$error_code = $doc_response->getElementsByTagName('ErrorCode')->item(0)->nodeValue;
        	$short_message = $doc_response->getElementsByTagName('ShortMessage')->item(0)->nodeValue;
        	$long_message = $doc_response->getElementsByTagName('LongMessage')->item(0)->nodeValue;
	        $ebay_call_response = strtoupper($severity_code) . ': ' . $long_message . ' Error Code: ' . $error_code;	        
        }

        if($message == 'Success') {
        	$ebay_call_response = $doc_response->getElementsByTagName('Timestamp')->item(0)->nodeValue;
        }

        return $ebay_call_response;
	}

} // end class
?>