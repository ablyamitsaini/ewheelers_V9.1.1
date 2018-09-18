<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearchCustomCatalogProducts->setFormTagAttribute ( 'onSubmit', 'searchCustomCatalogProducts(this); return(false);' );

$frmSearchCustomCatalogProducts->setFormTagAttribute('class', 'form');
$frmSearchCustomCatalogProducts->developerTags['colClassPrefix'] = 'col-md-';
$frmSearchCustomCatalogProducts->developerTags['fld_default_col'] = 12;

$keyFld = $frmSearchCustomCatalogProducts->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->setWrapperAttribute('class','col-sm-6');
$keyFld->developerTags['col'] = 8;

$submitBtnFld = $frmSearchCustomCatalogProducts->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-sm-3');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmSearchCustomCatalogProducts->getField('btn_clear');
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
						<div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_Requested_Products',$siteLangId); ?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head box__head--large">
								   <h4><?php echo Labels::getLabel('LBL_Search_Products',$siteLangId); ?></h4>
									<div class="group--btns panel__head_action">
									<?php if( User::canAddCustomProductAvailableToAllSellers() ){?>
										<a href="<?php echo CommonHelper::generateUrl('Seller','customCatalogProductForm');?>" class="btn btn--primary btn--sm"><?php echo Labels::getLabel( 'LBL_Request_New_Product', $siteLangId);?></a>
									<?php }?>
									</div>
								</div>
								<div class="box__body">
									<div class="form__cover nopadding--bottom">
                                        <?php echo $frmSearchCustomCatalogProducts->getFormHtml(); ?>
									</div>
									<span class="gap"></span>
									<?php echo $frmSearchCustomCatalogProducts->getExternalJS();?>
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
