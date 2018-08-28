 ALTER TABLE `tbl_user_cart` ADD `usercart_added_date` DATETIME NOT NULL AFTER `usercart_details`; 
 ALTER TABLE `tbl_user_cart` ADD `usercart_sent_reminder` INT NOT NULL AFTER `usercart_added_date`; 

 ALTER TABLE `tbl_user_wish_list_products` ADD `uwlp_sent_reminder` INT NOT NULL AFTER `uwlp_added_on`, ADD `uwlp_reminder_date` DATETIME NOT NULL AFTER `uwlp_sent_reminder`; 
  
 ALTER TABLE `tbl_user_cart` ADD `usercart_reminder_date` DATETIME NOT NULL AFTER `usercart_sent_reminder`; 


 INSERT INTO `tbl_cron_schedules` (`cron_id`, `cron_name`, `cron_command`, `cron_duration`, `cron_active`) VALUES (9, 'Remind Buyer For Products In Cart', 'Cronjob/remindBuyerForProductsInCart', '1440', '1'); 
 INSERT INTO `tbl_cron_schedules` (`cron_id`, `cron_name`, `cron_command`, `cron_duration`, `cron_active`) VALUES (10, 'Remind Buyer For Products In Wishlist', 'Cronjob/remindBuyerForProductsInWishlist', '1440', '1'); 


 INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('reminder_for_items_in_cart', '1', 'Reminder for items in Cart', 'Reminder for items in Cart', 'Reminder for items in Cart', '', '1'); 

 INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('reminder_for_items_in_wishlist', '1', 'Reminder for items in wishlist', 'Reminder for items in wishlist', 'Reminder for items in wishlist', '', '1'); 
 
 
 ALTER TABLE `tbl_users` DROP `user_app_access_token`;
 
 ALTER TABLE `tbl_user_auth_token` ADD `uauth_fcm_id` VARCHAR(300) NOT NULL AFTER `uauth_token`;
 ALTER TABLE `tbl_users` DROP `user_push_notification_api_token`;
 
 
 INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('failed_login_attempt', '1', 'Failed Login Attempt', 'Failed Login Attempt', '<div style="margin:0; padding:0;background: #ecf0f1;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ecf0f1" style="font-family:Arial; color:#333; line-height:26px;">
		<tbody>
			<tr>
				<td style="background:#ff3a59;padding:30px 0 10px;">
					<!--
					header start here
					-->
					 					 
					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td><a href="{website_url}">{Company_Logo}</a></td>
								<td style="text-align:right;">{social_media_icons}</td>
							</tr>
						</tbody>
					</table>
					<!--
					header end here
					-->
					 </td>
			</tr>
			<tr>
				<td style="background:#ff3a59;">
					<!--
					page title start here
					-->
					 					 
					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="background:#fff;padding:20px 0 10px; text-align:center;">
									<h4 style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;"></h4>
									<h2 style="margin:0; font-size:34px; padding:0;"><a href="http://yokart-v8-1.staging.4demo.biz/admin/%7Bwebsite_url%7D" style="font-family: Arial; text-align: center; background-color: rgb(255, 255, 255);"></a><a href="http://yokart-v8-1.staging.4demo.biz/admin/%7Bwebsite_url%7D" style="font-family: Arial; text-align: center; background-color: rgb(255, 255, 255);">{website_name}</a></h2></td>
							</tr>
						</tbody>
					</table>
					<!--
					page title end here
					-->
					 </td>
			</tr>
			<tr>
				<td>
					<!--
					page body start here
					-->
					 					 
					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td style="padding:20px 0;"><strong style="font-size:18px;color:#333;">Dear {user_full_name} </strong><br />
													Are you facing problem logging in?</td>                                          
											</tr>
											<tr>
												<td style="padding:0px 0px 20px;">
													<p>You seem to be facing problem logging in at <a href="{website_url}">{website_name}</a><br />
														Please note that your username and password are both case sensitive.<br />
														You can use forgot password feature if you have lost your password.<br />
														If you were not trying logging in, it might be a hacking attempt.<br />
														Also, you should keep your email password secured.<br />
														</p></td>
											</tr>
											<!--
											section footer
											-->
											   
											<tr>
												<td style="padding:30px 0;border-top:1px solid #ddd; ">Get in touch if you have any questions regarding our Services.<br />
													Feel free to contact us 24/7. We are here to help.<br />
													<br />
													All the best,<br />
													The {website_name} Team<br />
													</td>
											</tr>
											<!--
											section footer
											-->
											   
										</tbody>
									</table></td>
							</tr>
						</tbody>
					</table>
					<!--
					page body end here
					-->
					 </td>
			</tr>
			<tr>
				<td>
					<!--
					page footer start here
					-->
					 					 
					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="height:30px;"></td>
							</tr>
							<tr>
								<td style="background:rgba(0,0,0,0.04);padding:0 30px; text-align:center; color:#999;vertical-align:top;">
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td style="padding:30px 0; font-size:20px; color:#000;">Need more help?<br />
													 <a href="{contact_us_url}" style="color:#ff3a59;">Weâ€˜re here, ready to talk</a></td>
											</tr>
										</tbody>
									</table></td>
							</tr>
							<tr>
								<td style="padding:0; color:#999;vertical-align:top; line-height:20px;">
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td style="padding:20px 0 30px; text-align:center; font-size:13px; color:#999;"><br />
													<br />
													{website_name} Inc. 
													<!--
													if these emails get annoying, please feel free to  <a href="#" style="text-decoration:underline; color:#666;">unsubscribe</a>.
													-->
													 </td>
											</tr>
										</tbody>
									</table></td>
							</tr>
							<tr>
								<td style="padding:0; height:50px;"></td>
							</tr>
						</tbody>
					</table>
					<!--
					page footer end here
					-->
					 </td>
			</tr>
		</tbody>
	</table></div>', '', '1');
	
	ALTER TABLE `tbl_shops` ADD `shop_free_ship_upto` INT NOT NULL AFTER `shop_updated_on`;
	
	ALTER TABLE `tbl_order_products` ADD `op_free_ship_upto` INT NOT NULL AFTER `op_selprod_download_validity_in_days`, ADD `op_actual_shipping_charges` FLOAT NOT NULL AFTER `op_free_ship_upto`;


CREATE TABLE `tbl_unique_check_failed_attempt` (
  `ucfattempt_ip` varchar(50) CHARACTER SET utf8 NOT NULL,
  `ucfattempt_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `tbl_product_saved_search`
--

CREATE TABLE `tbl_product_saved_search` (
  `pssearch_id` int(11) NOT NULL,
  `pssearch_user_id` int(11) NOT NULL,
  `pssearch_name` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `pssearch_type` int(11) NOT NULL,
  `pssearch_record_id` int(11) NOT NULL,
  `pssearch_url` text CHARACTER SET utf8mb4 NOT NULL,
  `pssearch_added_on` datetime NOT NULL,
  `pssearch_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_product_saved_search`
--
ALTER TABLE `tbl_product_saved_search`
  ADD PRIMARY KEY (`pssearch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_product_saved_search`
--
ALTER TABLE `tbl_product_saved_search`
  MODIFY `pssearch_id` int(11) NOT NULL AUTO_INCREMENT;
  
  
  
CREATE TABLE `tbl_user_requests_history` (
  `ureq_id` int(11) NOT NULL,
  `ureq_user_id` int(11) NOT NULL,
  `ureq_type` tinyint(4) NOT NULL,
  `ureq_purpose` varchar(500) NOT NULL,
  `ureq_status` tinyint(4) NOT NULL,
  `ureq_date` datetime NOT NULL,
  `ureq_approved_date` datetime NOT NULL,
  `ureq_deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `tbl_user_requests_history`
	ADD PRIMARY KEY (`ureq_id`);

ALTER TABLE `tbl_user_requests_history`
	MODIFY `ureq_id` int(11) NOT NULL AUTO_INCREMENT;

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES('data_request_notification_to_admin', 1, 'Data request notification to admin', 'Request Data', '<div style="margin:0; padding:0;background: #ecf0f1;">\r\n	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ecf0f1" style="font-family:Arial; color:#333; line-height:26px;">\r\n		<tbody>\r\n			<tr>\r\n				<td style="background:#ff3a59;padding:30px 0 10px;">\r\n					<!--\r\n					header start here\r\n					-->\r\n					   \r\n					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">\r\n						<tbody>\r\n							<tr>\r\n								<td><a href="{website_url}">{Company_Logo}</a></td>\r\n								<td style="text-align:right;">{social_media_icons}</td>\r\n							</tr>\r\n						</tbody>\r\n					</table>\r\n					<!--\r\n					header end here\r\n					-->\r\n					   </td>\r\n			</tr>\r\n			<tr>\r\n				<td style="background:#ff3a59;">\r\n					<!--\r\n					page title start here\r\n					-->\r\n					   \r\n					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">\r\n						<tbody>\r\n							<tr>\r\n								<td style="background:#fff;padding:20px 0 10px; text-align:center;">\r\n									<h4 style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">Updated</h4>\r\n									<h2 style="margin:0; font-size:34px; padding:0;">Data Request</h2></td>\r\n							</tr>\r\n						</tbody>\r\n					</table>\r\n					<!--\r\n					page title end here\r\n					-->\r\n					   </td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					<!--\r\n					page body start here\r\n					-->\r\n					   \r\n					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">\r\n						<tbody>\r\n							<tr>\r\n								<td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">\r\n									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">\r\n										<tbody>\r\n											<tr>\r\n												<td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear Admin</strong><br />\r\n													\r\n													<div>Data request has been placed by {user_full_name}</div>\r\n													<div>Phone Number: {user_phone}</div>\r\n													<div>Username: {username}</div>\r\n													<div>Purpose of request:</div>\r\n													<div><span style="color: rgb(153, 153, 153); font-family: Arial; text-align: center; background-color: rgb(255, 255, 255);">{ureq_purpose}</span><br />\r\n														</div></td>\r\n											</tr>\r\n											<tr>\r\n												<!--\r\n												section footer\r\n												-->\r\n												   \r\n											</tr>\r\n											<tr>\r\n												<td style="padding:30px 0;border-top:1px solid #ddd; ">Get in touch in you have any questions regarding our Services.<br />\r\n													Feel free to contact us 24/7. We are here to help.<br />\r\n													<br />\r\n													All the best,<br />\r\n													The {website_name} Team<br />\r\n													</td>\r\n											</tr>\r\n											<!--\r\n											section footer\r\n											-->\r\n											   \r\n										</tbody>\r\n									</table></td>\r\n							</tr>\r\n						</tbody>\r\n					</table>\r\n					<!--\r\n					page body end here\r\n					-->\r\n					   </td>\r\n			</tr>\r\n			<tr>\r\n				<td>\r\n					<!--\r\n					page footer start here\r\n					-->\r\n					   \r\n					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">\r\n						<tbody>\r\n							<tr>\r\n								<td style="height:30px;"></td>\r\n							</tr>\r\n							<tr>\r\n								<td style="background:rgba(0,0,0,0.04);padding:0 30px; text-align:center; color:#999;vertical-align:top;">\r\n									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">\r\n										<tbody>\r\n											<tr>\r\n												<td style="padding:30px 0; font-size:20px; color:#000;">Need more help?<br />\r\n													 <a href="{contact_us_url}" style="color:#ff3a59;">Weâ€˜re here, ready to talk</a></td>\r\n											</tr>\r\n										</tbody>\r\n									</table></td>\r\n							</tr>\r\n							<tr>\r\n								<td style="padding:0; color:#999;vertical-align:top; line-height:20px;">\r\n									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">\r\n										<tbody>\r\n											<tr>\r\n												<td style="padding:20px 0 30px; text-align:center; font-size:13px; color:#999;">{website_name} Inc.\r\n													<!--\r\n													if these emails get annoying, please feel free to  <a href="#" style="text-decoration:underline; color:#666;">unsubscribe</a>.\r\n													-->\r\n													</td>\r\n											</tr>\r\n										</tbody>\r\n									</table></td>\r\n							</tr>\r\n							<tr>\r\n								<td style="padding:0; height:50px;"></td>\r\n							</tr>\r\n						</tbody>\r\n					</table>\r\n					<!--\r\n					page footer end here\r\n					-->\r\n					   </td>\r\n			</tr>\r\n		</tbody>\r\n	</table></div>', '{user_full_name} Full User name\r\n{username} Username\r\n{user_phone} User phone Number\r\n{ureq_purpose} Request Purpose', 1);

ALTER TABLE `tbl_user_favourite_products` CHANGE `ufp_product_id` `ufp_selprod_id` INT(11) NOT NULL;

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('gdpr_request_status_update_notification_to_user', '1', 'GDPR request status update notification to user', 'GDPR Request Status Updated', '<div style="margin:0; padding:0;background: #ecf0f1;">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#ecf0f1" style="font-family:Arial; color:#333; line-height:26px;">
		<tbody>
			<tr>
				<td style="background:#ff3a59;padding:30px 0 10px;">
					<!--
					header start here
					-->
					   
					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td><a href="{website_url}">{Company_Logo}</a></td>
								<td style="text-align:right;">{social_media_icons}</td>
							</tr>
						</tbody>
					</table>
					<!--
					header end here
					-->
					   </td>
			</tr>
			<tr>
				<td style="background:#ff3a59;">
					<!--
					page title start here
					-->
					   
					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="background:#fff;padding:20px 0 10px; text-align:center;">
									<h4 style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">Updated</h4>
									<h2 style="margin:0; font-size:34px; padding:0;">Request Status Update</h2></td>
							</tr>
						</tbody>
					</table>
					<!--
					page title end here
					-->
					   </td>
			</tr>
			<tr>
				<td>
					<!--
					page body start here
					-->
					   
					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear <span style="color: rgb(153, 153, 153); font-family: Arial; text-align: center; background-color: rgb(255, 255, 255);">{username}</span></strong>
													<div>Your Request for {request_type} has been completed.</div></td>
											</tr>
											<tr>
												<!--
												section footer
												-->
												   
											</tr>
											<tr>
												<td style="padding:30px 0;border-top:1px solid #ddd; ">Get in touch in you have any questions regarding our Services.<br />
													Feel free to contact us 24/7. We are here to help.<br />
													<br />
													All the best,<br />
													The {website_name} Team<br />
													</td>
											</tr>
											<!--
											section footer
											-->
											   
										</tbody>
									</table></td>
							</tr>
						</tbody>
					</table>
					<!--
					page body end here
					-->
					   </td>
			</tr>
			<tr>
				<td>
					<!--
					page footer start here
					-->
					   
					<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td style="height:30px;"></td>
							</tr>
							<tr>
								<td style="background:rgba(0,0,0,0.04);padding:0 30px; text-align:center; color:#999;vertical-align:top;">
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td style="padding:30px 0; font-size:20px; color:#000;">Need more help?<br />
													 <a href="{contact_us_url}" style="color:#ff3a59;">Weâ€˜re here, ready to talk</a></td>
											</tr>
										</tbody>
									</table></td>
							</tr>
							<tr>
								<td style="padding:0; color:#999;vertical-align:top; line-height:20px;">
									<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
										<tbody>
											<tr>
												<td style="padding:20px 0 30px; text-align:center; font-size:13px; color:#999;">{website_name} Inc.
													<!--
													if these emails get annoying, please feel free to  <a href="#" style="text-decoration:underline; color:#666;">unsubscribe</a>.
													-->
													</td>
											</tr>
										</tbody>
									</table></td>
							</tr>
							<tr>
								<td style="padding:0; height:50px;"></td>
							</tr>
						</tbody>
					</table>
					<!--
					page footer end here
					-->
					   </td>
			</tr>
		</tbody>
	</table></div>', '{username} Username
{request_type} Request Type', '1');

ALTER TABLE `tbl_user_requests_history` CHANGE `ureq_purpose` `ureq_purpose` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_product_settings`
--

CREATE TABLE `tbl_order_product_settings` (
  `opsetting_op_id` int(11) NOT NULL,
  `op_commission_include_tax` tinyint(1) NOT NULL,
  `op_commission_include_shipping` tinyint(1) NOT NULL,
  `op_tax_collected_by_seller` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_order_product_settings`
--
ALTER TABLE `tbl_order_product_settings`
  ADD UNIQUE KEY `opsetting_op_id` (`opsetting_op_id`);