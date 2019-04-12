<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frmSearch->setFormTagAttribute( 'id', 'frmSearchTaxCat' );
    $frmSearch->setFormTagAttribute( 'onsubmit', 'searchTaxCategories(this); return(false);' );

    $frmSearch->setFormTagAttribute('class', 'form');
    $frmSearch->developerTags['colClassPrefix'] = 'col-md-';
    $frmSearch->developerTags['fld_default_col'] = 12;

    $keyFld = $frmSearch->getField('keyword');
    $keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
    $keyFld->setWrapperAttribute('class','col-lg-8');
    $keyFld->developerTags['col'] = 8;

    $submitBtnFld = $frmSearch->getField('btn_submit');
    $submitBtnFld->setFieldTagAttribute('class','btn--block');
    $submitBtnFld->setWrapperAttribute('class','col-lg-2');
    $submitBtnFld->developerTags['col'] = 2;

    $cancelBtnFld = $frmSearch->getField('btn_clear');
    $cancelBtnFld->setFieldTagAttribute('class','btn--block');
    $cancelBtnFld->setWrapperAttribute('class','col-lg-2');
    $cancelBtnFld->developerTags['col'] = 2;
?>


<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header  row justify-content-between mb-3">
		<div class="col-md-auto">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Tax_Categories',$siteLangId); ?></h2>
		</div>
	</div>
	<div class="content-body">
		<div class="cards">
			<div class="cards-header p-3">
				<h5 class="cards-title "><?php echo Labels::getLabel('LBL_Manage_Tax_Rates',$siteLangId); ?></h5>
			</div>
			<div class="cards-content p-3">
                <div class="bg-gray-light p-3 pb-0">
                  <?php echo $frmSearch->getFormHtml(); ?>
                </div>
                <span class="gap"></span>
                 <?php echo $frmSearch->getExternalJS();?>
                <div id="listing"><?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?></div>
			</div>
		</div>
	</div>
  </div>
</main>
