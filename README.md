Custom extensions and classes designed for opencart users who want to be able to manage there products on eBay as well. This will allow bulk imports, product stock and inventory management and much more. So far The CSV Import and eBay ItemID product link are here, tested and working. Using the header.php, header.tpl, startup.php is for extension use without using vqmod. You can easily extend this to work with vqmod.
DIRECTIONS:
- run the affiliate_install.sql file in your open-cart db, note: sql file uses 'db' as a prefix
- Install the software via FTP
- add the new permissions under system/users/user groups  then edit the top administrator permissions to allow the new directories.