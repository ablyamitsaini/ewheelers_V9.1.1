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

UPDATE `tbl_email_templates` SET `etpl_replacements` = '{user_full_name} Name of the email receiver<br/> {product_link} Product Link<br/> {new_status} New/Current Review Status<br/> {website_name} Name of our website<br> {website_url} URL of our website<br> {social_media_icons} <br> {contact_us_url} <br> ' WHERE `tbl_email_templates`.`etpl_code` = 'buyer_notification_review_status_updated' AND `tbl_email_templates`.`etpl_lang_id` = 1;

UPDATE `tbl_email_templates` SET `etpl_body` = '<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#ecf0f1\" style=\"font-family:Arial; color:#333; line-height:26px;\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"background:#ff3a59;padding:30px 0 10px;\">\r\n				<!--\r\n				header start here\r\n				-->\r\n				   \r\n				<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n					<tbody>\r\n						<tr>\r\n							<td><a href=\"{website_url}\">{Company_Logo}</a></td>\r\n							<td style=\"text-align:right;\">{social_media_icons}</td>\r\n						</tr>\r\n					</tbody>\r\n				</table>\r\n				<!--\r\n				header end here\r\n				-->\r\n				   </td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"background:#ff3a59;\">\r\n				<!--\r\n				page title start here\r\n				-->\r\n				   \r\n				<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n					<tbody>\r\n						<tr>\r\n							<td style=\"background:#fff;padding:20px 0 10px; text-align:center;\">\r\n								<h4 style=\"font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;\">Changed</h4>\r\n								<h2 style=\"margin:0; font-size:34px; padding:0;\">Review Status</h2></td>\r\n						</tr>\r\n					</tbody>\r\n				</table>\r\n				<!--\r\n				page title end here\r\n				-->\r\n				   </td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<!--\r\n				page body start here\r\n				-->\r\n				   \r\n				<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n					<tbody>\r\n						<tr>\r\n							<td style=\"background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;\">\r\n								<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n									<tbody>\r\n										<tr>\r\n											<td style=\"padding:20px 0 30px;\"><strong style=\"font-size:18px;color:#333;\">Dear {user_full_name}</strong><br />\r\n												Your Review status for {product_link} has been changed to {new_status} at <a href=\"{website_url}\">{website_name}</a>.<br />\r\n												</td>\r\n										</tr>\r\n										<!--\r\n										section footer\r\n										-->\r\n										   \r\n										<tr>\r\n											<td style=\"padding:30px 0;border-top:1px solid #ddd;\">Get in touch in you have any questions regarding our Services.<br />\r\n												Feel free to contact us 24/7. We are here to help.<br />\r\n												<br />\r\n												All the best,<br />\r\n												The {website_name} Team<br />\r\n												</td>\r\n										</tr>\r\n										<!--\r\n										section footer\r\n										-->\r\n										   \r\n									</tbody>\r\n								</table></td>\r\n						</tr>\r\n					</tbody>\r\n				</table>\r\n				<!--\r\n				page body end here\r\n				-->\r\n				   </td>\r\n		</tr>\r\n		<tr>\r\n			<td>\r\n				<!--\r\n				page footer start here\r\n				-->\r\n				   \r\n				<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n					<tbody>\r\n						<tr>\r\n							<td style=\"height:30px;\"></td>\r\n						</tr>\r\n						<tr>\r\n							<td style=\"background:rgba(0,0,0,0.04);padding:0 30px; text-align:center; color:#999;vertical-align:top;\">\r\n								<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n									<tbody>\r\n										<tr>\r\n											<td style=\"padding:30px 0; font-size:20px; color:#000;\">Need more help?<br />\r\n												 <a href=\"{contact_us_url}\" style=\"color:#ff3a59;\">Weâ€˜re here, ready to talk</a></td>\r\n										</tr>\r\n									</tbody>\r\n								</table></td>\r\n						</tr>\r\n						<tr>\r\n							<td style=\"padding:0; color:#999;vertical-align:top; line-height:20px;\">\r\n								<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n									<tbody>\r\n										<tr>\r\n											<td style=\"padding:20px 0 30px; text-align:center; font-size:13px; color:#999;\">{website_name} Inc.\r\n												<!--\r\n												if these emails get annoying, please feel free to  <a href=\"#\" style=\"text-decoration:underline; color:#666;\">unsubscribe</a>.\r\n												-->\r\n												</td>\r\n										</tr>\r\n									</tbody>\r\n								</table></td>\r\n						</tr>\r\n						<tr>\r\n							<td style=\"padding:0; height:50px;\"></td>\r\n						</tr>\r\n					</tbody>\r\n				</table>\r\n				<!--\r\n				page footer end here\r\n				-->\r\n				   </td>\r\n		</tr>\r\n	</tbody>\r\n</table>' WHERE `tbl_email_templates`.`etpl_code` = 'buyer_notification_review_status_updated';


DELETE FROM `tbl_language_labels` WHERE `label_key` = 'Lbl_Have_You_Used_This_Product';
DELETE FROM `tbl_language_labels` WHERE `label_key` = 'LBL_Forgot_Password';
DELETE FROM `tbl_language_labels` WHERE `label_key` = 'LBL_Not_Register_Yet';