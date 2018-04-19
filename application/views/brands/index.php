<?php defined('SYSTEM_INIT') or die('Invalid Usage.');  ?>

<div id="body" class="body bg--gray">
  <section class="dashboard">
    <div class="fixed-container">
      <div class="breadcrumb">
		<?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
      </div>
      <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="panel panel--centered">
          <h3><?php echo Labels::getLabel('LBL_All_Top_Brands',$siteLangId);?></h3>
          <div class="cell-container">
            <div class="panel panel--centered">
				<?php /* CommonHelper::printArray($allBrands); die; */ if(!empty($allBrands)){ $firstCharacter = '';
						foreach($allBrands as $brands){
						
						/* if($layoutDirection == 'rtl'){
							$str = substr(strtolower($brands['brand_name']), -1);
						}else{
							$str = substr(strtolower($brands['brand_name']), 0, 1);
						} */
						$str = substr(strtolower($brands['brand_name']), 0, 1);
						
						if(is_numeric($str)){
							$str = '0-9';
						}			
						
						if($str != $firstCharacter){
							if($firstCharacter!=''){ echo "</ul></div>"; }
							$firstCharacter = $str;
				?>
              <div class="listingbox">
                <h5><?php echo $firstCharacter;?></h5>
                <ul class="listing--onefifth">
                  <?php } ?>
                  <li><a href="<?php echo CommonHelper::generateUrl('Brands','view',array($brands['brand_id']));?>"><?php echo $brands['brand_name'];?></a></li>
                  <?php } ?>
                </ul>
              </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
	<div class="gap"></div>
</div>
