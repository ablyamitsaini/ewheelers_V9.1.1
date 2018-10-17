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
delete FROM `tbl_configurations` WHERE `conf_name` = 'conf_yokart_version'