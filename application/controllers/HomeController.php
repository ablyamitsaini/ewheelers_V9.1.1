<?php
class HomeController extends MyAppController
{
    public function index()
    {
        $db = FatApp::getDb();
        $loggedUserId = UserAuthentication::getLoggedUserId(true);

        $productSrchObj = new ProductSearch($this->siteLangId);
        $productSrchObj->joinProductToCategory();
        /* $productSrchObj->doNotCalculateRecords();
        $productSrchObj->setPageSize( 10 ); */
        $productSrchObj->setDefinedCriteria();
        $productSrchObj->joinSellerSubscription($this->siteLangId, true);
        $productSrchObj->addSubscriptionValidCondition();
        // $productSrchObj->joinProductRating();

        if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
            $productSrchObj->joinFavouriteProducts($loggedUserId);
            $productSrchObj->addFld('ufp_id');
        } else {
            $productSrchObj->joinUserWishListProducts($loggedUserId);
            $productSrchObj->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
        }

        $productSrchObj->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $productSrchObj->addMultipleFields(array('product_id','selprod_id','IFNULL(product_name, product_identifier) as product_name','IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title','product_image_updated_on','special_price_found', 'splprice_display_list_price','splprice_display_dis_val','splprice_display_dis_type','theprice','selprod_price','selprod_stock','selprod_condition','prodcat_id','IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','selprod_sold_count','IF(selprod_stock > 0, 1, 0) AS in_stock'));

        $collections = $this->getCollections($this->siteLangId, $productSrchObj);
        $sponsoredShops = $this->getSponsoredShops($this->siteLangId, $productSrchObj);
        $sponsoredProds = $this->getSponsoredProducts($this->siteLangId, $productSrchObj);
        $slides = $this->getSlides($this->siteLangId);
        $banners = $this->getBanners($this->siteLangId);

        $this->set('sponsoredProds', $sponsoredProds);
        $this->set('sponsoredShops', $sponsoredShops);
        $this->set('slides', $slides);
        $this->set('banners', $banners);
        $this->set('collections', $collections);
        $this->_template->addJs(array('js/slick.min.js', 'js/responsive-img.min.js'));
        $this->_template->addCss(array('css/slick.css', 'css/product-detail.css'));
        $this->_template->render();
    }

    public function setLanguage($langId = 0)
    {
        if (!FatUtility::isAjaxCall()) {
            die('Invalid Action.');
        }

        $langId =  FatUtility::int($langId);
        if (0 < $langId) {
            $languages = Language::getAllNames();
            if (array_key_exists($langId, $languages)) {
                setcookie('defaultSiteLang', $langId, time()+3600*24*10, CONF_WEBROOT_URL);
            }
        }
    }

    public function setCurrency($currencyId = 0)
    {
        if (!FatUtility::isAjaxCall()) {
            die('Invalid Action.');
        }

        $currencyId =  FatUtility::int($currencyId);
        $currencyObj = new Currency();

        if (0 < $currencyId) {
            $currencies = Currency::getCurrencyAssoc($this->siteLangId);
            if (array_key_exists($currencyId, $currencies)) {
                setcookie('defaultSiteCurrency', $currencyId, time()+3600*24*10, CONF_WEBROOT_URL);
            }
        }
    }

    public function setCurrentLocation()
    {
        $post = FatApp::getPostedData();

        $countryCode = $post['country'];
        $this->updateSettingByCurrentLocation($countryCode);

        if (!$_SESSION['geo_location']) {
            Message::addErrorMessage(Labels::getLabel('MSG_Current_Location', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }
        $this->set('msg', Labels::getLabel('MSG_Settings_with_your_current_location_setup_successful', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateSettingByCurrentLocation($countryCode = '')
    {
        if (!$countryCode) {
            return ;
        }

        $row = Countries::getCountryByCode($countryCode, array('country_code','country_id','country_currency_id','country_language_id'));
        if ($row == false) {
            return false;
        }
        $_SESSION['geo_location'] = true;
        $this->setCurrency($row['country_currency_id']);
        $this->setLanguage($row['country_language_id']);
    }

    public function affiliateReferral($referralCode)
    {
        $userSrchObj = User::getSearchObject();
        $userSrchObj->doNotCalculateRecords();
        $userSrchObj->doNotLimitRecords();
        $userSrchObj->addCondition('user_referral_code', '=', $referralCode);
        $userSrchObj->addMultipleFields(array('user_id', 'user_referral_code' ));
        $rs = $userSrchObj->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if ($row && $referralCode != '' && $row['user_referral_code'] == $referralCode) {
            $cookieExpiryDays = FatApp::getConfig("CONF_AFFILIATE_REFERRER_URL_VALIDITY", FatUtility::VAR_INT, 5);

            $cookieValue = array('data' => $row['user_referral_code'], 'creation_time' => time());
            $cookieValue = serialize($cookieValue);
            CommonHelper::setCookie('affiliate_referrer_code_signup', $cookieValue, time()+3600*24*$cookieExpiryDays);
        }
        FatApp::redirectUser(CommonHelper::generateUrl());
    }

    public function referral($userReferralCode)
    {
        $userSrchObj = User::getSearchObject();
        $userSrchObj->doNotCalculateRecords();
        $userSrchObj->doNotLimitRecords();
        $userSrchObj->addCondition('user_referral_code', '=', $userReferralCode);
        $userSrchObj->addMultipleFields(array('user_id', 'user_referral_code' ));
        $rs = $userSrchObj->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if ($row && $userReferralCode != '' && $row['user_referral_code'] == $userReferralCode) {
            $cookieExpiryDays = FatApp::getConfig("CONF_REFERRER_URL_VALIDITY", FatUtility::VAR_INT, 10);

            $cookieValue = array('data' => $row['user_referral_code'], 'creation_time' => time());
            $cookieValue = serialize($cookieValue);

            CommonHelper::setCookie('referrer_code_signup', $cookieValue, time()+3600*24*$cookieExpiryDays);
            CommonHelper::setCookie('referrer_code_checkout', $row['user_referral_code'], time()+3600*24*$cookieExpiryDays);
        }
        FatApp::redirectUser(CommonHelper::generateUrl());
    }

    private function getCollections($langId, $productSrchObj)
    {
        $collectionCache =  FatCache::get('collectionCache_'.$langId, CONF_HOME_PAGE_CACHE_TIME, '.txt');

        if ($collectionCache) {
            return  unserialize($collectionCache);
        }

        $db = FatApp::getDb();

        $srch = new CollectionSearch($langId);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addOrder('collection_display_order', 'ASC');
        $srch->addMultipleFields(array('collection_id', 'IFNULL(collection_name,collection_identifier) as collection_name','IFNULL( collection_description, "" ) as collection_description','IFNULL(collection_link_caption, "") as collection_link_caption','collection_link_url', 'collection_layout_type','collection_type','collection_criteria','collection_child_records','collection_primary_records'));
        $rs = $srch->getResultSet();
        $collectionsArr = $db->fetchAll($rs, 'collection_id');
        if (empty($collectionsArr)) {
            return array();
        }

        $collections = array();

        $productCatSrchObj = ProductCategory::getSearchObject(false, $langId);
        $productCatSrchObj->doNotCalculateRecords();
        $productCatSrchObj->addMultipleFields(array('prodcat_id', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','prodcat_description'));

        $collectionObj = new CollectionSearch();
        foreach ($collectionsArr as $collection_id => $collection) {
            if (!$collection['collection_primary_records']) {
                continue;
            }

            switch ($collection['collection_type']) {
                case Collections::COLLECTION_TYPE_PRODUCT:
                    $tempObj = clone $collectionObj;
                    $tempObj->joinCollectionProducts();
                    $tempObj->addCondition('collection_id', '=', $collection_id);
                    /* $tempObj->setPageSize( $collection['collection_primary_records']); */
                    $tempObj->addMultipleFields(array( 'ctsp_selprod_id' ));
                    $tempObj->addCondition('ctsp_selprod_id', '!=', 'NULL');
                    $rs = $tempObj->getResultSet();

                    if (!$productIds = $db->fetchAll($rs, 'ctsp_selprod_id')) {
                        continue;
                    }

                    /* fetch Products data[ */
                    $orderBy = 'ASC';
                    if ($collection['collection_criteria'] == Collections::COLLECTION_CRITERIA_PRICE_HIGH_TO_LOW) {
                        $orderBy = 'DESC';
                    }

                    $productSrchTempObj = clone $productSrchObj;
                    $productSrchTempObj->addCondition('selprod_id', 'IN', array_keys($productIds));
                    $productSrchTempObj->addCondition('selprod_deleted', '=', applicationConstants::NO);
                    $productSrchTempObj->addOrder('theprice', $orderBy);
                    $productSrchTempObj->joinSellers();
                    $productSrchTempObj->joinSellerSubscription($langId);
                    $productSrchTempObj->addGroupBy('selprod_id');
                    $productSrchTempObj->setPageSize($collection['collection_primary_records']);
                    $rs = $productSrchTempObj->getResultSet();

                    $collections[$collection['collection_layout_type']][$collection['collection_id']] = $collection;
                    $collections[$collection['collection_layout_type']][$collection['collection_id']]['products'] = $db->fetchAll($rs, 'selprod_id');
                    $collections[$collection['collection_layout_type']][$collection['collection_id']]['totProducts'] = $productSrchTempObj->recordCount();
                    /* ] */
                    unset($tempObj);
                    unset($productSrchTempObj);
                    break;

                case Collections::COLLECTION_TYPE_CATEGORY:
                    $tempObj = clone $collectionObj;
                    $tempObj->addCondition('collection_id', '=', $collection_id);
                    $tempObj->joinCollectionCategories($langId);
                    $tempObj->addMultipleFields(array( 'ctpc_prodcat_id'));
                    $tempObj->addCondition('ctpc_prodcat_id', '!=', 'NULL');
                    $tempObj->setPageSize($collection['collection_primary_records']);

                    /* Exclude categories having no product [ */
                    /* $productSrchTempObj = clone $productSrchObj;
                    $productSrchTempObj->addGroupBy( 'prodcat_id' );
                    $productSrchTempObj->addMultipleFields( array('count(selprod_id) as productCounts', 'prodcat_id as qryProducts_prodcat_id') );
                    $productSrchTempObj->addCondition('selprod_deleted','=',applicationConstants::NO);
                    $tempObj->joinTable( '('.$productSrchTempObj->getQuery().')', 'LEFT OUTER JOIN', 'qryProducts.qryProducts_prodcat_id = prodcat_id', 'qryProducts' );
                    $tempObj->addCondition( 'qryProducts.productCounts', '>', 0 ); */
                    /* ] */

                    $rs = $tempObj->getResultSet();
                    if (!$categoryIds = $db->fetchAll($rs, 'ctpc_prodcat_id')) {
                        continue;
                    }

                    /* fetch Categories data[ */
                    $productCatSrchTempObj = clone $productCatSrchObj;
                    $productCatSrchTempObj->addCondition('prodcat_id', 'IN', array_keys($categoryIds));
                    $rs = $productCatSrchTempObj->getResultSet();
                    /* ] */

                    $collections[$collection['collection_layout_type']][$collection['collection_id']] = $collection;

                    if ($collection['collection_layout_type'] == Collections::TYPE_CATEGORY_LAYOUT2) {
                        while ($catData = $db->fetch($rs)) {
                            /* fetch Sub-Categories[ */
                            $subCategorySrch = clone $productCatSrchObj;
                            $subCategorySrch->addCondition('prodcat_parent', '=', $catData['prodcat_id']);
                            $Catrs = $subCategorySrch->getResultSet();

                            $collections[$collection['collection_layout_type']][$collection['collection_id']]['categories'][$catData['prodcat_id']] = $catData;
                            $collections[$collection['collection_layout_type']][$collection['collection_id']]['categories'][$catData['prodcat_id']]['subCategories'] = $db->fetchAll($Catrs);
                            /* ] */
                        }
                    } else {
                        while ($catData = $db->fetch($rs)) {
                            /* fetch Product data[ */
                            $productShopSrchTempObj = clone $productSrchObj;
                            $productShopSrchTempObj->addCondition('prodcat_id', '=', $catData['prodcat_id']);
                            $productShopSrchTempObj->addOrder('in_stock', 'DESC');
                            $productShopSrchTempObj->addGroupBy('selprod_product_id');
                            $productShopSrchTempObj->setPageSize(7);
                            $Prs = $productShopSrchTempObj->getResultSet();

                            $collections[$collection['collection_layout_type']][$collection['collection_id']]['categories'][$catData['prodcat_id']]['catData'] = $catData;
                            $collections[$collection['collection_layout_type']][$collection['collection_id']]['categories'][$catData['prodcat_id']]['products'] = $db->fetchAll($Prs);
                            /* ] */
                        }
                    }
                    $collections[$collection['collection_layout_type']][$collection['collection_id']]['totCategories'] = $tempObj->recordCount();
                    unset($tempObj);
                    break;
                case Collections::COLLECTION_TYPE_SHOP:
                    $tempObj = clone $collectionObj;
                    $tempObj->addCondition('collection_id', '=', $collection_id);
                    $tempObj->joinCollectionShops();
                    $tempObj->addMultipleFields(array( 'ctps_shop_id' ));
                    $tempObj->addCondition('ctps_shop_id', '!=', 'NULL');
                    // $tempObj->setPageSize( $collection['collection_primary_records'] );
                    $rs = $tempObj->getResultSet();

                    if (!$shopIds = $db->fetchAll($rs, 'ctps_shop_id')) {
                        continue;
                    }

                    $shopObj = new ShopSearch($langId);
                    $shopObj->setDefinedCriteria($langId);
                    $shopObj->joinSellerSubscription();
                    $shopObj->addCondition('shop_id', 'IN', array_keys($shopIds));
                    $shopObj->setPageSize($collection['collection_primary_records']);
                    $shopObj->addMultipleFields(array( 'shop_id','shop_user_id','IFNULL(shop_name, shop_identifier) as shop_name','IFNULL(country_name, country_code) as country_name','IFNULL(state_name, state_identifier) as state_name'));
                    $rs = $shopObj->getResultSet();

                    $collections[$collection['collection_layout_type']][$collection['collection_id']] = $collection;
                    $collections[$collection['collection_layout_type']][$collection['collection_id']]['totShops'] = $shopObj->recordCount();

                    while ($shopsData = $db->fetch($rs)) {
                        /* fetch Shop data[ */
                        $productShopSrchTempObj = clone $productSrchObj;
                        $productShopSrchTempObj->addCondition('selprod_user_id', '=', $shopsData['shop_user_id']);
                        $productShopSrchTempObj->addOrder('in_stock', 'DESC');
                        $productShopSrchTempObj->addGroupBy('selprod_product_id');
                        $productShopSrchTempObj->setPageSize(3);
                        $Prs = $productShopSrchTempObj->getResultSet();

                        $collections[$collection['collection_layout_type']][$collection['collection_id']]['shops'][$shopsData['shop_id']]['shopData'] = $shopsData;

                        $rating = 0;
                        if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) {
                            $rating = SelProdRating::getSellerRating($shopsData['shop_user_id']);
                        }

                        $collections[$collection['collection_layout_type']][$collection['collection_id']]['rating'][$shopsData['shop_id']] =  $rating;
                        $collections[$collection['collection_layout_type']][$collection['collection_id']]['shops'][$shopsData['shop_id']]['products'] = $db->fetchAll($Prs);
                        /* ] */
                    }
                    unset($tempObj);
                    break;
                case Collections::COLLECTION_TYPE_BRAND:
                    $tempObj = clone $collectionObj;
                    $tempObj->addCondition('collection_id', '=', $collection_id);
                    $tempObj->joinCollectionBrands($langId);
                    $tempObj->addMultipleFields(array('ctpb_brand_id'));
                    $tempObj->addCondition('ctpb_brand_id', '!=', 'NULL');
                    $rs = $tempObj->getResultSet();
                    $brandIds = $db->fetchAll($rs, 'ctpb_brand_id');

                    if (empty($brandIds)) {
                        continue;
                    }

                    /* fetch Brand data[ */
                    $brandSearchObj = Brand::getSearchObject($langId, true, true);
                    $brandSearchTempObj = clone $brandSearchObj;
                    $brandSearchTempObj->addMultipleFields(array('brand_id','IFNULL(brand_name, brand_identifier) as brand_name'));
                    $brandSearchTempObj->addCondition('brand_id', 'IN', array_keys($brandIds));
                    $brandSearchTempObj->setPageSize($collection['collection_primary_records']);
                    $rs = $brandSearchTempObj->getResultSet();
                    /* ] */
                    $collections[$collection['collection_layout_type']][$collection['collection_id']] = $collection;
                    $collections[$collection['collection_layout_type']][$collection['collection_id']]['totBrands'] = $brandSearchTempObj->recordCount();
                    $collections[$collection['collection_layout_type']][$collection['collection_id']]['brands'] = $db->fetchAll($rs);

                    unset($brandSearchTempObj);
                    unset($tempObj);
                    break;
            }
        }

        FatCache::set('collectionCache_'.$langId, serialize($collections), '.txt');
        return $collections;
    }

    private function getSlides($langId)
    {
        $db = FatApp::getDb();
        $srchSlide = new SlideSearch($langId);
        $srchSlide->doNotCalculateRecords();
        $srchSlide->joinPromotions($langId, true, true, true);
        $srchSlide->addPromotionTypeCondition();
        $srchSlide->joinUserWallet();
        $srchSlide->joinActiveUser();
        $srchSlide->addMinimiumWalletbalanceCondition();
        $srchSlide->addSkipExpiredPromotionAndSlideCondition();
        $srchSlide->joinBudget();
        $srchSlide->joinAttachedFile();
        $srchSlide->addMultipleFields(array('slide_id','slide_record_id','slide_type','IFNULL(promotion_name, promotion_identifier) as promotion_name,IFNULL(slide_title, slide_identifier) as slide_title','slide_target','slide_url','promotion_id','daily_cost','weekly_cost','monthly_cost','total_cost'));

        $totalSlidesPageSize = FatApp::getConfig('CONF_TOTAL_SLIDES_HOME_PAGE', FatUtility::VAR_INT, 4);
        $ppcSlidesPageSize = FatApp::getConfig('CONF_PPC_SLIDES_HOME_PAGE', FatUtility::VAR_INT, 4);

        $ppcSlides = array();
        $adminSlides = array();

        $slidesSrch = new SearchBase('('.$srchSlide->getQuery().') as t');
        $slidesSrch->addMultipleFields(array('slide_id','slide_type','slide_record_id','slide_url','slide_target','slide_title','promotion_id','userBalance','daily_cost','weekly_cost','monthly_cost','total_cost','promotion_budget' ,'promotion_duration'));
        $slidesSrch->addOrder('', 'rand()');

        if (0 < $ppcSlidesPageSize) {
            $ppcSrch  = clone $slidesSrch;
            $ppcSrch->addDirectCondition(
                '((CASE
					WHEN promotion_duration='.Promotion::DAILY.' THEN promotion_budget > COALESCE(daily_cost,0)
					WHEN promotion_duration='.Promotion::WEEKLY.' THEN promotion_budget > COALESCE(weekly_cost,0)
					WHEN promotion_duration='.Promotion::MONTHLY.' THEN promotion_budget > COALESCE(monthly_cost,0)
					WHEN promotion_duration='.Promotion::DURATION_NOT_AVAILABALE.' THEN promotion_budget = -1
				  END ) )'
            );

            $ppcSrch->addCondition('slide_type', '=', Slides::TYPE_PPC);
            $ppcSrch->setPageSize($ppcSlidesPageSize);
            $ppcRs = $ppcSrch->getResultSet();
            $ppcSlides = $db->fetchAll($ppcRs, 'slide_id');
        }

        $ppcSlidesCount = count($ppcSlides);
        if ($totalSlidesPageSize > $ppcSlidesCount) {
            $totalSlidesPageSize = $totalSlidesPageSize - $ppcSlidesCount;
            $adminSlideSrch  = clone $slidesSrch;
            $adminSlideSrch->addCondition('slide_type', '=', Slides::TYPE_SLIDE);
            $adminSlideSrch->setPageSize($totalSlidesPageSize);
            $slideRs = $adminSlideSrch->getResultSet();
            $adminSlides = $db->fetchAll($slideRs, 'slide_id');
        }

        $slides = array_merge($ppcSlides, $adminSlides);
        return $slides;
    }

    private function getBanners($langId)
    {
        $db = FatApp::getDb();
        $bannerSrch = Banner::getBannerLocationSrchObj(true);
        $bannerSrch->addCondition('blocation_id', '<=', BannerLocation::HOME_PAGE_BOTTOM_BANNER);
        $rs = $bannerSrch->getResultSet();
        $bannerLocation = $db->fetchAll($rs, 'blocation_key');

        $banners = $bannerLocation;
        foreach ($bannerLocation as $val) {
            $bsrch = new BannerSearch($langId, true);
            $bsrch->joinPromotions($langId, true, true, true);
            $bsrch->addPromotionTypeCondition();
            $bsrch->joinActiveUser();
            $bsrch->joinUserWallet();
            $bsrch->addMinimiumWalletbalanceCondition();
            $bsrch->addSkipExpiredPromotionAndBannerCondition();
            $bsrch->joinBudget();
            $bsrch->addMultipleFields(array('banner_id','banner_blocation_id','banner_type','banner_record_id','banner_url','banner_target','banner_title','promotion_id','daily_cost','weekly_cost','monthly_cost','total_cost'));
            $bsrch->doNotCalculateRecords();
            $bsrch->doNotLimitRecords();
            $bsrch->joinAttachedFile();
            $bsrch->addCondition('banner_blocation_id', '=', $val['blocation_id']);

            $srch = new SearchBase('('.$bsrch->getQuery().') as t');
            $srch->doNotCalculateRecords();
            $srch->addDirectCondition(
                '((CASE
					WHEN promotion_duration='.Promotion::DAILY.' THEN promotion_budget > COALESCE(daily_cost,0)
					WHEN promotion_duration='.Promotion::WEEKLY.' THEN promotion_budget > COALESCE(weekly_cost,0)
					WHEN promotion_duration='.Promotion::MONTHLY.' THEN promotion_budget > COALESCE(monthly_cost,0)
					WHEN promotion_duration='.Promotion::DURATION_NOT_AVAILABALE.' THEN promotion_budget = -1
				  END ) )'
            );

            $srch->addMultipleFields(array('banner_id','banner_blocation_id','banner_type','banner_record_id','banner_url','banner_target','banner_title','promotion_id','userBalance','daily_cost','weekly_cost','monthly_cost','total_cost','promotion_budget','promotion_duration'));

            $pageSize = 5;
            if ($val['blocation_banner_count'] > 0) {
                $pageSize = $val['blocation_banner_count'];
            }

            $srch->setPageSize($pageSize);
            $srch->addOrder('', 'rand()');
            $rs = $srch->getResultSet();

            $bannerListing = $db->fetchAll($rs, 'banner_id');
            $banners[$val['blocation_key']]['banners'] = $bannerListing;
        }
        return $banners;
    }

    private function getSponsoredShops($langId, $productSrchObj)
    {
        $shopPageSize = FatApp::getConfig('CONF_PPC_SHOPS_HOME_PAGE', FatUtility::VAR_INT, 2);
        if (1 > $shopPageSize) {
            return array();
        }

        $sponsoredShops = array();
        $db = FatApp::getDb();

        $shopObj  = new PromotionSearch($langId);
        $shopObj->setDefinedCriteria();
        $shopObj->joinActiveUser();
        $shopObj->joinShops($langId, true, true);
        $shopObj->joinShopCountry();
        $shopObj->joinShopState();
        $shopObj->addPromotionTypeCondition(Promotion::TYPE_SHOP);
        $shopObj->addShopActiveExpiredCondition();
        $shopObj->joinUserWallet();
        $shopObj->joinBudget();
        $shopObj->addBudgetCondition();
        $shopObj->addOrder('', 'rand()');
        $shopObj->setPageSize($shopPageSize);

        $rs = $shopObj->getResultSet();
        while ($shops = $db->fetch($rs)) {
            /* fetch Shop data[ */
            $productShopSrchTempObj = clone $productSrchObj;
            $productShopSrchTempObj->addCondition('selprod_user_id', '=', $shops['shop_user_id']);
            $productShopSrchTempObj->addGroupBy('selprod_product_id');
            $productShopSrchTempObj->doNotCalculateRecords();
            $productShopSrchTempObj->setPageSize(Shop::SHOP_PRODUCTS_COUNT_AT_HOMEPAGE);
            $Prs = $productShopSrchTempObj->getResultSet();

            $sponsoredShops['shops'][$shops['shop_id']]['shopData'] = $shops;
            $sponsoredShops['shops'][$shops['shop_id']]['shopData']['promotion_id'] = $shops['promotion_id'];

            $rating = 0;
            if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) {
                $rating = SelProdRating::getSellerRating($shops['shop_user_id']);
            }
            $sponsoredShops['rating'][$shops['shop_id']] =  $rating;
            $sponsoredShops['shops'][$shops['shop_id']]['products'] = $db->fetchAll($Prs);
            /* ] */
        }
        return $sponsoredShops;
    }

    private function getSponsoredProducts($langId, $productSrchObj)
    {
        $prodObj  = new PromotionSearch($langId);
        $prodObj->joinProducts();
        $prodObj->joinShops();
        $prodObj->addPromotionTypeCondition(Promotion::TYPE_PRODUCT);
        $prodObj->joinActiveUser();
        $prodObj->setDefinedCriteria();
        $prodObj->addShopActiveExpiredCondition();
        $prodObj->joinUserWallet();
        $prodObj->joinBudget();
        $prodObj->addBudgetCondition();
        $prodObj->doNotCalculateRecords();
        $prodObj->addMultipleFields(array('selprod_id as proSelProdId','promotion_id','promotion_record_id'));
        $productPageSize = FatApp::getConfig('CONF_PPC_PRODUCTS_HOME_PAGE', FatUtility::VAR_INT, 4);

        if (1 > $productPageSize) {
            return array();
        }

        $db = FatApp::getDb();
        $productSrchSponObj = clone $productSrchObj;
        $productSrchSponObj->joinTable('(' . $prodObj->getQuery().') ', 'INNER JOIN', 'selprod_id = ppr.proSelProdId ', 'ppr');
        $productSrchSponObj->addFld(array('promotion_id','promotion_record_id'));
        $productSrchSponObj->addOrder('theprice', 'ASC');
        $productSrchSponObj->joinSellers();
        $productSrchSponObj->joinSellerSubscription($langId);
        $productSrchSponObj->addGroupBy('selprod_id');
        $productSrchSponObj->doNotCalculateRecords();
        $productSrchSponObj->setPageSize($productPageSize);
        $productSrchSponObj->addOrder('', 'rand()');
        $rs = $productSrchSponObj->getResultSet();
        return $db->fetchAll($rs);
    }
}
