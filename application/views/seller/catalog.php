<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
		<div class="fixed-container">
			<div class="row">
                <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full " >
					<div class="cols--group">
						<div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_Product_Listing',$siteLangId); ?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head">
								   <h4><?php echo Labels::getLabel('LBL_Search_Products',$siteLangId); ?></h4>
								   <div class="group--btns panel__head_action">
								   <div class="-inline-element" id="tour-step-2" ><a href="javascript:void(0)" onclick="addCatalogPopup()" class = "btn btn--primary btn--sm"><?php echo Labels::getLabel( 'LBL_Add_New_Product', $siteLangId);?></a></div>
								   <!--<a href="<?php /* echo CommonHelper::generateUrl('seller','products');?>" class="btn btn--primary btn--sm "><?php echo Labels::getLabel( 'LBL_My_Inventory', $siteLangId) */?></a>-->

								   <?php if((isset($canAddCustomProduct) && $canAddCustomProduct==false) && (isset($canRequestProduct) && $canRequestProduct === true )){?>
										<a href="<?php echo CommonHelper::generateUrl('Seller','requestedCatalog');?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Request_A_Product',$siteLangId);?></a>
								   <?php } ?>
								</div>
								</div>
								<div class="box__body">
									<div class="form__cover nopadding--bottom">
                                    	<?php
										$frmSearchCatalogProduct->setFormTagAttribute ( 'id', 'frmSearchCatalogProduct' );
										$frmSearchCatalogProduct->setFormTagAttribute ( 'class', 'form' );
										$frmSearchCatalogProduct->setFormTagAttribute( 'onsubmit', 'searchCatalogProducts(this); return(false);' );
										$frmSearchCatalogProduct->getField('keyword')->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search_by_keyword/EAN/ISBN/UPC_code',$siteLangId));
										$frmSearchCatalogProduct->developerTags['colClassPrefix'] = 'col-md-';
										$frmSearchCatalogProduct->developerTags['fld_default_col'] = 12;
										$fldSubmit= $frmSearchCatalogProduct->getField('btn_submit');
										$fldSubmit->setFieldTagAttribute('class','btn--block');

										$keywordFld = $frmSearchCatalogProduct->getField('keyword');
										$keywordFld->setFieldTagAttribute('id','tour-step-3');
										$keywordFld->developerTags['col'] = 12;


										if( FatApp::getConfig('CONF_ENABLED_SELLER_CUSTOM_PRODUCT') ){
											$dateFromFld = $frmSearchCatalogProduct->getField('type');
											$dateFromFld->setFieldTagAttribute('class','');
											$dateFromFld->setWrapperAttribute('class','col-lg-4 col-md-4 col-sm-4 col-xs-12');
											$dateFromFld->developerTags['col'] = 3;
										}
										$typeFld = $frmSearchCatalogProduct->getField('product_type');
										$typeFld->setWrapperAttribute('class','col-lg-4 col-md-4 col-sm-4 col-xs-12');
										$typeFld->developerTags['col'] = 3;

										$submitFld = $frmSearchCatalogProduct->getField('btn_submit');
										$submitFld->setFieldTagAttribute('class','btn--block');
										$submitFld->setWrapperAttribute('class','col-lg-2 col-md-2 col-sm-2 col-xs-12');
										$submitFld->developerTags['col'] = 3;

										$fldClear= $frmSearchCatalogProduct->getField('btn_clear');
										$fldClear->setFieldTagAttribute('onclick','clearSearch()');
										$fldClear->setFieldTagAttribute('class','btn--block');
										$fldClear->setWrapperAttribute('class','col-lg-2 col-md-2 col-sm-2 col-xs-12');
										$fldClear->developerTags['col'] = 3;
										/* if( User::canAddCustomProductAvailableToAllSellers() ){
											$submitFld = $frmSearchCatalogProduct->getField('btn_submit');
											$submitFld->setFieldTagAttribute('class','btn--block');
											$submitFld->developerTags['col'] = 4;
										} */
										echo $frmSearchCatalogProduct->getFormHtml();
										?>
									</div>
									<span class="gap"></span>
									<div id="listing"> </div>  <span class="gap"></span>
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
	<?php if(!$displayDefaultListing){?>
	searchCatalogProducts(document.frmSearchCatalogProduct);
	<?php }?>
});

$(".btn-inline-js").click(function(){
    $(".box-slide-js").slideToggle();
});
</script>
