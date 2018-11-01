<?php
class BrandRequest extends MyAppModel{
	const DB_TBL = 'tbl_seller_brand_requests';
	const DB_LANG_TBL = 'tbl_seller_brand_requests_lang';
	const DB_TBL_PREFIX = 'sbrandreq_';	
	const DB_TBL_LANG_PREFIX = 'sbrandreqlang_';	
	const BRAND_REQUEST_PENDING = 0;
	const BRAND_REQUEST_APPROVED = 1;
	const BRAND_REQUEST_CANCELLED = 2;
	private $db;

	public function __construct($id = 0) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id );
		$this->db = FatApp::getDb();
	}
	
	public static function getSearchObject($langId = 0, $isDeleted = true ) {
		$srch = new SearchBase(static::DB_TBL, 'br');
		
		if($isDeleted==true){
			$srch->addCondition('br.'.static::DB_TBL_PREFIX.'deleted', '=', 0);
		}
		
		if($langId > 0){
			$srch->joinTable(static::DB_LANG_TBL,'LEFT OUTER JOIN',
			'br_l.'.static::DB_TBL_LANG_PREFIX.'sbrandreq_id = br.'.static::tblFld('id').' and 
			br_l.'.static::DB_TBL_LANG_PREFIX.'lang_id = '.$langId,'br_l');
		}
		
		$srch->addOrder('br.'.static::DB_TBL_PREFIX.'approved', 'ASC');
		return $srch;
	}
	
	public static function getBrandReqStatusArr($langId){
		$langId = FatUtility::int($langId);
		if($langId == 0){ 
			trigger_error(Labels::getLabel('ERR_Language_Id_not_specified.',CommonHelper::getLangId()), E_USER_ERROR);				
		}
		$arr=array(
			static::BRAND_REQUEST_PENDING => Labels::getLabel('LBL_Pending',$langId),
			static::BRAND_REQUEST_APPROVED => Labels::getLabel('LBL_Approved',$langId),
			static::BRAND_REQUEST_CANCELLED => Labels::getLabel('LBL_Cancelled',$langId)	
		);
		return $arr;
	}
	
	public function updateBrandRequest($data = array()){
		if(empty($data)){ 
			$this->error = Labels::getLabel('ERR_INVALID_REQUEST',CommonHelper::getLangId());	
			return false;
		}
		
		$srequest_id = FatUtility::int($data['request_id']);
		
		$assignValues = array(
			'sbrandreq_status'=>$data['status'],
			'sbrandreq_comments'=>isset($data['comments'])?$data['comments']:'',
		);
		if (!FatApp::getDb()->updateFromArray(static::DB_TBL, $assignValues,
			array('smt' => 'usuprequest_id = ? ', 'vals' => array((int)$srequest_id)))){
			$this->error = $this->db->getError();
			return false;
		}
		return true;
	}
	
	public function addBrand($sbrandReqId = 0){
		
		$brequestData = BrandRequest::getAttributesById($sbrandReqId,array('sbrandreq_seller_id','sbrandreq_identifier'));
		$brandDataToSave = array(
			'brand_identifier'=>$brequestData['sbrandreq_identifier'],
			'sbrandreq_seller_id'=>$brequestData['sbrandreq_seller_id'],
		);
		
		
	}
}