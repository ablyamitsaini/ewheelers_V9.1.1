<?php
class TestDriveController extends AdminBaseController
{
    private $canView;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewTestDriveRequests($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditTestDriveRequests($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $srchFrm = $this->getSearchForm();
        $this->objPrivilege->canViewTestDriveRequests();
        $this->set("frmSearch", $srchFrm);
        $this->_template->render();
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch', array('id'=>'frmSearch'));
        $frm->setRequiredStarWith('caption');
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');

        $prodCatObj = new ProductCategory();
        $arrCategories = $prodCatObj->getCategoriesForSelectBox($this->adminLangId);
        $categories = $prodCatObj->makeAssociativeArray($arrCategories);

        $frm->addSelectBox(Labels::getLabel('LBL_category', $this->adminLangId), 'prodcat_id', array( -1 =>Labels::getLabel('LBL_Does_not_Matter', $this->adminLangId) ) + $categories, '', array(), '');

        $frm->addTextBox(Labels::getLabel('LBL_Seller_Name_Or_Email', $this->adminLangId), 'user_name', '', array('id'=>'keyword','autocomplete'=>'off'));

        $testDriveStatusArr = TestDrive::getStatusArr($this->adminLangId);
        /* $frm->addSelectBox(Labels::getLabel('LBL_Request_Status', $this->adminLangId), 'ptdr_status', $testDriveStatusArr, array()); */
        $frm->addSelectBox(Labels::getLabel('LBL_Product_Type', $this->adminLangId), 'ptdr_status', array( '-1' => Labels::getLabel('LBL_All', $this->adminLangId) ) + $testDriveStatusArr, '-1', array(), '');

        $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->adminLangId), 'date_from', '', array('readonly' => 'readonly','class' => 'small dateTimeFld field--calender' ));
        $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->adminLangId), 'date_to', '', array('readonly' => 'readonly','class' => 'small dateTimeFld field--calender'));

        $frm->addHiddenField('', 'user_id', '');
        $frm->addHiddenField('', 'page');

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick'=>'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    public function search()
    {
        $this->objPrivilege->canViewTestDriveRequests();
        $db = FatApp::getDb();
        $frm = $this->getSearchForm($this->adminLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false == $frm->validate($post)) {
            FatUtility::dieJsonError($frm->getValidationErrors());
        }

        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10);

        $srch = TestDrive::getSearchObject();

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('p_l.product_name', 'like', '%' . $keyword . '%');
            $cnd = $srch->addCondition('p.product_identifier', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('p.product_model', 'like', '%' . $keyword . '%');
        }

        $user_id = FatApp::getPostedData('user_id', FatUtility::VAR_INT, -1);
        if ($user_id > 0) {
            $srch->addCondition('sp.selprod_user_id', '=', $user_id);
        } else {
            $user_name = FatApp::getPostedData('user_name', null, '');
            if (!empty($user_name)) {
                $cond = $srch->addCondition('u.user_name', 'like', '%'.$keyword.'%');
                $cond->attachCondition('uc.credential_email', 'like', '%'.$keyword.'%', 'OR');
                $cond->attachCondition('u.user_name', 'like', '%'. $keyword .'%');
            }
        }


        $prodcat_id = FatApp::getPostedData('prodcat_id', FatUtility::VAR_INT, -1);
        if ($prodcat_id  > -1) {
            $srch->joinTable(Product::DB_TBL_PRODUCT_TO_CATEGORY, 'LEFT OUTER JOIN', 'p.product_id = ptc_product_id', 'ptcat');
            $srch->addCondition('ptcat.ptc_prodcat_id', '=', $prodcat_id);
        }

        $status = FatApp::getPostedData('ptdr_status', FatUtility::VAR_INT, -1);
        if ($status > -1) {
            $srch->addCondition('td.ptdr_status', '=', $status);
        }

        $date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('td.ptdr_date', '>=', $date_from. ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('td.ptdr_date', '<=', $date_to. ' 23:59:59');
        }

        $srch->addCondition('sp.selprod_test_drive_enable', '=', 1);
        $srch->addOrder("td.ptdr_id", "DESC");
        $srch->addMultipleFields(TestDrive::addSearchFields(array()));

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetchAll($rs);
        /* echo"<pre>";
        print_r($arr_listing);
        echo"</pre>"; */
        $this->set("arr_listing", $arr_listing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('adminLangId', $this->adminLangId);
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
        $this->set('canEdit', $this->objPrivilege->canEditProducts(AdminAuthentication::getLoggedAdminId(), true));
        $this->_template->render(false, false);
    }

    public function viewTestDriveDetails($requestId)
    {
        $db = FatApp::getDb();
        $srch = TestDrive::getSearchObject();
        $srch->addCondition('td.ptdr_id', '=', $requestId);
        $srch->addMultipleFields(TestDrive::addSearchFields(array()));

        $rs = $srch->getResultSet();
        $arr_listing = $db->fetch($rs);
        $this->set("arr_listing", $arr_listing);
        $this->set('adminLangId', $this->adminLangId);
        $this->_template->render(false, false);
    }

    public function completeRequest()
    {
        if (!$this->objPrivilege->canEditTestDriveRequests()) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Invalid_Request', $this->adminLangId));
        }

        $requestId = FatApp::getPostedData('requestId', FatUtility::VAR_INT, 0);
        $request_data = TestDrive::getAttributesById($requestId);

        if (empty($request_data) || $request_data['ptdr_status'] != TestDrive::STATUS_DELIVERED) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Invalid_Request', $this->adminLangId));
        }

        $db = FatApp::getDb();
        $srch = TestDrive::getSearchObject();
        $srch->addCondition('td.ptdr_id', '=', $requestId);
        $srch->addMultipleFields(array('selprod_user_id','ptdr_user_id'));
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetch($rs);
        $seller_id = $arr_listing['selprod_user_id'];
        $user_id = $arr_listing['ptdr_user_id'];

        if (1 > $user_id || 1 > $seller_id) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Invalid_Request', $this->adminLangId));
        }

        $db = FatApp::getDb();
        $db->startTransaction();

        if (FatApp::getConfig("CONF_ENABLE_BUYER_TEST_DRIVE_CREDIT_MODULE", FatUtility::VAR_INT)) {
            if (TestDriveManagement::checkBuyerCreditAmount($user_id)) {
                $urpId = $this->addRewards($user_id);
                if (false == $urpId) {
                    $db->rollbackTransaction();
                }

                $dataToSaveArr = array('ptdr_user_reward_points' => FatApp::getConfig("CONF_BUYER_TEST_DRIVE_CREDIT_POINTS", FatUtility::VAR_INT, 0));
                $where = array('smt' => 'ptdr_id = ?', 'vals' => array( $requestId ) );
                $row = $db->updateFromArray(TestDrive::DB_TBL, $dataToSaveArr, $where);
                if (!$row) {
                    Message::addErrorMessage($db->getError());
                    FatUtility::dieJsonError(Message::getHtml());
                    $db->rollbackTransaction();
                }
            }
        }

        if (FatApp::getConfig("CONF_ENABLE_SELLER_TEST_DRIVE_CREDIT_MODULE", FatUtility::VAR_INT)) {
            $txnId = $this->addTransaction($seller_id, $requestId);
            if (false === $txnId) {
                $db->rollbackTransaction();
            }
        }

        $obj = new TestDrive($requestId);
        $obj->setFldValue('ptdr_status', TestDrive::STATUS_COMPLETED, false);
        if (!$obj->save()) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError($obj->getError());
        }

        $db->commitTransaction();

        $emailObj = new EmailHandler();
        if (!empty($urpId)) {
            if (!$emailObj->sendRewardPointsNotification($this->adminLangId, $urpId)) {
                FatUtility::dieJsonError(Labels::getLabel($emailObj->getError(), $this->adminLangId));
            }
        }

        if (!empty($txnId)) {
            if (!$emailObj->sendTxnNotification($txnId, $this->adminLangId)) {
                FatUtility::dieJsonError(Labels::getLabel($emailObj->getError(), $this->adminLangId));
            }
        }

        if (!$obj->sendStatusChangedEmailUpdateSeller($requestId, TestDrive::STATUS_COMPLETED, $this->adminLangId)) {
            FatUtility::dieJsonError($obj->getError());
        }

        if (!$obj->sendStatusChangedEmailUpdateBuyer($requestId, TestDrive::STATUS_COMPLETED, $this->adminLangId)) {
            FatUtility::dieJsonError($obj->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_Request_has_been_confirmed_successfully', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }


    private function addTransaction($seller_id, $requestId)
    {
        $creditAmount = TestDriveManagement::checkSellerCreditAmount($seller_id);
        if ($creditAmount == 0) {
            return $creditAmount;
        }
        $comments = Labels::getLabel("LBL_Test_Drive_Credits", CommonHelper::getLangId());
        $txnObj = new Transactions();
        $txnDataArr = array(
         'utxn_user_id'=> $seller_id,
         'utxn_comments'=> $comments,
         'utxn_status'=> Transactions::STATUS_COMPLETED,
         'utxn_credit'=> $creditAmount,
         'utxn_debit'=> 0,
         'utxn_type'=> Transactions::TYPE_TEST_DRIVE_CREDITS,
         'utxn_test_drive_id'=> $requestId,
         'utxn_date' => date("Y-m-d h:i:sa")
        );
        if (!$txnObj->addTransaction($txnDataArr)) {
            FatUtility::dieJsonError($txnObj->getError());
            return false;
        }

        return $txnObj->getMainTableRecordId();
    }

    private function addRewards($user_id)
    {
        $rewardExpiryDate = '0000-00-00';
        $CONF_TEST_DRIVE_REWARD_POINTS_VALIDITY = FatApp::getConfig("CONF_TEST_DRIVE_REWARD_POINTS_VALIDITY", FatUtility::VAR_INT, 0);
        if ($CONF_TEST_DRIVE_REWARD_POINTS_VALIDITY > 0) {
            $rewardExpiryDate = date('Y-m-d', strtotime('+'.$CONF_TEST_DRIVE_REWARD_POINTS_VALIDITY.' days'));
        }

        $robj = new UserRewards();
        $urpComments = Labels::getLabel("LBL_Test_Drive_Reward_Points", CommonHelper::getLangId());
        $reward_points = FatApp::getConfig("CONF_BUYER_TEST_DRIVE_CREDIT_POINTS", FatUtility::VAR_INT, 0);
        if ($reward_points == 0) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Please_set_valid_reward_points', $this->adminLangId));
        }

        $robj->assignValues(
            array(
            'urp_user_id'            => $user_id,
            'urp_referral_user_id'    =>   0,
            'urp_points'    =>    $reward_points,
            'urp_comments'    =>    $urpComments,
            'urp_used'        =>    0,
            'urp_date_expiry'    =>    $rewardExpiryDate
            )
        );
        if (!$robj->save()) {
            FatUtility::dieJsonError($robj->getError());
            return false;
        }

        return $robj->getMainTableRecordId();
    }
}
