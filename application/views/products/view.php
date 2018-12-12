<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

//echo '<pre>';var_dump($this->variables); echo'</pre>'; die;
$buyQuantity = $frmBuyProduct->getField('quantity');
$buyQuantity->addFieldTagAttribute('class','qty');
/* CommonHelper::printArray($product); die; */

?>

<div id="body" class="body bg--gray">
<section>
  <div class="container">
    <div class="breadcrumb">
      <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
    </div>
    <div class="white--bg padding20">
      <div class="row">
        <div class="col-lg-5 col-md-6 col-sm-6 col-xm-12 details__body clearfix">
          <div id="img-static"  class="img-sticky80">
            <div class="product-gallery ">
              <?php $data['product'] = $product;
				$data['productImagesArr'] = $productImagesArr;
				$data['imageGallery'] = true;
				/* $this->includeTemplate('products/product-gallery.php',$data,false); */
			   ?>
				<div class="slider-for" dir="<?php echo CommonHelper::getLayoutDirection();?>" id="slider-for">
				<?php if( $productImagesArr ){ ?>
				  <?php
					foreach( $productImagesArr as $afile_id => $image ){
					$originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
					$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
					$thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
				  ?>
				  <img class="xzoom" id="xzoom-default" src="<?php echo $mainImgUrl; ?>" xoriginal="<?php echo $originalImgUrl; ?>">
				<?php break; }?>
				<?php } else {
					$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'MEDIUM', 0 ) ), CONF_IMG_CACHE_TIME, '.jpg');
					$originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array(0, 'ORIGINAL', 0 ) ), CONF_IMG_CACHE_TIME, '.jpg');?>
				  <img class="xzoom" src="<?php echo $mainImgUrl; ?>" xoriginal="<?php echo $originalImgUrl; ?>">
				  <?php } ?>
				</div>
				<?php if( $productImagesArr ){ ?>
					<div class="slider-nav xzoom-thumbs" dir="<?php echo CommonHelper::getLayoutDirection();?>" id="slider-nav">
						<?php foreach( $productImagesArr as $afile_id => $image ){
							$originalImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'ORIGINAL', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
							$mainImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');
							/* $thumbImgUrl = FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id']) ), CONF_IMG_CACHE_TIME, '.jpg'); */
						?>
						<div class="thumb"><a href="<?php echo $originalImgUrl; ?>"><img class="xzoom-gallery" width="80" src="<?php echo $mainImgUrl; ?>"></a></div>
					  <?php } ?>
					</div>
				<?php } ?>
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-6 col-sm-6 col-xm-12">
          <div class="product-detail">
            <div class="item-yk detail_head ">
              <?php $firstToReview=true; include(CONF_THEME_PATH.'_partial/product-listing-head-section.php'); ?>
              <?php include(CONF_THEME_PATH.'_partial/collection-ui.php');?>
              <div class="product_price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?>
                <?php if($product['special_price_found']){ ?>
                <span class="product_price_old"> <?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span>
                <div class="product_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></div>
                <?php } ?>
              </div>
			  <?php if($shop['shop_free_ship_upto'] > 0){
					$freeShipAmt = CommonHelper::displayMoneyFormat($shop['shop_free_ship_upto']);
				?>
				<div class="note-messages"><?php echo str_replace('{amount}',$freeShipAmt,Labels::getLabel('LBL_Free_shipping_up_to_{amount}_purchase',$siteLangId));?></div>
			<?php }?>
              <?php if( count($productSpecifications)>0 ){
												 ?>
              <div class="gap"></div>
              <div class="heading3"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?>:</div>
              <div class="bullet-list">
                <ul>
                  <?php $count=1;
						foreach($productSpecifications as $key => $specification){
							if($count>5) continue;
							?>
                  <li><?php echo $specification['prodspec_name']." : ".$specification['prodspec_value']; ?></li>
                  <?php $count++;  } ?>
                  <?php if(count($productSpecifications)>5) { ?>
                  <li class="link_li"><a href="javascript:void()"  ><?php echo Labels::getLabel('LBL_View_All_Details', $siteLangId); ?></a></li>
                  <?php } ?>
                </ul>
              </div>
              <?php } ?>
              <div class="divider"></div>
              <?php if( !empty($optionRows) ){

				$selectedOptionsArr = $product['selectedOptionValues'];

				foreach($optionRows as $option){ ?>
              <div class="heading3"><?php echo $option['option_name']; ?>:</div>
              <div class="<?php echo ($option['option_is_color']) ? 'select-color' : 'select-size'; ?>">
                <?php if($option['values']){ ?>
                <ul>
                  <?php foreach( $option['values'] as $opVal ){
						$isAvailable = true;
						if(in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])){
							$optionUrl = CommonHelper::generateUrl('Products','view',array($product['selprod_id']));
						} else {
						$optionUrl = Product::generateProductOptionsUrl($product['selprod_id'], $selectedOptionsArr, $option['option_id'], $opVal['optionvalue_id'], $product['product_id']);
							$optionUrlArr = explode("::", $optionUrl);
							if( is_array($optionUrlArr) && count($optionUrlArr) == 2 ){
								$optionUrl = $optionUrlArr[0];
								$isAvailable = false;
							}
						}
					?>
                  <li class="<?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' is--active' : ' '; echo (!$optionUrl) ? ' is-disabled' : ''; echo (!$isAvailable) ? 'not--available':'';?>">
                    <?php   if($option['option_is_color'] && $opVal['optionvalue_color_code'] != '' ){ ?>
                    <a  optionValueId="<?php echo $opVal['optionvalue_id']; ?>" selectedOptionValues = "<?php echo implode("_",$selectedOptionsArr); ?>" title="<?php echo $opVal['optionvalue_name']; echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available',$siteLangId) : ''; ?>" class="<?php echo (!$option['option_is_color']) ? 'selector__link' : ''; echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' ' : ' '; echo (!$optionUrl) ? ' is-disabled' : '';  ?>" href="<?php echo ($optionUrl) ? $optionUrl : 'javascript:void(0)'; ?>"> <span style="background-color:#<?php echo $opVal['optionvalue_color_code']; ?>;"></span></a>
                    <?php   } else{ ?>
                    <a optionValueId="<?php echo $opVal['optionvalue_id']; ?>" selectedOptionValues = "<?php echo implode("_",$selectedOptionsArr); ?>" title="<?php echo $opVal['optionvalue_name']; echo (!$isAvailable) ? ' '.Labels::getLabel('LBL_Not_Available',$siteLangId) : ''; ?>" class="<?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? '' : ' '; echo (!$optionUrl) ? ' is-disabled' : '' ?>" href="<?php echo ($optionUrl) ? $optionUrl : 'javascript:void(0)'; ?>"> <?php echo $opVal['optionvalue_name'];  ?> </a>
                    <?php } ?>
                  </li>
                  <?php } ?>
                </ul>
                <?php } ?>
              </div>
              <?php }
				}	 ?>
              <?php /* Volume Discounts[ */
				if( isset($volumeDiscountRows) && !empty($volumeDiscountRows) ){
					//$product['theprice']
				?>
              <div class="gap"></div>
              <div class="form__group form__group--qty">
                <label class="field_label"><?php echo Labels::getLabel('LBL_Wholesale_Price_(Piece)',$siteLangId);?>:</label>
                <div class="selector-container">
                  <ul class="selector selector--qty selector--qty-js">
                    <?php foreach($volumeDiscountRows as $volumeDiscountRow ){
							$volumeDiscount = $product['theprice'] * ( $volumeDiscountRow['voldiscount_percentage'] / 100 );
							$price = ($product['theprice'] - $volumeDiscount);
					?>
					<li>
					  <div class="qty__value"><?php echo ($volumeDiscountRow['voldiscount_min_qty']); ?> <?php echo Labels::getLabel('LBL_Or_more',$siteLangId);?> (<?php echo $volumeDiscountRow['voldiscount_percentage'].'%';?>) <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($price); ?> / <?php echo Labels::getLabel('LBL_Product',$siteLangId);?></span><span class="item__price--old"><?php echo CommonHelper::displayMoneyFormat($product['theprice']);?></span></div>
					</li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
				<script type="text/javascript">
					$("document").ready(function(){
						$('.selector--qty-js').slick( getSlickSliderSettings(3,1,langLbl.layoutDirection) );
					});
				</script>
              <?php } /* ] */ ?>
              <?php include(CONF_THEME_PATH.'_partial/product/shipping-rates.php');?>
              <?php if($codEnabled){?>
              <div class="cod-txt"><?php echo Labels::getLabel('LBL_Cash_on_delivery_is_available',$siteLangId);?> <i class="fa fa-question-circle-o tooltip tooltip--right"><span class="hovertxt"><?php echo Labels::getLabel('MSG_Cash_on_delivery_available._Choose_from_payment_options',$siteLangId);?> </span></i> </div>
              <?php }?>
            </div>
            <div class="gap"></div>
            <div class="">
              <!-- Upsell Products [ -->
              <?php if (count($upsellProducts)>0) { ?>
              <div id="product">
                <div class="cart-box">
                  <div class="heading3"><?php echo Labels::getLabel('LBL_Product_Add-ons', $siteLangId); ?></div>
                  <div class="gap"></div>
                  <table class="table cart--full cart-tbl cart-tbl-addons item-yk" width="100%">
                    <thead>
                      <tr class="hide--mobile">
                        <th></th>
                        <th><?php echo Labels::getLabel('LBL_Name', $siteLangId); ?></th>
                        <th><?php echo Labels::getLabel('LBL_Price', $siteLangId); ?></th>
                        <th><?php echo Labels::getLabel('LBL_Qty', $siteLangId); ?></th>
                        <th></th>
                      </tr>
                    </thead>
                    <?php  foreach ($upsellProducts as $usproduct) {
						$cancelClass ='';
						$uncheckBoxClass='';
						if($usproduct['selprod_stock']<=0){
							$cancelClass ='cancelled--js';
							$uncheckBoxClass ='remove-add-on';
						}
					?>
                    <tr>
                      <td class="<?php echo $cancelClass;?>"><div class="product-img"><a title="<?php echo $usproduct['selprod_title'];?>" href="<?php echo CommonHelper::generateUrl('products','view',array($usproduct['selprod_id']))?>"><img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('Image', 'product', array($usproduct['product_id'], 'MINI', $usproduct['selprod_id'] ) ), CONF_IMG_CACHE_TIME, '.jpg');?>" alt="<?php echo $usproduct['product_identifier']; ?>"> </a></div></td>
                      <td class="<?php echo $cancelClass;?>"><div class="item-yk-head-title"><a href="<?php echo CommonHelper::generateUrl('products', 'view', array($usproduct['selprod_id']) )?>" ><?php echo $usproduct['selprod_title']?></a></div>
                       <?php if($usproduct['selprod_stock']<=0){ ?>
						  <div class="addon--tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId);?></div>
						  <?php  } ?></td>
                      <td class="<?php echo $cancelClass;?>"><div class="item__price"><?php echo CommonHelper::displayMoneyFormat($usproduct['selprod_price']); ?></div></td>
                      <td class="<?php echo $cancelClass;?>"><div class="qty"> <span class="decrease decrease-js">-</span>
                          <input type="text" value="1" placeholder="Qty" class="cartQtyTextBox" lang="addons[<?php echo $usproduct['selprod_id']?>]"   name="addons[<?php echo $usproduct['selprod_id']?>]">
                          <span class="increase increase-js">+</span> </div></td>
                      <td class="<?php echo $cancelClass;?>"><label class="checkbox">
                          <input <?php if($usproduct['selprod_stock']>0){ ?>checked="checked" <?php } ?> type="checkbox" class="cancel <?php echo $uncheckBoxClass;?>" id="check_addons" name="check_addons" title="<?php echo Labels::getLabel('LBL_Remove',$siteLangId);?>">
                          <i class="input-helper"></i> </label>
						</td>
                    </tr>
                    <?php } ?>
                  </table>
                </div>
              </div>
              <div class="gap"></div>
              <?php } ?>
              <!-- ] -->

              <!-- Add To Cart [ -->
              <?php if( $product['in_stock'] ){
					echo $frmBuyProduct->getFormTag();
					$qtyField =  $frmBuyProduct->getField('quantity');
					$qtyFieldName =  $qtyField->getCaption();
					if(strtotime($product['selprod_available_from'])<= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))){
					?>
              <div class="form__group">
                <label><?php echo $qtyFieldName;?></label>
                <div class="qty"> <span class="decrease decrease-js">-</span>
                  <?php
				  echo $frmBuyProduct->getFieldHtml('quantity'); ?>
                  <span class="increase increase-js">+</span></div>
              </div>
			  <?php }?>
              <div class="gap"></div>
              <div class="buy-group">
                <?php
					if(strtotime($product['selprod_available_from'])<= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))){
						echo $frmBuyProduct->getFieldHtml('btnProductBuy');
						echo $frmBuyProduct->getFieldHtml('btnAddToCart');
					}
					echo $frmBuyProduct->getFieldHtml('selprod_id');
					?>
              </div>
              </form>
              <?php echo $frmBuyProduct->getExternalJs();
					} else { ?>
              <div class="sold">
                <h3 class="text--normal-secondary"><?php echo Labels::getLabel('LBL_Sold_Out',$siteLangId); ?></h3>
                <p class="text--normal-secondary"><?php echo Labels::getLabel('LBL_This_item_is_currently_out_of_stock', $siteLangId); ?></p>
              </div>
              <?php } ?>
			  <?php if(strtotime($product['selprod_available_from'])> strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))){?>
				<div class="sold">
					<h3 class="text--normal-secondary"><?php echo Labels::getLabel('LBL_Not_Available',$siteLangId); ?></h3>
					<p class="text--normal-secondary"><?php echo str_replace('{available-date}',FatDate::Format($product['selprod_available_from']),Labels::getLabel('LBL_This_item_will_be_available_from_{available-date}', $siteLangId)); ?></p>
				  </div>
			  <?php }?>
              <!-- ] -->

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="gap"></div>
    <div class="row stop-img-static--js">
      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="white--bg padding20 gallery-js">
          <div class="heading4"><?php echo Labels::getLabel('LBL_Seller_Information',$siteLangId); ?></div>
          <div class="ftshops seller--info">
            <div class="ftshops_item_head">
              <div class="row ">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="ftshops_item_head_left">
                    <div class="ftshops_logo"><a href="<?php echo CommonHelper::generateUrl('Shops','view',array($shop['shop_id']));?>" title="<?php echo $shop['shop_name'];?>" ><img src="<?php echo CommonHelper::generateUrl('image','shopLogo', array($shop['shop_id'], "SMALL",$siteLangId),CONF_WEBROOT_URL); ?>" alt="<?php echo $shop['shop_name'];?>"></a></div>
                    <div class="ftshops_detail">
                      <div class="ftshops_name"><a href="<?php echo CommonHelper::generateUrl('Shops','view',array($shop['shop_id']));?>" title="<?php echo $shop['shop_name'];?>" ><?php echo $shop['shop_name'];?></a></div>
                      <div class="ftshops_location"><?php echo ( $shop['shop_city'])? $shop['shop_city'].',':'';?> <?php echo $shop['shop_state_name'];?>, <?php echo $shop['shop_country_name'];?></div>
                      <?php if($shop_rating>0){ ?>
                      <div class="item-yk_rating"><i class="svg"><svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="14.854px" height="14.166px" viewBox="0 0 14.854 14.166" enable-background="new 0 0 14.854 14.166" xml:space="preserve">
                        <path d="M14.854,5.49c0-0.268-0.286-0.375-0.5-0.41L9.873,4.428L7.864,0.367C7.784,0.197,7.632,0,7.427,0
				C7.222,0,7.07,0.197,6.989,0.367L4.981,4.428L0.5,5.08C0.277,5.115,0,5.223,0,5.49c0,0.16,0.116,0.313,0.223,0.429l3.249,3.159
				l-0.768,4.464c-0.009,0.063-0.018,0.116-0.018,0.179c0,0.232,0.116,0.445,0.375,0.445c0.125,0,0.241-0.043,0.357-0.106l4.008-2.106
				l4.008,2.106c0.107,0.063,0.232,0.106,0.357,0.106c0.259,0,0.366-0.213,0.366-0.445c0-0.063,0-0.116-0.009-0.179l-0.768-4.464
				l3.241-3.159C14.737,5.803,14.854,5.65,14.854,5.49z"/>
                        </svg> </i><span class="rate"><?php echo round($shop_rating,1); ?></span> </div>
                      <?php }?>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <?php if(count($product['moreSellersArr'])>0){ ?>
                  <div class="more--seller align--right"><a class="link--arrow"  href="<?php echo CommonHelper::generateUrl('products','sellers',array($product['selprod_id']));?>"><?php echo sprintf(Labels::getLabel('LBL_VIEW_%d_More_Sellers',$siteLangId),count($product['moreSellersArr']));?></a></div>
                  <?php } ?>
                  <div class="ftshops_item_head_right"> <a href="<?php echo CommonHelper::generateUrl('shops','View',array($shop['shop_id'])); ?>" class="btn btn--primary ripplelink block-on-mobile" tabindex="0"><?php echo Labels::getLabel('LBL_View_Store',$siteLangId); ?></a> <a onclick="return checkUserLoggedIn();" href="<?php echo CommonHelper::generateUrl('shops','sendMessage',array($shop['shop_id'],$product['selprod_id'])); ?>" class="btn btn--secondary ripplelink block-on-mobile" tabindex="0"><?php echo Labels::getLabel('LBL_Ask_Question',$siteLangId); ?></a> </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="gap"></div>
        <?php include(CONF_THEME_PATH.'products/recommended-products.php'); ?>
        <?php include(CONF_THEME_PATH.'products/related-products.php'); ?>
		<?php $youtube_embed_code=CommonHelper::parseYoutubeUrl($product["product_youtube_video"]);
		if( count($productSpecifications)>0 || $youtube_embed_code || $product['product_description']!='' || !empty($product['selprod_warranty_policies']) || !empty($product['selprod_return_policies']) || !empty($product['selprodComments']) ){ ?>
        <div class="white--bg padding20 product--specifications">
          <div class="cms-editor">
            <?php if( count($productSpecifications)>0 ){?>
            <h2><?php echo Labels::getLabel('LBL_Specification',$siteLangId); ?></h2>
            <table>
              <tbody>
                <?php foreach($productSpecifications as $key => $specification){ ?>
                <tr>
                  <td><?php echo $specification['prodspec_name']." :" ;?></td>
                  <td><?php echo html_entity_decode($specification['prodspec_value'],ENT_QUOTES,'utf-8') ; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php } ?>
            <div class="gap"></div>
			<?php
				if( $youtube_embed_code || $product['product_description']!=''){
				?>
				<h2><?php echo Labels::getLabel('LBL_Description', $siteLangId); ?></h2>
				<div class="tab_content desc-txt" id="tab1">
				  <?php

								if($youtube_embed_code!=""):?>
				  <div class="videowrap">
					<iframe width="60%" height="300" src="//www.youtube.com/embed/<?php echo $youtube_embed_code?>" frameborder="0" allowfullscreen></iframe>
				  </div>
				  <span class="gap"></span>
				  <?php  endif;?>
				</div>
				<p><?php echo CommonHelper::renderHtml($product['product_description']);?></p>
			<?php
			}?>
            <?php if(!empty($product['selprod_warranty_policies'])) { ?>
            <h2><?php echo Labels::getLabel('LBL_Warranty', $siteLangId); ?></h2>
            <ul class="listing--bullet">
              <?php foreach($product['selprod_warranty_policies'] as $warranty) { ?>
              <li><?php echo $warranty; ?></li>
              <?php } ?>
            </ul>
            <?php } ?>
            <?php if(!empty($product['selprod_return_policies'])) { ?>
            <h2><?php echo Labels::getLabel('LBL_Return_Policy', $siteLangId); ?></h2>
            <ul class="listing--bullet">
              <?php foreach($product['selprod_return_policies'] as $policy) { ?>
              <li><?php echo $policy; ?></li>
              <?php } ?>
            </ul>
            <?php }?>
            <?php if(!empty($product['selprodComments'])) { ?>
            <h2><?php echo Labels::getLabel('LBL_Extra_comments', $siteLangId); ?></h2>
            <p><?php echo CommonHelper::displayNotApplicable($siteLangId, nl2br($product['selprodComments'])); ?></p>
            <?php } ?>
          </div>
        </div>
		<?php } ?>
        <div class="gap"></div>
        <?php if(FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)) { ?>
        <div class="white--bg padding20" id="itemRatings">
          <div class="section__head">
            <h4><?php echo Labels::getLabel('LBl_Reviews', $siteLangId); ?></h4>
            <?php echo $frmReviewSearch->getFormHtml(); ?> </div>
			<div class="section__body">
              <?php $this->includeTemplate('_partial/product-reviews.php',array('reviews'=>$reviews,'siteLangId'=>$siteLangId,'product_id' => $product['product_id']),false); ?>
			</div>
        </div>
        <?php } ?>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <?php if( isset($banners['Product_Detail_Page_Banner']) && $banners['Product_Detail_Page_Banner']['blocation_active'] && count($banners['Product_Detail_Page_Banner']['banners']) ) { ?>
        <div class="fixed__panel promotion-sticky">
          <div  id="fixed__panelx"  class="promotion">
            <?php foreach( $banners['Product_Detail_Page_Banner']['banners'] as $val ){
				$desktop_url = '';
				$tablet_url = '';
				$mobile_url = '';
				if( !AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId ) ){
					continue;
				}else{
					$slideArr = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_BANNER, $val['banner_id'], 0, $siteLangId );
					foreach($slideArr as $slideScreen){
						switch($slideScreen['afile_screen']){
							case applicationConstants::SCREEN_MOBILE:
								$mobile_url = '<736:' .CommonHelper::generateUrl('Banner','productDetailPageBanner',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_MOBILE)).",";
								break;
							case applicationConstants::SCREEN_IPAD:
								$tablet_url = ' >768:' .CommonHelper::generateUrl('Banner','productDetailPageBanner',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_IPAD)).",";
								break;
							case applicationConstants::SCREEN_DESKTOP:
								$desktop_url = ' >1025:' .CommonHelper::generateUrl('Banner','productDetailPageBanner',array($val['banner_id'], $siteLangId, applicationConstants::SCREEN_DESKTOP)).",";
								break;
						}
					}
				}
				?>
            <a href="<?php echo CommonHelper::generateUrl('Banner','url',array($val['banner_id']));?>" target="<?php echo $val['banner_target'];?>" title="<?php echo $val['banner_title'];?>" class="advertise__block"><img data-src-base="" data-src-base2x="" data-src="<?php echo $mobile_url  . $tablet_url  . $desktop_url; ?>" src="<?php echo CommonHelper::generateUrl('Banner','productDetailPageBanner',array($val['banner_id'],$siteLangId,applicationConstants::SCREEN_DESKTOP));?>" alt="<?php echo $val['banner_title'];?>" class="img-responsive"></a>
            <?php } ?>
          </div>
        </div>
        <?php }
			if(isset($val['banner_record_id']) && $val['banner_record_id'] > 0 && $val['banner_type'] == Banner::TYPE_PPC){
				Promotion::updateImpressionData($val['banner_record_id']);
			}
			?>
      </div>
    </div>
    <div class="gap"></div>
  </div>
</section>
<section>
  <div class="unique-heading"><?php echo Labels::getLabel('LBL_Recently_Viewed', $siteLangId); ?></div>
  <div id="recentlyViewedProductsDiv"></div>
</section>
<div class="gap"></div>
<script type="text/javascript">
$("document").ready(function(){
	zheight = $( window ).height() - 180;
	zwidth = $( window ).width()/2 - 50;
	$('.xzoom, .xzoom-gallery').xzoom({adaptive:false, zoomWidth: zwidth, zoomHeight: zheight, title: true, tint: '#333', Xoffset: 15});

	window.setInterval(function(){
		var scrollPos = $(window).scrollTop();
		if(scrollPos > 0){
		  setProductWeightage('<?php echo $product['selprod_code']; ?>');
		}
	}, 5000);
});

  <?php if( isset($banners['Product_Detail_Page_Banner']) && $banners['Product_Detail_Page_Banner']['blocation_active'] && count($banners['Product_Detail_Page_Banner']['banners']) ) { ?>
$(function () {
	 if($(window).width()>1050){
            $(window).scroll(sticky_relocate);
				sticky_relocate();
			 }
        });
 <?php }?>
</script>

<!--Here is the facebook OG for this product  -->
<?php echo $this->includeTemplate( '_partial/shareThisScript.php' ); ?>
