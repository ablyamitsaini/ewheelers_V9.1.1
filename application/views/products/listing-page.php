<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
    $frmProductSearch->setFormTagAttribute('onSubmit', 'searchProducts(this); return(false);');
    $keywordFld = $frmProductSearch->getField('keyword');
    $keywordFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search', $siteLangId));
    $keywordFld = $frmProductSearch->getField('keyword');
    $keywordFld->overrideFldType("hidden");
    $bannerImage = '';
if (!empty($category['banner'])) {
    $bannerImage = CommonHelper::generateUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, 'wide'));
}
if (!empty($category['banner']) || !empty($category['prodcat_description'])) { ?>
    <section class="section bg-brands" style="background-image: url(<?php echo $bannerImage; ?>)">
        <?php if (!empty($category['prodcat_description']) && array_key_exists('prodcat_description', $category)) { ?>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <div class="text-center">
                            <h6 class="txt-white"><?php  echo FatUtility::decodeHtmlEntities($category['prodcat_description']); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </section>
<?php } ?>
<?php if (isset($pageTitle)) { ?>
<section class="section section--pagebar">
    <div class="container">
        <div class="section-head  section--white--head justify-content-center mb-0">
            <div class="section__heading">
                <h2 class="mb-0"><?php echo $pageTitle; ?> <?php /* <span class="hide_on_no_product"><?php echo Labels::getLabel('LBL_Showing', $siteLangId); ?> <span id="start_record"><?php echo $page;?> - </span><span
                        id="end_record"><?php echo $pageCount;?></span> <?php echo Labels::getLabel('LBL_of', $siteLangId); ?> <span id="total_records"><?php echo $recordCount;?></span></span> */ ?> </h2>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<?php $this->includeTemplate('_partial/productsSearchForm.php', array('frmProductSearch'=>$frmProductSearch,'siteLangId'=>$siteLangId,'recordCount'=>$recordCount), false);  ?>
<section class="">
    <div class="container">
        <div class="row">
        <?php if (!isset($noProductFound)) { ?>
            <div class="col-lg-3">
            <?php if (isset($shop)) { ?>
                <div class="bg-gray rounded shop-information p-5 ">
                    <div class="shop-logo"><img data-ratio="1:1 (150x150)" src="<?php echo CommonHelper::generateUrl('image', 'shopLogo', array($shop['shop_id'], $siteLangId, 'SMALL')); ?>" alt="<?php echo $shop['shop_name']; ?>"></div>
                    <div class="shop-info">
                        <div class="shop-name">
                            <h5>
                                <?php echo $shop['shop_name']; ?>
                                <span class="blk-txt"><?php echo Labels::getLabel('LBL_Shop_Opened_On', $siteLangId); ?> <strong> <?php $date = new DateTime($shop['user_regdate']);
                                echo $date->format('M d, Y'); ?> </strong></span>
                            </h5>
                        </div>
                        <div class="products__rating"> <i class="icn"><svg class="svg">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                            </svg></i> <span class="rate"><?php echo round($shopRating, 1),' ',Labels::getLabel('Lbl_Out_of', $siteLangId),' ', '5';
                            if ($shopTotalReviews) { ?>
                                 - <a href="<?php echo CommonHelper::generateUrl('Reviews', 'shop', array($shop['shop_id'])); ?>"><?php echo $shopTotalReviews, ' ', Labels::getLabel('Lbl_Reviews', $siteLangId); ?></a>
                            <?php } ?> </span>
                        </div>
                        <div class="share-button share-button--static-horizontal">
                            <a href="javascript:void(0)" class="social-toggle"><i class="icn">
                                <svg class="svg">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#share"></use>
                                </svg>
                            </i></a>
                            <div class="social-networks open-menu">
                                <ul>
                                    <li class="social-facebook">
                                        <a class="social-link st-custom-button" data-network="facebook">
                                            <i class="icn"><svg class="svg">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#fb"></use>
                                                </svg></i>
                                        </a>
                                    </li>
                                    <li class="social-twitter">
                                        <a class="social-link st-custom-button" data-network="twitter">
                                            <i class="icn"><svg class="svg">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#tw"></use>
                                                </svg></i>
                                        </a>
                                    </li>
                                    <li class="social-pintrest">
                                        <a class="social-link st-custom-button" data-network="pinterest">
                                            <i class="icn"><svg class="svg">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#pt"></use>
                                                </svg></i>
                                        </a>
                                    </li>
                                    <li class="social-email">
                                        <a class="social-link st-custom-button" data-network="email">
                                            <i class="icn"><svg class="svg">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#envelope"></use>
                                                </svg></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="shop-btn-group">
                            <?php $showAddToFavorite = true;
                            if (UserAuthentication::isUserLogged() && (!User::isBuyer())) {
                                $showAddToFavorite = false;
                            }
                            ?>
                            <?php if ($showAddToFavorite) { ?>
                                <a href="javascript:void(0)" onclick="toggleShopFavorite(<?php echo $shop['shop_id']; ?>);" class="btn btn--primary btn--sm <?php echo ($shop['is_favorite']) ? 'is-active' : ''; ?>" id="shop_<?php echo $shop['shop_id']; ?>"><i class="icn"><svg class="svg">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart"></use>
                                    </svg></i><?php echo Labels::getLabel('LBL_Favorite_Shop', $siteLangId); ?> </a>
                            <?php }?>
                            <?php $showMoreButtons = true; if (UserAuthentication::isUserLogged() && UserAuthentication::getLoggedUserId(true) == $shop['shop_user_id']) {
                                $showMoreButtons = false;
                            } ?>
                            <?php if ($showMoreButtons) { ?>
                                <a href="<?php echo CommonHelper::generateUrl('Shops', 'ReportSpam', array($shop['shop_id'])); ?>" class="btn btn--primary btn--sm"><i class="icn"><svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#report" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#report"></use>
                                        </svg></i><?php echo Labels::getLabel('LBL_Report_Spam', $siteLangId); ?></a>

                                <a href="<?php echo CommonHelper::generateUrl('shops', 'sendMessage', array($shop['shop_id'])); ?>" class="btn btn--primary btn--sm"><i class="icn"><svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#send-msg" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#send-msg"></use>
                                        </svg></i><?php echo Labels::getLabel('LBL_Send_Message', $siteLangId); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="gap"></div>
            <?php } ?>
                <?php if (array_key_exists('brand_id', $postedData) && $postedData['brand_id'] > 0) {
                    ?> <div class="brands-block-wrapper">
                            <div class="brands-block">
                                <img src="<?php echo FatCache::getCachedUrl(CommonHelper::generateUrl('image', 'brand', array($postedData['brand_id'] , $siteLangId, 'COLLECTION_PAGE')), CONF_IMG_CACHE_TIME, '.jpg'); ?>">
                            </div>
                        </div> <?php
                } ?>
                <div class="filters bg-gray rounded">
                    <div class="filters__ele productFilters-js"></div>
                </div>
            </div>
            <?php
        }
        if (!isset($noProductFound)) {
            $class ='col-xl-9';
        } else {
            $class= 'col-lg-12';
        } ?>
        <div class="<?php echo $class; ?>">
            <div class="listing-products -listing-products ">
                    <div id="productsList" role="main-listing" class="row product-listing">
                    <?php if ($recordCount > 0) {
                        $productsData = array(
                                        'products'=> $products,
                                        'page'=> $page,
                                        'pageCount'=> $pageCount,
                                        'postedData'=> $postedData,
                                        'recordCount'=> $recordCount,
                                        'siteLangId'=> $siteLangId,
                                    );
                        $this->includeTemplate('products/products-list.php', $productsData, false);
                    } else {
                        $pSrchFrm = Common::getSiteSearchForm();
                        $pSrchFrm->fill(array('btnSiteSrchSubmit' => Labels::getLabel('LBL_Submit', $siteLangId)));
                        $pSrchFrm->setFormTagAttribute('onSubmit', 'submitSiteSearch(this); return(false);');

                        $this->includeTemplate('_partial/no-product-found.php', array('pSrchFrm'=>$pSrchFrm,'siteLangId'=>$siteLangId,'postedData'=>$postedData), true);
                    } ?> </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col--left col--left-adds">
                <div class="wrapper--adds">
                    <div class="grids" id="searchPageBanners">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="gap"></div>
<script type="text/javascript">
    $(document).ready(function() {
        $currentPageUrl = '<?php echo $canonicalUrl; ?>';
        $productSearchPageType = '<?php echo $productSearchPageType; ?>';
        $recordId = <?php echo $recordId; ?>;
        loadProductListingfilters(document.frmProductSearch);
        bannerAdds('<?php echo $bannerListigUrl;?>');
    });
</script>
