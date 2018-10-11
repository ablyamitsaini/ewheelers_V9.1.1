<?php
class LoggedUserController extends MyAppController {
	public function __construct($action) {
		parent::__construct($action);
		
		UserAuthentication::checkLogin();
		
		$userObj = new User(UserAuthentication::getLoggedUserId());
		$userInfo = $userObj->getUserInfo(array(),false,false);	
		
		//var_dump($userInfo); exit;
		if(false == $userInfo || (!UserAuthentication::isGuestUserLogged() && $userInfo['credential_active'] != applicationConstants::ACTIVE )){			
			if ( FatUtility::isAjaxCall() ) {
				// FatUtility::dieWithError(Labels::getLabel('MSG_Session_seems_to_be_expired', CommonHelper::getLangId()));
				Message::addErrorMessage(Labels::getLabel('MSG_Session_seems_to_be_expired', CommonHelper::getLangId()));
				FatUtility::dieWithError(Message::getHtml());
			}
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'logout'));
		}
		
		$userPreferedDashboardType = ($userInfo['user_preferred_dashboard'])?$userInfo['user_preferred_dashboard']:$userInfo['user_registered_initially_for'];
		
		switch($userPreferedDashboardType){
			case User::USER_TYPE_BUYER:
				$_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'B';
			break;
			case User::USER_TYPE_SELLER:
				$_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'S';
			break;
			case User::USER_TYPE_AFFILIATE:
				$_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'AFFILIATE';
			break;
			case User::USER_TYPE_ADVERTISER:
				$_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'Ad';
			break;
		}
		
		if((!UserAuthentication::isGuestUserLogged() && $userInfo['credential_verified'] != 1 ) && !($_SESSION[USER::ADMIN_SESSION_ELEMENT_NAME] && $_SESSION[USER::ADMIN_SESSION_ELEMENT_NAME]>0)){
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'logout'));
		}
		
		if(UserAuthentication::getLoggedUserId() < 1){			
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'logout'));
		}
		
		if(empty($userInfo['credential_email'])){
			Message::addErrorMessage(Labels::getLabel('MSG_Please_Configure_Your_Email',$this->siteLangId));
			FatApp::redirectUser(CommonHelper::generateUrl('GuestUser', 'configureEmail'));
		}
		
		$this->initCommonValues();		
	}
	
	private function initCommonValues(){		
		
	}
	
	protected function getOrderCancellationRequestsSearchForm( $langId ){
		$frm = new Form('frmOrderCancellationRequest');
		$frm->addTextBox( '', 'op_invoice_number' );
		$frm->addSelectBox('' ,'ocrequest_status', array( '-1' => Labels::getLabel('LBL_Status_Does_Not_Matter', $langId)  ) + OrderCancelRequest::getRequestStatusArr( $langId ), '', array(),'' );
		$frm->addDateField( '', 'ocrequest_date_from', '',array('readonly'=>'readonly'));
		$frm->addDateField( '', 'ocrequest_date_to', '',array('readonly'=>'readonly'));
		
		$fldSubmit = $frm->addSubmitButton( '', 'btn_submit', Labels::getLabel('LBL_Search',$langId) );
		$fldCancel = $frm->addButton( "", "btn_clear", Labels::getLabel("LBL_Clear", $langId), array('onclick'=>'clearOrderCancelRequestSearch();') );
		$frm->addHiddenField('','page');
		return $frm;
	}
	
	protected function getOrderReturnRequestsSearchForm( $langId ){
		$frm = new Form('frmOrderReturnRequest');
		$frm->addTextBox('', 'keyword');
		$frm->addSelectBox('','orrequest_status', array( '-1' => Labels::getLabel('LBL_Status_Does_Not_Matter', $langId) ) + OrderReturnRequest::getRequestStatusArr( $langId ), '', array(), '' );
		$returnRquestArray = OrderReturnRequest::getRequestTypeArr( $langId );
		if(count($returnRquestArray) > applicationConstants::YES)
		{
			$frm->addSelectBox('','orrequest_type', array( '-1' => Labels::getLabel('LBL_Request_Type_Does_Not_Matter', $langId) ) + $returnRquestArray, '', array(), '' );
		}
		else
		{
			$frm->addHiddenField('','orrequest_type','-1');
		}
		$frm->addDateField('', 'orrequest_date_from','',array('readonly'=>'readonly'));
		$frm->addDateField('', 'orrequest_date_to','',array('readonly'=>'readonly'));
		$fldSubmit = $frm->addSubmitButton( '', 'btn_submit', Labels::getLabel('LBL_Search',$langId) );
		$fldCancel = $frm->addButton( "", "btn_clear", Labels::getLabel("LBL_Clear", $langId), array('onclick'=>'clearOrderReturnRequestSearch();') );
		$frm->addHiddenField('','page');
		return $frm;
	}
	
	protected function getOrderReturnRequestMessageSearchForm( $langId ){
		$frm = new Form('frmOrderReturnRequestMsgsSrch');
		$frm->addHiddenField('','page');
		$frm->addHiddenField( '', 'orrequest_id' );
		return $frm;
	}
	
	protected function getOrderReturnRequestMessageForm( $langId ){
		$frm = new Form('frmOrderReturnRequestMessge');
		$frm->setRequiredStarPosition('');
		$fld = $frm->addTextArea('','orrmsg_msg');
		$fld->requirements()->setRequired();
		$fld->requirements()->setCustomErrorMessage( Labels::getLabel('MSG_Message_is_mandatory', $langId) );
		$frm->addHiddenField('','orrmsg_orrequest_id');
		$frm->addSubmitButton( '', 'btn_submit', Labels::getLabel('LBL_Submit',$langId) );
		return $frm;
	}
}