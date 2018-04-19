<?php
class BrandsController extends MyAppController {
	public function __construct($action){
		parent::__construct($action);
	}
	
	public function index() {
		$brandSrch = Brand::getListingObj($this->siteLangId,array( 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name'),true);
		$brandSrch->doNotCalculateRecords();
		$brandSrch->doNotLimitRecords();
		$brandSrch->addOrder('brand_name', 'asc');		
		$brandRs = $brandSrch->getResultSet();
		$brandsArr = FatApp::getDb()->fetchAll($brandRs);
		/* CommonHelper::printArray($brandsArr);die; */
		$this->set('layoutDirection',Language::getLayoutDirection($this->siteLangId));		
		$this->set('allBrands', $brandsArr);
		$this->_template->render();
	}
	
	public function all(){
		FatApp::redirectUser( CommonHelper::generateUrl('Brands') );
	}
	
	public function view( $brandId ){
		$brandId = FatUtility::int($brandId);
		Brand::recordBrandWeightage($brandId);
		$db = FatApp::getDb();

		$this->includeProductPageJsCss();
		$frm = $this->getProductSearchForm();	
		
		$prodSrchObj = new ProductSearch( $this->siteLangId );
		$prodSrchObj->setDefinedCriteria(0);
		$prodSrchObj->joinProductToCategory();
		$prodSrchObj->joinSellerSubscription();
		$prodSrchObj->addSubscriptionValidCondition();
		$prodSrchObj->doNotCalculateRecords();
		$prodSrchObj->setPageSize(FatApp::getConfig('CONF_PAGE_SIZE',FatUtility::VAR_INT, 10));
		
		if($brandId > 0) {
		    $prodSrchObj->addBrandCondition($brandId);
		}
		$rs = $prodSrchObj->getResultSet();
		$record = FatApp::getDb()->fetch($rs);
		/* Brand Filters Data[ */
		$brandSrch = Brand::getListingObj($this->siteLangId,array( 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description'));
		$brandSrch->doNotCalculateRecords();
		$brandSrch->doNotLimitRecords();
		$brandSrch->addCondition('brand_id','=',$brandId);
		$brandRs = $brandSrch->getResultSet();
		$brandsArr = $db->fetchAll($brandRs);
		
		
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
		$priceSrch = new ProductSearch( $this->siteLangId );
		$priceSrch->setDefinedCriteria(1);
		$priceSrch->joinProductToCategory();
		$priceSrch->joinSellerSubscription();
		$priceSrch->addSubscriptionValidCondition();
		$priceSrch->doNotCalculateRecords();
		$priceSrch->doNotLimitRecords();

		if($brandId > 0) {
			$priceSrch->addBrandCondition($brandId);
		}
		$priceSrch->addMultipleFields( array('MIN(theprice) as minPrice', 'MAX(theprice) as maxPrice') );
		$qry = $priceSrch->getQuery();
		$qry .= ' having minPrice IS NOT NULL AND maxPrice IS NOT NULL';
		//echo $qry; die();
		//$priceRs = $priceSrch->getResultSet();
		$priceRs = $db->query($qry);
		$priceArr = $db->fetch($priceRs);
		/* ] */
		
		
		/* Categories Data[ */
		//echo $prodSrchObj->getQuery();die();
		$catSrch = clone $prodSrchObj;
		$catSrch->addGroupBy( 'prodcat_code' );
		//$categoriesArr = productCategory::getProdCatParentChildWiseArr( $this->siteLangId, 0, true, false, false, $catSrch );
		
		$productCatObj = new ProductCategory;
		$productCategories =  $productCatObj->getCategoriesForSelectBox($this->siteLangId);			
		
		$categoriesArr = ProductCategory::getProdCatParentChildWiseArr($this->siteLangId, 0, false, false, false, $catSrch,true);
		

		usort($categoriesArr, function($a, $b) {
		  return $a['prodcat_code'] - $b['prodcat_code'];
		});
		
		/* ] */
		
		$productFiltersArr = array( 
			'categoriesArr'		=>	$categoriesArr, 
			'productCategories'		=>	$productCategories,
			'shopCatFilters'		=>	true,
			'brandsArr'			=>	$brandsArr,
			'brandsCheckedArr'	=>	array($brandId),
			'conditionsArr'		=>	$conditionsArr,			
			'priceArr'			=>	$priceArr,			
			'siteLangId'		=>	$this->siteLangId
		);
		
		$brandData = array();
		$brandData = array_shift($brandsArr);
		
		$this->set('frmProductSearch', $frm);	
		$this->set('brandData', $brandData);
		$this->set('productFiltersArr', $productFiltersArr );
		if(empty($record)){
			$this->set('noProductFound', 'noProductFound');
		}
		$this->_template->addJs('js/slick.min.js'); 
		$this->_template->addCss(array('css/slick.css','css/product-detail.css'));
		$this->_template->render();
	}
	
	function autoComplete(){
		$pagesize = FatApp::getConfig('CONF_PAGE_SIZE');
		$post = FatApp::getPostedData();
		
		$brandObj = new Brand();
		$srch = $brandObj->getSearchObject($this->siteLangId,true,true);
		
		$srch->addMultipleFields(array('brand_id, IFNULL(brand_name, brand_identifier) as brand_name'));
		
		if (!empty($post['keyword'])) {
			$srch->addCondition('brand_name', 'LIKE', '%' . $post['keyword'] . '%');
		}
		$srch->addCondition('brand_status', '=',Brand::BRAND_REQUEST_APPROVED);
	
		$srch->setPageSize($pagesize);
		$rs = $srch->getResultSet();
		$db = FatApp::getDb();
		$brands = $db->fetchAll($rs,'brand_id');
		$json = array();
		foreach( $brands as $key => $brand ){
			$json[] = array(
				'id' => $key,
				'name'      => strip_tags(html_entity_decode($brand['brand_name'], ENT_QUOTES, 'UTF-8'))
			);
		}
		die(json_encode($json));
		/* $this->set('brands', $db->fetchAll($rs,'brand_id') );
		$this->_template->render(false,false); */
	}
	
	public function checkUniqueBrandName(){
		$post = FatApp::getPostedData();
		
		$langId = FatUtility::int($post['langId']);
		
		$brandName = $post['brandName'];
		$brandId =  FatUtility::int($post['brandId']);
		if(1>$langId){
			trigger_error(Labels::getLabel('LBL_Lang_Id_not_Specified',CommonHelper::getLangId()));
		}
		if(1>$brandId){
			trigger_error(Labels::getLabel('LBL_Brand_Id_not_Specified',CommonHelper::getLangId()));
		}
		$srch = Brand::getSearchObject($langId);
		$srch->addCondition('brand_name','=', $brandName );
		if($brandId)
		$srch->addCondition('brand_id','!=', $brandId );
		$rs = $srch->getResultSet();
		$records = $srch->recordCount();
		if($records>0){
			
			FatUtility::dieJsonError(sprintf(Labels::getLabel('LBL_%s_not_available',$this->siteLangId),$brandName));
		}
		FatUtility::dieJsonSuccess(array());
	}
	
	public function getBreadcrumbNodes($action) {
		$nodes = array();
		$parameters = FatApp::getParameters();
		switch($action)
		{
			case 'view':
				$nodes[] = array('title'=>Labels::getLabel('LBL_Brands',$this->siteLangId), 'href'=>CommonHelper::generateUrl('brands'));
				if (isset($parameters[0]) && $parameters[0] > 0) {
					$brandId = FatUtility::int($parameters[0]);
					if ($brandId>0){
						
						$brandSrch = Brand::getListingObj($this->siteLangId,array( 'IFNULL(brand_name, brand_identifier) as brand_name', ));
						$brandSrch->doNotCalculateRecords();
						$brandSrch->doNotLimitRecords();
						$brandSrch->addCondition('brand_id','=',$brandId);
						$brandRs = $brandSrch->getResultSet();
						$brandsArr = FatApp::getDb()->fetch($brandRs);
						$nodes[] = array('title'=>$brandsArr['brand_name']);
							
							
						}
					} 
				
			break;
			
			case 'index':
				$nodes[] = array('title'=>Labels::getLabel('LBL_Brands',$this->siteLangId));
				
			break;

			
		}
		return $nodes;
	}	
}