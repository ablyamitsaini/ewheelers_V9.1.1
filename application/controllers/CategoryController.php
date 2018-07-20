<?php
class CategoryController extends MyAppController {
	public function __construct($action){
		parent::__construct($action);
	}

	public function index(){
		$categoriesArr = ProductCategory::getProdCatParentChildWiseArr( $this->siteLangId,'',true,false,true );
		$this->set('categoriesArr', $categoriesArr );
		$this->_template->render();
	}

	public function view( $category_id ){
		$category_id = FatUtility::int( $category_id );
		ProductCategory::recordCategoryWeightage( $category_id );

		$db = FatApp::getDb();
		$this->includeProductPageJsCss();
		$frm = $this->getProductSearchForm();

		$headerFormParamsArr = FatApp::getParameters();
		$headerFormParamsAssocArr = CommonHelper::arrayToAssocArray($headerFormParamsArr);
		//var_dump($headerFormParamsAssocArr); exit;
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
		$headerFormParamsAssocArr['category'] = $category_id;
		$headerFormParamsAssocArr['join_price'] = 1;
		$frm->fill( $headerFormParamsAssocArr );
		
		$catSrch = new ProductCategorySearch( $this->siteLangId );
		$catSrch->addCondition( 'prodcat_id', '=', $category_id );


		/* to show searched category data[ */
		$catSrch->addMultipleFields( array('prodcat_id','IFNULL(prodcat_name, prodcat_identifier) as prodcat_name','prodcat_description','GETCATCODE(prodcat_id) AS prodcat_code') );
		$catSrchRs = $catSrch->getResultSet();
		$categoryData = $db->fetch( $catSrchRs );


		if( !$categoryData ){
			FatUtility::exitWithErrorCode( 404 );
		}
		$catBanner = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER, $categoryData['prodcat_id'] );
		$categoryData['catBanner'] = $catBanner;
		/* ] */

		$prodSrchObj = new ProductSearch( $this->siteLangId );
		$prodSrchObj->setDefinedCriteria();
		$prodSrchObj->joinProductToCategory();
		$prodSrchObj->joinSellerSubscription();
		$prodSrchObj->addSubscriptionValidCondition();
		$prodSrchObj->doNotCalculateRecords();
		$prodSrchObj->setPageSize(FatApp::getConfig('CONF_PAGE_SIZE',FatUtility::VAR_INT, 10));
		$prodSrchObj->addCategoryCondition($category_id);

		//$prodSrchObj->addMultipleFields(array('selprod_id','prodcat_id'));
		$rs = $prodSrchObj->getResultSet();
		$record = FatApp::getDb()->fetchAll($rs);


		//	var_dump($record); die;

		$brandsArr = array();
		$conditionsArr  = array();
		$priceArr  = array();

		/* Categories Data[ */
		$catSrch = clone $prodSrchObj;
		$catSrch->addGroupBy('prodcat_id');
		$categoriesDataArr = productCategory::getProdCatParentChildWiseArr( $this->siteLangId, $category_id, false, false, false, $catSrch,false );

		//var_dump($categoriesDataArr); die;

		$productCategory = new productCategory;
		$categoriesArr = $productCategory ->getCategoryTreeArr($this->siteLangId,$categoriesDataArr);


		/* ] */

		/* Brand Filters Data[ */
		$brandSrch = clone $prodSrchObj;
		$brandSrch->addGroupBy('brand_id');
		$brandSrch->addOrder('brand_name');
		$brandSrch->addMultipleFields(array( 'brand_id', 'ifNull(brand_name,brand_identifier) as brand_name', 'brand_short_description'));
		/* if needs to show product counts under brands[ */
		//$brandSrch->addFld('count(selprod_id) as totalProducts');
		/* ] */

		$brandRs = $brandSrch->getResultSet();
		$brandsArr = $db->fetchAll($brandRs);
		/* ] */

		/* {Can modify the logic fetch data directly from query . will implement later}
		Option Filters Data[ */
		$options = array();
		if($category_id && ProductCategory::isLastChildCategory($category_id)){
			$selProdCodeSrch = clone $prodSrchObj;
			$selProdCodeSrch->addGroupBy('selprod_code');
			$selProdCodeSrch->addMultipleFields(array('product_id','selprod_code'));
			$selProdCodeRs = $selProdCodeSrch->getResultSet();
			$selProdCodeArr = $db->fetchAll($selProdCodeRs);

			if(!empty($selProdCodeArr)){
				foreach($selProdCodeArr as $val){
					$optionsVal = SellerProduct::getSellerProductOptionsBySelProdCode($val['selprod_code'],$this->siteLangId,true);
					$options = $options+$optionsVal;
				}
			}
		}
		
		usort($options, function($a, $b) {
			if ($a['optionvalue_id']==$b['optionvalue_id']) return 0;
			return ($a['optionvalue_id']<$b['optionvalue_id'])?-1:1;
		});
		
		/* $optionSrch->joinSellerProductOptionsWithSelProdCode();
		$optionSrch->addGroupBy('optionvalue_id'); */
		/*]*/


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
		$priceSrch->addCategoryCondition($category_id);
		$priceSrch->addMultipleFields( array('MIN(theprice) as minPrice', 'MAX(theprice) as maxPrice') );
		
	
		$qry = $priceSrch->getQuery();
		$qry .= ' having minPrice IS NOT NULL AND maxPrice IS NOT NULL';
		//$priceRs = $priceSrch->getResultSet();
		$priceRs = $db->query($qry);
		$priceArr = $db->fetch($priceRs);
		
		$priceInFilter = false;	
		$filterDefaultMinValue = $priceArr['minPrice'];
		$filterDefaultMaxValue = $priceArr['maxPrice'];
		if(array_key_exists('price-min-range',$headerFormParamsAssocArr) && array_key_exists('price-max-range',$headerFormParamsAssocArr)){
			$priceArr['minPrice'] = $headerFormParamsAssocArr['price-min-range'];
			$priceArr['maxPrice'] = $headerFormParamsAssocArr['price-max-range'];
			$priceInFilter = true;
		}
		/* ] */

		$brandsCheckedArr = array();
		if(array_key_exists('brand',$headerFormParamsAssocArr)){
			$brandsCheckedArr = $headerFormParamsAssocArr['brand'];
		}
		
		$optionValueCheckedArr = array();
		if(array_key_exists('optionvalues',$headerFormParamsAssocArr)){
			$optionValueCheckedArr = $headerFormParamsAssocArr['optionvalues'];
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
		//	'categoryDataArr'		=>	$categoryFilterData,
			'brandsArr'				=>	$brandsArr,
			'brandsCheckedArr'		  =>	$brandsCheckedArr,
			'availability'	          =>	 $availability,
			'conditionsArr'			=>	$conditionsArr,
			'conditionsCheckedArr'	  =>	$conditionsCheckedArr,
			'priceArr'				=>	$priceArr,
			'options'				=>	$options,
			'siteLangId'			=>	$this->siteLangId,
			'priceInFilter'			  =>	$priceInFilter,		 
			'filterDefaultMinValue'			  =>	$filterDefaultMinValue,		
			'filterDefaultMaxValue'			  =>	$filterDefaultMaxValue,
			'count_for_view_more'   =>  FatApp::getConfig('CONF_COUNT_FOR_VIEW_MORE', FatUtility::VAR_INT, 5)
		);




		//$this->set('categoryData',$categoryData);
		 $this->set( 'productFiltersArr', $productFiltersArr );
		 $this->set('frmProductSearch',$frm);

		$this->set('categoryData', $categoryData);
		//$this->_template->render(false, false, 'category/view-test.php');
		//exit();

		// $this->_template->render(false, false, 'category/view.php');

		//var_dump($categoryData); die;

		if( empty($record) ){
			$this->set('noProductFound', 'noProductFound');
		}
		$this->set('priceArr', $priceArr);
		$this->set('priceInFilter', $priceInFilter);
		/* Get category Polls [ */
		$pollQuest = Polling::getCategoryPoll($category_id , $this->siteLangId);
		$this->set('pollQuest', $pollQuest);
		$this->set('category_id', $category_id);
		$this->set('canonicalUrl', CommonHelper::generateFullUrl('Category','view',array($category_id)));
		/* ] */
		$this->_template->addJs('js/slick.min.js'); 
		$this->_template->addCss(array('css/slick.css','css/product-detail.css')); 
		$this->_template->render();
	}

	public function image( $catId, $langId = 0, $sizeType = ''){
		$catId = FatUtility::int($catId);
		$langId = FatUtility::int($langId);
		$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_IMAGE, $catId, 0, $langId );
		$image_name = isset($file_row['afile_physical_path']) ?  $file_row['afile_physical_path'] : '';

		switch( strtoupper( $sizeType ) ){
			case 'THUMB':
				$w = 100;
				$h = 100;
				AttachedFile::displayImage( $image_name, $w, $h );
			break;
			case 'COLLECTION_PAGE':
				$w = 45;
				$h = 41;
				AttachedFile::displayImage( $image_name, $w, $h );
			break;
			default:
				AttachedFile::displayOriginalImage( $image_name );
			break;
		}
	}

	public function icon( $catId, $langId = 0, $sizeType = ''){
		$catId = FatUtility::int($catId);
		$langId = FatUtility::int($langId);
		$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_ICON, $catId, 0, $langId );
		$image_name = isset($file_row['afile_physical_path']) ?  $file_row['afile_physical_path'] : '';

		switch( strtoupper($sizeType) ){
			case 'THUMB':
				$w = 100;
				$h = 100;
				AttachedFile::displayImage( $image_name, $w, $h );
			break;
			case 'COLLECTION_PAGE':
				$w = 48;
				$h = 48;
				AttachedFile::displayImage( $image_name, $w, $h );
			break;
			default:
				AttachedFile::displayOriginalImage( $image_name );
			break;
		}
	}

	public function sellerBanner( $shopId, $prodCatId, $langId = 0, $sizeType = '' ){
		$shopId = FatUtility::int( $shopId );
		$prodCatId = FatUtility::int( $prodCatId );
		$langId = FatUtility::int( $langId );

		$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER_SELLER, $shopId, $prodCatId, $langId );
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

	public function banner( $prodCatId, $langId = 0, $sizeType = '', $subRcordId = 0){
		$prodCatId = FatUtility::int($prodCatId);
		$subRcordId = FatUtility::int($subRcordId);
		$langId = FatUtility::int($langId);

		$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER, $prodCatId, $subRcordId, $langId );
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

	/* public function banner( $shopId, $sizeType = '', $prodCatId = 0){
		$shopId = FatUtility::int($shopId);
		$prodCatId = FatUtility::int($prodCatId);

		$file_row = false;
		if($prodCatId > 0){
			$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER_SELLER, $shopId,$prodCatId );
			if(false == $file_row){
				$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_SHOP_BANNER, $shopId );
			}
		}

		if(false == $file_row){
			// $file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_BANNER, $shopId );
			$file_row = AttachedFile::getAttachment( AttachedFile::FILETYPE_SHOP_BANNER, $shopId );
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
	} */

	public function getBreadcrumbNodes($action) {
		$nodes = array();
		$parameters = FatApp::getParameters();
		switch($action)
		{
			case 'view':
				//$nodes[] = array('title'=>'Root Categories', 'href'=>CommonHelper::generateUrl('ProductCategories'));
				if (isset($parameters[0]) && $parameters[0] > 0) {
					$parent = FatUtility::int($parameters[0]);
					if ($parent>0){
						$cntInc=1;
						$prodCateObj =new ProductCategory();
						$category_structure=$prodCateObj->getCategoryStructure($parent,'',$this->siteLangId);
						$category_structure = array_reverse($category_structure);
						foreach($category_structure as $catKey=>$catVal){
							if ($cntInc<count($category_structure)){
								$nodes[] = array('title'=>$catVal["prodcat_name"], 'href'=>Commonhelper::generateUrl('category','view',array($catVal['prodcat_id'])));
							}else{
								$nodes[] = array('title'=>$catVal["prodcat_name"]);
							}
							$cntInc++;
						}
					}

				}
			break;

			case 'form':
			break;
		}
		return $nodes;
	}

}
