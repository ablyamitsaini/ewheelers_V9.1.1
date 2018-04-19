<?php
class CashOnDeliveryPayController extends MyAppController{
	private $keyName = "CashOnDelivery";
	
	public function charge( $orderId ){
		$orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
		$paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
		$orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
		if( !$orderInfo || $orderInfo["order_is_paid"] == Orders::ORDER_IS_PAID ){
			Message::addErrorMessage( Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED',$this->siteLangId) );
			FatApp::redirectUser( CommonHelper::generateUrl( 'Buyer', 'ViewOrder', array($orderInfo['id']) ) );
		}
		
		/* Partial Payment is not allowed, Wallet + COD, So, disabling COD in case of Partial Payment Wallet Selected. [ */
		if( $orderInfo['order_wallet_amount_charge'] > 0 && $paymentAmount > 0 ){
			$str = Labels::getLabel('MSG_Wallet_can_not_be_used_along_with_{COD}', $this->siteLangId );
			$str = str_replace( '{cod}', $this->keyName, $str );
			Message::addErrorMessage( $str );
			FatApp::redirectUser( CommonHelper::generateUrl( 'Buyer', 'ViewOrder', array($orderInfo['id']) ) );
		}
		/* ] */
				
		$orderPaymentObj->confirmCodOrder($orderId,$this->siteLangId);	
		
		FatApp::redirectUser( CommonHelper::generateFullUrl( 'custom', 'paymentSuccess', array( $orderInfo['id']) ) );
	}
	
	/* private function getPaymentSettings(){
		$pmObj = new PaymentSettings($this->keyName);
		return $pmObj->getPaymentSettings();
	} */
	
	/* private function validateCashOnDeliverySettings($paymentSettings = array()){		
		$settingVal = array('child_order_status_initial');
		foreach($settingVal as $val){			
			if( !isset($paymentSettings[$val]) || strlen( trim( $paymentSettings[$val] ) ) == 0 ){
				return false;
			}
		}
		return true;
	} */
}
?>
