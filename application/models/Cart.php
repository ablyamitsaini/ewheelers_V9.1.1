<?php
class Cart extends FatModel {
	private $products = array();
	private $SYSTEM_ARR = array();
	private $warning;
	
	const CART_KEY_PREFIX_PRODUCT = 'SP_'; /* SP stands for Seller Product */
	const CART_KEY_PREFIX_BATCH = 'SB_'; /* SB stands for Seller Batch/Combo Product */
	const TYPE_PRODUCT = 1;
	const TYPE_SUBSCRIPTION = 2;
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
			if ( $user_id > 0 ){
				$this->cart_user_id = $user_id;
			}else{
				$this->cart_user_id = UserAuthentication::getLoggedUserId();
			}
		}
		
		$srch = new SearchBase('tbl_user_cart');
		$srch->addCondition('usercart_user_id', '=', $this->cart_user_id );
		$srch->addCondition('usercart_type', '=',CART::TYPE_PRODUCT);
		$rs = $srch->getResultSet();
		if( $row = FatApp::getDb()->fetch($rs) ){
			$this->SYSTEM_ARR['cart'] = unserialize( $row["usercart_details"] );
			if( isset($this->SYSTEM_ARR['cart']['shopping_cart']) ){
				$this->SYSTEM_ARR['shopping_cart'] = $this->SYSTEM_ARR['cart']['shopping_cart'];
				unset($this->SYSTEM_ARR['cart']['shopping_cart']);
			}
		}

		if ( !isset( $this->SYSTEM_ARR['cart'] ) || !is_array( $this->SYSTEM_ARR['cart'] ) ) {
			$this->SYSTEM_ARR['cart'] = array();
		}
		if( !isset($this->SYSTEM_ARR['shopping_cart']) || !is_array($this->SYSTEM_ARR['shopping_cart']) ){
			$this->SYSTEM_ARR['shopping_cart'] = array();
		}
	}
	
	public static function getCartKeyPrefixArr(){
		return array(
			static::CART_KEY_PREFIX_PRODUCT =>	static::CART_KEY_PREFIX_PRODUCT,
			static::CART_KEY_PREFIX_BATCH	=>	static::CART_KEY_PREFIX_BATCH,
		);
	}
	
	public static function getCartUserId(){
		$cart_user_id = session_id();
		if ( UserAuthentication::isUserLogged()  ){
			$cart_user_id = UserAuthentication::getLoggedUserId();
		}
		return $cart_user_id;
	}
	
	public static function getCartData($userId){
		$srch = new SearchBase('tbl_user_cart');
		$srch->addCondition('usercart_user_id', '=', $userId );
		$srch->addCondition('usercart_type', '=', CART::TYPE_PRODUCT );
		$rs = $srch->getResultSet();
		if( $row = FatApp::getDb()->fetch($rs) ){
			return $row["usercart_details"];
		}
		return;		
	}
	
	public function add( $selprod_id, $qty = 1, $prodgroup_id = 0 ){
		$this->products = array();
		$selprod_id = FatUtility::int( $selprod_id );
		$prodgroup_id = FatUtility::int( $prodgroup_id );
		
		if ( $qty > 0 ) {
			$key = static::CART_KEY_PREFIX_PRODUCT . $selprod_id; 
			if( $prodgroup_id ){
				$key = static::CART_KEY_PREFIX_BATCH . $prodgroup_id; 
			}
			
			$key = base64_encode(serialize($key));
			if (!isset($this->SYSTEM_ARR['cart'][$key])) {
				$this->SYSTEM_ARR['cart'][$key] = FatUtility::int($qty);
			} else {
				$this->SYSTEM_ARR['cart'][$key] += FatUtility::int($qty);
			}
		}
		
		if( $prodgroup_id > 0){
			$products = $this->getProducts( $this->cart_lang_id );
			if( $products ){
				foreach( $products as $cartKey => $product ){
					if( $product['is_batch'] && $prodgroup_id == $product['prodgroup_id'] ){
						foreach( $product['products'] as $pgProduct ){
							$this->updateTempStockHold( $pgProduct['selprod_id'], $this->SYSTEM_ARR['cart'][$key], $product['prodgroup_id'] );
						}
					}
				}
			}
		} else {
			$this->updateTempStockHold( $selprod_id, $this->SYSTEM_ARR['cart'][$key] );
		}
		
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
			if($product['is_batch'] && !empty($product['products'])){
				foreach($product['products'] as $pgproduct){
					if( $pgproduct['is_digital_product'] ){
						$isDigital = true;
						break;
					}
				}
			}else{
				if( $product['is_digital_product'] ){
					$isDigital = true;
					break;
				}
			}
		}
		$this->products = array();
		return $isDigital;
	}
		
	public function hasPhysicalProduct(){
		$isPhysical = false;
		foreach ($this->getProducts($this->cart_lang_id) as $product) {
			if($product['is_batch'] && !empty($product['products'])){
				foreach($product['products'] as $pgproduct){
					if( $pgproduct['is_physical_product'] ){
						$isPhysical = true;
						break;
					}
				}
			}else{
				if( $product['is_physical_product'] ){
					$isPhysical = true;
					break;
				}
			}
		}
		$this->products = array();
		return $isPhysical;
	}
		
	public function getProducts( $siteLangId = 0 ){
		/* CommonHelper::printArray($this->SYSTEM_ARR['cart']); die(); */
		
		/* if( !$siteLangId ){
			trigger_error("Language Id not specified.", E_USER_ERROR);
		} */
		if( !$this->products ){
			$productSelectedShippingMethodsArr = $this->getProductShippingMethod();
			$maxConfiguredCommissionVal = FatApp::getConfig("CONF_MAX_COMMISSION",FatUtility::VAR_INT,0);
			
			$db = FatApp::getDb();
			$prodGroupQtyArr = array();
			$prodGroupPriceArr = array();
			
			$associatedAffiliateUserId = 0;
			/* detect current logged user has associated affiliate user[ */
			if( UserAuthentication::isUserLogged() ){
				$loggedUserId = UserAuthentication::getLoggedUserId();
				$associatedAffiliateUserId = User::getAttributesById( $loggedUserId, 'user_affiliate_referrer_user_id');
				if( $associatedAffiliateUserId > 0 ){
					$prodObj = new Product();
				}
			}
			/* ] */
	
			$is_cod_enabled = true;	
			foreach ( $this->SYSTEM_ARR['cart'] as $key => $quantity ) {
				$selprod_id = 0;
				$prodgroup_id = 0;
				$sellerProductRow = array();
				
				$affiliateCommissionPercentage = '';
				$affiliateCommission = 0;
				
				$keyDecoded = unserialize( base64_decode($key) );
				 if( strpos($keyDecoded, static::CART_KEY_PREFIX_PRODUCT ) !== FALSE ){
					$selprod_id = FatUtility::int(str_replace( static::CART_KEY_PREFIX_PRODUCT, '', $keyDecoded ));
				} 	
				/* CommonHelper::printArray($keyDecoded); die; */
				// if( strpos($keyDecoded, static::CART_KEY_PREFIX_BATCH ) !== FALSE ){
					// $prodgroup_id = FatUtility::int(str_replace( static::CART_KEY_PREFIX_BATCH, '', $keyDecoded ));
				// }
				
				$this->products[$key]['shipping_cost'] = 0;
				$this->products[$key]['sduration_id'] = 0;
				$this->products[$key]['commission_percentage'] = '';
				$this->products[$key]['commission'] = 0;
				
				
				$this->products[$key]['tax'] = 0;
				$this->products[$key]['reward_point'] = 0;
				$this->products[$key]['volume_discount'] = 0;
				$this->products[$key]['volume_discount_total'] = 0;
								
				/* seller products[ */
				if( $selprod_id > 0 ){
					$sellerProductRow = $this->getSellerProductData( $selprod_id, $quantity, $siteLangId ); 
					/* echo "<pre>"; var_dump($sellerProductRow); */					
					if( !$sellerProductRow ){
						$this->removeCartKey( $key );
						continue;
					}
					$this->products[$key] = $sellerProductRow;
					
					/*[COD available*/
					$codEnabled = false;
					if($is_cod_enabled && Product::isProductShippedBySeller($sellerProductRow['product_id'],$sellerProductRow['product_seller_id'],$sellerProductRow['selprod_user_id'])){
						if($sellerProductRow['selprod_cod_enabled']){
							$codEnabled = true;
						}
					}else{
						if($sellerProductRow['product_cod_enabled']){
							$codEnabled = true;
						}
					}
					$is_cod_enabled = $codEnabled;
					/* ]*/
					
					/*[ Product shipping cost */
					$shippingCost = 0;
					if( !empty($productSelectedShippingMethodsArr['product']) && isset($productSelectedShippingMethodsArr['product'][$sellerProductRow['selprod_id']]) ){
						$shippingDurationRow = $productSelectedShippingMethodsArr['product'][$sellerProductRow['selprod_id']];
						$this->products[$key]['sduration_id'] = isset($shippingDurationRow['sduration_id'])?$shippingDurationRow['sduration_id']:'';
						$shippingCost = ROUND(($shippingDurationRow['mshipapi_cost'] ), 2);
						$this->products[$key]['shipping_cost'] = $shippingCost;
					}
					/*]*/
					
					/*[ Product Tax */
					$taxObj = new Tax();
					$tax = $taxObj->calculateTaxRates($sellerProductRow['product_id'],$sellerProductRow['theprice'],$sellerProductRow['selprod_user_id'],$siteLangId,$quantity);
					$this->products[$key]['tax'] = $tax;
					/*]*/
					
					/*[ Product Commission */
					$commissionPercentage = SellerProduct::getProductCommission( $sellerProductRow['selprod_id'] );
					$commissionCostValue = $sellerProductRow['theprice'];
					
					if(FatApp::getConfig('CONF_COMMISSION_INCLUDING_TAX',FatUtility::VAR_INT,0) && $tax){
						$commissionCostValue = $commissionCostValue + ( $tax / $quantity ); 
					}
					
					if(FatApp::getConfig('CONF_COMMISSION_INCLUDING_SHIPPING',FatUtility::VAR_INT,0) && $shippingCost ){
						$commissionCostValue = $commissionCostValue + ( $shippingCost / $quantity);
					}	
					
					$commissionCostValue =  ROUND(( $commissionCostValue * $quantity), 2 );					
					$commission = ROUND(($commissionCostValue * $commissionPercentage/100), 2);
					$commission = MIN($commission,$maxConfiguredCommissionVal);
					
					$this->products[$key]['commission_percentage'] = $commissionPercentage;
					$this->products[$key]['commission'] = ROUND( $commission, 2 );
					/*]*/
					
					/* Affiliate Commission[ */
					if( $associatedAffiliateUserId > 0 ){
						$affiliateCommissionPercentage = AffiliateCommission::getAffiliateCommission( $associatedAffiliateUserId, $sellerProductRow['product_id'], $prodObj );
						$affiliateCommissionCostValue =  ROUND( $sellerProductRow['theprice'] * $quantity, 2 );
						$affiliateCommission = ROUND( $affiliateCommissionCostValue * $affiliateCommissionPercentage/100, 2 );
					}
					/* ] */
					
				}else{
					$is_cod_enabled = false;
				}
				/* ] */			
				
				$this->products[$key]['key'] = $key;
				$this->products[$key]['is_batch'] = 0;
				$this->products[$key]['is_cod_enabled'] = $is_cod_enabled;
				$this->products[$key]['selprod_id'] = $selprod_id;
				$this->products[$key]['quantity'] = $quantity;
				$this->products[$key]['has_physical_product'] = 0;
				$this->products[$key]['has_digital_product'] = 0;
				/* $this->products[$key]['product_ship_free'] = $sellerProductRow['product_ship_free']; */
				$this->products[$key]['is_shipping_selected'] = false;
				$this->products[$key]['affiliate_commission_percentage'] = $affiliateCommissionPercentage;
				$this->products[$key]['affiliate_commission'] = $affiliateCommission;
				$this->products[$key]['affiliate_user_id'] = $associatedAffiliateUserId;
				if( UserAuthentication::isUserLogged() ){
					$this->products[$key]['shipping_address'] =  UserAddress::getUserAddresses(UserAuthentication::getLoggedUserId(),$siteLangId, 0, $this->getCartShippingAddress() );
					$this->products[$key]['seller_address'] =  Shop::getShopAddress($sellerProductRow['shop_id'],true , $siteLangId);
				}
			}
		}	
		/* CommonHelper::printArray($this->products); die();		 */
		return $this->products;
	}
	
	public function getSellerProductData( $selprod_id, &$quantity, $siteLangId ){
		$prodSrch = new ProductSearch( $siteLangId );
		$prodSrch->setDefinedCriteria();
		$prodSrch->joinProductToCategory();
		$prodSrch->joinSellerSubscription();
		$prodSrch->addSubscriptionValidCondition();
		$prodSrch->joinProductShippedBy();
		$prodSrch->joinProductFreeShipping();
		$prodSrch->joinSellers();
		$prodSrch->doNotCalculateRecords();
		$prodSrch->doNotLimitRecords();
		$prodSrch->addCondition('selprod_id', '=', $selprod_id );
		$prodSrch->addMultipleFields(array( 'product_id', 'product_type', 'product_length', 'product_width', 'product_height','product_ship_free' ,
		'product_dimension_unit', 'product_weight', 'product_weight_unit', 
		'selprod_id','selprod_code', 'selprod_stock','selprod_user_id','IF(selprod_stock > 0, 1, 0) AS in_stock',
		'special_price_found', 'theprice', 'shop_id', 'shop_free_ship_upto',
		'splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type', 'selprod_price', 'selprod_cost','case when product_seller_id=0 then IFNULL(psbs_user_id,0)   else product_seller_id end  as psbs_user_id','product_seller_id','product_cod_enabled','selprod_cod_enabled'));
		
		if( $siteLangId ){
			$prodSrch->joinBrands();
			$prodSrch->addFld( array('IFNULL(product_name, product_identifier) as product_name','IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title','IFNULL(brand_name, brand_identifier) as brand_name','IFNULL(shop_name, shop_identifier) as shop_name') );
		}
		$rs = $prodSrch->getResultSet();
		$sellerProductRow = FatApp::getDb()->fetch($rs);
		if( !$sellerProductRow || $sellerProductRow['selprod_stock'] <= 0 ){
			Message::addErrorMessage( Labels::getLabel('MSG_Product_not_available_or_out_of_stock_so
			_removed_from_cart_listing', $siteLangId) );
			return false;
		}
		
		$productSelectedShippingMethodsArr = $this->getProductShippingMethod();
		if( ( $quantity > $sellerProductRow['selprod_stock'] ) ){
			/* requested quantity cannot more than stock available */
			$quantity = $sellerProductRow['selprod_stock'];
		}
		
		/* update/fetch/apply theprice, according to volume discount module[ */
		$sellerProductRow['volume_discount'] = 0;
		$sellerProductRow['volume_discount_percentage'] = 0;
		$sellerProductRow['volume_discount_total'] = 0;
		$srch = new SellerProductVolumeDiscountSearch();
		$srch->doNotCalculateRecords();
		$srch->addCondition( 'voldiscount_selprod_id', '=', $sellerProductRow['selprod_id'] );
		$srch->addCondition( 'voldiscount_min_qty', '<=', $quantity );
		$srch->addOrder( 'voldiscount_min_qty', 'DESC' );
		$srch->setPageSize(1);
		$srch->addMultipleFields( array('voldiscount_percentage') );
		$rs = $srch->getResultSet();
		$volumeDiscountRow = FatApp::getDb()->fetch( $rs );
		if( $volumeDiscountRow ){
			$volumeDiscount = $sellerProductRow['theprice'] * ( $volumeDiscountRow['voldiscount_percentage'] / 100 );
			//$sellerProductRow['theprice'] = $sellerProductRow['theprice'] - $volumeDiscount;
			$sellerProductRow['volume_discount_percentage'] = $volumeDiscountRow['voldiscount_percentage'];
			$sellerProductRow['volume_discount'] = $volumeDiscount;
			$sellerProductRow['volume_discount_total'] = $volumeDiscount * $quantity;
		}
		/* ] */
		
		/* set variable of shipping cost of the product, if shipping already selected[ */
		$sellerProductRow['shipping_cost'] = 0;
		$sellerProductRow['sduration_id'] = 0;
		if( !empty($productSelectedShippingMethodsArr) && isset($productSelectedShippingMethodsArr[$selprod_id]) ){
			$shippingDurationRow = $productSelectedShippingMethodsArr[$selprod_id];
			$sellerProductRow['sduration_id'] = $shippingDurationRow['sduration_id'];
			$sellerProductRow['shipping_cost'] = ROUND(($shippingDurationRow['mshipapi_cost'] * $quantity), 2);
		}
		/* ] */
		
		/* calculation of commission and tax against each product[ */
		$commission = 0;
		$tax = 0;
		$maxConfiguredCommissionVal = FatApp::getConfig("CONF_MAX_COMMISSION");
		
		$commissionPercentage = SellerProduct::getProductCommission( $selprod_id );
		$commission = MIN( ROUND( $sellerProductRow['theprice'] * $commissionPercentage/100, 2 ), $maxConfiguredCommissionVal );
		$sellerProductRow['commission_percentage'] = $commissionPercentage;
		$sellerProductRow['commission'] = ROUND( $commission * $quantity, 2 );
		
		$totalPrice = $sellerProductRow['theprice'] * $quantity;
		
		$taxObj = new Tax();
		$tax = $taxObj->calculateTaxRates($sellerProductRow['product_id'],$sellerProductRow['theprice'],$sellerProductRow['selprod_user_id'],$siteLangId,$quantity);
		
		$sellerProductRow['tax'] = $tax;
		/* ] */
		
		$sellerProductRow['total'] = $totalPrice;
		$sellerProductRow['netTotal'] = $sellerProductRow['total'] + $sellerProductRow['shipping_cost'];
		
		$sellerProductRow['is_digital_product'] = ($sellerProductRow['product_type'] == Product::PRODUCT_TYPE_DIGITAL) ? 1 : 0;
		$sellerProductRow['is_physical_product'] = ($sellerProductRow['product_type'] == Product::PRODUCT_TYPE_PHYSICAL) ? 1 : 0;
	
	
		if( $siteLangId ){
			$sellerProductRow['options'] = SellerProduct::getSellerProductOptions($selprod_id, true, $siteLangId);
		} else {
			$sellerProductRow['options'] = SellerProduct::getSellerProductOptions($selprod_id, false);
		}	
		return $sellerProductRow;
	}
	
	public function removeCartKey($key) {
		unset($this->products[$key]);
		unset($this->SYSTEM_ARR['cart'][$key]);
		$this->updateUserCart();
		return true;
	}
	
	public function remove($key){
		$this->products = array();
		$cartProducts = $this->getProducts($this->cart_lang_id);
			
		if( is_array($cartProducts) ){
			foreach($cartProducts as $cartKey=>$product){
				if( md5($product['key']) == $key && !$product['is_batch'] ){
					unset($this->SYSTEM_ARR['cart'][$cartKey]);
					
					/* to keep track of temporary hold the product stock[ */
					$this->updateTempStockHold($product['selprod_id'], 0, 0);
					/* ] */
					break;
				}
			}
		}
		$this->updateUserCart();
		return true;
	}
	
	public function removeGroup( $prodgroup_id ){
		$prodgroup_id = FatUtility::int($prodgroup_id);
		$this->products = array();
		$cartProducts = $this->getProducts($this->cart_lang_id);
		if( is_array($cartProducts) ){
			foreach( $cartProducts as $cartKey => $product ){
				if( $product['is_batch'] && $product['prodgroup_id'] == $prodgroup_id ){
					unset($this->SYSTEM_ARR['cart'][$cartKey]);
					
					/* to keep track of temporary hold the product stock[ */
					foreach( $product['products'] as $pgproduct ){
						$this->updateTempStockHold( $pgproduct['selprod_id'], 0, $prodgroup_id );
					}
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
			$cart_user_id = static::getCartUserId();
			
			if( is_array($cartProducts) ){
				foreach($cartProducts as $cartKey => $product){
					if( md5($product['key']) == $key ){
						$tempHoldStock = Product::tempHoldStockCount($product['selprod_id']);
						$availableStock = $cartProducts[$cartKey]['selprod_stock'] - $tempHoldStock;
						$userTempHoldStock = Product::tempHoldStockCount($product['selprod_id'],$cart_user_id,0,true);
						
						if( $quantity > $userTempHoldStock ){
							if($availableStock == 0 || ( $availableStock < ( $quantity - $userTempHoldStock)) ){
								$this->warning = Labels::getLabel('MSG_Requested_quantity_more_than_stock_available', $this->cart_lang_id);											
								$quantity = $userTempHoldStock + $availableStock;
							}
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
	
	public function updateGroup( $prodgroup_id, $quantity ){
		$prodgroup_id = FatUtility::int($prodgroup_id);
		$quantity = FatUtility::int($quantity);
		
		$cart_user_id = static::getCartUserId();
		/* not handled the case, if any product from the group is added separately, stock sum from that product and product in group is not checked, need to handle the same. */
		
		if ( $quantity > 0 ){
			$cartProducts = $this->getProducts( $this->cart_lang_id );
			if( is_array($cartProducts) ){
				$prodGroupQtyArr = array();
				$inStock = true;
				foreach( $cartProducts as $cartKey => $product ){					
					if( $product['is_batch'] && $product['prodgroup_id'] == $prodgroup_id ){
						foreach( $product['products'] as $pgproduct ){
							$tempHoldStock = Product::tempHoldStockCount($pgproduct['selprod_id']);
							$availableStock = $pgproduct['selprod_stock'] - $tempHoldStock; 
							$userTempHoldStock = Product::tempHoldStockCount($pgproduct['selprod_id'],$cart_user_id,$product['prodgroup_id'],true);
						
							if($availableStock == 0 || ( $availableStock < ( $quantity - $userTempHoldStock))){
								$this->warning = Labels::getLabel('MSG_Requested_quantity_more_than_stock_available', $this->cart_lang_id);
								$quantity = $userTempHoldStock + $availableStock;								
								$inStock = false;
								break;
							}
							$prodGroupQtyArr[$pgproduct['selprod_id']] = $quantity;
						}
						
						if( !$inStock ){
							break;
						}
					}
				}
				
				if( !empty($prodGroupQtyArr) ){
					$maxAvailableQty = min($prodGroupQtyArr);
					if( $quantity > $maxAvailableQty ){
						/* $msgString = str_replace("{n}", $maxAvailableQty, "MSG_One_of_the_product_in_combo_is_not_available_in_requested_quantity,_you_can_buy_upto_max_{n}_quantity."); */
						$this->warning = Labels::getLabel("MSG_One_of_the_product_in_combo_is_not_available_in_requested_quantity,_you_can_buy_upto_max_{n}_quantity.", $this->cart_lang_id);
						$this->warning = str_replace("{n}", $maxAvailableQty, $this->warning);
						return true;
					}
				}
				
				if( $inStock ){
					foreach( $cartProducts as $cartKey => $product ){
						if( $product['is_batch'] && $product['prodgroup_id'] == $prodgroup_id ){
							$this->SYSTEM_ARR['cart'][$cartKey] = $quantity;
							foreach( $product['products'] as $pgproduct ){
								$this->updateTempStockHold( $pgproduct['selprod_id'], $quantity, $prodgroup_id );
							}
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
	
	public function removeProductShippingMethod(){
		unset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']);
		$this->updateUserCart();
		return true;
	}
	
	public function getProductShippingMethod(){
		return isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']) ? $this->SYSTEM_ARR['shopping_cart']['product_shipping_methods'] : array();
	}
	
	public function isProductShippingMethodSet(){
		foreach( $this->getProducts($this->cart_lang_id) as $product ){
			if($product['is_batch']){
				if( $product['has_physical_product'] && !isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['group'][$product['prodgroup_id']]) ){
					return false;
				}
				if(isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['group'][$product['prodgroup_id']]['mshipapi_id'])){
					$mshipapi_id = $this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['group'][$product['prodgroup_id']]['mshipapi_id'];
					$manualShipingApiRow = ManualShippingApi::getAttributesById($mshipapi_id, 'mshipapi_id');
					if( !$manualShipingApiRow ){
						return false;
					}	
				}
			}else{
				
				if( $product['is_physical_product'] && !isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['product'][$product['selprod_id']]) ){
					return false;
				}
				
			
				if(isset($this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['product'][$product['selprod_id']]['mshipapi_id'])){
					 $shipapi_id = $this->SYSTEM_ARR['shopping_cart']['product_shipping_methods']['product'][$product['selprod_id']]['mshipapi_id'];
					 $ShipingApiRow = ShippingApi::getAttributesById($shipapi_id, 'shippingapi_id');
					
					if( !$ShipingApiRow ){
						return false;
					}	
				}
			}			 			
		}
		return true;
	}
	
	public function getSubTotal() {
		$cartTotal = 0;
		$products = $this->getProducts($this->cart_lang_id);
		// CommonHelper::printArray($products); die;
		if( is_array($products) && count($products) > 0 ){
			foreach( $products as $product ){				
				$cartTotal += $product['total'];
			}
		}		
		return $cartTotal;
	}
	
	public function getCartFinancialSummary( $langId ){
		$products = $this->getProducts( $langId );
		
		$sellerPrice = $this->getSellersProductItemsPrice($products);
		
		
		$cartTotal = 0;
		$cartTotalNonBatch = 0;
		$cartTotalBatch = 0;
		$shippingTotal = 0;
		$originalShipping = 0;
		$cartTotalAfterBatch = 0;
		$orderPaymentGatewayCharges = 0;
		$cartTaxTotal = 0;
		$cartDiscounts = self::getCouponDiscounts();
		
		$totalSiteCommission = 0;
		$orderNetAmount = 0;
		$cartRewardPoints = self::getCartRewardPoint();
		$cartVolumeDiscount = 0;
		
		$isCodEnabled = true;
		
		if( is_array($products) && count($products) ){
			foreach( $products as $product ){
				$codEnabled = false;
				if($isCodEnabled && $product['is_cod_enabled']){
					$codEnabled = true;
				}
				$isCodEnabled = $codEnabled;
				
				if( $product['is_batch'] ){
					//$cartTotalBatch += $product['prodgroup_total'];
					$cartTotal += $product['prodgroup_total'];					
				} else {
					//$cartTotalNonBatch += $product['total'];
					$cartTotal += $product['total'];					
				}
				$cartVolumeDiscount += $product['volume_discount_total'];
				$cartTaxTotal += $product['tax'];
				$originalShipping += $product['shipping_cost'];
				$totalSiteCommission += $product['commission'];
				
				if(array_key_exists($product['selprod_user_id'],$sellerPrice)){
					if($product['shop_free_ship_upto'] > 0 && $product['shop_free_ship_upto'] < $sellerPrice[$product['selprod_user_id']]['totalPrice']){
						continue;
					}
					$shippingTotal += $product['shipping_cost'];
				}

			}
		}
		
		$cartTotalAfterBatch = $cartTotalBatch + $cartTotalNonBatch;
		//$netTotalAfterDiscount = $netTotalWithoutDiscount;
		$userWalletBalance = User::getUserBalance( $this->cart_user_id );
		//$orderCreditsCharge = $this->isCartUserWalletSelected() ? min($netTotalAfterDiscount, $userWalletBalance) : 0;
		//$orderPaymentGatewayCharges = $netTotalAfterDiscount - $orderCreditsCharge;
		
		$totalDiscountAmount = (isset($cartDiscounts['coupon_discount_total'])) ? $cartDiscounts['coupon_discount_total'] : 0;
		$orderNetAmount = ( $cartTotal  + $shippingTotal  + $cartTaxTotal )  - $totalDiscountAmount - $cartVolumeDiscount ;
		
		$orderNetAmount = $orderNetAmount - CommonHelper::rewardPointDiscount($orderNetAmount,$cartRewardPoints);		
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
			'cartTotal'			=>	$cartTotal,
			'shippingTotal'		=>	$shippingTotal,
			'originalShipping'	=>	$originalShipping,
			'cartTaxTotal'		=>	$cartTaxTotal,
			'cartDiscounts'		=>	$cartDiscounts,
			'cartVolumeDiscount'=> $cartVolumeDiscount,
			'cartRewardPoints'	=>	$cartRewardPoints,
			'cartWalletSelected'=>	$this->isCartUserWalletSelected(),
			'siteCommission' 	=> $totalSiteCommission,
			'orderNetAmount'	=>	$orderNetAmount,
			'WalletAmountCharge'=> $WalletAmountCharge,
			'isCodEnabled' 		=> $isCodEnabled,
			'orderPaymentGatewayCharges' => $orderPaymentGatewayCharges,
		);
		
		//CommonHelper::printArray($cartSummary); die();
		return $cartSummary;
	}
	
	public function getCouponDiscounts(){
		$couponObj = new DiscountCoupons();
		if( !self::getCartDiscountCoupon() ){ return false; }
		$couponInfo = $couponObj->getValidCoupons( $this->cart_user_id, $this->cart_lang_id, self::getCartDiscountCoupon() );
		//$couponInfo = $couponObj->getCoupon( self::getCartDiscountCoupon(), $this->cart_lang_id );
		//CommonHelper::printArray($couponInfo); die();
		$cartSubTotal = self::getSubTotal();
		
		/* $var = false;
		if(count($var>0)){
			echo 'its false';
		} else { echo 'not false'; }
		die(); */
		$couponData = array();
		
		if( $couponInfo ){
			$discountTotal = 0;
			$cartProducts = $this->getProducts( $this->cart_lang_id );
			$prodObj = new Product();
			
			/* binded product_ids are not in array, are in string, so converting the same to array[ */
			if( !empty( $couponInfo['grouped_coupon_products'] ) ){
				$couponInfo['grouped_coupon_products'] = explode( ",", $couponInfo['grouped_coupon_products']);
			}
			
			if( !empty($couponInfo['grouped_coupon_categories']) ){
				$couponInfo['grouped_coupon_categories'] = explode( ",", $couponInfo['grouped_coupon_categories']);
				if( !is_array($couponInfo['grouped_coupon_categories']) ){
					return array();
				}
				
				$productIdsArr = array();
				
				foreach( $cartProducts as $cartProduct ){
					$cartProdCategoriesArr = $prodObj->getProductCategories( $cartProduct['product_id'] );
					if( $cartProdCategoriesArr == false || empty($cartProdCategoriesArr) ){
						continue;
					}
					
					foreach( $cartProdCategoriesArr as $cartProdCategory ){
						if( in_array( $cartProdCategory['prodcat_id'], $couponInfo['grouped_coupon_categories'] ) ){
							$productIdsArr[] = $cartProduct['product_id'];
						}
					}
				}
				
				if( !empty($productIdsArr) ){
					if( empty($couponInfo['grouped_coupon_products']) ){
						$couponInfo['grouped_coupon_products'] = $productIdsArr;
					} else {
						$couponInfo['grouped_coupon_products'] = array_merge( $couponInfo['grouped_coupon_products'], $productIdsArr );
					}
				}
			}
			/* ] */
			
			if ( empty($couponInfo['grouped_coupon_products']) ) {
				$subTotal = $cartSubTotal;
			} else {
				$subTotal = 0;
				foreach ( $cartProducts as $cartProduct ) {
					if( $cartProduct['is_batch'] ){
						/* if ( in_array($product['prodgroup_id'], $couponInfo['groups']) ){
							$subTotal += $product['prodgroup_total'];
						} */						
					} else {
						if ( in_array($cartProduct['product_id'], $couponInfo['grouped_coupon_products'])){
							$subTotal += $cartProduct['total'];
						}
					}					
				}
			}
			
			if ( $couponInfo['coupon_discount_in_percent'] == applicationConstants::FLAT ) {
				$couponInfo['coupon_discount_value'] = min($couponInfo['coupon_discount_value'], $subTotal);
			}
			
			foreach ( $cartProducts as $cartProduct ) {
				$discount = 0;
				if ( empty($couponInfo['grouped_coupon_products']) ) {
					$status = true;
				} else {
					if( $cartProduct['is_batch'] ){
						/* if (in_array($cartProduct['prodgroup_id'], $couponInfo['groups'])) {
							$status = true;
						} else {
							$status = false;
						} */
					}else{
						if (in_array($cartProduct['product_id'], $couponInfo['grouped_coupon_products'])) {
							$status = true;
						} else {
							$status = false;
						}
					}
				}
				
				
				if ($status) {
					if( $cartProduct['is_batch'] ){
						/* if (!$couponInfo['coupon_discount_in_percent']) {
							$discount = $couponInfo['coupon_discount_value'] * ($cartProduct['prodgroup_total'] / $subTotal);
						}else{
							$discount = ( $cartProduct['prodgroup_total'] / 100 ) * $couponInfo['coupon_discount_value'];
						} */
					}else{
						if ( $couponInfo['coupon_discount_in_percent'] == applicationConstants::FLAT ) {
							$discount = $couponInfo['coupon_discount_value'] * ($cartProduct['total'] / $subTotal);
						} else {
							$discount = ( $cartProduct['total'] / 100 ) * $couponInfo['coupon_discount_value'];
						}	
					}					
				}				
				$discountTotal += $discount;
			}
			
			if ($discountTotal > $couponInfo['coupon_max_discount_value'] && $couponInfo['coupon_discount_in_percent'] == applicationConstants::PERCENTAGE) {
				$discountTotal = $couponInfo['coupon_max_discount_value'];
			}
			
			$selProdDiscountTotal = 0;
			$discountTypeArr = DiscountCoupons::getTypeArr( $this->cart_lang_id );
			
			/*[ Calculate discounts for each Seller Products*/
			$discountedSelProdIds = array();
			$discountedProdGroupIds = array();
			if ( empty($couponInfo['grouped_coupon_products']) ) {
				foreach ( $cartProducts as $cartProduct ) {
					if( $cartProduct['is_batch'] ){
						/* $totalSelProdDiscount = round(($discountTotal*$cartProduct['prodgroup_total'])/$subTotal,2);
						$selProdDiscountTotal += $totalSelProdDiscount;
						$discountedProdGroupIds[$cartProduct['prodgroup_id']] = round($totalSelProdDiscount,2); */
					}else{
						$totalSelProdDiscount = round(($discountTotal*$cartProduct['total'])/$subTotal,2);
						$selProdDiscountTotal += $totalSelProdDiscount;
						$discountedSelProdIds[$cartProduct['selprod_id']] = round($totalSelProdDiscount,2);
					}
				}
			}else{
				foreach ( $cartProducts as $cartProduct ) {
					if( $cartProduct['is_batch'] ){
						/* if (in_array($cartProduct['prodgroup_id'], $couponInfo['groups'])) {
							$totalSelProdDiscount = round(($discountTotal*$cartProduct['prodgroup_total'])/$subTotal,2);
							$selProdDiscountTotal += $totalSelProdDiscount;
							$discountedProdGroupIds[$cartProduct['prodgroup_id']] = round($totalSelProdDiscount,2);
						} */
					} else {
						if ( in_array($cartProduct['product_id'], $couponInfo['grouped_coupon_products']) ) {
							$totalSelProdDiscount = round(($discountTotal*$cartProduct['total'])/$subTotal,2);
							$selProdDiscountTotal += $totalSelProdDiscount;
							$discountedSelProdIds[$cartProduct['selprod_id']] = round($totalSelProdDiscount,2);
						}
					}
				}
			}
			/*]*/
			
			$labelArr = array(
				'coupon_label'=>$couponInfo["coupon_title"],
				'coupon_discount_in_percent'=>$couponInfo["coupon_discount_in_percent"],
				'max_discount_value' =>$couponInfo["coupon_max_discount_value"] 
			);
			
			if ( $couponInfo['coupon_discount_in_percent'] == applicationConstants::PERCENTAGE ) {
				if ( $selProdDiscountTotal > $couponInfo['coupon_max_discount_value'] ) {
					$selProdDiscountTotal = $couponInfo['coupon_max_discount_value'];
				}
			} else if( $couponInfo['coupon_discount_in_percent'] == applicationConstants::FLAT ) {
				if ( $selProdDiscountTotal > $couponInfo["coupon_discount_value"] ) {
				$selProdDiscountTotal = $couponInfo["coupon_discount_value"];
				}
			}
			
			$couponData = array(
				'coupon_discount_type'       => $couponInfo["coupon_type"],
				'coupon_code' => $couponInfo["coupon_code"],
				'coupon_discount_value'      =>$couponInfo["coupon_discount_value"],
				'coupon_discount_total'      => $selProdDiscountTotal, 
				'coupon_info'      => json_encode($labelArr),				
				'discountedSelProdIds'=>$discountedSelProdIds,	
				'discountedProdGroupIds'=>$discountedProdGroupIds,	
			);
			
		}
		
		/* Existing old functionality[ */
		// if( $couponInfo ){
			// $discountTotal = 0;
			
			// if (empty($couponInfo['products']) && empty($couponInfo['groups'])) {
				// $subTotal = $cartSubTotal;
			// }else{
				// $subTotal = 0;
				// foreach ($this->getProducts($this->cart_lang_id) as $product) {
					// if($product['is_batch']){
						// if (in_array($product['prodgroup_id'], $couponInfo['groups'])){
							// $subTotal += $product['prodgroup_total'];
						// }						
					// }else{
						// if (in_array($product['product_id'], $couponInfo['products'])){
							// $subTotal += $product['total'];
						// }
					// }					
				// }
			// }
			
			// if ( !$couponInfo['coupon_discount_in_percent'] ) {
				// $couponInfo['coupon_discount_value'] = min($couponInfo['coupon_discount_value'], $subTotal);
			// }
			
			// foreach ($this->getProducts($this->cart_lang_id) as $product) {
				// $discount = 0;
				
				// if (empty($couponInfo['products']) && empty($couponInfo['groups'])) {
					// $status = true;
				// }else{
					// if($product['is_batch']){
						// if (in_array($product['prodgroup_id'], $couponInfo['groups'])) {
							// $status = true;
						// } else {
							// $status = false;
						// }
					// }else{
						// if (in_array($product['product_id'], $couponInfo['products'])) {
							// $status = true;
						// } else {
							// $status = false;
						// }
					// }
				// }	
				
				
				// if ($status) {
					// if($product['is_batch']){
						// if (!$couponInfo['coupon_discount_in_percent']) {
							// $discount = $couponInfo['coupon_discount_value'] * ($product['prodgroup_total'] / $subTotal);
						// }else{
							// $discount = ( $product['prodgroup_total'] / 100 ) * $couponInfo['coupon_discount_value'];
						// }
					// }else{
						// if (!$couponInfo['coupon_discount_in_percent']) {
							// $discount = $couponInfo['coupon_discount_value'] * ($product['total'] / $subTotal);
						// }else{
							// $discount = ( $product['total'] / 100 ) * $couponInfo['coupon_discount_value'];
						// }	
					// }					
				// }				
				// $discountTotal += $discount;
			// }
			
			// // If discount greater than total			
			// if ($discountTotal > $couponInfo['coupon_max_discount_value']) {
				// $discountTotal = $couponInfo['coupon_max_discount_value'];
			// }
			
			// $selProdDiscountTotal = 0;
			// $discountTypeArr = DiscountCoupons::getTypeArr($this->cart_lang_id);
			
			// /*[ Calculate discounts for each Seller Products*/
			// $discountedSelProdIds = array();
			// $discountedProdGroupIds = array();
			// if (empty($couponInfo['products'])&& empty($couponInfo['groups'])) {
				// foreach ($this->getProducts($this->cart_lang_id) as $product) {
					// if($product['is_batch']){	
						// $totalSelProdDiscount = round(($discountTotal*$product['prodgroup_total'])/$subTotal,2);
						// $selProdDiscountTotal += $totalSelProdDiscount;
						// $discountedProdGroupIds[$product['prodgroup_id']] = round($totalSelProdDiscount,2);
					// }else{
						// $totalSelProdDiscount = round(($discountTotal*$product['total'])/$subTotal,2);
						// $selProdDiscountTotal += $totalSelProdDiscount;
						// $discountedSelProdIds[$product['selprod_id']] = round($totalSelProdDiscount,2);
					// }
				// }
			// }else{
				// foreach ($this->getProducts($this->cart_lang_id) as $product) {
					// if($product['is_batch']){
						// if (in_array($product['prodgroup_id'], $couponInfo['groups'])) {
							// $totalSelProdDiscount = round(($discountTotal*$product['prodgroup_total'])/$subTotal,2);
							// $selProdDiscountTotal += $totalSelProdDiscount;
							// $discountedProdGroupIds[$product['prodgroup_id']] = round($totalSelProdDiscount,2);
						// }
					// }else{
						// if (in_array($product['product_id'], $couponInfo['products'])) {
							// $totalSelProdDiscount = round(($discountTotal*$product['total'])/$subTotal,2);
							// $selProdDiscountTotal += $totalSelProdDiscount;
							// $discountedSelProdIds[$product['selprod_id']] = round($totalSelProdDiscount,2);
						// }
					// }
				// }
			// }
			// /*]*/
			
			// $labelArr = array(
				// 'coupon_label'=>$couponInfo["coupon_title"],
				// 'coupon_discount_in_percent'=>$couponInfo["coupon_discount_in_percent"],
				// 'max_discount_value' =>$couponInfo["coupon_max_discount_value"] 
			// );
			
			// $couponData = array(
				// 'coupon_discount_type'       => $couponInfo["coupon_type"],
				// 'coupon_code' => $couponInfo["coupon_code"],
				// 'coupon_discount_value'      =>$couponInfo["coupon_discount_value"],
				// 'coupon_discount_total'      => $selProdDiscountTotal, 
				// 'coupon_info'      => json_encode($labelArr),				
				// 'discountedSelProdIds'=>$discountedSelProdIds,	
				// 'discountedProdGroupIds'=>$discountedProdGroupIds,	
			// );	
		// }
		/* ] */
		
		if(empty($couponData)){ return false;} 
		return $couponData;
	}
	
	public function updateCartWalletOption($val) {
		$this->SYSTEM_ARR['shopping_cart']['Pay_from_wallet'] = $val;
		$this->updateUserCart();
		return true;
	}
	
	public function updateCartDiscountCoupon($val) {
		$this->SYSTEM_ARR['shopping_cart']['discount_coupon'] = $val;
		$this->updateUserCart();
		return true;
	}
	
	public function removeCartDiscountCoupon() {
		$couponCode = array_key_exists('discount_coupon', $this->SYSTEM_ARR['shopping_cart']) ? $this->SYSTEM_ARR['shopping_cart']['discount_coupon'] : '';
		unset($this->SYSTEM_ARR['shopping_cart']['discount_coupon']);
		
		/* Removing from temp hold[ */
		if( UserAuthentication::isUserLogged() && $couponCode != '' ){
			$loggedUserId = UserAuthentication::getLoggedUserId();
			
			$srch = DiscountCoupons::getSearchObject(0, false, false);
			$srch->addCondition( 'coupon_code', '=', $couponCode );
			$srch->setPageSize(1);
			$srch->addMultipleFields( array('coupon_id') );
			$rs = $srch->getResultSet();
			$couponRow = FatApp::getDb()->fetch( $rs );
			
			if( $couponRow && $loggedUserId ){
				FatApp::getDb()->deleteRecords( DiscountCoupons::DB_TBL_COUPON_HOLD, array( 'smt' => 'couponhold_coupon_id = ? AND couponhold_user_id = ?', 'vals'=> array( $couponRow['coupon_id'], $loggedUserId ) ) );
			}
		}
		/* ] */
		
		$this->updateUserCart();
		return true;
	}
	
	public function updateCartUseRewardPoints($val){
		$this->SYSTEM_ARR['shopping_cart']['reward_points'] = $val;
		$this->updateUserCart();
		return true;
	}
	
	public function removeUsedRewardPoints(){
		unset($this->SYSTEM_ARR['shopping_cart']['reward_points']);
		$this->updateUserCart();
		return true;
	}
	
	public function getCartRewardPoint(){
		return isset($this->SYSTEM_ARR['shopping_cart']['reward_points'])?$this->SYSTEM_ARR['shopping_cart']['reward_points']:0;
	}
	
	public function getCartDiscountCoupon() {
		return isset($this->SYSTEM_ARR['shopping_cart']['discount_coupon']) ? $this->SYSTEM_ARR['shopping_cart']['discount_coupon'] : '';
	}
	
	public function isDiscountCouponSet() {
		return !empty($this->SYSTEM_ARR['shopping_cart']['discount_coupon']);
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
			$record->assignValues( array("usercart_user_id" => $this->cart_user_id,"usercart_type" =>CART::TYPE_PRODUCT, "usercart_details" => $cart_arr, "usercart_added_date" => date ( 'Y-m-d H:i:s' ) ) );
			if( !$record->addNew( array(), array( 'usercart_details' => $cart_arr, "usercart_added_date" => date ( 'Y-m-d H:i:s' ), "usercart_sent_reminder" => 0 ) ) ){
				Message::addErrorMessage( $record->getError() );
				throw new Exception('');
			}
		}
	}
	
	/* to keep track of temporary hold the product stock[ */
	public function updateTempStockHold( $selprod_id, $quantity = 0, $prodgroup_id = 0 ){
		$selprod_id = FatUtility::int($selprod_id);
		$quantity = FatUtility::int($quantity);
		$prodgroup_id = FatUtility::int($prodgroup_id);
		if( !$selprod_id ){
			return;
		}
		$db = FatApp::getDb();
		
		if( $quantity <= 0 ){
			$db->deleteRecords( 'tbl_product_stock_hold', array('smt'=>'pshold_selprod_id = ? AND pshold_user_id = ? AND pshold_prodgroup_id = ?', 'vals' => array($selprod_id, $this->cart_user_id, $prodgroup_id)) );
			return;
		}
		
		//$record = new TableRecord('tbl_product_stock_hold');
		$dataArrToSave = array( 
			'pshold_selprod_id'	=>	$selprod_id, 
			'pshold_user_id'	=>	$this->cart_user_id, 
			'pshold_prodgroup_id' => $prodgroup_id,
			'pshold_selprod_stock'	=>	$quantity, 
			'pshold_added_on' => date('Y-m-d H:i:s')
		);
		
		//$qty = isset($this->SYSTEM_ARR['cart'][$selprod_id]) ? FatUtility::int($this->SYSTEM_ARR['cart'][$selprod_id]) : 0;
		$dataUpdateOnDuplicate = array_merge($dataArrToSave,array( 'pshold_selprod_stock' => $quantity));
		if(!$db->insertFromArray('tbl_product_stock_hold',$dataArrToSave,true,array(),$dataUpdateOnDuplicate)){
			Message::addErrorMessage( $db->getError() );
			throw new Exception('');
		}
		/* $record->assignValues( $dataArrToSave );
		if( !$record->addNew( array(), $dataUpdateOnDuplicate ) ){
			Message::addErrorMessage( $record->getError() );
			throw new Exception('');
		} */
		
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
		unset($_SESSION['wallet_recharge_cart']["order_id"]);
	}
	
	static function setCartAttributes( $userId = 0 ){
		$db = FatApp::getDb();
		
		/* to keep track of temporary hold the product stock[ */
		$cart_user_id = static::getCartUserId();
		$db->updateFromArray( 'tbl_product_stock_hold', array( 'pshold_user_id' => $cart_user_id ), array('smt' => 'pshold_user_id = ?', 'vals' => array(session_id()) ) );
		/* 	] */
		
		$userId = FatUtility::int($userId);
		if($userId == 0) { return false;}
		
		$srch = new SearchBase('tbl_user_cart');
		$srch->addCondition('usercart_user_id', '=', session_id() );
		$srch->addCondition('usercart_type', '=', CART::TYPE_PRODUCT );
		$rs = $srch->getResultSet();
		
		if(!$row = FatApp::getDb()->fetch($rs) ){
			return false;
		}
		
		$cartInfo = unserialize( $row["usercart_details"] );
		
		$cartObj = new Cart($userId);
		
		foreach($cartInfo as $key => $quantity){
			
			$keyDecoded = unserialize( base64_decode($key) );
			
			$selprod_id = 0;
			$prodgroup_id = 0;
			
			if( strpos($keyDecoded, static::CART_KEY_PREFIX_PRODUCT ) !== FALSE ){
				$selprod_id = FatUtility::int(str_replace( static::CART_KEY_PREFIX_PRODUCT, '', $keyDecoded ));
			}
			
			if( strpos($keyDecoded, static::CART_KEY_PREFIX_BATCH ) !== FALSE ){
				$prodgroup_id = FatUtility::int(str_replace( static::CART_KEY_PREFIX_BATCH, '', $keyDecoded ));
			}
			
			$cartObj->add($selprod_id, $quantity,$prodgroup_id);	
			
			$db->deleteRecords('tbl_user_cart', array('smt'=>'`usercart_user_id`=? and usercart_type=?', 'vals'=>array(session_id(),CART::TYPE_PRODUCT)));
		}
		$cartObj->updateUserCart();
	}
	
	public function shipStationCarrierList() {		
        $carrierList = array();
        $carrierList[0] =  Labels::getLabel('MSG_Select_Services', commonHelper::getLangId());
        try {
			require_once (CONF_INSTALLATION_PATH . 'library/APIs/shipstatation/ship.class.php');
			$carriers = null;
            //$carriers = $this->getCache("shipstationcarriers");
            if (!$carriers ) {
				$apiKeys = ShippingMethods::getShipStationApiKeys(ShippingMethods::SHIPSTATION_SHIPPING);				
			    $ship = new Ship($apiKeys['shipstation_api_key'],$apiKeys['shipstation_api_secret_key']);
                $carriers = $ship->getCarriers();				
               // $this->setCache("shipstationcarriers", $carriers);
            }

            foreach ($carriers as $carrier) {
                $code = $carrier->code;
                $name = $carrier->name;
                $carrierList[$code] = $name;
            }
        } catch (Exception $ex) {
            // $carriers = new stdClass();
        }
        return $carrierList;
    }
	
	public function getCache($key) {
        require_once (CONF_INSTALLATION_PATH . 'library/phpfastcache.php');
        phpFastCache::setup("storage", "files");

        phpFastCache::setup("path", CONF_UPLOADS_PATH . "caching");

        $cache = phpFastCache();
        return $cache->get($key);
    }

    private function setCache($key, $value) {

        require_once (CONF_INSTALLATION_PATH . 'library/phpfastcache.php');
        phpFastCache::setup("storage", "files");
        phpFastCache::setup("path", CONF_UPLOADS_PATH . "caching");
        $cache = phpFastCache();
        return $cache->set($key, $value, 60 * 60);
    }
	
	public function getCarrierShipmentServicesList($product_key, $carrier_id = 0 ,$lang_id =0 ) {

        $services = $this->getCarrierShipmentServices($product_key, $carrier_id,$lang_id );
        $servicesList = array();

        $servicesList[0] = Labels::getLabel('MSG_Select_Services', $lang_id);

        if (!empty($carrier_id)) {
            foreach ($services as $key => $value) {
                $code = $value->serviceCode;
                $price = $value->shipmentCost + $value->otherCost;
                $name = $value->serviceName;
                $label = $name . " (" . CommonHelper::displayMoneyFormat($price) . " )";
                $servicesList[$code . "-" . $price] = $label;
            }
        }

        return $servicesList;
    }
	
	public function getProductByKey($find_key) {

        if (!$this->hasPhysicalProduct()) {
            return false;
        }

        foreach ($this->SYSTEM_ARR['cart'] as $key => $cart) {

            if ($find_key == md5($key)) {
                return $key;
            }
        }
        return false;
    }
	
    public function getCarrierShipmentServices($product_key, $carrier_id ,$lang_id ) {

        if (!$key = $this->getProductByKey($product_key)) {
            return array();
        }

        $products = $this->getProducts($this->cart_lang_id);
		$weightUnitsArr = applicationConstants::getWeightUnitsArr( $lang_id );
		$lengthUnitsArr = applicationConstants::getLengthUnitsArr( $lang_id );
		

        $product = $products[$key];
        $productShippingAddress = $product['shipping_address'];
        $productShopAddress = $product['seller_address'];
		
        $sellerPinCode = $productShopAddress['shop_postalcode'];
        $quantity = $product['quantity'];
        $productWeight = $product['product_weight'] / $quantity;
        $productWeightClass = ($product['product_dimension_unit']) ? $lengthUnitsArr[$product['product_dimension_unit']] : '';
        $productLength = $product['product_length'];
        $productWidth = $product['product_width'];
        $productHeight = $product['product_height'];
    
		$productLengthUnit = ($product['product_weight_unit']) ? $weightUnitsArr[$product['product_weight_unit']] : '';



        $productWeightInOunce = $this->ConvertWeightInOunce($productWeight, $productWeightClass);
        $productLengthInCenti = $this->ConvertLengthInCenti($productLength, $productLengthUnit);
        $productWidthInCenti = $this->ConvertLengthInCenti($productWidth, $productLengthUnit);
        $productHeightInCenti = $this->ConvertLengthInCenti($productHeight, $productLengthUnit);

        $product_rates = array();
        try {
			require_once (CONF_INSTALLATION_PATH . 'library/APIs/shipstatation/ship.class.php');
			$apiKeys = ShippingMethods::getShipStationApiKeys(ShippingMethods::SHIPSTATION_SHIPPING);				
			$Ship = new Ship($apiKeys['shipstation_api_key'],$apiKeys['shipstation_api_secret_key']);
						
            $Ship->setProductDeliveryAddress($productShippingAddress['state_code'], $productShippingAddress['country_code'], $productShippingAddress['ua_city'], $productShippingAddress['ua_zip']);

            $Ship->setProductWeight($productWeightInOunce);
            // $Ship->setProductDim($productLengthInCenti,$productWidthInCenti,$productHeightInCenti);
            if ($productLengthInCenti > 0 && $productWidthInCenti > 0 && $productHeightInCenti > 0) {
                $Ship->setProductDim($productLengthInCenti, $productWidthInCenti, $productHeightInCenti);
            }
			
            $product_rates = (array) $Ship->getProductShippingRates($carrier_id, $sellerPinCode, $Ship->getProductWeight(), $Ship->getProductDeliveryAddress(), $Ship->getProductDim());
        } catch (Exception $ex) { 
            $ex->getMessage();
            return array();
        }

        return $product_rates;
    }
	
	function ConvertWeightInOunce($productWeight, $productWeightClass) {

        $coversionRate = 1;
        switch ($productWeightClass) {
            case "KG":
                $coversionRate = "35.274";
                break;
            case "GM":
                $coversionRate = "0.035274";
                break;
            case "PN":
                $coversionRate = "16";
                break;
            case "OU":
                $coversionRate = "1";
                break;
            case "Ltr":
                $coversionRate = "33.814";
                break;
            case "Ml":
                $coversionRate = "0.033814";
                break;
        }

        return $productWeight * $coversionRate;
    }

    function ConvertLengthInCenti($productWeight, $productWeightClass) {

        $coversionRate = 1;
        switch ($productWeightClass) {

            case "IN":
                $coversionRate = "2.54";
                break;
            case "MM":
                $coversionRate = "0.1";
                break;
            case "CM":
                $coversionRate = "1";
                break;
        }

        return $productWeight * $coversionRate;
    }
	
	public function getSellersProductItemsPrice($cartProducts){
		$sellerPrice = array();
		if( is_array($cartProducts) && count($cartProducts) ){
			foreach( $cartProducts as $selprod ){
				if(!array_key_exists($selprod['selprod_user_id'],$sellerPrice)){
					$sellerPrice[$selprod['selprod_user_id']]['totalPrice'] = 0;
				}
				$sellerPrice[$selprod['selprod_user_id']]['totalPrice']+= $selprod['theprice'] * $selprod['quantity'];
			}
		}
		return $sellerPrice;
	}

}