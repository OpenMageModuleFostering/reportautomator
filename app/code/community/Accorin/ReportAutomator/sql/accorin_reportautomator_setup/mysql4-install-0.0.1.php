<?php
/**
 * Created by PhpStorm.
 * User: marcosegura
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
   CREATE TABLE IF NOT EXISTS `reportautomator_entries` (
  `entry_id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `report_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `output_id` tinyint(4) DEFAULT NULL,
  `file_type` tinyint(4) NOT NULL DEFAULT '0',
  `email_array` text  DEFAULT '',
  `ftp_user` varchar(255)  DEFAULT '',
  `ftp_pass` varchar(255)  DEFAULT '',
  `ftp_host` varchar(255)  DEFAULT '',
  `ftp_is_passive` tinyint(4) NOT NULL DEFAULT '0',
  `ftp_remote_file` varchar(255) DEFAULT '',
  `schedule_frequency` int(2) DEFAULT '0',
  `schedule_day` int(2) DEFAULT '0',
  `schedule_date_flag` tinyint(4) NOT NULL DEFAULT '0',
  `template` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `store_id` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
    CREATE TABLE IF NOT EXISTS `reportautomator_report` (
      `report_id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `name` varchar(255) DEFAULT NULL,
      `block` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
    CREATE TABLE IF NOT EXISTS `reportautomator_log` (
      `log_id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
      `entry_id` int(11) unsigned NOT NULL,
      `status_log` tinyint(4) NOT NULL DEFAULT '0',
      `last_executed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `result` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("INSERT INTO `reportautomator_report` VALUES (1, 'Sales Orders', 'adminhtml/report_sales_sales_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (2, 'Sales Tax', 'adminhtml/report_sales_tax_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (3, 'Sales Invoiced', 'adminhtml/report_sales_invoiced_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (4, 'Sales Shipping', 'adminhtml/report_sales_shipping_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (5, 'Sales Refunds', 'adminhtml/report_sales_refunded_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (6, 'Sales Coupons', 'adminhtml/report_sales_coupons_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (7, 'Sales Paypal', '')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (8, 'Shopping Cart Products', 'adminhtml/report_shopcart_product_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (9, 'Shopping Cart Abandoned', 'adminhtml/report_shopcart_abandoned_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (10, 'Products Bestsellers', 'adminhtml/report_sales_bestsellers_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (11, 'Products Ordered', 'adminhtml/report_product_sold_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (12, 'Products Most Viewed', 'adminhtml/report_product_viewed_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (13, 'Products Low Stock', 'adminhtml/report_product_lowstock_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (14, 'Products Downloads', 'adminhtml/report_product_downloads_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (15, 'Customer New Accounts', 'adminhtml/report_customer_accounts_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (16, 'Customers by Order Total', 'adminhtml/report_customer_totals_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (17, 'Customers by Number of Orders', 'adminhtml/report_customer_orders_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (18, 'Tag Customers', 'adminhtml/report_tag_customer_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (19, 'Tag Products', 'adminhtml/report_tag_product_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (20, 'Tag Popular', 'adminhtml/report_tag_popular_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (21, 'Review Customers', 'adminhtml/report_review_customer_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (22, 'Review Products', 'adminhtml/report_review_product_grid')");
$installer->run("INSERT INTO `reportautomator_report` VALUES (23, 'Search Terms', 'adminhtml/report_search_grid')");


$installer->endSetup();