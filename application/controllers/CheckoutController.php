<?php
class CheckoutController extends MyAppController{
	private $cartObj;
	
	public function __construct($action) {
		parent::__construct($action);
		$user_id = 0;
		if( UserAuthentication::isUserLogged() ){
			$user_is_buyer = User::getAttributesById( UserAuthentication::getLoggedUserId(), 'user_is_buyer' );
			if( !$user_is_buyer ){
				$errMsg = Labels::getLabel('MSG_Please_login_with_buyer_account', $this->siteLangId);
				Message::addErrorMessage( $errMsg );
				if ( FatUtility::isAjaxCall() ) {
					FatUtility::dieWithError( Message::getHtml() );
				}
				FatApp::redirectUser(CommonHelper::generateUrl('Cart'));
			}
			$user_id = UserAuthentication::getLoggedUserId();
		}
		$this->cartObj = new Cart( $user_id, $this->siteLangId );
		$this->set('exculdeMainHeaderDiv', true);
	}
	
	private function isEligibleForNextStep( &$criteria = array()){
		if( empty( $criteria ) ) return true;
		foreach( $criteria as $key => $val ) {
            switch( $key ) {
				case 'isUserLogged':
					if( !UserAuthentication::isUserLogged() ){
						$key = false;
						Message::addErrorMessage(Labels::getLabel('MSG_Your_Session_seems_to_be_expired.', $this->siteLangId));
						return false;
					}
				break;
				case 'hasProducts':
					if( !$this->cartObj->hasProducts() ){
						$key = false;
						Message::addErrorMessage(Labels::getLabel('MSG_Your_cart_seems_to_be_empty,_Please_try_after_reloading_the_page.', $this->siteLangId));
						return false;
					}
				break;
				case 'hasStock':
					/* if( !$this->cartObj->hasStock() ){
						$key = false;
						Message::addErrorMessage(Labels::getLabel('MSG_Products_are_out_of_stock', $this->siteLangId));
						return false;
					} */
					
					/* to check that product is temporary hold[ */
					$cart_user_id = Cart::getCartUserId();
					$intervalInMinutes = FatApp::getConfig( 'cart_stock_hold_minutes', FatUtility::VAR_INT, 15 );
					//$srch->addCondition('pshold_user_id', '!=', $cart_user_id);
					
					/* ] */
					
					$cartProducts = $this->cartObj->getProducts($this->siteLangId);
					//CommonHelper::printArray($cartProducts); exit;
					foreach ($cartProducts as $product) {
						if ( !$product['in_stock'] ) {
							$stock = false;
							$key = false;
							Message::addErrorMessage(Labels::getLabel('MSG_Products_are_out_of_stock', $this->siteLangId));
							return false;
							break;
						}
						
						if($product['is_batch'] && !empty($product['products'])){
							foreach( $product['products'] as $pgproduct ){ 
								$tempHoldStock = Product::tempHoldStockCount($pgproduct['selprod_id']);
								$availableStock = $pgproduct['selprod_stock'] - $tempHoldStock; 
								$userTempHoldStock = Product::tempHoldStockCount($pgproduct['selprod_id'],$cart_user_id,$product['prodgroup_id'],true);								
								if( $availableStock < ( $product['quantity'] - $userTempHoldStock)){							
									$key = false;
									$productName = ( isset($pgproduct['selprod_title']) && $pgproduct['selprod_title'] != '' ) ? $pgproduct['selprod_title'] : $pgproduct['name'];
									Message::addErrorMessage(str_replace('{product-name}',$productName,Labels::getLabel('MSG_{product-name}_is_temporary_out_of_stock_or_hold_by_other_customer', $this->siteLangId))); 
									return false;
								}								
							}
						}else{
							$tempHoldStock = Product::tempHoldStockCount($product['selprod_id']);
							$availableStock = $product['selprod_stock'] - $tempHoldStock; 
							$userTempHoldStock = Product::tempHoldStockCount($product['selprod_id'],$cart_user_id,0,true);
							if($availableStock < ( $product['quantity'] - $userTempHoldStock)){
								$key = false;
								$productName = ( isset($product['selprod_title']) && $product['selprod_title'] != '' ) ? $product['selprod_title'] : $product['name'];
								Message::addErrorMessage(str_replace('{product-name}',$productName,Labels::getLabel('MSG_{product-name}_is_temporary_out_of_stock_or_hold_by_other_customer', $this->siteLangId))); 
								return false;
							}							
						}
						
						/* $srch = new SearchBase('tbl_product_stock_hold');
						$srch->doNotCalculateRecords();
						$srch->addOrder('pshold_id', 'ASC');
						$srch->addCondition( 'pshold_added_on', '>=', 'mysql_func_DATE_SUB( NOW(), INTERVAL ' . $intervalInMinutes . ' MINUTE )', 'AND', true );
						$srch->addCondition( 'pshold_selprod_id', '=', $product['selprod_id'] );
						$srch->addOrder('pshold_id');
						$srch->setPageNumber(1);
						$srch->setPageSize(1);
						$rs = $srch->getResultSet();
						$stockHoldRow = FatApp::getDb()->fetch($rs);
						if( $stockHoldRow && ($stockHoldRow['pshold_user_id'] != $cart_user_id) && ($product['selprod_stock'] - $stockHoldRow['pshold_selprod_stock']) < $product['quantity'] ){
							$key = false;
							$productName = ( isset($product['selprod_title']) && $product['selprod_title'] != '' ) ? $product['selprod_title'] : $product['name'];
							Message::addErrorMessage($productName . " is temporary out of stock or hold by other customer, please try after some time.");
							return false;
						} */
						/* if( array_key_exists($product['selprod_id'], $rows ) && ($product['selprod_stock'] - $rows[$product['selprod_id']]['pshold_selprod_stock'] < $product['quantity'] ) ){
							$key = false;
							Message::addErrorMessage("Product Stock is currently hold by some other user, please try after some time.");
							return false;
						} */
					}
				break;
				case 'hasBillingAddress':
					if( !$this->cartObj->getCartBillingAddress() ){
						$key = false;
						Message::addErrorMessage( Labels::getLabel('MSG_Billing_Address_is_not_provided.', $this->siteLangId) );
						return false;
					}
				break;
				case 'hasShippingAddress':
					if( !$this->cartObj->getCartShippingAddress() ){
						$key = false;
						Message::addErrorMessage( Labels::getLabel('MSG_Shipping_Address_is_not_provided.', $this->siteLangId) );
						return false;
					}
				break;
				case 'isProductShippingMethodSet':
					if( !$this->cartObj->isProductShippingMethodSet() ){
						$key = false;
						Message::addErrorMessage(Labels::getLabel('MSG_Shipping_Method_is_not_selected_on_products_in_cart', $this->siteLangId));
						return false;
					}
				break;
			}
		}
		return true;
	}
	
	public function index($appParam = '',$appLang = '1',$appCurrency = '1'){
		if ($appParam == 'api'){
			$langId =  FatUtility::int($appLang); 
			if(0 < $langId ){ 
				$languages = Language::getAllNames();
				if(array_key_exists($langId,$languages)){ 		
					setcookie('defaultSiteLang', $langId, time()+3600*24*10,'/');
				}			
			}
		
			$currencyId =  FatUtility::int($appCurrency); 
			$currencyObj = new Currency();
			if(0 < $currencyId ){ 
				$currencies = Currency::getCurrencyAssoc($this->siteLangId);
				if(array_key_exists($currencyId,$currencies)){ 		
					setcookie('defaultSiteCurrency', $currencyId, time()+3600*24*10,'/');
				}				
			}
			commonhelper::setAppUser();
			FatApp::redirectUser(CommonHelper::generateUrl('checkout','index'));
		}
		
		$criteria = array('hasProducts' => true, 'hasStock' => true);
		if( !$this->isEligibleForNextStep( $criteria ) ){
			FatApp::redirectUser(CommonHelper::generateUrl('cart'));
		}
		$cartHasPhysicalProduct = false;
		if( $this->cartObj->hasPhysicalProduct() ){
			$cartHasPhysicalProduct = true;
		}
		
		$products = $this->cartObj->getProducts($this->siteLangId);
		$this->set('products', $products );
		$this->cartObj->removeProductShippingMethod( );
		$this->set('cartHasPhysicalProduct', $cartHasPhysicalProduct);
		$this->set('cartSummary', $this->cartObj->getCartFinancialSummary($this->siteLangId) );
		$obj = new Extrapage();
		$pageData = $obj->getContentByPageType( Extrapage::CHECKOUT_PAGE_RIGHT_BLOCK, $this->siteLangId );
		$this->set('pageData' , $pageData);
		$this->_template->render(true,false);
	}
	
	public function loadLoginDiv(){
		$this->_template->render( false, false );
	}
	
	public function login(){
		$loginFormData = array(
			'loginFrm' 		=> $this->getLoginForm(),
			'siteLangId'	=> $this->siteLangId,
			'showSignUpLink' => true,
			'onSubmitFunctionName' => 'setUpLogin'
		);
		$this->set('loginFormData', $loginFormData);
		
		$cPageSrch = ContentPage::getSearchObject($this->siteLangId);
		$cPageSrch->addCondition('cpage_id','=',FatApp::getConfig('CONF_TERMS_AND_CONDITIONS_PAGE' , FatUtility::VAR_INT , 0));
		$cpage = FatApp::getDb()->fetch($cPageSrch->getResultSet());
		if(!empty($cpage) && is_array($cpage)) {
			$termsAndConditionsLinkHref = CommonHelper::generateUrl('Cms','view',array($cpage['cpage_id']));
		} else {
			$termsAndConditionsLinkHref = 'javascript:void(0)';
		}
		
		$signUpFrm = $this->getRegistrationForm( false );
		$signUpFrm->addHiddenField('', 'isCheckOutPage', 1);
		
		$signUpFormData = array(
			'frm'			=>	$signUpFrm,
			'siteLangId'	=>	$this->siteLangId,
			'showLogInLink' => false,
			'onSubmitFunctionName'		=>	'setUpRegisteration',
			'termsAndConditionsLinkHref'=> $termsAndConditionsLinkHref,
		);
		
		$this->set( 'signUpFormData', $signUpFormData );
		$this->_template->render( false, false);
	}
	
	public function addresses(){
		$criteria = array( 'isUserLogged' => true );
		$cartObj = new Cart();
		if( !$this->isEligibleForNextStep( $criteria ) ){
			$this->set('redirectUrl', CommonHelper::generateUrl('GuestUser','LoginForm'));
			Message::addErrorMessage(Labels::getLabel('MSG_Your_Session_seems_to_be_expired.', $this->siteLangId));
			FatUtility::dieWithError( Message::getHtml() );
		}
		$addressFrm = $this->getUserAddressForm( $this->siteLangId );
		$addresses = UserAddress::getUserAddresses( UserAuthentication::getLoggedUserId(), $this->siteLangId );
		
		$cartHasPhysicalProduct = false;
		if( $cartObj->hasPhysicalProduct() ){
			$cartHasPhysicalProduct = true;
		}
		$cart_products = $this->cartObj->getProducts($this->siteLangId);
		if(count($cart_products)==0){
			Message::addErrorMessage(Labels::getLabel('MSG_Your_Cart_is_empty.', $this->siteLangId));
				FatUtility::dieWithError(Message::getHtml());
		}
		
		$selected_billing_address_id = $cartObj->getCartBillingAddress();
		$selected_shipping_address_id = $cartObj->getCartShippingAddress();
		
		$this->set('selected_billing_address_id', $selected_billing_address_id);
		$this->set('selected_shipping_address_id', $selected_shipping_address_id);
		
		$isShippingSameAsBilling = $cartObj->getShippingAddressSameAsBilling();
		$this->set( 'isShippingSameAsBilling', $isShippingSameAsBilling );
		$this->set( 'cartHasPhysicalProduct', $cartHasPhysicalProduct );
		$this->set( 'addresses', $addresses );
		$this->set('stateId', 0 );
		$this->set('addressFrm', $addressFrm);
		$this->set('checkoutAddressFrm', $this->getCheckoutAddressForm( $this->siteLangId ) );
		$this->_template->render( false, false);
	}
	
	public function loadBillingShippingAddress(){
		$cartObj = new Cart();
		$selected_shipping_address_id = $cartObj->getCartShippingAddress();
		$address =  UserAddress::getUserAddresses( UserAuthentication::getLoggedUserId(), $this->siteLangId, 0,$selected_shipping_address_id );
		$hasPhysicalProduct = $this->cartObj->hasPhysicalProduct();
	
		$this->set('hasPhysicalProduct', $hasPhysicalProduct );
		if(!$hasPhysicalProduct){
				$selected_billing_address_id = $cartObj->getCartBillingAddress();
				$address =  UserAddress::getUserAddresses( UserAuthentication::getLoggedUserId(), $this->siteLangId, 0,$selected_billing_address_id );
		}
		$this->set('defaultAddress', $address );
		$this->_template->render( false, false);
	}
	
	public function setUpAddressSelection(){
		if( !UserAuthentication::isUserLogged() ){
			$this->set('redirectUrl', CommonHelper::generateUrl('GuestUser','LoginForm'));
			Message::addErrorMessage(Labels::getLabel('MSG_Your_Session_seems_to_be_expired.', $this->siteLangId));
			FatUtility::dieWithError( Message::getHtml() );
		}
		$post = FatApp::getPostedData();
		$shipping_address_id = FatUtility::int($post['shipping_address_id']);
	
		$billing_address_id = FatUtility::int($post['billing_address_id']);
		$isShippingSameAsBilling = isset($post['isShippingSameAsBilling']) ? FatUtility::int($post['isShippingSameAsBilling']) : 0;
		
		// Validate cart has products and has stock.
		//$this->cartObj = new Cart();
		$hasProducts = $this->cartObj->hasProducts();
		$hasStock = $this->cartObj->hasStock();
		
		if ( (!$hasProducts) || ( !$hasStock ) ) {
			$this->set('redirectUrl', CommonHelper::generateUrl('cart') );
			Message::addErrorMessage(Labels::getLabel('MSG_Cart_seems_to_be_empty_or_products_are_out_of_stock', $this->siteLangId));
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$hasPhysicalProduct = $this->cartObj->hasPhysicalProduct();
		
		if( !$billing_address_id ){
			Message::addErrorMessage( Labels::getLabel('MSG_Please_select_Billing_address', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if( $hasPhysicalProduct && !$shipping_address_id ){
			$this->set('loadAddressDiv', true );
			/* $this->set( 'msg', Labels::getLabel('MSG_Please_select_shipping_address', $this->siteLangId) );
			$this->_template->render(false, false, 'json-success.php'); */
			Message::addErrorMessage( Labels::getLabel('MSG_Please_select_shipping_address', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		/* setup billing address[ */
		$BillingAddressDetail = UserAddress::getUserAddresses( UserAuthentication::getLoggedUserId(), 0, 0, $billing_address_id );
		if( !$BillingAddressDetail ){
			Message::addErrorMessage( Labels::getLabel('MSG_ACTION_TRYING_PERFORM_NOT_VALID', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		$this->cartObj->setCartBillingAddress( $BillingAddressDetail['ua_id']);
		
		/* ] */
		
		if( $hasPhysicalProduct && $shipping_address_id ){
			if( $isShippingSameAsBilling ){ 
				$this->cartObj->setShippingAddressSameAsBilling();
				$shipping_address_id = $billing_address_id; 
			}
			$ShippingAddressDetail = UserAddress::getUserAddresses( UserAuthentication::getLoggedUserId(), 0, 0, $shipping_address_id );
			if( !$ShippingAddressDetail ){
				Message::addErrorMessage( Labels::getLabel('MSG_ACTION_TRYING_PERFORM_NOT_VALID', $this->siteLangId) );
				FatUtility::dieWithError( Message::getHtml() );
			}
			$this->cartObj->setCartShippingAddress( $ShippingAddressDetail['ua_id']);
		}
		
		if( !$isShippingSameAsBilling ){
			$this->cartObj->unSetShippingAddressSameAsBilling();
		}
		$this->cartObj->removeProductShippingMethod( );
		$this->set('hasPhysicalProduct', $hasPhysicalProduct);
		$this->set('msg', Labels::getLabel('MSG_Address_Selection_Successfull', $this->siteLangId) );
		$this->_template->render(false, false, 'json-success.php');
	}
	
	/* public function shippingSummary(){
		$criteria = array( 'isUserLogged' => true, 'hasBillingAddress' => true, 'hasShippingAddress' => true );
		if( !$this->isEligibleForNextStep( $criteria ) ){
			if( Message::getErrorCount() ){
				$errMsg = Message::getHtml();
			} else {
				Message::addErrorMessage(Labels::getLabel('MSG_Something_went_wrong,_please_try_after_some_time.', $this->siteLangId));
				$errMsg = Message::getHtml();
			}
			FatUtility::dieWithError( $errMsg );
		}
		
		$selectedShippingapi_id = $this->cartObj->getCartShippingApi();
		$frm_data = array('shippingapi_id' => $selectedShippingapi_id );
		$frm = $this->getShippingApiForm( $this->siteLangId );
		$frm->fill($frm_data);
		$this->set( 'frmShippingApi', $frm);
		$this->_template->render( false, false);
	} */
	
	public function shippingSummary(){
		$criteria = array( 'isUserLogged' => true );
		if( !$this->isEligibleForNextStep( $criteria ) ){
			if( Message::getErrorCount() ){
				$errMsg = Message::getHtml();
			} else {
				Message::addErrorMessage(Labels::getLabel('MSG_Something_went_wrong,_please_try_after_some_time.', $this->siteLangId));
				$errMsg = Message::getHtml();
			}
			FatUtility::dieWithError( $errMsg );
		}
	
		/* $frm = $this->getShippingApiForm( $this->siteLangId );
		$post = $frm->getFormDataFromArray(FatApp::getPostedData());
		$shippingapi_id = FatUtility::int($post['shippingapi_id']);
		if( !$shippingapi_id ){
			FatUtility::dieWithError( Labels::getLabel('MSG_Please_select_shipping_api', $this->siteLangId) );
		} */
		$productSelectedShippingMethodsArr = $this->cartObj->getProductShippingMethod();
		$selectedShippingapi_id = $this->cartObj->getCartShippingApi();
		$user_id = UserAuthentication::getLoggedUserId();
		
		$manualShippingArt = array('Seller Shiping');
		$frm_data = array('shippingapi_id' => $selectedShippingapi_id );
		$frm = $this->getShippingApiForm( $this->siteLangId );
		$shippingMethods = $this->getShippingMethods( $this->siteLangId );
		$frm->fill($frm_data);
		$this->set( 'frmShippingApi', $frm);
		/* $shippingDurationError = '';
		if( $shippingDurationError ){
			FatUtility::dieWithError( $shippingDurationError );
		} */
		$cart_products=$this->cartObj->getProducts( $this->siteLangId ); 
		/* get user shipping address[ */
		$shippingAddressDetail = UserAddress::getUserAddresses($user_id, $this->siteLangId, 0, $this->cartObj->getCartShippingAddress());
		
		
		/* ] */
		foreach($cart_products as $cartkey=>$cartval)
		{
			$cart_products[$cartkey]['pship_id']= 0;
			$shipBy=0;
			
			if($cart_products[$cartkey]['psbs_user_id']){
				  $shipBy =$cart_products[$cartkey]['psbs_user_id'];
			}
			/* $limit = 1; */
			$ua_country_id = isset($shippingAddressDetail['ua_country_id'])?$shippingAddressDetail['ua_country_id']:0;
			$shipping_options = Product::getProductShippingRates($cartval['product_id'], $this->siteLangId,$ua_country_id,$shipBy);
			$free_shipping_options = Product::getProductFreeShippingAvailabilty($cartval['product_id'], $this->siteLangId,$ua_country_id,$shipBy);
		
			$cart_products[$cartkey]['is_shipping_selected'] =  isset($productSelectedShippingMethodsArr['product'][$cartval['selprod_id']])?$productSelectedShippingMethodsArr['product'][$cartval['selprod_id']]['mshipapi_id']:false;
			if($cart_products[$cartkey]['is_shipping_selected'] && $productSelectedShippingMethodsArr['product'][$cartval['selprod_id']]['mshipapi_id']== SHIPPINGMETHODS::SHIPSTATION_SHIPPING){
				
				$cart_products[$cartkey]['selected_shipping_option']=$productSelectedShippingMethodsArr['product'][$cartval['selprod_id']];
			}elseif($cart_products[$cartkey]['is_shipping_selected'] && $productSelectedShippingMethodsArr['product'][$cartval['selprod_id']]['mshipapi_id']== SHIPPINGMETHODS::MANUAL_SHIPPING){
				$cart_products[$cartkey]['pship_id']=$productSelectedShippingMethodsArr['product'][$cartval['selprod_id']]['pship_id'];
			
			}
			$cart_products[$cartkey]['shipping_rates']=$shipping_options;
			$cart_products[$cartkey]['shipping_free_availbilty']=$free_shipping_options;
		
		} 
		if(count($cart_products)==0){
			Message::addErrorMessage(Labels::getLabel('MSG_Your_Cart_is_empty.', $this->siteLangId));
			FatUtility::dieWithError(Message::getHtml());
		}
				
		$this->set('productSelectedShippingMethodsArr', $productSelectedShippingMethodsArr);
		$this->set('shipStationCarrierList', $this->cartObj->shipStationCarrierList());
		$this->set('shippingMethods', $shippingMethods );
		$this->set('products', $cart_products );
		$this->set('cartSummary', $this->cartObj->getCartFinancialSummary( $this->siteLangId ));
		$this->set('shippingAddressDetail', UserAddress::getUserAddresses(UserAuthentication::getLoggedUserId(),$this->siteLangId, 0, $this->cartObj->getCartShippingAddress() ) );
	
		$this->set('selectedProductShippingMethod', $this->cartObj->getProductShippingMethod() );
		
		$this->_template->render(false, false, 'checkout/shipping-summary-inner.php');
	}
	
	public function getCarrierServicesList( $product_key, $carrier_id = 0) {
		if( !UserAuthentication::isUserLogged() ){
			Message::addErrorMessage(Labels::getLabel('MSG_Your_Session_seems_to_be_expired.', $this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );	
		}
        $this->Cart = new Cart(UserAuthentication::getLoggedUserId());
        $carrierList = $this->Cart->getCarrierShipmentServicesList($product_key, $carrier_id, $this->siteLangId);
	
        $this->set('options', $carrierList);
        $this->_template->render(false, false);
    }
	
	public function setUpShippingMethod(){
		$post = FatApp::getPostedData();
		
		$cartProducts = $this->cartObj->getProducts($this->siteLangId);
		//$this->cartObj = new Cart();
		$productToShippingMethods = array();
		$user_id = UserAuthentication::getLoggedUserId();
		
		/* get user shipping address[ */
		$shippingAddressDetail = UserAddress::getUserAddresses($user_id, $this->siteLangId, 0, $this->cartObj->getCartShippingAddress());
		/* ] */
		$sn= 0;
		$json= array();
		if( !empty($cartProducts) ){
			$prodSrchObj = new ProductSearch( );	
			foreach($cartProducts as $cartkey=>$cartval){			
				$sn++;
				$shipping_address = UserAddress::getUserAddresses(UserAuthentication::getLoggedUserId(),$this->siteLangId );
				$shipBy=0;
			
				if($cartProducts[$cartkey]['psbs_user_id']){
					 $shipBy =$cartProducts[$cartkey]['psbs_user_id'];
				}
				$ua_country_id = isset($shippingAddressDetail['ua_country_id'])?$shippingAddressDetail['ua_country_id']:0;
				$shipping_options = Product::getProductShippingRates($cartval['product_id'], $this->siteLangId,$ua_country_id,$shipBy);
				$free_shipping_options = Product::getProductFreeShippingAvailabilty($cartval['product_id'], $this->siteLangId,$ua_country_id,$shipBy);
				$productKey = md5($cartval["key"]);
				if( $cartval && $cartval['product_type'] == Product::PRODUCT_TYPE_PHYSICAL ){
			
					/* get Product Data[ */
					$prodSrch = clone $prodSrchObj;
					$prodSrch->setDefinedCriteria();
					$prodSrch->joinProductToCategory();
					$prodSrch->joinProductShippedBy();
					$prodSrch->joinProductFreeShipping();
					$prodSrch->joinSellerSubscription();
					$prodSrch->addSubscriptionValidCondition();
					$prodSrch->doNotCalculateRecords();
					$prodSrch->doNotLimitRecords();
					$prodSrch->addCondition( 'selprod_deleted', '=', applicationConstants::NO );
					$prodSrch->addCondition( 'selprod_id', '=', $cartval['selprod_id'] );					
					/* $prodSrch->addDirectCondition( "( isnull(psbs.psbs_user_id) or psbs.psbs_user_id = '".$cartval['selprod_user_id']."')" ); */
					$prodSrch->addMultipleFields( array('selprod_id','product_seller_id','psbs_user_id as shippedBySellerId') );
					$productRs = $prodSrch->getResultSet();									
					$product = FatApp::getDb()->fetch($productRs);					
					/* ] */
					
					if (isset($post["shipping_type"][$productKey]) && ($post["shipping_type"][$productKey] ==  ShippingCompanies::MANUAL_SHIPPING) &&  !empty($post["shipping_locations"][$productKey]) ){
							foreach($shipping_options as $shipOption){
									if($shipOption['pship_id']==$post["shipping_locations"][$productKey]){								
									
										$productToShippingMethods['product'][$cartval['selprod_id']] = array(
											'selprod_id'	=>	$cartval['selprod_id'],
											'pship_id'	=>	$post["shipping_locations"][$productKey],
											'sduration_id'	=>	$shipOption['sduration_id'],
											'sduration_name' => $shipOption['sduration_name'],
											'sduration_from' => $shipOption['sduration_from'],
											'sduration_to' => $shipOption['sduration_to'],
											'sduration_days_or_weeks' => $shipOption['sduration_days_or_weeks'],
											'mshipapi_id'	=>	$post["shipping_type"][$productKey],
											'mshipcompany_id'	=>	$shipOption['scompanylang_scompany_id'],
											'mshipcompany_name'	=>	$shipOption['scompany_name'],
											'shipped_by_seller'	=>	CommonHelper::isShippedBySeller($cartval['selprod_user_id'],$product['product_seller_id'],$product['shippedBySellerId']),
											'mshipapi_cost' =>  ( $free_shipping_options == 0 )? ($shipOption['pship_charges'] + ($shipOption['pship_additional_charges'] * ($cartval['quantity'] -1))) : 0 ,
											);	
											continue;
									}
							}
						
						
					
					}elseif (isset($post["shipping_type"][$productKey]) && ($post["shipping_type"][$productKey] ==  ShippingCompanies::SHIPSTATION_SHIPPING ) && !empty($post["shipping_services"][$productKey]) ){							
								list($carrier_name, $carrier_price) = explode("-", $post["shipping_services"][$productKey]);
								$productToShippingMethods['product'][$cartval['selprod_id']] = array(
											'selprod_id'	=>	$cartval['selprod_id'],
											'mshipapi_id'	=>	$post["shipping_type"][$productKey],
											'mshipcompany_name'	=>	($carrier_name),
											'mshipapi_cost' =>  $carrier_price ,
											'mshipapi_key' =>  $post["shipping_services"][$productKey] ,
											'mshipapi_label' =>  str_replace("_", " ",$post["shipping_services"][$productKey]) ,
											'shipped_by_seller'	=>	CommonHelper::isShippedBySeller($cartval['selprod_user_id'],$product['product_seller_id'],$product['shippedBySellerId']),
											);												
											continue;
					
					}else{
							
						$json['error']['product'][$sn] = sprintf(Labels::getLabel('M_Shipping_Info_Required_for_%s', $this->siteLangId), htmlentities($cartval['product_name']));	
					
					}
				}
			}
			
			if (!$json) {
				$this->cartObj->setProductShippingMethod( $productToShippingMethods );
				if( !$this->cartObj->isProductShippingMethodSet() ){
					//MSG_Error_in_Shipping_Method_Selection
					Message::addErrorMessage(Labels::getLabel('MSG_Shipping_Method_is_not_selected_on_products_in_cart', $this->siteLangId));
					FatUtility::dieWithError( Message::getHtml() );
				}
				$this->set('msg',Labels::getLabel('MSG_Shipping_Method_selected_successfully.', $this->siteLangId));
				$this->_template->render(false, false, 'json-success.php');
			}else{
				Message::addErrorMessage(Labels::getLabel('MSG_Shipping_Method_is_not_selected_on_products_in_cart', $this->siteLangId));
				FatUtility::dieWithError( Message::getHtml() );
			}
		}
	
		
	}
	
	public function reviewCart(){
		$criteria = array( 'isUserLogged' => true, 'hasProducts' => true, 'hasStock' => true, 'hasBillingAddress' => true );
		if( $this->cartObj->hasPhysicalProduct() ){
			$criteria['hasShippingAddress'] = true;
			$criteria['isProductShippingMethodSet'] = true;
		}
		if( !$this->isEligibleForNextStep( $criteria ) ){
			if( Message::getErrorCount() ){
				$errMsg = Message::getHtml();
			} else {
				Message::addErrorMessage(Labels::getLabel('MSG_Something_went_wrong,_please_try_after_some_time.', $this->siteLangId));
				$errMsg = Message::getHtml();
			}
			FatUtility::dieWithError( $errMsg );
		}
		$cartHasDigitalProduct = $this->cartObj->hasDigitalProduct();
		$cartHasPhysicalProduct = $this->cartObj->hasPhysicalProduct();
		$cart_products = $this->cartObj->getProducts($this->siteLangId);
		if(count($cart_products)==0){
			Message::addErrorMessage(Labels::getLabel('MSG_Your_Cart_is_empty.', $this->siteLangId));
				FatUtility::dieWithError(Message::getHtml());
		}
		$this->set('cartHasDigitalProduct', $cartHasDigitalProduct);
		$this->set('cartHasPhysicalProduct', $cartHasPhysicalProduct);
		$this->set('products', $cart_products );
		
		$this->set('cartSummary', $this->cartObj->getCartFinancialSummary($this->siteLangId));
		$this->set('selectedProductShippingMethod', $this->cartObj->getProductShippingMethod() );
		$this->_template->render(false, false );
	}
	
	private function getCartProductInfo($selprod_id){
		$selprod_id = FatUtility::int($selprod_id);
		$prodSrch = new ProductSearch( $this->siteLangId );
		$prodSrch->setDefinedCriteria();
		$prodSrch->joinBrands();
		$prodSrch->joinSellerSubscription();
		$prodSrch->addSubscriptionValidCondition();
		$prodSrch->joinProductToCategory();
		$prodSrch->doNotCalculateRecords();
		$prodSrch->doNotLimitRecords();
		$prodSrch->addCondition( 'selprod_deleted', '=', applicationConstants::NO );
		$prodSrch->addCondition('selprod_id', '=', $selprod_id );
		$fields = array( 'product_id', 'product_type', 'product_length', 'product_width', 'product_height', 
		'product_dimension_unit', 'product_weight', 'product_weight_unit', 'product_model',
		'selprod_id', 'selprod_user_id', 'selprod_stock','IF(selprod_stock > 0, 1, 0) AS in_stock', 'selprod_sku', 
		'selprod_condition', 'selprod_code',
		'special_price_found', 'theprice', 'shop_id', 'IFNULL(product_name, product_identifier) as product_name', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title','IFNULL(brand_name, brand_identifier) as brand_name','shop_name',
		'seller_user.user_name as shop_onwer_name', 'seller_user_cred.credential_username as shop_owner_username', 
		'seller_user.user_phone as shop_owner_phone','seller_user_cred.credential_email as shop_owner_email','selprod_download_validity_in_days','selprod_max_download_times' );
		$prodSrch->addMultipleFields( $fields  );
		$rs = $prodSrch->getResultSet();
		return $productInfo = FatApp::getDb()->fetch($rs);
	}
	
	private function getCartProductLangData($selprod_id,$lang_id){
		$langProdSrch = new ProductSearch( $lang_id );
		$langProdSrch->setDefinedCriteria();
		$langProdSrch->joinBrands();
		$langProdSrch->joinProductToCategory();
		$langProdSrch->joinSellerSubscription();
		$langProdSrch->addSubscriptionValidCondition();						
		$langProdSrch->doNotCalculateRecords();
		$langProdSrch->doNotLimitRecords();
		$langProdSrch->addCondition( 'selprod_deleted', '=', applicationConstants::NO );
		$langProdSrch->addCondition('selprod_id', '=', $selprod_id );
		$fields = array( 'IFNULL(product_name, product_identifier) as product_name','IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title','IFNULL(brand_name, brand_identifier) as brand_name','IFNULL(shop_name, shop_identifier) as shop_name' );
		$langProdSrch->addMultipleFields( $fields  );
		$langProdRs = $langProdSrch->getResultSet();
		return $langSpecificProductInfo = FatApp::getDb()->fetch($langProdRs);
	}
	
	public function PaymentSummary(){
		$criteria = array( 'isUserLogged' => true, 'hasProducts' => true, 'hasStock' => true, 'hasBillingAddress' => true );
		if( $this->cartObj->hasPhysicalProduct() ){
			$criteria['hasShippingAddress'] = true;
			$criteria['isProductShippingMethodSet'] = true;
		}
		
		if( !$this->isEligibleForNextStep( $criteria ) ){
			if( Message::getErrorCount() ){
				$errMsg = Message::getHtml();
			} else {
				Message::addErrorMessage(Labels::getLabel('MSG_Something_went_wrong,_please_try_after_some_time.', $this->siteLangId));
				$errMsg = Message::getHtml();
			}
			FatUtility::dieWithError( $errMsg );
		}		
	
		$cartSummary = $this->cartObj->getCartFinancialSummary($this->siteLangId);
		//commonHelper::printArray($cartSummary);
		$userId = UserAuthentication::getLoggedUserId();
		
		/* Payment Methods[ */
		$pmSrch = PaymentMethods::getSearchObject( $this->siteLangId );
		$pmSrch->doNotCalculateRecords();
		$pmSrch->doNotLimitRecords();
		$pmSrch->addMultipleFields(array('pmethod_id', 'IFNULL(pmethod_name, pmethod_identifier) as pmethod_name', 'pmethod_code', 'pmethod_description'));
		if( !$cartSummary["isCodEnabled"] ){
			$pmSrch->addCondition( 'pmethod_code', '!=', 'CashOnDelivery' );
		}	

		/* if( $this->cartObj->hasDigitalProduct() ){
			
		} */
		
		$pmRs = $pmSrch->getResultSet();
		$paymentMethods = FatApp::getDb()->fetchAll($pmRs);
		/* ] */
		
		$orderData = array();
		/* add Order Data[ */
		$order_id = isset($_SESSION['shopping_cart']["order_id"]) ? $_SESSION['shopping_cart']["order_id"] : false;
		
		/* if($order_id){
			$orderObj =  new Orders();
			$orderInfo = $orderObj->getOrderById( $order_id, $this->siteLangId );
			if($orderInfo['order_is_paid']){
				$order_id = false;
			}
		} */
		
		$shippingAddressArr = array();
		$billingAddressArr = array();
		$shippingAddressId = $this->cartObj->getCartShippingAddress();
		$billingAddressId = $this->cartObj->getCartBillingAddress();
		
		if( $shippingAddressId ){
			$shippingAddressArr = UserAddress::getUserAddresses( $userId, $this->siteLangId, 0, $shippingAddressId );
		}
		if( $billingAddressId ){
			$billingAddressArr = UserAddress::getUserAddresses( $userId, $this->siteLangId, 0, $billingAddressId );
		}
		
		$orderData['order_id'] = $order_id;
		$orderData['order_user_id'] = $userId;
		/* $orderData['order_user_name'] = $userDataArr['user_name'];
		$orderData['order_user_email'] = $userDataArr['credential_email'];
		$orderData['order_user_phone'] = $userDataArr['user_phone']; */
		$orderData['order_is_paid'] = Orders::ORDER_IS_PENDING;
		$orderData['order_date_added'] = date('Y-m-d H:i:s');
		
		/* addresses[ */
		$userAddresses[0] = array(
			'oua_order_id'	=>	$order_id,
			'oua_type'		=>	Orders::BILLING_ADDRESS_TYPE,
			'oua_name'		=>	$billingAddressArr['ua_name'],
			'oua_address1'	=>	$billingAddressArr['ua_address1'],
			'oua_address2'	=>	$billingAddressArr['ua_address2'],
			'oua_city'		=>	$billingAddressArr['ua_city'],
			'oua_state'		=>	$billingAddressArr['state_name'],
			'oua_country'	=>	$billingAddressArr['country_name'],
			'oua_country_code'	=>	$billingAddressArr['country_code'],
			'oua_phone'		=>	$billingAddressArr['ua_phone'],
			'oua_zip'		=>	$billingAddressArr['ua_zip'],
		);
		
		if( !empty($shippingAddressArr) ){
			$userAddresses[1] = array(
				'oua_order_id'	=>	$order_id,
				'oua_type'		=>	Orders::SHIPPING_ADDRESS_TYPE,
				'oua_name'		=>	$shippingAddressArr['ua_name'],
				'oua_address1'	=>	$shippingAddressArr['ua_address1'],
				'oua_address2'	=>	$shippingAddressArr['ua_address2'],
				'oua_city'		=>	$shippingAddressArr['ua_city'],
				'oua_state'		=>	$shippingAddressArr['state_name'],
				'oua_country'	=>	$shippingAddressArr['country_name'],
				'oua_country_code'	=>	$shippingAddressArr['country_code'],
				'oua_phone'		=>	$shippingAddressArr['ua_phone'],
				'oua_zip'		=>	$shippingAddressArr['ua_zip'],
			);
		}
		$orderData['userAddresses'] = $userAddresses;
		/* ] */
		
		/* order extras[ */
		$orderData['extra'] = array(
			'oextra_order_id'	=>	$order_id,
			'order_ip_address'	=>	$_SERVER['REMOTE_ADDR']
		);
		
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$orderData['extra']['order_forwarded_ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$orderData['extra']['order_forwarded_ip'] = $_SERVER['HTTP_CLIENT_IP'];
		} else {
			$orderData['extra']['order_forwarded_ip'] = '';
		}
		
		if (isset($_SERVER['HTTP_USER_AGENT'])) {
			$orderData['extra']['order_user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		} else {
			$orderData['extra']['order_user_agent'] = '';
		}
		
		if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			$orderData['extra']['order_accept_language'] = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		} else {
			$orderData['extra']['order_accept_language'] = '';
		}
		/* ] */
		
		$languageRow = Language::getAttributesById($this->siteLangId);
		$orderData['order_language_id'] =  $languageRow['language_id'];
		$orderData['order_language_code'] =  $languageRow['language_code'];
		
		$currencyRow = Currency::getAttributesById($this->siteCurrencyId);
		$orderData['order_currency_id'] =  $currencyRow['currency_id'];
		$orderData['order_currency_code'] =  $currencyRow['currency_code'];
		$orderData['order_currency_value'] =  $currencyRow['currency_value'];
		
		$orderData['order_user_comments'] =  '';
		$orderData['order_admin_comments'] =  '';
		
		/* $cartShippingApiId = $this->cartObj->getCartShippingApi();
		$order_shippingapi_id = 0;
		$order_shippingapi_code = '';
		
		if( $cartShippingApiId > 0 ){
			$shippingApiRow = ShippingApi::getAttributesById($cartShippingApiId);
			$order_shippingapi_id = $shippingApiRow['shippingapi_id'];
			$order_shippingapi_code = $shippingApiRow['shippingapi_code'];
		}
		
		if( $order_shippingapi_id > 0 ){
			$orderData['order_shippingapi_id'] = $order_shippingapi_id;
			$orderData['order_shippingapi_code'] = $order_shippingapi_code;
		} */
		/* if( $order_shippingapi_id > 0 ){
			$shippingData['opshipping_method_id'] = $shippingApiRow['shippingapi_code'];
			$shippingData['opshipping_pship_id'] =  $shippingApiRow['shippingapi_code'];
			$shippingData['opshipping_carrier'] =  $shippingApiRow['shippingapi_code'];
			$shippingData['opshipping_company_id'] =  $shippingApiRow['shippingapi_code'];
			$shippingData['opshipping_duration'] =  $shippingApiRow['shippingapi_code'];
		} */
		if(!empty($cartSummary["cartDiscounts"])){
			$orderData['order_discount_coupon_code'] = $cartSummary["cartDiscounts"]["coupon_code"];
			$orderData['order_discount_type'] = $cartSummary["cartDiscounts"]["coupon_discount_type"];
			$orderData['order_discount_value'] = $cartSummary["cartDiscounts"]["coupon_discount_value"];
			$orderData['order_discount_total'] = $cartSummary["cartDiscounts"]["coupon_discount_total"];
			$orderData['order_discount_info'] = $cartSummary["cartDiscounts"]["coupon_info"];
		}
		
		 $orderData['order_reward_point_used'] = $cartSummary["cartRewardPoints"];
		 $orderData['order_reward_point_value'] = CommonHelper::convertRewardPointToCurrency($cartSummary["cartRewardPoints"]);
				
		//$orderData['order_payment_gateway_charges'] = $cartSummary["orderPaymentGatewayCharges"];
		//$orderData['order_cart_total'] = $cartSummary["cartTotal"];
		//$orderData['order_shipping_charged'] = $cartSummary["shippingTotal"];
		$orderData['order_tax_charged'] = $cartSummary["cartTaxTotal"];
		$orderData['order_site_commission'] = $cartSummary["siteCommission"];
		$orderData['order_volume_discount_total'] = $cartSummary["cartVolumeDiscount"];
		//$orderData['order_sub_total'] = $cartSummary["netTotalWithoutDiscount"];
		//$orderData['order_net_charged'] = $cartSummary["netTotalAfterDiscount"];
		//$orderData['order_actual_paid'] = $cartSummary["cartActualPaid"];
		$orderData['order_net_amount'] = $cartSummary["orderNetAmount"];
		$orderData['order_is_wallet_selected'] = $cartSummary["cartWalletSelected"];
		$orderData['order_wallet_amount_charge'] = $cartSummary["WalletAmountCharge"];
		$orderData['order_type'] = Orders::ORDER_PRODUCT;		
		
		/* referrer details[ */
		$srchOrder = new OrderSearch();
		$srchOrder->doNotCalculateRecords();
		$srchOrder->doNotLimitRecords();
		$srchOrder->addCondition( 'order_user_id', '=', $userId );
		$srchOrder->addCondition( 'order_is_paid', '=', Orders::ORDER_IS_PAID );
		$srchOrder->addCondition( 'order_referrer_user_id', '!=', 0 );
		$srchOrder->addMultipleFields(array( 'count(o.order_id) as totalOrders' ));
		$rs = $srchOrder->getResultSet();
		$existingReferrerOrderRow = FatApp::getDb()->fetch($rs);
		
		$orderData['order_referrer_user_id'] = 0;
		$orderData['order_referrer_reward_points'] = 0;
		$orderData['order_referral_reward_points'] = 0;
		$orderData['order_cart_data'] = Cart::getCartData();
		
		$referrerUserId = 0;
		if ( isset($_COOKIE['referrer_code_checkout']) && !empty($_COOKIE['referrer_code_checkout']) ){
			$userReferrerCode = $_COOKIE['referrer_code_checkout'];
			
			$userSrchObj = User::getSearchObject();
			$userSrchObj->doNotCalculateRecords();
			$userSrchObj->doNotLimitRecords();
			$userSrchObj->addCondition('user_referral_code', '=', $userReferrerCode );
			$userSrchObj->addCondition( 'user_id', '!=', $userId );
			$userSrchObj->addMultipleFields( array('user_id', 'user_referral_code', 'user_name' ) );
			$rs = $userSrchObj->getResultSet();
			$referrerUserRow = FatApp::getDb()->fetch( $rs );
			if( $referrerUserRow && $referrerUserRow['user_referral_code'] == $userReferrerCode && $userReferrerCode != '' && $referrerUserRow['user_referral_code'] != '' ){
				$referrerUserId = $referrerUserRow['user_id'];
				//$referrerUserName = $referrerUserRow['user_name'];
			}
		}
		
		if( $referrerUserId > 0 && FatApp::getConfig("CONF_ENABLE_REFERRER_MODULE") && $existingReferrerOrderRow['totalOrders'] == 0 ){
			$orderData['order_referrer_user_id'] = $referrerUserId;
			$orderData['order_referrer_reward_points'] = FatApp::getConfig("CONF_SALE_REFERRER_REWARD_POINTS", FatUtility::VAR_INT, 0);
			$orderData['order_referral_reward_points'] = FatApp::getConfig("CONF_SALE_REFERRAL_REWARD_POINTS", FatUtility::VAR_INT, 0);
		}
		/* ] */
		
		$allLanguages = Language::getAllNames();
		$productSelectedShippingMethodsArr = $this->cartObj->getProductShippingMethod();
		
		$orderLangData = array();
		foreach( $allLanguages as $lang_id => $language_name ){
			$order_shippingapi_name = '';
			
			if( $this->cartObj->getCartShippingApi() ){
				$shippingApiLangRow = ShippingApi::getAttributesByLangId($lang_id, $this->cartObj->getCartShippingApi());
				$order_shippingapi_name = $shippingApiLangRow['shippingapi_name'];
				if( empty($shippingApiLangRow) ){
					$order_shippingapi_name = $shippingApiRow['shippingapi_identifier'];
				}
			}
			
			$orderLangData[$lang_id] = array(
				'orderlang_lang_id'			=>	$lang_id,
				'order_shippingapi_name'	=>	$order_shippingapi_name
			);
		}
		$orderData['orderLangData'] = $orderLangData;
		
		/* order products[ */
		$cartProducts = $this->cartObj->getProducts($this->siteLangId);
		$orderData['products'] = array();
		$orderData['prodCharges'] = array();
		
		$order_affiliate_user_id = 0;
		$order_affiliate_total_commission = 0;
		
		if( $cartProducts ){
			$productShippingData = array();
			foreach( $cartProducts as $cartProduct ){
					$productInfo = $this->getCartProductInfo($cartProduct['selprod_id']);
					if( !$productInfo ){ continue; }
					
					$sduration_name = '';
					$shippingDurationTitle = '';
					$shippingDurationRow = array();
					
					if( !empty($productSelectedShippingMethodsArr['product']) && isset($productSelectedShippingMethodsArr['product'][$productInfo['selprod_id']]) ){
						$shippingDurationRow = $productSelectedShippingMethodsArr['product'][$productInfo['selprod_id']];
						if($shippingDurationRow['mshipapi_id']== ShippingMethods::MANUAL_SHIPPING){
								$productShippingData = array(
									'opshipping_method_id' =>$shippingDurationRow['mshipapi_id'],
									'opshipping_pship_id' =>$shippingDurationRow['pship_id'],
									'opshipping_company_id' =>$shippingDurationRow['mshipcompany_id'],
									'opshipping_max_duration' =>$shippingDurationRow['sduration_to'],
									'opshipping_duration_id' =>$shippingDurationRow['sduration_id'],		
									); 
							} elseif( $shippingDurationRow['mshipapi_id']== ShippingMethods::SHIPSTATION_SHIPPING ){
								$productShippingData = array( 'opshipping_method_id' =>$shippingDurationRow['mshipapi_id'] ); 
							}
							$productShippingData['opshipping_by_seller_user_id'] = $shippingDurationRow['shipped_by_seller'];
						}
					$productsLangData = array();
					$productShippingLangData = array();
					foreach( $allLanguages as $lang_id => $language_name ){
						$langSpecificProductInfo = $this->getCartProductLangData($productInfo['selprod_id'],$lang_id);
						if( !$langSpecificProductInfo ) { continue; }
						
						if( !empty($shippingDurationRow) ){
							if( $shippingDurationRow['mshipapi_id']== ShippingMethods::MANUAL_SHIPPING ){
								$shippingDurationTitle = ShippingDurations::getShippingDurationTitle( $shippingDurationRow, $lang_id );
								$sduration_name = $shippingDurationRow['mshipcompany_name'];
								$productShippingLangData[$lang_id] =  array(
									'opshipping_duration'=>$shippingDurationTitle,
									'opshipping_duration_name'=>$shippingDurationRow['mshipcompany_name'],
									'opshippinglang_lang_id' => $lang_id
								);
							} elseif( $shippingDurationRow['mshipapi_id']== ShippingMethods::SHIPSTATION_SHIPPING ){
								$sduration_name = $shippingDurationRow['mshipapi_label'];
								$productShippingLangData[$lang_id] =  array(
									'opshipping_carrier'=>$shippingDurationRow['mshipcompany_name'],
									'opshipping_duration_name'=>$sduration_name,
									'opshippinglang_lang_id' => $lang_id
								);
							}
						}
						
						$weightUnitsArr = applicationConstants::getWeightUnitsArr( $lang_id );
						$lengthUnitsArr = applicationConstants::getLengthUnitsArr( $lang_id );
						$op_selprod_title = ($langSpecificProductInfo['selprod_title'] != '') ? $langSpecificProductInfo['selprod_title'] : '';
						
						/* stamping/locking of product options language based [ */
						$op_selprod_options = '';
						$productOptionsRows = SellerProduct::getSellerProductOptions( $productInfo['selprod_id'], true, $lang_id );
						if( !empty($productOptionsRows) ){
							$optionCounter = 1;
							foreach($productOptionsRows as $poLang){
								$op_selprod_options .= $poLang['option_name'].': '.$poLang['optionvalue_name'];
								if( $optionCounter != count($productOptionsRows) ){
									$op_selprod_options .= ' | ';
								}
								$optionCounter++;
							}
						}
						/* ] */
					
						$op_products_dimension_unit_name = ($productInfo['product_dimension_unit']) ? $lengthUnitsArr[$productInfo['product_dimension_unit']] : '';
						$op_product_weight_unit_name = ($productInfo['product_weight_unit']) ? $weightUnitsArr[$productInfo['product_weight_unit']] : '';
						
						$productsLangData[$lang_id] = array(
							'oplang_lang_id'	=>	$lang_id,
							'op_product_name'	=>	$langSpecificProductInfo['product_name'],
							'op_selprod_title'	=>	$op_selprod_title,
							'op_selprod_options'=>  $op_selprod_options,
							'op_brand_name'		=>	$langSpecificProductInfo['brand_name'],
							'op_shop_name'		=>	$langSpecificProductInfo['shop_name'],
							'op_shipping_duration_name'	=>	$sduration_name,
							'op_shipping_durations'	=>	$shippingDurationTitle,
							'op_products_dimension_unit_name'	=>	$op_products_dimension_unit_name,
							'op_product_weight_unit_name'		=>	$op_product_weight_unit_name,
						);
					}
					
					$taxCollectedBySeller = applicationConstants::NO;
					if(FatApp::getConfig('CONF_TAX_COLLECTED_BY_SELLER',FatUtility::VAR_INT,0)){
						$taxCollectedBySeller = applicationConstants::YES;
					}

					$orderData['products'][CART::CART_KEY_PREFIX_PRODUCT.$productInfo['selprod_id']] = array(
						'op_selprod_id'		=>	$productInfo['selprod_id'],
						'op_is_batch'		=>	0,
						'op_selprod_user_id'=>	$productInfo['selprod_user_id'],
						'op_selprod_code'	=>	$productInfo['selprod_code'],
						'op_qty'			=>	$cartProduct['quantity'],
						'op_unit_price'		=>	$cartProduct['theprice'],
						'op_unit_cost'		=>	$cartProduct['selprod_cost'],
						'op_selprod_sku'	=>	$productInfo['selprod_sku'],
						'op_selprod_condition'	=>	$productInfo['selprod_condition'],
						'op_product_model'	=>	$productInfo['product_model'],
						'op_product_type'	=>	$productInfo['product_type'],
						'op_product_length'	=>	$productInfo['product_length'],
						'op_product_width'	=>	$productInfo['product_width'],
						'op_product_height'	=>	$productInfo['product_height'],
						'op_product_dimension_unit'	=>	$productInfo['product_dimension_unit'],
						'op_product_weight'	=>	$productInfo['product_weight'],
						'op_product_weight_unit'	=>	$productInfo['product_weight_unit'],
						'op_shop_id'		=>	$productInfo['shop_id'],
						'op_shop_owner_username'=>	$productInfo['shop_owner_username'],
						'op_shop_owner_name'=>	$productInfo['shop_onwer_name'],
						'op_shop_owner_email'	=>	$productInfo['shop_owner_email'],
						'op_shop_owner_phone'	=>	$productInfo['shop_owner_phone'],
						'op_selprod_max_download_times' => ($productInfo['selprod_max_download_times']!='-1')?$cartProduct['quantity']*$productInfo['selprod_max_download_times']:$productInfo['selprod_max_download_times'],
						'op_selprod_download_validity_in_days' => $productInfo['selprod_download_validity_in_days'],
						'op_sduration_id'			=>	$cartProduct['sduration_id'],
						//'op_shipping_cost'	=>	$cartProduct['shipping_cost'],
						//'op_discount_total'	=>	0, //todo:: after coupon discount integration
						//'op_tax_total'	=>	$cartProduct['tax'], 
						'op_commission_charged' => $cartProduct['commission'],
						'op_commission_percentage'	=> $cartProduct['commission_percentage'],
						'op_affiliate_commission_percentage' => $cartProduct['affiliate_commission_percentage'],
						'op_affiliate_commission_charged' => $cartProduct['affiliate_commission'],												
						'op_status_id'		=>	FatApp::getConfig("CONF_DEFAULT_ORDER_STATUS"),
						// 'op_volume_discount_percentage'	=>	$cartProduct['volume_discount_percentage'],
						'productsLangData'	=>	$productsLangData,
						'productShippingData'	=>	$productShippingData,
						'productShippingLangData'	=>	$productShippingLangData,
						'op_tax_collected_by_seller'	=>	$taxCollectedBySeller,
					);
					
					$order_affiliate_user_id = isset($cartProduct['affiliate_user_id'])?$cartProduct['affiliate_user_id']:'';
					$order_affiliate_total_commission += isset($cartProduct['affiliate_commission'])?$cartProduct['affiliate_commission']:'';
					
					$discount = 0;
					if(!empty($cartSummary["cartDiscounts"]["discountedSelProdIds"])){
						if(array_key_exists($productInfo['selprod_id'],$cartSummary["cartDiscounts"]["discountedSelProdIds"])){
							$discount = $cartSummary["cartDiscounts"]["discountedSelProdIds"][$productInfo['selprod_id']];
						}
					}			
					
					$rewardPoints = 0;
					$rewardPoints = $orderData['order_reward_point_value'];
					$usedRewardPoint = 0;
					if($rewardPoints > 0){
						$selProdAmount = ($cartProduct['quantity'] * $cartProduct['theprice']) + $cartProduct['shipping_cost'] +  $cartProduct['tax']  - $discount ;
						$usedRewardPoint = round((($rewardPoints * $selProdAmount)/($orderData['order_net_amount']+$rewardPoints)),2);
					}
					
					//CommonHelper::printArray($cartProduct); die();
					$orderData['prodCharges'][CART::CART_KEY_PREFIX_PRODUCT.$productInfo['selprod_id']] = array(
						OrderProduct::CHARGE_TYPE_SHIPPING => array(
							'amount' => $cartProduct['shipping_cost']
						),
						OrderProduct::CHARGE_TYPE_TAX =>array(
							'amount' => $cartProduct['tax']
						),
						OrderProduct::CHARGE_TYPE_DISCOUNT =>array(
							'amount' => -$discount /*[Should be negative value]*/
						),
						OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT =>array(
							'amount' => -$usedRewardPoint
						), 
						/* OrderProduct::CHARGE_TYPE_BATCH_DISCOUNT => array(
							'amount' => -$cartProduct['batch_discount_single_product'] */
						 OrderProduct::CHARGE_TYPE_VOLUME_DISCOUNT => array(
							'amount'	=>	-$cartProduct['volume_discount_total']
						), 
					);
							
			}
		}
		
		$orderData['order_affiliate_user_id'] = $order_affiliate_user_id;
		$orderData['order_affiliate_total_commission'] = $order_affiliate_total_commission;
		/* ] */
		/* ] */				
		$orderObj = new Orders();
		if( $orderObj->addUpdateOrder( $orderData ,$this->siteLangId) ){
			$order_id = $orderObj->getOrderId();
		} else {			
			Message::addErrorMessage($orderObj->getError());
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$srch = Orders::getSearchObject();
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addCondition( 'order_id', '=', $order_id );
		$srch->addCondition( 'order_is_paid', '=', Orders::ORDER_IS_PENDING );
		$rs = $srch->getResultSet();
		$orderInfo = FatApp::getDb()->fetch( $rs );
		/* $orderInfo = $orderObj->getOrderById( $order_id, $this->siteLangId, array('payment_status' => 0) ); */
		if( !$orderInfo ){
			$this->cartObj->clear();
			FatApp::redirectUser( CommonHelper::generateUrl('Buyer', 'viewOrder', array($order_id) ) );
		}
		$WalletPaymentForm = $this->getWalletPaymentForm( $this->siteLangId );
		$userWalletBalance = User::getUserBalance($userId,true);
			
		if( (FatUtility::convertToType($userWalletBalance,FatUtility::VAR_FLOAT) >= FatUtility::convertToType($cartSummary['cartWalletSelected'],FatUtility::VAR_FLOAT) ) && $cartSummary['cartWalletSelected'] ){ 
			$WalletPaymentForm->addFormTagAttribute('action', CommonHelper::generateUrl('WalletPay','Charge', array($order_id)) );
			$WalletPaymentForm->fill( array('order_id' => $order_id) );
			$WalletPaymentForm->setFormTagAttribute('onsubmit', 'confirmOrder(this); return(false);');
			$WalletPaymentForm->addSubmitButton( '', 'btn_submit', Labels::getLabel('LBL_Pay_Now', $this->siteLangId) );
		}
		
		$redeemRewardFrm = $this->getRewardsForm($this->siteLangId);	
		
		$this->set('redeemRewardFrm', $redeemRewardFrm );
		$cartHasPhysicalProduct = false;
		if( $this->cartObj->hasPhysicalProduct() ){
			$cartHasPhysicalProduct = true;
		}
		
		$excludePaymentGatewaysArr = applicationConstants::getExcludePaymentGatewayArr();
		
		$this->set('cartHasPhysicalProduct',$cartHasPhysicalProduct);
		$this->set( 'paymentMethods', $paymentMethods );
		$this->set( 'excludePaymentGatewaysArr', $excludePaymentGatewaysArr );
		$this->set('cartSummary', $cartSummary );
		$this->set( 'orderInfo', $orderInfo );
		$this->set('userWalletBalance', $userWalletBalance );
		$this->set('WalletPaymentForm', $WalletPaymentForm );
		$this->_template->render(false, false );
	}
	
	public function PaymentTab( $order_id, $pmethod_id ){
		$pmethod_id = FatUtility::int( $pmethod_id );
		if( !$pmethod_id ){
			FatUtility::dieWithError( Labels::getLabel("MSG_Invalid_Request!", $this->siteLangId) );
		}
		
		if( !UserAuthentication::isUserLogged() ){
			/* Message::addErrorMessage( Labels::getLabel('MSG_Your_Session_seems_to_be_expired.', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() ); */
			FatUtility::dieWithError( Labels::getLabel('MSG_Your_Session_seems_to_be_expired.', $this->siteLangId) ); 
		}
		
		$srch = Orders::getSearchObject();
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addCondition( 'order_id', '=', $order_id );
		$srch->addCondition( 'order_is_paid', '=', Orders::ORDER_IS_PENDING );
		$rs = $srch->getResultSet();
		$orderInfo = FatApp::getDb()->fetch( $rs );
		/* $orderObj = new Orders();
		$orderInfo = $orderObj->getOrderById( $order_id, $this->siteLangId, array('payment_status' => 0) ); */
		if ( !$orderInfo ){
			/* Message::addErrorMessage( Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId) );
			$this->set('error', Message::getHtml() ); */
			FatUtility::dieWithError( Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId) );
		}
		
		//commonHelper::printArray($orderInfo);
		
		$pmSrch = PaymentMethods::getSearchObject( $this->siteLangId );
		$pmSrch->doNotCalculateRecords();
		$pmSrch->doNotLimitRecords();
		$pmSrch->addMultipleFields(array('pmethod_id', 'IFNULL(pmethod_name, pmethod_identifier) as pmethod_name', 'pmethod_code', 'pmethod_description'));
		$pmSrch->addCondition('pmethod_id','=',$pmethod_id);
		$pmRs = $pmSrch->getResultSet();
		$paymentMethod = FatApp::getDb()->fetch($pmRs);
		//var_dump($paymentMethod);
		if( !$paymentMethod ){
			FatUtility::dieWithError( Labels::getLabel("MSG_Selected_Payment_method_not_found!", $this->siteLangId) );
		}
		
		$frm = $this->getPaymentTabForm( $this->siteLangId, $paymentMethod['pmethod_code'] );
		$controller = $paymentMethod['pmethod_code'].'Pay';
		$frm->setFormTagAttribute('action',CommonHelper::generateUrl( $controller, 'charge', array($orderInfo['order_id']) ) );
		$frm->fill(array(
			'order_type' => $orderInfo['order_type'],
			'order_id' => $order_id,
			'pmethod_id' => $pmethod_id
			)
		);
		
		$this->set( 'orderInfo', $orderInfo );
		$this->set('paymentMethod', $paymentMethod);
		$this->set('frm', $frm);
		/* Partial Payment is not allowed, Wallet + COD, So, disabling COD in case of Partial Payment Wallet Selected. [ */
		if( strtolower($paymentMethod['pmethod_code']) == "cashondelivery" ){
			if( $this->cartObj->hasDigitalProduct() ){
				$str = Labels::getLabel( 'MSG_{COD}_is_not_available_if_your_cart_has_any_Digital_Product', $this->siteLangId );
				$str = str_replace( '{cod}', $paymentMethod['pmethod_name'], $str );
				FatUtility::dieWithError( $str );
			}
			$cartSummary = $this->cartObj->getCartFinancialSummary($this->siteLangId);
			$user_id = UserAuthentication::getLoggedUserId();
			$userWalletBalance = User::getUserBalance($user_id,true);
		
			if( $cartSummary['cartWalletSelected'] && $userWalletBalance < $cartSummary['orderNetAmount'] ){
				$str = Labels::getLabel('MSG_Wallet_can_not_be_used_along_with_{COD}', $this->siteLangId );
				$str = str_replace( '{cod}', $paymentMethod['pmethod_name'], $str );
				FatUtility::dieWithError( $str );
				//$this->set('error', $str );
			}
		}
		/* ] */
		$this->_template->render( false, false, '', false, false );
	}
	
	public function walletSelection(){
		$post = FatApp::getPostedData();
		$payFromWallet = $post['payFromWallet'];
		//$this->cartObj = new Cart();
		$this->cartObj->updateCartWalletOption($payFromWallet);
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function useRewardPoints(){	
		$post = FatApp::getPostedData();
	
		if( false == $post ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if( empty($post['redeem_rewards']) ){ 
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$rewardPoints = $post['redeem_rewards'];
		$totalBalance = UserRewardBreakup::rewardPointBalance(UserAuthentication::getLoggedUserId());
		/* var_dump($totalBalance);exit; */
		if($totalBalance == 0 || $totalBalance < $rewardPoints){
			Message::addErrorMessage(Labels::getLabel('ERR_Insufficient_reward_point_balance',$this->siteLangId));
			FatUtility::dieJsonError( Message::getHtml() );	
		}
		
		$cartObj = new Cart();
		$cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
		$rewardPointValues = min(CommonHelper::convertRewardPointToCurrency($rewardPoints),$cartSummary['cartTotal']);
		$rewardPoints = CommonHelper::convertCurrencyToRewardPoint($rewardPointValues);
		
		if($rewardPoints < FatApp::getConfig('CONF_MIN_REWARD_POINT') || $rewardPoints > FatApp::getConfig('CONF_MAX_REWARD_POINT')){
			$msg = Labels::getLabel('ERR_PLEASE_USE_REWARD_POINT_BETWEEN_{MIN}_to_{MAX}',$this->siteLangId);
			$msg = str_replace('{MIN}',FatApp::getConfig('CONF_MIN_REWARD_POINT'),$msg);
			$msg = str_replace('{MAX}',FatApp::getConfig('CONF_MAX_REWARD_POINT'),$msg);
			Message::addErrorMessage($msg);
			FatUtility::dieJsonError( Message::getHtml() );	
		}
		
		if(!$cartObj->updateCartUseRewardPoints($rewardPoints)){
			Message::addErrorMessage( Labels::getLabel('LBL_Action_Trying_Perform_Not_Valid', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}

		$this->set( 'msg', Labels::getLabel("MSG_Used_Reward_point", $this->siteLangId).'-'.$rewardPoints );
		$this->_template->render(false, false, 'json-success.php');			
	}
	
	public function removeRewardPoints(){
		$cartObj = new Cart();
		if(!$cartObj->removeUsedRewardPoints()){
			Message::addErrorMessage( Labels::getLabel('LBL_Action_Trying_Perform_Not_Valid', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$this->set( 'msg', Labels::getLabel("MSG_used_reward_point_removed", $this->siteLangId) );
		$this->_template->render(false, false, 'json-success.php');	
	}
	
	public function ConfirmOrder(){ 
		$order_type = FatApp::getPostedData('order_type', FatUtility::VAR_INT, 0);
		
		/* Loading Money to wallet[ */
		if( $order_type == Orders::ORDER_WALLET_RECHARGE ){
			$criteria = array( 'isUserLogged' => true );
			if( !$this->isEligibleForNextStep( $criteria ) ){
				if( Message::getErrorCount() > 0 ){
					$errMsg = Message::getHtml();
				} else {
					Message::addErrorMessage(Labels::getLabel('MSG_Something_went_wrong,_please_try_after_some_time.', $this->siteLangId));
					$errMsg = Message::getHtml();
				}
				FatUtility::dieWithError( $errMsg );
			}
			
			$user_id = UserAuthentication::getLoggedUserId();
			$pmethod_id = FatApp::getPostedData( 'pmethod_id', FatUtility::VAR_INT, 0  );
			$paymentMethodRow = PaymentMethods::getAttributesById( $pmethod_id );			
			if( !$paymentMethodRow || $paymentMethodRow['pmethod_active'] != applicationConstants::ACTIVE ){
				Message::addErrorMessage( Labels::getLabel("LBL_Invalid_Payment_method,_Please_contact_Webadmin.", $this->siteLangId ) );
				FatUtility::dieWithError( Message::getHtml() );
			}
			
			$order_id = FatApp::getPostedData( "order_id", FatUtility::VAR_STRING, "" );
			if( $order_id == '' ){
				Message::addErrorMessage( Labels::getLabel('MSG_INVALID_Request', $this->siteLangId) );
				FatUtility::dieWithError( Message::getHtml() );
			}
			$orderObj = new Orders();
			
			$srch = Orders::getSearchObject();
			$srch->doNotCalculateRecords();
			$srch->doNotLimitRecords();
			$srch->addCondition( 'order_id', '=', $order_id );
			$srch->addCondition( 'order_user_id', '=', $user_id );
			$srch->addCondition( 'order_is_paid', '=', Orders::ORDER_IS_PENDING );
			$srch->addCondition( 'order_type', '=', Orders::ORDER_WALLET_RECHARGE );
			$rs = $srch->getResultSet();
			$orderInfo = FatApp::getDb()->fetch( $rs );
			if( !$orderInfo ){
				Message::addErrorMessage( Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId) );
				FatUtility::dieWithError( Message::getHtml() );
			}
			$this->cartObj->clear();
			$this->cartObj->updateUserCart();
			$orderObj->updateOrderInfo($order_id, array('order_pmethod_id' => $pmethod_id) );
			$this->_template->render(false, false, 'json-success.php');
		}
		/* ] */
		
		/* ConfirmOrder function is called for both wallet payments and for paymentgateway selection as well. */
		$criteria = array( 'isUserLogged' => true, 'hasProducts' => true, 'hasStock' => true, 'hasBillingAddress' => true );
		if( $this->cartObj->hasPhysicalProduct() ){
			$criteria['hasShippingAddress'] = true;
			$criteria['isProductShippingMethodSet'] = true;
		}
		if( !$this->isEligibleForNextStep( $criteria ) ){
			if( Message::getErrorCount() > 0 ){
				$errMsg = Message::getHtml();
			} else {
				Message::addErrorMessage(Labels::getLabel('MSG_Something_went_wrong,_please_try_after_some_time.', $this->siteLangId));
				$errMsg = Message::getHtml();
			}
			FatUtility::dieWithError( $errMsg );
		}
		$user_id = UserAuthentication::getLoggedUserId();
		$cartSummary = $this->cartObj->getCartFinancialSummary($this->siteLangId);
		$userWalletBalance = User::getUserBalance($user_id,true);
		$pmethod_id = FatApp::getPostedData( 'pmethod_id', FatUtility::VAR_INT, 0  );
			
		if( $cartSummary['cartWalletSelected'] && (FatUtility::convertToType($userWalletBalance,FatUtility::VAR_FLOAT) >= FatUtility::convertToType($cartSummary['cartWalletSelected'],FatUtility::VAR_FLOAT) ) && !$pmethod_id ){ 
			$this->_template->render(false, false, 'json-success.php');
			exit;
		}
		
		$post = FatApp::getPostedData();
		// commonHelper::printArray($post); die;
		
		$paymentMethodRow = PaymentMethods::getAttributesById( $pmethod_id );
		
		if( !$paymentMethodRow || $paymentMethodRow['pmethod_active'] != applicationConstants::ACTIVE ){
			Message::addErrorMessage( Labels::getLabel("LBL_Invalid_Payment_method,_Please_contact_Webadmin.", $this->siteLangId ) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if( strtolower($paymentMethodRow['pmethod_code']) == 'cashondelivery' && FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'' && FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY',FatUtility::VAR_STRING,'')!= '')){
			if( !CommonHelper::verifyCaptcha() ) {
				Message::addErrorMessage(Labels::getLabel('MSG_That_captcha_was_incorrect',$this->siteLangId));						
				FatUtility::dieWithError( Message::getHtml() );
				//FatApp::redirectUser(CommonHelper::generateUrl('Custom', 'ContactUs'));
			}
		}
		
		/* Enable it if we add Shipping Users in Project Check, System have shipping company user added or nor, if not, then COD is not allowed for Project[ */
		/* if( strtolower($paymentMethodRow['pmethod_code']) == 'cashondelivery' ){
			if( !CommonHelper::verifyCaptcha() ) {
				Message::addErrorMessage(Labels::getLabel('MSG_That_captcha_was_incorrect',$this->siteLangId));						
				FatUtility::dieWithError( Message::getHtml() );
				//FatApp::redirectUser(CommonHelper::generateUrl('Custom', 'ContactUs'));
			}
			$srch = User::getSearchObject( true );
			$srch->doNotCalculateRecords();
			$srch->setPageSize(1);
			$srch->addCondition( 'user_type', '=', User::USER_TYPE_SHIPPING_COMPANY );
			$srch->addCondition( 'uc.credential_active', '=', applicationConstants::ACTIVE );
			$srch->addCondition( 'uc.credential_verified', '=', applicationConstants::YES );
			$srch->addMultipleFields( array('user_id') );
			$rs = $srch->getResultSet();
			$userRow = FatApp::getDb()->fetch($rs);
			if( !$userRow ){
				$str = Labels::getLabel("LBL_{paymentMethodName}_is_not_available_as_Shipping_Company_is_not_added_by_admin_as_yet.", $this->siteLangId );
				$str = str_replace('{paymentmethodname}', $paymentMethodRow['pmethod_identifier'] , $str);
				Message::addErrorMessage( $str );
				FatUtility::dieWithError( Message::getHtml() );
			}
		} */
		/* ] */
		
		if( $userWalletBalance >= $cartSummary['orderNetAmount'] && $cartSummary['cartWalletSelected'] && !$pmethod_id ){
			$frm = $this->getWalletPaymentForm( $this->siteLangId );
		} else {
			$frm = $this->getPaymentTabForm( $this->siteLangId );
		}
		
		$post = $frm->getFormDataFromArray( $post );
		if( !isset($post['order_id']) || $post['order_id'] == '' ){
			Message::addErrorMessage( Labels::getLabel('MSG_INVALID_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		$orderObj = new Orders();
		$order_id = $post['order_id'];
		
		$srch = Orders::getSearchObject();
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addCondition( 'order_id', '=', $order_id );
		$srch->addCondition( 'order_user_id', '=', $user_id );
		$srch->addCondition( 'order_is_paid', '=', Orders::ORDER_IS_PENDING );
		$rs = $srch->getResultSet();
		$orderInfo = FatApp::getDb()->fetch( $rs );
		if( !$orderInfo ){
			Message::addErrorMessage( Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if( $cartSummary['cartWalletSelected'] && $cartSummary['orderPaymentGatewayCharges'] == 0 ){
			Message::addErrorMessage( Labels::getLabel('MSG_Try_to_pay_using_wallet_balance_as_amount_for_payment_gateway_is_not_enough.', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if( $cartSummary['orderPaymentGatewayCharges'] == 0 && $pmethod_id ){
			Message::addErrorMessage( Labels::getLabel('MSG_Amount_for_payment_gateway_must_be_greater_than_zero.', $this->siteLangId ) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if( $pmethod_id ){
			$_SESSION['cart_order_id'] = $order_id;
			$orderObj->updateOrderInfo($order_id, array('order_pmethod_id' => $pmethod_id) );
			$this->cartObj->clear();
			$this->cartObj->updateUserCart(); 
		}
		
		/* if ( !$orderObj->addOrderHistory( $order_id, 1, Labels::getLabel("LBL_-NA-",$this->siteLangId), true, $this->siteLangId ) ){
			Message::addErrorMessage( $orderObj->getError() );
			FatUtility::dieWithError( Message::getHtml() );
		} */
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function editAddress(){
		$post = FatApp::getPostedData();
		$address_id = isset( $post['address_id'] ) ? FatUtility::int( $post['address_id'] ) : 0;
		$addressFrm = $this->getUserAddressForm( $this->siteLangId );
		$address =  UserAddress::getUserAddresses( UserAuthentication::getLoggedUserId(), $this->siteLangId, 0, $address_id );
		if($address_id){
			
			$stateId =  $address['ua_state_id']; 
		}else{
			$stateId = 0;
		}
		$addressFrm->fill( $address );
		$this->set('addressFrm', $addressFrm );
		$this->set('address_id', $address_id );
		if($address_id>0){
				$labelHeading =  Labels::getLabel( 'LBL_Edit_Address', $this->siteLangId );
		}else{
			$labelHeading =  Labels::getLabel( 'LBL_Add_Address', $this->siteLangId );
		}
		$this->set('labelHeading',$labelHeading);
		$this->set('stateId', $stateId );
		$this->_template->render(false, false, 'checkout/address-form.php' );
	}
	
	private function getCheckoutAddressForm( $langId ){
		$frm = new Form('frmAddress');
		$addresses = UserAddress::getUserAddresses( UserAuthentication::getLoggedUserId(), $langId );
		$addressAssoc = array();
		foreach( $addresses as $address ){
			$city = $address['ua_city'];
			$state = ( strlen($address['ua_city']) > 0 ) ? ', '. $address['state_name'] : $address['state_name'];
			$country = ( strlen($state) > 0 ) ? ', '.$address['country_name'] : $address['country_name']; 
			$location = $city . $state. $country;
			$addressAssoc[$address['ua_id']] = $location;
		}
		$frm->addRadioButtons('', 'shipping_address_id', $addressAssoc );
		$frm->addRadioButtons('', 'billing_address_id', $addressAssoc );
		return $frm;
	}
	
	private function getShippingApiForm( $langId ){
		$srch = ShippingMethods::getListingObj( $langId , array('shippingapi_id') );
		$srch->doNotCalculateRecords();
		$rs = $srch->getResultSet();
		$shippingApis = FatApp::getDb()->fetchAllAssoc($rs);
		$frm = new Form('frmShippingApi');
		$frm->addSelectBox( Labels::getLabel('MSG_Select_Shipping_Type', $langId), 'shippingapi_id', $shippingApis, '', array(), '' )->requirements()->setRequired();
		/* $frm->addSubmitButton( '', 'btn_submit', Labels::getLabel('LBL_Continue', $langId) ); */
		return $frm;
	}
	
	private function getShippingMethods( $langId ){
		$srch = ShippingMethods::getListingObj( $langId , array('shippingapi_id') );
		$srch->doNotCalculateRecords();
		$rs = $srch->getResultSet();
		$shippingApis = FatApp::getDb()->fetchAllAssoc($rs);
		
		return $shippingApis;
	}
	
	private function getPaymentTabForm( $langId, $paymentMethodCode = '' ){
		$frm = new Form('frmPaymentTabForm');
		$frm->setFormTagAttribute('id', 'frmPaymentTabForm');
		
		if( strtolower($paymentMethodCode) == "cashondelivery" && FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'')!= '' && FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY',FatUtility::VAR_STRING,'')!= ''){
			$frm->addHtml('htmlNote', 'htmlNote','<div class="g-recaptcha" data-sitekey="'.FatApp::getConfig('CONF_RECAPTCHA_SITEKEY',FatUtility::VAR_STRING,'').'"></div>');
		}
		$frm->addSubmitButton( '', 'btn_submit', Labels::getLabel('LBL_Confirm_Payment', $langId) );
		$frm->addHiddenField( '', 'order_type' );
		$frm->addHiddenField('','order_id');
		$frm->addHiddenField('','pmethod_id');
		return $frm;
	}
	
	private function getWalletPaymentForm( $langId ){
		$frm = new Form('frmWalletPayment');
		$frm->addHiddenField('','order_id');
		return $frm;
	}
	
	private function getRewardsForm($langId){
		$langId = FatUtility::int($langId);
		$frm = new Form('frmRewards');
		$frm->addTextBox(Labels::getLabel('LBL_Reward_Points',$langId),'redeem_rewards','',array('placeholder'=>Labels::getLabel('LBL_Use_Reward_Point',$langId)));
		$frm->addSubmitButton('', 'btn_submit',Labels::getLabel('LBL_Apply',$langId));		
		return $frm;
	}
	
	public function resetShippingSummary(){
		$this->_template->render(false,false);
	}
	
	public function resetCartReview(){
		$cartHasPhysicalProduct = false;
		if( $this->cartObj->hasPhysicalProduct() ){
			$cartHasPhysicalProduct = true;
		}
		$this->set('cartHasPhysicalProduct',$cartHasPhysicalProduct);
		$this->_template->render(false,false);
	}
	
	public function resetPaymentSummary(){
		$cartHasPhysicalProduct = false;
		if( $this->cartObj->hasPhysicalProduct() ){
			$cartHasPhysicalProduct = true;
		}
		$this->set('cartHasPhysicalProduct',$cartHasPhysicalProduct);
		$this->_template->render(false,false);
	}
	
	public function loadCartReview(){
		$cartHasPhysicalProduct = false;
		if( $this->cartObj->hasPhysicalProduct() ){
			$cartHasPhysicalProduct = true;
		}
		$products = $this->cartObj->getProducts($this->siteLangId);
		$this->set('cartHasPhysicalProduct',$cartHasPhysicalProduct);
		$this->set('products',$products);
		$this->_template->render(false,false);
	}
	
	public function loadShippingSummary(){
		$products = $this->cartObj->getProducts($this->siteLangId);
		$this->set('products', $products );
		$this->_template->render(false,false);
	}
	
	public function removeShippingSummary(){
		$this->cartObj->removeProductShippingMethod( );
		
	}
	
	public function getFinancialSummary(){
		$cartSummary = $this->cartObj->getCartFinancialSummary($this->siteLangId);
		//CommonHelper::printArray($cartSummary); die();
		$products = $this->cartObj->getProducts($this->siteLangId);
		$this->set('products', $products );
		$this->set('cartSummary', $cartSummary );
		$this->_template->render(false, false );
	}
	
	public function getCouponForm(){
		/* if( !UserAuthentication::isUserLogged() ){
			Message::addErrorMessage(Labels::getLabel('MSG_Your_Session_seems_to_be_expired.', $this->siteLangId));
			FatUtility::dieWithError( Message::getHtml() );
		} */
		$loggedUserId = UserAuthentication::getLoggedUserId();
		
		$couponsList = DiscountCoupons::getValidCoupons( $loggedUserId, $this->siteLangId );
		$this->set( 'couponsList', $couponsList );
		
		$PromoCouponsFrm = $this->getPromoCouponsForm($this->siteLangId); 
		$this->set('PromoCouponsFrm', $PromoCouponsFrm ); 
		$this->_template->render(false, false);
	}
	
	private function getPromoCouponsForm($langId){
		$langId = FatUtility::int($langId);
		$frm = new Form('frmPromoCoupons');
		$fld = $frm->addTextBox(Labels::getLabel('LBL_Coupon_code',$langId),'coupon_code','',array('placeholder'=>Labels::getLabel('LBL_Enter_Your_code',$langId)));
		$fld->requirements()->setRequired();
		$frm->addSubmitButton('', 'btn_submit',Labels::getLabel('LBL_Apply',$langId));		
		return $frm;
	}
}