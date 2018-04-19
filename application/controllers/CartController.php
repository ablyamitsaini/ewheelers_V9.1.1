<?php
class CartController extends MyAppController{
	public function __construct($action) {
		parent::__construct($action);
	}
	
	public function index(){
		$this->_template->render();
	}
	
	public function listing(){
		$templateName = 'cart/listing.php';
		$products['groups'] = array();
		$products['single'] = array();
		$cartObj = new Cart();
		$productsArr = $cartObj->getProducts($this->siteLangId);
		$prodGroupIds = array();
		
		if( $productsArr ){
			foreach( $productsArr as $product ){
				/* if( $product['prodgroup_id'] > 0 ){
					$prodGroupIds[$product['prodgroup_id']] = $product['prodgroup_id'];
					//$products['groups'][$product['prodgroup_id']][] = $product;
					$groupDetailArr = array(
						'prodgroup_id' => $product['prodgroup_id'], 
						'prodgroup_name' => $product['prodgroup_name'], 
						'prodgroup_price' => $product['prodgroup_price'],
						'prodgroup_total' => $product['prodgroup_total'],
					);
					$products['groups'][$product['prodgroup_id']]['group_detail'] = $groupDetailArr;
					$products['groups'][$product['prodgroup_id']]['products'][] = $product;
					//$products[$product['prodgroup_id']][] = $product;
				} else {
					$products['single'][] = $product;
				} */
			}
			$cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
			
			$PromoCouponsFrm = $this->getPromoCouponsForm($this->siteLangId);
			$this->set('products', $productsArr );
			$this->set( 'prodGroupIds', $prodGroupIds );
			$this->set('PromoCouponsFrm', $PromoCouponsFrm );
			$this->set('cartSummary', $cartSummary);
		} else { 
			$srch = EmptyCartItems::getSearchObject( $this->siteLangId );
			$srch->doNotCalculateRecords();
			$srch->addMultipleFields(array('emptycartitem_title', 'emptycartitem_url', 'emptycartitem_url_is_newtab'));
			$rs = $srch->getResultSet();
			$EmptyCartItems = FatApp::getDb()->fetchAll($rs);
			$this->set('EmptyCartItems', $EmptyCartItems );
			$templateName = 'cart/empty-cart.php';
		}		
		$this->_template->render(false, false, $templateName);
	}
	
	public function add(){
		$post = FatApp::getPostedData();
		if( false == $post ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser( CommonHelper::generateUrl() );
		}
		if( UserAuthentication::isUserLogged() ){
			$user_is_buyer = User::getAttributesById( UserAuthentication::getLoggedUserId(), 'user_is_buyer' );
			if( !$user_is_buyer ){
				$errMsg = Labels::getLabel('MSG_Please_login_with_buyer_account_to_add_products_to_cart', $this->siteLangId);
				Message::addErrorMessage( $errMsg );
				if ( FatUtility::isAjaxCall() ) {
					FatUtility::dieWithError( Message::getHtml() );
				}
				FatApp::redirectUser( CommonHelper::generateUrl() );
			}
			$user_id = UserAuthentication::getLoggedUserId();
		}
		$json = array();
		$selprod_id = FatApp::getPostedData( 'selprod_id', FatUtility::VAR_INT, 0 ); //FatUtility::int($post['selprod_id']);
		$quantity = FatApp::getPostedData( 'quantity', FatUtility::VAR_INT, 0 ); //FatUtility::int($post['quantity']);
		
		$productsToAdd  = isset($post['addons'])?$post['addons']:array();
		$productsToAdd[$selprod_id] = $quantity;
		
		$ProductAdded = false;
		foreach($productsToAdd as $productId =>$quantity){
			if( $productId <= 0 ){
				Message::addErrorMessage(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
				FatUtility::dieWithError( Message::getHtml() );
			}
			$srch = new ProductSearch($this->siteLangId);
			
			$srch->setDefinedCriteria();
			$srch->joinBrands();
			$srch->joinSellerSubscription();
			$srch->addSubscriptionValidCondition();
			$srch->joinProductToCategory();
			$srch->addCondition( 'pricetbl.selprod_id', '=', $productId );
			$srch->addCondition( 'selprod_deleted', '=', applicationConstants::NO );
			$srch->addMultipleFields( array(
				'selprod_id','selprod_code', 'selprod_min_order_qty', 'selprod_stock', 'product_name' ) );
			$rs = $srch->getResultSet();
			$db = FatApp::getDb();
			$sellerProductRow = $db->fetch($rs);
			if( !$sellerProductRow || $sellerProductRow['selprod_id'] != $productId  ){
				Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
				FatUtility::dieWithError( Message::getHtml() );
			}
			$productId = $sellerProductRow['selprod_id'];		
			$selprod_code = $sellerProductRow['selprod_code'];
			$productAdd = true;
			/* cannot add, out of stock products in cart[ */
			if( $sellerProductRow['selprod_stock'] <= 0 ){
				
				if ($productId!=$selprod_id)
					$productErr['addon'][$productId]=sprintf(Labels::getLabel('LBL_Out_of_Stock_Products_cannot_be_added_to_cart_%s',$this->siteLangId),FatUtility::decodeHtmlEntities($sellerProductRow['product_name']));
				else
					$productErr['product']=sprintf(Labels::getLabel('LBL_Out_of_Stock_Products_cannot_be_added_to_cart_%s',$this->siteLangId),FatUtility::decodeHtmlEntities($sellerProductRow['product_name']));
				
				/* Message::addErrorMessage(Labels::getLabel("LBL_Out_of_Stock_Products_cannot_be_added_to_cart",$this->siteLangId));
				$productErr (Message::getHtml()); */
			}
			/* ] */
			
			/* minimum quantity check[ */
			$minimum_quantity = ($sellerProductRow['selprod_min_order_qty']) ? $sellerProductRow['selprod_min_order_qty'] : 1;
			if( $quantity < $minimum_quantity ){
				$productAdd = false;
				if ($productId!=$selprod_id)
					$productErr['addon'][$productId]=Labels::getLabel('LBL_Please_add_minimum',$this->siteLangId). " ".$minimum_quantity." ".FatUtility::decodeHtmlEntities($sellerProductRow['product_name']);
				else
					$productErr['product']=Labels::getLabel('LBL_Please_add_minimum',$this->siteLangId). " ".$minimum_quantity." ".FatUtility::decodeHtmlEntities($sellerProductRow['product_name']);
			}
			/* ] */

			/* product availability date check covered in product search model[ ] */
			$cartObj = new Cart();
			
			/* cannot add quantity more than stock of the product[ */
			$selprod_stock = $sellerProductRow['selprod_stock'] - Product::tempHoldStockCount($productId);
			if( $quantity > $selprod_stock ){
				if ( $productId != $selprod_id ){
					$productErr['addon'][$productId]=Message::addInfo(Labels::getLabel('MSG_Requested_quantity_more_than_stock_available',$this->siteLangId)." ". $selprod_stock." " .FatUtility::decodeHtmlEntities($sellerProductRow['product_name']));
				} else {
					$productErr['product']=Labels::getLabel('MSG_Requested_quantity_more_than_stock_available',$this->siteLangId)." ". $selprod_stock." " .FatUtility::decodeHtmlEntities($sellerProductRow['product_name']);
				}
			}		
			/* ] */
			if($productAdd){
				$cartObj->add( $productId, $quantity );
				$ProductAdded = true;
			}
		}
		$strProduct = '<a href="'.CommonHelper::generateUrl('Products','view',array($selprod_id)).'">'.$sellerProductRow['product_name'].'</a>';	
		$strCart = '<a href="'.CommonHelper::generateUrl('Cart').'">'.Labels::getLabel('Lbl_Shopping_Cart',$this->siteLangId).'</a>';
		if(isset($productErr)){
			Message::addInfo($productErr);
			$this->set( 'msg', CommonHelper::renderHtml( Message::getHtml($productErr)));
			if(!$ProductAdded){
				Message::addErrorMessage($productErr);
				FatUtility::dieWithError( Message::getHtml() );
			}
			$this->set('alertType','alert-info');
			
		}else{
			
			Message::addMessage(sprintf(Labels::getLabel('MSG_Success_cart_add', $this->siteLangId), $strProduct, $strCart));
			$this->set( 'msg', Labels::getLabel("MSG_Added_to_cart", $this->siteLangId) );
		}
		$this->set('success_msg', CommonHelper::renderHtml(Message::getHtml()));		
		$this->set('total', $cartObj->countProducts() );
		$this->_template->render(false, false, 'json-success.php',false,false);
	}
	
	public function remove(){
		$post = FatApp::getPostedData();
		if( false == $post ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser( CommonHelper::generateUrl() );
		}
		
		if( !isset($post['key']) ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$cartObj = new Cart();
		if( !$cartObj->remove($post['key']) ){
			Message::addMessage($cartObj->getError());
			FatUtility::dieWithError( Message::getHtml() );
		}
		$this->set( 'msg', Labels::getLabel("MSG_Item_removed_successfully", $this->siteLangId) );
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function removeGroup(){
		$post = FatApp::getPostedData();
		
		if( false == $post ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser( CommonHelper::generateUrl() );
		}
		
		$prodgroup_id  = FatApp::getPostedData('prodgroup_id', FatUtility::VAR_INT, 0);
		if( $prodgroup_id <= 0 ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$cartObj = new Cart();
		if( !$cartObj->removeGroup( $prodgroup_id ) ){
			Message::addMessage( $cartObj->getError() );
			FatUtility::dieWithError( Message::getHtml() );
		}
		$this->set( 'msg', Labels::getLabel("MSG_Product_Combo_removed_successfully", $this->siteLangId) );
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function update(){
		$post = FatApp::getPostedData();
		if( false == $post ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser( CommonHelper::generateUrl() );
		}
		if( !isset($post['key']) ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		$key = $post['key'];
		$quantity = isset($post['quantity']) ? FatUtility::int($post['quantity']) : 1;
		$cartObj = new Cart();
		if( !$cartObj->update($key, $quantity) ){
			Message::addMessage($cartObj->getError());
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if(!empty($cartObj->getWarning())){
			$this->set( 'msg', $cartObj->getWarning() );
		}else{
			$this->set( 'msg', Labels::getLabel("MSG_cart_updated_successfully", $this->siteLangId) );
		}
		
		$this->_template->render(false, false, 'json-success.php');
	}
	
	public function updateGroup(){
		$post = FatApp::getPostedData();
		if( false == $post ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser( CommonHelper::generateUrl() );
		}
		$prodgroup_id = FatApp::getPostedData( 'prodgroup_id', FatUtility::VAR_INT, 0 );
		$quantity = FatApp::getPostedData( 'quantity', FatUtility::VAR_INT, 1 );
		if( $prodgroup_id <= 0 ){
			Message::addErrorMessage(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
			FatUtility::dieWithError( Message::getHtml() );
		}
		$cartObj = new Cart();
		if( !$cartObj->updateGroup( $prodgroup_id, $quantity) ){
			Message::addMessage($cartObj->getError());
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if( !empty( $cartObj->getWarning() )){
			/* Message::addMessage( $cartObj->getWarning() );
			FatUtility::dieWithError( Message::getHtml() );  */
			$this->set( 'msg', $cartObj->getWarning() );
		} else {
			$this->set( 'msg', Labels::getLabel("MSG_cart_updated_successfully", $this->siteLangId) );
		}
		
		$this->_template->render(false, false, 'json-success.php');
	}
	
/* 	public function addGroup(){
		$post = FatApp::getPostedData();
		if( false == $post ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser( CommonHelper::generateUrl() );
		}
		$json = array();
		$prodgroup_id = FatApp::getPostedData( 'prodgroup_id', FatUtility::VAR_INT, 0 );
		if( $prodgroup_id <= 0 ){
			Message::addErrorMessage(Labels::getLabel('LBL_Invalid_Request', $this->siteLangId));
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$db = FatApp::getDb();
		
		$row = ProductGroup::getAttributesById( $prodgroup_id, array('prodgroup_id', 'prodgroup_active') );
		if( !$row || $row['prodgroup_id'] != $prodgroup_id || $row['prodgroup_active'] != applicationConstants::ACTIVE ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$srch = new ProductSearch( $this->siteLangId, ProductGroup::DB_PRODUCT_TO_GROUP, ProductGroup::DB_PRODUCT_TO_GROUP_PREFIX.'product_id' );
		$srch->setBatchProductsCriteria();
		$srch->addCondition( ProductGroup::DB_PRODUCT_TO_GROUP_PREFIX.'prodgroup_id', '=', $row['prodgroup_id'] );
		$srch->addMultipleFields( array( 'selprod_id', 'selprod_stock', 'IF(selprod_stock > 0, 1, 0) AS in_stock') );
		$rs = $srch->getResultSet();
		$pg_products = $db->fetchAll($rs);
		
		if( !$pg_products ){
			Message::addErrorMessage(Labels::getLabel('LBL_No_Products_under_this_Batch/Combo', $this->siteLangId));
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$cart_user_id = session_id();
		if ( UserAuthentication::isUserLogged()  ){
			$cart_user_id = UserAuthentication::getLoggedUserId();
		}
		
		foreach($pg_products as $product){			
			if( !$product['in_stock'] || (1 > $product['selprod_stock'] - Product::tempHoldStockCount($product['selprod_id'])) ){
				Message::addErrorMessage(Labels::getLabel('LBL_one_of_the_product_in_batch_is_out_of_stock', $this->siteLangId));
				FatUtility::dieWithError( Message::getHtml() );
				break;
			}
				
		}
		
		$cartObj = new Cart();
		$cartObj->add( 0, 1, $row['prodgroup_id'] );
		
		$this->set( 'msg', Labels::getLabel("MSG_Added_to_cart", $this->siteLangId) );
		$this->set('total', $cartObj->countProducts() );
		$this->_template->render( false, false, 'json-success.php', false, false );
	} */
	
	public function applyPromoCode(){
		UserAuthentication::checkLogin();
		
		$post = FatApp::getPostedData();
		$loggedUserId = UserAuthentication::getLoggedUserId();
		
		if( false == $post ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		if( empty($post['coupon_code']) ){ 
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
	
		$couponCode = $post['coupon_code'];
		
		/* $couponObj = new DiscountCoupons();
		$couponInfo = $couponObj->getCoupon($couponCode,$this->siteLangId);
		*/
		$couponInfo = DiscountCoupons::getValidCoupons( $loggedUserId, $this->siteLangId, $couponCode );
		if( $couponInfo == false ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Coupon_Code', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$cartObj = new Cart();
		if( !$cartObj->updateCartDiscountCoupon($couponInfo['coupon_code']) ){
			Message::addErrorMessage( Labels::getLabel('LBL_Action_Trying_Perform_Not_Valid', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$holdCouponData = array(
			'couponhold_coupon_id'=>$couponInfo['coupon_id'],
			'couponhold_user_id'=>UserAuthentication::getLoggedUserId(),
			'couponhold_added_on'=>date('Y-m-d H:i:s'),
		);
		
		if( !FatApp::getDb()->insertFromArray( DiscountCoupons::DB_TBL_COUPON_HOLD, $holdCouponData, true,array(),$holdCouponData)) {
			Message::addErrorMessage( Labels::getLabel('LBL_Action_Trying_Perform_Not_Valid', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$this->set( 'msg', Labels::getLabel("MSG_cart_discount_coupon_applied", $this->siteLangId) );
		$this->_template->render(false, false, 'json-success.php');		
	}
	
	public function removePromoCode(){
		$cartObj = new Cart();
		if(!$cartObj->removeCartDiscountCoupon()){
			Message::addErrorMessage( Labels::getLabel('LBL_Action_Trying_Perform_Not_Valid', $this->siteLangId) );
			FatUtility::dieWithError( Message::getHtml() );
		}
		
		$this->set( 'msg', Labels::getLabel("MSG_cart_discount_coupon_removed", $this->siteLangId) );
		$this->_template->render(false, false, 'json-success.php');	
	}
	
	private function getPromoCouponsForm($langId){
		$langId = FatUtility::int($langId);
		$frm = new Form('frmPromoCoupons');
		$frm->addTextBox(Labels::getLabel('LBL_Coupon_code',$langId),'coupon_code','',array('placeholder'=>Labels::getLabel('LBL_Enter_Your_code',$langId)));
		$frm->addSubmitButton('', 'btn_submit',Labels::getLabel('LBL_Apply',$langId));		
		return $frm;
	}
	
	public function getCartSummary(){
		$cartObj = new Cart();
		$productsArr = $cartObj->getProducts($this->siteLangId);
		$cartSummary = $cartObj->getCartFinancialSummary($this->siteLangId);
		
		$this->set('siteLangId', $this->siteLangId );
		$this->set('products', $productsArr );
		$this->set('cartSummary', $cartSummary);
		$this->set( 'totalCartItems', $cartObj->countProducts() );	
		$this->_template->render(false,false);
	}	
}