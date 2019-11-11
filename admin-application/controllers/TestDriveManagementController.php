<?php
class TestDriveManagementController extends AdminBaseController
{
    private $canView;
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewTestDriveManagement($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditTestDriveManagement($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->_template->render();
    }

    public function slabRates()
    {
        $srch = TestDriveManagement::getSearchObject();
        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetchAll($rs);
        $this->set("arr_listing", $arr_listing);
        $this->_template->render(false, false);
    }

    public function frm()
    {
        $record = Configurations::getConfigurations();
        $frm = $this->getSettingsForm();
        $frm->fill($record);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function slabRateFrm($id=0)
    {
        $frm = $this->getSlabRateFrm();
        if (!empty($id)) {
            $data = TestDriveManagement::getAttributesById($id);
            $frm->fill($data);
        }

        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setupSlabRates()
    {
        if (!$this->objPrivilege->canEditTestDriveManagement()) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $frm = $this->getSlabRateFrm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false == $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $tdcs_id = FatApp::getPostedData('tdcs_id', FatUtility::VAR_INT, 0);
        $min = FatApp::getPostedData('tdcs_min_rides', FatUtility::VAR_INT);
        $max = FatApp::getPostedData('tdcs_max_rides', FatUtility::VAR_INT);

        if ($min >= $max) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Invalid_Range', $this->adminLangId));
        };

		$tobj = TestDriveManagement::getSearchObject();
		$cnd = $tobj->addDirectCondition("((" . $min . " BETWEEN tdcs_min_rides  and tdcs_max_rides  OR  " . $max . " between tdcs_min_rides and tdcs_max_rides) or (tdcs_min_rides BETWEEN " . $min . " and " . $max . " OR tdcs_max_rides between " . $min . " and " . $max . ")) and tdcs_id != ". $tdcs_id ."");
		$rs = $tobj->getResultSet();
        $row = FatApp::getDb()->fetchAll($rs);
		
		if(!empty($row)){
			FatUtility::dieJsonError(Labels::getLabel('LBL_Invalid_Range', $this->adminLangId));
		}

        $obj = new TestDriveManagement($tdcs_id);
        $obj->assignValues($post);
        if (!$obj->save()) {
            FatUtility::dieJsonError($obj->getError());
        }

        $slabId = $obj->getMainTableRecordId();
        if ($slabId == $tdcs_id) {
            $this->set('msg', Labels::getLabel('MSG_Credit_Slab_Updated_successfully', $this->adminLangId));
        } else {
            $this->set('msg', Labels::getLabel('MSG_Credit_Slab_Added_successfully', $this->adminLangId));
        }

        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateSettings()
    {
        if (!$this->objPrivilege->canEditTestDriveManagement()) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $frm = $this->getSettingsForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false == $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        if (FatApp::getPostedData('CONF_ENABLE_BUYER_TEST_DRIVE_CREDIT_MODULE', FatUtility::VAR_INT, 0) == 1) {
            if (FatApp::getPostedData('CONF_BUYER_TEST_DRIVE_CREDIT_POINTS', FatUtility::VAR_INT, 0) == 0 || FatApp::getPostedData('CONF_TEST_DRIVE_REWARD_POINTS_VALIDITY', FatUtility::VAR_INT, 0) == 0) {
                FatUtility::dieJsonError(Labels::getLabel('MSG_Enter_Valid_Values', $this->adminLangId));
            }
        }

        $record = new Configurations();

        if (!$record->update($post)) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('MSG_Setup_Successful', $this->adminLangId));
        $this->set('langId', 0);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteSlabRateFrm()
    {
        if (!$this->objPrivilege->canEditTestDriveManagement()) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $tdcs_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);

        if ($tdcs_id < 1) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieJsonError(Message::getHtml());
        }

        if (!FatApp::getDb()->deleteRecords(TestDriveManagement::DB_TBL, array( 'smt' => 'tdcs_id = ?', 'vals' => array( $tdcs_id )))) {
            Message::addErrorMessage(FatApp::getDb()->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    private function getSettingsForm()
    {
        $frm = new Form('frmTestDriveSettings');
        $frm->addRadioButtons(Labels::getLabel('LBL_Enable_Seller_Credit_Module', $this->adminLangId), 'CONF_ENABLE_SELLER_TEST_DRIVE_CREDIT_MODULE', applicationConstants::getYesNoArr($this->adminLangId), '', array('class'=>'list-inline'));
        $frm->addRadioButtons(Labels::getLabel('LBL_Enable_Buyer_Credit_Module', $this->adminLangId), 'CONF_ENABLE_BUYER_TEST_DRIVE_CREDIT_MODULE', applicationConstants::getYesNoArr($this->adminLangId), '', array('class'=>'list-inline'));
        $fld = $frm->addIntegerField(Labels::getLabel('LBL_Buyer_Rewards', $this->adminLangId), 'CONF_BUYER_TEST_DRIVE_CREDIT_POINTS');
        $fld->requirements()->setRequired(false);
		$fld->requirements()->setPositive();
        $fld = $frm->addIntegerField(Labels::getLabel('LBL_Test_Drive_Rewards_Expire_Days', $this->adminLangId), 'CONF_TEST_DRIVE_REWARD_POINTS_VALIDITY');
        $fld->requirements()->setRequired(false);
		$fld->requirements()->setPositive();
        $frm->addSubmitButton(' ', 'btn_submit', Labels::getLabel('LBL_Submit', $this->adminLangId));
        return $frm;
    }

    private function getSlabRateFrm()
    {
        $frm = new Form('frmSlabRate');
        $min = $frm->addIntegerField(Labels::getLabel('LBL_Min_Drives', $this->adminLangId), 'tdcs_min_rides');
        $min->requirements()->setRequired();
		$min->requirements()->setPositive();
        $max = $frm->addIntegerField(Labels::getLabel('LBL_Max_Drives', $this->adminLangId), 'tdcs_max_rides');
        $max->requirements()->setRequired();
		$max->requirements()->setPositive();
        $amount = $frm->addIntegerField(Labels::getLabel('LBL_Amount', $this->adminLangId), 'tdcs_amount');
        $amount->requirements()->setRequired();
        $amount->requirements()->setPositive();
        $frm->addHiddenField('', 'tdcs_id');
        $frm->addSubmitButton(' ', 'btn_submit', Labels::getLabel('LBL_Submit', $this->adminLangId));
        return $frm;
    }
}
