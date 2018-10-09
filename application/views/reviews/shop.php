<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$shop_city = $shop['shop_city'];
$shop_state = ( strlen($shop['shop_city']) > 0 ) ? ', '. $shop['shop_state_name'] : $shop['shop_state_name'];
$shop_country = ( strlen($shop_state) > 0 ) ? ', '.$shop['shop_country_name'] : $shop['shop_country_name'];
$shopLocation = $shop_city . $shop_state. $shop_country;
?>

<div id="body" class="body bg--gray">
    <div class="section section--pagebar">
      <div class="container container--fixed">
        <div class="row">
          <div class="col-md-8">
            <div class="cell">
             <!-- <div class="cell__left">
                <div class="avtar"><img alt="" src="images/150x150_4.jpg"></div>
              </div>-->
              <div class="cell__right">
                <div class="avtar__info">
                  <h5><?php echo $shop['shop_name']; ?></h5>
                  <p><?php echo $shopLocation; ?> <?php echo Labels::getLabel('LBL_Opened_on', $siteLangId); ?> <?php echo FatDate::format($shop['shop_created_on']); ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 align--right"><span class="gap"></span><a href="<?php echo CommonHelper::generateUrl('Shops','view',array($shop['shop_id'])); ?>" class="btn btn--primary"><?php echo Labels::getLabel('Lbl_Back_to_Shop',$siteLangId); ?></a></div>
        </div>
      </div>
    </div>
	<section class="top-space">
      <div class="container container--fixed">
        <div class="">
          <div class="panel panel--centered clearfix">
            <div class="">
              <div id="itemRatings" class="section section--info clearfix">
                <div class="section__head">
                  <h4><?php echo Labels::getLabel('Lbl_Reviews_of',$siteLangId).' '. $shop['shop_name'];?></h4>
				   <?php echo $frmReviewSearch->getFormHtml(); ?>
                </div>
                <div class="section__body">
					<div class="box box--white">
						<?php $this->includeTemplate('_partial/shop-reviews.php',array('reviews'=>$reviews,'siteLangId'=>$siteLangId,'shop_id'=>$shop['shop_id']),false); ?>
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
