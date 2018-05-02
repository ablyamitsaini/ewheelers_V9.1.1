<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="row">
			<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>                      
			   <div class="col-md-10 panel__right--full " >
					<div class="cols--group">
						<div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_Shop_Details',$siteLangId); ?></h2>							   
						</div>
						<div class="panel__body">							
							<div class="box box--white box--space"> 
								<div class="box__head">
								   <h5><?php echo Labels::getLabel('LBL_Shop_Setup',$siteLangId); ?></h5>
								</div>
								<div class="box__body" id="shopFormBlock"> 
									<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
								</div>
							</div>
						</div>
					</div>
			   </div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
<script>
$(document).ready(function(){
<?php if($tab==USER::RETURN_ADDRESS_ACCOUNT_TAB && !$subTab){?>
returnAddressForm();
<?php } elseif($subTab){?>
	returnAddressLangForm(<?php echo $subTab;?>);
	<?php
	
} else{
	?>
	shopForm();
<?php }?>
	
});
</script>