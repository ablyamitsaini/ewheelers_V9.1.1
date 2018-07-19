<?php
class UrlRewrite extends MyAppModel{
	const DB_TBL = 'tbl_url_rewrite';	
	const DB_TBL_PREFIX = 'urlrewrite_';	
	private $db;
	
	public function __construct($id = 0) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id );
		$this->db = FatApp::getDb();
	}
	
	public static function getSearchObject() {
		$srch = new SearchBase(static::DB_TBL, 'ur');		
		return $srch;
	}
	
	public static function saveData($originalUrl,$customUrl){
	
	}

	public static function getDataByCustomUrl($customUrl,$excludeThisOriginalUrl = false){
		$urlSrch = static::getSearchObject();
		$urlSrch->doNotCalculateRecords();
		$urlSrch->setPageSize(1);
		$urlSrch->addMultipleFields(array('urlrewrite_id','urlrewrite_original','urlrewrite_custom'));		
		$urlSrch->addCondition( 'urlrewrite_custom', '=', $customUrl );
		if($excludeThisOriginalUrl){
			$urlSrch->addCondition( 'urlrewrite_original', '!=', $excludeThisOriginalUrl );
		}
		$rs = $urlSrch->getResultSet();
		$urlRow = FatApp::getDb()->fetch($rs);
		if($urlRow == false) { 
			return array();
		}   
		
		return $urlRow;
	}
	public static function getDataByOriginalUrl($originalUrl,$excludeThisCustomUrl = false){
		$urlSrch = static::getSearchObject();
		$urlSrch->doNotCalculateRecords();
		$urlSrch->setPageSize(1);
		$urlSrch->addMultipleFields(array('urlrewrite_id','urlrewrite_original','urlrewrite_custom'));		
		$urlSrch->addCondition( 'urlrewrite_original', '=', $originalUrl );
		if($excludeThisCustomUrl){
			$urlSrch->addCondition( 'urlrewrite_custom', '!=', $excludeThisCustomUrl );
		}
		$rs = $urlSrch->getResultSet();
		$urlRow = FatApp::getDb()->fetch($rs);
		if($urlRow == false) { 
			return array();
		}   
		
		return $urlRow;
	}
	
	public static function getValidSeoUrl($urlKeyword,$excludeThisOriginalUrl = false){		
		$customUrl = CommonHelper::seoUrl($urlKeyword);
		
		$res = static::getDataByCustomUrl($customUrl,$excludeThisOriginalUrl);
		if(empty($res)){
			return $customUrl;
		}
		
		$i = 1; 				
		$slug = $customUrl;
		while(static::getDataByCustomUrl($slug,$excludeThisOriginalUrl)){                
			$slug = $customUrl . "-" . $i++;     			
		}
		
		return $slug;
	}		
}	