<?php
class AuthorizeAimPayController extends PaymentController
{
    private $keyName = "AuthorizeAim";
    private $testEnvironmentUrl = 'https://test.authorize.net/gateway/transact.dll';
    private $liveEnvironmentUrl = 'https://secure.authorize.net/gateway/transact.dll';

    public function charge($orderId = '')
    {
        if (empty($orderId)) {
            FatUtility::exitWIthErrorCode(404);
        }

        $pmObj = new PaymentSettings($this->keyName);
        if (!$paymentSettings = $pmObj->getPaymentSettings()) {
            Message::addErrorMessage($pmObj->getError());
            CommonHelper::redirectUserReferer();
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();

        if (!$orderInfo['id']) {
            FatUtility::exitWIthErrorCode(404);
        } elseif ($orderInfo["order_is_paid"] == Orders::ORDER_IS_PENDING) {
            $frm = $this->getPaymentForm($orderId);
            $this->set('frm', $frm);
            $this->set('paymentAmount', $paymentAmount);
        } else {
            $this->set('error', Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId));
        }

        $cancelBtnUrl = CommonHelper::getPaymentCancelPageUrl();
        if ($orderInfo['order_type'] == Orders::ORDER_WALLET_RECHARGE) {
            $cancelBtnUrl = CommonHelper::getPaymentFailurePageUrl();
        }

        $this->set('cancelBtnUrl', $cancelBtnUrl);
        $this->set('orderInfo', $orderInfo);
        $this->set('paymentAmount', $paymentAmount);
        $this->set('exculdeMainHeaderDiv', true);
        $this->_template->addCss('css/payment.css');
        $this->_template->render(true, false);
    }

    public function send($orderId)
    {
        $pmObj=new PaymentSettings($this->keyName);
        $paymentSettings=$pmObj->getPaymentSettings();

        $post = FatApp::getPostedData();
        $orderPaymentObj=new OrderPayment($orderId, $this->siteLangId);
        /* Retrieve Payment to charge corresponding to your order */
        $orderPaymentAamount=$orderPaymentObj->getOrderPaymentGatewayAmount();
        if ($orderPaymentAamount>0) {
            /* Retrieve Primary Info corresponding to your order */
            $orderInfo=$orderPaymentObj->getOrderPrimaryinfo();
            $orderActualPaid = number_format(round($orderPaymentAamount, 2), 2, ".", "");
            $actionUrl = (FatApp::getConfig('CONF_TRANSACTION_MODE', FatUtility::VAR_BOOLEAN, false) == true)?$this->liveEnvironmentUrl:$this->testEnvironmentUrl;

            $data = array();
            $data['x_login'] = $paymentSettings['login_id'];
            $data['x_tran_key'] = $paymentSettings['transaction_key'];
            $data['x_version'] = '3.1';
            $data['x_delim_data'] = 'true';
            $data['x_delim_char'] = '|';
            $data['x_encap_char'] = '"';
            $data['x_relay_response'] = 'false';
            $data['x_first_name'] = FatUtility::decodeHtmlEntities($orderInfo['customer_name'], ENT_QUOTES, 'UTF-8');
            $data['x_company'] = FatUtility::decodeHtmlEntities($orderInfo['customer_name'], ENT_QUOTES, 'UTF-8');
            $data['x_address'] = FatUtility::decodeHtmlEntities($orderInfo['customer_billing_address_1'], ENT_QUOTES, 'UTF-8').' '.FatUtility::decodeHtmlEntities($orderInfo['customer_billing_address_2'], ENT_QUOTES, 'UTF-8');
            $data['x_city'] = FatUtility::decodeHtmlEntities($orderInfo['customer_billing_city'], ENT_QUOTES, 'UTF-8');
            $data['x_state'] = FatUtility::decodeHtmlEntities($orderInfo['customer_billing_state'], ENT_QUOTES, 'UTF-8');
            $data['x_zip'] = FatUtility::decodeHtmlEntities($orderInfo['customer_billing_postcode'], ENT_QUOTES, 'UTF-8');
            $data['x_country'] = FatUtility::decodeHtmlEntities($orderInfo['customer_billing_country'], ENT_QUOTES, 'UTF-8');
            $data['x_phone'] = $orderInfo['customer_phone'];
            /* $data['x_customer_ip'] = $this->request->server['REMOTE_ADDR']; */
            $data['x_customer_ip'] = $_SERVER['REMOTE_ADDR'];
            $data['x_email'] = $orderInfo['customer_email'];
            $orderPaymentGatewayDescription=sprintf(Labels::getLabel("MSG_Order_Payment_Gateway_Description", $this->siteLangId), $orderInfo["site_system_name"], $orderInfo['invoice']);
            $data['x_description'] = FatUtility::decodeHtmlEntities($orderPaymentGatewayDescription, ENT_QUOTES, 'UTF-8');
            $data['x_amount'] = $orderActualPaid;
            $data['x_currency_code'] = $orderInfo["order_currency_code"];
            $data['x_method'] = 'CC';
            $data['x_type'] = 'AUTH_CAPTURE';
            $data['x_card_num'] = str_replace(' ', '', $post['cc_number']);
            $data['x_exp_date'] = $post['cc_expire_date_month'] . $post['cc_expire_date_year'];
            $data['x_card_code'] = $post['cc_cvv'];
            $data['x_invoice_num'] = $orderId;
            $data['x_solution_id'] = 'A1000015';

            /* Customer Shipping Address Fields[ */
            $data['x_ship_to_first_name'] = FatUtility::decodeHtmlEntities($orderInfo['customer_shipping_name'], ENT_QUOTES, 'UTF-8');
            $data['x_ship_to_company'] = FatUtility::decodeHtmlEntities($orderInfo['customer_shipping_name'], ENT_QUOTES, 'UTF-8');
            $data['x_ship_to_address'] = FatUtility::decodeHtmlEntities($orderInfo['customer_shipping_address_1'], ENT_QUOTES, 'UTF-8') . ' ' . FatUtility::decodeHtmlEntities($orderInfo['customer_shipping_address_2'], ENT_QUOTES, 'UTF-8');
            $data['x_ship_to_city'] = FatUtility::decodeHtmlEntities($orderInfo['customer_shipping_city'], ENT_QUOTES, 'UTF-8');
            $data['x_ship_to_state'] = FatUtility::decodeHtmlEntities($orderInfo['customer_shipping_state'], ENT_QUOTES, 'UTF-8');
            $data['x_ship_to_zip'] = FatUtility::decodeHtmlEntities($orderInfo['customer_shipping_postcode'], ENT_QUOTES, 'UTF-8');
            $data['x_ship_to_country'] = FatUtility::decodeHtmlEntities($orderInfo['customer_shipping_country'], ENT_QUOTES, 'UTF-8');
            /* ] */

            if (FatApp::getConfig('CONF_TRANSACTION_MODE', FatUtility::VAR_BOOLEAN, false) == true) {
                $data['x_test_request'] = 'true';
            }

            $curl = curl_init($actionUrl);
            curl_setopt($curl, CURLOPT_PORT, 443);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FORBID_REUSE, 1);
            curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));
            $response = curl_exec($curl);

            $json = array();
            if (curl_error($curl)) {
                /* $json['error'] = 'CURL ERROR: ' . curl_errno($curl) . '::' . curl_error($curl); */
                $json['error'] = Labels::getLabel('MSG_Payment_cannot_be_processed_right_now._Please_try_after_some_time.', $this->siteLangId);
            } elseif ($response) {
                $i = 1;
                $responseInfo = array();
                $results = explode('|', $response);
                foreach ($results as $result) {
                    $responseInfo[$i] = trim($result, '"');
                    $i++;
                }
                if ($responseInfo[1] == '1') {
                    $message = '';
                    if (isset($responseInfo['5'])) {
                        $message .= 'Authorization Code: ' . $responseInfo['5'] . "\n";
                    }
                    if (isset($responseInfo['6'])) {
                        $message .= 'AVS Response: ' . $responseInfo['6'] . "\n";
                    }
                    if (isset($responseInfo['7'])) {
                        $message .= 'Transaction ID: ' . $responseInfo['7'] . "\n";
                    }
                    if (isset($responseInfo['39'])) {
                        $message .= 'Card Code Response: ' . $responseInfo['39'] . "\n";
                    }
                    if (isset($responseInfo['40'])) {
                        $message .= 'Cardholder Authentication Verification Response: ' . $responseInfo['40'] . "\n";
                    }

                    if (!$paymentSettings['md5_hash'] || (strtoupper($responseInfo[38]) == strtoupper(md5($paymentSettings['md5_hash'].$paymentSettings['login_id'].$responseInfo[7] . $orderActualPaid)))) {
                        /* Recording Payment in DB */
                        if (!$orderPaymentObj->addOrderPayment($paymentSettings["pmethod_name"], $responseInfo['7'], $orderPaymentAamount, Labels::getLabel("MSG_Received_Payment", $this->siteLangId), $message)) {
                            $json['error'] = "Invalid Action";
                        }
                        /* End Recording Payment in DB */
                    } else {
                        /*  Do what ever you want to do */
                    }
                    $json['redirect'] = CommonHelper::generateUrl('custom', 'paymentSuccess', array($orderId));
                } else {
                    $json['error'] = $responseInfo[4];
                }
            } else {
                $json['error'] = Labels::getLabel('MSG_EMPTY_GATEWAY_RESPONSE', $this->siteLangId);
            }
        } else {
            $json['error'] = Labels::getLabel('MSG_Invalid_Request', $this->siteLangId);
        }
        curl_close($curl);

        echo json_encode($json);
    }

    public function checkCardType()
    {
        $post = FatApp::getPostedData();
        $res=ValidateElement::ccNumber($post['cc']);
        echo json_encode($res);
        exit;
    }

    private function getPaymentForm($orderId = '')
    {
        $frm = new Form('frmPaymentForm', array('id'=>'frmPaymentForm','action'=>CommonHelper::generateUrl('AuthorizeAimPay', 'send', array($orderId)), 'class' =>"form form--normal"));
        $frm->addRequiredField(Labels::getLabel('LBL_ENTER_CREDIT_CARD_NUMBER', $this->siteLangId), 'cc_number');
        $frm->addRequiredField(Labels::getLabel('LBL_CARD_HOLDER_NAME', $this->siteLangId), 'cc_owner');
        $data['months'] = applicationConstants::getMonthsArr($this->siteLangId);
        $today = getdate();
        $data['year_expire'] = array();
        for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
            $data['year_expire'][strftime('%Y', mktime(0, 0, 0, 1, 1, $i))] = strftime('%Y', mktime(0, 0, 0, 1, 1, $i));
        }
        $frm->addSelectBox(Labels::getLabel('LBL_EXPIRY_MONTH', $this->siteLangId), 'cc_expire_date_month', $data['months'], '', array(), '');
        $frm->addSelectBox(Labels::getLabel('LBL_EXPIRY_YEAR', $this->siteLangId), 'cc_expire_date_year', $data['year_expire'], '', array(), '');
        $frm->addPasswordField(Labels::getLabel('LBL_CVV_SECURITY_CODE', $this->siteLangId), 'cc_cvv')->requirements()->setRequired(true);
        /* $frm->addCheckBox(Labels::getLabel('LBL_SAVE_THIS_CARD_FOR_FASTER_CHECKOUT',$this->siteLangId), 'cc_save_card','1'); */
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Pay_Now', $this->siteLangId));
        return $frm;
    }
}
