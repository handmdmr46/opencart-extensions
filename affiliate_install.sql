DROP TABLE IF EXISTS `db_product_to_affiliate`;
CREATE TABLE `db_product_to_affiliate` (
  `affiliate_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`affiliate_id`,`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `db_customer_to_customergroup`;
CREATE TABLE  `db_customer_to_customergroup` (
  `customer_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  PRIMARY KEY (`customer_group_id`,`customer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `db_affiliate_order`;
CREATE TABLE `db_affiliate_order` (
  `order_id` int(11) NOT NULL,
  `affiliate_id` int(11) NOT NULL,
  PRIMARY KEY (`order_id`,`affiliate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `db_affiliate_to_email`;
CREATE TABLE `db_affiliate_to_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(96) NOT NULL,
  `affiliate_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `db_affiliate_product_link`;
CREATE TABLE `db_affiliate_product_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `affiliate_id` int(11) NOT NULL,
  `product_id` varchar(16) NOT NULL,
  `ebay_item_id` varchar(100) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id` (`product_id`,`ebay_item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `db_ebay_import_startdates`;
CREATE TABLE `db_ebay_import_startdates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` varchar(64) NOT NULL,
  `end_date` varchar(64) NOT NULL,
  `affiliate_id` int(11) NOT NULL,
  `text` varchar(22) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `db_ebay_settings`;
CREATE TABLE `db_ebay_settings` (
  `compat` int(11) NOT NULL,
  `user_token` text NOT NULL,
  `application_id` varchar(64) NOT NULL,
  `developer_id` varchar(64) NOT NULL,
  `certification_id` varchar(64) NOT NULL,
  `site_id` int(11) NOT NULL,
  `affiliate_id` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `db_ebay_compatibility`;
CREATE TABLE `db_ebay_compatibility` (
  `level` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


DROP TABLE IF EXISTS `db_ebay_site_ids`;
CREATE TABLE `db_ebay_site_ids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `site_name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

INSERT INTO `db_ebay_compatibility` (`level`, `id`) VALUES
(851, 1),
(849, 2),
(847, 3),
(845, 4),
(843, 5),
(841, 6),
(839, 7),
(837, 8),
(835, 9),
(833, 10),
(831, 11),
(829, 12),
(827, 13),
(825, 14),
(823, 15),
(821, 16),
(819, 17),
(817, 18),
(815, 19),
(813, 20),
(811, 21),
(809, 22),
(807, 23),
(805, 24),
(803, 25),
(801, 26);

INSERT INTO `db_ebay_site_ids` (`id`, `site_id`, `site_name`) VALUES
(1, 0, 'United States'),
(2, 100, 'eBay Motors'),
(3, 101, 'Italy'),
(4, 123, 'Belgium'),
(5, 146, 'Netherlands'),
(6, 15, 'Australia'),
(7, 16, 'Austria'),
(8, 186, 'Spain'),
(9, 193, 'Switzerland'),
(10, 196, 'Taiwan'),
(11, 2, 'Canada'),
(12, 201, 'Hong Kong'),
(13, 203, 'India'),
(14, 205, 'Ireland'),
(15, 207, 'Malaysia'),
(16, 210, 'Canada (French)'),
(17, 211, 'Philippines'),
(18, 212, 'Poland'),
(19, 216, 'Singapore'),
(20, 218, 'Sweden'),
(21, 223, 'China'),
(22, 23, 'Belgium (French)'),
(23, 3, 'UK'),
(24, 71, 'France'),
(25, 77, 'Germany');


-- alter tables --

ALTER TABLE `db_customer_group`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0'
AFTER       `customer_group_id`;

ALTER TABLE `db_setting`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0'
AFTER       `store_id`;

ALTER TABLE `db_product`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0',
ADD COLUMN  `affiliate_order` int(11) NOT NULL DEFAULT'0',
ADD COLUMN  `csv_import` int(11) NOT NULL DEFAULT'0';

ALTER TABLE `db_order`
ADD COLUMN  `affiliate_order` int(11) NOT NULL DEFAULT'0'
AFTER       `affiliate_id`;

ALTER TABLE `db_order_product`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0';

ALTER TABLE `db_order_total`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0',
ADD COLUMN  `affiliate_order` int(11) NOT NULL DEFAULT'0';

ALTER TABLE `db_order_voucher`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0',
ADD COLUMN  `affiliate_order` int(11) NOT NULL DEFAULT'0';

ALTER TABLE `db_order_option`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0',
ADD COLUMN  `affiliate_order` int(11) NOT NULL DEFAULT'0';

ALTER TABLE `db_order_history`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0',
ADD COLUMN  `affiliate_order` int(11) NOT NULL DEFAULT'0';

ALTER TABLE `db_order_fraud`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0',
ADD COLUMN  `affiliate_order` int(11) NOT NULL DEFAULT'0';

ALTER TABLE `db_order_field`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0',
ADD COLUMN  `affiliate_order` int(11) NOT NULL DEFAULT'0';

ALTER TABLE `db_order_download`
ADD COLUMN  `affiliate_id` int(11) NOT NULL DEFAULT'0',
ADD COLUMN  `affiliate_order` int(11) NOT NULL DEFAULT'0';

ALTER TABLE `db_category`
ADD COLUMN  `manufacturer_id` int(11) NOT NULL DEFAULT'0'
AFTER       `category_id`;

ALTER TABLE `db_ebay_listing`
ADD COLUMN  `active` int(11) NOT NULL DEFAULT'1'
AFTER       `status`;
