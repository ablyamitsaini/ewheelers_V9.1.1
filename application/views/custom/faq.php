<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
	<section class="top-space bg--white">
	  <div class="container">
		<div class="breadcrumb">
		  <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
		</div>
		<div class="row">
		  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div id="listing"></div>
		  </div>
		  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="heading3"><?php echo Labels::getLabel( 'LBL_Browse_By_Category', $siteLangId)?></div>
			<div class="row">
				<div id="categoryPanel"></div>
			</div> 
		  </div>
		</div>
		<div class="divider"></div>
		<div class="align--center">
		  <div class="heading3"><?php echo Labels::getLabel( 'LBL_Still_need_help', $siteLangId)?> ?</div>
		  <a href="<?php echo CommonHelper::generateUrl('custom' , 'contact-us'); ?>" class="btn btn--secondary btn--lg ripplelink" ><?php echo Labels::getLabel( 'LBL_Contact_Customer_Care', $siteLangId)?> </a>
		</div>
		<div class="gap"></div>
	  </div>
	</section>

	<!-- <div class="container container--fixed">
	   <div class="row">
		   <div class="container container--fluid">
			  
			   <div class="panel panel--grids panel--grids-even">
				   <div class="grid__left fixed__panel">
					  <div id="fixed__panel">
						   <div class="box box--white" id="categoryPanel">
						   </div>
					   </div>
				   </div>
					<div class="grid__right">
					   <h2><?php echo Labels::getLabel('Lbl_Frequently_Asked_Questions',$siteLangId); ?></h2>
					   <ul class="breadcrumb clearfix">
						   <li><a href="<?php echo CONF_WEBROOT_URL; ?>"><?php echo Labels::getLabel('Lbl_Home',$siteLangId); ?></a></li>
						   <li><?php echo Labels::getLabel('Lbl_Frequently_Asked_Questions',$siteLangId); ?></li>
					   </ul>
					   <?php if(!empty($cpages)){ ?>
					   <div class="grid grid--onefourth">
						   <h4>For Immediate Self-help</h4>
						   <?php if(!empty($cpages)){ ?>
							<ul>
							<?php foreach($cpages as $cpage){ ?>
							   <li><a href="<?php echo CommonHelper::generateUrl('Cms' , 'view' ,array($cpage['cpage_id'])); ?>" class="btn btn--secondary btn--block"><?php echo $cpage['cpage_identifier']; ?></a></li>
							   <?php } ?>
						   </ul>
						   <?php } ?>
						   
					   </div>
					   <?php } ?>
						<div class="container--faqs">
						   <?php
							$frm->setFormTagAttribute('id','frmSearchFaqs');
							$frm->setFormTagAttribute('onSubmit','searchFaqs(this);return false;');
							$frm->getField('question')->setFieldTagAttribute('placeholder',Labels::getLabel('Lbl_Search_within',$siteLangId));
							echo $frm->getFormTag(); ?>
							   <label class="field_label"><?php echo Labels::getLabel('Lbl_Enter_Your_Question',$siteLangId); ?></label>
								<div class="search search--sort">
									<div class="search__field">
									<?php echo $frm->getFieldHtml('question') , $frm->getFieldHtml('btn_submit'); ?>
										 
										<i class="fa fa-search"></i>
									</div>
								</div>
							</form>
							<?php echo $frm->getExternalJs(); ?>
							<div id="listing"></div>
							<span class="gap"></span>
						</div>
					</div>
			   </div>
				
			</div>
		</div>
	</div> -->

	<div class="gap"></div>
</div>
<script>
var $linkMoreText = '<?php echo Labels::getLabel('Lbl_SHOW_MORE',$siteLangId); ?>';
var $linkLessText = '<?php echo Labels::getLabel('Lbl_SHOW_LESS',$siteLangId); ?>';
</script>
