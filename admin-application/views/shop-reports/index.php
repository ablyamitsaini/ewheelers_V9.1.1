<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<script>
var shopId = '<?php echo $shopId; ?>';
</script>
<div class="row">
	<div class="col-sm-12"> 
		<h1><?php echo Labels::getLabel('LBL_Manage_Shop_Reports',$adminLangId); ?> </h1>
	</div>
	<div class="col-sm-12"> 		
		<section class="section">
		<div class="sectionhead">
			<h4><?php echo Labels::getLabel('LBL_Shop_Reports_Listing',$adminLangId); ?></h4>
			<a href="<?php echo CommonHelper::generateUrl('Shops'); ?>" class="themebtn btn-default btn-sm"><?php echo Labels::getLabel('LBL_Back_to_Shops',$adminLangId); ?></a>			
		</div>
		<div class="sectionbody">
			<div class="tablewrap" >
				<div id="listing"> <?php echo Labels::getLabel('LBL_Processing...',$adminLangId); ?></div>
			</div> 
		</div>
		</section>
	</div>		
</div>