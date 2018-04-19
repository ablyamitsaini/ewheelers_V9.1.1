<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body">
	<section class="top-space bg--white">
	  <div class="fixed-container">
		<div class="breadcrumb">
		  <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
		</div>
		<div class="row">
		  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div id="listing"></div>
		  </div>
		  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="heading3"><?php echo Labels::getLabel( 'LBL_Few_More_Questions', $siteLangId)?></div>
			<div id="categoryPanel"></div>
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
	<div class="gap"></div>
</div>
<script>
var faqcatId = '<?php echo $faqCatId ?>';
var faqId = '<?php echo $faqId ?>';
</script>
