<?php

// headint title
$_['heading_title_csv_import']         = 'CSV Import';
$_['heading_title_ebayid_import']      = 'eBay ItemID Import';

// text
$_['text_choose_file']                 = 'Select CSV file';
$_['text_skip_image']                  = 'Skip Image Description';
$_['text_skip_image_help']             = 'Prevents duplicate gallery images by skipping first image match if they\'re embedded in the description';
$_['text_file_type']                   = 'TurboLister CSV File Type';
$_['text_file_type_help']              = 'Select the CSV file format when you export from TurboLister';
$_['text_file_exchange']               = 'FileExchange';
$_['text_turbo_lister']                = 'TurboLister';
$_['text_title']                       = 'Product Title';
$_['text_count']                       = 'Count';
$_['text_description']                 = 'Product Description';
$_['text_quantity']                    = 'Quantity';
$_['text_price']                       = 'Price';
$_['text_category']                    = 'Category';
$_['text_manufacturer']                = 'Manufacturer';
$_['text_shipping_dom']                = 'Shipping Domestic';
$_['text_shipping_intl']               = 'Shipping International';
$_['text_image']                       = 'Featured Image';
$_['text_gallery_image']               = 'Gallery Images';
$_['text_length']                      = 'Length';
$_['text_width']                       = 'Width';
$_['text_height']                      = 'Height';
$_['text_model']                       = 'Model #';
$_['text_weight']                      = 'Weight';
$_['text_ebay_start_from']             = 'Product Start From';
$_['text_ebay_start_to']               = 'Product Start To';
$_['text_ebay_start_to_help']          = 'Date range <b>to</b> when products were listed';
$_['text_ebay_start_from_help']        = 'Date range <b>from</b> when products were listed';
$_['text_start_dates']                 = 'Date Range Tracker';
$_['text_start_dates_help']            = 'These are so you can track your previous start to and start from eBay import dates. Please make use of this calendar to completely cover all possible import dates and complete your product listing links.';
$_['text_use_profile']                 = 'Uses previous established setting(s), un-check if you need to change any of these setting(s).';
$_['text_site_id']                     = 'eBay Site ID';
$_['text_certification_id']            = 'eBay Certification ID';
$_['text_application_id']              = 'eBay Application ID';
$_['text_developer_id']                = 'eBay Developer ID';
$_['text_none']                        = 'Please Select';
$_['text_confirm']                     = 'Delete/Uninstall cannot be undone! Are you sure you want to do this?';
$_['text_confirm_clear_dates']         = 'Clear Dates cannot be undone! Are you sure you want to do this?';
$_['text_confirm_edit']                = 'Edit Products, Is this want you want to do?';
$_['text_search_image_help']           = 'Search &amp; extract embedded image(s) within the product description.';
$_['text_search_image']                = 'Search Image Descriprion';
$_['text_import_ebayid']               = 'Import eBayID';
$_['text_no_dates']                    = 'No Dates to Display';
$_['text_compat_level']                = 'Compatibility Level';
$_['text_compat_help']                 = 'Compatibility level is already pre-selected to the highest available level. Only during rare case will you need to adjust the compatibility level.';
$_['text_user_token']                  = 'eBay User Token';
$_['text_product_links']               = 'Product Links';
$_['text_linked_products']             = 'Linked Products';
$_['text_unlinked_products']           = 'Unlinked Products';
$_['text_product_title']               = 'Product Title';
$_['text_product_id']                  = 'Product ID';
$_['text_ebay_item_id']                = 'eBay Item ID';
$_['text_unlinked_product_pagination'] = 'Unlinked Products Pagination';
$_['text_linked_product_pagination']   = 'Linked Products Pagination';



// buttons
$_['button_import']                    = 'Import';
$_['button_cancel']                    = 'Cancel';
$_['button_clear_dates']               = 'Clear Dates';
$_['button_reload']                    = 'Reload';
$_['button_edit_linked_products']      = 'Edit Linked Products';
$_['button_edit_unlinked_products']    = 'Edit Unlinked Products';
$_['button_clear_products']            = 'Clear Products';
$_['button_edit_list']                 = 'Edit';
$_['button_activate_linked_products']  = 'Activate Product Links';
$_['button_set_ebay_profile']          = 'Save Profile';
$_['button_clear'] 					   = 'Clear';

// error
$_['error']							   = 'ERROR: There was an error in your request, please try again';
$_['error_file']                       = 'ERROR: Incorrect file type, parser only works with Turbolister Exported CSV files.';
$_['error_validation']                 = 'ERROR: There was a problem parsing your csv file, the title fields do not match. Please make sure the CSV file is a Turbolister export in FileExchange format. If problem\'s persist contact the site administrator.';
$_['error_delete']                     = 'ERROR: There was a problem deleting the selected product, please try again. If problem\'s persist contact the site administrator.';
$_['error_edit']                       = 'ERROR: There was a problem editing the selected product(s), please try again. If problem\'s persist contact the site administrator.';
$_['error_ebayid']                     = 'ERROR: There was a problem with your eBay itemID import. Please check the form for errors and review your eBay developer profile setting\'s then try again. If problem\'s persist contact the site administrator.';
$_['error_startdate_from']             = 'WARNING: eBay product listing start time <b>from</b> date required';
$_['error_startdate_to']               = 'WARNING: eBay product listing start time <b>to</b> date required';
$_['error_certification_id']           = 'WARNING: eBay developers Certification ID is required for the API call';
$_['error_developer_id']               = 'WARNING: eBay developers Developer ID is required for the API call';
$_['error_application_id']             = 'WARNING: eBay developers Application ID is required for the API call';
$_['error_site_id']                    = 'WARNING: eBay developers Site ID is required for the API call';
$_['error_user_token']                 = 'WARNING: eBay developers User Token is required for the API call';
$_['error_compatability_level']        = 'ERROR: eBay Compatability Level is required for the API call';

$_['error_ebay_call']                  = 'ERROR: The eBay call request has failed, timed out or your date interval has exceeded 121 days. Try decreasing your date range and re-send. If problem\'s persist contact the site administrator.';

// success
$_['success_delete']                   = 'SUCCESS: Product has been deleted.';
$_['success_edit']                     = 'SUCCESS: Product edit has been saved.';
$_['success_clear_dates']              = 'SUCCESS: Start to and start from eBay ItemID import dates have been cleared.';
$_['success_profile']                  = 'SUCCESS: eBay developer profile has been saved.';
$_['success_import']                   = 'SUCCESS: eBay product ID import has been completed.';
$_['text_csv_success']                 = 'SUCCESS: CSV file has been parsed, preview product data below before submit.';
$_['success_activate_product_links']   = 'SUCCESS: Linked products are now activated.';
$_['success_clear'] 				   = 'SUCCESS: CSV Import table has been cleared.';

// others
$_['entry_select']                     = 'Please Select One';


$_['error_test'] = 'ERROR TEST';










?>