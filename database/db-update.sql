ALTER TABLE `tbl_product_categories` ADD `prodcat_code` VARCHAR(255) NOT NULL AFTER `prodcat_deleted`;

ALTER TABLE `tbl_banner_locations` DROP `blocation_banner_width`, DROP `blocation_banner_height`;

CREATE TABLE `tbl_banner_location_dimensions` (
  `bldimension_blocation_id` int(11) NOT NULL,
  `bldimension_device_type` int(11) NOT NULL,
  `blocation_banner_width` decimal(10,0) NOT NULL,
  `blocation_banner_height` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tbl_banner_location_dimensions` (`bldimension_blocation_id`, `bldimension_device_type`, `blocation_banner_width`, `blocation_banner_height`) VALUES
(1, 1, '960', '400'),
(1, 2, '1024', '360'),
(1, 3, '760', '360'),
(2, 1, '1920', '400'),
(2, 2, '1024', '360'),
(2, 3, '760', '360'),
(3, 1, '310', '460'),
(3, 2, '310', '460'),
(3, 3, '310', '460');

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('guest_welcome_registration', '1', 'Welcome Mail on Registration', 'Welcome to {website_name}', '<div style="margin:0; padding:0;background: #ecf0f1;">
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
									<h4 style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">Congratulations</h4>
									<h2 style="margin:0; font-size:34px; padding:0;">Account Created!</h2></td>
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
												<td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {name} </strong><br />
													Your email has been registered. Next time you shop with us, log in for faster checkout at <a href="{website_url}">{website_name}</a>.</td>
											</tr>
											<tr>
												<td style="padding:20px 0 30px;">We are thrilled to have you aboard! You have taken a great first step and we are so excited to connect directly with you.</td>
											</tr>
											<tr>
												<td style="padding:0 0 30px;">If you require any assistance in using our site, or have any feedback or suggestions, you can email us at {contact_us_email}</td>
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
	</table></div>', '{name} Name of the signed up user.<br>
{email} Email Address of the signed up user.<br>
{username} Username of the signed up User <br/>
{contact_us_email} - Contact Us Email Address<br/>
{website_name} Name of our website<br>
{social_media_icons} <br>
{contact_us_url} <br>
', '1');
delete FROM `tbl_configurations` WHERE `conf_name` = 'conf_yokart_version';
ALTER TABLE `tbl_languages` CHANGE `language_code` `language_code` VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

INSERT INTO `tbl_extra_pages` (`epage_id`, `epage_identifier`, `epage_type`, `epage_active`, `epage_default`) VALUES ('27', 'Checkout page header block', '27', '1', '');

INSERT INTO `tbl_extra_pages_lang` (`epagelang_epage_id`, `epagelang_lang_id`, `epage_label`, `epage_content`) VALUES ('27', '1', 'Checkout page header block', '<ul class="trust-banners">          
	<li><i class="svg-icn"> 
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="22.852px" height="27.422px" viewbox="0 0 22.852 27.422" enable-background="new 0 0 22.852 27.422" xml:space="preserve">            
				<path fill="none" d="M19.424,14.854c0,2.589-2.285,4.928-4.195,6.428c-1.429,1.124-2.893,1.963-3.803,2.445V3.428h7.998V14.854z M22.852,1.143C22.852,0.518,22.334,0,21.709,0H1.143C0.518,0,0,0.518,0,1.143v13.711c0,7.516,10.516,12.266,10.962,12.461 c0.143,0.072,0.303,0.107,0.464,0.107c0.16,0,0.321-0.035,0.464-0.107c0.446-0.195,10.962-4.945,10.962-12.461V1.143z"></path>            </svg> </i>            
		<p>Secure Payments</p>          </li>          
	<li><i class="svg-icn"> 
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="36.566px" height="29.707px" viewbox="0 0 36.566 29.707" enable-background="new 0 0 36.566 29.707" xml:space="preserve">            
				<path fill="none" d="M3.787,11.426h5.766l5.356,11.872L3.787,11.426z M18.283,25.209l-6.23-13.783h12.461L18.283,25.209z M9.606,9.141H3.43l5.142-6.855h4.678L9.606,9.141z M21.657,23.298l5.356-11.872h5.766L21.657,23.298z M12.195,9.141l3.642-6.855 h4.892l3.643,6.855H12.195z M26.96,9.141l-3.643-6.855h4.678l5.142,6.855H26.96z M29.477,0.465C29.263,0.16,28.924,0,28.566,0H8 C7.643,0,7.304,0.16,7.09,0.465L0.234,9.605c-0.34,0.428-0.304,1.053,0.071,1.463L17.444,29.35c0.214,0.232,0.518,0.357,0.839,0.357 s0.625-0.125,0.839-0.357l17.139-18.281c0.375-0.41,0.411-1.035,0.071-1.463L29.477,0.465z"></path>            </svg> </i>            
		<p>Authentic Products</p>          </li>          
	<li><i class="svg-icn"> 
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="27.422px" height="27.422px" viewbox="0 0 27.422 27.422" enable-background="new 0 0 27.422 27.422" xml:space="preserve">            
				<path fill="none" d="M15.996,7.427c0-0.321-0.25-0.571-0.571-0.571h-1.143c-0.321,0-0.571,0.25-0.571,0.571v6.284H9.712 c-0.321,0-0.571,0.25-0.571,0.571v1.143c0,0.321,0.25,0.571,0.571,0.571h5.713c0.321,0,0.571-0.25,0.571-0.571V7.427z M23.423,13.711c0,5.355-4.356,9.712-9.712,9.712s-9.712-4.356-9.712-9.712s4.356-9.712,9.712-9.712S23.423,8.355,23.423,13.711z M27.422,13.711C27.422,6.142,21.28,0,13.711,0S0,6.142,0,13.711c0,7.57,6.142,13.711,13.711,13.711S27.422,21.281,27.422,13.711z"></path>            </svg> </i>            
		<p>24x7 Customer Support</p>          </li>          
	<li><i class="svg-icn"> 
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="30.85px" height="25.137px" viewbox="0 0 30.85 25.137" enable-background="new 0 0 30.85 25.137" xml:space="preserve">            
				<path fill="none" d="M10.283,20.566c0,1.25-1.035,2.285-2.285,2.285s-2.285-1.035-2.285-2.285c0-1.25,1.035-2.285,2.285-2.285 S10.283,19.317,10.283,20.566z M3.428,11.426V10.89c0-0.071,0.107-0.339,0.16-0.393l3.481-3.481 c0.054-0.053,0.321-0.161,0.394-0.161h2.82v4.57H3.428z M26.279,20.566c0,1.25-1.035,2.285-2.285,2.285s-2.285-1.035-2.285-2.285 c0-1.25,1.035-2.285,2.285-2.285S26.279,19.317,26.279,20.566z M30.85,1.143C30.85,0.518,30.332,0,29.707,0H11.426 c-0.625,0-1.143,0.518-1.143,1.143V4.57H7.427c-0.643,0-1.5,0.357-1.946,0.804L1.946,8.909c-0.982,0.982-0.804,2.392-0.804,3.66 v5.713C0.518,18.281,0,18.799,0,19.424c0,1.321,1.393,1.143,2.285,1.143h1.143c0,2.518,2.053,4.57,4.57,4.57s4.57-2.053,4.57-4.57 h6.855c0,2.518,2.053,4.57,4.57,4.57s4.57-2.053,4.57-4.57c0.893,0,2.285,0.179,2.285-1.143V1.143z"></path>            </svg> </i>            
		<p>Fast Delivery</p>          </li>        
</ul>');