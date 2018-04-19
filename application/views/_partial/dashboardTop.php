<?php  if((User::canViewSupplierTab() && User::canViewBuyerTab()) || (User::canViewSupplierTab() && User::canViewAdvertiserTab()) || (User::canViewBuyerTab() && User::canViewAdvertiserTab())){ ?>
	<div class="dashboard-switch hide--desktop no-print">
		<div class="mobile-switch">
			<?php if( User::canViewSupplierTab() ){ ?>
				<a <?php if($activeTab == 'S'){ echo 'class="is-active"';}?> href="<?php echo CommonHelper::generateUrl('Seller'); ?>"><?php echo Labels::getLabel('Lbl_Seller',$siteLangId);?></a>
			<?php }?>
			<?php if( User::canViewBuyerTab() ){ ?>			
			<a <?php if($activeTab == 'B'){ echo 'class="is-active"';}?> href="<?php echo CommonHelper::generateUrl('Buyer'); ?>"><?php echo Labels::getLabel('Lbl_Buyer',$siteLangId);?></a>
			<?php }?>
			<?php if( User::canViewAdvertiserTab() ){ ?>			
			<a <?php if($activeTab == 'Ad'){ echo 'class="is-active"';}?> href="<?php echo CommonHelper::generateUrl('Advertiser'); ?>"><?php echo Labels::getLabel('Lbl_Advertiser',$siteLangId);?></a>
			<?php }?>
		</div>
	</div>
<?php } ?>
<?php 
/* echo $str = '<script type="text/javascript">
		var langLbl = ' . json_encode(
			$jsVariables 
		) . ';
	</script>' . "\r\n"; */
?>