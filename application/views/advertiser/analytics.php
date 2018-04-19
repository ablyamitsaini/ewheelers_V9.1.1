<div id="body" class="body bg--gray">
  <div class="section section--pagebar">
      <div class="fixed-container container--fixed">
        <h4><?php echo Labels::getLabel('Lbl_Advertiser' , $siteLangId); ?></h4>
      </div>
    </div>
  <section class="dashboard">
    <?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
    <div class="fixed-container">
      <div class="row">
        <?php $this->includeTemplate('_partial/advertiser/advertiserDashboardNavigation.php'); ?>
        <div class="col-md-10 panel__right--full" >
          <div class="cols--group">
               <div class="panel__head">
				   <h2><?php echo Labels::getLabel('LBL_Promotion_Analytics',$siteLangId);?></h2>				 
				</div>
				<div class="panel__body">
			   <div class="box box--white box--space">
                  <div class="box__head">
                    <h4><?php echo ucfirst($promotionDetails['promotion_name']);?></h4>
					<div class="group--btns">						
						<a href="<?php echo CommonHelper::generateUrl('advertiser','promotions');?>" class="btn btn--primary btn--sm"><?php echo Labels::getLabel('LBL_My_promotions',$siteLangId);?></a>
					</div>
                  </div>
                  <div class="box__body">
					<div class="form__cover nopadding--bottom">
					<?php 
						$searchForm->setFormTagAttribute('class', 'form');
						$searchForm->setFormTagAttribute('onsubmit', 'searchAnalytics(this); return false;');
						$searchForm->developerTags['colClassPrefix'] = 'col-md-';
						$searchForm->developerTags['fld_default_col'] = 4;
						$fldSubmit = $searchForm->getField('btn_submit');
						
						$submitBtnFld = $searchForm->getField('btn_submit');
						$submitBtnFld->setFieldTagAttribute('class','btn--block');
						$submitBtnFld->setWrapperAttribute('class','col-sm-6 ');
						$submitBtnFld->developerTags['col'] = 2;

						$cancelBtnFld = $searchForm->getField('btn_clear');
						$cancelBtnFld->setFieldTagAttribute('class','btn--block');
						$cancelBtnFld->setWrapperAttribute('class','col-sm-6 ');
						$cancelBtnFld->developerTags['col'] = 2;
					echo $searchForm->getFormHTML();?>
					</div>
					<div id="ppcListing"></div>
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