<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$contactFrm->setFormTagAttribute('class', 'form form--normal');
	$captchaFld = $contactFrm->getField('htmlNote');
	$captchaFld->htmlBeforeField = '<div class="field-set">
		   <div class="caption-wraper"><label class="field_label"></label></div>
		   <div class="field-wraper">
			   <div class="field_cover">';
	$captchaFld->htmlAfterField = '</div></div></div>';

	$contactFrm->setFormTagAttribute('action', CommonHelper::generateUrl('Custom', 'contactSubmit'));
	$contactFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
	$contactFrm->developerTags['fld_default_col'] = 12;
?>


		<div id="body" class="body" role="main">
			<section class="bg-contact" style="background-image:url(/images/startup-photos.jpg);"></section>
			<section class="contact-wrapper">
				<div class="container">
					<div class="section-head section--white--head section--head--center">
						<div class="section__heading">
							<h2>Get in Touch</h2>
						</div>
					</div>
					<div class="contact-box">
						<div class="row">
							<div class="col-md-4">
								<div class="info-cell contact-pic "> <img src="images/pexels-photo.jpeg" alt=""></div>
								<div class="contact-address info-cell">
									<div class="info-cell-inner"><i class="icn">
											<svg class="svg draw">
												<use xlink:href="images/retina/sprite.svg#address" href="images/retina/sprite.svg#address"></use>
											</svg>
										</i>
										<h3>Address</h3>
										<p>Ably soft Pvt. Ltd<br>
											Plot No. 268, JLPL Industrial Area<br>
											Sector 82<br>
											Mohali, Punjab </p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="section-head section--head--center mt-4 mb-4">
									<div class="section__heading">
										<h2>Contact Us</h2>
										<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor </p>
									</div>
								</div>
								<form class="form form--contact">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="field-set">
												<div class="field-wraper">
													<div class="field_cover"><input placeholder="Your Name" type="text" value=""></div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="field-set">

												<div class="field-wraper">
													<div class="field_cover"><input placeholder="Your Email" type="text" value=""></div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="field-set">

												<div class="field-wraper">
													<div class="field_cover"><input placeholder="Your Phone" type="text" value=""></div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="field-set">

												<div class="field-wraper">
													<div class="field_cover"><textarea data-field-caption="Your Message" data-fatreq="{&quot;required&quot;:true}" name="message"></textarea></div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="field-set">
												<div class="caption-wraper"><label class="field_label"></label></div>
												<div class="field-wraper">
													<div class="field_cover">
														<div class="g-recaptcha" data-sitekey="6LeqqlEUAAAAALi8ZunXfHby_9YVAhX6xRoda1H2">
															<div style="width: 304px; height: 78px;">
																<div><iframe src="https://www.google.com/recaptcha/api2/anchor?ar=1&amp;k=6LeqqlEUAAAAALi8ZunXfHby_9YVAhX6xRoda1H2&amp;co=aHR0cDovL3lva2FydC12OC0xLmR6cGF3YW4uNGRlbW8uYml6Ojgw&amp;hl=en&amp;v=v1550471573786&amp;size=normal&amp;cb=pi6ujd4tgn2l" role="presentation" name="a-1b9g5ccnpexd" scrolling="no" sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-top-navigation allow-modals allow-popups-to-escape-sandbox allow-storage-access-by-user-activation" width="304" height="78" frameborder="0"></iframe></div><textarea id="g-recaptcha-response" name="g-recaptcha-response" class="g-recaptcha-response" style="width: 250px; height: 40px; border: 1px solid rgb(193, 193, 193); margin: 10px 25px; padding: 0px; resize: none; display: none;"></textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="field-set">
												<div class="caption-wraper"><label class="field_label"></label></div>
												<div class="field-wraper">
													<div class="field_cover"><input data-fatreq="{&quot;required&quot;:false}" type="submit" name="btn_submit" value="Submit" class="btn--block"></div>
												</div>
											</div>
										</div>
									</div>
								</form>

							</div>

							<div class="col-md-4">
								<div class="contact-phones info-cell">
									<div class="info-cell-inner">
										<i class="icn">
											<svg class="svg draw">
												<use xlink:href="images/retina/sprite.svg#phones" href="images/retina/sprite.svg#phones"></use>
											</svg>
										</i>
										<h3>Phones</h3>
										<p>Toll Free 1800-272-172</p>
										<p>Local 1800-272-172</p>
									</div>
								</div>
								<div class="contact-email info-cell">
									<div class="info-cell-inner">
										<i class="icn">
											<svg class="svg draw">
												<use xlink:href="images/retina/sprite.svg#email" href="images/retina/sprite.svg#email"></use>
											</svg>
										</i>
										<h3>email</h3>
										<p><a href="mailto:contact.us@dummyid.com">contact.us@dummyid.com</a> </p>
										<p><a href="mailto:contact.us@dummyid.com">contact.us@dummyid.com</a> </p>
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
<div id="body" class="body">
  <section class="">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="heading3"><?php echo Labels::getLabel('LBL_Contact_Us',$siteLangId);?></div>
        </div>
      </div>
      <div class="row layout--grids">
        <div class="col-md-8">
          <div class="box box--white box--space"> <?php echo $contactFrm->getFormHtml(); ?> </div>
        </div>
        <div class="col-md-4">
          <div class="boxcontainer">
            <div class="box--gray"> <i class="fa fa-phone"></i>
              <h3><?php echo FatApp::getConfig('CONF_SITE_PHONE',FatUtility::VAR_STRING,'');?></h3>
              <p><?php echo Labels::getLabel('LBL_24_a_day_7_days_week',$siteLangId);?></p>
            </div>
			<?php if(FatApp::getConfig('CONF_SITE_FAX',FatUtility::VAR_STRING,'') != '') {?>
			<div class="box--gray"> <i class="fa fa-fax"></i>
              <h3><?php echo FatApp::getConfig('CONF_SITE_FAX',FatUtility::VAR_STRING,'');?></h3>
              <p><?php echo Labels::getLabel('LBL_24_a_day_7_days_week',$siteLangId);?></p>
            </div>
			<?php }?>
            <div class="box--gray"> <i class="fa fa-briefcase"></i>
              <h3><?php echo Labels::getLabel('LBL_Office',$siteLangId);?></h3>
              <?php echo nl2br(FatApp::getConfig('CONF_ADDRESS_'.$siteLangId,FatUtility::VAR_STRING,''));?> </div>
          </div>
          <?php echo FatUtility::decodeHtmlEntities( nl2br($pageData['epage_content']) );?> </div>
      </div>
    </div>
  </section>
  <div class="gap"></div>
</div>
<script src='https://www.google.com/recaptcha/api.js'></script>
