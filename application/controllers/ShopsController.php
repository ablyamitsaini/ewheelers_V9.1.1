<?php
class ShopsController extends MyAppController {
	//use CommonServices;

	public function __construct($action){
		parent::__construct($action);
	}

	public function index(){
		$searchForm = $this->getShopSearchForm($this->siteLangId);
		$this->set('searchForm',$searchForm);
		$this->_template->addJs('js/slick.min.js'); 
		$this->_template->addCss(array('css/slick.css','css/product-detail.css'));
		$this->_template->render();
	}

	public function featured(){
		$searchForm = $this->getShopSearchForm($this->siteLangId);
		$params['featured'] = 1;
		$searchForm->fill( $params );
		$this->set('searchForm',$searchForm);
		$this->_template->render();
	}

	public function search(){
		$db = FatApp::getDb();
		$data = FatApp::getPostedData();
		$page = (empty($data['page']) || $data['page'] <= 0) ? 1 : FatUtility::int($data['page']);
		$pagesize = FatApp::getConfig('CONF_PAGE_SIZE',FatUtility::VAR_INT, 10);

		$searchForm = $this->getShopSearchForm($this->siteLangId);
		$post = $searchForm->getFormDataFromArray($data);

		/* SubQuery, Shop have products[ */
		$prodShopSrch = new ProductSearch( $this->siteLangId );
		$prodShopSrch->setDefinedCriteria();
		$prodShopSrch->joinProductToCategory();
		$prodShopSrch->doNotCalculateRecords();
		$prodShopSrch->doNotLimitRecords();
		$prodShopSrch->joinSellerSubscription( $this->siteLangId, true );
		$prodShopSrch->addSubscriptionValidCondition();
		$prodShopSrch->addMultipleFields( array('distinct(shop_id)'));
		//$rs = $prodShopSrch->getResultSet();
		/* $productRows = FatApp::getDb()->fetchAll($rs);
		$shopMainRootArr = array_unique(array_column($productRows,'shop_id')); */
		/* ] */

		$srch = new ShopSearch( $this->siteLangId );
		$srch->setDefinedCriteria( $this->siteLangId );
		$srch->joinShopCountry();
		$srch->joinShopState();
		$srch->joinSellerSubscription();
		$srch->joinTable('('. $prodShopSrch->getQuery() . ')','INNER JOIN','temp.shop_id = s.shop_id','temp');
		/* if($shopMainRootArr){
			$srch->addCondition('shop_id', 'in', $shopMainRootArr);
		} */
		$loggedUserId = 0;
		if( UserAuthentication::isUserLogged() ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
		}

		/* sub query to find out that logged user have marked shops as favorite or not[ */
		$favSrchObj = new UserFavoriteShopSearch();
		$favSrchObj->doNotCalculateRecords();
		$favSrchObj->doNotLimitRecords();
		$favSrchObj->addMultipleFields(array('ufs_shop_id','ufs_id'));
		$favSrchObj->addCondition( 'ufs_user_id', '=', $loggedUserId );
		$srch->joinTable( '('. $favSrchObj->getQuery() . ')', 'LEFT OUTER JOIN', 'ufs_shop_id = s.shop_id', 'ufs' );
		/* ] */

		$srch->addMultipleFields(array( 's.shop_id','shop_user_id','shop_ltemplate_id', 'shop_created_on', 'shop_name', 'shop_description',
		'shop_country_l.country_name as country_name', 'shop_state_l.state_name as state_name', 'shop_city',
		'IFNULL(ufs.ufs_id, 0) as is_favorite' ));

		$featured = FatApp::getPostedData('featured', FatUtility::VAR_INT, 0);
		if(1 > $featured) {
			$srch->addCondition('shop_featured', '=', $featured);
		}

		$page = (empty($page) || $page <= 0)?1:$page;
		$page = FatUtility::int($page);
		$srch->setPageNumber($page);
		$srch->setPageSize($pagesize);

		$srch->addOrder('shop_created_on');
		$shopRs = $srch->getResultSet();
		$allShops = $db->fetchAll( $shopRs , 'shop_id' );

		$totalProdCountToDisplay = 4;
		$productSrchObj = new ProductSearch( $this->siteLangId );
		$productSrchObj->joinProductToCategory($this->siteLangId );
		$productSrchObj->doNotCalculateRecords();
		/* $productSrchObj->setPageSize( 10 ); */
		$productSrchObj->setDefinedCriteria();
		$productSrchObj->joinSellerSubscription($this->siteLangId , true);
		$productSrchObj->addSubscriptionValidCondition();
		$productSrchObj->joinProductRating( );
		
		if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){
			$productSrchObj->joinFavouriteProducts( $loggedUserId );
			$productSrchObj->addFld('ufp_id');
		}else{
			
			$productSrchObj->joinUserWishListProducts( $loggedUserId );
			$productSrchObj->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
		}
		
		$productSrchObj->addCondition( 'selprod_deleted', '=', applicationConstants::NO );
		$productSrchObj->addMultipleFields( array('product_id', 'selprod_id', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 
		'special_price_found', 'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type',
		'theprice', 'selprod_price','selprod_stock', 'selprod_condition','prodcat_id','IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','ifnull(sq_sprating.prod_rating,0) prod_rating ','selprod_sold_count','IF(selprod_stock > 0, 1, 0) AS in_stock') );
		foreach($allShops as $val){
			$productShopSrchTempObj = clone $productSrchObj;
			$productShopSrchTempObj->addCondition( 'selprod_user_id', '=', $val['shop_user_id']  ) ;
			$productShopSrchTempObj->addOrder('in_stock','DESC');
			$productShopSrchTempObj->addGroupBy('selprod_product_id');
			$productShopSrchTempObj->setPageSize(3);
			$Prs = $productShopSrchTempObj->getResultSet(); 				
			$allShops[$val['shop_id']]['products'] = $db->fetchAll( $Prs);
			$allShops[$val['shop_id']]['totalProducts'] = $productShopSrchTempObj->recordCount();
			$allShops[$val['shop_id']]['shopRating'] = SelProdRating::getSellerRating($val['shop_user_id']);
			$allShops[$val['shop_id']]['shopTotalReviews'] = SelProdReview::getSellerTotalReviews($val['shop_user_id']);
		}
		/* CommonHelper::printArray($allShops[4]['products']); */
		$this->set('allShops',$allShops);
		$this->set('totalProdCountToDisplay',$totalProdCountToDisplay);
		$this->set('pageCount',$srch->pages());
		$this->set('recordCount',$srch->recordCount());

		$this->set('page', $page);
		$this->set('pageSize', $pagesize);
		$this->set('postedData', $post);

		$startRecord = ($page-1)* $pagesize + 1 ;
		$endRecord = $pagesize;
		$totalRecords = $srch->recordCount();
		if ($totalRecords < $endRecord) { $endRecord = $totalRecords; }
		$json['totalRecords'] = $totalRecords;
		$json['startRecord'] = $startRecord;
		$json['endRecord'] = $endRecord;

		$json['html'] = $this->_template->render( false, false, 'shops/search.php', true, false);
		$json['loadMoreBtnHtml'] = $this->_template->render( false, false, '_partial/load-more-btn.php', true, false);
		FatUtility::dieJsonSuccess($json);
	}

	private function getShopSearchForm(){
		$frm = new Form('frmSearchShops');
		$frm->addHiddenField('', 'featured',0);
		return $frm;
	}

	protected function getSearchForm(){
		$frm = new Form('frmSearch');
		$frm->addTextBox('','keyword');
		$frm->addHiddenField('','shop_id');
		$frm->addHiddenField('','join_price');
		$frm->addSubmitButton('','btnProductSrchSubmit','');
		return $frm;
	}

	public function view( $shop_id ){
		$shop_id = FatUtility::int($shop_id);

		if( $shop_id <= 0 ){
			FatApp::redirectUser(CommonHelper::generateUrl('Seller' , 'Shop'));
		}
		$shopDetails = Shop::getAttributesByid($shop_id);
		if( UserAuthentication::isUserLogged() && UserAuthentication::getLoggedUserId() == $shopDetails['shop_user_id'] && !UserPrivilege::IsUserHasValidSubsription(UserAuthentication::getLoggedUserId()) ){
			Message::addInfo( Labels::getLabel("MSG_Please_buy_subscription", $this->siteLangId) );
			FatApp::redirectUser(CommonHelper::generateUrl('Seller','Packages'));
		}
		$this->shopDetail($shop_id); /* [defined in traits] */
		$searchFrm = $this->getSearchForm();
		$frm = $this->getProductSearchForm();

		$headerFormParamsArr = FatApp::getParameters();
		$headerFormParamsAssocArr = Product::convertArrToSrchFiltersAssocArr($headerFormParamsArr);

		if(array_key_exists('currency',$headerFormParamsAssocArr)){
			$headerFormParamsAssocArr['currency_id'] = $headerFormParamsAssocArr['currency'];
		}
		if(array_key_exists('sort',$headerFormParamsAssocArr)){
			$headerFormParamsAssocArr['sortOrder'] = $headerFormParamsAssocArr['sort'];
		}
		//$headerFormParamsAssocArr['join_price'] = 1;
		$headerFormParamsAssocArr['shop_id'] = $shop_id;
		$frm->fill($headerFormParamsAssocArr);

		$searchFrm->fill($headerFormParamsAssocArr);

		$prodSrchObj = new ProductSearch( $this->siteLangId );
		$prodSrchObj->setDefinedCriteria(0);
		$prodSrchObj->joinProductToCategory();
		$prodSrchObj->joinSellerSubscription();
		$prodSrchObj->addSubscriptionValidCondition();
		$prodSrchObj->doNotCalculateRecords();
		$prodSrchObj->setPageSize(FatApp::getConfig('CONF_PAGE_SIZE',FatUtility::VAR_INT, 10));
		$prodSrchObj->addShopIdCondition($shop_id);
		$prodSrchObj->addOrder('product_id');
		$rs = $prodSrchObj->getResultSet();
		$record = FatApp::getDb()->fetch($rs);
		if( empty($record) ){
			$this->set('noProductFound', 'noProductFound');
		}

		$this->set('frmProductSearch', $frm);
		$this->set('searchFrm', $searchFrm);
		$this->set('shopId', $shop_id);
		$this->set('canonicalUrl', CommonHelper::generateFullUrl('Shops','view',array($shop_id)));
		$this->_template->addJs('js/slick.min.js');
		$this->_template->addCss(array('css/slick.css','css/product-detail.css'));
		$this->_template->addJs('js/shop-nav.js');
		$this->_template->addJs('js/jquery.colourbrightness.min.js');
		$this->includeProductPageJsCss();

		$this->_template->render();
	}

	public function showBackgroundImage($shop_id =0,$lang_id =0,$templateId=''){
		$recordId = FatUtility::int($shop_id);
		$lang_id = FatUtility::int($lang_id);
		$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_SHOP_BACKGROUND_IMAGE, $recordId, 0, $lang_id );
		if(!$file_row && !$this->getAllowedShowBg($templateId)){
			return false;
		}

		return true;
	}

	public function shopDetail( $shop_id, $policy = false ){
		$db = FatApp::getDb();

		$headerFormParamsArr = FatApp::getParameters();
		$headerFormParamsAssocArr = Product::convertArrToSrchFiltersAssocArr($headerFormParamsArr);
		if(array_key_exists('currency',$headerFormParamsAssocArr)){
			$headerFormParamsAssocArr['currency_id'] = $headerFormParamsAssocArr['currency'];
		}
		if(array_key_exists('sort',$headerFormParamsAssocArr)){
			$headerFormParamsAssocArr['sortOrder'] = $headerFormParamsAssocArr['sort'];
		}
		if(array_key_exists('shop',$headerFormParamsAssocArr)){
			$headerFormParamsAssocArr['shop_id'] = $headerFormParamsAssocArr['shop'];
		}
		if(array_key_exists('collection',$headerFormParamsAssocArr)){
			$headerFormParamsAssocArr['collection_id'] = $headerFormParamsAssocArr['collection'];
		}

		$srch = new ShopSearch( $this->siteLangId );
		$srch->setDefinedCriteria( $this->siteLangId );
		$srch->joinSellerSubscription();
		$srch->doNotCalculateRecords();
		$srch->joinTable( 'tbl_users', 'LEFT OUTER JOIN', 'tu.user_id = shop_user_id', 'tu' );
		$loggedUserId = 0;
		if( UserAuthentication::isUserLogged() ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
		}

		/* sub query to find out that logged user have marked current shop as favorite or not[ */
		$favSrchObj = new UserFavoriteShopSearch();
		$favSrchObj->doNotCalculateRecords();
		$favSrchObj->doNotLimitRecords();
		$favSrchObj->addMultipleFields(array('ufs_shop_id','ufs_id'));
		$favSrchObj->addCondition( 'ufs_user_id', '=', $loggedUserId );
		$favSrchObj->addCondition( 'ufs_shop_id', '=', $shop_id );
		$srch->joinTable( '('. $favSrchObj->getQuery() . ')', 'LEFT OUTER JOIN', 'ufs_shop_id = shop_id', 'ufs' );
		/* ] */

		$srch->addMultipleFields(array( 'shop_id','tu.user_name','shop_user_id','shop_ltemplate_id', 'shop_created_on', 'shop_name', 'shop_description',
		'shop_country_l.country_name as shop_country_name', 'shop_state_l.state_name as shop_state_name', 'shop_city',
		'IFNULL(ufs.ufs_id, 0) as is_favorite' ));
		$srch->addCondition( 'shop_id', '=', $shop_id );
		if($policy){
			$srch->addMultipleFields(array('shop_payment_policy', 'shop_delivery_policy','shop_refund_policy','shop_additional_info','shop_seller_info'));
		}
		//echo $srch->getQuery();
		$shopRs = $srch->getResultSet();
		$shop = $db->fetch( $shopRs );

		if( !$shop ){
			FatApp::redirectUser(FatUtility::exitWithErrorCode('404'));
		}

		$prodSrchObj = new ProductSearch( $this->siteLangId );
		$prodSrchObj->setDefinedCriteria();
		$prodSrchObj->joinSellerSubscription();
		$prodSrchObj->addSubscriptionValidCondition();
		$prodSrchObj->addShopIdCondition($shop_id);
		$prodSrchObj->joinProductToCategory();
		$prodSrchObj->doNotCalculateRecords();
		$prodSrchObj->doNotLimitRecords();

		/* Categories Data[ */
		$catSrch = clone $prodSrchObj;
		$catSrch->addGroupBy('prodcat_id');


		$productCatObj = new ProductCategory;
		$productCategories =  $productCatObj->getCategoriesForSelectBox($this->siteLangId);

		$categoriesArr = ProductCategory::getProdCatParentChildWiseArr($this->siteLangId, 0, false, false, false, $catSrch,true);


		usort($categoriesArr, function($a, $b) {
		  return $a['prodcat_code'] - $b['prodcat_code'];
		});


		/* ] */

		/* Brand Filters Data[ */
		$brandSrch = clone $prodSrchObj;
		$brandSrch->addGroupBy('brand_id');
		$brandSrch->addOrder('brand_name');
		$brandSrch->addMultipleFields(array( 'brand_id', 'ifNull(brand_name,brand_identifier) as brand_name'));
		/* if needs to show product counts under brands[ */
		//$brandSrch->addFld('count(selprod_id) as totalProducts');
		/* ] */
		$brandRs = $brandSrch->getResultSet();
		$brandsArr = $db->fetchAll($brandRs);

		/* ] */

		/* Condition filters data[ */
		$conditionSrch = clone $prodSrchObj;
		$conditionSrch->addGroupBy('selprod_condition');
		$conditionSrch->addOrder('selprod_condition');
		$conditionSrch->addMultipleFields( array('selprod_condition') );
		//echo $conditionSrch->getQuery(); die();
		/* if needs to show product counts under any condition[ */
		//$conditionSrch->addFld('count(selprod_condition) as totalProducts');
		/* ] */
		$conditionRs = $conditionSrch->getResultSet();
		$conditionsArr = $db->fetchAll($conditionRs);
		/* ] */

		/* Price Filters[ */
		$priceSrch = clone $prodSrchObj;
		$priceSrch->addMultipleFields( array('MIN(theprice) as minPrice', 'MAX(theprice) as maxPrice') );
		$qry = $priceSrch->getQuery();
		$qry .= ' having minPrice IS NOT NULL AND maxPrice IS NOT NULL';
		//echo $qry; die();
		//$priceRs = $priceSrch->getResultSet();
		$priceRs = $db->query($qry);
		$priceArr = $db->fetch($priceRs);

		$priceInFilter = false;
		$filterDefaultMinValue = $priceArr['minPrice'];
		$filterDefaultMaxValue = $priceArr['maxPrice'];

		if($this->siteCurrencyId != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1) || (array_key_exists('currency_id',$headerFormParamsAssocArr) && $headerFormParamsAssocArr['currency_id'] != $this->siteCurrencyId )){
			$filterDefaultMinValue = CommonHelper::displayMoneyFormat($priceArr['minPrice'],false,false,false);
			$filterDefaultMaxValue = CommonHelper::displayMoneyFormat($priceArr['maxPrice'],false,false,false);
			$priceArr['minPrice'] = $filterDefaultMinValue;
			$priceArr['maxPrice'] = $filterDefaultMaxValue;
		}

		if(array_key_exists('price-min-range',$headerFormParamsAssocArr) && array_key_exists('price-max-range',$headerFormParamsAssocArr)){
			$priceArr['minPrice'] = $headerFormParamsAssocArr['price-min-range'];
			$priceArr['maxPrice'] = $headerFormParamsAssocArr['price-max-range'];
			$priceInFilter = true;
		}

		if(array_key_exists('currency_id',$headerFormParamsAssocArr) && $headerFormParamsAssocArr['currency_id'] != $this->siteCurrencyId){
			$priceArr['minPrice'] = CommonHelper::convertExistingToOtherCurrency($headerFormParamsAssocArr['currency_id'],$headerFormParamsAssocArr['price-min-range'],$this->siteCurrencyId,false);
			$priceArr['maxPrice'] = CommonHelper::convertExistingToOtherCurrency($headerFormParamsAssocArr['currency_id'],$headerFormParamsAssocArr['price-max-range'],$this->siteCurrencyId,false);
		}
		/* ] */

		$brandsCheckedArr = array();
		if(array_key_exists('brand',$headerFormParamsAssocArr)){
			$brandsCheckedArr = $headerFormParamsAssocArr['brand'];
		}

		$optionValueCheckedArr = array();
		if(array_key_exists('optionvalue',$headerFormParamsAssocArr)){
			$optionValueCheckedArr = $headerFormParamsAssocArr['optionvalue'];
		}

		$conditionsCheckedArr = array();
		if(array_key_exists('condition',$headerFormParamsAssocArr)){
			$conditionsCheckedArr = $headerFormParamsAssocArr['condition'];
		}

		$availability = 0;
		if(array_key_exists('availability',$headerFormParamsAssocArr)){
			$availability = current($headerFormParamsAssocArr['availability']);
		}

		$prodcatArr = array();
		if(array_key_exists('prodcat',$headerFormParamsAssocArr)){
			$prodcatArr = $headerFormParamsAssocArr['prodcat'];
		}

		$productFiltersArr = array(
			'headerFormParamsAssocArr'=>	$headerFormParamsAssocArr,
			'categoriesArr'		=>	$categoriesArr,
			'productCategories'		=>	$productCategories,
			'prodcatArr'		=>	$prodcatArr,
			'brandsCheckedArr'		  => $brandsCheckedArr,
			'optionValueCheckedArr'	  =>	$optionValueCheckedArr,
			'availability'	          =>	 $availability,
			'shopCatFilters'		=>	true,
			'brandsArr'			=>	$brandsArr,
			'CategoryCheckedArr' =>array(),
			'conditionsArr'		=>	$conditionsArr,
			'conditionsCheckedArr'			=>	$conditionsCheckedArr,
			'priceArr'			=>	$priceArr,
			'priceInFilter'			  =>	$priceInFilter,
			'filterDefaultMinValue'	  =>	$filterDefaultMinValue,
			'filterDefaultMaxValue'	  =>	$filterDefaultMaxValue,
			'siteLangId'		=>	$this->siteLangId
		);

		$shopCategories = array();
		Switch($shop['shop_ltemplate_id']){
			case Shop::TEMPLATE_ONE:
			case Shop::TEMPLATE_THREE:
			case Shop::TEMPLATE_FOUR:
			case Shop::TEMPLATE_FIVE:
			$this->_template->addCss('shops/templates/page-css/'.$shop['shop_ltemplate_id'].'.css');
			break;
			case Shop::TEMPLATE_TWO:
				$srchCat = Shop::getUserShopProdCategoriesObj($shop['shop_user_id'],$shop['shop_id'],0,$this->siteLangId);
				$srchCat->doNotCalculateRecords();
				$srchCat->doNotLimitRecords();

				$db = FatApp::getDb();
				$rs = $srchCat->getResultSet();
				$shopCategories = $db->fetchAll($rs,'prodcat_id');
				$this->_template->addJs('js/slick.min.js');
				$this->_template->addCss('shops/templates/page-css/'.$shop['shop_ltemplate_id'].'.css');
			break;
			default:
			$this->_template->addCss('shops/templates/page-css/'.SHOP::TEMPLATE_ONE.'.css');

			break;
		}

		$this->set( 'shop', $shop);
		$this->set( 'shopRating', SelProdRating::getSellerRating($shop['shop_user_id']));
		$this->set( 'shopTotalReviews', SelProdReview::getSellerTotalReviews($shop['shop_user_id']));

		$this->set( 'shopCategories', $shopCategories);
		$this->set('productFiltersArr', $productFiltersArr );

		$description = trim(CommonHelper::subStringByWords(strip_tags(CommonHelper::renderHtml($shop['shop_description'],true)),500));
		$description .= ' - '.Labels::getLabel('LBL_See_more_at', $this->siteLangId).": ".CommonHelper::getCurrUrl();

		if($shop){
			$socialShareContent = array(
				'title'=>$shop['shop_name'],
				'description'=>$description,
				'image'=>CommonHelper::generateUrl('image','shopBanner',array($shop['shop_id'], $this->siteLangId, 'wide')),
			);
			$this->set( 'socialShareContent', $socialShareContent);
		}

		$shopUserId = FatUtility::int($shop['shop_user_id']);
		if($shopUserId !== 0){
			$srchSplat = SocialPlatform::getSearchObject($this->siteLangId);
			$srchSplat->doNotCalculateRecords();
			$srchSplat->doNotLimitRecords();
			$srchSplat->addCondition('splatform_user_id','=',$shopUserId);
			$db = FatApp::getDb();

			$rs = $srchSplat->getResultSet();

			$socialPlatforms = $db->fetchAll($rs);

			$this->set('socialPlatforms',$socialPlatforms);
		}
		$detail= ShopCollection::getCollectionDetail($shop_id,$this->siteLangId);
		$collection_data=array();
		if(!empty($detail)){
		$collectionName= isset($detail['scollection_name'])?$detail['scollection_name']:$detail['scollection_identifier'];
		$collection_data= array('collectionName'=>$collectionName,'collectionId'=>$detail['scollection_id']);
		}
		$this->set('collectionData',$collection_data);
		$this->set('layoutTemplate','shop');
		$this->set('template_id',($shop['shop_ltemplate_id']==0)?SHOP::TEMPLATE_ONE:$shop['shop_ltemplate_id']);
		$this->set('layoutRecordId',$shop['shop_id']);
		$showBgImage = $this->showBackgroundImage($shop_id,$this->siteLangId,$shop['shop_ltemplate_id']);
		$this->set('showBgImage',$showBgImage);
		$this->set('canonicalUrl', CommonHelper::generateFullUrl('Shops','view',array($shop_id)));
	}

	public function getAllowedShowBg($templateId =''){

		switch($templateId ){

			case Shop::TEMPLATE_ONE :
				return false;
				break;
			case Shop::TEMPLATE_TWO :
				return false;
				break;
			case Shop::TEMPLATE_THREE :
				return false;
				break;
			case Shop::TEMPLATE_FOUR :
				return true;
				break;
			case Shop::TEMPLATE_FIVE :
				return true;
				break;
			default:
				return false;
			break;
		}

		return $default_image;

	}

	public function topProducts( $shop_id ){

		$shop_id = FatUtility::int($shop_id);

		if( $shop_id <= 0 ){
			FatApp::redirectUser(CommonHelper::generateUrl('Seller' , 'Shop'));
		}
		$this->shopDetail($shop_id); /* [defined in traits] */
		$searchFrm = $this->getSearchForm();
		$frm = $this->getProductSearchForm();
		$fld=$frm->getField('sortBy');
		$fld->value='popularity_desc';
		$fld->fldType ='hidden';
		$frmData = array('shop_id' => $shop_id,'top_products' => $shop_id);
		$frm->fill($frmData);
		$searchFrm->fill($frmData);
        $this->set('shopId', $shop_id);
		$this->set('frmProductSearch', $frm);
		$this->set('searchFrm', $searchFrm);
		$this->includeProductPageJsCss();
		$this->_template->addJs('js/slick.min.js');
		$this->_template->addCss(array('css/slick.css','css/product-detail.css'));
		$this->_template->addJs('js/shop-nav.js');
		$this->_template->addJs('js/jquery.colourbrightness.min.js');
		$this->_template->render();
	}

	public function policy( $shop_id ){

		$shop_id = FatUtility::int($shop_id);

		if( $shop_id <= 0 ){
			FatApp::redirectUser(CommonHelper::generateUrl('Seller' , 'Shop'));
		}
		$frm = $this->getProductSearchForm();
		$searchFrm = $this->getSearchForm();
		$frmData = array('shop_id' => $shop_id);
		$frm->fill($frmData);
		$searchFrm->fill($frmData);
		$this->set('frmProductSearch', $frm);
		$this->set('searchFrm', $searchFrm);
		$this->_template->addJs('js/slick.js');
		$this->_template->addCss('css/slick.css');
		$this->_template->addJs('js/shop-nav.js');
		$this->_template->addJs('js/jquery.colourbrightness.min.js');
		$this->shopDetail($shop_id,true); /* [defined in traits] */
		$this->_template->render();
	}

	public function collection( $shop_id ){

		$shop_id = FatUtility::int($shop_id);


		if( $shop_id <= 0 ){
			FatApp::redirectUser(CommonHelper::generateUrl('Seller' , 'Shop'));
		}
		$this->shopDetail($shop_id); /* [defined in traits] */
		$frm = $this->getProductSearchForm();
		$searchFrm = $this->getSearchForm();
		$fld=$frm->getField('sortBy');
		$fld->value='popularity_desc';
		$fld->fldType ='hidden';

		$shopcolDetails = ShopCollection::getCollectionGeneralDetail($shop_id);

		 $scollectionId = $shopcolDetails['scollection_id'];
		if($scollectionId<0){
			FatApp::redirectUser(CommonHelper::generateUrl(''));
		}
		$frmData = array('collection_id'=>$scollectionId);
		$frm->fill($frmData);
		$searchFrm->fill($frmData);
        $this->set('shopId', $shop_id);
		$this->set('frmProductSearch', $frm);
		$this->set('searchFrm', $searchFrm);
		$this->includeProductPageJsCss();
		$this->_template->addJs('js/slick.min.js');
		$this->_template->addCss(array('css/slick.css','css/product-detail.css'));
		$this->_template->addJs('js/shop-nav.js');
		$this->_template->addJs('js/jquery.colourbrightness.min.js');
		$this->_template->render();
	}

	public function sendMessage( $shop_id, $selprod_id=0 ){
		UserAuthentication::checkLogin();
		$shop_id = FatUtility::int($shop_id);
		$selprod_id = FatUtility::int($selprod_id);
		$loggedUserId = UserAuthentication::getLoggedUserId();
		$db = FatApp::getDb();

		$shop = $this->getShopInfo( $shop_id );
		if( !$shop ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser(CommonHelper::generateUrl('Home'));
		}

		$frm = $this->getSendMessageForm( $this->siteLangId );
		$userObj = new User($loggedUserId);
		$loggedUserData = $userObj->getUserInfo( array('user_id', 'user_name', 'credential_username') );
		$frmData = array( 'shop_id' => $shop_id  );

		if($selprod_id > 0)
		{
			$frmData['product_id'] = $selprod_id;
			$srch = SellerProduct::getSearchObject( $this->siteLangId );
			$srch->joinTable( Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p' );
			$srch->joinTable( Product::DB_LANG_TBL, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = '.$this->siteLangId, 'p_l' );
			$srch->addMultipleFields(array('IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title'));
			$srch->addCondition('selprod_id', '=', $selprod_id);
			$db = FatApp::getDb();
			$rs = $srch->getResultSet();
			$products = $db->fetch($rs);
			$this->set( 'product', $products);
		}

		$frm->fill( $frmData );
		$this->set( 'frm', $frm );
		$this->set( 'loggedUserData', $loggedUserData );
		$this->set( 'shop', $shop);
		$this->_template->render();
	}

	public function setUpSendMessage(){
		UserAuthentication::checkLogin();
		$frm = $this->getSendMessageForm( $this->siteLangId );
		$post = $frm->getFormDataFromArray( FatApp::getPostedData() );
		$loggedUserId = UserAuthentication::getLoggedUserId();
		if (false == $post) {
			Message::addErrorMessage(current($frm->getValidationErrors()));
			FatUtility::dieJsonError( Message::getHtml() );
		}

		$shop_id = FatUtility::int($post['shop_id']);
		$shopData = $this->getShopInfo($shop_id);
		if( !$shopData ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieJsonError( Message::getHtml() );
		}
		if( $shopData['shop_user_id'] == $loggedUserId){
			Message::addErrorMessage( Labels::getLabel('LBL_User_is_not_allowed_to_send_message_to_yourself', $this->siteLangId) );
			FatUtility::dieJsonError( Message::getHtml() );
		}

		$threadObj = new Thread();
		$threadDataToSave = array(
			'thread_subject'	=>	$post['thread_subject'],
			'thread_started_by' =>	$loggedUserId,
			'thread_start_date'	=>	date('Y-m-d H:i:s')
		);

		if(isset($post['product_id']) && $post['product_id']>0)
		{
			$product_id = FatUtility::int($post['product_id']);
			$threadDataToSave['thread_type'] = Thread::THREAD_TYPE_PRODUCT;
			$threadDataToSave['thread_record_id'] = $product_id;
		}else{
			$threadDataToSave['thread_type'] =	Thread::THREAD_TYPE_SHOP;
			$threadDataToSave['thread_record_id'] =	$shop_id;
		}

		$threadObj->assignValues( $threadDataToSave );

		if ( !$threadObj->save() ) {
			Message::addErrorMessage( Labels::getLabel($threadObj->getError(),$this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		$thread_id = $threadObj->getMainTableRecordId();

		$threadMsgDataToSave = array(
			'message_thread_id'	=>	$thread_id,
			'message_from'		=>	$loggedUserId,
			'message_to'		=>	$shopData['shop_user_id'],
			'message_text'		=>	$post['message_text'],
			'message_date'		=>	date('Y-m-d H:i:s'),
			'message_is_unread'	=>	1,
			'message_deleted'	=>	0
		);
		if( !$message_id = $threadObj->addThreadMessages( $threadMsgDataToSave ) ){
			Message::addErrorMessage( Labels::getLabel($threadObj->getError(),$this->siteLangId) );
			FatUtility::dieWithError(Message::getHtml());
		}

		if( $message_id ){
			$emailObj = new EmailHandler();
			$emailObj->SendMessageNotification( $message_id, $this->siteLangId );
		}

		$this->set( 'msg', Labels::getLabel('MSG_Message_Submitted_Successfully!', $this->siteLangId) );
		$this->_template->render(false, false, 'json-success.php');
	}

	public function reportSpam( $shop_id ){
		UserAuthentication::checkLogin();
		$db = FatApp::getDb();
		$shop_id = FatUtility::int($shop_id);

		$shop = $this->getShopInfo($shop_id);
		if( !$shop ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser(CommonHelper::generateUrl('Home'));
		}
		$frm = $this->getReportSpamForm( $this->siteLangId );
		$frm->fill( array( 'shop_id' => $shop_id ) );
		$this->set( 'frm', $frm );
		$this->set('shop', $shop);
		$this->_template->render();
	}

	public function setUpShopSpam(){
		UserAuthentication::checkLogin();
		$frm = $this->getReportSpamForm( $this->siteLangId );
		$post = $frm->getFormDataFromArray( FatApp::getPostedData() );
		$loggedUserId = UserAuthentication::getLoggedUserId();

		if ( false == $post ) {
			Message::addErrorMessage( current($frm->getValidationErrors()) );
			FatUtility::dieJsonError( Message::getHtml() );
		}

		$shop_id = FatUtility::int($post['shop_id']);

		$srch = new ShopSearch( $this->siteLangId );
		$srch->setDefinedCriteria( $this->siteLangId );
		$srch->joinSellerSubscription();
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array( 'shop_id', 'shop_user_id'));
		$srch->addCondition( 'shop_id', '=', $shop_id );
		$shopRs = $srch->getResultSet();
		$shopData = FatApp::getDb()->fetch($shopRs);

		if( !$shopData ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieJsonError( Message::getHtml() );
		}

		$sReportObj = new ShopReport();
		$dataToSave = array(
			'sreport_shop_id'			=>	$shop_id,
			'sreport_reportreason_id'	=>	$post['sreport_reportreason_id'],
			'sreport_message'			=>	$post['sreport_message'],
			'sreport_user_id'			=>	$loggedUserId,
			'sreport_added_on'			=>	date('Y-m-d H:i:s'),
		);

		$sReportObj->assignValues( $dataToSave );
		if ( !$sReportObj->save() ) {
			Message::addErrorMessage( Labels::getLabel($sReportObj->getError(),$this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}

		$sreport_id = $sReportObj->getMainTableRecordId();

		if( !$sreport_id ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}

		/* email notification[ */
		if( $sreport_id ){
			$emailObj = new EmailHandler();
			$emailObj->SendShopReportNotification( $sreport_id, $this->siteLangId );

			//send notification to admin
			$notificationData = array(
					'notification_record_type' => Notification::TYPE_SHOP,
					'notification_record_id' => $shop_id,
					'notification_user_id' => $loggedUserId,
					'notification_label_key' => Notification::REPORT_SHOP_NOTIFICATION,
					'notification_added_on' => date('Y-m-d H:i:s'),
			);

			if(!Notification::saveNotifications($notificationData)){
				Message::addErrorMessage(Labels::getLabel("MSG_NOTIFICATION_COULD_NOT_BE_SENT",$this->siteLangId));
				FatUtility::dieWithError( Message::getHtml() );
			}

		}
		/* ] */

		$sucessMsg = Labels::getLabel('MSG_Your_report_sent_review!', $this->siteLangId);
		Message::addMessage( $sucessMsg );
		$this->set( 'msg', $sucessMsg );
		$this->_template->render(false, false, 'json-success.php');
	}

	/* public function searchWhoFavouriteShop(){
		$db = FatApp::getDb();
		$data = FatApp::getPostedData();
		$page = (empty($data['page']) || $data['page'] <= 0) ? 1 : FatUtility::int($data['page']);
		$pagesize = FatApp::getConfig('CONF_PAGE_SIZE',FatUtility::VAR_INT, 10);

		$searchForm = $this->getWhoFavouriteSearchForm($this->siteLangId);
		$post = $searchForm->getFormDataFromArray($data);


		$shop_id = FatUtility::int($post['shop_id']);
		if(1 > $shop_id){
			FatUtility::dieWithError( Labels::getLabel('LBL_Invalid_Access_ID',$this->siteLangId));
		}

		$srch = new UserFavoriteShopSearch($this->siteLangId);
		$srch->joinWhosFavouriteUser();
		$srch->joinFavouriteUserShopsCount();
		$srch->addMultipleFields(array( 'ufs_shop_id as shop_id','ufs_user_id','user_name','userFavShopcount'));
		$srch->addCondition('ufs_shop_id','=',$shop_id);

		$page = (empty($page) || $page <= 0)?1:$page;
		$page = FatUtility::int($page);
		$srch->setPageNumber($page);
		$srch->setPageSize($pagesize);

		$rs = $srch->getResultSet();
		$userFavorite = $db->fetchAll( $rs );

		$totalShopToShow = 4;
		$prodSrchObj = new ProductSearch( $this->siteLangId );
		$prodSrchObj->setDefinedCriteria();
		$prodSrchObj->setPageSize(1);
		$shops = array();
		foreach($userFavorite as $val){
			$fsrch = new UserFavoriteShopSearch($this->siteLangId);
			$fsrch->joinWhosFavouriteUser();
			$fsrch->addCondition('ufs_user_id','=',$val['ufs_user_id']);
			$fsrch->addMultipleFields(array( 'ufs_shop_id as shop_id'));
			$fsrch->setPageSize($totalShopToShow);
			$frs = $fsrch->getResultSet();
			$shops[$val['ufs_user_id']]['shop'] = $db->fetchAll( $frs,'shop_id');
			if( $shops[$val['ufs_user_id']]['shop'] ){
				foreach( $shops[$val['ufs_user_id']]['shop'] as $res ){
					$prodSrch = clone $prodSrchObj;
					$prodSrch->addShopIdCondition( $res['shop_id'] );
					$prodSrch->addMultipleFields( array( 'selprod_id', 'product_id', 'shop_id','IFNULL(shop_name, shop_identifier) as shop_name',
					'IFNULL(product_name, product_identifier) as product_name',
					'IF(selprod_stock > 0, 1, 0) AS in_stock') );
					$prodRs = $prodSrch->getResultSet();
					$shops[$val['ufs_user_id']]['products'][] = $db->fetch( $prodRs);
					$shops[$val['ufs_user_id']]['totalProducts'] = 	$prodSrch->recordCount();
				}
			}
		}

		$this->set( 'shops', $shops );
		$this->set( 'totalShopToShow', $totalShopToShow );
		$this->set( 'userFavorite', $userFavorite );
		$this->set('pageCount',$srch->pages());
		$this->set('recordCount',$srch->recordCount());
		$this->set('page', $page);
		$this->set('pageSize', $pagesize);
		$this->set('postedData', $post);

		$startRecord = ($page-1)* $pagesize + 1 ;
		$endRecord = $pagesize;
		$totalRecords = $srch->recordCount();
		if ($totalRecords < $endRecord) { $endRecord = $totalRecords; }
		$json['totalRecords'] = $totalRecords;
		$json['startRecord'] = $startRecord;
		$json['endRecord'] = $endRecord;
		$json['html'] = $this->_template->render( false, false, '', true, false);
		$json['loadMoreBtnHtml'] = $this->_template->render( false, false, '_partial/load-more-btn.php', true, false);
		FatUtility::dieJsonSuccess($json);
	}

	public function whoFavoritesShop($shop_id){
		$db = FatApp::getDb();
		$shop_id = FatUtility::int($shop_id);

		$searchForm = $this->getWhoFavouriteSearchForm($this->siteLangId);
		$searchForm->fill(array('shop_id'=>$shop_id));

		$shopData = $this->getShopInfo($shop_id);
		if( !$shopData ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser(CommonHelper::generateUrl('Home'));
		}

		$srch = new UserFavoriteShopSearch($this->siteLangId);
		$srch->joinWhosFavouriteUser();
		$srch->joinFavouriteUserShopsCount();
		$srch->addMultipleFields(array( 'ufs_shop_id as shop_id','ufs_user_id','user_name','userFavShopcount'));
		$srch->addCondition('ufs_shop_id','=',$shop_id);

		$rs = $srch->getResultSet();
		$userFavorite = $db->fetchAll( $rs );

		$this->set( 'shopData', $shopData );
		$this->set( 'searchForm', $searchForm );
		$this->set( 'userFavoriteCount', $srch->recordCount() );
		$this->_template->render( );
	}*/

	public function policies( $shop_id ){
		$shop = $this->getShopInfo($shop_id);
		if( !$shop ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser(CommonHelper::generateUrl('Home'));
		}

		$this->set( 'shop', $shop );
		$this->_template->render();
	}

	public function banner( $shopId, $sizeType = '', $prodCatId = 0, $lang_id = 0 ){
		$shopId = FatUtility::int($shopId);
		$prodCatId = FatUtility::int($prodCatId);
		$file_row = false;

		if( $prodCatId > 0 ){
			$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER_SELLER, $shopId, $prodCatId, $lang_id );
			/* if(false == $file_row){
				$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_SHOP_BANNER, $shopId );
			} */
		}

		if(false == $file_row){
			$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_SHOP_BANNER, $shopId, 0, $lang_id );
		}

		$image_name = isset($file_row['afile_physical_path']) ?  $file_row['afile_physical_path'] : '';

		switch( strtoupper($sizeType) ){
			case 'THUMB':
				$w = 250;
				$h = 100;
				AttachedFile::displayImage( $image_name, $w, $h );
			break;
			case 'WIDE':
				$w = 1320;
				$h = 320;
				AttachedFile::displayImage( $image_name, $w, $h );
			break;
			default:
				AttachedFile::displayOriginalImage( $image_name );
			break;
		}
	}

	private function getShopInfo($shop_id){
		$db = FatApp::getDb();
		$shop_id = FatUtility::int($shop_id);
		$srch = new ShopSearch( $this->siteLangId );
		$srch->setDefinedCriteria( $this->siteLangId );
		$srch->doNotCalculateRecords();
		$srch->joinSellerSubscription();
		$srch->addMultipleFields(array( 'shop_id','shop_user_id','shop_ltemplate_id', 'shop_created_on', 'shop_name', 'shop_description',
		'shop_payment_policy', 'shop_delivery_policy', 'shop_refund_policy', 'shop_additional_info', 'shop_seller_info',
		'shop_country_l.country_name as shop_country_name', 'shop_state_l.state_name as shop_state_name', 'shop_city','u.user_name as shop_owner_name', 'u_cred.credential_username as shop_owner_username' ));

		$srch->addCondition( 'shop_id', '=', $shop_id );
		$shopRs = $srch->getResultSet();
		return $shop = $db->fetch( $shopRs );
	}

	private function getReportSpamForm( $langId ){
		$frm = new Form('frmShopReportSpam');
		$frm->addHiddenField('', 'shop_id');
		$frm->addSelectBox( Labels::getLabel('LBL_Select_Reason', $langId), 'sreport_reportreason_id', ShopReportReason::getReportReasonArr($langId), '', array(), Labels::getLabel('LBL_Select', $langId) )->requirements()->setRequired();
		$frm->addTextArea( Labels::getLabel('LBL_Message', $langId), 'sreport_message')->requirements()->setRequired();
		$fldSubmit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Submit_Report', $langId));
		return $frm;
	}

	private function getSendMessageForm( $langId ){
		$frm = new Form('frmSendMessage');
		//$frm->addHiddenField('', 'user_id');
		$frm->addHiddenField('', 'shop_id');

		$fld = $frm->addHtml( Labels::getLabel('LBL_From', $langId ), 'send_message_from', '');
		$frm->addHtml( Labels::getLabel('LBL_To', $langId ), 'send_message_to','');
		$frm->addHtml( Labels::getLabel('LBL_About_Product', $langId ), 'about_product','');
		$frm->addRequiredField( Labels::getLabel('LBL_Subject', $langId), 'thread_subject');
		$fld = $frm->addTextArea( Labels::getLabel('LBL_Your_Message', $langId), 'message_text');
		$fld->requirements()->setRequired();
		$frm->addHiddenField('','product_id');
		$fldSubmit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Send', $langId));
		return $frm;
	}

	private function getWhoFavouriteSearchForm($langId ){
		$frm = new Form('frmsearchWhoFavouriteShop');
		$frm->addHiddenField('', 'shop_id');
		return $frm;
	}

	public function track($shopId = 0,$redirectType,$recordId){
		$shopId = FatUtility::int($shopId);
		if( 1 > $shopId){
			Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access',$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl(''));
		}

		/* Track Click */
		$srch = new PromotionSearch($this->siteLangId,true);
		$srch->joinActiveUser();
		$srch->joinShops();
		$srch->joinShopCountry();
		$srch->joinShopState();
		$srch->addPromotionTypeCondition(Promotion::TYPE_SHOP);
		$srch->addShopActiveExpiredCondition();
		$srch->joinUserWallet();
		$srch->joinBudget();
		$srch->addBudgetCondition();
		$srch->addCondition('shop_id','=',$shopId);
		$srch->addMultipleFields( array( 'shop_id','shop_user_id','shop_name','country_name','state_name','promotion_id','promotion_cpc') );
		$srch->addOrder('','rand()');
		$srch->setPageSize(1);
		$srch->doNotCalculateRecords();
		$rs = $srch->getResultSet();
		$row = FatApp::getDb()->fetch( $rs );

		if($row == false){
			Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access',$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl(''));
		}

		if($redirectType == PROMOTION::REDIRECT_PRODUCT){
			$url =  CommonHelper::generateFullUrl('products','view',array($recordId));
		}elseif($redirectType == PROMOTION::REDIRECT_CATEGORY){
			$url =  CommonHelper::generateFullUrl('category','view',array($recordId));
		}else{
			$url  = CommonHelper::generateFullUrl('shops','view',array($recordId));
		}

		$userId = 0;

		if ( UserAuthentication::isUserLogged()  ){
			$userId = UserAuthentication::getLoggedUserId();
		}

		if(Promotion::isUserClickCountable($userId,$row['promotion_id'],$_SERVER['REMOTE_ADDR'],session_id())){
			$promotionClickData = array(
				'pclick_promotion_id' => $row['promotion_id'],
				'pclick_user_id' => $userId,
				'pclick_datetime' => date('Y-m-d H:i:s'),
				'pclick_ip' => $_SERVER['REMOTE_ADDR'],
				'pclick_cost' => $row['promotion_cpc'],
				'pclick_session_id' => session_id(),
			);
			FatApp::getDb()->insertFromArray(Promotion::DB_TBL_CLICKS,$promotionClickData,false,'',$promotionClickData);
			$clickId= FatApp::getDb()->getInsertId();

			$promotionClickChargesData = array(

				'picharge_pclick_id' => $clickId,
				'picharge_datetime'  => date('Y-m-d H:i:s'),
				'picharge_cost'  => $row['promotion_cpc'],

			);

			FatApp::getDb()->insertFromArray(Promotion::DB_TBL_ITEM_CHARGES,$promotionClickChargesData,false);

			$promotionLogData = array(
				'plog_promotion_id' => $row['promotion_id'],
				'plog_date' =>  date('Y-m-d'),
				'plog_clicks' =>  1,
			);


			$onDuplicatePromotionLogData = array_merge($promotionLogData,array('plog_clicks'=>'mysql_func_plog_clicks+1'));
			FatApp::getDb()->insertFromArray(Promotion::DB_TBL_LOGS,$promotionLogData,true,array(),$onDuplicatePromotionLogData);
		}

		if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
			FatApp::redirectUser(CommonHelper::processURLString($url));
		}

		FatApp::redirectUser(CommonHelper::generateUrl(''));

	}

	/* private function getProductSearchForm(){
		$sortByArr = array( 'price_asc' => Labels::getLabel('LBL_Price_(Low_to_High)', $this->siteLangId), 'price_desc' => Labels::getLabel('LBL_Price_(High_to_Low)', $this->siteLangId) );

		$pageSize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10);
		$itemsTxt = Labels::getLabel('LBL_Items', $this->siteLangId);
		$pageSizeArr[$pageSize] = $pageSize.' '.$itemsTxt;
		$pageSizeArr[25] = 25 . ' '.$itemsTxt;
		$pageSizeArr[50] = 50 . ' '.$itemsTxt;
		$frm = new Form('frmProductSearch');
		$frm->addTextBox('','keyword');
		$frm->addSelectBox( '', 'sortBy', $sortByArr, 'price_asc', array(), '');
		$frm->addSelectBox( '', 'pageSize', $pageSizeArr, $pageSize, array(), '' );
		$frm->addHiddenField('', 'page', 1);
		$frm->addHiddenField('', 'sortOrder', 'asc');
		$frm->addHiddenField('', 'category', 0);
		$frm->addHiddenField('', 'shop_id', 0);
		$frm->addSubmitButton('','btnProductSrchSubmit','');
		return $frm;
	} */
}
