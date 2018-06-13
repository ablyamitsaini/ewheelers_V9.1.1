<?php
class Notifications extends MyAppModel{
	const DB_TBL = 'tbl_user_notifications';
	const DB_TBL_PREFIX = 'unotification_';
	
	
	public function __construct($unotificationId = 0) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $unotificationId );				
	}
	
	public static function getSearchObject() {
		$srch = new SearchBase(static::DB_TBL, 'unt');
		return $srch;
	}
	
	public function addNotification($data){
		$userId = FatUtility::int($data['unotification_user_id']);
		if($userId < 1){
			trigger_error(Labels::getLabel('MSG_INVALID_REQUEST',$this->commonLangId),E_USER_ERROR) ;
			return false;
		}
		$data['unotification_date'] = date('Y-m-d H:i:s');
		$this->assignValues($data);
		if (!$this->save()) {
			return false;		
		}
		
		$uObj = new User($userId);
		$fcmDeviceIds = $uObj->getPushNotificationTokens();
		if(empty($fcmDeviceIds)){
			return $this->getMainTableRecordId();
		}
		
		$google_push_notification_api_key = FatApp::getConfig("CONF_GOOGLE_PUSH_NOTIFICATION_API_KEY",FatUtility::VAR_STRING,'');
		if(trim($google_push_notification_api_key) == ''){
			return $this->getMainTableRecordId();
		}
		
		require_once(CONF_INSTALLATION_PATH . 'library/APIs/notifications/pusher.php');
		foreach($fcmDeviceIds as $pushNotificationApiToken){
			$pusher = new Pusher($google_push_notification_api_key);
			$pusher->notify($pushNotificationApiToken, array('message'=>$data['unotification_body'],'type'=>$data['unotification_type']));
		}
		/* 
		$userInfo = $uObj->getUserInfo(array('user_push_notification_api_token'),true,true);
		$user_push_notification_api_token = $userInfo['user_push_notification_api_token']; 
		
		if (!empty($user_push_notification_api_token) && !empty($google_push_notification_api_key)){
			require_once(CONF_INSTALLATION_PATH . 'library/APIs/notifications/pusher.php');
			$pusher = new Pusher($google_push_notification_api_key);
			$pusher->notify($user_push_notification_api_token, array('message'=>$data['unotification_body'],'type'=>$data['unotification_type']));
		}  */
		
		return $this->getMainTableRecordId();
	}
	
	function readUserNotification($notificationId,$userId){
		
		if (!FatApp::getDb()->updateFromArray(static::DB_TBL, array(static::DB_TBL_PREFIX.'is_read'=>1), array('smt' => static::DB_TBL_PREFIX . 'id = ? AND '.static::DB_TBL_PREFIX . 'user_id = ?', 'vals' => array((int)$notificationId,(int)$userId)))){
			$this->error = FatApp::getDb()->getError();
			echo $this->error; die;
		}
		return true;
    }
	
	function getUnreadNotificationCount($userId){
		$srch = new SearchBase( static::DB_TBL, 'unt' );
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$cnd = $srch->addCondition('unt.unotification_user_id','=',$userId);
		$cnd = $srch->addCondition('unt.unotification_is_read','=',0);
		$srch->addMultipleFields(array("count(unt.unotification_id) as UnReadNotificationCount"));
		$rs = $srch->getResultSet();
		if(!$rs){
			return 0;
		}
		$res = FatApp::getDb()->fetch($rs);
		return $res['UnReadNotificationCount'];
	}
	
}