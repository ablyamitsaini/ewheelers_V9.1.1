<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="box__head ">
   <h4><?php echo Labels::getLabel('LBL_Product_Listing',$siteLangId); ?></h4>									
</div>
<div class="box__body">	
	<div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
		<?php require_once('sellerCatalogProductTop.php');?>
	</div>
	<div class="tabs__content form">
		
		<div class="form__content">
			<div class="col-md-12">
				<div class="container container--fluid">
					<div class="tabs--inline tabs--scroll clearfix">
						<ul>
							<li><a href="javascript:void(0)" onClick="sellerProductForm(<?php echo $product_id,',',$selprod_id ?>)" ><?php echo Labels::getLabel('LBL_Basic',$siteLangId); ?></a></li>
							<?php	
							foreach($language as $langId => $langName){?>	
							<li class="<?php echo ($formLangId == $langId)?'is-active':'' ; ?>"><a href="javascript:void(0)" onClick="sellerProductLangForm(<?php echo $langId;?>,<?php echo $selprod_id;?>)">
							<?php echo $langName;?></a></li>
							<?php }?>
							<li><a href="javascript:void(0)" onClick="linkPoliciesForm(<?php echo $product_id,',',$selprod_id,',',PolicyPoint::PPOINT_TYPE_WARRANTY ; ?>)"><?php echo Labels::getLabel('LBL_Link_Warranty_Policies',$siteLangId); ?></a></li>
							<li><a href="javascript:void(0)" onClick="linkPoliciesForm(<?php echo $product_id,',',$selprod_id,',',PolicyPoint::PPOINT_TYPE_RETURN ; ?>)"><?php echo Labels::getLabel('LBL_Link_Return_Policies',$siteLangId); ?></a></li>
						</ul>
					</div>
				</div>
				<div class="form__subcontent">
					<?php
					$frmSellerProdLangFrm->setFormTagAttribute('onsubmit','setUpSellerProductLang(this); return(false);');
					$frmSellerProdLangFrm->setFormTagAttribute('class','form form--horizontal layout--'.$formLayout);
					$frmSellerProdLangFrm->developerTags['colClassPrefix'] = 'col-lg-8 col-md-8 col-sm-';
					$frmSellerProdLangFrm->developerTags['fld_default_col'] = 8;
					//$selprod_return_policy_fld = $frmSellerProdLangFrm->getField('selprod_return_policy');
					
					//$selprod_features_fld = $frmSellerProdLangFrm->getField('selprod_features');
					
					$newLineTxt = Labels::getLabel('LBL_Enter_Data_Separated_By_New_Line.', $siteLangId );			
				//	$returnPolicyTxt = Labels::getLabel('LBL_Product_Return_Policy_text',$siteLangId);
					//$selprod_features_fld->htmlAfterField = '<span class="text--small">'. $newLineTxt .'</span>';
					//$selprod_return_policy_fld->htmlAfterField  = '<span class="text--small">'. $newLineTxt .' '. $returnPolicyTxt .'</span>';
					
					echo $frmSellerProdLangFrm->getFormHtml(); ?>
				</div>	
			</div>	
		</div>	
		
	</div>
</div>