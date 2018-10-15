<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearchCustomProduct->setFormTagAttribute( 'onsubmit', 'searchCustomProducts(this); return(false);' );
$frmSearchCustomProduct->setFormTagAttribute('class', 'form');
$frmSearchCustomProduct->developerTags['colClassPrefix'] = 'col-md-';
$frmSearchCustomProduct->developerTags['fld_default_col'] = 12;

$keyFld = $frmSearchCustomProduct->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->setWrapperAttribute('class','col-sm-6');
$keyFld->developerTags['col'] = 8;

$submitBtnFld = $frmSearchCustomProduct->getField('btn_submit');
$submitBtnFld->value=Labels::getLabel('LBL_Search',$siteLangId);
$submitBtnFld->setFieldTagAttribute('class','btn--block');
$submitBtnFld->setWrapperAttribute('class','col-sm-3');
$submitBtnFld->developerTags['col'] = 2;

$cancelBtnFld = $frmSearchCustomProduct->getField('btn_clear');
$cancelBtnFld->value=Labels::getLabel("LBL_Clear", $siteLangId);
$cancelBtnFld->setFieldTagAttribute('class','btn--block');
$cancelBtnFld->setWrapperAttribute('class','col-sm-3');
$cancelBtnFld->developerTags['col'] = 2;
?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
		<div class="container">
			<div class="row">
                <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full " >
					<div class="cols--group">
						<div class="panel__head">
						   <h2><?php echo Labels::getLabel('LBL_My_Product',$siteLangId); ?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head box__head--large">
								   <h4><?php echo Labels::getLabel('LBL_My_Products_list',$siteLangId); ?></h4>
									<div class="group--btns">
										<a href="javascript:void(0)" onclick="addCatalogPopup()" class = "btn btn--primary btn--sm"><?php echo Labels::getLabel( 'LBL_Add_New_Product', $siteLangId);?></a><a href="<?php echo CommonHelper::generateUrl('seller','catalog' );?>" class="btn btn--secondary btn--sm"><?php echo Labels::getLabel('LBL_Products_List', $siteLangId);?></a>
									</div>
								</div>
								<div class="box__body">
									<div class="form__cover nopadding--bottom">
                                        <?php echo $frmSearchCustomProduct->getFormHtml(); ?>
									</div>
									<span class="gap"></span>
									<?php echo $frmSearchCustomProduct->getExternalJS();?>
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
