ALTER TABLE `tbl_languages` CHANGE `language_code` `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

CREATE TABLE `tbl_coupons_hold_pending_order` (
  `ochold_order_id` varchar(15) NOT NULL,
  `ochold_coupon_id` int(11) NOT NULL,
  `ochold_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_coupons_hold_pending_order`
--
ALTER TABLE `tbl_coupons_hold_pending_order`
  ADD PRIMARY KEY (`ochold_order_id`,`ochold_coupon_id`);

ALTER TABLE `tbl_user_cart` ADD `usercart_last_used_date` DATETIME NOT NULL AFTER `usercart_reminder_date`, ADD `usercart_last_session_id` VARCHAR(200) NOT NULL AFTER `usercart_last_used_date`;
  
  
CREATE TABLE `tbl_collection_to_brands` (
  `ctpb_collection_id` int(11) NOT NULL,
  `ctpb_brand_id` int(11) NOT NULL,
  `ctpb_display_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tbl_collection_to_brands`
  ADD PRIMARY KEY (`ctpb_collection_id`,`ctpb_brand_id`);
  
  
ALTER TABLE `tbl_seller_products` ADD UNIQUE( `selprod_user_id`, `selprod_code`);

DELETE FROM `tbl_language_labels` WHERE `tbl_language_labels`.`label_key` = 'LBL_VIEW_%d_More_Sellers';
DELETE FROM `tbl_language_labels` WHERE `label_key` LIKE 'LBL_Commission_fees';

ALTER TABLE `tbl_product_special_prices` ADD UNIQUE( `splprice_selprod_id`, `splprice_start_date`, `splprice_end_date`);
ALTER TABLE tbl_product_special_prices DROP INDEX price_selprod_id;

/* After 3rd Jan 2019 */

DELETE FROM `tbl_language_labels` WHERE `label_key` LIKE 'LBL_This_order_is_In_Process_or_Completed_now,_so_not_eligible_for_cancellation'
