<?php
require_once CONF_INSTALLATION_PATH . 'library/payment-plugins/PayFort/PayfortIntegration.php';
class PayFortPayController extends PaymentController
{
    private $keyName = "PayFort";
    private $testEnvironmentUrl = 'https://sbcheckout.payfort.com/FortAPI/paymentPage';
    private $liveEnvironmentUrl = 'https://checkout.payfort.com/FortAPI/paymentPage';
    private $error = false;
    private $currency = 'SAR'; // replace $currency with strtoupper( $orderInfo['order_currency_code'])
    private $currenciesAccepted = array(
                                            'United Arab Emirates Dirham' => 'AED',
                                            'U.S. Dollar' => 'USD',
                                            'Jordanian Dinar' => 'JOD',
                                            'Kuwaiti Dinar' => 'KWD',
                                            'Omani Rial' => 'OMR',
                                            'Tunisian Dinar' => 'TND',
                                            'Bahraini Dinar' => 'BHD',
                                            'Libyan Dinar' => 'LYD',
                                            'Iraqi Dinar' => 'IQD',
                                            'Saudi Riyal' => 'SAR',
                                        );

    public function charge($orderId = '')
    {
        if (empty($orderId)) {
            FatUtility::exitWIthErrorCode(404);
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentGatewayCharge = 0.00;
        $orderInfo  = array();
        $requestParams = $this->generatePaymentFormParams($orderId, $orderPaymentObj, $orderInfo, $paymentGatewayCharge);
        if ($requestParams) {
            $frm = $this->getPaymentForm($requestParams);
            $this->set('paymentAmount', $paymentGatewayCharge);
            $this->set('frm', $frm);
            $this->set('orderInfo', $orderInfo);
            $this->set('requestParams', $requestParams);
        } else {
            $this->error = Labels::getLabel('PAYFORT_Invalid_request_parameters', $this->siteLangId);
        }

        if ($this->error) {
            $this->set('error', $this->error);
        }
        $this->set('paymentAmount', $paymentGatewayCharge);
        $this->set('orderInfo', $orderInfo);
        $this->set('exculdeMainHeaderDiv', true);
        $this->_template->addCss('css/payment.css');
        $this->_template->render(true, false);
    }

    public function doPayment($orderId)
    {
        if (!$orderId) {
            Message::addErrorMessage(Labels::getLabel('PAYFORT_INVALID_REQUEST'));
            FatApp::redirectUser(CommonHelper::generateUrl('Account', 'profileInfo'));
        }

        $paymentChargeUrl = CommonHelper::generateUrl('PayFortPay', 'charge', array( $orderId ));
        if (!(isset($_REQUEST['signature']) and !empty($_REQUEST['signature']))) {
            Message::addErrorMessage(Labels::getLabel('PAYFORT_INVALID_REQUEST', $this->siteLangId));
            FatApp::redirectUser($paymentChargeUrl);
        }

        $paymentSettings = $this->getPaymentSettings();
        if (!$this->validatePayFortSettings($paymentSettings)) {
            Message::addErrorMessage(Labels::getLabel('PAYFORT_INVALID_PAYMENT_GATEWAY_SETUP_ERROR', $this->siteLangId));
            redirectUser($paymentChargeUrl);
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentGatewayCharge = 0.00;
        $orderInfo = array();

        $requestParams = $this->generatePaymentFormParams($orderId, $orderPaymentObj, $orderInfo, $paymentGatewayCharge, false);

        if ($requestParams === false || !$orderInfo) {
            Message::addErrorMessage($this->error);
            FatApp::redirectUser($paymentChargeUrl);
        }
        //calculate Signature after back to merchant and comapre it with request Signature
        $arrData = $_REQUEST;
        unset($arrData['signature']);
        unset($arrData['url']);
        unset($_REQUEST['expiry_date']);
        unset($_REQUEST['card_security_code']);

        $payfortIntegration = new PayfortIntegration();

        $returnSignature = $payfortIntegration->calculateSignature($arrData, $paymentSettings['sha_response_phrase'], $paymentSettings['sha_type']);

        if ($returnSignature == $_REQUEST['signature'] && substr($_REQUEST['response_code'], 2) == '000' && $_REQUEST['amount'] == $paymentGatewayCharge && $_REQUEST['customer_ip'] == $_SERVER['REMOTE_ADDR'] && $_REQUEST['currency'] == strtoupper($orderInfo['order_currency_code']/* $this->currency */) && $_REQUEST['merchant_reference'] == $orderInfo['id']) {
            $message = array();

            foreach ($_REQUEST as $key => $value) {
                $key = str_replace('_', ' ', $key);
                $message[] = ucwords($key) . ': '.(string)$value;
            }

            $gateWayCharges =     ($paymentGatewayCharge/100);
            $orderPaymentObj->addOrderPayment($paymentSettings["pmethod_code"], $_REQUEST['fort_id'], $gateWayCharges, 'Received Payment', implode('&', $message));

            FatApp::redirectUser(CommonHelper::generateUrl('custom', 'paymentSuccess', array($orderId)));
        } else {
            $orderPaymentObj->addOrderPaymentComments('#' . $_REQUEST['response_code'] . ': ' . $_REQUEST['response_message']);
        }
        if (substr($_REQUEST['response_code'], 2) == '072') {
            FatApp::redirectUser(CommonHelper::getPaymentCancelPageUrl());
        } else {
            FatApp::redirectUser(CommonHelper::getPaymentFailurePageUrl());
        }
    }

    private function generatePaymentFormParams($orderId, $orderPaymentObj, &$orderInfo, &$paymentGatewayCharge = 0.00, $returnParams = true)
    {
        if (!$orderId) {
            $this->error = Labels::getLabel('MSG_Invalid_order_request', $this->siteLangId);
            return false;
        }

        $paymentGatewayCharge = $this->formatPayableAmount($orderPaymentObj->getOrderPaymentGatewayAmount());
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();

        $paymentSettings = $this->getPaymentSettings();

        if (count($this->currenciesAccepted) && !in_array($orderInfo["order_currency_code"], $this->currenciesAccepted)) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_ORDER_CURRENCY_PASSED_TO_GATEWAY', $this->siteLangId));
            CommonHelper::redirectUserReferer();
        }

        if (!$this->validatePayFortSettings($paymentSettings)) {
            $this->error = Labels::getLabel('PAYFORT_Invalid_Payment_Gateway_Setup_Error', $this->siteLangId);
        }

        if (!$orderInfo['id']) {
            $this->error = Labels::getLabel('MSG_INVALID_ACCESS', $this->siteLangId);
            return false;
        } elseif ($orderInfo["order_is_paid"] != Orders::ORDER_IS_PENDING) {
            $this->error = Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId);
            return false;
        }

        $orderPaymentGatewayDescription = sprintf(Labels::getLabel('MSG_Order_Payment_Gateway_Description', $this->siteLangId), $orderInfo["site_system_name"], $orderInfo['invoice']);

        if ($returnParams) {
            $payfortIntegration = new PayfortIntegration();
            $payfortIntegration->amount                 = $paymentGatewayCharge;
            $payfortIntegration->currency               = /* $this->currency */ strtoupper($orderInfo['order_currency_code']);
            $payfortIntegration->language               = strtolower($orderInfo['order_language']);
            $payfortIntegration->merchant_identifier    = $paymentSettings['merchant_id'];
            $payfortIntegration->access_code            = $paymentSettings['access_code'];
            $payfortIntegration->order_description      = $orderPaymentGatewayDescription;
            $payfortIntegration->merchant_reference     = $orderInfo['invoice']; /* uniqid('ref_'); */
            $payfortIntegration->customer_ip            = $_SERVER['REMOTE_ADDR'];
            $payfortIntegration->customer_email         = $orderInfo['customer_email'];
            $payfortIntegration->command                   = 'PURCHASE';
            $payfortIntegration->return_url             = CommonHelper::generateNoAuthUrl('PayFortPay', 'doPayment', array($orderId));
            //$payfortIntegration->return_url             = CommonHelper::generateFullUrl('PayFortPay','doPayment',array($orderId),'',false);

            $requestParams  = $payfortIntegration->getRequestParams();
            $signature      = $payfortIntegration->calculateSignature($requestParams, $paymentSettings['sha_request_phrase'], $paymentSettings['sha_type']);
            $requestParams['signature'] = $signature;

            return $requestParams;
        } else {
            return array();
        }
    }

    private function getPaymentSettings()
    {
        $pmObj = new PaymentSettings($this->keyName);
        return $pmObj->getPaymentSettings();
    }

    private function formatPayableAmount($amount = null)
    {
        if ($amount == null) {
            return false;
        }
        $amount = number_format($amount, 2, '.', '');
        return $amount*100;
    }

    private function validatePayFortSettings($paymentSettings = array())
    {
        $settingVal = array('merchant_id','access_code','sha_type','sha_request_phrase','sha_response_phrase');
        foreach ($settingVal as $val) {
            if (!isset($paymentSettings[$val]) || strlen(trim($paymentSettings[$val])) == 0) {
                return false;
            }
        }
        return true;
    }

    private function getPaymentForm($requestParams = array())
    {
        $actionUrl = (FatApp::getConfig('CONF_TRANSACTION_MODE', FatUtility::VAR_BOOLEAN, false) == true)?$this->liveEnvironmentUrl:$this->testEnvironmentUrl;

        $frm = new Form('frmPayFort', array('id'=>'frmPayFort','class'=>'form','action'=>$actionUrl));
        foreach ($requestParams as $a => $b) {
            $frm->addHiddenField('', htmlentities($a), htmlentities($b));
        }
        $frm->addSubmitButton('', '', Labels::getLabel('LBL_CONFIRM_PAYMENT', $this->siteLangId));
        return $frm;
    }
}
