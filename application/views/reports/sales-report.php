<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit','searchSalesReport(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form');
$frmSrch->developerTags['colClassPrefix'] = 'col-lg-4 col-md-4 col-sm-';
$frmSrch->developerTags['fld_default_col'] = 4;
?>

<div id="body" class="body bg--gray">
  <section class="dashboard">
    <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
    <div class="container">
      <div class="row">
        <?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
        <div class="col-xs-10 panel__right--full ">
          <div class="cols--group">
            <div class="panel__head">
              <h2><?php echo Labels::getLabel('LBL_Sales_Report',$siteLangId);?></h2>
            </div>
            <div class="panel__body">
              <div class="box box--white box--space">
                <div class="box__head">
                  <h4><?php echo Labels::getLabel('LBL_Sales_Report',$siteLangId);?></h4>
				  <div class="group--btns panel__head_action"> <?php echo '<a href="javascript:void(0)" onClick="exportSalesReport()" class="btn btn--secondary btn--sm">'.Labels::getLabel('LBL_Export',$siteLangId).'</a>'; ?></div>
                </div>
                <div class="box__body">
                  <div class="grids--profile">
					<?php if(empty($orderDate)){ ?>
                    <div class="form__cover nopadding--bottom"> <?php echo $frmSrch->getFormHtml(); ?> </div>
					<?php  }else{ echo  $frmSrch->getFormHtml(); } ?>
                    <div class="grid" >
                      <div class="row">
                        <div class="col-md-12" id="listingDiv"> <?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?> </div>
                      </div>
                    </div>
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
