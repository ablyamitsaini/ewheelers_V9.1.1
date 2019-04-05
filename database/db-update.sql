UPDATE `tbl_banner_locations` SET `blocation_key` = 'Home_Page_Top_Banner', `blocation_identifier` = 'Home page top banner', `blocation_banner_count` = '1' WHERE `tbl_banner_locations`.`blocation_id` = 1;
UPDATE `tbl_banner_locations` SET `blocation_key` = 'Home_Page_Bottom_Banner', `blocation_identifier` = 'home page bottom banner' WHERE `tbl_banner_locations`.`blocation_id` = 2;
TRUNCATE tbl_banner_location_dimensions;
INSERT INTO `tbl_banner_location_dimensions` (`bldimension_blocation_id`, `bldimension_device_type`, `blocation_banner_width`, `blocation_banner_height`) VALUES
(1, 1, '1200', '360'),
(1, 2, '1200', '360'),
(1, 3, '1200', '360'),
(2, 1, '1200', '360'),
(2, 2, '1200', '360'),
(2, 3, '1200', '360'),
(3, 1, '1200', '360'),
(3, 2, '1200', '360'),
(3, 3, '1200', '360');
UPDATE `tbl_theme_colors` SET `tcolor_header_text_color`= '323232';

UPDATE `tbl_email_templates` SET `etpl_replacements` = '{website_name} Name of the website<br /> {username} Username of the person registered<br /> {email} Email Address of the person registered<br /> {name} Name of the person registered<br /> {user_type} Type of the User registered<br /> {social_media_icons} <br> {contact_us_url} <br> ' WHERE `tbl_email_templates`.`etpl_code` = 'new_registration_admin' AND `tbl_email_templates`.`etpl_lang_id` = 1;

UPDATE `tbl_email_templates` SET `etpl_body` = '<div style="margin:0; padding:0;background: #ecf0f1;">
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
									<h2 style="margin:0; font-size:34px; padding:0;">New Account Created!</h2></td>
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
												<td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear Admin </strong><br />
													We have received a new registration on <a href="{website_url}">{website_name}</a>. Please find the details below:</td>
											</tr>
											<tr>
												<td style="padding:20px 0 30px;">
													<table style="border:1px solid #ddd; border-collapse:collapse;" cellspacing="0" cellpadding="0" border="0">
														<tbody>
															<tr>
																<td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Username</td>
																<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{username}</td>
															</tr>                                                        
															<tr>
																<td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Email<span class="Apple-tab-span" style="white-space:pre"></span></td>
																<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{email}</td>
															</tr>                                                        
															<tr>
																<td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Name</td>
																<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{name}</td>
															</tr>  
                                                            
															<tr>
																<td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Type</td>
																<td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{user_type}</td>
															</tr>                                                        
														</tbody>
													</table></td>
											</tr>
											<!--
											section footer
											-->
											   
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
	</table></div>' WHERE `tbl_email_templates`.`etpl_code` = 'new_registration_admin' AND `tbl_email_templates`.`etpl_lang_id` = 1;
    
    ALTER TABLE `tbl_products` ADD `product_image_updated_on` TIMESTAMP NOT NULL AFTER `product_added_on`;
