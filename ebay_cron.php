<?php

define('DIR_APPLICATION', '/Applications/MAMP/htdocs/open-cart/catalog/');
define('DIR_LOGS', '/Applications/MAMP/htdocs/open-cart/system/logs/');

$file = DIR_LOGS . 'ebay_cron_log.txt';
// The new person to add to the file
$person = "Testing writing to the log directory \n";


// Write the contents to the file, 
// using the FILE_APPEND flag to append the content to the end of the file
// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
file_put_contents($file, $person, FILE_APPEND | LOCK_EX);



?>