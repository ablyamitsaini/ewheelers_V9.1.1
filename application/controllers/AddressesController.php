<?php
class AddressesController extends LoggedUserController
{
    public function __construct($action)
    {
        parent::__construct($action);
        //$this->set('bodyClass','is--dashboard');
    }

    public function setUpAddress()
    {
        $frm = $this->getUserAddressForm($this->siteLangId);
        $post = FatApp::getPostedData();
        if ($post == false) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $ua_state_id = FatUtility::int($post['ua_state_id']);
        $post = $frm->getFormDataFromArray($post);
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieWithError(Message::getHtml());
        }
        $post['ua_state_id'] = $ua_state_id;

        $ua_id = FatUtility::int($post['ua_id']);
        unset($post['ua_id']);

        $addressObj = new UserAddress($ua_id);

        $data_to_be_save = $post;
        $data_to_be_save['ua_user_id'] = UserAuthentication::getLoggedUserId();

        $addressObj->assignValues($data_to_be_save, true);
        if (!$addressObj->save()) {
            Message::addErrorMessage($addressObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
        if (0 <= $ua_id) {
            $ua_id = $addressObj->getMainTableRecordId();
        }
        $this->set('ua_id', $ua_id);

        $this->set('msg', Labels::getLabel('LBL_Setup_Successful', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function setDefault()
    {
        $post = FatApp::getPostedData();
        if ($post == false) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $ua_id = FatUtility::int($post['id']);
        if (1 > $ua_id) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $updateArray = array('ua_is_default'=>0);
        $whr = array('smt'=>'ua_user_id = ?', 'vals'=>array(UserAuthentication::getLoggedUserId()));

        if (!FatApp::getDb()->updateFromArray(UserAddress::DB_TBL, $updateArray, $whr)) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $addressObj = new UserAddress($ua_id);
        $data = array(
        'ua_id'=>$ua_id,
        'ua_is_default'=>1,
        'ua_user_id'=>UserAuthentication::getLoggedUserId(),
        );

        $addressObj->assignValues($data, true);
        if (!$addressObj->save()) {
            Message::addErrorMessage($addressObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('LBL_Setup_Successful', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $post = FatApp::getPostedData();
        if ($post == false) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $ua_id = FatUtility::int($post['id']);
        if (1 > $ua_id) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }

        $data =  UserAddress::getUserAddresses(UserAuthentication::getLoggedUserId(), $this->siteLangId, 0, $ua_id);
        if ($data === false) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_request', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $addressObj = new UserAddress($ua_id);
        if (!$addressObj->deleteRecord()) {
            Message::addErrorMessage($addressObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_Deleted_successfully', $this->siteLangId));
    }
}
