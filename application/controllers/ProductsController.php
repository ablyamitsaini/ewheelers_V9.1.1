<?php
class ProductsController extends MyAppController {

	public function __construct($action){
		parent::__construct($action);
	}

	public function index(){
		$db = FatApp::getDb();

		$this->includeProductPageJsCss();
		$frm = $this->getProductSearchForm();
		
		$headerFormParamsArr = FatApp::getParameters();
		$headerFormParamsAssocArr = Product::convertArrToSrchFiltersAssocArr($headerFormParamsArr);
		$headerFormParamsAssocArr['join_price'] = 1;
		$frm->fill( $headerFormParamsAssocArr );

		$prodSrchObj = new ProductSearch( $this->siteLangId );
		$prodSrchObj->setDefinedCriteria();
		$prodSrchObj->joinProductToCategory();
		$prodSrchObj->joinSellerSubscription();
		$prodSrchObj->addSubscriptionValidCondition();
		$prodSrchObj->doNotCalculateRecords();
		$prodSrchObj->doNotLimitRecords();
		if( isset($headerFormParamsAssocArr['keyword']) && !empty($headerFormParamsAssocArr['keyword']) ) {
		    $prodSrchObj->addKeywordSearch($headerFormParamsAssocArr['keyword']);
		}
		if( !empty($category_id) ) {
		    $prodSrchObj->addCategoryCondition($category_id);
		}

		$rs = $prodSrchObj->getResultSet();
		$record = FatApp::getDb()->fetch($rs);

		/* Categories Data[ */
		$catSrch = clone $prodSrchObj;
		$catSrch->addGroupBy('prodcat_id');
		$rootCategoriesArr = productCategory::getProdCatParentChildWiseArr( $this->siteLangId, 0, false, true, false,false );
		$flipCatArr = $rootCategoriesArr ;
		$categoriesDataArr = productCategory::getProdCatParentChildWiseArr( $this->siteLangId, 0, false, false, false, $catSrch,true );

		$categoriesMainRootArr = array_unique(array_column($categoriesDataArr,'prodrootcat_code'));

		array_walk($categoriesMainRootArr,function(&$n) {
			  $n = FatUtility::int($n);
			}) ;
		array_flip($categoriesMainRootArr);
		$categoriesArr  =  array();

		foreach($categoriesMainRootArr as $key=>$catId){
			if(isset($rootCategoriesArr[$catId])){
				$categoriesArr [$catId]['prodcat_name'] = $rootCategoriesArr[$catId];
				$categoriesArr [$catId]['prodcat_id'] = $catId;
				$categoriesArr[$catId]['children'] = productCategory::getProdCatParentChildWiseArr( $this->siteLangId, $catId, true, false, false, false,true );
			}
		}
		/* ] */

		/* Brand Filters Data[ */
		$brandSrch = clone $prodSrchObj;
		$brandSrch->addGroupBy('brand_id');
		$brandSrch->addOrder('brand_name');
		$brandSrch->addMultipleFields(array( 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description'));
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

		/* if needs to show product counts under any condition[ */
		//$conditionSrch->addFld('count(selprod_condition) as totalProducts');
		/* ] */
		$conditionRs = $conditionSrch->getResultSet();
		$conditionsArr = $db->fetchAll($conditionRs);
		/* ] */

		/* Price Filters [ */
		$priceSrch = new ProductSearch( $this->siteLangId );
		$priceSrch->setDefinedCriteria(1);
		$priceSrch->joinProductToCategory();
		$priceSrch->joinSellerSubscription();
		$priceSrch->addSubscriptionValidCondition();
		$priceSrch->doNotCalculateRecords();
		$priceSrch->doNotLimitRecords();

		if( isset($headerFormParamsAssocArr['keyword']) && !empty($headerFormParamsAssocArr['keyword']) ) {
			$priceSrch->addKeywordSearch($headerFormParamsAssocArr['keyword']);
		}
		
		if( !empty($category_id) ) {
			$priceSrch->addCategoryCondition($category_id);
		}
		$priceSrch->addMultipleFields( array('MIN(theprice) as minPrice', 'MAX(theprice) as maxPrice') );
		$qry = $priceSrch->getQuery();
		$qry .= ' having minPrice IS NOT NULL AND maxPrice IS NOT NULL';

		//$priceRs = $priceSrch->getResultSet();
		$priceRs = $db->query($qry);
		$priceArr = $db->fetch($priceRs);
		/* ] */
		
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
	
		$productFiltersArr = array(
			'headerFormParamsAssocArr'=>	$headerFormParamsAssocArr,
			'categoriesArr'			  =>	$categoriesArr,
			'brandsArr'			  	  =>	$brandsArr,
			'brandsCheckedArr'		  =>	$brandsCheckedArr,
			'optionValueCheckedArr'	  =>	$optionValueCheckedArr,
			'conditionsArr'			  =>	$conditionsArr,
			'conditionsCheckedArr'	  =>	$conditionsCheckedArr,
			'availability'	          =>	 $availability,
			'priceArr'				  =>	$priceArr,
			'currencySymbolLeft'	  =>	CommonHelper::getCurrencySymbolLeft(),
			'currencySymbolRight' 	  =>	CommonHelper::getCurrencySymbolRight(),
			'siteLangId'			  =>	$this->siteLangId,
			'priceInFilter'			  =>	$priceInFilter,		 
			'filterDefaultMinValue'	  =>	$filterDefaultMinValue,		
			'filterDefaultMaxValue'	  =>	$filterDefaultMaxValue,
		);
		/* commonHelper::printArray($productFiltersArr); die; */
		/* Get generic Polls [ */

		/* $pollQuest = Polling::getGeneraicPoll($this->siteLangId);
		$this->set('pollQuest', $pollQuest); */

		/* ] */
		if(empty($record)){
			$this->set('noProductFound', 'noProductFound');
		}
		
		$this->set('priceArr', $priceArr);
		$this->set('priceInFilter', $priceInFilter);
		$this->set('frmProductSearch', $frm);
		$this->set('productFiltersArr', $productFiltersArr );
		$this->set('canonicalUrl', CommonHelper::generateFullUrl('Products','index') );
		$this->_template->addJs('js/slick.min.js'); 
		$this->_template->addCss(array('css/slick.css','css/product-detail.css'));
		$this->_template->render();
	}

	public function search(){ 
		$db = FatApp::getDb(); 

		$frm = $this->getProductSearchForm();

		$headerFormParamsArr = FatApp::getParameters();

		$headerFormParamsAssocArr = Product::convertArrToSrchFiltersAssocArr($headerFormParamsArr);
		if( isset($headerFormParamsAssocArr['keyword']) ) {
			$frm = $this->getProductSearchForm(true);
		}
		$headerFormParamsAssocArr['join_price'] = 1;
		$frm->fill( $headerFormParamsAssocArr );
		$this->includeProductPageJsCss();

		/* to show searched category data[ */
		$category_id = null;
		$searchedCategoryData = array();
		if( isset($headerFormParamsAssocArr['category']) ){
			$category_id = FatUtility::int($headerFormParamsAssocArr['category']);
			if( $category_id ){
				$catSrch = new ProductCategorySearch( $this->siteLangId );
				$catSrch->addCondition( 'prodcat_id', '=', $category_id );
				$catSrch->addMultipleFields( array('prodcat_id','prodcat_name') );
				$catSrchRs = $catSrch->getResultSet();
				$searchedCategoryData = $db->fetch($catSrchRs);
				if( $searchedCategoryData ){
					$catBanner = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER, $searchedCategoryData['prodcat_id'] );
					$searchedCategoryData['catBanner'] = $catBanner;
				}
			}
		}
		/* ] */

		$prodSrchObj = new ProductSearch( $this->siteLangId );
		$prodSrchObj->setDefinedCriteria();
		$prodSrchObj->joinProductToCategory();
		$prodSrchObj->joinSellerSubscription($this->siteLangId ,true);
		$prodSrchObj->addSubscriptionValidCondition();
		$prodSrchObj->doNotCalculateRecords();
		$prodSrchObj->doNotLimitRecords();
		if( !empty($category_id) ) {
		    $prodSrchObj->addCategoryCondition($category_id);
		}

		if( isset($headerFormParamsAssocArr['keyword']) && !empty($headerFormParamsAssocArr['keyword']) ) {
		    $prodSrchObj->addKeywordSearch($headerFormParamsAssocArr['keyword']);		
		}

		$rs = $prodSrchObj->getResultSet();
		$record = FatApp::getDb()->fetch($rs);

		if(array_key_exists('keyword',$headerFormParamsAssocArr) && $headerFormParamsAssocArr['keyword']!= '' && count($record) ) {
			$searchItemObj = new SearchItem();
			$searchData = array('keyword'=>$headerFormParamsAssocArr['keyword']);
			$searchItemObj->addSearchResult($searchData);
		}

		/* Categories Data[ */
		$catSrch = clone $prodSrchObj;
		$catSrch->addGroupBy('prodcat_id');
		//$catSrch->addCondition('prodcat_parent','=',0);
		//Get All Categories which have products
		$categoriesDataArr = productCategory::getProdCatParentChildWiseArr( $this->siteLangId, 0, false, false, false, $catSrch,false );

		/* ] */
		$productCategory = new productCategory;		
		$categoriesArr = $productCategory ->getCategoryTreeArr($this->siteLangId,$categoriesDataArr);
		
		/* Brand Filters Data[ */
		$brandSrch = clone $prodSrchObj;
		$brandSrch->addGroupBy('brand_id');
		$brandSrch->addOrder('brand_name');
		$brandSrch->addMultipleFields(array( 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description'));
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
		/* if needs to show product counts under any condition[ */
		//$conditionSrch->addFld('count(selprod_condition) as totalProducts');
		/* ] */
		$conditionRs = $conditionSrch->getResultSet();
		$conditionsArr = $db->fetchAll($conditionRs);
		/* ] */


		/* Price Filters[ */		
		$priceSrch = new ProductSearch( $this->siteLangId );
		$priceSrch->setDefinedCriteria(1);
		$priceSrch->joinProductToCategory();
		$priceSrch->joinSellerSubscription();
		$priceSrch->addSubscriptionValidCondition();
		$priceSrch->doNotCalculateRecords();
		$priceSrch->doNotLimitRecords();

		if( !empty($category_id) ) {
			$priceSrch->addCategoryCondition($category_id);
		}

		if( isset($headerFormParamsAssocArr['keyword']) && !empty($headerFormParamsAssocArr['keyword']) ) {
			$priceSrch->addKeywordSearch($headerFormParamsAssocArr['keyword']);

		}
		$priceSrch->addMultipleFields( array('MIN(theprice) as minPrice', 'MAX(theprice) as maxPrice') );
		$qry = $priceSrch->getQuery();
		$qry .= ' having minPrice IS NOT NULL AND maxPrice IS NOT NULL';
		//$priceRs = $priceSrch->getResultSet();

		$priceRs = $db->query($qry);
		$priceArr = $db->fetch($priceRs);
		/* }  */
		
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
		/* CommonHelper::printArray($headerFormParamsAssocArr); die; */
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
		
		$productFiltersArr = array(
			'headerFormParamsAssocArr'=>	$headerFormParamsAssocArr,
			'categoriesArr'			  =>	$categoriesArr,
			'brandsArr'			  	  =>	$brandsArr,
			'brandsCheckedArr'		  =>	$brandsCheckedArr,
			'optionValueCheckedArr'	  =>	$optionValueCheckedArr,
			'conditionsArr'			  =>	$conditionsArr,
			'conditionsCheckedArr'	  =>	$conditionsCheckedArr,
			'availability'	          =>	 $availability,
			'priceArr'				  =>	$priceArr,
			'currencySymbolLeft'	  =>	CommonHelper::getCurrencySymbolLeft(),
			'currencySymbolRight' 	  =>	CommonHelper::getCurrencySymbolRight(),
			'siteLangId'			  =>	$this->siteLangId,
			'priceInFilter'			  =>	$priceInFilter,		 
			'filterDefaultMinValue'	  =>	$filterDefaultMinValue,		
			'filterDefaultMaxValue'	  =>	$filterDefaultMaxValue,
			'count_for_view_more'     =>  FatApp::getConfig('CONF_COUNT_FOR_VIEW_MORE', FatUtility::VAR_INT, 5)
		);

		$this->set('priceArr', $priceArr);
		$this->set('priceInFilter', $priceInFilter);
		$this->set('frmProductSearch', $frm);
		$this->set('searchedCategoryData', $searchedCategoryData);
		if( empty($record) ){
			$this->set('noProductFound', 'noProductFound');
		}
		$this->_template->addJs('js/slick.min.js'); 
		$this->_template->addCss(array('css/slick.css','css/product-detail.css'));
		
		$this->set('canonicalUrl', CommonHelper::generateFullUrl('Products','search') );
		$this->set('productFiltersArr', $productFiltersArr );
		$this->_template->render();
	}

	public function featured(){
		$db = FatApp::getDb();

		$frm = $this->getProductSearchForm();

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
		$headerFormParamsAssocArr['join_price'] = 1;
		$headerFormParamsAssocArr['featured'] = 1;
		$frm->fill( $headerFormParamsAssocArr );
		$this->includeProductPageJsCss();

		/* to show searched category data[ */
		$category_id = null;
		$searchedCategoryData = array();
		if( isset($headerFormParamsAssocArr['category']) ){
			$category_id = FatUtility::int($headerFormParamsAssocArr['category']);
			if( $category_id ){
				$catSrch = new ProductCategorySearch( $this->siteLangId );
				$catSrch->addCondition( 'prodcat_id', '=', $category_id );
				$catSrch->addMultipleFields( array('prodcat_id','prodcat_name') );
				$catSrchRs = $catSrch->getResultSet();
				$searchedCategoryData = $db->fetch($catSrchRs);
				if( $searchedCategoryData ){
					$catBanner = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER, $searchedCategoryData['prodcat_id'] );
					$searchedCategoryData['catBanner'] = $catBanner;
				}
			}
		}
		/* ] */


		$prodSrchObj = new ProductSearch( $this->siteLangId );
		$prodSrchObj->setDefinedCriteria(0);
		$prodSrchObj->joinProductToCategory();
		$prodSrchObj->joinSellerSubscription();
		$prodSrchObj->addSubscriptionValidCondition();
		$prodSrchObj->doNotCalculateRecords();
		$prodSrchObj->doNotLimitRecords();
		$prodSrchObj->addCondition('selprod_deleted','=',applicationConstants::NO);
		if( isset($headerFormParamsAssocArr['keyword']) && !empty($headerFormParamsAssocArr['keyword']) ) {
		    $prodSrchObj->addKeywordSearch($headerFormParamsAssocArr['keyword']);

			$searchItemObj = new SearchItem();
			$searchData = array('keyword'=>$headerFormParamsAssocArr['keyword']);
			$searchItemObj->addSearchResult($searchData);
		}
		if( !empty($category_id) ) {
		    $prodSrchObj->addCategoryCondition($category_id);
		}
		$rs = $prodSrchObj->getResultSet();
		$record = FatApp::getDb()->fetch($rs);

		/* Categories Data[ */
		$catSrch = clone $prodSrchObj;
		$catSrch->addGroupBy('prodcat_id');
		
		
		//Get All Categories which have products
		$categoriesDataArr = productCategory::getProdCatParentChildWiseArr( $this->siteLangId, 0, false, false, false, $catSrch,false );
	
		/* ] */
		$productCategory = new productCategory;
		$categoriesArr = $productCategory ->getCategoryTreeArr($this->siteLangId,$categoriesDataArr);
		
		/* ] */

		/* Brand Filters Data[ */
		$brandSrch = clone $prodSrchObj;
		$brandSrch->addGroupBy('brand_id');
		$brandSrch->addOrder('brand_name');
		$brandSrch->addMultipleFields(array( 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description'));
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

		/* if needs to show product counts under any condition[ */
		//$conditionSrch->addFld('count(selprod_condition) as totalProducts');
		/* ] */
		$conditionRs = $conditionSrch->getResultSet();
		$conditionsArr = $db->fetchAll($conditionRs);
		/* ] */


		/* Price Filters[ */
		$priceSrch = new ProductSearch( $this->siteLangId );
		$priceSrch->setDefinedCriteria(1);
		$priceSrch->joinProductToCategory();
		$priceSrch->joinSellerSubscription();
		$priceSrch->addSubscriptionValidCondition();
		$priceSrch->doNotCalculateRecords();
		$priceSrch->doNotLimitRecords();
		$priceSrch->addCondition('selprod_deleted','=',applicationConstants::NO);
		if( isset($headerFormParamsAssocArr['keyword']) && !empty($headerFormParamsAssocArr['keyword']) ) {
		    $priceSrch->addKeywordSearch($headerFormParamsAssocArr['keyword']);

		}
		if( !empty($category_id) ) {
		    $priceSrch->addCategoryCondition($category_id);
		}
		$priceSrch->addMultipleFields( array('MIN(theprice) as minPrice', 'MAX(theprice) as maxPrice') );
		$qry = $priceSrch->getQuery();
		$qry .= ' having minPrice IS NOT NULL AND maxPrice IS NOT NULL';
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
		$productFiltersArr = array(
			'headerFormParamsAssocArr'=>	$headerFormParamsAssocArr,
			'categoriesArr'			=>	$categoriesArr,
			'brandsArr'				=>	$brandsArr,
			'brandsCheckedArr'		  =>	$brandsCheckedArr,
			'optionValueCheckedArr'	  =>	$optionValueCheckedArr,
			'conditionsArr'			=>	$conditionsArr,
			'conditionsCheckedArr'	  =>	$conditionsCheckedArr,
			'availability'	          =>	 $availability,
			'priceArr'				=>	$priceArr,
			'currencySymbolLeft'	=>	CommonHelper::getCurrencySymbolLeft(),
			'currencySymbolRight' 	=>	CommonHelper::getCurrencySymbolRight(),
			'siteLangId'			=>	$this->siteLangId,
			'priceInFilter'			  =>	$priceInFilter,		 
			'filterDefaultMinValue'	  =>	$filterDefaultMinValue,		
			'filterDefaultMaxValue'	  =>	$filterDefaultMaxValue,
			'count_for_view_more'   =>  FatApp::getConfig('CONF_COUNT_FOR_VIEW_MORE', FatUtility::VAR_INT, 5)
		);

		$this->set('frmProductSearch', $frm);

		$this->set('searchedCategoryData', $searchedCategoryData);
		if(empty($record)){
			$this->set('noProductFound', 'noProductFound');
		}
		
		$this->set('canonicalUrl', CommonHelper::generateFullUrl('Products','featured') );
		$this->set('productFiltersArr', $productFiltersArr );
		$this->_template->addJs('js/slick.min.js'); 
		$this->_template->addCss(array('css/slick.css','css/product-detail.css'));
		$this->_template->render();
	}

	public function productsList(){ 
		$json = array();
		$json['reload'] = 0;
		$db = FatApp::getDb();
		$srchFrm = $this->getProductSearchForm();
		$post = FatApp::getPostedData();

		/* $postedCurrencyId = FatApp::getPostedData( 'currency_id', FatUtility::VAR_INT, 0 );
		if( $postedCurrencyId > 0 && $postedCurrencyId != $this->siteCurrencyId ){
			Message::addErrorMessage( Labels::getLabel("LBL_Currency_data_updated,_So_Page_Reloaded", $this->siteLangId) );
			$json['reload'] = 1;
			$json['status'] = true;
			die(json_encode($json));
		} */

		$colMdVal = FatApp::getPostedData('colMdVal', FatUtility::VAR_INT, 0 );

		$post = $srchFrm->getFormDataFromArray( $post );

		if (false === $post) {
			FatUtility::dieWithError(current($srchFrm->getValidationErrors()));
		}

		$page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
		if ($page < 2) {
			$page = 1;
		}

		$pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_INT, FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 10));

		$srch = new ProductSearch( $this->siteLangId );
		$join_price = (isset($post['join_price']) && $post['join_price'] != '') ? FatUtility::int($post['join_price']) : 0 ;

		
		$criteria = array();
		$optionvalue = FatApp::getPostedData('optionvalue', null, '');
		if($optionvalue){
			$criteria['optionvalue'] = $optionvalue;
		}
				
		$srch->setDefinedCriteria( $join_price,0,$criteria,true );
		$srch->joinProductToCategory();
		$srch->joinSellerSubscription();
		$srch->addSubscriptionValidCondition();
		
		
		/* to check current product is in wish list or not[ */
		$loggedUserId = 0;
		if( UserAuthentication::isUserLogged() ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
		}
		if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){
			$srch->joinFavouriteProducts( $loggedUserId );
			$srch->addFld('ufp_id');
		}else{
			$srch->joinUserWishListProducts( $loggedUserId );
			$srch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
		}
		
		$selProdReviewObj = new SelProdReviewSearch();
		$selProdReviewObj->joinSelProdRating();
		$selProdReviewObj->addCondition('sprating_rating_type','=',SelProdRating::TYPE_PRODUCT);
		$selProdReviewObj->doNotCalculateRecords();
		$selProdReviewObj->doNotLimitRecords();
		$selProdReviewObj->addGroupBy('spr.spreview_product_id');
		$selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
		$selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id',"ROUND(AVG(sprating_rating),2) as prod_rating"));
		$selProdRviewSubQuery = $selProdReviewObj->getQuery();
		$srch->joinTable( '(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_selprod_id = selprod_id', 'sq_sprating' );

		$srch->setPageNumber($page);
		$srch->addMultipleFields(array('GETCATCODE(`prodcat_id`)',
				'product_id', 'prodcat_id', 'IFNULL(product_name, product_identifier) as product_name', 'product_model', 'product_short_description',
				'substring_index(group_concat(IFNULL(prodcat_name, prodcat_identifier) ORDER BY IFNULL(prodcat_name, prodcat_identifier) ASC SEPARATOR "," ) , ",", 1) as prodcat_name',
				'selprod_id', 'selprod_user_id',  'selprod_code', 'selprod_stock', 'selprod_condition', 'selprod_price', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
				'special_price_found','splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type', 'splprice_start_date', 'splprice_end_date',
				'theprice', 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description', 'user_name', 'IF(selprod_stock > 0, 1, 0) AS in_stock',
				'selprod_sold_count','selprod_return_policy','ifnull(prod_rating,0) prod_rating',/* 'ifnull(sq_sprating.totReviews,0) totReviews','IF(ufp_id > 0, 1, 0) as isfavorite', */'selprod_min_order_qty'
				));

		if( $pageSize ){
			$srch->setPageSize($pageSize);
		}

		$category_id = FatApp::getPostedData('category', null, '');
		if( $category_id ) {			
			$srch->addCategoryCondition($category_id);
		}
		
		$shop_id = FatApp::getPostedData('shop_id', FatUtility::VAR_INT, 0);
		if( $shop_id ) {			
			$srch->addShopIdCondition($shop_id);
		}
		
		$top_products = FatApp::getPostedData('top_products',FatUtility::VAR_INT, 0);
		if( $top_products ) {						
			$srch->addHaving('prod_rating','>=',3);
		}		

		$collection_id = FatApp::getPostedData('collection_id', FatUtility::VAR_INT, 0);
		if( $collection_id ) {			
			$srch->addCollectionIdCondition($collection_id);
		}

		$keyword = FatApp::getPostedData('keyword', null, '');
		if(!empty($keyword)) {
			$srch->addKeywordSearch($keyword);
			/* $srch->addOrder( 'keyword_relevancy', 'DESC' ); */
		}

		$brand = FatApp::getPostedData('brand', null, '');				
		if( $brand ) {
			$srch->addBrandCondition($brand);
		}

		$optionvalue = FatApp::getPostedData('optionvalue', null, '');
		if( $optionvalue ) {
			$srch->addOptionCondition($optionvalue);
		}
				
		$condition = FatApp::getPostedData('condition', null, '');
		if( !empty($condition) ) {
			$srch->addConditionCondition($condition);
		}

		$out_of_stock = FatApp::getPostedData('out_of_stock', null, '');
		if( !empty($out_of_stock) && $out_of_stock == 1 ) {
			$srch->excludeOutOfStockProducts();
		}

		$price_min_range = FatApp::getPostedData('min_price_range', null, '');
		if( !empty($price_min_range)) {
			$min_price_range_default_currency =  CommonHelper::getDefaultCurrencyValue($price_min_range,false,false);
			$srch->addCondition('theprice', '>=', $min_price_range_default_currency);
		}

		$price_max_range = FatApp::getPostedData('max_price_range', null, '');
		if( !empty($price_max_range)) {
			$max_price_range_default_currency =  CommonHelper::getDefaultCurrencyValue($price_max_range,false,false);
			$srch->addCondition('theprice', '<=', $max_price_range_default_currency);
		}

		$featured = FatApp::getPostedData('featured', FatUtility::VAR_INT, 0);
		if( $featured ) {
			$srch->addCondition('product_featured', '=', $featured);
		}

		$srch->addOrder('in_stock','DESC');
		$sortBy = FatApp::getPostedData('sortBy', null, 'popularity');
		$sortOrder = FatApp::getPostedData('sortOrder', null, 'asc');
		
		if(!in_array($sortOrder,array('asc','desc'))){
			$sortOrder = 'asc';
		}
		
		if(!empty($sortBy)) {
			$sortByArr = explode("_",$sortBy);
			$sortBy = isset($sortByArr[0]) ? $sortByArr[0] : $sortBy;
			$sortOrder = isset($sortByArr[1]) ? $sortByArr[1] : $sortOrder;
			switch($sortBy){
				case 'keyword':
					$srch->addOrder( 'keyword_relevancy', 'DESC' );
				break;
				case 'price':
					$srch->addOrder('theprice',$sortOrder);
				break;
				case 'popularity':
					$srch->addOrder('selprod_sold_count',$sortOrder);
				break;
				case 'rating':
					$srch->addOrder('prod_rating',$sortOrder);
				break;
			}
		}
		$srch->addCondition('selprod_deleted' ,'=' , applicationConstants::NO);
		/* groupby added, because if same product is linked with multiple categories, then showing in repeat for each category[ */
		$srch->addGroupBy('selprod_id');
		/* ] */
				
		$rs = $srch->getResultSet();
		$db = FatApp::getDb();
		$productsList = $db->fetchAll($rs);
		
		$priceArr = array(
			"minPrice"=>$price_min_range,
			"maxPrice"=>$price_max_range,
		);
		
		$selectedCurrencyPriceArr = array(
			"minPrice"=>floor(CommonHelper::displayMoneyFormat($priceArr['minPrice'],false,false,false)),
			"maxPrice"=>ceil(CommonHelper::displayMoneyFormat($priceArr['maxPrice'],false,false,false)),
		);
		
		$this->set('products', $productsList );
		$this->set('siteLangId', $this->siteLangId);
		$this->set('page', $page);
		$this->set('pageCount', $srch->pages());
		$this->set('postedData', $post);
		$this->set('colMdVal', $colMdVal);		
		$this->set('recordCount', $srch->recordCount());

		$startRecord = ( $page - 1 ) * $pageSize + 1 ;
		$endRecord = $page * $pageSize;
		$totalRecords = $srch->recordCount();
		if ($totalRecords < $endRecord) { $endRecord = $totalRecords; }
		$json['totalRecords'] = $totalRecords;
		$json['startRecord'] = $startRecord ;
		$json['endRecord'] = $endRecord;
		$json['priceArr'] = $priceArr;					
		$json['selectedCurrencyPriceArr'] = $selectedCurrencyPriceArr;					
		$pSrchFrm = Common::getSiteSearchForm();
		$pSrchFrm->fill(array('btnSiteSrchSubmit' => Labels::getLabel('LBL_Submit' , $this->siteLangId)));
		$pSrchFrm->setFormTagAttribute ( 'onSubmit', 'submitSiteSearch(this); return(false);' );
		$this->set( 'pSrchFrm', $pSrchFrm );
		$searchObj=new SearchItem();
		$this->set('top_searched_keywords',$searchObj->getTopSearchedKeywords());
		if( $totalRecords > 0 ){
			$json['html'] = $this->_template->render( false, false, 'products/products-list.php', true);
		} else {
			$json['html'] = $this->_template->render( false, false, '_partial/no-product-found.php', true);
		}

		$json['loadMoreBtnHtml'] = $this->_template->render( false, false, 'products/products-list-load-more-btn.php', true, false);
		FatUtility::dieJsonSuccess($json);
	}

	public function view( $selprod_id = 0){
		$productImagesArr = array();
		$selprod_id = FatUtility::int($selprod_id);
		$prodSrchObj = new ProductSearch( $this->siteLangId );

		/* fetch requested product[ */
		$prodSrch = clone $prodSrchObj;
		$prodSrch->setDefinedCriteria(0,0,array(),false);
		$prodSrch->joinProductToCategory();
		$prodSrch->joinSellerSubscription();
		$prodSrch->addSubscriptionValidCondition();
		$prodSrch->doNotCalculateRecords();
		$prodSrch->addCondition( 'selprod_id', '=', $selprod_id );
		$prodSrch->addCondition('selprod_deleted','=',applicationConstants::NO);
		$prodSrch->doNotLimitRecords();

		/* sub query to find out that logged user have marked current product as in wishlist or not[ */
		$loggedUserId = 0;
		if( UserAuthentication::isUserLogged() ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
		}
		if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){
			$prodSrch->joinFavouriteProducts( $loggedUserId );
			$prodSrch->addFld('ufp_id');
		}else{
			$prodSrch->joinUserWishListProducts( $loggedUserId );
			$prodSrch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
		}

		$selProdReviewObj = new SelProdReviewSearch();
		$selProdReviewObj->joinProducts($this->siteLangId);
		$selProdReviewObj->joinSellerProducts($this->siteLangId);
		$selProdReviewObj->joinSelProdRating();
		$selProdReviewObj->joinUser();
		$selProdReviewObj->joinSelProdReviewHelpful();
		$selProdReviewObj->addCondition('sprating_rating_type','=',SelProdRating::TYPE_PRODUCT);
		$selProdReviewObj->doNotCalculateRecords();
		$selProdReviewObj->doNotLimitRecords();
		$selProdReviewObj->addGroupBy('spr.spreview_product_id');
		$selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
		$selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id','spr.spreview_product_id',"ROUND(AVG(sprating_rating),2) as prod_rating","count(spreview_id) as totReviews"));
		$selProdRviewSubQuery = $selProdReviewObj->getQuery();
		$prodSrch->joinTable( '(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_product_id = product_id', 'sq_sprating' );

		$prodSrch->addMultipleFields( array(
			'product_id','product_identifier', 'IFNULL(product_name,product_identifier) as product_name', 'product_seller_id', 'product_model','product_type', 'prodcat_id', 'IFNULL(prodcat_name,prodcat_identifier) as prodcat_name', 'product_upc', 'product_isbn', 'product_short_description', 'product_description',
			'selprod_id', 'selprod_user_id', 'selprod_code', 'selprod_condition', 'selprod_price', 'special_price_found','splprice_start_date', 'splprice_end_date', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'selprod_warranty', 'selprod_return_policy','selprodComments',
			'theprice', 'selprod_stock' , 'selprod_threshold_stock_level', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description', 'user_name',
			'shop_id', 'shop_name','ifnull(sq_sprating.prod_rating,0) prod_rating ','ifnull(sq_sprating.totReviews,0) totReviews',
			'splprice_display_dis_type', 'splprice_display_dis_val', 'splprice_display_list_price', 'product_attrgrp_id', 'product_youtube_video', 'product_cod_enabled', 'selprod_cod_enabled','selprod_available_from') );

		$productRs = $prodSrch->getResultSet();
		$product = FatApp::getDb()->fetch($productRs);
		
		/* ] */

		if( !$product ){
			FatUtility::exitWithErrorCode(404);
			/* Message::addErrorMessage("Invalid Request");
			FatApp::redirectUser(CommonHelper::generateUrl('Products')); */
		}

		/* over all catalog product reviews */
		$selProdReviewObj->addCondition('spreview_product_id','=',$product['product_id']);
		$selProdReviewObj->addMultipleFields(array('count(spreview_postedby_user_id) totReviews','sum(if(sprating_rating=1,1,0)) rated_1','sum(if(sprating_rating=2,1,0)) rated_2','sum(if(sprating_rating=3,1,0)) rated_3','sum(if(sprating_rating=4,1,0)) rated_4','sum(if(sprating_rating=5,1,0)) rated_5'));
		$reviews = FatApp::getDb()->fetch($selProdReviewObj->getResultSet());

		$this->set('reviews',$reviews);
		$subscription = false;
		$allowed_images =-1;
		if(FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE'))
		{
			$allowed_images = OrderSubscription::getUserCurrentActivePlanDetails($this->siteLangId,$product['selprod_user_id'],array('ossubs_images_allowed'));
			$subscription = true;
		}

		/* Product::recordProductWeightage($product['selprod_code'],SmartWeightageSettings::PRODUCT_VIEW);
		Product::addUpdateProductBrowsingHistory($product['selprod_code'],SmartWeightageSettings::PRODUCT_VIEW); */

		/* Current Product option Values[ */
		$options = SellerProduct::getSellerProductOptions($selprod_id, false);
		/* CommonHelper::printArray($options); die; */
		$productSelectedOptionValues = array();
		$productGroupImages= array();
		if($options){
			foreach($options as $op){
				/* Product UPC code [ */
					$product['product_upc'] = UpcCode::getUpcCode( $product['product_id'] , $op['selprodoption_optionvalue_id'] );
				/* ] */
				$images = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], $op['selprodoption_optionvalue_id'], $this->siteLangId,true,'',$allowed_images );
				if( $images ){
					$productImagesArr += $images;
				}
				$productSelectedOptionValues[$op['selprodoption_option_id']] = $op['selprodoption_optionvalue_id'];
			}
		}


		if($productImagesArr){
			foreach($productImagesArr as $image){
			  $afileId = $image['afile_id'];
			  if(!array_key_exists($afileId, $productGroupImages)){
				$productGroupImages[$afileId] = array();
			  }
			  $productGroupImages[$afileId] = $image;
			}
		}

		$product['selectedOptionValues'] = $productSelectedOptionValues;
		/* ] */

		if(isset($allowed_images) && $allowed_images >0){

			$universal_allowed_images_count = $allowed_images  - count($productImagesArr);
		}

		$productUniversalImagesArr = array();
		if(empty($productGroupImages) ||  !$subscription || isset($universal_allowed_images_count)){
			$universalImages = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], -1, $this->siteLangId, true,'' );
			/* CommonHelper::printArray($universalImages); die; */
			if($universalImages){
				if(isset($universal_allowed_images_count)){
					$images = array_slice($universalImages,0,$universal_allowed_images_count);

					$productUniversalImagesArr = $images;

					 $universal_allowed_images_count = $universal_allowed_images_count  - count($productUniversalImagesArr);
				}elseif(!$subscription){
					$productUniversalImagesArr = $universalImages;
				}
			}
		}


		if($productUniversalImagesArr){
			foreach($productUniversalImagesArr as $image){
			  $afileId = $image['afile_id'];
			  if(!array_key_exists($afileId, $productGroupImages)){
				$productGroupImages[$afileId] = array();
			  }
			  $productGroupImages[$afileId] = $image;
			}
		}


		/* $universalImages = //$universalImages = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], -1, $this->siteLangId, true,'',$allowed_images_count );
		//if( $universalImages ){
			//$productImagesArr += $universalImages;

		//}abled and Get Shipping Rates*/
		$codEnabled = false;
		if(Product::isProductShippedBySeller($product['product_id'],$product['product_seller_id'],$product['selprod_user_id'])){
			if($product['selprod_cod_enabled']){
				$codEnabled = true;
			}
			$shippingRates = Product::getProductShippingRates($product['product_id'],$this->siteLangId,0,  $product['selprod_user_id']);
			$shippingDetails = Product::getProductShippingDetails($product['product_id'], $this->siteLangId,$product['selprod_user_id']);
		}else{
			if($product['product_cod_enabled']){
				$codEnabled = true;
			}
			$shippingRates = Product::getProductShippingRates($product['product_id'],$this->siteLangId,0, 0);
			$shippingDetails = Product::getProductShippingDetails($product['product_id'], $this->siteLangId,0);
		}

		if($product['product_type'] == Product::PRODUCT_TYPE_DIGITAL){
			$shippingRates = array();
			$shippingDetails  = array();
		}

		$this->set('codEnabled',$codEnabled);
		$this->set('shippingRates',$shippingRates);
		$this->set('shippingDetails',$shippingDetails);
		/*]*/


		/*[ Product shipping cost */
		$shippingCost = 0;
		/*]*/

		/* more sellers[ */
		$moreSellerSrch = clone $prodSrchObj;
		
		$moreSellerSrch->addMoreSellerCriteria( $product['selprod_user_id'], $product['selprod_code'] );
		$moreSellerSrch->addMultipleFields( array( 'selprod_id', 'selprod_user_id', 'selprod_price', 'special_price_found', 'theprice', 'shop_id', 'shop_name' ,'IF(selprod_stock > 0, 1, 0) AS in_stock') );
		$moreSellerSrch->addHaving('in_stock','>',0);
		$moreSellerSrch->addOrder('theprice');
		$moreSellerSrch->addGroupBy('selprod_id');
		$moreSellerRs = $moreSellerSrch->getResultSet();
		$moreSellersArr = FatApp::getDb()->fetchAll($moreSellerRs);
		$product['moreSellersArr'] = $moreSellersArr;
		/* ] */

		$product['selprod_return_policies'] =  SellerProduct::getSelprodPolicies($product['selprod_id'] , PolicyPoint::PPOINT_TYPE_RETURN , $this->siteLangId);
		$product['selprod_warranty_policies'] =  SellerProduct::getSelprodPolicies($product['selprod_id'] , PolicyPoint::PPOINT_TYPE_WARRANTY , $this->siteLangId);
		/* $productImagesArr = array(); */

		/* product Images[ */
		/* if(empty($productGroupImages) ||  !$subscription || isset($universal_allowed_images_count)){

			$images = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], -1,  0, true );

			if($images){
				if(isset($universal_allowed_images_count)){

					$images = array_slice($images,0,$universal_allowed_images_count);

					$productImagesArr = $images;

				}elseif(!$subscription){
					$productImagesArr = $images;
				}
			}


		}
		if($productImagesArr){
			foreach($productImagesArr as &$v){
			 $afileId = $v['afile_id'];
			  if(!array_key_exists($afileId, $productGroupImages)){
				$productGroupImages[$afileId] = array();
			  }
			  $productGroupImages[$afileId] = $v;
			}
		} */

		/* $productImagesArr = array_slice($productImagesArr, 0, $allowed_images, true); */

		/* ] */
		//CommonHelper::printArray($productImagesArr);die;
		/* Form buy product[ */
		$frm = $this->getCartForm($this->siteLangId);
		$frm->fill(array('selprod_id' => $selprod_id));
		$this->set('frmBuyProduct', $frm);
		/* ] */

		$optionSrchObj = clone $prodSrchObj;
		$optionSrchObj->setDefinedCriteria();
		$optionSrchObj->doNotCalculateRecords();
		$optionSrchObj->doNotLimitRecords();
		$optionSrchObj->joinTable( SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'LEFT OUTER JOIN', 'selprod_id = tspo.selprodoption_selprod_id', 'tspo');
		$optionSrchObj->joinTable( OptionValue::DB_TBL, 'LEFT OUTER JOIN', 'tspo.selprodoption_optionvalue_id = opval.optionvalue_id', 'opval' );
		$optionSrchObj->joinTable( Option::DB_TBL, 'LEFT OUTER JOIN', 'opval.optionvalue_option_id = op.option_id', 'op' );
		$optionSrchObj->addCondition('product_id', '=', $product['product_id'] );

		$optionSrch = clone $optionSrchObj;
		$optionSrch->joinTable( Option::DB_TBL.'_lang', 'LEFT OUTER JOIN', 'op.option_id = op_l.optionlang_option_id AND op_l.optionlang_lang_id = '. $this->siteLangId, 'op_l' );
		$optionSrch->addMultipleFields(array(  'option_id', 'option_is_color', 'ifNULL(option_name,option_identifier) as option_name' ));
		$optionSrch->addCondition('option_id','!=','NULL');
		$optionSrch->addCondition('selprodoption_selprod_id','=',$selprod_id);
		$optionSrch->addGroupBy('option_id');

		$optionRs = $optionSrch->getResultSet();
		$optionRows = FatApp::getDb()->fetchAll($optionRs,'option_id');

		if($optionRows){
			foreach($optionRows as &$option){
				$optionValueSrch = clone $optionSrchObj;
				$optionValueSrch->joinTable( OptionValue::DB_TBL.'_lang', 'LEFT OUTER JOIN', 'opval.optionvalue_id = opval_l.optionvaluelang_optionvalue_id AND opval_l.optionvaluelang_lang_id = '. $this->siteLangId, 'opval_l' );
				$optionValueSrch->addCondition('product_id', '=', $product['product_id'] );
				$optionValueSrch->addCondition('option_id', '=', $option['option_id'] );
				$optionValueSrch->addMultipleFields(array( 'IFNULL(product_name, product_identifier) as product_name','selprod_id','selprod_user_id','selprod_code','option_id','ifNULL(optionvalue_name,optionvalue_identifier) as optionvalue_name ', 'theprice', 'optionvalue_id','optionvalue_color_code'));
				$optionValueSrch->addGroupBy('optionvalue_id');
				$optionValueRs = $optionValueSrch->getResultSet();
				$optionValueRows = FatApp::getDb()->fetchAll($optionValueRs,'optionvalue_id');
				$option['values'] = $optionValueRows;
			}
		}
		$this->set('optionRows', $optionRows);

/* Get Product Specifications */
		$specSrchObj = clone $prodSrchObj;
		$specSrchObj->setDefinedCriteria();
		$specSrchObj->doNotCalculateRecords();
		$specSrchObj->doNotLimitRecords();
		$specSrchObj->joinTable( Product::DB_PRODUCT_SPECIFICATION, 'LEFT OUTER JOIN', 'product_id = tcps.prodspec_product_id', 'tcps');
		$specSrchObj->joinTable( Product::DB_PRODUCT_LANG_SPECIFICATION, 'INNER JOIN', 'tcps.prodspec_id = tcpsl.prodspeclang_prodspec_id and   prodspeclang_lang_id  = '.$this->siteLangId, 'tcpsl' );
		$specSrchObj->addMultipleFields(array('prodspec_id','prodspec_name','prodspec_value'));
		$specSrchObj->addGroupBy('prodspec_id');
		$specSrchObj->addCondition('prodspec_product_id','=',$product['product_id']);
		$specSrchObjRs = $specSrchObj->getResultSet();
		$productSpecifications = FatApp::getDb()->fetchAll($specSrchObjRs);

		$this->set( 'productSpecifications', $productSpecifications );

		/* End of Product Specifications */
		/* to save recently viewed products in cookies [ */
		if ( isset($_COOKIE['recentViewedProducts']) ){
			$recentProducts = $_COOKIE['recentViewedProducts'];
			$recentProductsArr = explode( '_' , $recentProducts );
			if( is_array( $recentProductsArr ) && !in_array( $selprod_id, $recentProductsArr ) ){
				if( count($recentProductsArr) >= 10 ){
					$recentProductsArr = array_reverse($recentProductsArr);
					array_pop($recentProductsArr);
					$recentProductsArr = array_reverse($recentProductsArr);
				}

				$newRecentProductsArr = array();
				foreach( $recentProductsArr as $val ){
					if( $val == '' ){ continue; }
					array_push($newRecentProductsArr,$val);
				}
				array_push($newRecentProductsArr,$selprod_id);
				setcookie('recentViewedProducts',implode('_',$newRecentProductsArr),time()+60*60*72, CONF_WEBROOT_URL);
			}
		} else {
			setcookie('recentViewedProducts',$selprod_id.'_',time()+60*60*72, CONF_WEBROOT_URL);
		}
		/* ] */

		if($product){
			$title  = $product['product_name'];

			if($product['selprod_title']){
				$title = $product['selprod_title'];
			}

			$product_description = trim(CommonHelper::subStringByWords(strip_tags(CommonHelper::renderHtml($product["product_description"],true)),500));
			$product_description .= ' - '.Labels::getLabel('LBL_See_more_at', $this->siteLangId).": ".CommonHelper::getCurrUrl();

			$productImageUrl = '';
			/* $productImageUrl = CommonHelper::generateFullUrl('Image','product', array($product['product_id'],'', $product['selprod_id'],0,$this->siteLangId )); */
			if( $productImagesArr ){
				$afile_id = array_keys($productImagesArr)[0];
				$productImageUrl = CommonHelper::generateFullUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $afile_id ) );
			}
			$socialShareContent = array(
				'type'=>'Product',
				'title'=>$title,
				'description'=>$product_description,
				'image'=>$productImageUrl,
			);
			/* CommonHelper::printArray($socialShareContent); die; */
			$this->set( 'socialShareContent', $socialShareContent);
		}


		/* Recommnended Products [ */
		$productId = SellerProduct::getAttributesById($selprod_id , 'selprod_product_id' , false );

		$srch = new ProductSearch( $this->siteLangId );
		$join_price = 1;
		$srch->setDefinedCriteria( $join_price );
		$srch->joinProductToCategory();
		$srch->joinSellerSubscription();
		$srch->addSubscriptionValidCondition();
		$srch->addCondition( 'selprod_deleted', '=', applicationConstants::NO );
		$srch->addMultipleFields(array(
				'product_id','prodcat_id','substring_index(group_concat(IFNULL(prodcat_name, prodcat_identifier) ORDER BY IFNULL(prodcat_name, prodcat_identifier) ASC SEPARATOR "," ) , ",", 1) as prodcat_name', 'IFNULL(product_name, product_identifier) as product_name', 'product_model', 'product_short_description',
				'selprod_id', 'selprod_user_id',  'selprod_code', 'selprod_stock', 'selprod_condition', 'selprod_price', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
				'special_price_found','splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type',
				'theprice', 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description', 'user_name',
				'IF(selprod_stock > 0, 1, 0) AS in_stock','selprod_sold_count','selprod_return_policy','ifnull(prod_rating,0) prod_rating'
				 ));

		$dateToEquate = date('Y-m-d');

		$loggedUserId = UserAuthentication::getLoggedUserId(true);
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
							if( $loggedUserId ){
								$recommendedProductsQuery.= " union
							select rec_product_id , weightage from
							(
								SELECT upr_product_id as rec_product_id , upr_weightage as weightage from tbl_user_product_recommendation
								where upr_user_id = $loggedUserId order by upr_weightage desc limit 5
							) as set3 " ;
							}

							$recommendedProductsQuery.= ")";

		$srch->joinTable("$recommendedProductsQuery" , 'inner join' , 'rs1.rec_product_id = product_id' , 'rs1' );
		$srch->addGroupBy('product_id');
		if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){
			$srch->joinFavouriteProducts( $loggedUserId );
			$srch->addFld('ufp_id');
		}else{
			$srch->joinUserWishListProducts( $loggedUserId );
			$srch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
		}
		$selProdReviewObj = new SelProdReviewSearch();
		$selProdReviewObj->joinSelProdRating();
		$selProdReviewObj->addCondition('sprating_rating_type','=',SelProdRating::TYPE_PRODUCT);
		$selProdReviewObj->doNotCalculateRecords();
		$selProdReviewObj->doNotLimitRecords();
		$selProdReviewObj->addGroupBy('spr.spreview_product_id');
		$selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
		$selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id',"ROUND(AVG(sprating_rating),2) as prod_rating"));
		$selProdRviewSubQuery = $selProdReviewObj->getQuery();
		$srch->joinTable( '(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_selprod_id = selprod_id', 'sq_sprating' );
		$srch->setPageSize(5);
		$srch->doNotCalculateRecords();
		$recommendedProducts = FatApp::getDb()->fetchAll($srch->getResultSet());
		$this->set('recommendedProducts' , $recommendedProducts);
		/* ]  */


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
		/* $sellerProductObj = new SellerProduct();
		$productGroups = $sellerProductObj->getGroupsToProduct( $selprod_id, $this->siteLangId );
		if( $productGroups ){
			foreach( $productGroups as $key => &$pg ){
				$srch = new ProductSearch( $this->siteLangId, ProductGroup::DB_PRODUCT_TO_GROUP, ProductGroup::DB_PRODUCT_TO_GROUP_PREFIX.'product_id' );
				$srch->setBatchProductsCriteria();
				$srch->addCondition( ProductGroup::DB_PRODUCT_TO_GROUP_PREFIX.'prodgroup_id', '=', $pg['ptg_prodgroup_id'] );
				$srch->addMultipleFields( array( 'selprod_id', 'product_id', 'selprod_stock', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'IFNULL(splprice_price, selprod_price) AS theprice', 'CASE WHEN splprice_selprod_id IS NULL THEN 0 ELSE 1 END AS special_price_found' ) );
				$rs = $srch->getResultSet();
				$pg_products = FatApp::getDb()->fetchAll($rs);
				//$pg_products = $sellerProductObj->getProductsToGroup( $pg['ptg_prodgroup_id'], $this->siteLangId );
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
		$criteria='selprod_id';
		$sellerObj=new SellerProduct();
		$upsellProducts=$sellerObj->getUpsellProducts($product['selprod_id'],$this->siteLangId);
		$relatedProducts=$sellerObj->getRelatedProducts($product['selprod_id'],$this->siteLangId,$criteria);

		$relatedProductsRs=$this->relatedProductsById(array_keys($relatedProducts));
		// CommonHelper::printArray($relatedProductsRs);die;

		$srch = new ShopSearch( $this->siteLangId );
		$srch->setDefinedCriteria( $this->siteLangId );
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields(array( 'shop_id','shop_user_id','shop_ltemplate_id', 'shop_created_on', 'ifNULL(shop_name,shop_identifier)as shop_name', 'shop_description',
		'ifNULL(shop_country_l.country_name,shop_country.country_code) as shop_country_name', 'ifNULL(shop_state_l.state_name,state_identifier) as shop_state_name', 'shop_city','shop_free_ship_upto' ));
		$srch->addCondition( 'shop_id', '=', $product['shop_id'] );
		$shopRs = $srch->getResultSet();
		$shop = FatApp::getDb()->fetch( $shopRs );

		if(!FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)){
			$shop_rating = 0;
		}else{
			$shop_rating = SelProdRating::getSellerRating($shop['shop_user_id']);
		}


	/* 	$bannerSrch = Banner::getBannerLocationSrchObj(true);
		$bannerSrch->addCondition('blocation_id','=',3);
		$rs = $bannerSrch->getResultSet();
		$bannerLocation = FatApp::getDb()->fetchAll( $rs ,'blocation_key');

		$banners = $bannerLocation;
		foreach( $bannerLocation as $val ){
			$srch = Banner::getSearchObject($this->siteLangId,true);
			$srch->doNotCalculateRecords();

			if($val['blocation_banner_count'] > 0){
				$srch->setPageSize($val['blocation_banner_count']);
			}

			$srch->addCondition('banner_blocation_id','=',$val['blocation_id']);
			$rs = $srch->getResultSet();
			$bannerListing = FatApp::getDb()->fetchAll( $rs,'banner_id');
			$banners[$val['blocation_key']]['banners'] = $bannerListing;
		} */


		/*   [ Promotional Banner   */

		$bannerSrch = Banner::getBannerLocationSrchObj(true);
		$bannerSrch->addCondition('blocation_id','=',3);
		$rs = $bannerSrch->getResultSet();
		$bannerLocation = FatApp::getDb()->fetchAll( $rs ,'blocation_key');

		$banners = $bannerLocation;
		foreach( $bannerLocation as $val ){
			$srch = new BannerSearch($this->siteLangId,true);
			$srch->joinPromotions($this->siteLangId, true,true,true);
			$srch->addPromotionTypeCondition();
			$srch->joinUserWallet();
			$srch->addMinimiumWalletbalanceCondition();
			$srch->addSkipExpiredPromotionAndBannerCondition();
			$srch->joinBudget();
			$srch->joinActiveUser();
			$srch->addMultipleFields(array('banner_id','banner_blocation_id','banner_type','banner_record_id','banner_url','banner_target','banner_title','promotion_id' ,'daily_cost','weekly_cost','monthly_cost','total_cost', ));
			$srch->addOrder('','rand()');
			$srch->doNotCalculateRecords();

			if($val['blocation_banner_count'] > 0){
				$srch->setPageSize($val['blocation_banner_count']);
			}
			$srch->addCondition('banner_blocation_id','=',$val['blocation_id']);

			$srch = new SearchBase('('.$srch->getQuery().') as t');
			$srch->doNotCalculateRecords();
			$srch->addDirectCondition('((CASE
					WHEN promotion_duration='.Promotion::DAILY.' THEN promotion_budget > COALESCE(daily_cost,0)
					WHEN promotion_duration='.Promotion::WEEKLY.' THEN promotion_budget > COALESCE(weekly_cost,0)
					WHEN promotion_duration='.Promotion::MONTHLY.' THEN promotion_budget > COALESCE(monthly_cost,0)
					WHEN promotion_duration='.Promotion::DURATION_NOT_AVAILABALE.' THEN promotion_budget = -1
				  END ) )');
			$srch->addMultipleFields(array('banner_id','banner_blocation_id','banner_type','banner_record_id','banner_url','banner_target','banner_title','promotion_id' ,'userBalance','daily_cost','weekly_cost','monthly_cost','total_cost','promotion_budget' ,'promotion_duration'));
			$rs = $srch->getResultSet();
			$bannerListing = FatApp::getDb()->fetchAll( $rs,'banner_id');
			$banners[$val['blocation_key']]['banners'] = $bannerListing;
		}

		/* End of Prmotional Banner  ]*/
		
		// CommonHelper::printArray($productImagesArr); die;
		$this->set( 'upsellProducts', $upsellProducts );
		$this->set( 'relatedProductsRs', $relatedProductsRs );
		$this->set( 'banners', $banners );
		
		$this->set( 'product', $product );
		$this->set( 'shop_rating', $shop_rating);
		$this->set('shop', $shop);
		$this->set('productImagesArr',$productGroupImages);
		//	$this->set( 'productGroups', $productGroups );
		$frmReviewSearch = $this->getReviewSearchForm(5);
		$frmReviewSearch->fill(array('selprod_id'=>$selprod_id));
		$this->set( 'frmReviewSearch', $frmReviewSearch );


		/* Get product Polls [ */
		$pollQuest = Polling::getProductPoll($product['product_id'] , $this->siteLangId);
		$this->set('pollQuest', $pollQuest);
		/* ] */
		
		/* Get Product Volume Discount (if any)[ */
		$srch = new SellerProductVolumeDiscountSearch();
		$srch->doNotCalculateRecords();
		$srch->addMultipleFields( array('voldiscount_min_qty', 'voldiscount_percentage') );
		$srch->addCondition( 'voldiscount_selprod_id', '=', $product['selprod_id'] );
		$srch->addOrder( 'voldiscount_min_qty', 'ASC' );
		$rs = $srch->getResultSet();
		$volumeDiscountRows = FatApp::getDb()->fetchAll($rs);
		$this->set( 'volumeDiscountRows', $volumeDiscountRows );
		/* ] */
		
		$this->_template->addCss('css/slick.css');
		$this->_template->addJs('js/slick.js');
		$this->_template->addCss('css/modaal.css');
		$this->_template->addJs('js/modaal.js');
		$this->_template->addCss('css/product-detail.css');
		$this->_template->addJs('js/product-detail.js');
		$this->_template->addJs('js/responsive-img.min.js');
		$this->_template->addCss('css/cart.css');
		$this->_template->addCss('css/xzoom.css');
		$this->_template->addJs('js/xzoom.js');
		//var_dump($product); die;
		$this->_template->render();
	}

	public function getProductShippingRates(){
		$post  = FatApp::getPostedData();
		$productId =  $post['productId'];
		$sellerId =  $post['sellerId'];
	}

	public function recentlyViewedProducts(){
		$loggedUserId = 0;
		if( UserAuthentication::isUserLogged() ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
		}
		$recentViewedProducts = array();
		$cookieProducts = isset($_COOKIE['recentViewedProducts']) ? $_COOKIE['recentViewedProducts'] : false;
		if($cookieProducts!=false){
			$cookiesProductsArr = explode("_", $cookieProducts);
			if(!isset($cookiesProductsArr) || !is_array($cookiesProductsArr) || count($cookiesProductsArr)<=0 ){
				return '';
			}
			if( isset($cookiesProductsArr) && is_array($cookiesProductsArr) && count($cookiesProductsArr) ){
				$cookiesProductsArr = array_map('intval', $cookiesProductsArr);
				$cookiesProductsArr = array_reverse($cookiesProductsArr);
				$prodSrch = new ProductSearch( $this->siteLangId );
				$prodSrch->setDefinedCriteria();
				$prodSrch->joinSellerSubscription();
				$prodSrch->addSubscriptionValidCondition();
				$prodSrch->joinProductToCategory();
				$prodSrch->doNotCalculateRecords();
				$prodSrch->doNotLimitRecords();
				if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){
					$prodSrch->joinFavouriteProducts( $loggedUserId );
					$prodSrch->addFld('ufp_id');
				}else{
					$prodSrch->joinUserWishListProducts( $loggedUserId );
					$prodSrch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
				}
				$prodSrch->joinProductRating();
				$prodSrch->addCondition('selprod_id', 'IN', $cookiesProductsArr );
				$prodSrch->addMultipleFields(array(
						'product_id', 'IFNULL(product_name, product_identifier) as product_name', 'prodcat_id', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name', 'ifnull(sq_sprating.prod_rating,0) prod_rating ',
						'selprod_id', 'selprod_condition', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'theprice',
						'special_price_found', 'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type','selprod_sold_count', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title','selprod_price'));


				$productRs = $prodSrch->getResultSet();
				$recentViewedProducts = FatApp::getDb()->fetchAll($productRs,'selprod_id');

				uksort($recentViewedProducts, function($key1, $key2) use ($cookiesProductsArr) {
					return (array_search($key1, $cookiesProductsArr) > array_search($key2, $cookiesProductsArr));
				});
			}
		}
		$this->set( 'recentViewedProducts', $recentViewedProducts );
		$this->_template->render( false, false );
	}

	public function relatedProductsById($ids=array()){
		$loggedUserId = 0;
		if( UserAuthentication::isUserLogged() ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
		}
		if( isset($ids) && is_array($ids) && count($ids) ){
			$prodSrch = new ProductSearch( $this->siteLangId );
			$prodSrch->setDefinedCriteria();
			$prodSrch->joinProductToCategory();
			$prodSrch->doNotCalculateRecords();
			$prodSrch->doNotLimitRecords();
			if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){
				$prodSrch->joinFavouriteProducts( $loggedUserId );
				$prodSrch->addFld('ufp_id');
			}else{
				$prodSrch->joinUserWishListProducts( $loggedUserId );
				$prodSrch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
			}
			$prodSrch->joinProductRating();
			$prodSrch->addCondition('selprod_id', 'IN', $ids );
			$prodSrch->addMultipleFields(array(
					'product_id', 'IFNULL(product_name, product_identifier) as product_name', 'prodcat_id', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name', 'ifnull(sq_sprating.prod_rating,0) prod_rating ', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
					'selprod_id', 'selprod_condition', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'theprice',
					'special_price_found', 'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type','selprod_sold_count','selprod_price'));
			
			$productRs = $prodSrch->getResultSet();
			$Products = FatApp::getDb()->fetchAll($productRs,'selprod_id');

			uksort($Products, function($key1, $key2) use ($ids) {
				return (array_search($key1, $ids) > array_search($key2, $ids));
			});
			return $Products;
		}
	}

	/* public function top_50(){
		$this->_template->render();
	} */

	/* public function batch($prodgroup_id = 0){
		$prodgroup_id = FatUtility::int($prodgroup_id);

		$srch = ProductGroup::getSearchObj($this->siteLangId);
		$srch->addCondition('b.prodgroup_id','=',$prodgroup_id);
		$srch->joinTable( Shop::DB_TBL, 'LEFT OUTER JOIN','s.shop_user_id = b.prodgroup_user_id', 's');
		$srch->joinTable( Shop::DB_TBL_LANG, 'LEFT OUTER JOIN','s_l.shoplang_shop_id = s.shop_id and s_l.shoplang_lang_id = '.$this->siteLangId, 's_l');
		$srch->addMultipleFields(array('b.*','b_l.prodgroup_name','shop_id','ifnull(shop_name,shop_identifier) as shop_name'));
		$rs = $srch->getResultSet();
		$batch = FatApp::getDb()->fetch($rs);

		$pg_products = array();
		if(!empty($batch)){
			$srch = new ProductSearch( $this->siteLangId, ProductGroup::DB_PRODUCT_TO_GROUP, ProductGroup::DB_PRODUCT_TO_GROUP_PREFIX.'product_id' );
			$srch->setBatchProductsCriteria();
			$srch->addCondition( ProductGroup::DB_PRODUCT_TO_GROUP_PREFIX.'prodgroup_id', '=', $prodgroup_id );
			$srch->addMultipleFields( array( 'selprod_id', 'product_id', 'selprod_stock', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'IFNULL(splprice_price, selprod_price) AS theprice', 'CASE WHEN splprice_selprod_id IS NULL THEN 0 ELSE 1 END AS special_price_found' ) );
			$rs = $srch->getResultSet();
			$pg_products = FatApp::getDb()->fetchAll($rs);
		}

		$this->set( 'pg_products', $pg_products );
		$this->set( 'batch', $batch );
		$this->_template->render();
	} */

	public function searchProducttagsAutocomplete(){
		$post = FatApp::getPostedData();
		$json = array();
		$srch = Tag::getSearchObject( $this->siteLangId );
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields( array('tag_id', 'IFNULL(tag_name, tag_identifier) as tag_name') );
		$srch->addOrder('tag_name');
		$srch->addGroupby('tag_name');
		$srch->addCondition( 'tag_name', 'LIKE', '%'.urldecode($post["keyword"]).'%' );
		$rs = $srch->getResultSet();
		$tags = FatApp::getDb()->fetchAll($rs);

		foreach ($tags as $key => $tag) {
			$json[] = array(
				//'label'  => FatUtility::convertToType($tag['tag_id'],FatUtility::VAR_STRING),
				'value' 	=> strip_tags(html_entity_decode($tag['tag_name'], ENT_QUOTES, 'UTF-8')),
			);
		}

		/* $sort_order = array();
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['value'];
		}
		array_multisort($sort_order, SORT_ASC, $json); */
		//echo json_encode( array( 'suggestions' => array('suggestion' => $json ) ) );
		echo json_encode(array('suggestions'=>$json)); exit;
	}

	public function getBreadcrumbNodes($action) {
		$nodes = array();
		$parameters = FatApp::getParameters();
		switch($action){
			case 'view':
				$nodes[] = array('title' => Labels::getLabel('LBL_Products', $this->siteLangId), 'href' => CommonHelper::generateUrl('Products') );
				if ( isset($parameters[0]) && FatUtility::int($parameters[0]) > 0 ) {
					$selprod_id = FatUtility::int($parameters[0]);
					if($selprod_id){
						$srch = new ProductSearch( $this->siteLangId );
						$srch->joinSellerProducts();
						$srch->joinProductToCategory();
						$srch->doNotCalculateRecords();
						$srch->doNotLimitRecords();
						$srch->addMultipleFields(array('IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title','IFNULL(product_name, product_identifier)as product_name','GETCATCODE(prodcat_id) AS prodcat_code'));
						$srch->addCondition('selprod_id', '=', $selprod_id );
						$rs = $srch->getResultSet();
						$row = FatApp::getDb()->fetch($rs);
						if($row){
							$productCatCode = $row['prodcat_code'];
							$productCatCode =  explode("_",$productCatCode);
							$productCatCode  = array_filter($productCatCode, 'strlen');
							$productCatObj = new ProductCategory;
							$prodCategories =  $productCatObj->getCategoriesForSelectBox($this->siteLangId,'',$productCatCode);

							foreach($productCatCode as $code){
								$code= FatUtility::int($code);
								if(isset( $prodCategories[$code]['prodcat_name'])){
									$prodCategories[$code]['prodcat_name'];
									$nodes[] = array('title' => $prodCategories[$code]['prodcat_name'],'href'=>CommonHelper::generateUrl('category','view',array($code)));
								}
							}
							$nodes[] = array('title' => ($row['selprod_title'])? $row['selprod_title']:$row['product_name']);
						}
					}
				}
			break;
			default:
				$nodes[] = array('title'=>Labels::getLabel('LBL_'.FatUtility::camel2dashed($action),$this->siteLangId	));
			break;
		}
		return $nodes;
	}

	public function logWeightage(){
		$post  = FatApp::getPostedData();
		$selprod_code = (isset($post['selprod_code']) && $post['selprod_code'] !='')?$post['selprod_code']:'';

		if($selprod_code == '') { return false;}

		$weightageKey = SmartWeightageSettings::PRODUCT_VIEW ;
		if(isset($post['timeSpend']) && $post['timeSpend'] == true){
			$weightageKey = SmartWeightageSettings::PRODUCT_TIME_SPENT;
		}

		$weightageSettings = SmartWeightageSettings::getWeightageAssoc();
		Product::recordProductWeightage($selprod_code,$weightageKey,$weightageSettings[$weightageKey]);
	}

	private function getCartForm($formLangId){
		$frm = new Form('frmBuyProduct',array('id'=>'frmBuyProduct'));
		$fld = $frm->addTextBox(Labels::getLabel( 'LBL_Quantity', $formLangId ), 'quantity',1, array('maxlength' => '3'));
		$fld->requirements()->setIntPositive();
		// $frm->addSubmitButton(null, 'btnProductBuy', Labels::getLabel('LBL_Buy_Now', $formLangId ), array( 'id' => 'btnProductBuy' ) );
		//$frm->addSubmitButton(null, 'btnAddToCart', Labels::getLabel('LBL_Add_to_Cart', $formLangId), array( 'id' => 'btnAddToCart' ));
		$frm->addHTML(null, 'btnProductBuy', '<button name="btnProductBuy" type="submit" id="btnProductBuy" class="btn btn--primary btn--h-large ripplelink block-on-mobile add-to-cart--js btnBuyNow"><i class="fa fa-shopping-cart"></i> '.Labels::getLabel('LBL_Buy_Now', $formLangId ).'</button>' );
		$frm->addHTML(null, 'btnAddToCart', '<button name="btnAddToCart" type="submit" id="btnAddToCart" class="btn btn--secondary btn--h-large ripplelink block-on-mobile add-to-cart--js"><i class="fa fa-cart-plus"></i> '.Labels::getLabel('LBL_Add_to_Cart', $formLangId ).'</button>' );
		$frm->addHiddenField('', 'selprod_id');
		return $frm;
	}

	private function getReviewSearchForm($pageSize = 10){
		$frm = new Form('frmReviewSearch');
		$frm->addHiddenField('', 'selprod_id');
		$frm->addHiddenField('', 'page');
		$frm->addHiddenField('', 'pageSize',$pageSize);
		$frm->addHiddenField('', 'orderBy','most_helpful');
		return $frm;
	}

	private function getReviewAbuseForm($reviewId){
		$frm = new Form('frmReviewAbuse');
		$frm->addHiddenField('', 'spra_spreview_id',$reviewId);
		$frm->addTextarea(Labels::getLabel('Lbl_Comments',$this->siteLangId), 'spra_comments');
		$frm->addSubmitButton('', 'btn_submit',Labels::getLabel('Lbl_Report_Abuse',$this->siteLangId));
		return $frm;
	}

	private function getPollForm($pollId, $langId){
		$frm = new Form('frmPoll');
		$frm->addHiddenField('', 'polling_id',$pollId);
		$frm->addRadioButtons('','polling_feedback',Polling::getPollingResponseTypeArr($langId), '' ,array('class'=>'listing--vertical listing--vertical-chcek'),array());
		$frm->addSubmitButton('', 'btn_submit',Labels::getLabel('Lbl_Vote',$this->siteLangId) ,array('class'=>'btn btn--primary poll--link-js'));
		return $frm;
	}

	public function fatActionCatchAll( $action ){
		FatUtility::exitWithErrorCode(404);
	}

	public function track($productId = 0){
		$bannerId = FatUtility::int($productId);
		if( 1 > $productId){
			Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access',$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl(''));
		}
		$loggedUserId = 0;
		if( UserAuthentication::isUserLogged() ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
		}
		/* Track Click */
			$prodObj = new PromotionSearch($this->siteLangId,true);
			$prodObj->joinProducts();
			$prodObj->joinShops();
			$prodObj->addPromotionTypeCondition(Promotion::TYPE_PRODUCT);
			$prodObj->addShopActiveExpiredCondition();
			$prodObj->joinUserWallet();
			$prodObj->joinBudget();
			$prodObj->addBudgetCondition();
			$prodObj->doNotCalculateRecords();
			$prodObj->addMultipleFields(array('selprod_id as proSelProdId','promotion_id'));
			$prodObj->addCondition('promotion_record_id','=',$productId);
			$sponsoredProducts = array();
			$productSrchObj = new ProductSearch( $this->siteLangId );
			$productSrchObj->joinProductToCategory($this->siteLangId );
			$productSrchObj->doNotCalculateRecords();
			$productSrchObj->setPageSize( 10 );
			$productSrchObj->setDefinedCriteria();

			if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){
				$productSrchObj->joinFavouriteProducts( $loggedUserId );
				$productSrchObj->addFld('ufp_id');
			}else{
				$productSrchObj->joinUserWishListProducts( $loggedUserId );
				$productSrchObj->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
			}
			$productSrchObj->joinProductRating( );

			$productSrchObj->addMultipleFields( array('product_id', 'selprod_id', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
			'special_price_found', 'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type',
			'theprice', 'selprod_price','selprod_stock', 'selprod_condition','prodcat_id','IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','ifnull(sq_sprating.prod_rating,0) prod_rating ','selprod_sold_count') );

			$productCatSrchObj = ProductCategory::getSearchObject( false, $this->siteLangId );
			$productCatSrchObj->doNotCalculateRecords();
			/* $productCatSrchObj->setPageSize(4); */
			$productCatSrchObj->addMultipleFields( array('prodcat_id', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','prodcat_description') );

			$productSrchObj->joinTable('(' . $prodObj->getQuery().') ','INNER JOIN', 'selprod_id = ppr.proSelProdId ', 'ppr');
			$productSrchObj->addFld(array('promotion_id'));

			$productSrchObj->joinSellerSubscription( );
			$productSrchObj->addSubscriptionValidCondition();
			$productSrchObj->addGroupBy('selprod_id');

			$rs = $productSrchObj->getResultSet();
			$row = FatApp::getDb()->fetch($rs);	;

			$url  = CommonHelper::generateFullUrl('products','view',array($productId));
			if($row == false){
				if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
					FatApp::redirectUser($url);
				}
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
				'pclick_cost' => Promotion::getPromotionCostPerClick(Promotion::TYPE_PRODUCT),
				'pclick_session_id' => session_id(),
			);

			FatApp::getDb()->insertFromArray(Promotion::DB_TBL_CLICKS,$promotionClickData,false,'',$promotionClickData);
			$clickId= FatApp::getDb()->getInsertId();

			$promotionClickChargesData = array(

				'picharge_pclick_id' => $clickId,
				'picharge_datetime'  => date('Y-m-d H:i:s'),
				'picharge_cost'  => Promotion::getPromotionCostPerClick(Promotion::TYPE_PRODUCT),

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
			FatApp::redirectUser($url);
		}

		FatApp::redirectUser(CommonHelper::generateUrl(''));

	}

	public function sellers($selprod_id){
		$selprod_id = FatUtility::int($selprod_id);
		$prodSrchObj = new ProductSearch( $this->siteLangId );

		/* fetch requested product[ */
		$prodSrch = clone $prodSrchObj;
		$prodSrch->setDefinedCriteria(0,0,array(),false);
		$prodSrch->joinProductToCategory();
		$prodSrch->joinSellerSubscription();
		$prodSrch->addSubscriptionValidCondition();
		$prodSrch->doNotCalculateRecords();
		/* $prodSrch->addCondition( 'selprod_id', '=', $selprod_id ); */
		$prodSrch->doNotLimitRecords();

		/* sub query to find out that logged user have marked current product as in wishlist or not[ */
		$loggedUserId = 0;
		if( UserAuthentication::isUserLogged() ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
		}


		$selProdReviewObj = new SelProdReviewSearch();
		$selProdReviewObj->joinSelProdRating();
		$selProdReviewObj->addCondition('sprating_rating_type','=',SelProdRating::TYPE_PRODUCT);
		$selProdReviewObj->doNotCalculateRecords();
		$selProdReviewObj->doNotLimitRecords();
		$selProdReviewObj->addGroupBy('spr.spreview_product_id');
		$selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
		$selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id','spr.spreview_product_id',"ROUND(AVG(sprating_rating),2) as prod_rating","count(spreview_id) as totReviews"));
		$selProdRviewSubQuery = $selProdReviewObj->getQuery();
		$prodSrch->joinTable( '(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_product_id = product_id', 'sq_sprating' );

		$prodSrch->addMultipleFields( array(
			'product_id', 'IFNULL(product_name,product_identifier ) as product_name', 'product_seller_id', 'product_model', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name', 'product_upc', 'product_isbn', 'product_short_description', 'product_description',
			'selprod_id', 'selprod_user_id', 'selprod_code', 'selprod_condition', 'selprod_price', 'special_price_found','splprice_start_date', 'splprice_end_date', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'selprod_warranty', 'selprod_return_policy','selprodComments',
			'theprice', 'selprod_stock' , 'selprod_threshold_stock_level', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description', 'user_name',
			'shop_id', 'shop_name', 'ifnull(sq_sprating.prod_rating,0) prod_rating ','ifnull(sq_sprating.totReviews,0) totReviews',
			'splprice_display_dis_type', 'splprice_display_dis_val', 'splprice_display_list_price', 'product_attrgrp_id', 'product_youtube_video', 'product_cod_enabled', 'selprod_cod_enabled') );

		$productRs = $prodSrch->getResultSet();
		// echo $prodSrch->getQuery(); die;
		$product = FatApp::getDb()->fetch($productRs);

		//var_dump($product);
		/* ] */
		if( !$product ){
			FatUtility::exitWithErrorCode(404);
			//die("Invalid Request");
			/* Message::addErrorMessage("Invalid Request");
			FatApp::redirectUser(CommonHelper::generateUrl('Products')); */
		}
		/* more sellers[ */
		$moreSellerSrch = clone $prodSrchObj;
		$moreSellerSrch->addMoreSellerCriteria( $product['selprod_user_id'], $product['selprod_code'] );
		$moreSellerSrch->addMultipleFields( array( 'selprod_id', 'selprod_user_id', 'selprod_price', 'special_price_found', 'theprice', 'shop_id', 'shop_name', 'product_seller_id','product_id',
		'shop_country_l.country_name as shop_country_name', 'shop_state_l.state_name as shop_state_name', 'shop_city','selprod_cod_enabled', 'product_cod_enabled','IF(selprod_stock > 0, 1, 0) AS in_stock','selprod_min_order_qty','selprod_available_from') );
		$moreSellerSrch->addOrder('theprice');
		$moreSellerSrch->addHaving('in_stock','>',0);
		$moreSellerSrch->addGroupBy('selprod_id');
		$moreSellerRs = $moreSellerSrch->getResultSet();
		$moreSellersArr = FatApp::getDb()->fetchAll($moreSellerRs);
		$product['moreSellersArr'] = $moreSellersArr;

		foreach($moreSellersArr as $seller){
			if(FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)){
				$product['rating'][$seller['selprod_user_id']]= SelProdRating::getSellerRating($seller['selprod_user_id']);
			}else{
				$product['rating'][$seller['selprod_user_id']]= 0;
			}

			/*[ Check COD enabled*/
			$codEnabled = false;
			if(Product::isProductShippedBySeller($seller['product_id'],$seller['product_seller_id'],$seller['selprod_user_id'])){
				if($product['selprod_cod_enabled']){
					$codEnabled = true;
				}
			}else{
				if($product['product_cod_enabled']){
					$codEnabled = true;
				}
			}
			$product['cod'][$seller['selprod_user_id']] =$codEnabled ;
			/*]*/
		}


		/* ] */
		$this->set('product',$product);

		$this->_template->render();

	}
	
	function productQuickDetail($selprod_id = 0){
		$productImagesArr = array();
		$selprod_id = FatUtility::int($selprod_id);
		$prodSrchObj = new ProductSearch( $this->siteLangId );

		/* fetch requested product[ */
		$prodSrch = clone $prodSrchObj;
		$prodSrch->setDefinedCriteria(false,false,array(),false);
		$prodSrch->joinProductToCategory();
		$prodSrch->joinSellerSubscription();
		$prodSrch->addSubscriptionValidCondition();
		$prodSrch->doNotCalculateRecords();
		$prodSrch->addCondition( 'selprod_id', '=', $selprod_id );
		$prodSrch->doNotLimitRecords();

		/* sub query to find out that logged user have marked current product as in wishlist or not[ */
		$loggedUserId = 0;
		if( UserAuthentication::isUserLogged() ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
		}
		
		if( FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO){
			$prodSrch->joinFavouriteProducts( $loggedUserId );
			$prodSrch->addFld('ufp_id');
		}else{
			$prodSrch->joinUserWishListProducts( $loggedUserId );
			$prodSrch->addFld('IFNULL(uwlp.uwlp_selprod_id, 0) as is_in_any_wishlist');
		}

		$selProdReviewObj = new SelProdReviewSearch();
		$selProdReviewObj->joinSelProdRating();
		$selProdReviewObj->addCondition('sprating_rating_type','=',SelProdRating::TYPE_PRODUCT);
		$selProdReviewObj->doNotCalculateRecords();
		$selProdReviewObj->doNotLimitRecords();
		$selProdReviewObj->addGroupBy('spr.spreview_product_id');
		$selProdReviewObj->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
		$selProdReviewObj->addMultipleFields(array('spr.spreview_selprod_id','spr.spreview_product_id',"ROUND(AVG(sprating_rating),2) as prod_rating","count(spreview_id) as totReviews"));
		$selProdRviewSubQuery = $selProdReviewObj->getQuery();
		$prodSrch->joinTable( '(' . $selProdRviewSubQuery . ')', 'LEFT OUTER JOIN', 'sq_sprating.spreview_product_id = product_id', 'sq_sprating' );

		$prodSrch->addMultipleFields( array(
			'product_id','product_identifier', 'IFNULL(product_name,product_identifier) as product_name', 'product_seller_id', 'product_model','product_type', 'prodcat_id', 'IFNULL(prodcat_name,prodcat_identifier) as prodcat_name', 'product_upc', 'product_isbn', 'product_short_description', 'product_description',
			'selprod_id', 'selprod_user_id', 'selprod_code', 'selprod_condition', 'selprod_price', 'special_price_found','splprice_start_date', 'splprice_end_date', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title', 'selprod_warranty', 'selprod_return_policy','selprodComments',
			'theprice', 'selprod_stock' , 'selprod_threshold_stock_level', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description', 'user_name',
			'shop_id', 'shop_name','ifnull(sq_sprating.prod_rating,0) prod_rating ','ifnull(sq_sprating.totReviews,0) totReviews',
			'splprice_display_dis_type', 'splprice_display_dis_val', 'splprice_display_list_price', 'product_attrgrp_id', 'product_youtube_video', 'product_cod_enabled', 'selprod_cod_enabled','selprod_available_from') );

		/* echo $selprod_id; die; */
		$productRs = $prodSrch->getResultSet();
		$product = FatApp::getDb()->fetch($productRs);
		

		/* ] */

		if( !$product ){
			FatUtility::exitWithErrorCode(404);
		}

		
		$subscription = false;
		$allowed_images =-1;
		if(FatApp::getConfig('CONF_ENABLE_SELLER_SUBSCRIPTION_MODULE'))
		{
			$allowed_images = OrderSubscription::getUserCurrentActivePlanDetails($this->siteLangId,$product['selprod_user_id'],array('ossubs_images_allowed'));
			$subscription = true;
		}
		
		/* Current Product option Values[ */
		$options = SellerProduct::getSellerProductOptions($selprod_id, false);
		/* CommonHelper::printArray($options);die(); */
		$productSelectedOptionValues = array();
		$productGroupImages= array();
		if($options){
			foreach($options as $op){
				/* Product UPC code [ */
					/* $product['product_upc'] = UpcCode::getUpcCode( $product['product_id'] , $op['selprodoption_optionvalue_id'] ); */
				/* ] */
				$images = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], $op['selprodoption_optionvalue_id'], $this->siteLangId,true,'',$allowed_images );
				if( $images ){
					$productImagesArr += $images;
				}
				$productSelectedOptionValues[$op['selprodoption_option_id']] = $op['selprodoption_optionvalue_id'];
			}
		}


		if($productImagesArr){
			foreach($productImagesArr as $image){
			  $afileId = $image['afile_id'];
			  if(!array_key_exists($afileId, $productGroupImages)){
				$productGroupImages[$afileId] = array();
			  }
			  $productGroupImages[$afileId] = $image;
			}
		}

		$product['selectedOptionValues'] = $productSelectedOptionValues;
		/* ] */

		if(isset($allowed_images) && $allowed_images >0){

			$universal_allowed_images_count = $allowed_images  - count($productImagesArr);
		}

		$productUniversalImagesArr = array();
		if(empty($productGroupImages) ||  !$subscription || isset($universal_allowed_images_count)){
			$universalImages = AttachedFile::getMultipleAttachments( AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id'], -1, $this->siteLangId, true,'' );
			/* CommonHelper::printArray($universalImages); die; */
			if($universalImages){
				if(isset($universal_allowed_images_count)){
					$images = array_slice($universalImages,0,$universal_allowed_images_count);

					$productUniversalImagesArr = $images;

					 $universal_allowed_images_count = $universal_allowed_images_count  - count($productUniversalImagesArr);
				}elseif(!$subscription){
					$productUniversalImagesArr = $universalImages;
				}
			}
		}

		if($productUniversalImagesArr){
			foreach($productUniversalImagesArr as $image){
			  $afileId = $image['afile_id'];
			  if(!array_key_exists($afileId, $productGroupImages)){
				$productGroupImages[$afileId] = array();
			  }
			  $productGroupImages[$afileId] = $image;
			}
		}

		/*[ Product shipping cost */
		$shippingCost = 0;
		/*]*/

		/* more sellers[ */
		$moreSellerSrch = clone $prodSrchObj;
		$moreSellerSrch->addMoreSellerCriteria( $product['selprod_user_id'], $product['selprod_code'] );
		$moreSellerSrch->addMultipleFields( array( 'selprod_id', 'selprod_user_id', 'selprod_price', 'special_price_found', 'theprice', 'shop_id', 'shop_name' ,'IF(selprod_stock > 0, 1, 0) AS in_stock') );
		$moreSellerSrch->addHaving('in_stock','>',0);
		$moreSellerSrch->addOrder('theprice');
		$moreSellerRs = $moreSellerSrch->getResultSet();
		$moreSellersArr = FatApp::getDb()->fetchAll($moreSellerRs);
		$product['moreSellersArr'] = $moreSellersArr;
		/* ] */

		$product['selprod_return_policies'] =  SellerProduct::getSelprodPolicies($product['selprod_id'] , PolicyPoint::PPOINT_TYPE_RETURN , $this->siteLangId);
		$product['selprod_warranty_policies'] =  SellerProduct::getSelprodPolicies($product['selprod_id'] , PolicyPoint::PPOINT_TYPE_WARRANTY , $this->siteLangId);
		
		/* Form buy product[ */
		$frm = $this->getCartForm($this->siteLangId);
		$frm->fill(array('selprod_id' => $selprod_id));
		$this->set('frmBuyProduct', $frm);
		/* ] */

		$optionSrchObj = clone $prodSrchObj;
		$optionSrchObj->setDefinedCriteria();
		$optionSrchObj->doNotCalculateRecords();
		$optionSrchObj->doNotLimitRecords();
		$optionSrchObj->joinTable( SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'LEFT OUTER JOIN', 'selprod_id = tspo.selprodoption_selprod_id', 'tspo');
		$optionSrchObj->joinTable( OptionValue::DB_TBL, 'LEFT OUTER JOIN', 'tspo.selprodoption_optionvalue_id = opval.optionvalue_id', 'opval' );
		$optionSrchObj->joinTable( Option::DB_TBL, 'LEFT OUTER JOIN', 'opval.optionvalue_option_id = op.option_id', 'op' );
		$optionSrchObj->addCondition('product_id', '=', $product['product_id'] );

		$optionSrch = clone $optionSrchObj;
		$optionSrch->joinTable( Option::DB_TBL.'_lang', 'LEFT OUTER JOIN', 'op.option_id = op_l.optionlang_option_id AND op_l.optionlang_lang_id = '. $this->siteLangId, 'op_l' );
		$optionSrch->addMultipleFields(array(  'option_id', 'option_is_color', 'ifNULL(option_name,option_identifier) as option_name' ));
		$optionSrch->addCondition('option_id','!=','NULL');
		$optionSrch->addCondition('selprodoption_selprod_id','=',$selprod_id);
		$optionSrch->addGroupBy('option_id');
		/* echo $optionSrch->getQuery();die; */
		$optionRs = $optionSrch->getResultSet();
		$optionRows = FatApp::getDb()->fetchAll($optionRs,'option_id');
		/* CommonHelper::printArray($optionRows);die; */
		if($optionRows){
			foreach($optionRows as &$option){
				$optionValueSrch = clone $optionSrchObj;
				$optionValueSrch->joinTable( OptionValue::DB_TBL.'_lang', 'LEFT OUTER JOIN', 'opval.optionvalue_id = opval_l.optionvaluelang_optionvalue_id AND opval_l.optionvaluelang_lang_id = '. $this->siteLangId, 'opval_l' );
				$optionValueSrch->addCondition('product_id', '=', $product['product_id'] );
				$optionValueSrch->addCondition('option_id', '=', $option['option_id'] );
				$optionValueSrch->addMultipleFields(array( 'IFNULL(product_name, product_identifier) as product_name','selprod_id','selprod_user_id','selprod_code','option_id','ifNULL(optionvalue_name,optionvalue_identifier) as optionvalue_name ', 'theprice', 'optionvalue_id','optionvalue_color_code'));
				$optionValueSrch->addGroupBy('optionvalue_id');
				$optionValueRs = $optionValueSrch->getResultSet();
				$optionValueRows = FatApp::getDb()->fetchAll($optionValueRs,'optionvalue_id');
				$option['values'] = $optionValueRows;
			}
		}
		$this->set('optionRows', $optionRows);

		/* Get Product Specifications */
		$specSrchObj = clone $prodSrchObj;
		$specSrchObj->setDefinedCriteria();
		$specSrchObj->doNotCalculateRecords();
		$specSrchObj->doNotLimitRecords();
		$specSrchObj->joinTable( Product::DB_PRODUCT_SPECIFICATION, 'LEFT OUTER JOIN', 'product_id = tcps.prodspec_product_id', 'tcps');
		$specSrchObj->joinTable( Product::DB_PRODUCT_LANG_SPECIFICATION, 'INNER JOIN', 'tcps.prodspec_id = tcpsl.prodspeclang_prodspec_id and   prodspeclang_lang_id  = '.$this->siteLangId, 'tcpsl' );
		$specSrchObj->addMultipleFields(array('prodspec_id','prodspec_name','prodspec_value'));
		$specSrchObj->addGroupBy('prodspec_id');
		$specSrchObj->addCondition('prodspec_product_id','=',$product['product_id']);
		$specSrchObjRs = $specSrchObj->getResultSet();
		$productSpecifications = FatApp::getDb()->fetchAll($specSrchObjRs);

		$this->set( 'productSpecifications', $productSpecifications );

		/* End of Product Specifications */

		if($product){
			$title  = $product['product_name'];

			if($product['selprod_title']){
				$title = $product['selprod_title'];
			}

			$product_description = trim(CommonHelper::subStringByWords(strip_tags(CommonHelper::renderHtml($product["product_description"],true)),500));
			$product_description .= ' - '.Labels::getLabel('LBL_See_more_at', $this->siteLangId).": ".CommonHelper::getCurrUrl();

			$productImageUrl = '';
			/* $productImageUrl = CommonHelper::generateFullUrl('Image','product', array($product['product_id'],'', $product['selprod_id'],0,$this->siteLangId )); */
			if( $productImagesArr ){
				$afile_id = array_keys($productImagesArr)[0];
				$productImageUrl = CommonHelper::generateFullUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $afile_id ) );
			}
		}
		$this->set( 'product', $product );
		$this->set('productImagesArr',$productGroupImages);

		$this->_template->render(false,false);
	}
	
	function links_autocomplete(){
		$prodCatObj = new ProductCategory();
		$post = FatApp::getPostedData();
		$arr_options = $prodCatObj->getProdCatTreeStructureSearch( 0, $this->siteLangId,$post['keyword'] );
		$json = array();
		foreach( $arr_options as $key => $product ){
			$json[] = array(
				'id' 	=> $key,
				'name'  => strip_tags(html_entity_decode($product , ENT_QUOTES, 'UTF-8'))
			);
		}
		die(json_encode($json));		
	}		
}