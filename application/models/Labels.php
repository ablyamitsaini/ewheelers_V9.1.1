<?php
class Labels extends MyAppModel{
	const DB_TBL = 'tbl_language_labels';
	const DB_TBL_PREFIX = 'label_';
	
	public function __construct($labelId = 0) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $labelId);
	}
	
	public static function getInstance(){		
		if( self::$_instance === NULL ) {
			self::$_instance = new self();
		}
		return self::$_instance;
    }
	
	public static function getSearchObject($langId = 0) {
		$langId =  FatUtility::int( $langId );
		
		$srch = new SearchBase( static::DB_TBL, 'lbl');	
		$srch->addOrder('lbl.' . static::DB_TBL_PREFIX . 'id', 'DESC');
		$srch->addMultipleFields ( array (
				'lbl.' . static::DB_TBL_PREFIX . 'id',
				'lbl.' . static::DB_TBL_PREFIX . 'lang_id',
				'lbl.' . static::DB_TBL_PREFIX . 'key',
				'lbl.' . static::DB_TBL_PREFIX . 'caption',
		) );

		if($langId > 0){
			$srch->addCondition('lbl.' . static::DB_TBL_PREFIX . 'lang_id','=',$langId);
		}		
		return $srch;		
	}
	
	public static function getLabel($lblKey = '',$langId){
		if(empty($lblKey)){
			return;
		}
		
		if ( preg_match('/\s/',$lblKey) ){
			return $lblKey;
		}
		
		$langId = FatUtility::int($langId);
		if($langId == 0){
			return;
		}
		
		global $lang_array;
		
		$key_original = $lblKey;
		$key = strtoupper($lblKey);
		
		if (isset($lang_array[$lblKey][$langId])) { 
			if($lang_array[$lblKey][$langId]!=''){
				return $lang_array[$lblKey][$langId];
			}else{
				$arr = explode(' ', ucwords(str_replace('_', ' ', strtolower($lblKey))));
				array_shift($arr);				
				return $str = implode(' ', $arr);
			}
		}
		 
		$db = FatApp::getDb();
		
		$srch = static::getSearchObject($langId);
		
		$srch->addCondition(static::DB_TBL_PREFIX . 'key', '=', $key);
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		
		if($lbl = $db->fetch( $srch->getResultSet())){			
			$lang_array[$lblKey][$langId] = $lbl[static::DB_TBL_PREFIX . 'caption'];
			if(isset($lbl[static::DB_TBL_PREFIX . 'caption']) && $lbl[static::DB_TBL_PREFIX . 'caption']!=''){
				return $lbl[static::DB_TBL_PREFIX . 'caption'];
			}else{
				$arr = explode(' ', ucwords(str_replace('_', ' ', strtolower($lblKey))));
				array_shift($arr);				
				return $str = implode(' ', $arr);
			}
		}else {
			// $arr =  explode('_', strtolower($key_original));
			$arr = explode(' ', ucwords(str_replace('_', ' ', strtolower($key_original))));
			array_shift($arr);
			
			$str = implode(' ', $arr);
			$assignValues = array(
							static::DB_TBL_PREFIX . 'key' => $lblKey, 
							static::DB_TBL_PREFIX . 'caption' => $str,
							static::DB_TBL_PREFIX . 'lang_id' => $langId
							);
							
			FatApp::getDB()->insertFromArray(static::DB_TBL,$assignValues,false,array(),$assignValues);			
		}
		return $str;
	}
	
	public function addUpdateData($data = array()){
		$assignValues = array(
						static::DB_TBL_PREFIX . 'key' => $data['label_key'], 
						static::DB_TBL_PREFIX . 'caption' => $data['label_caption'],
						static::DB_TBL_PREFIX . 'lang_id' => $data['label_lang_id']
						);
						
		if(!FatApp::getDB()->insertFromArray(static::DB_TBL,$assignValues,false,array(),$assignValues)){
			return false;
		}		
		return true;
	}
}	