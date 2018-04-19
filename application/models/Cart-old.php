<?php
class Cart extends FatModel {
	private $products = array();
	private $SYSTEM_ARR = array();
	private $warning;
	public function __construct( $user_id = 0, $langId = 0) {
		parent::__construct();
		$user_id = FatUtility::int($user_id);
		$langId = FatUtility::int($langId);
		
		$this->cart_lang_id = $langId;
		if(1 > $langId){
			$this->cart_lang_id = CommonHelper::getLangId();	
		}		
		
		$this->cart_user_id = session_id();
		if ( UserAuthentication::isUserLogged() || ( $user_id > 0 ) ){
			$this->cart_user_id= UserAuthentication::getLoggedUserId();
			if ( $user_id > 0 ){
				$this->cart_user_id = $user_id;
			}
		}
		
		if ( isset($this->cart_user_id) ) {
			$srch = new SearchBase('tbl_user_cart');
			$srch->addCondition('usercart_user_id', '=', $this->cart_user_id );
			$rs = $srch->getResultSet();
			if( $row = FatApp::getDb()->fetch($rs) ){
				$this->SYSTEM_ARR['cart'] = unserialize( $row["usercart_details"] );
				
				if( isset($this->SYSTEM_ARR['cart']['shopping_cart']) ){
					$this->SYSTEM_ARR['shopping_cart']=$this->SYSTEM_ARR['cart']['shopping_cart'];
					unset($this->SYSTEM_ARR['cart']['shopping_cart']);
				}
			}
        }
		
		if ( !isset($this->SYSTEM_ARR['cart']) || !is_array($this->SYSTEM_ARR['cart']) ) {
			$this->SYSTEM_ARR['cart'] = array();
			
		}
		if( !isset($this->SYSTEM_ARR['shopping_cart']) || !is_array($this->SYSTEM_ARR['shopping_cart']) ){
			$this->SYSTEM_ARR['shopping_cart'] = array();
		}
		/* echo '<pre>';
		print_r($this->SYSTEM_ARR['cart']);
		echo '</pre>'; */
	}
	
	public function add( $selprod_id, $qty = 1 ){
		$this->products = array();
		$product['selprod_id'] = FatUtility::int($selprod_id);

		$key = base64_encode(serialize($product));
		if ( (int)$qty && ((int)$qty > 0) ) {
			if (!isset($this->SYSTEM_ARR['cart'][$key])) {
				$this->SYSTEM_ARR['cart'][$key] = FatUtility::int($qty);
			} else {
				$this->SYSTEM_ARR['cart'][$key] += FatUtility::int($qty);
			}
		}
		$this->updateTempStockHold($product['selprod_id'], $this->SYSTEM_ARR['cart'][$key] );
		
		$this->updateUserCart();
		return true;
	}
	
	public function countProducts() {
		return count($this->SYSTEM_ARR['cart']);
	}
	
	public function hasProducts() {
		return count($this->SYSTEM_ARR['cart']);
	}
	
	public function hasStock() {
		$stock = true;
		foreach ($this->getProducts($this->cart_lang_id) as $product) {
			if ( !$product['in_stock'] ) {
				$stock = false;
				break;
			}
		}
		return $stock;
	}
	
	public function hasDigitalProduct(){
		$isDigital = false;
		foreach ($this->getProducts($this->cart_lang_id) as $product) {
			if( $product['is_digital_product'] ){
				$isDigital = true;
				break;
			}
		}
		$this->products = array();
		return $isDigital;
	}
	
	public function hasPhysicalProduct(){
		$isPhysical = false;
		foreach ($this->getProducts($this->cart_lang_id) as $product) {
			if( $product['is_physical_product'] ){
				$isPhysical = true;
				break;
			}
		}
		$this->products = array();
		return $isPhysical;
	}
	
	public function getProducts( $siteLangId = 0 ){
		/* if( !$siteLangId ){
			trigger_error("Language Id not specified.", E_USER_ERROR);
		} */
		if (!$this->products) {
			
			$productSelectedShippingMethodsArr = $this->getProductShippingMethod();
			
			$db = FatApp::getDb();
			$selprodIdsArr = array();
			$maxConfiguredCommissionVal = FatApp::getConfig("CONF_MAX_COMMISSION");
			foreach ($this->SYSTEM_ARR['cart'] as $key => $quantity) {
				
				$product = array();
				$product = unserialize(base64_decode($key));
			
				$selprod_id = FatUtility::int($product['selprod_id']);
				$prodSrch = new ProductSearch( $siteLangId );
				$prodSrch->setDefinedCriteria();
				$prodSrch->joinProductToCategory();
				$prodSrch->doNotCalculateRecords();
				$prodSrch->doNotLimitRecords();
				$prodSrch->addCondition('selprod_id', '=', $selprod_id );
				$fields1 = array( 'product_id', 'product_type', 'product_length', 'product_width', 'product_height', 
				'product_dimension_unit', 'product_weight', 'product_weight_unit', 
				'selprod_id','selprod_code', 'selprod_stock','selprod_user_id','IF(selprod_stock > 0, 1, 0) AS in_stock',
				'special_price_found', 'theprice', 'shop_id', 
				'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type', 'selprod_price');
				$fields2 = array();
				if( $siteLangId ){
					$prodSrch->joinBrands();
					$fields2 = array('product_name','selprod_title','brand_name','shop_name');
				}
				$fields = array_merge($fields1, $fields2);
				$prodSrch->addMultipleFields( $fields  );
				$rs = $prodSrch->getResultSet();
				$sellerProductRow = $db->fetch($rs);
				if( !$sellerProductRow ){
					$this->removeCartKey($key);
					continue;
				}
				if(($quantity > $sellerProductRow['selprod_stock']))
				{
					// $this->warning = Labels::getLabel('MSG_Requested_quantity_more_than_stock_available', $this->cart_lang_id);
					$quantity = $sellerProductRow['selprod_stock'];
				}
				
				$this->products[$key] = $sellerProductRow;
				$this->products[$key]['key'] = $key;
				
				/* set variable of shipping cost of the product, if shipping already selected[ */
				$this->products[$key]['shipping_cost'] = 0;
				$this->products[$key]['sduration_id'] = 0;
				if( !empty($productSelectedShippingMethodsArr) && isset($productSelectedShippingMethodsArr[$sellerProductRow['selprod_id']]) ){
					$shippingDurationRow = $productSelectedShippingMethodsArr[$sellerProductRow['selprod_id']];
					$this->products[$key]['sduration_id'] = $shippingDurationRow['sduration_id'];
					$this->products[$key]['shipping_cost'] = ROUND(($shippingDurationRow['mshipapi_cost'] * $quantity), 2);
				}
				/* ] */
				
				/* calculation of commission against each product[ */
				$commission = 0;
				$tax = 0;
				$commissionPercentage = SellerProduct::getProductCommission( $sellerProductRow['selprod_id'] );
				//echo $sellerProductRow['theprice']; die();
				$commission = MIN( ROUND( $sellerProductRow['theprice'] * $commissionPercentage/100, 2 ), $maxConfiguredCommissionVal );
				$this->products[$key]['commission_percentage'] = $commissionPercentage;
				$this->products[$key]['commission'] = ROUND( $commission * $quantity, 2 );
				
				$this->products[$key]['quantity'] = $quantity;
				
				$totalPrice = $sellerProductRow['theprice'] * $quantity;
				//echo $sellerProductRow['product_id'].'-'.$totalPrice.'-'.$sellerProductRow['selprod_user_id'].'-'.$siteLangId.'-<br>';
				$taxObj = new Tax();
				$tax = $taxObj->calculateTaxRates($sellerProductRow['product_id'],$sellerProductRow['theprice'],$sellerProductRow['selprod_user_id'],$siteLangId,$quantity);
				
				$this->products[$key]['tax'] = $tax;
				$this->products[$key]['total'] = $totalPrice;
				$this->products[$key]['netTotal'] = $this->products[$key]['total'] + $this->products[$key]['shipping_cost'];
				
				$this->products[$key]['is_digital_product'] = ($sellerProductRow['product_type'] == Product::PRODUCT_TYPE_DIGITAL) ? 1 : 0;
				$this->products[$key]['is_physical_product'] = ($sellerProductRow['product_type'] == Product::PRODUCT_TYPE_PHYSICAL) ? 1 : 0;
				
				if( $siteLangId ){
					$this->products[$key]['options'] = SellerProduct::getSellerProductOptions($selprod_id, true, $siteLangId);
				} else {
					$this->products[$key]['options'] = SellerProduct::getSellerProductOptions($selprod_id, false);
				}
				//CommonHelper::printArray($this->products);
			}
		}
		return $this->products;
	}
	
	public function removeCartKey($key) {
		unset($this->SYSTEM_ARR['cart'][$key]);
		$this->updateUserCart();
		return true;
	}
	
	public function remove($key){
		$this->products = array();
		$cartProducts = $this->getProducts($this->cart_lang_id);
			
		if( is_array($cartProducts) ){
			foreach($cartProducts as $cartKey=>$product){
				if( md5($product['key']) == $key ){
					unset($this->SYSTEM_ARR['cart'][$cartKey]);
					
					/* to keep track of temporary hold the product stock[ */
					$this->updateTempStockHold($product['selprod_id'], 0);
					/* ] */
					break;
				}
			}
		}
		$this->updateUserCart();
		return true;
	}
	
	public function getWarning(){
		return $this->warning;
	}
	
	public function update($key, $quantity){
		$quantity = FatUtility::int($quantity);
		if ( $quantity > 0 ){
			$cartProducts = $this->getProducts($this->cart_lang_id);
			/* CommonHelper::printArray($cartProducts);
			die(); */
			if( is_array($cartProducts) ){
				foreach($cartProducts as $cartKey => $product){
					if( md5($product['key']) == $key ){
						if( $cartProducts[$cartKey]['selprod_stock'] < $quantity ){
							$this->warning = Labels::getLabel('MSG_Requested_quantity_more_than_stock_available', $this->cart_lang_id);
							$quantity = $cartProducts[$cartKey]['selprod_stock'];
						}
						if( $quantity ){
							$this->SYSTEM_ARR['cart'][$cartKey] = $quantity;
							/* to keep track of temporary hold the product stock[ */
							$this->updateTempStockHold($product['selprod_id'], $quantity);
							/* ] */
							break;
						} else {
							$this->remove($key);
						}
					}
				}
			}
			$this->updateUserCart();
		}
		return true;
	}
	
	public function setCartBillingAddress($address_id) {
		$this->SYSTEM_ARR['shopping_cart']['billing_address_id'] = $address_id;
		$this->updateUserCart();
		return true;
	}
	
	public function setCartShippingAddress($address_id) {
		$this->SYSTEM_ARR['shopping_cart']['shipping_address_id'] = $address_id;
		$this->updateUserCart();
		return true;
	}
	
	public function setShippingAddressSameAsBilling(){
		$billing_address_id = $this->getCartBillingAddress();
		if( $billing_address_id ){
			$this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling'] = true;
		}
	}
	
	public function unSetShippingAddressSameAsBilling(){
		if( isset($this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling']) ){
			unset($this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling']);
		}
	}
	
	public function setCartShippingApi($shippingapi_id){
		$this->SYSTEM_ARR['shopping_cart']['shippingapi_id'] = FatUtility::int( $shippingapi_id );
		$this->updateUserCart();
		return true;
	}
	
	public function getCartBillingAddress(){
		return isset($this->SYSTEM_ARR['shopping_cart']['billing_address_id']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['billing_address_id']) : 0;
	}
	
	public function getCartShippingAddress(){
		return isset($this->SYSTEM_ARR['shopping_cart']['shipping_address_id']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['shipping_address_id']) : 0;
	}
	
	public function getCartShippingApi(){
		return isset($this->SYSTEM_ARR['shopping_cart']['shippingapi_id']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['shippingapi_id']) : 0;
	}
	
	public function getShippingAddressSameAsBilling(){
		return isset($this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling']) ? FatUtility::int($this->SYSTEM_ARR['shopping_cart']['isShippingSameAsBilling']) : 0;
	}
	
	public function setProductShippingMethod( $arr ){
		$this->SYSTEM_ARR['shopping_cart']['product_shipping_methods'] = $arr;
		$this->updateUserCart();
		return true;
	}
	
	public function getProductShippingMethod(){
		return isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']) ? $this->SYSTEM_ARR['shopping_cart']['product_shipping_methods'] : array();
	}
	
	public function isProductShippingMethodSet(){
		foreach( $this->getProducts($this->cart_lang_id) as $product ){
			
			if( $product['is_physical_product'] && !isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods'][$product['selprod_id']]) ){
				return false;
			}
			
			if(isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods'][$product['selprod_id']]['mshipapi_id'])){
				$mshipapi_id = $this->SYSTEM_ARR['shopping_cart']['product_shipping_methods'][$product['selprod_id']]['mshipapi_id'];
				$manualShipingApiRow = ManualShippingApi::getAttributesById($mshipapi_id, 'mshipapi_id');
				if( !$manualShipingApiRow ){
					return false;
				}	
			} 			
		}
		return true;
	}
	
	public function getCartFinancialSummary($langId){
		$products = $this->getProducts($langId);
		$cartProductPriceTotal = 0;
		$cartTotal = 0;
		$shippingTotal = 0;
		//$netTotalWithoutDiscount = 0;
		//$netTotalAfterDiscount = 0;
		$orderPaymentGatewayCharges = 0;
		$cartTaxTotal = 0;
		$cartDiscounts = self::getCouponDiscounts();
		$totalSiteCommission = 0;
		$orderNetAmount = 0;
		if( is_array($products) && count($products) ){
			foreach( $products as $product ){
				$cartProductPriceTotal += $product['theprice'];
				$cartTotal += $product['total'];
				$cartTaxTotal += $product['tax'];
				$shippingTotal += $product['shipping_cost'];
				//$netTotalWithoutDiscount += $product['netTotal'];
				$totalSiteCommission += $product['commission'];
			}
		}
		//$netTotalAfterDiscount = $netTotalWithoutDiscount;
		$userWalletBalance = User::getUserBalance( $this->cart_user_id );
		//$orderCreditsCharge = $this->isCartUserWalletSelected() ? min($netTotalAfterDiscount, $userWalletBalance) : 0;
		//$orderPaymentGatewayCharges = $netTotalAfterDiscount - $orderCreditsCharge;
		
		$totalDiscountAmount = (isset($cartDiscounts['coupon_discount_total'])) ? $cartDiscounts['coupon_discount_total'] : 0;
		$orderNetAmount = ( $cartTotal + $shippingTotal + $cartTaxTotal ) - $totalDiscountAmount;
		
		$WalletAmountCharge = ( $this->isCartUserWalletSelected() ) ? min( $orderNetAmount, $userWalletBalance ) : 0;
		$orderPaymentGatewayCharges = $orderNetAmount - $WalletAmountCharge;
		/* $cartSummary = array(
			'cartProductPriceTotal'  => $cartProductPriceTotal,
			'cartTotal'		=>	$cartTotal,
			'shippingTotal'	=>	$shippingTotal,
			'cartTaxTotal'	=>	$cartTaxTotal,
			'cartDiscounts'	=>	$cartDiscounts,
			'netTotalWithoutDiscount' => $netTotalWithoutDiscount,
			'netTotalAfterDiscount' => $netTotalAfterDiscount,
			'cartWalletSelected'	=>	$this->isCartUserWalletSelected(),
			'siteCommission' => $totalSiteCommission,
			'cartActualPaid' => max(round($netTotalAfterDiscount,2),0),
			'items'  => $this->countProducts(),
			'orderPaymentGatewayCharges' => $orderPaymentGatewayCharges,
			'orderNetAmount'	=>	$orderNetAmount,
			'WalletAmountCharge' => $WalletAmountCharge
		); */
		$cartSummary = array(
			'cartProductPriceTotal'  => $cartProductPriceTotal,
			'cartTotal'		=>	$cartTotal,
			'shippingTotal'	=>	$shippingTotal,
			'cartTaxTotal'	=>	$cartTaxTotal,
			'cartDiscounts'	=>	$cartDiscounts,
			'cartWalletSelected'	=>	$this->isCartUserWalletSelected(),
			'siteCommission' => $totalSiteCommission,
			'orderNetAmount'	=>	$orderNetAmount,
			'WalletAmountCharge' => $WalletAmountCharge,
			'orderPaymentGatewayCharges' => $orderPaymentGatewayCharges,
		);
		
		return $cartSummary;
	}
	
	public function getCouponDiscounts(){
		$coupon_data = array(
			'coupon_code'      		=>	'',
			'coupon_discount_type'	=>	'',
			'coupon_discount_value' =>	0,
			'coupon_discount_total'	=>	0
		);
		return $coupon_data;
	}
	
	public function updateCartWalletOption($val) {
		$this->SYSTEM_ARR['shopping_cart']['Pay_from_wallet'] = $val;
		$this->updateUserCart();
		return true;
	}
	
	public function isCartUserWalletSelected() {
		return (isset($this->SYSTEM_ARR['shopping_cart']['Pay_from_wallet']) && intval($this->SYSTEM_ARR['shopping_cart']['Pay_from_wallet'])==1) ? 1: 0;
	}
	
	public function updateUserCart() {
		if (isset($this->cart_user_id)) {
			$record = new TableRecord('tbl_user_cart');
			$cart_arr = $this->SYSTEM_ARR['cart'];
			if (isset($this->SYSTEM_ARR['shopping_cart']) && is_array($this->SYSTEM_ARR['shopping_cart']) && (!empty($this->SYSTEM_ARR['shopping_cart']))){
				$cart_arr["shopping_cart"] = $this->SYSTEM_ARR['shopping_cart'];
			}
			$cart_arr = serialize($cart_arr);
			$record->assignValues( array("usercart_user_id" => $this->cart_user_id, "usercart_details" => $cart_arr ) );
			if( !$record->addNew( array(), array( 'usercart_details' => $cart_arr ) ) ){
				Message::addErrorMessage( $record->getError() );
				throw new Exception('');
			}
		}
	}
	
	/* to keep track of temporary hold the product stock[ */
	public function updateTempStockHold( $selprod_id, $quantity ){
		$selprod_id = FatUtility::int($selprod_id);
		$quantity = FatUtility::int($quantity);
		if( !$selprod_id ){
			return;
		}
		$db = FatApp::getDb();
		
		if( !$quantity ){
			$db->deleteRecords( 'tbl_product_stock_hold', array('smt'=>'pshold_selprod_id = ? AND pshold_user_id = ?', 'vals' => array($selprod_id, $this->cart_user_id)) );
			return;
		}
		
		$record = new TableRecord('tbl_product_stock_hold');
		$dataArrToSave = array( 'pshold_selprod_id' => $selprod_id, 'pshold_user_id' => $this->cart_user_id, 'pshold_selprod_stock' =>  $quantity, 'pshold_added_on' => date('Y-m-d H:i:s') );
		
		//$qty = isset($this->SYSTEM_ARR['cart'][$selprod_id]) ? FatUtility::int($this->SYSTEM_ARR['cart'][$selprod_id]) : 0;
		$dataUpdateOnDuplicate = array( 'pshold_selprod_stock' => $quantity, 'pshold_added_on' => date('Y-m-d H:i:s')  );
		$record->assignValues( $dataArrToSave );
		if( !$record->addNew( array(), $dataUpdateOnDuplicate ) ){
			Message::addErrorMessage( $record->getError() );
			throw new Exception('');
		}
		
		/* delete old records[ */
		$intervalInMinutes = FatApp::getConfig( 'cart_stock_hold_minutes', FatUtility::VAR_INT, 15 );
		$deleteQuery = "DELETE FROM tbl_product_stock_hold WHERE pshold_added_on < DATE_SUB(NOW(), INTERVAL ". $intervalInMinutes ." MINUTE)";
		$db->query( $deleteQuery );
		/* ] */
	}
	/* ] */
	
	public function clear() {
		$this->products = array();
		$this->SYSTEM_ARR['cart'] = array();
		$this->SYSTEM_ARR['shopping_cart'] = array();
		unset($_SESSION['shopping_cart']["order_id"]);
	}
	
	static function setCartAttributes( $userId = 0 ){
		$db = FatApp::getDb();
		
		/* to keep track of temporary hold the product stock[ */
		$cart_user_id = session_id();
		if ( UserAuthentication::isUserLogged()  ){
			$cart_user_id = UserAuthentication::getLoggedUserId();
		}
		$db->updateFromArray( 'tbl_product_stock_hold', array( 'pshold_user_id' => $cart_user_id ), array('smt' => 'pshold_user_id = ?', 'vals' => array(session_id()) ) );
		/* 	] */
		
		$userId = FatUtility::int($userId);
		if($userId == 0) { return false;}
		
		$srch = new SearchBase('tbl_user_cart');
		$srch->addCondition('usercart_user_id', '=', session_id() );
		$rs = $srch->getResultSet();
		
		if(!$row = FatApp::getDb()->fetch($rs) ){
			return false;
		}
		
		$cartInfo = unserialize( $row["usercart_details"] );
		
		$cartObj = new Cart($userId);
		
		foreach($cartInfo as $key => $quantity){
			$product = unserialize(base64_decode($key));
			$selprod_id = $product['selprod_id'];
			$cartObj->add($selprod_id, $quantity);	
			
			$db->deleteRecords('tbl_user_cart', array('smt'=>'`usercart_user_id`=?', 'vals'=>array(session_id())));
		}
		$cartObj->updateUserCart();
	}
}