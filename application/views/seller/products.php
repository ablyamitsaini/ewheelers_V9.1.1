<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute ( 'onSubmit', 'sellerProducts(); return(false);' );

$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 12;

$keyFld = $frmSearch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->setWrapperAttribute('class','col-sm-6');
$keyFld->developerTags['col'] = 8;

$submitBtnFld = $frmSearch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-sm-3');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmSearch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class','btn--block');
$cancelBtnFld->setWrapperAttribute('class','col-sm-3');
$cancelBtnFld->developerTags['col'] = 2;
?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
		<div class="fixed-container">
			<div class="row">
                <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full " >
					<div class="cols--group">
						<?php $this->includeTemplate('_partial/productPagesTabs.php',array('siteLangId'=>$siteLangId,'controllerName'=>$controllerName,'action'=>$action),false); ?>
						<div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_Store_Inventory',$siteLangId); ?></h2>
							<div class="delivery-term">
								<div class="dropdown"> 
									<a href="#inventoryToolTip" rel="facebox"> <i class="fa fa-question-circle"></i></a>
									<div id="inventoryToolTip" style="display:none">
										<div class="delivery-term-data-inner">
											<ol class="list-nested">
												<li>This tab lists all the products available to your front end store.</li>
												<li>For each product variant, separate copy need to be created by seller either from Marketplace product tab or clone product icon.</li>
												<li>To add new product to your store inventory, seller will have to pick the products from the marketplace products tabs from "Add to Store" button</li>
											</ol>
										</div>
									</div>
								</div>
							</div>						   
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head box__head--large">
								   <h4><?php echo Labels::getLabel('LBL_Search_your_inventory',$siteLangId); ?></h4>
									<div class="group--btns">
										<!--<a href="javascript:void(0)" onclick="addCatalogPopup()" class = "btn btn--primary btn--sm"><?php /* echo Labels::getLabel( 'LBL_Add_New_Product', $siteLangId); */?></a>-->
										<?php if( User::canAddCustomProduct() ){ ?>
											<a href="<?php echo commonHelper::generateUrl('seller','catalog');?>" class = "btn btn--primary btn--sm"><?php echo Labels::getLabel( 'LBL_Products_list', $siteLangId);?></a>
										<?php } ?>
									</div>
								</div>
								<div class="box__body">
									<div class="form__cover nopadding--bottom">
                                        <?php echo $frmSearch->getFormHtml(); ?>
									</div>
									<span class="gap"></span>
									<?php echo $frmSearch->getExternalJS();?>
									<div id="listing">
										<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
									</div>
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
<?php echo FatUtility::createHiddenFormFromData ( array('product_id'=>$product_id), array ('name' => 'frmSearchSellerProducts') );?>

<script>
jQuery(document).ready(function($) {
	$('a[rel*=facebox]').facebox() 
});
</script>
