<?php
class UserRequest extends MyAppModel {
	const ADMIN_SESSION_ELEMENT_NAME = 'yokartAdmin';
	
	const DB_TBL = 'tbl_user_requests_history';
	const DB_TBL_PREFIX = 'ureq_';

	const USER_REQUEST_TYPE_TRUNCATE = 1;
	const USER_REQUEST_TYPE_DATA = 2;
	
	const USER_REQUEST_STATUS_PENDING = 0;
	const USER_REQUEST_STATUS_COMPLETE = 1;

	
	public function __construct($userReqId = 0) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $userReqId );		
		$this->objMainTableRecord->setSensitiveFields ( array (
			/* 'ureq_date' */
		) );
	}
	
	static function getUserRequestTypesArr( $langId ){
		$langId = FatUtility::int($langId);
		if($langId < 1){
			$langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
		}
		return array(
			static::USER_REQUEST_TYPE_TRUNCATE	=>	Labels::getLabel('LBL_Truncate_Request', $langId),	
			static::USER_REQUEST_TYPE_DATA	=>	Labels::getLabel('LBL_Data_Request', $langId)
		);
	}
	
	static function getUserRequestStatusesArr( $langId ){
		$langId = FatUtility::int($langId);
		if($langId < 1){
			$langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
		}
		return array(
			static::USER_REQUEST_STATUS_PENDING	=>	Labels::getLabel('LBL_Pending', $langId),	
			static::USER_REQUEST_STATUS_COMPLETE =>	Labels::getLabel('LBL_Complete', $langId)
		);
	}
	
	public function updateRequestStatus($reqId, $status){
		$reqId = FatUtility::int($reqId);
		$status = FatUtility::int($status);
		
		$assignValues = array(
			'ureq_status'=>$status,
			'ureq_approved_date'=>date('Y-m-d H:i:s'),
		);
		if (!FatApp::getDb()->updateFromArray(static::DB_TBL, $assignValues, array('smt' => static::DB_TBL_PREFIX . 'id = ? ', 'vals' => array($reqId)))){
			$this->error = FatApp::getDb()->getError();
			echo $this->error; die;
		}
		return true;
	}
	
	public function deleteRequest($reqId){
		$reqId = FatUtility::int($reqId);
		
		$assignValues = array(
			'ureq_deleted'=>applicationConstants::YES,
		);
		if (!FatApp::getDb()->updateFromArray(static::DB_TBL, $assignValues, array('smt' => static::DB_TBL_PREFIX . 'id = ? ', 'vals' => array($reqId)))){
			$this->error = FatApp::getDb()->getError();
			echo $this->error; die;
		}
		return true;
	}
	
	
}