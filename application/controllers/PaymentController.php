<?php
class PaymentController extends MyAppController
{
    //Mobile payment gateways
    private $keyNames = ['PaypalStandard'];

    //For API Call, After successfull payment.
    public function paymentSuccess()
    {
        $keyName = FatApp::getPostedData('keyName', FatUtility::VAR_STRING, '');

        if (in_array($keyName, $this->keyNames)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }

        $tempToken = FatApp::getPostedData('tempToken', FatUtility::VAR_STRING, '');
        if (UserAuthentication::TOKEN_LENGTH != strlen($tempToken)) {
            FatUtility::dieJSONError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }

        $userId = UserAuthentication::getLoggedUserId();
        $uObj = new User($userId);
        if (!$uObj->validateAPITempToken($tempToken)) {
            FatUtility::dieJSONError(Labels::getLabel('LBL_Invalid_Temp_Token', $this->siteLangId));
        }


        $txn_id = FatApp::getPostedData('txn_id', FatUtility::VAR_STRING, '');
        $amount = FatApp::getPostedData('amount', FatUtility::VAR_FLOAT, 0);
        $response = FatApp::getPostedData('response', FatUtility::VAR_STRING, '');
        $orderId = FatApp::getPostedData('orderId', FatUtility::VAR_STRING, '');

        if (empty($txn_id) || 0 >= $amount || empty($response) || empty($orderId)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }

        $orderObj = new Orders();
        $orderDetail = $orderObj->getOrderById($orderId, $this->siteLangId);
        if (!$orderDetail || 1 > count($orderDetail) || $orderDetail['order_user_id'] != $userId) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }

        $pmObj = new PaymentSettings($keyName);
        $paymentSettings = $pmObj->getPaymentSettings();

        $msg = Labels::getLabel('MSG_Received_Payment', $this->siteLangId);

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $orderPaymentObj->addOrderPayment($paymentSettings["pmethod_code"], $txn_id, $amount, $msg, $response);

        $this->set('msg', $msg);
        $this->_template->render();
    }

    //For API Call, If order not completed.
    public function paymentPending()
    {
        $keyName = FatApp::getPostedData('keyName', FatUtility::VAR_STRING, '');

        if (in_array($keyName, $this->keyNames)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }

        $tempToken = FatApp::getPostedData('tempToken', FatUtility::VAR_STRING, '');
        if (UserAuthentication::TOKEN_LENGTH != strlen($tempToken)) {
            FatUtility::dieJSONError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }

        $userId = UserAuthentication::getLoggedUserId();
        $uObj = new User($userId);
        if (!$uObj->validateAPITempToken($tempToken)) {
            FatUtility::dieJSONError(Labels::getLabel('LBL_Invalid_Temp_Token', $this->siteLangId));
        }

        $orderId = FatApp::getPostedData('orderId', FatUtility::VAR_STRING, '');
        $orderObj = new Orders();
        $orderDetail = $orderObj->getOrderById($orderId, $this->siteLangId);
        if (!$orderDetail || 1 > count($orderDetail) || $orderDetail['order_user_id'] != $userId) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }

        $response = FatApp::getPostedData('response', FatUtility::VAR_STRING, '');
        if (empty($response)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }

        $pmObj = new PaymentSettings($keyName);
        $paymentSettings = $pmObj->getPaymentSettings();

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $orderPaymentObj->addOrderPaymentComments($response);

        $this->set('msg', $response);
        $this->_template->render();
    }
}
