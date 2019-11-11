<?php
class TestDriveController extends LoggedUserController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function form($selprod_id)
    {
        $frm = $this->getForm($this->siteLangId);
        $frm->fill(array('selprod_id' => $selprod_id));
        $termsAndConditionsLinkHref = '';
        $cPageSrch = ContentPage::getSearchObject($this->siteLangId);
        $cPageSrch->addCondition('cpage_id', '=', FatApp::getConfig('CONF_TEST_DRIVE_TERMS_AND_CONDITIONS_PAGE', FatUtility::VAR_INT, 0));
        $cpage = FatApp::getDb()->fetch($cPageSrch->getResultSet());
        if (!empty($cpage) && is_array($cpage)) {
            $termsAndConditionsLinkHref = CommonHelper::generateUrl('Cms', 'view', array($cpage['cpage_id']));
        }

        $this->set('termsAndConditionsLinkHref', $termsAndConditionsLinkHref);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('frmTestDrive', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
	
        if (false == $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $userId = UserAuthentication::getLoggedUserId();
        $selprod_id = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);

        $obj = new TestDrive();
        $canRequest = $obj->canRequest($userId, $selprod_id, $this->siteLangId);

        if (false == $canRequest) {
            Message::addErrorMessage($obj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
		
		$date_timestamp = strtotime($post['ptdr_date']);
		$date = date('Y-m-d H:i:s', $date_timestamp);

        $data = array(
                        'ptdr_selprod_id' => $selprod_id,
                        'ptdr_user_id' => $userId,
                        'ptdr_location' => $post['ptdr_location'],
                        'ptdr_date' => $date,
                        'ptdr_contact' => $post['ptdr_contact'],
                        'ptdr_request_added_on' => date('Y-m-d H:i:s')
                    );
        $obj->setFldValue('ptdr_status', $obj::STATUS_PENDING, false);
        $obj->assignValues($data);
        if (!$obj->save()) {
            FatUtility::dieJsonError($obj->getError());
        }

        $testDriveId = $obj->getMainTableRecordId();
        if (!$obj->sendTestDriveRequestEmail($testDriveId, $this->siteLangId)) {
            FatUtility::dieJsonError($obj->getError());
        }
		
		if (!$obj->sendTestDriveRequestDetailEmailBuyer($testDriveId, $this->siteLangId)) {
            FatUtility::dieJsonError($obj->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_Request_Added_successful', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function sellerRequests()
    {
        $frm = TestDrive::getSearchForm($this->siteLangId);
        $this->set("frm", $frm);
        $this->_template->render(true, true, 'seller/test-drive-requests.php');
    }

    public function buyerRequests()
    {
        $frm = TestDrive::getSearchForm($this->siteLangId);
        $this->set("frm", $frm);
        $this->_template->render(true, true, 'buyer/test-drive-requests.php');
    }

    public function searchRequests()
    {
        $frm = TestDrive::getSearchForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false == $post) {
            FatUtility::dieJsonError($frm->getValidationErrors());
        }

        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);

        $pagesize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);

        $srch = TestDrive::getSearchObject();
        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('product_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('product_identifier', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('attrgrp_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('product_model', 'like', '%' . $keyword . '%');
        }

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        if ($status > -1) {
            $srch->addCondition('td.ptdr_status', '=', $status);
        }
        $userId = UserAuthentication::getLoggedUserId();
        if ((User::isBuyer() ||  User::isSigningUpBuyer()) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='B') {
            $srch->addCondition('ptdr_user_id', '=', $userId);
            $this->set("user_dasboard", 'buyer');
        }
        if ((User::isSeller() || User::isSigningUpForSeller())&& $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='S') {
            $srch->addCondition('selprod_user_id', '=', $userId);
            $this->set("user_dasboard", 'seller');
        }

        $srch->addOrder("td.ptdr_id", "DESC");
        $srch->addMultipleFields(TestDrive::addSearchFields());
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetchAll($rs);
        $this->set("arr_listing", $arr_listing);
        $this->set('pageCount', $srch->pages());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('siteLangId', $this->siteLangId);

        unset($post['page']);
        $frm->fill($post);
        $this->set("frmTestDriveRequest", $frm);
        $this->_template->render(false, false);
    }

    public function requestInfo($requestId)
    {
        $frmTestDriveStatus = $this->getStatusFrm();
        $srch = TestDrive::getSearchObject();
        $srch->addCondition('td.ptdr_id', '=', $requestId);
        $srch->addMultipleFields(TestDrive::addSearchFields());

        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetch($rs);
        if ((User::isBuyer() ||  User::isSigningUpBuyer()) && $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='B') {
            $link = 'buyer/test-drive-request-info.php';
        }
        if ((User::isSeller() || User::isSigningUpForSeller())&& $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] =='S') {
            $fillFormData = array('ptdr_status' => $arr_listing['ptdr_status'] , 'ptdr_comments' => $arr_listing['ptdr_comments'],'ptdr_id' => $arr_listing['ptdr_id'] );
            $frmTestDriveStatus->fill($fillFormData);
            $this->set("frmTestDriveStatus", $frmTestDriveStatus);
            $link = 'seller/test-drive-request-info.php';
        }

        $this->set("siteLangId", $this->siteLangId);
        $this->set("requestData", $arr_listing);
        $this->_template->render(false, false, $link);
    }

    public function cancel()
    {
        $requestId = FatApp::getPostedData('requestId', FatUtility::VAR_INT, 0);

        if (empty($requestId)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
        }

        $userId = UserAuthentication::getLoggedUserId();
        $obj = new TestDrive($requestId);
        if (!$obj->canChangeStatus($userId, TestDrive::STATUS_CANCELLED)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
        }

        $obj->setFldValue('ptdr_status', TestDrive::STATUS_CANCELLED, false);
        if (!$obj->save()) {
            FatUtility::dieJsonError($obj->getError());
        }

        if (!$obj->sendStatusChangedEmailUpdateSeller($requestId, TestDrive::STATUS_CANCELLED, $this->siteLangId)) {
            FatUtility::dieJsonError($obj->getError());
        }
		
		if (!$obj->sendStatusChangedEmailUpdateBuyer($requestId, TestDrive::STATUS_CANCELLED, $this->siteLangId)) {
            FatUtility::dieJsonError($obj->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_Request_has_been_cancelled_successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
	
	public function confirm($requestId)
    {
		$frmTestDriveStatus = $this->getFeedbackFrm();
		$fillFormData = array('ptdr_id' => $requestId,'ptdr_status' => TestDrive::STATUS_CONFIRMED);
        $frmTestDriveStatus->fill($fillFormData);
		$this->set("frmTestDriveStatus", $frmTestDriveStatus);
		$this->set("siteLangId", $this->siteLangId);
        $this->_template->render(false, false,'buyer/test-drive-confirm.php');
    }

    public function changeRequestStatus()
    {
        $post = FatApp::getPostedData();
        $reqId = $post['ptdr_id'];
        $status = $post['ptdr_status'];

        $obj = new TestDrive($reqId);
        $canChangeStatus = $obj->canChangeStatus(UserAuthentication::getLoggedUserId(), $post['ptdr_status']);

        if (!$canChangeStatus) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
        }
		
		if($status == TestDrive::STATUS_CONFIRMED){
			$data = array('ptdr_id' => $post['ptdr_id'],
                      'ptdr_feedback' => $post['ptdr_feedback'],
                      );
		}elseif($status == TestDrive::STATUS_DELIVERED){
			$data = array('ptdr_id' => $post['ptdr_id'],                    
                      );
		}else{
			$data = array('ptdr_id' => $post['ptdr_id'],
                      'ptdr_comments' => $post['ptdr_comments'],
                      );
		}

        $obj->setFldValue('ptdr_status', $post['ptdr_status'], false);
        $obj->assignValues($data);
        if (!$obj->save()) {
            FatUtility::dieJsonError($obj->getError());
        }
		
		//send notification to admin
		if($status == TestDrive::STATUS_DELIVERED){
			$notificationData = array(
			'notification_record_type' => Notification::TEST_DRIVE_COMPLETION_REQUEST,
			'notification_record_id' => $reqId,
			'notification_user_id' => UserAuthentication::getLoggedUserId(),
			'notification_label_key' => Notification::TEST_DRIVE_COMPLETION_REQUEST,
			'notification_added_on' => date('Y-m-d H:i:s'),
			);
	
			if (!Notification::saveNotifications($notificationData)) {
				Message::addErrorMessage(Labels::getLabel("MSG_NOTIFICATION_COULD_NOT_BE_SENT", $this->siteLangId));
				FatUtility::dieJsonError(Message::getHtml());
			}
		}
		
		if($status == TestDrive::STATUS_CONFIRMED){
			if (!$obj->sendStatusChangedEmailUpdateSeller($reqId, $status, $this->siteLangId)) {
				FatUtility::dieJsonError($obj->getError());
			}
		}else{
			if (!$obj->sendStatusChangedEmailUpdateBuyer($reqId, $status, $this->siteLangId)) {
				FatUtility::dieJsonError($obj->getError());
			}
		}
		

        $this->set('msg', Labels::getLabel('MSG_Request_Status_Changed_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm()
    {
        $frm = new Form('frmTestDrive', array('id'=>'frmTestDrive'));
        $frm->addHiddenField('', 'selprod_id');
        $frm->addRequiredField(Labels::getLabel('LBL_Location', $this->siteLangId), 'ptdr_location');
        $phnFld = $frm->addRequiredField(Labels::getLabel('LBL_Phone', $this->siteLangId), 'ptdr_contact', '');
        $phnFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
        $phnFld->requirements()->setCustomErrorMessage(Labels::getLabel('LBL_Please_enter_valid_format.', $this->siteLangId));
        $date = $frm->addRequiredField(Labels::getLabel('LBL_Date_Time', $this->siteLangId), 'ptdr_date', '');
        $fld = $frm->addCheckBox(Labels::getLabel('', $this->siteLangId), 'terms', 1, array(), false, 0);
        $fld->requirements()->setRequired();
        $fld->requirements()->setCustomErrorMessage(Labels::getLabel('LBL_Terms_Condition_is_mandatory.', $this->siteLangId));
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('Lbl_Confirm_Request', $this->siteLangId));
        return $frm;
    }
	
	public function report(){
		
		if (!User::canAccessSupplierDashboard()) {
            Message::addErrorMessage(Labels::getLabel("LBL_Invalid_Access!", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
		
		$frmSrch = $this->getReportSearchForm();
        $this->set('frmSrch', $frmSrch);
        $this->set('siteLangId', $this->siteLangId);
        $this->_template->render(true, true);
		
	}	
	
	public function searchReport($export=''){
		
		if (!User::canAccessSupplierDashboard()) {
            Message::addErrorMessage(Labels::getLabel("LBL_Invalid_Access!", $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
		$userId = UserAuthentication::getLoggedUserId();

        $srchFrm = $this->getReportSearchForm();
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);

		$pagesize = FatApp::getConfig('CONF_PAGE_SIZE');
		
		$srch = TestDrive::getSearchObject();
		$srch->joinTable(Transactions::DB_TBL, 'LEFT JOIN', 'txn.utxn_test_drive_id = ptdr_id', 'txn');
		$srch->addCondition('sp.selprod_user_id','=',$userId);
		
		$date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('td.ptdr_request_added_on', '>=', $date_from. ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('td.ptdr_request_added_on', '<=', $date_to. ' 23:59:59');
        }
		
		$srch->addMultipleFields(array('u.user_name as buyername','seller.user_name as sellername','IFNULL(product_name, product_identifier) as product_name','ptdr_id','ptdr_date','ptdr_request_added_on','ptdr_status','utxn_id'));
		
		
		if ($export == "export") {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();
            $arr = array( Labels::getLabel('LBL_Date', $this->siteLangId), Labels::getLabel('LBL_Test_Drive_Number', $this->siteLangId), Labels::getLabel('LBL_Product', $this->siteLangId), Labels::getLabel('LBL_Buyer', $this->siteLangId), Labels::getLabel('LBL_Requested_On', $this->siteLangId),Labels::getLabel('LBL_Status', $this->siteLangId),Labels::getLabel('LBL_Payment_Status', $this->siteLangId));
            array_push($sheetData, $arr);
            while ($row = FatApp::getDb()->fetch($rs)) {
				
				if(!empty($row['utxn_id'])){
					$utxn_status = Labels::getLabel('LBL_Settled', $this->siteLangId); 
				}else{ 
					$utxn_status = 'N/A'; 
				}
				
				$date = FatDate::format($row['ptdr_request_added_on'],true);
				$requestedOn = FatDate::format($row['ptdr_date'],true);
				$testDriveStatusArr = TestDrive::getStatusArr($this->siteLangId);
				$status = $testDriveStatusArr[$row['ptdr_status']];
				
                $arr = array( $date, $row['ptdr_id'], $row['product_name'], $row['buyername'] ,$requestedOn,$status,$utxn_status);
                array_push($sheetData, $arr);
            }
            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Test_Drive_Report', $this->siteLangId).date("Y-m-d").'.csv', ',');
            exit;
        } else {
			$srch->setPageNumber($page);
			$srch->setPageSize($pagesize);
			$db = FatApp::getDb();
			$rs = $srch->getResultSet();
			$arr_listing = $db->fetchAll($rs);
			$this->set("arr_listing", $arr_listing);
			$this->set('pageCount', $srch->pages());
			$this->set('page', $page);
			$this->set('pageSize', $pagesize);
			$this->set('postedData', $post);
			$this->set('siteLangId', $this->siteLangId);
	
			unset($post['page']);
			$srchFrm->fill($post);
			$this->set("frmTestDriveReport", $srchFrm);
			$this->_template->render(false, false);
        }
		
	}
	
	public function exportReport(){
		$this->searchReport("export");
	}


    private function getStatusFrm()
    {
        $frm = new Form('frmTestDriveRequestStatus');
        $testDriveStatusArr = [
                               TestDrive::STATUS_PENDING  => Labels::getLabel('LBL_PENDING', $this->siteLangId),
                               TestDrive::STATUS_ACCEPTED  => Labels::getLabel('LBL_ACCEPTED', $this->siteLangId),
                               TestDrive::STATUS_CANCELLED  => Labels::getLabel('LBL_CANCELLED', $this->siteLangId),
                               ];

        $reqStatus= $frm->addSelectBox(Labels::getLabel('LBL_Request_Status', $this->siteLangId), 'ptdr_status', $testDriveStatusArr, '0', array(), '');

        $frm->addTextarea(Labels::getLabel('LBL_Comments', $this->siteLangId), 'ptdr_comments');

        $pCommFld = $frm->addFloatField(Labels::getLabel('LBL_Comments', $this->siteLangId), 'ptdr_comments');
        $pCommUnReqObj = new FormFieldRequirement('LBL_Comments', Labels::getLabel('ptdr_comments', $this->siteLangId));
        $pCommUnReqObj->setRequired(false);

        $pCommReqObj = new FormFieldRequirement('LBL_Comments', Labels::getLabel('ptdr_comments', $this->siteLangId));
        $pCommReqObj->setRequired(true);

        //$reqStatus->requirements()->addOnChangerequirementUpdate(0, 'eq', 'ptdr_comments', $pCommUnReqObj);
        $reqStatus->requirements()->addOnChangerequirementUpdate(TestDrive::STATUS_PENDING, 'eq', 'ptdr_comments', $pCommUnReqObj);
        $reqStatus->requirements()->addOnChangerequirementUpdate(TestDrive::STATUS_ACCEPTED, 'eq', 'ptdr_comments', $pCommUnReqObj);
        $reqStatus->requirements()->addOnChangerequirementUpdate(TestDrive::STATUS_CANCELLED, 'eq', 'ptdr_comments', $pCommReqObj);

        $frm->addHiddenField('', 'ptdr_id');
        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Submit', $this->siteLangId), array('class'=>'btn btn--primary'));

        return $frm;
    }
	
	private function getFeedbackFrm()
    {
        $frm = new Form('frmTestDriveFeedback');
        $fld = $frm->addTextarea(Labels::getLabel('LBL_Feedback', $this->siteLangId), 'ptdr_feedback');
		$fld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Write_Your_Feedback_Here', $this->siteLangId));
		$fld->requirements()->setRequired();
        $frm->addHiddenField('', 'ptdr_id');
        $frm->addHiddenField('', 'ptdr_status');
        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Submit', $this->siteLangId), array('class'=>'btn btn--primary'));
        return $frm;
    }

    private function getReportSearchForm()
    {
        $frm = new Form('frmTestDriveReportSrch');
        $frm->addHiddenField('', 'page');
        $frm->addDateField('', 'date_from', '', array('placeholder' => Labels::getLabel('LBL_Date_From', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender' ));
        $frm->addDateField('', 'date_to', '', array('placeholder' => Labels::getLabel('LBL_Date_To', $this->siteLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear', $this->siteLangId), array('onclick'=>'clearSearch();'));
        return $frm;
    }
	
}
