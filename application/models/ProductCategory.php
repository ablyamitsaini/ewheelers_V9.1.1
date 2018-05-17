<?php
class ProductCategory extends MyAppModel{
	const DB_TBL = 'tbl_product_categories';
	const DB_TBL_PREFIX = 'prodcat_';
	const DB_LANG_TBL ='tbl_product_categories_lang';
	const DB_LANG_TBL_PREFIX ='prodcatlang_';
	const REWRITE_URL_PREFIX = 'category/view/';
	private $db;
	private $categoryTreeArr = array();


	public function __construct( $id = 0 ) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id );
		$this->db = FatApp::getDb();
	}

	public static function getSearchObject( $includeChildCount = false , $langId = 0, $prodcat_active = true ) {
		$langId = FatUtility::int( $langId );
		$srch = new SearchBase(static::DB_TBL, 'm');
		$srch->addOrder('m.prodcat_active', 'DESC');

		if ( $includeChildCount ) {
			$childSrchbase = new SearchBase(static::DB_TBL);
			$childSrchbase->addCondition('prodcat_deleted','=',0);
			$childSrchbase->doNotCalculateRecords();
			$childSrchbase->doNotLimitRecords();
			$srch->joinTable('('.$childSrchbase->getQuery().')', 'LEFT OUTER JOIN', 's.prodcat_parent = m.prodcat_id', 's');
			$srch->addGroupBy('m.prodcat_id');
			$srch->addFld('COUNT(s.prodcat_id) AS child_count');
		}

		if( $langId > 0){
			$srch->joinTable(static::DB_LANG_TBL,'LEFT OUTER JOIN',
			'pc_l.'.static::DB_LANG_TBL_PREFIX.'prodcat_id = m.'.static::tblFld('id').' and
			pc_l.'.static::DB_LANG_TBL_PREFIX.'lang_id = '.$langId,'pc_l');
		}

		if( $prodcat_active ){
			$srch->addCondition( 'm.prodcat_active', '=', applicationConstants::ACTIVE );
		}

		return $srch;
	}

	function getMaxOrder( $parent = 0 ){
		$srch = new SearchBase(static::DB_TBL);
		$srch->addFld("MAX(" . static::DB_TBL_PREFIX . "display_order) as max_order");
		if($parent>0){
			$srch->addCondition(static::DB_TBL_PREFIX.'parent','=',$parent);
		}
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$rs = $srch->getResultSet();
		$record = FatApp::getDb()->fetch($rs);
		if(!empty($record))
			return $record['max_order']+1;
		return 1;
	}

	/* public function save() {

		// Check if adding i.e. $this->mainTableRecordId == 0
		// get max displayOrder under the same parent.
		// set displayOrder of this to max + 1

		if ( 0 < $this->mainTableRecordId) {
			$result = $this->objMainTableRecord->update(array('smt'=>$this->mainTableIdField . ' = ?', 'vals'=>array($this->mainTableRecordId)));
		}
		else {
			$result = $this->objMainTableRecord->addNew();
			if ( $result ) {
				$this->mainTableRecordId = $this->objMainTableRecord->getId();
			}
			//todo:set display order based on parent
		}

		if (!$result) {
			$this->error = $this->objMainTableRecord->getError();
		}

		return $result;
	} */

	/* public function getProdCategories( $langId = 0 ) {
		$langId = FatUtility::int( $langId );
		$srch = static::getSearchObject();
		$srch->addCondition('m.prodcat_deleted', '=', 0);
		$srch->addOrder('m.prodcat_display_order','asc');
		$srch->addFld(array('m.prodcat_id','m.prodcat_identifier'));

		if( $langId > 0){
			$srch->joinTable( static::DB_LANG_TBL,'LEFT OUTER JOIN',
			'pc_l.'.static::DB_LANG_TBL_PREFIX.'prodcat_id = m.'.static::tblFld('id').' and
			pc_l.'.static::DB_LANG_TBL_PREFIX.'lang_id = '.$langId,'pc_l');
		}
		return $record = FatApp::getDb()->fetchAllAssoc($srch->getResultSet());
	} */

	public function getCategoryStructure( $prodcat_id, $category_tree_array = '',$langId = 0 ){
		if ( !is_array($category_tree_array) ) $category_tree_array = array();
		$langId =  FatUtility::int($langId);
		
		$srch = static::getSearchObject();
		$srch->addCondition('m.prodcat_deleted', '=', applicationConstants::NO);
		$srch->addCondition('m.prodcat_active', '=', applicationConstants::ACTIVE);
		$srch->addCondition('m.prodcat_id', '=', $prodcat_id);
		$srch->addOrder('m.prodcat_display_order','asc');
		$srch->addOrder('m.prodcat_identifier','asc');
		
		if($langId > 0 ){ 
			$srch->joinTable(static::DB_LANG_TBL,'LEFT OUTER JOIN',static::DB_LANG_TBL_PREFIX.'prodcat_id = '.static::tblFld('id').' and '.static::DB_LANG_TBL_PREFIX.'lang_id = '.$langId);
			$srch->addFld(array('IFNULL(prodcat_name,prodcat_identifier) as prodcat_name'));
		}else{
			$srch->addFld(array('prodcat_identifier as prodcat_name'));
		}
		
		$srch->addMultipleFields(array('prodcat_id','prodcat_identifier','prodcat_parent'));
		$rs = $srch->getResultSet();		
		while( $categories = FatApp::getDb()->fetch($rs) ){
				$category_tree_array[] = $categories;
				$category_tree_array = self::getCategoryStructure($categories['prodcat_parent'],$category_tree_array,$langId);
			}
		
		return $category_tree_array;
	}

	/* public function getProdCat($prodcat_id,$lang_id=0){
		$srch =$this->getSearchObject();
		$srch->addCondition('m.prodcat_id','=',$prodcat_id);
		if($lang_id>0){
			$srch->joinTable(static::DB_LANG_TBL, 'LEFT JOIN', 'plang.prodcatlang_prodcat_id = m.prodcat_id', 'plang');
			$srch->addFld('plang.*');
		}
		$srch->addFld('m.*');
		$record = FatApp::getDb()->fetch($srch->getResultSet());
		//var_dump($record); exit;
		$lang_record=array();
		return  array_merge($record,$lang_record);

	} */

	public function addUpdateProdCatLang($data,$lang_id,$prodcat_id){
		$tbl = new TableRecord(static::DB_LANG_TBL);
		$data['prodcatlang_prodcat_id']=FatUtility::int($prodcat_id);
		$tbl->assignValues($data);
		if($this->isExistProdCatLang($lang_id,$prodcat_id)){
			if(!$tbl->update(array('smt'=>'prodcatlang_prodcat_id = ? and prodcatlang_lang_id = ? ','vals'=>array($prodcat_id,$lang_id)))){
				$this->error = $tbl->getError();
				return false;
			}
			return $prodcat_id;
		}
		if(!$tbl->addNew()){
			$this->error = $tbl->getError();
			return false;
		}
		return true;
	}

	public function isExistProdCatLang($lang_id,$prodcat_id){
		$srch = new SearchBase(static::DB_LANG_TBL);
		$srch->addCondition('prodcatlang_prodcat_id','=', $prodcat_id);
		$srch->addCondition('prodcatlang_lang_id','=', $lang_id);
		$row = FatApp::getDb()->fetch($srch->getResultSet());
		if(!empty($row)){
			return true;
		}
		return false;
	}

	public function getParentTreeStructure($prodCat_id=0,$level=0,$name_suffix='',$langId=0){
		$langId = FatUtility::int($langId);
		$srch = static::getSearchObject(false,$langId);
		$srch->addFld('m.prodcat_id,IFNULL(prodcat_name,m.prodcat_identifier) as prodcat_identifier,m.prodcat_parent');
		$srch->addCondition('m.prodcat_deleted', '=', applicationConstants::NO);
		$srch->addCondition('m.prodcat_active', '=', applicationConstants::ACTIVE);
		$srch->addCondition('m.prodCat_id', '=', FatUtility::int($prodCat_id));
		$rs = $srch->getResultSet();
		$records = FatApp::getDb()->fetch($rs);

		$name='';
		$seprator='';
		if ($level>0){
			$seprator=' &nbsp;&nbsp;&raquo;&raquo;&nbsp;&nbsp;';
		}

		if($records){
			$name=$records['prodcat_identifier'].$seprator.$name_suffix;
			if($records['prodcat_parent']>0){
				$name=self::getParentTreeStructure($records['prodcat_parent'],$level+1,$name,$langId);
			}
		}
		return $name;
	}

	public static function isLastChildCategory($prodCat_id = 0){
		$srch = static::getSearchObject();
		$srch->addCondition('prodcat_parent','=',$prodCat_id);
		$srch->addCondition('prodcat_active','=',applicationConstants::ACTIVE);
		$srch->addCondition('prodcat_deleted','=',applicationConstants::NO);
		$srch->addMultipleFields(array('prodcat_id'));
		$srch->doNotCalculateRecords();
		$srch->setPageSize(1);
		$rs = $srch->getResultSet();
		$records = FatApp::getDb()->fetch($rs);
		if(empty($records)){
			return true;
		}
		return false;
	}

	public function getProdCatAutoSuggest( $keywords = '', $limit = 10, $langId = 0 ){
		$srch = static::getSearchObject(false, $langId);
		$srch->addFld('m.prodcat_id,m.prodcat_identifier,m.prodcat_parent');
		$srch->addCondition('m.prodcat_deleted', '=', applicationConstants::NO);
		$srch->addCondition('m.prodcat_active', '=', applicationConstants::ACTIVE);
		if (!empty($keywords)){
			$srch->addCondition('m.prodcat_identifier','like','%'.$keywords.'%');
		}
		$srch->addOrder('m.prodcat_parent','asc');
		$srch->addOrder('m.prodcat_display_order','asc');
		$srch->addOrder('m.prodcat_identifier','asc');
		$rs = $srch->getResultSet();
		$records = FatApp::getDb()->fetchAll($rs);

		$return = array();
		foreach ($records as $row) {
			if(count($return)>=$limit){break;}
			if($row['prodcat_parent']>0){
				$return[$row['prodcat_id']]=self::getParentTreeStructure($row['prodcat_id'], 0, '', $langId);
			}else{
				$return[$row['prodcat_id']] =$row['prodcat_identifier'];
			}
		}
		return $return;
	}

	public function getNestedArray($langId) {
		$arr = $this->getCategoriesForSelectBox($langId);
		$out = array();
		foreach ($arr as $id => $cat) {
			$tree = str_split($cat['prodcat_code'], 6);
			array_pop($tree);
			$parent = & $out;
			foreach ($tree as $parentId) {
				$parentId = intval($parentId);
				$parent = & $parent['children'][$parentId];
			}
			$parent['children'][$id]['name'] = $cat['prodcat_name'];
		}
		return $out;
	}

	public function makeAssociativeArray($arr, $prefix = ' » ') {
		$out = array();
		$tempArr = array();
		foreach ($arr as $key => $value) {
			$tempArr[] = $key;
			$name = $value['prodcat_name'];
			$code = str_replace('_','',$value['prodcat_code']);
			$hierarchyArr = str_split($code, 6);

			$this_deleted = 0 ;
			foreach($hierarchyArr as $node)
			{
				$node = FatUtility::int($node);
				if(!in_array($node , $tempArr))
				{
					$this_deleted = 1 ;
					break;
				}
			}
			if($this_deleted == 0){
				$level = strlen($code) / 6;
				for ($i = 1; $i < $level; $i++) {
					$name = $prefix . $name;
				}
				$out[$key] = $name;
			}
		}
		return $out;
	}

	public function getCategoriesForSelectBox( $langId, $ignoreCategoryId = 0,$prefCategoryid=array()) {
		/* $srch = new SearchBase(static::DB_TBL); */
		$srch = static::getSearchObject();
		$srch->joinTable(static::DB_LANG_TBL, 'LEFT OUTER JOIN', 'prodcatlang_prodcat_id = prodcat_id
			AND prodcatlang_lang_id = ' . $langId);
		$srch->addCondition(static::DB_TBL_PREFIX.'deleted' , '=' , 0);
		$srch->addMultipleFields(array('prodcat_id',
		'IFNULL(prodcat_name, prodcat_identifier) AS prodcat_name',
		'GETCATCODE(prodcat_id) AS prodcat_code'
		));

		$srch->addOrder('GETCATORDERCODE(prodcat_id)');

		if(count($prefCategoryid)>0){
			foreach($prefCategoryid as $prefCategoryids){
				$srch->addHaving('prodcat_code', 'LIKE', '%' .$prefCategoryids. '%','OR' );				
			}			
		}		
		
		if ($ignoreCategoryId > 0) {
			$srch->addHaving('prodcat_code', 'NOT LIKE', '%' . str_pad($ignoreCategoryId, 6, '0', STR_PAD_LEFT ) . '%');
		}
		/* echo $srch->getQuery(); die; */
		$rs = $srch->getResultSet();

		return FatApp::getDb()->fetchAll($rs, 'prodcat_id');
	}

	public function getProdCatTreeStructure( $parent_id = 0, $langId = 0, $keywords = '', $level = 0, $name_prefix = '', $isActive = true, $isDeleted = true, $isForCsv = false ){
		$langId = FatUtility::int($langId);
		$srch = static::getSearchObject( false, $langId, $isActive );
		if( $langId ){
			$srch->addFld(  'm.prodcat_id, IFNULL(pc_l.prodcat_name, m.prodcat_identifier) as prodcat_name' );
		} else {
			$srch->addFld( 'm.prodcat_id, m.prodcat_identifier as prodcat_name' );
		}

		if( $isDeleted ){
			$srch->addCondition( 'm.prodcat_deleted', '=', 0 );
		}

		if( $isActive ){
			$srch->addCondition( 'm.prodcat_active', '=', applicationConstants::ACTIVE );
		}
		$srch->addCondition( 'm.prodcat_parent', '=', FatUtility::int($parent_id));

		if( !empty($keywords) ){
			$srch->addCondition('prodcat_name','like','%'.$keywords.'%');
		}
		
		$srch->addOrder('m.prodcat_display_order','asc');
		$srch->addOrder('prodcat_name','asc');
		
		$rs = $srch->getResultSet();
		$records = FatApp::getDb()->fetchAllAssoc($rs);

		$return = array();
		$seprator = '';
		if ( $level > 0 ){
			if( $isForCsv ){
				$seprator = '->-> ';
			} else {
				$seprator = '&raquo;&raquo;&nbsp;&nbsp;';
			}
			$seprator = CommonHelper::renderHtml($seprator);
		}
		foreach ($records as $prodcat_id=>$prodcat_identifier) {
				$name=	$name_prefix .$seprator. $prodcat_identifier;
				$return[$prodcat_id] = $name;
				$return += self::getProdCatTreeStructure($prodcat_id, $langId, $keywords, $level+1,$name, $isActive, $isDeleted, $isForCsv );
         }
        return $return;
	}

	public function getProdCatTreeStructureSearch( $parent_id = 0, $langId = 0, $keywords = '', $level = 0, $name_prefix = '', $isActive = true, $isDeleted = true, $isForCsv = false ){
		$langId = FatUtility::int($langId);
		$srch = static::getSearchObject( false, $langId, $isActive );
		if( $langId ){
			$srch->addFld(  'm.prodcat_id, IFNULL(pc_l.prodcat_name, m.prodcat_identifier) as prodcat_name' );
		} else {
			$srch->addFld( 'm.prodcat_id, m.prodcat_identifier as prodcat_name' );
		}

		if( $isDeleted ){
			$srch->addCondition( 'm.prodcat_deleted', '=', 0 );
		}

		if( $isActive ){
			$srch->addCondition( 'm.prodcat_active', '=', applicationConstants::ACTIVE );
		}
		$srch->addCondition( 'm.prodcat_parent', '=', FatUtility::int($parent_id));

		if( !empty($keywords) ){
			//$srch->addCondition('prodcat_name','like','%'.$keywords.'%');
		}
		$srch->addOrder('m.prodcat_display_order','asc');
		$srch->addOrder('prodcat_name','asc');
		$rs = $srch->getResultSet();
		$records = FatApp::getDb()->fetchAllAssoc($rs);

		$return = array();
		$seprator = '';
		if ( $level > 0 ){
			if( $isForCsv ){
				$seprator = '->-> ';
			} else {
				$seprator = '&raquo;&raquo;&nbsp;&nbsp;';
			}
			$seprator = CommonHelper::renderHtml($seprator);
		}
		//print_r($records); die;
		foreach ($records as $prodcat_id=>$prodcat_identifier) {
				$name=	$name_prefix .$seprator. $prodcat_identifier;
				//echo $name."<br>";
				$flag=0;
				if($keywords){
					if(stripos($name_prefix,$keywords)===0 || stripos($prodcat_identifier,$keywords)===0){

					}else{
						$return += self::getProdCatTreeStructureSearch($prodcat_id, $langId, $keywords, $level+1,$name, $isActive, $isDeleted, $isForCsv );
						continue;
					}
				}
				$return[$prodcat_id] = $name;
				$return += self::getProdCatTreeStructureSearch($prodcat_id, $langId, $keywords, $level+1,$name, $isActive, $isDeleted, $isForCsv );
				//print_r($return); die;
        }		
        return $return;
	}
	
	public function getAutoCompleteProdCatTreeStructure( $parent_id = 0, $langId = 0, $keywords = '', $level = 0, $name_prefix = '', $isActive = true, $isDeleted = true, $isForCsv = false ){
		
		 
		$langId = FatUtility::int($langId);
		$srch = static::getSearchObject( false, $langId,false );
		//$srch->addOrder('catOrder','asc');
		//$srch->addOrder('m.prodcat_display_order','asc');
		$srch->addOrder('prodcat_id','asc');
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields(array('prodcat_id','prodcat_active','prodcat_deleted','prodcat_name','GETCATCODE(prodcat_id) as prodcat_code'));
		$rs = $srch->getResultSet();
		$catRecords = FatApp::getDb()->fetchAll($rs,'prodcat_id');
		
		
		$srch = static::getSearchObject( false, $langId, $isActive );
		if( $langId ){
			$srch->addFld(  'm.prodcat_id, IFNULL(pc_l.prodcat_name, m.prodcat_identifier) as prodcat_name' );
		} else {
			$srch->addFld( 'm.prodcat_id, m.prodcat_identifier as prodcat_name' );
		}
		//$srch->addFld('GETCATCODE(prodcat_id) as prodcat_code');
		$srch->addFld('GETCATORDERCODE(prodcat_id) as catOrder');
		if( $isDeleted ){
			$srch->addCondition( 'm.prodcat_deleted', '=', 0 );
		}

		if( $isActive ){
			$srch->addCondition( 'm.prodcat_active', '=', applicationConstants::ACTIVE );
		}
		if($parent_id>0)
		{
			$srch->addCondition( 'm.prodcat_id', '=', FatUtility::int($parent_id));
		}
		
		if( !empty($keywords) ){
			$srch->addCondition('prodcat_name','like','%'.$keywords.'%');
		}
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addOrder('catOrder','asc');
		$srch->addOrder('prodcat_name','asc');
		//echo $srch->getQuery();
		$rs = $srch->getResultSet();
		$return = array();

		$records = FatApp::getDb()->fetchAll($rs);
		foreach ($records as $prodCats) {
			$level = 0;
			$seprator = '';
			$name_prefix='';
			$categoryCode = substr($catRecords[$prodCats['prodcat_id']]['prodcat_code'],0,-1);
			$prodCat = explode("_",$categoryCode);
			foreach($prodCat as $key => $prodcatParent)
			{
				//	var_dump($catRecords[FatUtility::int($prodcatParent)]);
				if( $catRecords[FatUtility::int($prodcatParent)]['prodcat_deleted'] !=applicationConstants::NO  || $catRecords[FatUtility::int($prodcatParent)]['prodcat_active']!=applicationConstants::ACTIVE){
				
				
					break;
				}
				if ( $level > 0 ){
					if( $isForCsv ){
						$seprator = '->-> ';
					} else {
						$seprator = '&raquo;&raquo;&nbsp;&nbsp;';
					}
					$seprator = CommonHelper::renderHtml($seprator);
				}
				$productCatName = $catRecords[FatUtility::int($prodcatParent)]['prodcat_name'];
				
				$name_prefix =	$name_prefix .$seprator. $productCatName;
				
				$return[$prodCats['prodcat_id']] = $name_prefix;
				$level++;
			}
		}
        return $return;
	}
	
	
	public static function getProdCatParentChildWiseArr( $langId = 0, $parentId = 0, $includeChildCat = true, $forSelectBox = false, $orderFeatured = false, $prodCatSrchObj = false, $excludeCategoriesHavingNoProducts = false ){
		$parentId = FatUtility::int($parentId);
		$langId = FatUtility::int($langId);
		if( !$langId ){
			trigger_error("Language not specified", E_USER_ERROR);
		}
		if( is_object($prodCatSrchObj) ){
			$prodCatSrch = clone $prodCatSrchObj;
		}else{
			
			$prodCatSrch = new ProductCategorySearch( $langId );
				$prodCatSrch->setParent( $parentId );
		}
		$prodCatSrch->doNotCalculateRecords();
		$prodCatSrch->doNotLimitRecords();
		
	
		
		if( $excludeCategoriesHavingNoProducts ){
			$prodSrchObj = new ProductSearch( $langId );
			$prodSrchObj->setDefinedCriteria();
			$prodSrchObj->joinProductToCategory();
			$prodSrchObj->doNotCalculateRecords();
			$prodSrchObj->doNotLimitRecords();
			$prodSrchObj->joinSellerSubscription( $langId, true );
			$prodSrchObj->addSubscriptionValidCondition();
			
			//$prodSrchObj->addGroupBy('selprod_id');
			$prodSrchObj->addGroupBy( 'c.prodcat_id' );
			$prodSrchObj->addMultipleFields( array('count(selprod_id) as productCounts', 'c.prodcat_id as qryProducts_prodcat_id') );
			$prodSrchObj->addCondition('selprod_deleted','=',applicationConstants::NO);
			$prodCatSrch->joinTable( '('.$prodSrchObj->getQuery().')', 'LEFT OUTER JOIN', 'qryProducts.qryProducts_prodcat_id = c.prodcat_id', 'qryProducts' );
			$prodCatSrch->addCondition( 'qryProducts.productCounts', '>', 0 );
		}
		
		
		$prodCatSrch->addMultipleFields( array( 'prodcat_id', 'IFNULL(prodcat_name,prodcat_identifier ) as prodcat_name','substr(GETCATCODE(prodcat_id),1,6) AS prodrootcat_code', 'prodcat_content_block','prodcat_active','prodcat_parent','GETCATCODE(prodcat_id) as prodcat_code') );
		
		if( $orderFeatured ){
			$prodCatSrch->addOrder('prodcat_featured');
		}

		$rs = $prodCatSrch->getResultSet();
		
		
		if( $forSelectBox ){
			$categoriesArr = FatApp::getDb()->fetchAllAssoc($rs);
		} else {
			$categoriesArr = FatApp::getDb()->fetchAll($rs);
		}
		if( !$includeChildCat ) { return $categoriesArr; }
		if( $categoriesArr ){
			foreach( $categoriesArr as &$cat ){
				$cat['children'] = self::getProdCatParentChildWiseArr( $langId, $cat['prodcat_id']  );
			}
		}
		return $categoriesArr;
	}

	public static function getRootProdCatArr( $langId ){
		$langId = FatUtility::int($langId);
		if( !$langId ){
			trigger_error(Labels::getLabel('ERR_Language_Not_Specified',$this->commonLangId), E_USER_ERROR);
		}
		return static::getProdCatParentChildWiseArr( $langId, 0, false, true );
	}

	public function canRecordMarkDelete($prodcat_id){
		$srch = static::getSearchObject(false,0,false);
		$srch->addCondition('m.prodcat_deleted', '=', 0);
		$srch->addCondition('m.prodcat_id', '=', $prodcat_id);
		$srch->addFld('m.prodcat_id');
		$rs = $srch->getResultSet();
		$row = FatApp::getDb()->fetch($rs);
		if(!empty($row) && $row['prodcat_id']==$prodcat_id){
			return true;
		}
		return false;
	}

	public function canRecordUpdateStatus($prodcat_id){
		$srch = static::getSearchObject();
		$srch->addCondition('m.prodcat_deleted', '=', 0);
		$srch->addCondition('m.prodcat_id', '=', $prodcat_id);
		$srch->addFld('m.prodcat_id,m.prodcat_active');
		$rs = $srch->getResultSet();
		$row = FatApp::getDb()->fetch($rs);
		if(!empty($row) && $row['prodcat_id']==$prodcat_id){
			return $row;
		}
		return false;
	}
	/*	function getSubCategory(){
		$srch = new SearchBase(static::DB_TBL, 'prodSubCate');
		$srch->addCondition('prodSubCate.prodcat_deleted', '=',0);
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addGroupBy('prodSubCate.prodcat_parent');
		$srch->addMultipleFields(array('prodSubCate.prodcat_parent',"COUNT(prodSubCate.prodcat_id) AS total_sub_cats"));
		return $srch;
	} */

	public static function recordCategoryWeightage($categoryId){
		/* $categoryId =  FatUtility::int($categoryId);
		if(1 > $categoryId){ return false;}
		$obj = new SmartUserActivityBrowsing();
		return $obj->addUpdate($categoryId,SmartUserActivityBrowsing::TYPE_CATEGORY); */
	}

	public static function getDeletedProductCategoryByIdentifier($identifier=''){
		$srch = static::getSearchObject(false,0,false);
		$srch->addCondition('m.prodcat_deleted', '=', applicationConstants::YES);
		$srch->addCondition('m.prodcat_identifier', '=',$identifier);

		$srch->addFld('m.prodcat_id');
		$rs = $srch->getResultSet();

		$row = FatApp::getDb()->fetch($rs);
		if($row){
			return $row['prodcat_id'];
		}else{
			return false;
		}
	}
	/* public static function getCatName($id,$categoryArr) {
			if (!array_key_exists($id, $categoryArr)) {
				$categoryArr[$id] = productCategory::getAttributesByLangId($id, 'prodcat_name');
			}
			return $categoryArr[$id];
	} */
	
	public static function getProductCategoryName($id,$langId) {
		$srch = static::getSearchObject(false,$langId);
		$srch->addCondition('m.prodcat_active', '=', applicationConstants::ACTIVE);
		$srch->addCondition('m.prodcat_deleted', '=', 0);
		$srch->addCondition('m.prodcat_id', '=', $id);
		$srch->addFld('ifNull(prodcat_name,prodcat_identifier) as prodcat_name');
		$rs = $srch->getResultSet();
		$row = FatApp::getDb()->fetch($rs);
		if($row)
			return $row['prodcat_name'];
		else
			return false;
	} 

    public  function getCategoryTreeForSearch( $siteLangId,$categories,&$globalCatTree = array(),$attr = array() ){
		if($categories){
			
			$remainingCatCods =  $categories;
			$catId = $categories[0];
			unset($remainingCatCods[0]);
			$remainingCatCods = array_values($remainingCatCods);
			$catId = FatUtility::int($catId);
			if(!empty($attr) && is_array($attr)){
				$prodCatSrch = new ProductCategorySearch( $siteLangId );
				$prodCatSrch->addMultipleFields( array( 'prodcat_id', 'IFNULL(prodcat_name,prodcat_identifier ) as prodcat_name','substr(GETCATCODE(prodcat_id),1,6) AS prodrootcat_code', 'prodcat_content_block','prodcat_active','prodcat_parent','GETCATCODE(prodcat_id) as prodcat_code') );
				$prodCatSrch->addCondition('prodcat_id','=',$catId);
				$rs = $prodCatSrch->getResultSet();
				$rows = FatApp::getDb()->fetch($rs);
				$globalCatTree[$catId] = $rows;
			}else{
				$globalCatTree[$catId]['prodcat_name'] = productCategory::getAttributesByLangId($siteLangId,$catId,'prodcat_name');
				$globalCatTree[$catId]['prodcat_id'] = $catId;
			}
			//$globalCatTree[$catId]['prodcat_id']['children'] = '';
			if(count($remainingCatCods)>0)
			self::getCategoryTreeForSearch($siteLangId,$remainingCatCods,$globalCatTree[$catId]['children'],$attr );

		}


	}

	public  function getCategoryTreeArr($siteLangId,$categoriesDataArr, $attr = array()){

		foreach($categoriesDataArr as $categoriesData){
			
			$categoryCode = substr($categoriesData['prodcat_code'],0,-1);
			$prodCats = explode("_",$categoryCode);
			$remaingCategories = $prodCats;
			unset($remaingCategories[0]);
			$remaingCategories = array_values($remaingCategories);

			$parentId = FatUtility::int($prodCats[0]);
			if(!array_key_exists($parentId,$this->categoryTreeArr)){

				$this->categoryTreeArr [$parentId] = array();
			}
			if(!empty($attr) && is_array($attr)){
				$prodCatSrch = new ProductCategorySearch( $siteLangId );
				$prodCatSrch->addMultipleFields( $attr );
				$prodCatSrch->addCondition('prodcat_id','=',FatUtility::int($prodCats[0]));
				$rs = $prodCatSrch->getResultSet();
				$rows = FatApp::getDb()->fetch($rs);
				$this->categoryTreeArr [$parentId] = $rows;
			}else{
				$this->categoryTreeArr [$parentId]['prodcat_name'] = productCategory::getAttributesByLangId($siteLangId,FatUtility::int($prodCats[0]),'prodcat_name');
				$this->categoryTreeArr [$parentId]['prodcat_id'] =  FatUtility::int($prodCats[0]); 
			}

			if(!isset($this->categoryTreeArr [$parentId]['children'])){
				$this->categoryTreeArr [$parentId]['children'] = array();
			}
			productCategory::getCategoryTreeForSearch($siteLangId,$remaingCategories,$this->categoryTreeArr[$parentId]['children']);

		}

		
		return $this->categoryTreeArr ;
	}
	
	public  function getProdRootCategoriesWithKeyword($langId = 0, $keywords = '', $returnWithChildArr = false ,$prodcatCode = false){
		$srch = static::getSearchObject(false,$langId);
		$srch->addFld('m.prodcat_id,ifnull(pc_l.prodcat_name,m.prodcat_identifier) as prodcat_name,m.prodcat_parent,substr(GETCATCODE(prodcat_id),1,6) AS prodrootcat_code');
		$srch->addCondition('m.prodcat_deleted', '=', applicationConstants::NO);
		$srch->addCondition('m.prodcat_active', '=', applicationConstants::ACTIVE);
		if (!empty($keywords)){
			$cnd = $srch->addCondition('m.prodcat_identifier','like','%'.$keywords.'%');
			$cnd->attachCondition('pc_l.prodcat_name','like','%'.$keywords.'%');
		}
		$srch->addOrder('m.prodcat_parent','asc');
		$srch->addOrder('m.prodcat_display_order','asc');
		$srch->addOrder('m.prodcat_identifier','asc');
		if($returnWithChildArr == false){
			$srch->addFld('count(prodcat_id) as totalRecord');
			$srch->addGroupBy('prodrootcat_code');
		}
		
		if($prodcatCode){
			$srch->addHaving('prodrootcat_code','=',$prodcatCode);
		}
		
		$rs = $srch->getResultSet();		
		$records = FatApp::getDb()->fetchAll($rs);
		
		$return = array();
		if($returnWithChildArr){
			foreach ($records as $row) {
				if($row['prodcat_parent']>0){
					$return[$row['prodrootcat_code']][$row['prodcat_id']]['structure'] = self::getParentTreeStructure($row['prodcat_id'],0,'',$langId);
					$return[$row['prodrootcat_code']][$row['prodcat_id']]['prodcat_name'] = $row['prodcat_name'];					
				}
			}	
		}else{
			$return = $records;
		}
		return $return;		
	}
	
	public function categoriesHaveProducts($siteLangId){

		$prodSrchObj = new ProductSearch( $siteLangId );
		$prodSrchObj->setDefinedCriteria();
		$prodSrchObj->joinProductToCategory();
		$prodSrchObj->doNotCalculateRecords();
		$prodSrchObj->doNotLimitRecords();
		$prodSrchObj->addGroupBy( 'prodcat_id' );
		$prodSrchObj->addMultipleFields( array('substr(GETCATCODE(prodcat_id),1,6) AS prodrootcat_code','count(selprod_id) as productCounts', 'prodcat_id', 'IFNULL(prodcat_name, prodcat_identifier) as prodcat_name', 'prodcat_parent'));
		$rs = $prodSrchObj->getResultSet();
		$productRows = FatApp::getDb()->fetchAll($rs);
		/* die(CommonHelper::printArray($productRows)); */
		$categoriesMainRootArr = array();
		if($productRows){
			
			$categoriesMainRootArr = array_unique(array_column($productRows,'prodcat_id'));
			array_flip($categoriesMainRootArr);
		}
		return $categoriesMainRootArr;
	}
}
