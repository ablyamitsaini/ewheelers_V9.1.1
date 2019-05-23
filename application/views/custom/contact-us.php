<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$contactFrm->setFormTagAttribute('class', 'form form--contact ml-2 mr-2');
	$contactFrm->setFormTagAttribute('action', CommonHelper::generateUrl('Custom', 'contactSubmit'));
	$contactFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
	$contactFrm->developerTags['fld_default_col'] = 12;
    $fldSubmit = $contactFrm->getField('btn_submit');
	$fldSubmit->addFieldTagAttribute('class','btn--block');
?>

<div id="body" class="body" role="main">
	<section class="section bg-contact">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-9">
					<div class="section-head section--white--head">
						<div class="section__heading">
							<h2>Get In Touch</h2>
							<p>Want to get in touch? We'd love to hear from you.<br>
								Here's how you can reach us...</p>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
	<section class="section">
		<div class="container">
		<div class="row justify-content-center">
				<div class="col-md-9">
				
			<div class="row">
				<div class="col-md-8">
					<form name="frmContact" method="post" id="frm_fat_id_frmContact" class="form form--normal" action="/custom/contact-submit">
						<div class="row">
							<div class="col-md-6">
								<div class="field-set">
									<div class="caption-wraper"><label class="field_label">First Name<span class="spn_must_field">*</span></label></div>
									<div class="field-wraper">
										<div class="field_cover"><input data-field-caption="Your Name" data-fatreq="{&quot;required&quot;:true}" type="text" name="name" value=""></div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="field-set">
									<div class="caption-wraper"><label class="field_label">Last Name<span class="spn_must_field">*</span></label></div>
									<div class="field-wraper">
										<div class="field_cover"><input data-field-caption="Your Name" data-fatreq="{&quot;required&quot;:true}" type="text" name="name" value=""></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="field-set">
									<div class="caption-wraper"><label class="field_label">Your Email<span class="spn_must_field">*</span></label></div>
									<div class="field-wraper">
										<div class="field_cover"><input data-field-caption="Your Email" data-fatreq="{&quot;required&quot;:true,&quot;email&quot;:true}" type="text" name="email" value=""></div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="field-set">
									<div class="caption-wraper"><label class="field_label">Your Phone<span class="spn_must_field">*</span></label></div>
									<div class="field-wraper">
										<div class="field_cover"><input data-field-caption="Your Phone" data-fatreq="{&quot;required&quot;:true,&quot;user_regex&quot;:&quot;^[\\s()+-]*([0-9][\\s()+-]*){5,20}$&quot;}" type="text" name="phone" value=""></div>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="field-set">
									<div class="caption-wraper"><label class="field_label">Your Message<span class="spn_must_field">*</span></label></div>
									<div class="field-wraper">
										<div class="field_cover"><textarea data-field-caption="Your Message" data-fatreq="{&quot;required&quot;:true}" name="message"></textarea></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row align-items-center">
							<div class="col">
								<div class="field-set">
									<div class="caption-wraper"><label class="field_label"></label></div>
									<div class="field-wraper">
										<div class="field_cover">
											<div class="g-recaptcha" data-sitekey="6LdP4QkUAAAAAFyYtQtBgU6usXihtJzAA69V4Rx6">
												<div>
													<div><iframe src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LdP4QkUAAAAAFyYtQtBgU6usXihtJzAA69V4Rx6&amp;co=aHR0cHM6Ly92OC5kZW1vLnlvLWthcnQuY29tOjQ0Mw..&amp;hl=en&amp;v=v1557729121476&amp;size=normal&amp;cb=106hazcs3cih" role="presentation" name="a-nf996dwdwxt" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" width="304" height="78" frameborder="0"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-auto">
								<div class="field-set">
									<div class="caption-wraper"><label class="field_label"></label></div>
									<div class="field-wraper">
										<div class="field_cover"><input data-field-caption="" data-fatreq="{&quot;required&quot;:false}" type="submit" name="btn_submit" value="Submit"></div>
									</div>
								</div>
							</div>
						</div>

					</form>
				</div>
				<div class="col-md-4">
					<div class="bg-gray rounded p-4">

						<h6>General Inquiry </h6>
						<p class="small">1800-272-172 <br>24 A Day, 7 Days Week</p>
						<div class="gap"></div>
						<div class="divider"></div>
						<div class="gap"></div>
						<h6>Fax </h6>h6>
						<p class="small">333-222-111 <br>24 A Day, 7 Days Week</p>

						<div class="gap"></div>
						<div class="divider"></div>
						<div class="gap"></div>
						<h6>Address</h6>
						<p class="small">Ably soft Pvt. Ltd<br>
							Plot No. 268, JLPL Industrial Area<br>
							Sector 82 Mohali, Punjab</p>

<div class="gap"></div>
						<div class="social">
							<ul class="">
								<li>
									<a class="fb" href="#"><img src="<?php echo CONF_WEBROOT_URL;?>images/social-fb.png"></a>
								</li>
								<li>
									<a class="twtr" href="#"><img src="<?php echo CONF_WEBROOT_URL;?>images/social-tw.png"></a>
								</li>
								<li>
									<a class="g-pls" href="#"><img src="<?php echo CONF_WEBROOT_URL;?>images/social-gp.png"></a>
								</li>
								<li>
									<a class="linkdn" href="#"><img src="<?php echo CONF_WEBROOT_URL;?>images/social-in.png"></a>
								</li>
							</ul>
						</div>

					</div>
				</div>
			</div>
			</div>
			</div>
		</div>
	</section>
	<section class="g-map">

				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3432.2445633768834!2d76.72417851512965!3d30.6552410816642!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390feef5b90fc51b%3A0x7541e61fcad7e6c4!2sAbly+Soft+Pvt.+Ltd.!5e0!3m2!1sen!2sin!4v1551782633079" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
			</section>

</div>
<script src='https://www.google.com/recaptcha/api.js'></script>