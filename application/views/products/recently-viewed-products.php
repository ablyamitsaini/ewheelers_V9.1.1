<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if ($recentViewedProducts) {
    ?> <section class="section bg--gray">
    <div class="container">
        <div class="section-head section--white--head section--head--center">
            <div class="section__heading">
                <h2><?php echo Labels::getLabel('LBL_Recently_Viewed', $siteLangId); ?></h2>
            </div>
        </div>
        <div class="js-collection-corner collection-corner product-listing" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
            <?php foreach ($recentViewedProducts as $rProduct) {
                    $productUrl = CommonHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])); ?>
                        <!--product tile-->
                        <div class="products">
                            <div class="products__quickview"> 
							<a onClick='quickDetail(<?php echo $rProduct['selprod_id']; ?>)' class="modaal-inline-content">
								<span class="svg-icon">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">
	<g>
		<g>
			<path fill="#fff" d="M601.54,278.748c-6.587-7.757-13.571-14.997-20.271-21.605c-38.843-38.268-80.536-70.24-126.632-94.064    c-33.015-17.06-65.411-28.299-96.724-33.9c-18.883-3.375-36.226-4.318-51.514-4.318c-15.954,0-33.652,0.844-52.52,4.318    c-31.66,5.835-64.078,17.095-96.716,33.9c-44.806,23.08-86.804,54.789-126.632,94.064c-7.7,7.587-14.352,14.571-20.272,21.605    c-13.685,16.238-13.671,37.594,0,53.838c16.245,19.316,37.942,39.482,65.142,61.158c57.888,46.104,114.613,75.387,170.175,87.441    c19.556,4.184,39.885,5.955,60.823,5.955c20.272,0,40.261-1.771,59.824-5.955c56.214-12.125,113.06-41.197,170.834-87.441    c28.973-23.193,50.096-43.893,64.482-61.158C615.409,315.945,615.565,295.262,601.54,278.748z M573.624,308.656    c-14.628,17.953-34.836,36.553-59.83,56.506c-52.449,41.877-103.971,69.084-155.214,79.789c-18.89,3.9-36.227,5.318-52.181,5.318    h-1c-16.287,0-33.284-1.488-51.521-5.318c-50.57-10.777-102.566-37.324-155.881-79.789    c-25.129-20.018-44.869-38.887-59.157-56.506c-2.326-1.66-2.326-3.652,0-5.978c1.66-2.326,4.566-5.736,8.637-9.977    c4.24-4.403,7.317-7.644,8.977-9.636c38.552-37.893,77.94-66.468,117.662-86.414c31.745-15.947,60.504-26.491,86.414-30.916    c14.976-2.552,30.249-3.985,45.869-3.985c14.954,0,29.923,1.262,45.529,3.985c26.271,4.588,55.102,15.11,86.421,30.916    c40.473,20.421,79.437,48.854,116.995,86.414c8.637,8.644,14.741,15.188,18.279,19.613    C575.411,304.912,575.284,306.996,573.624,308.656z" />
			<path fill="#fff" d="M306.399,189.008c-32.241,0-60.164,11.295-83.095,34.234c-22.931,22.931-34.234,50.521-34.234,82.755    c0,32.241,11.217,59.583,34.234,82.429c22.853,22.689,50.854,33.9,83.095,33.9c32.234,0,59.49-11.295,82.096-33.9    c22.931-22.932,34.233-50.188,34.233-82.429c0-32.234-11.388-59.739-34.233-82.755    C365.804,200.389,338.633,189.008,306.399,189.008z M362.564,362.502c-15.62,15.621-34.233,23.264-56.165,23.264    c-22.271,0-41.218-7.977-56.838-23.598c-15.621-15.619-23.598-34.566-23.598-56.171c0-22.265,7.977-40.877,23.598-56.499    c15.621-15.621,34.567-23.598,56.838-23.598c22.265,0,40.793,8.055,56.165,23.598c15.543,15.706,23.271,34.234,23.271,56.499    C385.835,327.936,378.185,346.881,362.564,362.502z" />
		</g>
	</g>

</svg>
</span>Quick View
							</a> 
							</div>
                            <div class="products__body"> <?php $this->includeTemplate('_partial/collection-ui.php', array('product'=>$rProduct,'siteLangId'=>$siteLangId), false); ?>
                                <?php $uploadedTime = ($rProduct['product_image_updated_on'] > 0) ? '?'.strtotime($rProduct['product_image_updated_on']) : '' ; ?> <div class="products__img">
                                    <a title="<?php echo $rProduct['selprod_title']; ?>"
                                        href="<?php echo !isset($rProduct['promotion_id'])?CommonHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])):CommonHelper::generateUrl('Products', 'track', array($rProduct['promotion_record_id'])); ?>"><img
                                            data-ratio="1:1 (500x500)"
                                            src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image', 'product', array($rProduct['product_id'], "CLAYOUT3", $rProduct['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg').$uploadedTime; ?>"
                                            alt="<?php echo $rProduct['prodcat_name']; ?>"> </a>
                                </div>
                            </div>
                            <div class="products__footer"> <?php /* if(round($rProduct['prod_rating'])>0 && FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)){ ?> <div class="products__rating">
                                    <i class="icn"><svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                                        </svg></i> <span class="rate"><?php echo round($rProduct['prod_rating'],1);?></span> <?php if(round($rProduct['prod_rating'])==0 ){  ?> <span class="be-first"> <a
                                            href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Be_the_first_to_review_this_product', $siteLangId); ?> </a> </span> <?php } ?> </div> <?php } */ ?> <div class="products__category"><a
                                        href="<?php echo CommonHelper::generateUrl('Category', 'View', array($rProduct['prodcat_id'])); ?>"><?php echo $rProduct['prodcat_name']; ?> </a></div>
                                <div class="products__title"><a title="<?php echo $rProduct['selprod_title']; ?>"
                                        href="<?php echo CommonHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])); ?>"><?php echo (mb_strlen($rProduct['selprod_title']) > 30) ? mb_substr($rProduct['selprod_title'], 0, 30)."..." : $rProduct['selprod_title']; ?>
                                    </a></div> <?php $this->includeTemplate('_partial/collection-product-price.php', array('product'=>$rProduct,'siteLangId'=>$siteLangId), false); ?>
                            </div>
                        </div>
                        <!--/product tile--> <?php
            } ?>
        </div>
    </div>
</section>
<?php } ?>
