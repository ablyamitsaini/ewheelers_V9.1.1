<?php
class ProductsController extends MyAppController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function index()
    {
        $db = FatApp::getDb();
        $get = Product::convertArrToSrchFiltersAssocArr(FatApp::getParameters());

        $includeKeywordRelevancy = false;
        if (array_key_exists('keyword', $get)) {
            $includeKeywordRelevancy = true;
        }

        $frm = $this->getProductSearchForm($includeKeywordRelevancy);
        $get['join_price'] = 1;
        $frm->fill($get);

        $data = $this->getListingData($get);

        $arr = array(
            'frmProductSearch' => $frm,
            'pageTitle' => Labels::getLabel('LBL_All_PRODUCTS', $this->siteLangId),
            'canonicalUrl' => CommonHelper::generateFullUrl('Products', 'index'),
            'productSearchPageType' => SavedSearchProduct::PAGE_PRODUCT_INDEX,
            'recordId' => 0,
            'bannerListigUrl' => CommonHelper::generateFullUrl('Banner', 'allProducts'),
            'showBreadcrumb' => false
        );

        $data = array_merge($data, $arr);
        $this->set('data', $data);

        $this->includeProductPageJsCss();
        $this->_template->addJs('js/slick.min.js');
        $this->_template->addCss(array('css/slick.css','css/product-detail.css'));
        $this->_template->render();
    }

    public function search()
    {
        $db = FatApp::getDb();
        $get = Product::convertArrToSrchFiltersAssocArr(FatApp::getParameters());
        $keyword = '';
        $includeKeywordRelevancy = false;
        if (array_key_exists('keyword', $get)) {
            $includeKeywordRelevancy = true;
            $keyword = $get['keyword'];
        }

        $frm = $this->getProductSearchForm($includeKeywordRelevancy);

        $get['join_price'] = 1;
        $frm->fill($get);
        $data = $this->getListingData($get);

        $arr = array(
            'frmProductSearch'=>$frm,
            'pageTitle'=> Labels::getLabel('LBL_Search_results_for', $this->siteLangId),
            'canonicalUrl'=>CommonHelper::generateFullUrl('Products', 'search'),
            'productSearchPageType'=>SavedSearchProduct::PAGE_PRODUCT,
            'recordId'=>0,
            'bannerListigUrl'=>CommonHelper::generateFullUrl('Banner', 'searchListing'),
            'showBreadcrumb'=> false,
            'keyword' => $keyword,
        );

        $data = array_merge($data, $arr);
        $this->set('data', $data);

        $this->includeProductPageJsCss();
        $this->_template->addJs('js/slick.min.js');
        $this->_template->addCss(array('css/slick.css', 'css/product-detail.css'));
        $this->_template->render(true, true, 'products/index.php');
    }

    public function featured()
    {
        $db = FatApp::getDb();
        $get = Product::convertArrToSrchFiltersAssocArr(FatApp::getParameters());

        $includeKeywordRelevancy = false;
        if (array_key_exists('keyword', $get)) {
            $includeKeywordRelevancy = true;
        }

        $frm = $this->getProductSearchForm($includeKeywordRelevancy);

        $get['join_price'] = 1;
        $get['featured'] = 1;
        $frm->fill($get);

        $data = $this->getListingData($get);

        $arr = array(
            'frmProductSearch' => $frm,
            'pageTitle' => Labels::getLabel('LBL_FEATURED_PRODUCTS', $this->siteLangId),
            'canonicalUrl' => CommonHelper::generateFullUrl('Products', 'featured'),
            'productSearchPageType' => SavedSearchProduct::PAGE_FEATURED_PRODUCT,
            'recordId' => 0,
            'bannerListigUrl' => CommonHelper::generateFullUrl('Banner', 'searchListing'),
            'showBreadcrumb' => false
        );

        $data = array_merge($data, $arr);
        $this->set('data', $data);

        $this->includeProductPageJsCss();
        $this->_template->addJs('js/slick.min.js');
        $this->_template->addCss(array('css/slick.css', 'css/product-detail.css'));
        $this->_template->render(true, true, 'products/index.php');
    }

    public function filters()
    {
        $db = FatApp::getDb();
        $post = FatApp::getPostedData();

        $get = FatApp::getParameters();
        $headerFormParamsAssocArr = Product::convertArrToSrchFiltersAssocArr($get);
        $headerFormParamsAssocArr = array_merge($headerFormParamsAssocArr, $post);

        $prodSrchObj = new ProductSearch($this->siteLangId);
        $prodSrchObj->setDefinedCriteria(0, 0, $headerFormParamsAssocArr, true);
        $prodSrchObj->joinProductToCategory();
        $prodSrchObj->joinSellerSubscription(0, false, true);
        $prodSrchObj->addSubscriptionValidCondition();

        $categoryId = 0;
        $categoriesArr = array();
        if (array_key_exists('category', $post)) {
            $prodSrchObj->addCategoryCondition($post['category']);
            $categoryId = FatUtility::int($post['category']);
        }

        $shopId = FatApp::getPostedData('shop_id', FatUtility::VAR_INT, 0);
        if (0 < $shopId) {
            $prodSrchObj->addShopIdCondition($shopId);
        }

        $brandId = FatApp::getPostedData('brand_id', FatUtility::VAR_INT, 0);
        if (0 < $brandId) {
            $prodSrchObj->addBrandCondition($brandId);
        }

        $featured = FatApp::getPostedData('featured', FatUtility::VAR_INT, 0);
        if (0 < $featured) {
            $prodSrchObj->addCondition('product_featured', '=', applicationConstants::YES);
        }

        $keyword = '';
        if (array_key_exists('keyword', $headerFormParamsAssocArr)) {
            $keyword = $headerFormParamsAssocArr['keyword'];
            $prodSrchObj->addKeywordSearch($keyword);
        }

        /* Categories Data[ */
        $catSrch = clone $prodSrchObj;
        $catSrch->addGroupBy('c.prodcat_id');
        $categoriesArr = ProductCategory::getTreeArr($this->siteLangId, $categoryId, false, $catSrch, true);
        /* ] */

        /*$recordSrch = clone $prodSrchObj;
        $recordSrch->addMultipleFields(array('product_id'));
        $recordSrch->setPageSize(1);
        $rs = $recordSrch->getResultSet();
        $totalRecords = FatApp::getDb()->totalRecords($rs);
        if(1 > $totalRecords){
            exit();
        }*/

        $prodSrchObj->doNotCalculateRecords();
        $prodSrchObj->doNotLimitRecords();

        $brandsArr = array();
        $conditionsArr  = array();
        $priceArr  = array();

        /* Brand Filters Data[ */
        $brandId = 0;
        if (array_key_exists('brand_id', $headerFormParamsAssocArr)) {
            $brandId = FatUtility::int($headerFormParamsAssocArr['brand_id']);
        }

        $brandsCheckedArr = array();
        if (array_key_exists('brand', $headerFormParamsAssocArr)) {
            $brandsCheckedArr = $headerFormParamsAssocArr['brand'];
        }

        $brandSrch = clone $prodSrchObj;
        $brandSrch->addGroupBy('brand_id');
        $brandSrch->addMultipleFields(array( 'brand_id', 'ifNull(brand_name,brand_identifier) as brand_name', 'brand_short_description'));
        if ($brandId) {
            $brandSrch->addCondition('brand_id', '=', $brandId);
            $brandsCheckedArr =  array($brandId);
        }
        //var_dump($brandsCheckedArr);

        if (!empty($brandsCheckedArr)) {
            $brandSrch->addFld('IF(FIND_IN_SET(brand_id, "'.implode(',', $brandsCheckedArr).'"), 1, 0) as priority');
            $brandSrch->addOrder('priority', 'desc');
        }
        $brandSrch->addOrder('brand_name');
        /* if needs to show product counts under brands[ */
        //$brandSrch->addFld('count(selprod_id) as totalProducts');
        /* ] */
        $brandRs = $brandSrch->getResultSet();
        $brandsArr = $db->fetchAll($brandRs);
        /* ] */

        /* {Can modify the logic fetch data directly from query . will implement later}
        Option Filters Data[ */
        $options = array();
        if ($categoryId && ProductCategory::isLastChildCategory($categoryId)) {
            $selProdCodeSrch = clone $prodSrchObj;
            $selProdCodeSrch->addGroupBy('selprod_code');
            $selProdCodeSrch->addMultipleFields(array('product_id','selprod_code'));
            $selProdCodeRs = $selProdCodeSrch->getResultSet();
            $selProdCodeArr = $db->fetchAll($selProdCodeRs);

            if (!empty($selProdCodeArr)) {
                foreach ($selProdCodeArr as $val) {
                    $optionsVal = SellerProduct::getSellerProductOptionsBySelProdCode($val['selprod_code'], $this->siteLangId, true);
                    $options = $options+$optionsVal;
                }
            }
        }

        usort(
            $options,
            function ($a, $b) {
                if ($a['optionvalue_id'] == $b['optionvalue_id']) {
                    return 0;
                }
                return ($a['optionvalue_id'] < $b['optionvalue_id'])?-1:1;
            }
        );

        /* $optionSrch->joinSellerProductOptionsWithSelProdCode();
        $optionSrch->addGroupBy('optionvalue_id'); */
        /*]*/

        /* Condition filters data[ */
        $conditionSrch = clone $prodSrchObj;
        $conditionSrch->addGroupBy('selprod_condition');
        $conditionSrch->addOrder('selprod_condition');
        $conditionSrch->addMultipleFields(array('selprod_condition'));
        /* if needs to show product counts under any condition[ */
        //$conditionSrch->addFld('count(selprod_condition) as totalProducts');
        /* ] */
        $conditionRs = $conditionSrch->getResultSet();
        $conditionsArr = $db->fetchAll($conditionRs);

        /* ] */

        /* Price Filters[ */
        $priceSrch = clone $prodSrchObj;
        $priceSrch->addMultipleFields(array('MIN(theprice) as minPrice', 'MAX(theprice) as maxPrice'));
        $qry = $priceSrch->getQuery();
        $qry .= ' having minPrice IS NOT NULL AND maxPrice IS NOT NULL';

        //$priceRs = $priceSrch->getResultSet();
        $priceRs = $db->query($qry);
        $priceArr = $db->fetch($priceRs);

        $priceInFilter = false;
        $filterDefaultMinValue = $priceArr['minPrice'];
        $filterDefaultMaxValue = $priceArr['maxPrice'];

        if ($this->siteCurrencyId != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1) || (array_key_exists('currency_id', $headerFormParamsAssocArr) && $headerFormParamsAssocArr['currency_id'] != $this->siteCurrencyId)) {
            $filterDefaultMinValue = CommonHelper::displayMoneyFormat($priceArr['minPrice'], false, false, false);
            $filterDefaultMaxValue = CommonHelper::displayMoneyFormat($priceArr['maxPrice'], false, false, false);
            $priceArr['minPrice'] = $filterDefaultMinValue;
            $priceArr['maxPrice'] = $filterDefaultMaxValue;
        }

        if (array_key_exists('price-min-range', $headerFormParamsAssocArr) && array_key_exists('price-max-range', $headerFormParamsAssocArr)) {
            $priceArr['minPrice'] = $headerFormParamsAssocArr['price-min-range'];
            $priceArr['maxPrice'] = $headerFormParamsAssocArr['price-max-range'];
            $priceInFilter = true;
        }

        if (array_key_exists('currency_id', $headerFormParamsAssocArr) && $headerFormParamsAssocArr['currency_id'] != $this->siteCurrencyId) {
            $priceArr['minPrice'] = CommonHelper::convertExistingToOtherCurrency($headerFormParamsAssocArr['currency_id'], $headerFormParamsAssocArr['price-min-range'], $this->siteCurrencyId, false);
            $priceArr['maxPrice'] = CommonHelper::convertExistingToOtherCurrency($headerFormParamsAssocArr['currency_id'], $headerFormParamsAssocArr['price-max-range'], $this->siteCurrencyId, false);
        }

        /* ] */
        /* Price Filters[ */
        $availabilitySrch = clone $prodSrchObj;
        $availabilitySrch->addGroupBy('in_stock');
        $availabilitySrch->addMultipleFields(array('if(selprod_stock > 0,1,0) as in_stock'));
        $availabilityRs = $availabilitySrch->getResultSet();
        $availabilityArr = $db->fetchAll($availabilityRs);
        /*] */


        $optionValueCheckedArr = array();
        if (array_key_exists('optionvalue', $headerFormParamsAssocArr)) {
            $optionValueCheckedArr = $headerFormParamsAssocArr['optionvalue'];
        }

        $conditionsCheckedArr = array();
        if (array_key_exists('condition', $headerFormParamsAssocArr)) {
            $conditionsCheckedArr = $headerFormParamsAssocArr['condition'];
        }

        $availability = 0;
        if (array_key_exists('out_of_stock', $headerFormParamsAssocArr)) {
            $availability = $headerFormParamsAssocArr['out_of_stock'];
        }

        $productFiltersArr = array('count_for_view_more' => FatApp::getConfig('CONF_COUNT_FOR_VIEW_MORE', FatUtility::VAR_INT, 5));

        $prodcatArr = array();
        //$productCategories = array();
        if (array_key_exists('prodcat', $headerFormParamsAssocArr)) {
            $prodcatArr = $headerFormParamsAssocArr['prodcat'];
            // $productCatObj = new ProductCategory;
            // $productCategories =  $productCatObj->getCategoriesForSelectBox($this->siteLangId);
        }

        $shopCatFilters = false;
        if (array_key_exists('shop_id', $headerFormParamsAssocArr)) {
            $shop_id = FatUtility::int($headerFormParamsAssocArr['shop_id']);
            $searchFrm = Shop::getFilterSearchForm();
            $searchFrm->fill($headerFormParamsAssocArr);
            $this->set('searchFrm', $searchFrm);
            if (0 < $shop_id) {
                $shopCatFilters = true;
            }
        }

        $this->set('productFiltersArr', $productFiltersArr);
        $this->set('headerFormParamsAssocArr', $headerFormParamsAssocArr);
        $this->set('categoriesArr', $categoriesArr);
        $this->set('shopCatFilters', $shopCatFilters);
        $this->set('prodcatArr', $prodcatArr);
        // $this->set('productCategories',$productCategories);
        $this->set('brandsArr', $brandsArr);
        $this->set('brandsCheckedArr', $brandsCheckedArr);
        $this->set('optionValueCheckedArr', $optionValueCheckedArr);
        $this->set('conditionsArr', $conditionsArr);
        $this->set('conditionsCheckedArr', $conditionsCheckedArr);
        $this->set('options', $options);
        $this->set('priceArr', $priceArr);
        $this->set('priceInFilter', $priceInFilter);
        $this->set('filterDefaultMinValue', $filterDefaultMinValue);
        $this->set('filterDefaultMaxValue', $filterDefaultMaxValue);
        $this->set('availability', $availability);
        $this->set('availabilityArr', $availabilityArr);

        if (true ===  MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        echo $this->_template->render(false, false, 'products/filters.php', true);
        exit;
    }

    public function view($selprod_id = 0)
    {
        $selprod_id = FatUtility::int($selprod_id);
        if (true ===  MOBILE_APP_API_CALL && 1 > $selprod_id) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }
        $productImagesArr = array();
        $prodSrchObj = new ProductSearch($this->siteLangId);

        /* fetch requested product[ */
        $prodSrch = clone $prodSrchObj;
        $prodSrch->setDefinedCriteria(0, 0, array(), false);
        $prodSrch->joinProductToCategory();
        $prodSrch->joinSellerSubscription();
        $prodSrch->addSubscriptionValidCondition();
        $prodSrch->doNotCalculateRecords();
        $prodSrch->addCondition('selprod_id', '=', $selprod_id);
        $prodSrch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $prodSrch->doNotLimitRecords();

        /* sub query to find out that logged user have marked current product as in wishlist or not[ */
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }
        if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
            $prodSrch->joinFavouriteProducts($loggedUserId);
            $prodSrch->addFld('ufp_id');
        } else {
            $prodSrch->joinUserWishListProducts($loggedUserId);
            $prodSrch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
        }

        $selProdReviewObj = new SelProdReviewSearch();
        $selProdReviewObj->joinProducts($this->siteLangId);
        $selProdReviewObj->joinSellerProducts($this->siteLangId);
        $selProdReviewObj->joinSelProdRating();
        $selProdReviewObj->joinUser();
        $selProdReviewObj->joinSelProdReviewHelpful();
        $selProdReviewObj->addCondition('sprating_rating_type', '=', SelProdRating::TYPE_PRODUCT);
        $selProdReviewObj->doNotCalculateRecords();
        $selProdReviewObj->doNotLimitRecords();
        $selProdReviewObj->addGroupBy('spr.spreview_product_id');
        $selProdReviewObj->addGroupBy('sprh_spreview_id');
        $selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id','spr.spreview_product_id',"ROUND(AVG(sprating_rating),2) as prod_rating","count(spreview_id) as totReviews"));
        $selProdRviewSubQuery = $selProdReviewObj->getQuery();
        $prodSrch->joinTable('(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_product_id = product_id', 'sq_sprating');
        $prodSrch->addMultipleFields(
            array(
            'product_id','product_identifier', 'IFNULL(product_name,product_identifier) as product_name', 'product_seller_id', 'product_model','product_type', 'prodcat_id', 'IFNULL(prodcat_name,prodcat_identifier) as prodcat_name', 'product_upc', 'product_isbn', 'product_short_description', 'product_description',
            'selprod_id', 'selprod_user_id', 'selprod_code', 'selprod_condition', 'selprod_price', 'special_price_found','splprice_start_date', 'splprice_end_date', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'selprod_warranty', 'selprod_return_policy','selprodComments',
            'theprice', 'selprod_stock' , 'selprod_threshold_stock_level', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description', 'user_name',
            'shop_id', 'IFNULL(shop_identifier, shop_name) as shop_name', 'ifnull(sq_sprating.prod_rating,0) prod_rating ','ifnull(sq_sprating.totReviews,0) totReviews',
            'splprice_display_dis_type', 'splprice_display_dis_val', 'splprice_display_list_price', 'product_attrgrp_id', 'product_youtube_video', 'product_cod_enabled', 'selprod_cod_enabled','selprod_available_from')
        );

        $productRs = $prodSrch->getResultSet();
        $product = FatApp::getDb()->fetch($productRs);
        /* ] */

        if (!$product) {
            if (true ===  MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
            }
            FatUtility::exitWithErrorCode(404);
        }

        /* over all catalog product reviews */
        $selProdReviewObj->addCondition('spreview_product_id', '=', $product['product_id']);
        $selProdReviewObj->addMultipleFields(array('count(spreview_postedby_user_id) totReviews','sum(if(sprating_rating=1,1,0)) rated_1','sum(if(sprating_rating=2,1,0)) rated_2','sum(if(sprating_rating=3,1,0)) rated_3','sum(if(sprating_rating=4,1,0)) rated_4','sum(if(sprating_rating=5,1,0)) rated_5'));

        $reviews = FatApp::getDb()->fetch($selProdReviewObj->getResultSet());
        /* CommonHelper::printArray($reviews); die; */
        $this->set('reviews', $reviews);
        $subscription = false;
        $allowed_images =-1;
        if (FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE')) {
            $allowed_images = OrderSubscription::getUserCurrentActivePlanDetails($this->siteLangId, $product['selprod_user_id'], array('ossubs_images_allowed'));
            $subscription = true;
        }

        /* Product::recordProductWeightage($product['selprod_code'],SmartWeightageSettings::PRODUCT_VIEW);
        Product::addUpdateProductBrowsingHistory($product['selprod_code'],SmartWeightageSettings::PRODUCT_VIEW); */

        /* Current Product option Values[ */
        $options = SellerProduct::getSellerProductOptions($selprod_id, false);
        /* CommonHelper::printArray($options); die; */
        $productSelectedOptionValues = array();
        $productGroupImages= array();
        if ($options) {
            foreach ($options as $op) {
                /* Product UPC code [ */
                $product['product_upc'] = UpcCode::getUpcCode($product['product_id'], $op['selprodoption_optionvalue_id']);
                /* ] */
                $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], $op['selprodoption_optionvalue_id'], $this->siteLangId, true, '', $allowed_images);
                if ($images) {
                    $productImagesArr += $images;
                }
                $productSelectedOptionValues[$op['selprodoption_option_id']] = $op['selprodoption_optionvalue_id'];
            }
        }
        if ($productImagesArr) {
            foreach ($productImagesArr as $image) {
                $afileId = $image['afile_id'];
                if (!array_key_exists($afileId, $productGroupImages)) {
                    $productGroupImages[$afileId] = array();
                }
                $productGroupImages[$afileId] = $image;
            }
        }

        $product['selectedOptionValues'] = $productSelectedOptionValues;
        /* ] */

        if (isset($allowed_images) && $allowed_images >0) {
            $universal_allowed_images_count = $allowed_images  - count($productImagesArr);
        }

        $productUniversalImagesArr = array();
        if (empty($productGroupImages) ||  !$subscription || isset($universal_allowed_images_count)) {
            $universalImages = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], -1, $this->siteLangId, true, '');
            /* CommonHelper::printArray($universalImages); die; */
            if ($universalImages) {
                if (isset($universal_allowed_images_count)) {
                    $images = array_slice($universalImages, 0, $universal_allowed_images_count);
                    $productUniversalImagesArr = $images;
                    $universal_allowed_images_count = $universal_allowed_images_count  - count($productUniversalImagesArr);
                } elseif (!$subscription) {
                    $productUniversalImagesArr = $universalImages;
                }
            }
        }

        if ($productUniversalImagesArr) {
            foreach ($productUniversalImagesArr as $image) {
                $afileId = $image['afile_id'];
                if (!array_key_exists($afileId, $productGroupImages)) {
                    $productGroupImages[$afileId] = array();
                }
                $productGroupImages[$afileId] = $image;
            }
        }

        //abled and Get Shipping Rates [*/
        $codEnabled = false;
        if (Product::isProductShippedBySeller($product['product_id'], $product['product_seller_id'], $product['selprod_user_id'])) {
            $walletBalance = User::getUserBalance($product['selprod_user_id']);
            if ($product['selprod_cod_enabled']) {
                $codEnabled = true;
            }
            $codMinWalletBalance = -1;
            $shop_cod_min_wallet_balance = Shop::getAttributesByUserId($product['selprod_user_id'], 'shop_cod_min_wallet_balance');
            if ($shop_cod_min_wallet_balance > -1) {
                $codMinWalletBalance = $shop_cod_min_wallet_balance;
            } elseif (FatApp::getConfig('CONF_COD_MIN_WALLET_BALANCE', FatUtility::VAR_FLOAT, -1) > -1) {
                $codMinWalletBalance = FatApp::getConfig('CONF_COD_MIN_WALLET_BALANCE', FatUtility::VAR_FLOAT, -1);
            }
            if ($codMinWalletBalance > -1 && $codMinWalletBalance > $walletBalance) {
                $codEnabled = false;
            }
            $shippingRates = Product::getProductShippingRates($product['product_id'], $this->siteLangId, 0, $product['selprod_user_id']);
            $shippingDetails = Product::getProductShippingDetails($product['product_id'], $this->siteLangId, $product['selprod_user_id']);
        } else {
            if ($product['product_cod_enabled']) {
                $codEnabled = true;
            }
            $shippingRates = Product::getProductShippingRates($product['product_id'], $this->siteLangId, 0, 0);
            $shippingDetails = Product::getProductShippingDetails($product['product_id'], $this->siteLangId, 0);
        }

        if ($product['product_type'] == Product::PRODUCT_TYPE_DIGITAL) {
            $shippingRates = array();
            $shippingDetails  = array();
        }

        $this->set('codEnabled', $codEnabled);
        $this->set('shippingRates', $shippingRates);
        $this->set('shippingDetails', $shippingDetails);
        /*]*/

        /*[ Product shipping cost */
        $shippingCost = 0;
        /*]*/

        $product['moreSellersArr'] = $this->getMoreSeller($product['selprod_code'], $this->siteLangId, $product['selprod_user_id']);
        $product['selprod_return_policies'] =  SellerProduct::getSelprodPolicies($product['selprod_id'], PolicyPoint::PPOINT_TYPE_RETURN, $this->siteLangId);
        $product['selprod_warranty_policies'] =  SellerProduct::getSelprodPolicies($product['selprod_id'], PolicyPoint::PPOINT_TYPE_WARRANTY, $this->siteLangId);
        /* Form buy product[ */
        $frm = $this->getCartForm($this->siteLangId);
        $frm->fill(array('selprod_id' => $selprod_id));
        $this->set('frmBuyProduct', $frm);
        /* ] */

        $optionSrchObj = clone $prodSrchObj;
        $optionSrchObj->setDefinedCriteria();
        $optionSrchObj->doNotCalculateRecords();
        $optionSrchObj->doNotLimitRecords();
        $optionSrchObj->joinTable(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'LEFT OUTER JOIN', 'selprod_id = tspo.selprodoption_selprod_id', 'tspo');
        $optionSrchObj->joinTable(OptionValue::DB_TBL, 'LEFT OUTER JOIN', 'tspo.selprodoption_optionvalue_id = opval.optionvalue_id', 'opval');
        $optionSrchObj->joinTable(Option::DB_TBL, 'LEFT OUTER JOIN', 'opval.optionvalue_option_id = op.option_id', 'op');
        if (FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE', FatUtility::VAR_INT, 0)) {
            $validDateCondition = " and oss.ossubs_till_date >= '".date('Y-m-d')."'";
            $optionSrchObj->joinTable(Orders::DB_TBL, 'INNER JOIN', 'o.order_user_id=seller_user.user_id AND o.order_type='.ORDERS::ORDER_SUBSCRIPTION.' AND o.order_is_paid =1', 'o');
            $optionSrchObj->joinTable(OrderSubscription::DB_TBL, 'INNER JOIN', 'o.order_id = oss.ossubs_order_id and oss.ossubs_status_id='.FatApp::getConfig('CONF_DEFAULT_SUBSCRIPTION_PAID_ORDER_STATUS').$validDateCondition, 'oss');
        }
        $optionSrchObj->addCondition('product_id', '=', $product['product_id']);

        $optionSrch = clone $optionSrchObj;
        $optionSrch->joinTable(Option::DB_TBL.'_lang', 'LEFT OUTER JOIN', 'op.option_id = op_l.optionlang_option_id AND op_l.optionlang_lang_id = '. $this->siteLangId, 'op_l');
        $optionSrch->addMultipleFields(array(  'option_id', 'option_is_color', 'ifNULL(option_name,option_identifier) as option_name' ));
        $optionSrch->addCondition('option_id', '!=', 'NULL');
        $optionSrch->addCondition('selprodoption_selprod_id', '=', $selprod_id);
        $optionSrch->addGroupBy('option_id');

        $optionRs = $optionSrch->getResultSet();
        if (true ===  MOBILE_APP_API_CALL) {
            $optionRows = FatApp::getDb()->fetchAll($optionRs);
        } else {
            $optionRows = FatApp::getDb()->fetchAll($optionRs, 'option_id');
        }
        if ($optionRows) {
            foreach ($optionRows as &$option) {
                $optionValueSrch = clone $optionSrchObj;
                $optionValueSrch->joinTable(OptionValue::DB_TBL.'_lang', 'LEFT OUTER JOIN', 'opval.optionvalue_id = opval_l.optionvaluelang_optionvalue_id AND opval_l.optionvaluelang_lang_id = '. $this->siteLangId, 'opval_l');
                $optionValueSrch->addCondition('product_id', '=', $product['product_id']);
                $optionValueSrch->addCondition('option_id', '=', $option['option_id']);
                $optionValueSrch->addMultipleFields(array( 'IFNULL(product_name, product_identifier) as product_name','selprod_id','selprod_user_id','selprod_code','option_id','ifNULL(optionvalue_name,optionvalue_identifier) as optionvalue_name ', 'theprice', 'optionvalue_id','optionvalue_color_code'));
                $optionValueSrch->addGroupBy('optionvalue_id');
                $optionValueRs = $optionValueSrch->getResultSet();
                if (true ===  MOBILE_APP_API_CALL) {
                    $optionValueRows = FatApp::getDb()->fetchAll($optionValueRs);
                } else {
                    $optionValueRows = FatApp::getDb()->fetchAll($optionValueRs, 'optionvalue_id');
                }
                $option['values'] = $optionValueRows;
            }
        }
        $this->set('optionRows', $optionRows);



        /* Product group attributes[ */
        /* $attributes = array();
        $infoAttributes = array();
        $numericAttributes = array();
        $textAttributes  = array();
        if( $product['product_attrgrp_id'] ){
        $srch = AttrGroupAttribute::getSearchObject();
        $srch->joinTable( AttrGroupAttribute::DB_TBL.'_lang', 'LEFT JOIN', 'lang.attrlang_attr_id = '. AttrGroupAttribute::DB_TBL_PREFIX.'id AND attrlang_lang_id = '.$this->siteLangId, 'lang');
        $srch->addCondition( AttrGroupAttribute::DB_TBL_PREFIX.'attrgrp_id', '=', $product['product_attrgrp_id'] );
        //$srch->addCondition( AttrGroupAttribute::DB_TBL_PREFIX.'type', '!=', AttrGroupAttribute::ATTRTYPE_TEXT );
        $srch->addOrder( AttrGroupAttribute::DB_TBL_PREFIX.'display_order');
        $srch->addMultipleFields( array('IFNULL( attr_name, attr_identifier ) as attr_name', 'attr_type', 'attr_fld_name','attr_options','attr_prefix','attr_postfix') );
        $rs = $srch->getResultSet();
        $attributes = FatApp::getDb()->fetchAll($rs);
        $numericAttributes = Product::getProductNumericAttributes( $product['product_id'] );
        $textAttributes = Product::getProductTextualAttributes( $this->siteLangId, $product['product_id'] );
        }
        $this->set( 'attributes', $attributes );
        $this->set( 'infoAttributes', $numericAttributes + $textAttributes ); */
        /* ] */



        /* product combo/batch[ */
        /*
        $productGroups = $sellerProduct->getGroupsToProduct($this->siteLangId);
        if( $productGroups ){
        foreach( $productGroups as $key => &$pg ){
        $srch = new ProductSearch( $this->siteLangId, ProductGroup::DB_PRODUCT_TO_GROUP, ProductGroup::DB_PRODUCT_TO_GROUP_PREFIX.'product_id' );
        $srch->setBatchProductsCriteria();
        $srch->addCondition( ProductGroup::DB_PRODUCT_TO_GROUP_PREFIX.'prodgroup_id', '=', $pg['ptg_prodgroup_id'] );
        $srch->addMultipleFields( array( 'selprod_id', 'product_id', 'selprod_stock', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'IFNULL(splprice_price, selprod_price) AS theprice', 'CASE WHEN splprice_selprod_id IS NULL THEN 0 ELSE 1 END AS special_price_found' ) );
        $rs = $srch->getResultSet();
        $pg_products = FatApp::getDb()->fetchAll($rs);
        //$pg_products = $sellerProduct->getProductsToGroup( $pg['ptg_prodgroup_id'], $this->siteLangId );
        if( $pg_products ){
        foreach( $pg_products as $pg_product){
         if( !$pg_product['in_stock'] ){
          unset($productGroups[$key]);
          continue 2;
         }
        }
        }
        $pg['products'] = $pg_products;
        }
        } */
        $sellerProduct = new SellerProduct($selprod_id);
        $criteria = array('selprod_id');
        $upsellProducts = $sellerProduct->getUpsellProducts($product['selprod_id'], $this->siteLangId);
        $relatedProducts = $sellerProduct->getRelatedProducts($product['selprod_id'], $this->siteLangId, $criteria);
        $relatedProductsRs = $this->relatedProductsById(array_keys($relatedProducts));

        $srch = new ShopSearch($this->siteLangId);
        $srch->setDefinedCriteria($this->siteLangId);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(
            array( 'shop_id','shop_user_id','shop_ltemplate_id', 'shop_created_on', 'IFNULL(shop_identifier, shop_name) as shop_name', 'shop_description', 'shop_payment_policy', 'shop_delivery_policy', 'shop_refund_policy',  'ifNULL(shop_country_l.country_name,shop_country.country_code) as shop_country_name', 'ifNULL(shop_state_l.state_name,state_identifier) as shop_state_name', 'shop_city','shop_free_ship_upto' )
        );
        $srch->addCondition('shop_id', '=', $product['shop_id']);
        $shopRs = $srch->getResultSet();
        $shop = FatApp::getDb()->fetch($shopRs);

        $shop_rating = 0;
        if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) {
            $shop_rating = SelProdRating::getSellerRating($shop['shop_user_id']);
        }

        /*   [ Promotional Banner   */
        $banners = BannerLocation::getPromotionalBanners(BannerLocation::PRODUCT_DETAIL_PAGE_BANNER, $this->siteLangId);
        /* End of Prmotional Banner  ]*/

        /* Get Product Specifications */
        $this->set('productSpecifications', $this->getProductSpecifications($product['product_id'], $this->siteLangId));
        /* End of Product Specifications */

        $canSubmitFeedback = true;
        if ($loggedUserId) {
            $orderProduct = SelProdReview::getProductOrderId($product['product_id'], $loggedUserId);
            if (!Orders::canSubmitFeedback($loggedUserId, $orderProduct['op_order_id'], $selprod_id)) {
                $canSubmitFeedback = false;
            }
        }

        $this->set('canSubmitFeedback', $canSubmitFeedback);
        $this->set('upsellProducts', !empty($upsellProducts) ? $upsellProducts : array());
        $this->set('relatedProductsRs', !empty($relatedProductsRs) ? $relatedProductsRs : array());
        $this->set('banners', $banners);
        $this->set('product', $product);
        $this->set('shop_rating', $shop_rating);
        $this->set('shop', $shop);
        $this->set('shopTotalReviews', SelProdReview::getSellerTotalReviews($shop['shop_user_id']));
        $this->set('productImagesArr', $productGroupImages);
        //    $this->set( 'productGroups', $productGroups );
        $frmReviewSearch = $this->getReviewSearchForm(5);
        $frmReviewSearch->fill(array('selprod_id'=>$selprod_id));
        $this->set('frmReviewSearch', $frmReviewSearch);

        /* Get product Polls [ */
        $pollQuest = Polling::getProductPoll($product['product_id'], $this->siteLangId);
        $this->set('pollQuest', $pollQuest);
        /* ] */

        /* Get Product Volume Discount (if any)[ */
        $this->set('volumeDiscountRows', $sellerProduct->getVolumeDiscounts());
        /* ] */

        if (!empty($product)) {
            $afile_id = !empty($productGroupImages)? array_keys($productGroupImages)[0] : 0;
            $this->set('socialShareContent', $this->getOgTags($product, $afile_id));
        }

        /* Recommnended Products [ */
        $loggedUserId = UserAuthentication::getLoggedUserId(true);
        $recommendedProducts = $this->getRecommendedProducts($selprod_id, $this->siteLangId, $loggedUserId);
        $this->set('recommendedProducts', $recommendedProducts);
        /* ]  */

        $this->setRecentlyViewedItem($selprod_id);

        if (false ===  MOBILE_APP_API_CALL) {
            $this->_template->addCss(array('css/slick.css','css/modaal.css','css/product-detail.css','css/cart.css','css/xzoom.css','css/magnific-popup.css'));
            $this->_template->addJs(array('js/slick.js','js/modaal.js','js/product-detail.js','js/responsive-img.min.js','js/xzoom.js','js/magnific-popup.js'));
        }

        $this->_template->render();
    }

    private function getProductSpecifications($product_id, $langId)
    {
        $product_id = FatUtility::int($product_id);
        $langId = FatUtility::int($langId);
        if (1 > $product_id) {
            return array();
        }
        $specSrchObj = new ProductSearch($langId);
        $specSrchObj->setDefinedCriteria();
        $specSrchObj->doNotCalculateRecords();
        $specSrchObj->doNotLimitRecords();
        $specSrchObj->joinTable(Product::DB_PRODUCT_SPECIFICATION, 'LEFT OUTER JOIN', 'product_id = tcps.prodspec_product_id', 'tcps');
        $specSrchObj->joinTable(Product::DB_PRODUCT_LANG_SPECIFICATION, 'INNER JOIN', 'tcps.prodspec_id = tcpsl.prodspeclang_prodspec_id and   prodspeclang_lang_id  = '.$langId, 'tcpsl');
        $specSrchObj->addMultipleFields(array('prodspec_id','prodspec_name','prodspec_value'));
        $specSrchObj->addGroupBy('prodspec_id');
        $specSrchObj->addCondition('prodspec_product_id', '=', $product_id);
        $specSrchObjRs = $specSrchObj->getResultSet();
        return FatApp::getDb()->fetchAll($specSrchObjRs);
    }

    private function getMoreSeller($selprodCode, $langId, $userId = 0)
    {
        $userId = FatUtility::int($userId);
        $langId = FatUtility::int($langId);

        $moreSellerSrch = new ProductSearch($langId);
        $moreSellerSrch->addMoreSellerCriteria($selprodCode, $userId);
        /*$moreSellerSrch->addMultipleFields(array( 'selprod_id', 'selprod_user_id', 'selprod_price', 'special_price_found', 'theprice', 'shop_id', 'shop_name' ,'IF(selprod_stock > 0, 1, 0) AS in_stock'));*/
        $moreSellerSrch->addMultipleFields(
            array('selprod_id','selprod_user_id','selprod_price','special_price_found','theprice','shop_id','shop_name', 'product_seller_id','product_id','shop_country_l.country_name as shop_country_name','shop_state_l.state_name as shop_state_name','shop_city','selprod_cod_enabled','product_cod_enabled','IF(selprod_stock > 0, 1, 0) AS in_stock','selprod_min_order_qty','selprod_available_from')
        );
        $moreSellerSrch->addHaving('in_stock', '>', 0);
        $moreSellerSrch->addOrder('theprice');
        $moreSellerSrch->addGroupBy('selprod_id');
        $moreSellerRs = $moreSellerSrch->getResultSet();
        return FatApp::getDb()->fetchAll($moreSellerRs);
    }

    private function setRecentlyViewedItem($selprod_id)
    {
        $selprod_id = FatUtility::int($selprod_id);
        if (1 > $selprod_id) {
            return;
        }

        $recentProductsArr = array();
        if (!isset($_COOKIE['recentViewedProducts'])) {
            setcookie('recentViewedProducts', $selprod_id.'_', time()+60*60*72, CONF_WEBROOT_URL);
        } else {
            $recentProducts = $_COOKIE['recentViewedProducts'];
            $recentProductsArr = explode('_', $recentProducts);
        }

        $products = array();

        if (is_array($recentProductsArr) && !in_array($selprod_id, $recentProductsArr)) {
            if (count($recentProductsArr) >= 10) {
                $recentProductsArr = array_reverse($recentProductsArr);
                array_pop($recentProductsArr);
                $recentProductsArr = array_reverse($recentProductsArr);
            }

            foreach ($recentProductsArr as $val) {
                if ($val == '') {
                    continue;
                }
                array_push($products, $val);
            }
            array_push($products, $selprod_id);
            setcookie('recentViewedProducts', implode('_', $products), time()+60*60*72, CONF_WEBROOT_URL);
        }
    }

    private function getRecommendedProducts($selprod_id, $langId, $userId = 0)
    {
        $selprod_id = FatUtility::int($selprod_id);
        if (1 > $selprod_id) {
            return;
        }

        $productId = SellerProduct::getAttributesById($selprod_id, 'selprod_product_id', false);

        $srch = new ProductSearch($langId);
        $join_price = 1;
        $srch->setDefinedCriteria($join_price);
        $srch->joinProductToCategory();
        $srch->joinSellerSubscription();
        $srch->addSubscriptionValidCondition();
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addMultipleFields(
            array(
            'product_id','prodcat_id','substring_index(group_concat(IFNULL(prodcat_name, prodcat_identifier) ORDER BY IFNULL(prodcat_name, prodcat_identifier) ASC SEPARATOR "," ) , ",", 1) as prodcat_name', 'IFNULL(product_name, product_identifier) as product_name', 'product_model', 'product_short_description', 'product_image_updated_on',
            'selprod_id', 'selprod_user_id',  'selprod_code', 'selprod_stock', 'selprod_condition', 'selprod_price', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
            'special_price_found','splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type',
            'theprice', 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description', 'user_name',
            'IF(selprod_stock > 0, 1, 0) AS in_stock','selprod_sold_count','selprod_return_policy','ifnull(prod_rating,0) prod_rating'
                 )
        );

        $dateToEquate = date('Y-m-d');

        $recommendedProductsQuery = "(select rec_product_id , weightage from
                            (
                                SELECT ppr_recommended_product_id as rec_product_id , ppr_weightage as weightage from tbl_product_product_recommendation
                                where ppr_viewing_product_id = $productId order by ppr_weightage desc limit 5
                            ) as set1
                            union
                            select rec_product_id , weightage from
                            (
                                select tpr_product_id  as rec_product_id , if(tpr_custom_weightage_valid_till <= '$dateToEquate' , tpr_custom_weightage+tpr_weightage , tpr_weightage) as weightage from
                                (
                                    select * from tbl_product_to_tags where ptt_product_id = $productId
                                ) innerSet1 inner JOIN tbl_tag_product_recommendation on tpr_tag_id = ptt_tag_id
                                order by if(tpr_custom_weightage_valid_till <= '$dateToEquate' , tpr_custom_weightage+tpr_weightage , tpr_weightage) desc limit 5
                            ) as set2
                            ";
        if (0 < $userId) {
            $recommendedProductsQuery.= " union
                            select rec_product_id , weightage from
                            (
                                SELECT upr_product_id as rec_product_id , upr_weightage as weightage from tbl_user_product_recommendation
                                where upr_user_id = $userId order by upr_weightage desc limit 5
                            ) as set3 " ;
        }

        $recommendedProductsQuery.= ")";

        $srch->joinTable("$recommendedProductsQuery", 'inner join', 'rs1.rec_product_id = product_id', 'rs1');
        $srch->addGroupBy('product_id');

        if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
            $srch->joinFavouriteProducts($userId);
            $srch->addFld('ufp_id');
        } else {
            $srch->joinUserWishListProducts($userId);
            $srch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
        }

        $selProdReviewObj = new SelProdReviewSearch();
        $selProdReviewObj->joinSelProdRating();
        $selProdReviewObj->addCondition('sprating_rating_type', '=', SelProdRating::TYPE_PRODUCT);
        $selProdReviewObj->doNotCalculateRecords();
        $selProdReviewObj->doNotLimitRecords();
        $selProdReviewObj->addGroupBy('spr.spreview_product_id');
        $selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id',"ROUND(AVG(sprating_rating),2) as prod_rating"));
        $selProdRviewSubQuery = $selProdReviewObj->getQuery();
        $srch->joinTable('(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_selprod_id = selprod_id', 'sq_sprating');
        $srch->setPageSize(5);
        $srch->doNotCalculateRecords();
        return $recommendedProducts = FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    private function getOgTags($product = array(), $afile_id = 0)
    {
        if (empty($product)) {
            return array();
        }
        $afile_id = FatUtility::int($afile_id);
        $title  = $product['product_name'];

        if ($product['selprod_title']) {
            $title = $product['selprod_title'];
        }

        $product_description = trim(CommonHelper::subStringByWords(strip_tags(CommonHelper::renderHtml($product["product_description"], true)), 500));
        $product_description .= ' - '.Labels::getLabel('LBL_See_more_at', $this->siteLangId).": ".CommonHelper::getCurrUrl();

        $productImageUrl = '';
        /* $productImageUrl = CommonHelper::generateFullUrl('Image','product', array($product['product_id'],'', $product['selprod_id'],0,$this->siteLangId )); */
        if (0 < $afile_id) {
            $productImageUrl = CommonHelper::generateFullUrl('Image', 'product', array($product['product_id'], 'FB_RECOMMEND', 0, $afile_id ));
        }
        $socialShareContent = array(
        'type'=>'Product',
        'title'=>$title,
        'description'=>$product_description,
        'image'=>$productImageUrl,
        );
        return $socialShareContent;
    }

    public function getProductShippingRates()
    {
        $post  = FatApp::getPostedData();
        $productId =  $post['productId'];
        $sellerId =  $post['sellerId'];
    }

    public function recentlyViewedProducts($productId = 0)
    {
        $productId = FatUtility::int($productId);
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }
        $recentViewedProducts = array();
        $cookieProducts = isset($_COOKIE['recentViewedProducts']) ? $_COOKIE['recentViewedProducts'] : false;
        if ($cookieProducts != false) {
            $cookiesProductsArr = explode("_", $cookieProducts);
            if (!isset($cookiesProductsArr) || !is_array($cookiesProductsArr) || count($cookiesProductsArr) <= 0) {
                return '';
            }
            if ($productId && in_array($productId, $cookiesProductsArr)) {
                $pos = array_search($productId, $cookiesProductsArr);
                unset($cookiesProductsArr[$pos]);
            }
            if (isset($cookiesProductsArr) && is_array($cookiesProductsArr) && count($cookiesProductsArr)) {
                $cookiesProductsArr = array_map('intval', $cookiesProductsArr);
                $cookiesProductsArr = array_reverse($cookiesProductsArr);

                $prodSrch = new ProductSearch($this->siteLangId);
                $prodSrch->setDefinedCriteria();
                $prodSrch->joinSellerSubscription();
                $prodSrch->addSubscriptionValidCondition();
                $prodSrch->joinProductToCategory();
                $prodSrch->doNotCalculateRecords();
                $prodSrch->doNotLimitRecords();
                if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
                    $prodSrch->joinFavouriteProducts($loggedUserId);
                    $prodSrch->addFld('ufp_id');
                } else {
                    $prodSrch->joinUserWishListProducts($loggedUserId);
                    $prodSrch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
                }
                $prodSrch->addCondition('selprod_id', 'IN', $cookiesProductsArr);
                $prodSrch->addMultipleFields(
                    array(
                    'product_id', 'IFNULL(product_name, product_identifier) as product_name', 'prodcat_id', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name', 'product_image_updated_on',
                    'selprod_id', 'selprod_condition', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'theprice',
                    'special_price_found', 'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type','selprod_sold_count', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title','selprod_price')
                );
                // echo $prodSrch->getQuery(); die;

                $productRs = $prodSrch->getResultSet();
                $recentViewedProducts = FatApp::getDb()->fetchAll($productRs, 'selprod_id');
                uksort(
                    $recentViewedProducts,
                    function ($key1, $key2) use ($cookiesProductsArr) {
                        return (array_search($key1, $cookiesProductsArr) > array_search($key2, $cookiesProductsArr));
                    }
                );
            }
        }
        $this->set('recentViewedProducts', $recentViewedProducts);
        $this->_template->render(false, false);
    }

    public function relatedProductsById($ids = array())
    {
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }

        if (isset($ids) && is_array($ids) && count($ids)) {
            $prodSrch = new ProductSearch($this->siteLangId);
            $prodSrch->setDefinedCriteria();
            $prodSrch->joinProductToCategory();
            $prodSrch->doNotCalculateRecords();

            if (true ===  MOBILE_APP_API_CALL) {
                $prodSrch->joinTable(SelProdReview::DB_TBL, 'LEFT OUTER JOIN', 'spr.spreview_selprod_id = selprod_id AND spr.spreview_product_id = product_id', 'spr');
                $prodSrch->joinTable(SelProdRating::DB_TBL, 'LEFT OUTER JOIN', 'sprating.sprating_spreview_id = spr.spreview_id', 'sprating');
                $prodSrch->addFld(array('IFNULL(ROUND(AVG(sprating_rating),2),0) as prod_rating'));
            }

            $prodSrch->doNotLimitRecords();
            if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
                $prodSrch->joinFavouriteProducts($loggedUserId);
                $prodSrch->addFld('ufp_id');
            } else {
                $prodSrch->joinUserWishListProducts($loggedUserId);
                $prodSrch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
            }
            // $prodSrch->joinProductRating();
            $prodSrch->addCondition('selprod_id', 'IN', $ids);
            $prodSrch->addMultipleFields(
                array(
                'product_id', 'IFNULL(product_name, product_identifier) as product_name', 'prodcat_id', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name', 'product_image_updated_on', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
                'selprod_id', 'selprod_condition', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'theprice',
                'special_price_found', 'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type','selprod_sold_count','selprod_price')
            );

            $productRs = $prodSrch->getResultSet();
            $products = FatApp::getDb()->fetchAll($productRs, 'selprod_id');

            uksort(
                $products,
                function ($key1, $key2) use ($ids) {
                    return (array_search($key1, $ids) > array_search($key2, $ids));
                }
            );

            return $products;
        }
    }

    public function searchProducttagsAutocomplete()
    {
        $post = FatApp::getPostedData();
        $srch = Tag::getSearchObject($this->siteLangId);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(array('IFNULL(tag_name, tag_identifier) as value'));
        $srch->addOrder("LOCATE('".urldecode($post["keyword"])."',value)");
        $srch->addGroupby('value');
        $srch->addHaving('value', 'LIKE', '%'.urldecode($post["keyword"]).'%');
        $rs = $srch->getResultSet();
        $tags = FatApp::getDb()->fetchAll($rs);
        die(json_encode(array('suggestions'=>$tags)));
    }

    public function getBreadcrumbNodes($action)
    {
        $nodes = array();
        $parameters = FatApp::getParameters();
        switch ($action) {
            case 'view':
                if (isset($parameters[0]) && FatUtility::int($parameters[0]) > 0) {
                    $selprod_id = FatUtility::int($parameters[0]);
                    if ($selprod_id) {
                        $srch = new ProductSearch($this->siteLangId);
                        $srch->joinSellerProducts();
                        $srch->joinProductToCategory();
                        $srch->doNotCalculateRecords();
                        $srch->doNotLimitRecords();
                        $srch->addMultipleFields(array('IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title','IFNULL(product_name, product_identifier)as product_name','prodcat_code'));
                        $srch->addCondition('selprod_id', '=', $selprod_id);
                        $rs = $srch->getResultSet();
                        $row = FatApp::getDb()->fetch($rs);
                        if ($row) {
                            $productCatCode = $row['prodcat_code'];
                            $productCatCode =  explode("_", $productCatCode);
                            $productCatCode  = array_filter($productCatCode, 'strlen');
                            $productCatObj = new ProductCategory;
                            $prodCategories =  $productCatObj->getCategoriesForSelectBox($this->siteLangId, '', $productCatCode);

                            foreach ($productCatCode as $code) {
                                $code= FatUtility::int($code);
                                if (isset($prodCategories[$code]['prodcat_name'])) {
                                    $prodCategories[$code]['prodcat_name'];
                                    $nodes[] = array('title' => $prodCategories[$code]['prodcat_name'],'href'=>CommonHelper::generateUrl('category', 'view', array($code)));
                                }
                            }
                            $nodes[] = array('title' => ($row['selprod_title'])? $row['selprod_title']:$row['product_name']);
                        }
                    }
                }
                break;
            default:
                $nodes[] = array('title' => Labels::getLabel('LBL_'.FatUtility::camel2dashed($action), $this->siteLangId));
                break;
        }
        return $nodes;
    }

    public function logWeightage()
    {
        $post  = FatApp::getPostedData();
        $selprod_code = (isset($post['selprod_code']) && $post['selprod_code'] !='')?$post['selprod_code']:'';

        if ($selprod_code == '') {
            return false;
        }

        $weightageKey = SmartWeightageSettings::PRODUCT_VIEW ;
        if (isset($post['timeSpend']) && $post['timeSpend'] == true) {
            $weightageKey = SmartWeightageSettings::PRODUCT_TIME_SPENT;
        }

        $weightageSettings = SmartWeightageSettings::getWeightageAssoc();
        Product::recordProductWeightage($selprod_code, $weightageKey, $weightageSettings[$weightageKey]);
    }

    private function getCartForm($formLangId)
    {
        $frm = new Form('frmBuyProduct', array('id'=>'frmBuyProduct'));
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Quantity', $formLangId), 'quantity', 1, array('maxlength' => '3'));
        $fld->requirements()->setIntPositive();
        // $frm->addSubmitButton(null, 'btnProductBuy', Labels::getLabel('LBL_Buy_Now', $formLangId ), array( 'id' => 'btnProductBuy' ) );
        //$frm->addSubmitButton(null, 'btnAddToCart', Labels::getLabel('LBL_Add_to_Cart', $formLangId), array( 'id' => 'btnAddToCart' ));
        $frm->addHTML(null, 'btnProductBuy', '<button name="btnProductBuy" type="submit" id="btnProductBuy" class="btn btn--primary block-on-mobile add-to-cart--js btnBuyNow"> '.Labels::getLabel('LBL_Buy_Now', $formLangId).'</button>');
        $frm->addHTML(null, 'btnAddToCart', '<button name="btnAddToCart" type="submit" id="btnAddToCart" class="btn btn--secondary block-on-mobile add-to-cart--js btn--primary-border"> '.Labels::getLabel('LBL_Add_to_Cart', $formLangId).'</button>');
        $frm->addHiddenField('', 'selprod_id');
        return $frm;
    }

    private function getReviewSearchForm($pageSize = 10)
    {
        $frm = new Form('frmReviewSearch');
        $frm->addHiddenField('', 'selprod_id');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'pageSize', $pageSize);
        $frm->addHiddenField('', 'orderBy', 'most_helpful');
        return $frm;
    }

    private function getReviewAbuseForm($reviewId)
    {
        $frm = new Form('frmReviewAbuse');
        $frm->addHiddenField('', 'spra_spreview_id', $reviewId);
        $frm->addTextarea(Labels::getLabel('Lbl_Comments', $this->siteLangId), 'spra_comments');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('Lbl_Report_Abuse', $this->siteLangId));
        return $frm;
    }

    private function getPollForm($pollId, $langId)
    {
        $frm = new Form('frmPoll');
        $frm->addHiddenField('', 'polling_id', $pollId);
        $frm->addRadioButtons('', 'polling_feedback', Polling::getPollingResponseTypeArr($langId), '', array('class'=>'listing--vertical listing--vertical-chcek'), array());
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('Lbl_Vote', $this->siteLangId), array('class'=>'btn btn--primary poll--link-js'));
        return $frm;
    }

    public function fatActionCatchAll($action)
    {
        FatUtility::exitWithErrorCode(404);
    }

    public function track($productId = 0)
    {
        $bannerId = FatUtility::int($productId);
        if (1 > $productId) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            FatApp::redirectUser(CommonHelper::generateUrl(''));
        }
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }
        /* Track Click */
        $prodObj = new PromotionSearch($this->siteLangId, true);
        $prodObj->joinProducts();
        $prodObj->joinActiveUser();
        $prodObj->joinShops();
        $prodObj->addPromotionTypeCondition(Promotion::TYPE_PRODUCT);
        $prodObj->addShopActiveExpiredCondition();
        $prodObj->joinUserWallet();
        $prodObj->joinBudget();
        $prodObj->addBudgetCondition();
        $prodObj->doNotCalculateRecords();
        $prodObj->addMultipleFields(array('selprod_id as proSelProdId','promotion_id'));
        $prodObj->addCondition('promotion_record_id', '=', $productId);
        $sponsoredProducts = array();
        $productSrchObj = new ProductSearch($this->siteLangId);
        $productSrchObj->joinProductToCategory($this->siteLangId);
        $productSrchObj->doNotCalculateRecords();
        $productSrchObj->setPageSize(10);
        $productSrchObj->setDefinedCriteria();

        if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
            $productSrchObj->joinFavouriteProducts($loggedUserId);
            $productSrchObj->addFld('ufp_id');
        } else {
            $productSrchObj->joinUserWishListProducts($loggedUserId);
            $productSrchObj->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
        }
        $productSrchObj->joinProductRating();
        $productSrchObj->addMultipleFields(
            array('product_id', 'selprod_id', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
            'special_price_found', 'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type',
            'theprice', 'selprod_price','selprod_stock', 'selprod_condition','prodcat_id','IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','ifnull(sq_sprating.prod_rating,0) prod_rating ','selprod_sold_count')
        );

        $productCatSrchObj = ProductCategory::getSearchObject(false, $this->siteLangId);
        $productCatSrchObj->doNotCalculateRecords();
        /* $productCatSrchObj->setPageSize(4); */
        $productCatSrchObj->addMultipleFields(array('prodcat_id', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','prodcat_description'));

        $productSrchObj->joinTable('(' . $prodObj->getQuery().') ', 'INNER JOIN', 'selprod_id = ppr.proSelProdId ', 'ppr');
        $productSrchObj->addFld(array('promotion_id'));
        $productSrchObj->joinSellerSubscription();
        $productSrchObj->addSubscriptionValidCondition();
        $productSrchObj->addGroupBy('selprod_id');

        $rs = $productSrchObj->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $url  = CommonHelper::generateFullUrl('products', 'view', array($productId));
        if ($row == false) {
            if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
                FatApp::redirectUser($url);
            }
        }

        $userId = 0;
        if (UserAuthentication::isUserLogged()) {
            $userId = UserAuthentication::getLoggedUserId();
        }

        if (Promotion::isUserClickCountable($userId, $row['promotion_id'], $_SERVER['REMOTE_ADDR'], session_id())) {
            $promotionClickData = array(
            'pclick_promotion_id' => $row['promotion_id'],
            'pclick_user_id' => $userId,
            'pclick_datetime' => date('Y-m-d H:i:s'),
            'pclick_ip' => $_SERVER['REMOTE_ADDR'],
            'pclick_cost' => Promotion::getPromotionCostPerClick(Promotion::TYPE_PRODUCT),
            'pclick_session_id' => session_id(),
            );

            FatApp::getDb()->insertFromArray(Promotion::DB_TBL_CLICKS, $promotionClickData, false, '', $promotionClickData);
            $clickId= FatApp::getDb()->getInsertId();

            $promotionClickChargesData = array(
            'picharge_pclick_id' => $clickId,
            'picharge_datetime'  => date('Y-m-d H:i:s'),
            'picharge_cost'  => Promotion::getPromotionCostPerClick(Promotion::TYPE_PRODUCT),
            );

            FatApp::getDb()->insertFromArray(Promotion::DB_TBL_ITEM_CHARGES, $promotionClickChargesData, false);

            $promotionLogData = array(
            'plog_promotion_id' => $row['promotion_id'],
            'plog_date' =>  date('Y-m-d'),
            'plog_clicks' =>  1,
            );

            $onDuplicatePromotionLogData = array_merge($promotionLogData, array('plog_clicks'=>'mysql_func_plog_clicks+1'));
            FatApp::getDb()->insertFromArray(Promotion::DB_TBL_LOGS, $promotionLogData, true, array(), $onDuplicatePromotionLogData);
        }

        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
            FatApp::redirectUser($url);
        }

        FatApp::redirectUser(CommonHelper::generateUrl(''));
    }

    public function setUrlString()
    {
        $urlString = FatApp::getPostedData('urlString', FatUtility::VAR_STRING, '');
        if ($urlString != '') {
            $_SESSION['referer_page_url'] = rtrim($urlString, '/').'/';
        }
    }

    public function sellers($selprod_id)
    {
        $selprod_id = FatUtility::int($selprod_id);
        $prodSrchObj = new ProductSearch($this->siteLangId);

        /* fetch requested product[ */
        $prodSrch = clone $prodSrchObj;
        $prodSrch->setDefinedCriteria(0, 0, array(), false);
        $prodSrch->joinProductToCategory();
        $prodSrch->joinSellerSubscription();
        $prodSrch->addSubscriptionValidCondition();
        $prodSrch->doNotCalculateRecords();
        $prodSrch->addCondition('selprod_id', '=', $selprod_id);
        $prodSrch->doNotLimitRecords();

        /* sub query to find out that logged user have marked current product as in wishlist or not[ */
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }

        $selProdReviewObj = new SelProdReviewSearch();
        $selProdReviewObj->joinSelProdRating();
        $selProdReviewObj->addCondition('sprating_rating_type', '=', SelProdRating::TYPE_PRODUCT);
        $selProdReviewObj->doNotCalculateRecords();
        $selProdReviewObj->doNotLimitRecords();
        $selProdReviewObj->addGroupBy('spr.spreview_product_id');
        $selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id','spr.spreview_product_id',"ROUND(AVG(sprating_rating),2) as prod_rating","count(spreview_id) as totReviews"));
        $selProdRviewSubQuery = $selProdReviewObj->getQuery();
        $prodSrch->joinTable('(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_product_id = product_id', 'sq_sprating');

        $prodSrch->addMultipleFields(
            array(
            'product_id','IFNULL(product_name,product_identifier ) as product_name','product_seller_id','product_model', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','product_upc','product_isbn','product_short_description','product_description','selprod_id','selprod_user_id','selprod_code','selprod_condition','selprod_price','special_price_found','splprice_start_date', 'splprice_end_date','IFNULL(selprod_title,IFNULL(product_name,product_identifier)) as selprod_title','selprod_warranty','selprod_return_policy','selprodComments','theprice','selprod_stock', 'selprod_threshold_stock_level','IF(selprod_stock > 0, 1, 0) AS in_stock','brand_id','IFNULL(brand_name, brand_identifier) as brand_name','brand_short_description','user_name','shop_id','shop_name','ifnull(sq_sprating.prod_rating,0) prod_rating ','ifnull(sq_sprating.totReviews,0) totReviews','splprice_display_dis_type','splprice_display_dis_val','splprice_display_list_price','product_attrgrp_id','product_youtube_video','product_cod_enabled','selprod_cod_enabled')
        );

        $productRs = $prodSrch->getResultSet();
        $product = FatApp::getDb()->fetch($productRs);
        /* ] */

        if (!$product) {
            FatUtility::exitWithErrorCode(404);
        }
        /* more sellers[ */
        $product['moreSellersArr'] = $this->getMoreSeller($product['selprod_code'], $this->siteLangId);

        foreach ($product['moreSellersArr'] as $seller) {
            if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) {
                $product['rating'][$seller['selprod_user_id']]= SelProdRating::getSellerRating($seller['selprod_user_id']);
            } else {
                $product['rating'][$seller['selprod_user_id']]= 0;
            }

            /*[ Check COD enabled*/
            $codEnabled = false;
            if (Product::isProductShippedBySeller($seller['product_id'], $seller['product_seller_id'], $seller['selprod_user_id'])) {
                if ($product['selprod_cod_enabled']) {
                    $codEnabled = true;
                }
            } else {
                if ($product['product_cod_enabled']) {
                    $codEnabled = true;
                }
            }
            $product['cod'][$seller['selprod_user_id']] = $codEnabled ;
            /*]*/
        }
        /* ] */
        $this->set('product', $product);
        $this->_template->render();
    }

    public function productQuickDetail($selprod_id = 0)
    {
        $productImagesArr = array();
        $selprod_id = FatUtility::int($selprod_id);
        $prodSrchObj = new ProductSearch($this->siteLangId);

        /* fetch requested product[ */
        $prodSrch = clone $prodSrchObj;
        $prodSrch->setDefinedCriteria(false, false, array(), false);
        $prodSrch->joinProductToCategory();
        $prodSrch->joinSellerSubscription();
        $prodSrch->addSubscriptionValidCondition();
        $prodSrch->doNotCalculateRecords();
        $prodSrch->addCondition('selprod_id', '=', $selprod_id);
        $prodSrch->doNotLimitRecords();

        /* sub query to find out that logged user have marked current product as in wishlist or not[ */
        $loggedUserId = 0;
        if (UserAuthentication::isUserLogged()) {
            $loggedUserId = UserAuthentication::getLoggedUserId();
        }

        if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
            $prodSrch->joinFavouriteProducts($loggedUserId);
            $prodSrch->addFld('ufp_id');
        } else {
            $prodSrch->joinUserWishListProducts($loggedUserId);
            $prodSrch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
        }

        $prodSrch->addMultipleFields(array('product_id','product_identifier','IFNULL(product_name,product_identifier) as product_name','product_seller_id','product_model','product_type','prodcat_id','IFNULL(prodcat_name,prodcat_identifier) as prodcat_name','product_upc','product_isbn','product_short_description','product_description','selprod_id','selprod_user_id','selprod_code', 'selprod_condition','selprod_price','special_price_found','splprice_start_date', 'splprice_end_date','IFNULL(selprod_title,IFNULL(product_name, product_identifier)) as selprod_title','selprod_warranty','selprod_return_policy','selprodComments','theprice', 'selprod_stock','selprod_threshold_stock_level','IF(selprod_stock > 0, 1, 0) AS in_stock', 'brand_id','IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description', 'user_name','shop_id', 'shop_name','splprice_display_dis_type', 'splprice_display_dis_val', 'splprice_display_list_price','product_attrgrp_id', 'product_youtube_video', 'product_cod_enabled','selprod_cod_enabled','selprod_available_from'));
        /* echo $selprod_id; die; */
        $productRs = $prodSrch->getResultSet();
        $product = FatApp::getDb()->fetch($productRs);
        /* ] */

        if (!$product) {
            FatUtility::exitWithErrorCode(404);
        }

        $subscription = false;
        $allowed_images =-1;
        if (FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE')) {
            $allowed_images = OrderSubscription::getUserCurrentActivePlanDetails($this->siteLangId, $product['selprod_user_id'], array('ossubs_images_allowed'));
            $subscription = true;
        }

        /* Current Product option Values[ */
        $options = SellerProduct::getSellerProductOptions($selprod_id, false);
        /* CommonHelper::printArray($options);die(); */
        $productSelectedOptionValues = array();
        $productGroupImages= array();
        if ($options) {
            foreach ($options as $op) {
                /* Product UPC code [ */
                /* $product['product_upc'] = UpcCode::getUpcCode( $product['product_id'] , $op['selprodoption_optionvalue_id'] ); */
                /* ] */
                $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], $op['selprodoption_optionvalue_id'], $this->siteLangId, true, '', $allowed_images);
                if ($images) {
                    $productImagesArr += $images;
                }
                $productSelectedOptionValues[$op['selprodoption_option_id']] = $op['selprodoption_optionvalue_id'];
            }
        }

        if ($productImagesArr) {
            foreach ($productImagesArr as $image) {
                $afileId = $image['afile_id'];
                if (!array_key_exists($afileId, $productGroupImages)) {
                    $productGroupImages[$afileId] = array();
                }
                $productGroupImages[$afileId] = $image;
            }
        }
        $product['selectedOptionValues'] = $productSelectedOptionValues;
        /* ] */

        if (isset($allowed_images) && $allowed_images >0) {
            $universal_allowed_images_count = $allowed_images  - count($productImagesArr);
        }

        $productUniversalImagesArr = array();
        if (empty($productGroupImages) ||  !$subscription || isset($universal_allowed_images_count)) {
            $universalImages = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], -1, $this->siteLangId, true, '');
            /* CommonHelper::printArray($universalImages); die; */
            if ($universalImages) {
                if (isset($universal_allowed_images_count)) {
                    $images = array_slice($universalImages, 0, $universal_allowed_images_count);
                    $productUniversalImagesArr = $images;
                    $universal_allowed_images_count = $universal_allowed_images_count  - count($productUniversalImagesArr);
                } elseif (!$subscription) {
                    $productUniversalImagesArr = $universalImages;
                }
            }
        }

        if ($productUniversalImagesArr) {
            foreach ($productUniversalImagesArr as $image) {
                $afileId = $image['afile_id'];
                if (!array_key_exists($afileId, $productGroupImages)) {
                    $productGroupImages[$afileId] = array();
                }
                $productGroupImages[$afileId] = $image;
            }
        }

        /*[ Product shipping cost */
        $shippingCost = 0;
        /*]*/

        /* more sellers[ */
        $product['moreSellersArr'] = $this->getMoreSeller($product['selprod_code'], $this->siteLangId, $product['selprod_user_id']);
        /* ] */

        $product['selprod_return_policies'] =  SellerProduct::getSelprodPolicies($product['selprod_id'], PolicyPoint::PPOINT_TYPE_RETURN, $this->siteLangId);
        $product['selprod_warranty_policies'] =  SellerProduct::getSelprodPolicies($product['selprod_id'], PolicyPoint::PPOINT_TYPE_WARRANTY, $this->siteLangId);

        /* Form buy product[ */
        $frm = $this->getCartForm($this->siteLangId);
        $frm->fill(array('selprod_id' => $selprod_id));
        $this->set('frmBuyProduct', $frm);
        /* ] */

        $optionSrchObj = clone $prodSrchObj;
        $optionSrchObj->setDefinedCriteria();
        $optionSrchObj->doNotCalculateRecords();
        $optionSrchObj->doNotLimitRecords();
        $optionSrchObj->joinTable(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'LEFT OUTER JOIN', 'selprod_id = tspo.selprodoption_selprod_id', 'tspo');
        $optionSrchObj->joinTable(OptionValue::DB_TBL, 'LEFT OUTER JOIN', 'tspo.selprodoption_optionvalue_id = opval.optionvalue_id', 'opval');
        $optionSrchObj->joinTable(Option::DB_TBL, 'LEFT OUTER JOIN', 'opval.optionvalue_option_id = op.option_id', 'op');
        if (FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE', FatUtility::VAR_INT, 0)) {
            $validDateCondition = " and oss.ossubs_till_date >= '".date('Y-m-d')."'";
            $optionSrchObj->joinTable(Orders::DB_TBL, 'INNER JOIN', 'o.order_user_id=seller_user.user_id AND o.order_type='.ORDERS::ORDER_SUBSCRIPTION.' AND o.order_is_paid =1', 'o');
            $optionSrchObj->joinTable(OrderSubscription::DB_TBL, 'INNER JOIN', 'o.order_id = oss.ossubs_order_id and oss.ossubs_status_id='.FatApp::getConfig('CONF_DEFAULT_SUBSCRIPTION_PAID_ORDER_STATUS').$validDateCondition, 'oss');
        }
        $optionSrchObj->addCondition('product_id', '=', $product['product_id']);

        $optionSrch = clone $optionSrchObj;
        $optionSrch->joinTable(Option::DB_TBL.'_lang', 'LEFT OUTER JOIN', 'op.option_id = op_l.optionlang_option_id AND op_l.optionlang_lang_id = '. $this->siteLangId, 'op_l');
        $optionSrch->addMultipleFields(array(  'option_id', 'option_is_color', 'ifNULL(option_name,option_identifier) as option_name' ));
        $optionSrch->addCondition('option_id', '!=', 'NULL');
        $optionSrch->addCondition('selprodoption_selprod_id', '=', $selprod_id);
        $optionSrch->addGroupBy('option_id');
        /* echo $optionSrch->getQuery();die; */
        $optionRs = $optionSrch->getResultSet();
        $optionRows = FatApp::getDb()->fetchAll($optionRs, 'option_id');
        /* CommonHelper::printArray($optionRows);die; */
        if ($optionRows) {
            foreach ($optionRows as &$option) {
                $optionValueSrch = clone $optionSrchObj;
                $optionValueSrch->joinTable(OptionValue::DB_TBL.'_lang', 'LEFT OUTER JOIN', 'opval.optionvalue_id = opval_l.optionvaluelang_optionvalue_id AND opval_l.optionvaluelang_lang_id = '. $this->siteLangId, 'opval_l');
                $optionValueSrch->addCondition('product_id', '=', $product['product_id']);
                $optionValueSrch->addCondition('option_id', '=', $option['option_id']);
                $optionValueSrch->addMultipleFields(array( 'IFNULL(product_name, product_identifier) as product_name','selprod_id','selprod_user_id','selprod_code','option_id','ifNULL(optionvalue_name,optionvalue_identifier) as optionvalue_name ', 'theprice', 'optionvalue_id','optionvalue_color_code'));
                $optionValueSrch->addGroupBy('optionvalue_id');
                $optionValueRs = $optionValueSrch->getResultSet();
                $optionValueRows = FatApp::getDb()->fetchAll($optionValueRs, 'optionvalue_id');
                $option['values'] = $optionValueRows;
            }
        }
        $this->set('optionRows', $optionRows);

        /* Get Product Specifications */
        $this->set('productSpecifications', $this->getProductSpecifications($product['product_id'], $this->siteLangId));
        /* End of Product Specifications */

        if ($product) {
            $title  = $product['product_name'];

            if ($product['selprod_title']) {
                $title = $product['selprod_title'];
            }

            $product_description = trim(CommonHelper::subStringByWords(strip_tags(CommonHelper::renderHtml($product["product_description"], true)), 500));
            $product_description .= ' - '.Labels::getLabel('LBL_See_more_at', $this->siteLangId).": ".CommonHelper::getCurrUrl();

            $productImageUrl = '';
            /* $productImageUrl = CommonHelper::generateFullUrl('Image','product', array($product['product_id'],'', $product['selprod_id'],0,$this->siteLangId )); */
            if ($productImagesArr) {
                $afile_id = array_keys($productImagesArr)[0];
                $productImageUrl = CommonHelper::generateFullUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $afile_id ));
            }
        }
        $this->set('product', $product);
        $this->set('productImagesArr', $productGroupImages);
        $this->_template->render(false, false);
    }

    public function linksAutocomplete()
    {
        $prodCatObj = new ProductCategory();
        $post = FatApp::getPostedData();
        $arr_options = $prodCatObj->getProdCatTreeStructureSearch(0, $this->siteLangId, $post['keyword']);
        $json = array();
        foreach ($arr_options as $key => $product) {
            $json[] = array(
            'id'     => $key,
            'name'  => strip_tags(html_entity_decode($product, ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

    private function getListingData($get)
    {
        $db = FatApp::getDb();

        /* to show searched category data[ */
        $categoryId = null;
        $category = array();
        if (array_key_exists('category', $get)) {
            $categoryId = FatUtility::int($get['category']);
            if ($categoryId) {
                $productCategorySearch = new ProductCategorySearch($this->siteLangId);
                $productCategorySearch->addCondition('prodcat_id', '=', $categoryId);
                $productCategorySearch->addMultipleFields(array('prodcat_id','IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','prodcat_description','prodcat_code'));
                $productCategorySearchRs = $productCategorySearch->getResultSet();
                $category = $db->fetch($productCategorySearchRs);
                $category['banner'] = AttachedFile::getAttachment(AttachedFile::FILETYPE_CATEGORY_BANNER, $categoryId);
            }
        }
        /* ] */

        $userId = 0;
        if (UserAuthentication::isUserLogged()) {
            $userId = UserAuthentication::getLoggedUserId();
        }

        $page = 1;
        if (array_key_exists('page', $get)) {
            $page = FatUtility::int($get['page']);
            if ($page < 2) {
                $page = 1;
            }
        }

        $pageSize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10);
        if (array_key_exists('pageSize', $get)) {
            $pageSize = FatUtility::int($get['pageSize']);
            if (0 >= $pageSize) {
                $pageSize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10);
            }
        }

        $srch = Product::getListingObj($get, $this->siteLangId, $userId);
        $srch->setPageNumber($page);
        if ($pageSize) {
            $srch->setPageSize($pageSize);
        }
        //echo $srch->getQuery();exit;
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $products = $db->fetchAll($rs);

        $data = array(
            'products'=>$products,
            'category'=>$category,
            'categoryId'=>$categoryId,
            'postedData'=>$get,
            'page'=>$page,
            'pageCount'=>$srch->pages(),
            'pageSize'=>$pageSize,
            'recordCount'=>$srch->recordCount(),
            'siteLangId'=>$this->siteLangId
        );
        return $data;
    }

    public function getFilteredProducts()
    {
        $post = FatApp::getPostedData();
        $userId = UserAuthentication::getLoggedUserId(true);

        $page = 1;
        if (array_key_exists('page', $post)) {
            $page = FatUtility::int($post['page']);
            if ($page < 2) {
                $page = 1;
            }
        }

        $pageSize = !empty($post['pageSize']) ? FatUtility::int($post['pageSize']) : FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10);

        $srch = Product::getListingObj($post, $this->siteLangId, $userId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $products = $db->fetchAll($rs);

        $data = array(
            'products'=>$products,
            'page'=>$page,
            'pageCount'=>$srch->pages(),
            'pageSize'=>$pageSize,
            'recordCount'=>$srch->recordCount()
        );
        $this->set('data', $data);
        $this->_template->render();
    }
}
