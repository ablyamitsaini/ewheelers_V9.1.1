<?php
class DummyController extends MyAppController {
	
	function deleteUserUplaods(){
		$dirName = CONF_INSTALLATION_PATH.'user-uploads';
		//CommonHelper::recursiveDelete( $dirName );
	}
	
	function updateCategoryTable(){
		$srch = ProductCategory::getSearchObject();
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();		
		$srch->addCondition('prodcat_parent','=',0);
		$rs = $srch->getResultSet();
		$result = FatApp::getDb()->fetchAll($rs);
		foreach($result as $row){
			$productCategory = new ProductCategory($row['prodcat_id']);
			$productCategory->updateCatCode();			
		}	
		echo "Done";	
	}
	
	function updateOrderProdSetting(){
		$srch = new SearchBase(OrderProduct::DB_TBL);
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addMultipleFields(array('op_id','op_tax_collected_by_seller'));
		$rs = $srch->getResultSet();
		$urlRows = FatApp::getDb()->fetchAll($rs);
		$db = FatApp::getDb();
		foreach($urlRows as $row){
			$data = array(
				'opsetting_op_id'=>$row['op_id'],
				'op_tax_collected_by_seller'=>$row['op_tax_collected_by_seller'],
				'op_commission_include_tax'=>FatApp::getConfig('CONF_COMMISSION_INCLUDING_SHIPPING',FatUtility::VAR_INT,0),
				'op_commission_include_shipping'=>FatApp::getConfig('CONF_COMMISSION_INCLUDING_TAX',FatUtility::VAR_INT,0),
			);
			
			if(!$db->insertFromArray(OrderProduct::DB_TBL_SETTINGS,$data,false,array(),$data)){
				echo "Error with ".$row['op_id'].':'.$db->getError() .'<br>';
			}		
		}
		echo "Done";
	}
	
	function changeCustomUrl(){
		$urlSrch = UrlRewrite::getSearchObject();
		$urlSrch->doNotCalculateRecords();
		$urlSrch->doNotLimitRecords();
		$urlSrch->addMultipleFields(array('urlrewrite_id','urlrewrite_original','urlrewrite_custom'));
		$rs = $urlSrch->getResultSet();
		$urlRows = FatApp::getDb()->fetchAll($rs);
		$db = FatApp::getDb();
		foreach($urlRows as $row){
			$url = str_replace("/","-",$row['urlrewrite_custom']);
			if($db->updateFromArray(UrlRewrite::DB_TBL, array('urlrewrite_custom' => $url), array('smt' => 'urlrewrite_id = ?', 'vals' => array($row['urlrewrite_id'])))){
				echo $row['urlrewrite_id']."<br>";
			}	
		}
	}
	
	function updateDecimal(){
		$database = CONF_DB_NAME;
		$qry = FatApp::getDb()->query("SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".$database."' AND DATA_TYPE = 'decimal'");
		while($row = FatApp::getDb()->fetch($qry)){			
			//FatApp::getDb()->query("ALTER TABLE ".$row['TABLE_NAME']." MODIFY COLUMN ".$row['COLUMN_NAME']." decimal(12,4)");
			echo 'Done:- '.$row['TABLE_NAME'].' - '.$row['COLUMN_NAME'].'<br>';
			//var_dump($row);	
		}		
	}
	
	function updateCharset(){
		$database = CONF_DB_NAME;
		/*FatApp::getDb()->query("ALTER DATABASE ".$database." CHARACTER SET utf8 COLLATE utf8_general_ci");
		$qry = FatApp::getDb()->query("show tables");
		$res = FatApp::getDb()->fetchAll($qry);
		foreach($res as $val){
			FatApp::getDb()->query("ALTER TABLE ".$val['Tables_in_'.$database]." CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci");
			echo 'Done:- '.$val['Tables_in_'.$database].'<br>';
		}*/		
		// ALTER TABLE tbl_affiliate_commission_settings MODIFY COLUMN afcommsetting_fees decimal(12,4)
	}

	function testSmtp(){
		require_once (CONF_INSTALLATION_PATH . 'library/PHPMailer/PHPMailerAutoload.php');
		$mail = new PHPMailer(true);
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->IsHTML(true);
		$mail->Host = 'mail.marketsanat.com';
		$mail->Port = 26;
		$mail->Username = 'test@marketsanat.com';
		$mail->Password = 'Test!!22';
		$mail->SMTPSecure = 'tls';
		$mail->SMTPDebug = true;
		$mail->SetFrom('test@marketsanat.com', 'test');
		$mail->addAddress('pooja.rani@ablysoft.com');
		$mail->Subject = 'test Headers test From marketsanat';
		$mail->AltBody="This is text only alternative body.";
		$mail->MsgHTML('<b>Headers test</b><br><br>Port: 26, Secure: tls' );
		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			exit;
		}
		echo 'Message has been sent';
	}
	
	function abcd(){
		
		$parent = 2500;
		$categoryData = ProductCategory::getAttributesById($parent,'prodcat_id');
		if(empty($categoryData) || $categoryData == false){
			$parent = 0;
		}
			echo $parent; exit;		
		
		$urlKeyword = 'apparel-textiles-accessories-textiles-leather-products-textile-stock';
		$excludeThisOriginalUrl ='category/view/454';
		echo $url = UrlRewrite::getValidSeoUrl($urlKeyword,$excludeThisOriginalUrl,455);
		exit;
		
		
		$i = 1; 				
		$slug = $customUrl;
		while(static::getDataByCustomUrl($slug,$excludeThisOriginalUrl)){                
			$slug = $customUrl . "-" . $i++;     			
		}
		exit;
		/* Notifications::sendPushNotification('AAAAc5bAbbg:APA91bE67wf1PrijhzCWRmb0vBcAEciA7-x-X_QrDUblDnbT1ij95hr619flMF2c4MFlfTOPU0g9usWaPPex0ho2W5bDxCGeKC0jlpBkmZEhXj0avb3MJ-NsTpwmEp-T7yQBq-e9MEHR','f36lUmAdj1w:APA91bEMS-oLPX7UDItO1cglzYN0MBDfAfJ3AYIRKRfgWSbnbgDaQV_1EW3OjamTINuIM_2tB6Gt-o-GI6ZZcS-SBG3D45wrIIIKuBTmhhcIb7Dp8UdqmZ8sZ6OcTIcKrlIk6Kqap4Gl',array('title' =>'hi' , 'text' => 'bodu message', 'sound' => 'default', 'badge' => '1')); exit; */
		
		$uObj = new User(119);
		//$fcmDeviceIds = $uObj->getPushNotificationTokens();
		$fcmDeviceIds = array(
				0=> array('uauth_fcm_id'=>'f36lUmAdj1w:APA91bEMS-oLPX7UDItO1cglzYN0MBDfAfJ3AYIRKRfgWSbnbgDaQV_1EW3OjamTINuIM_2tB6Gt-o-GI6ZZcS-SBG3D45wrIIIKuBTmhhcIb7Dp8UdqmZ8sZ6OcTIcKrlIk6Kqap4Gl'),
			);  
		var_dump($fcmDeviceIds);
		echo "\n";
		if(empty($fcmDeviceIds)){
			return false;	
		}
		
		$google_push_notification_api_key = FatApp::getConfig("CONF_GOOGLE_PUSH_NOTIFICATION_API_KEY",FatUtility::VAR_STRING,'');
		//$google_push_notification_api_key = 'AIzaSyDqigFC0880hWtyGChS6TlZi3Vm_I4Q4Qk';
		
		if(trim($google_push_notification_api_key) == ''){
			return false;
		}
		
/* 	require_once(CONF_INSTALLATION_PATH . 'library/APIs/notifications/pusher.php');
	$pusher = new Pusher($google_push_notification_api_key); */	
	foreach($fcmDeviceIds as $pushNotificationApiToken){		
		echo $google_push_notification_api_key."\n";
		echo $pushNotificationApiToken['uauth_fcm_id']."\n";
		Notifications::sendPushNotification($google_push_notification_api_key,$pushNotificationApiToken['uauth_fcm_id'],array( 'text' => 'bodu message', 'sound' => 'default', 'badge' => '1'));
		
		//$pusher->notify($pushNotificationApiToken['uauth_fcm_id'], array('text'=>'testing','sound' => 'default', 'badge' => '1'));
	}
		/* require_once(CONF_INSTALLATION_PATH . 'library/APIs/notifications/pusher.php');
		foreach($fcmDeviceIds as $pushNotificationApiToken){
			echo $pushNotificationApiToken['uauth_fcm_id']."\n";
			echo "<br>======<br>";
			$pusher = new Pusher($google_push_notification_api_key);			
			try{
				$res = $pusher->notify($pushNotificationApiToken['uauth_fcm_id'], array('message'=>'hello test','type'=>'TXN'));
				var_dump($res);
			}catch(exception $e){
				var_dump($e);
			}
			echo "<br>======<br>";
		} */
		exit;
		
		
	$userObj = new User(119);
		$row = $userObj->getProfileData();
		var_dump($row);
		/* $srch = new UserRewardSearch();
		$srch->joinUserRewardBreakup();
		$srch->addCondition('urpbreakup_used','=',0);
		$srch->addCondition('urp_user_id','=',$result['urp_user_id']);			
		$cnd = $srch->addCondition('urp_date_expiry','<=',date('Y-m-d'));			
		$cnd->attachCondition('urp_date_expiry','=','0000-00-00');	
		echo $srch->getQuery(); */
		exit;
		$prodSrchObj = new ProductSearch( $this->siteLangId );
		$prodSrchObj->setDefinedCriteria();
		$prodSrchObj->joinProductToCategory();
		$prodSrchObj->joinSellerSubscription($this->siteLangId ,true);
		$prodSrchObj->addSubscriptionValidCondition();
		$prodSrchObj->doNotCalculateRecords();
		$prodSrchObj->doNotLimitRecords();
		
		$catSrch = clone $prodSrchObj;
		$catSrch->addGroupBy('prodcat_id');
		
		$categoriesDataArr = productCategory::getProdCatParentChildWiseArr( $this->siteLangId, 0, false, false, false, $catSrch,true );
		$productCategory = new productCategory;
		$categoriesArr = $productCategory ->getCategoryTreeArr($this->siteLangId,$categoriesDataArr,array( 'prodcat_id', 'IFNULL(prodcat_name,prodcat_identifier ) as prodcat_name','substr(GETCATCODE(prodcat_id),1,6) AS prodrootcat_code', 'prodcat_content_block','prodcat_active','prodcat_parent','GETCATCODE(prodcat_id) as prodcat_code'));
		
		CommonHelper::printArray($categoriesArr); exit;
	}
	
	function pushTest(){
		
		$firebase_push_notification_server_key = "AAAAc5bAbbg:APA91bE67wf1PrijhzCWRmb0vBcAEciA7-x-X_QrDUblDnbT1ij95hr619flMF2c4MFlfTOPU0g9usWaPPex0ho2W5bDxCGeKC0jlpBkmZEhXj0avb3MJ-NsTpwmEp-T7yQBq-e9MEHR";
		//$firebase_push_notification_server_key = "AIzaSyDqigFC0880hWtyGChS6TlZi3Vm_I4Q4Qk";
		//$deviceToken = "c8T6nDKFl68:APA91bEWa0IYJGeWK7m89vxQErP8hR69INX3NgkZ75GfadIa282oWLd4EsGCv9lcYVRM0KvuPu78KZnCRuxtWOyKly-zii85jbi5XYIPCDmURJx11FKj5-80xK-m4b26i3yQigjSe44E";
		$deviceToken = "f36lUmAdj1w:APA91bEMS-oLPX7UDItO1cglzYN0MBDfAfJ3AYIRKRfgWSbnbgDaQV_1EW3OjamTINuIM_2tB6Gt-o-GI6ZZcS-SBG3D45wrIIIKuBTmhhcIb7Dp8UdqmZ8sZ6OcTIcKrlIk6Kqap4Gl";
		$url = 'https://fcm.googleapis.com/fcm/send';
		//$url = 'https://gcm-http.googleapis.com/gcm/send';
		//https://android.googleapis.com/gcm/send'
		$fcmKey = $firebase_push_notification_server_key;

		
		$headers = array(
				'Authorization: key=' . $fcmKey,
				'Content-Type: application/json'
		);
		
		$ch = curl_init();		
		curl_setopt( $ch, CURLOPT_URL, $url );		
		curl_setopt( $ch, CURLOPT_POST, true );		
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );		
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );		
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);		
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);		
				
		//$data = array('title'=>'Yocabs Notification Title', 'message'=>'Yocabs Notification Message Body');
		$msg = array
		(
			'message' 	=> 'here is a message. message',
			'title'		=> 'This is a title. title',
			/* 'subtitle'	=> 'This is a subtitle. subtitle',
			'id'	=> 12,
			'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon' */
		);
		
		$post = array(
					'to' => $deviceToken,
					'data' => $msg
			);
			
			/* print_r($post);
			die(); */
			curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );			
			$result = curl_exec( $ch );			
			$response = '';
			
			if ( curl_errno( $ch ) )
			{
				$response .= 'Error ' . curl_error( $ch ) . print_r($post, true);
				echo $response;
				return false;
			}
			
			$objResult = json_decode($result, true);
		
		
		curl_close( $ch );
		echo $result;	
	}
	
	function pushNotificaton(){		
		// API access key from Google API's Console
		$API_ACCESS_KEY =  'AAAAZA6vRK8:APA91bHlfYreFEpCK18CSBahNCe7e4pU-3c3925duLwhxXvxAGbWF5m4K7U4oMKWht_BBCAZ6VC6v8dGIBnR14_X-lNxJQwiORNUgeM3Djm9ZvUQJRk_n3hjkuAG2D8-iVAqtN2IC1GU' ;
		$registrationIds = 'c8T6nDKFl68:APA91bEWa0IYJGeWK7m89vxQErP8hR69INX3NgkZ75GfadIa282oWLd4EsGCv9lcYVRM0KvuPu78KZnCRuxtWOyKly-zii85jbi5XYIPCDmURJx11FKj5-80xK-m4b26i3yQigjSe44E';
		// prep the bundle
		$msg = array
		(
			'message' 	=> 'here is a message. message',
			'title'		=> 'This is a title. title',
			'subtitle'	=> 'This is a subtitle. subtitle',
			'tickerText'	=> 'Ticker text here...Ticker text here...Ticker text here',
			'vibrate'	=> 1,
			'sound'		=> 1,
			'largeIcon'	=> 'large_icon',
			'smallIcon'	=> 'small_icon'
		);
		$fields = array
		(
			'registration_ids' 	=> $registrationIds,
			'data'			=> $msg
		);
		 
		$headers = array
		(
			'Authorization: key=' . $API_ACCESS_KEY,
			'Content-Type: application/json'
		);
		 
		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch );
		curl_close( $ch );
		echo $result;
	}
	
	function downloadImages(){
		$res = Cronjob::autoDownloadProductImage();
		if($res){
			echo "No Record Found";
		}else{
			echo "Done";
		}		
		exit;
	}
	
	function format($number) {
		$prefixes = 'KMGTPEZY';
		if ($number >= 1000) {
			for ($i=-1; $number>=1000; ++$i) {					
				$number =  $number/1000;				
			}
			return floor($number).$prefixes[$i];
		}
		return $number;
	}
	
	function index(){ 
		$post = array();
		
		if(array_key_exists('ua_id',$post)){
			echo $ua_id = FatUtility::int($post['ua_id']);
			
		}
		exit;
		
		$arr = array(
			0=>array('brand_id'=>1,'brand_name'=>'a'),
			1=>array('brand_id'=>2,'brand_name'=>'b'),
			2=>array('brand_id'=>3,'brand_name'=>'b'),
			3=>array('brand_id'=>1,'brand_name'=>'a'),
		);
		$arr = array_unique($arr,SORT_REGULAR);
		var_dump($arr); exit;
		 exit;
		exit;
		$arr = array(
			'1' =>'1',
			'680' =>'680',
			'89581' =>'89581',
			'8568715' =>'8568715',
			'98989682' =>'98989682',
			'974856883' =>'974856883',
			'3689712254' =>'3689712254',
			'323689712254' =>'323689712254',
			'12323689712254' =>'12323689712254',
		);
		
		foreach($arr as $val){
			echo $val.' - '. $this->format($val); 
			echo "<br>";
		}
		
		
		
		 exit;
		
		echo $file = file_get_contents($image_path);
		
		var_dump($file_row); exit;
			
	
		exit;
		echo str_replace('{product-name}',$productName,Labels::getLabel('MSG_{product-name}_is_temporary_out_of_stock_or_hold_by_other_customer', $this->siteLangId)); exit;
		$userId = UserAuthentication::getLoggedUserId();	
		/* Check product group belongs to current user[ */
		$row = ProductGroup::getAttributesById( 3 ) ;
		
		if( !$row || $row['prodgroup_user_id'] != $userId ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Access!', $this->siteLangId) );
			FatUtility::dieJsonError( Message::getHtml() );			
		}
		/* ] */
		exit;
		
		$obj = new Orders();
		$childOrderInfo = $obj->getOrderProductsByOpId(166,1);
		$userId = $childOrderInfo['order_user_id'];
		$orderId = $childOrderInfo['op_order_id'];
		if(!FatApp::getConfig('CONF_ENABLE_FIRST_TIME_BUYER_DISCOUNT')){
			return Labels::getLabel('MSG_First_time_buyer_discount_module_is_disabled',FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1));
		}
		$userId =  FatUtility::int($userId);
		
		$orderSrch = new OrderSearch();
		$orderSrch->addMultipleFields(array('order_language_id','order_date_added'));
		$orderSrch->addCondition('order_id','=',$orderId);
		$orderSrch->addCondition('order_user_id','=',$userId);
		$orderRs = $orderSrch->getResultSet();
		$orderData = FatApp::getDb()->fetch($orderRs);

		if($orderData == false){
			return Labels::getLabel('MSG_No_Record_Found',FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1));
		}
		
		$srch = new OrderSearch();
		$srch->joinOrderBuyerUser();
		$srch->addCondition('order_is_paid','=',Orders::ORDER_IS_PAID);
		$srch->addCondition('order_user_id','=',$userId);
		$srch->addCondition('order_id','!=',$orderId);
		$srch->addCondition('order_date_added','<=',$orderData['order_date_added']);
		$srch->addMultipleFields(array('count(order_id) as paidOrderCount'));
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();		
		$rs = $srch->getResultSet();
		$row = FatApp::getDb()->fetch($rs);
						
		if($row['paidOrderCount'] > 0 ){
			return;
		}
		
		$expiryDate = date('Y-m-d',strtotime(date('Y-m-d').' +'.FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_VALIDITY').'days'));
		$defaultLangId = $orderData['order_language_id'];
		$couponData = array(
			'coupon_identifier'=>Labels::getLabel('LBL_Discount_On_First_Purchase',$defaultLangId),
			'coupon_type'=>DiscountCoupons::TYPE_DISCOUNT,
			'coupon_code'=>uniqid().base64_encode($userId),
			'coupon_discount_in_percent'=>FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_IN_PERCENT'),
			'coupon_min_order_value'=>FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_MIN_ORDER_VALUE'),
			'coupon_discount_value'=>FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_DISCOUNT_VALUE'),
			'coupon_max_discount_value'=>FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_MAX_DISCOUNT_VALUE'),
			'coupon_start_date'=>date('Y-m-d'),
			'coupon_end_date'=>$expiryDate,
			'coupon_uses_count'=>1,
			'coupon_uses_coustomer'=>1,
			'coupon_active'=>applicationConstants::ACTIVE,
		);
		
		var_dump($couponData);
		$expiryDate = date('Y-m-d',strtotime(date('Y-m-d').' +'.FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_VALIDITY').'days'));
		$defaultLangId = $orderData['order_language_id'];
		$couponData = array(
			'coupon_identifier'=>Labels::getLabel('LBL_Discount_On_First_Purchase',$defaultLangId),
			'coupon_type'=>DiscountCoupons::TYPE_DISCOUNT,
			'coupon_code'=>uniqid().base64_encode($userId),
			'coupon_discount_in_percent'=>FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_IN_PERCENT'),
			'coupon_min_order_value'=>FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_MIN_ORDER_VALUE'),
			'coupon_discount_value'=>FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_DISCOUNT_VALUE'),
			'coupon_max_discount_value'=>FatApp::getConfig('CONF_FIRST_TIME_BUYER_COUPON_MAX_DISCOUNT_VALUE'),
			'coupon_start_date'=>date('Y-m-d'),
			'coupon_end_date'=>$expiryDate,
			'coupon_uses_count'=>1,
			'coupon_uses_coustomer'=>1,
			'coupon_active'=>applicationConstants::ACTIVE,
		);
		
		$record = new DiscountCoupons();
		$record->assignValues($couponData);
		if ($record->save()) { 
			$couponId = $record->getMainTableRecordId();
			
			if($couponId > 0 && $userId > 0){
				$record->addUpdateCouponUser($couponId, $userId ) ;
			}
			
			$languages = Language::getAllNames();	
			foreach($languages as $langId =>$langName ){
				$langData = array(
					'coupon_title'=>Labels::getLabel('LBL_Discount_On_First_Purchase',$langId),
					'couponlang_coupon_id'=>$couponId,
					'couponlang_lang_id'=>$langId
				);
				
				$obj = new DiscountCoupons($couponId);
				$obj->updateLangData($langId,$langData);
			}

			$emailNotificationObj = new EmailHandler();
			$emailNotificationObj->sendDiscountCouponNotification( $couponId,$userId,$orderData['order_language_id']);	
		}
		echo "success!";
		
		exit;
	
		$taxObj = new Tax();
		echo $tax = $taxObj->calculateTaxRates(59,23,119,1,1);
		exit;		
		$obj = new EmailHandler();
		$obj->NewOrderBuyerAdmin('O1496746780',1);
		echo  exit;
		$orderId = 'O1494913211';
		$op_id = 706;
		$obj = new Orders();
		$childOrderInfo = $obj->getOrderProductsByOpId($op_id,$langId = 1);
		echo "<pre>";
		print_r($childOrderInfo);		
		exit;		
	
		$optionValueArr = array('15_12','13_1','1_2','13_2','13_11');
		//$res = SellerProduct::getSellerProductOptionsBySelProdCode('1_15_17');
		sort($optionValueArr);
		foreach($optionValueArr as $val){
				$opVal =  explode("_",$val);
				$opValArr[$opVal[0]][] = $opVal[1];
			}
		$str = '( ';
			$orCnd = '';
			$andCnd = '';
			foreach($opValArr as $row){
				$str.= $andCnd;
				foreach($row as $val){
					$str.= $orCnd." "."selprod_code like '_".$val."%'";
					$orCnd = 'or';
				}
				$orCnd = "";
				$andCnd = ") and (";
			}
			$str.= " )";
echo $str;			
		var_dump($opValArr);
		exit;
		$this->cartObj = new Cart( UserAuthentication::getLoggedUserId(), $this->siteLangId );
		$cartProducts = $this->cartObj->getProducts($this->siteLangId);
		CommonHelper::printArray($cartProducts);
		exit;
	}
	
	function index_prinka(){
		$sellerProductId = 1;
		
		$productId = SellerProduct::getAttributesById($sellerProductId , 'selprod_product_id' , false );
		
		$db = FatApp::getDb();
		
		$srch = new ProductSearch( $this->siteLangId );
		$join_price = 1;//(isset($post['join_price']) && $post['join_price'] != '') ? $post['join_price'] : 0 ;
		
		$srch->setDefinedCriteria( $join_price );
		$srch->joinProductToCategory();
		
		$srch->addMultipleFields(array(
				'product_id', 'product_name', 'product_model', 'product_short_description', 
				'substring_index(group_concat(IFNULL(prodcat_name, prodcat_identifier) ORDER BY IFNULL(prodcat_name, prodcat_identifier) ASC SEPARATOR "," ) , ",", 1) as prodcat_name', 
				'selprod_id', 'selprod_user_id',  'selprod_code', 'selprod_stock', 'selprod_condition', 'selprod_price','selprod_title', 
				'special_price_found','splprice_display_list_price', 'splprice_display_dis_val', 'splprice_display_dis_type',
				'theprice', 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'brand_short_description', 'user_name', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 
				'selprod_return_policy',
				 ));
		
		$dateToEquate = date('Y-m-d');
		
		$srch->joinTable("(select rec_product_id from 
							(
								SELECT ppr_recommended_product_id as rec_product_id from tbl_product_product_recommendation 
								where ppr_viewing_product_id = $productId order by ppr_weightage desc limit 5
							) as set1
							union 
							select rec_product_id from 
							(
								select tpr_product_id  as rec_product_id from 
								(
									select * from tbl_product_to_tags where ptt_product_id = $productId 
								) innerSet1 inner JOIN tbl_tag_product_recommendation on tpr_tag_id = ptt_tag_id 
								order by if(tpr_custom_weightage_valid_till <= '$dateToEquate' , tpr_custom_weightage+tpr_weightage , tpr_weightage) desc limit 5
							) as set2)" , 'inner join' , 'set3.rec_product_id = product_id' , 'set3' );
							$srch->addGroupBy('selprod_id');
		$recommendedProducts = FatApp::getDb()->fetchAll($srch->getResultSet());
		var_dump($recommendedProducts);
		exit;
		
	}
			
	function test(){
		$this->_template->addCss('css/xzoom.css');
		$this->_template->addJs('js/xzoom.js');
		$this->_template->render();
			
		/* $info = DiscountCoupons::getValidCoupons(4,1,'asd10');
var_dump($info);
		exit;
			
		$orders = new Orders('O1538197607');	
		$childOrderInfo = $orders->getOrderProductsByOpId(122,1);
		echo $childOrderInfo["op_free_ship_upto"].'-'.$childOrderInfo["op_actual_shipping_charges"].'-'.$childOrderInfo['charges'][OrderProduct::CHARGE_TYPE_SHIPPING]['opcharge_amount'];
		if(0 < $childOrderInfo["op_free_ship_upto"] && array_key_exists(OrderProduct::CHARGE_TYPE_SHIPPING,$childOrderInfo['charges']) && $childOrderInfo["op_actual_shipping_charges"] != $childOrderInfo['charges'][OrderProduct::CHARGE_TYPE_SHIPPING]['opcharge_amount']){
			die('dsds');
		}	
		CommonHelper::printArray($childOrderInfo); exit; */
	}
	
	private function getShopInfo($shop_id){
		$db = FatApp::getDb();
		$shop_id = FatUtility::int($shop_id);
		$srch = new ShopSearch( $this->siteLangId );
		$srch->setDefinedCriteria( $this->siteLangId );
		$srch->doNotCalculateRecords();
		
		$srch->addMultipleFields(array( 'shop_id','shop_user_id','shop_ltemplate_id', 'shop_created_on', 'shop_name', 'shop_description', 
		'shop_country_l.country_name as shop_country_name', 'shop_state_l.state_name as shop_state_name', 'shop_city' ));
		$srch->addCondition( 'shop_id', '=', $shop_id );
		$shopRs = $srch->getResultSet();
		return $shop = $db->fetch( $shopRs );
	}
	
	public function whoFavoritesShop($shop_id){
		$db = FatApp::getDb();
		$shop_id = FatUtility::int($shop_id);
		
		$shopData = $this->getShopInfo($shop_id);
		if( !$shopData ){
			Message::addErrorMessage( Labels::getLabel('LBL_Invalid_Request', $this->siteLangId) );
			FatApp::redirectUser(CommonHelper::generateUrl('Home'));
		}
		
		$srch = new UserFavoriteShopSearch($this->siteLangId);
		$srch->joinWhosFavouriteUser();
		
		/* $srch->setDefinedCriteria();
		$srch->joinWhosFavoritesUser(); */
		
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addCondition('ufs_shop_id','=',$shop_id);
	
		//$srch->addMultipleFields(array( 'ufs_user_id','s.shop_id', 'IFNULL(s.shop_name, s.shop_identifier) as shop_name', 'u.user_name as shop_owner_name','uf.user_name as favorite_user_name', ));
		$rs = $srch->getResultSet();
		$shops = $db->fetchAll( $rs );
		
		$totalProductsToShow = 4;
		if( $shops ){
			$prodSrchObj = new ProductSearch( $this->siteLangId );
			$prodSrchObj->setDefinedCriteria( 0 );			
			$prodSrchObj->setPageNumber(1);
			$prodSrchObj->setPageSize($totalProductsToShow);
			foreach( $shops as &$shop ){
				$prodSrch = clone $prodSrchObj;
				$prodSrch->addShopIdCondition( $shop['shop_id'] );
				$prodSrch->addMultipleFields( array( 'selprod_id', 'product_id', 'IFNULL(shop_name, shop_identifier) as shop_name',
				'IFNULL(product_name, product_identifier) as product_name', 
				'IF(selprod_stock > 0, 1, 0) AS in_stock') );
				$prodRs = $prodSrch->getResultSet();
				$shop['totalProducts'] = $prodSrch->recordCount();
				$shop['products'] = $db->fetchAll( $prodRs );
			}
		}
				
		$this->set('totalProductsToShow', $totalProductsToShow);
		$this->set( 'shops', $shops );
		$this->set( 'shopData', $shopData );
		$this->_template->render( );
	}
	

	/* function updateCountries(){
		// Get table from open cart
		$srch = new SearchBase('oc_country');
		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$rs = $srch->getResultSet();
		$records = FatApp::getDb()->fetchAll($rs,'country_id');
		foreach($records as $country){
			$assignValues = array(
				'country_id' => $country['country_id'],
				'country_code' => $country['iso_code_2'],
				'country_active' => applicationConstants::ACTIVE,
			);
			FatApp::getDb()->insertFromArray('tbl_countries',$assignValues,false,array(),$assignValues);

			$assignData = array(
				'countrylang_country_id' => $country['country_id'],
				'country_name' => $country['name'],
				'countrylang_lang_id' => 1,
			);
			FatApp::getDb()->insertFromArray('tbl_countries_lang',$assignData,false,array(),$assignData);
		}
	} */

	function getCountries(){
		$srch = new SearchBase('tbl_countries','c');
		$srch->joinTable('tbl_countries_lang','INNER JOIN','c_l.countrylang_country_id = c.country_id and c_l.countrylang_lang_id = 1','c_l');
		$srch->joinTable('tbl_countries_temp','LEFT OUTER JOIN','t.country_temp_name = c_l.country_name','t');

		$srch->doNotCalculateRecords();
		$srch->doNotLimitRecords();
		$srch->addFld(array('country_id','country_code','country_name','country_temp_id','country_temp_name'));

		$rs = $srch->getResultSet();
		$records = FatApp::getDb()->fetchAll($rs);
		$arr = array();
		foreach($records as $country){
			$arr[$country['country_temp_id']] = $country['country_id'];
		}
		//$this->getStates($arr);
		 echo count($arr);
		echo "<pre>";
		print_r($arr);
		//var_dump($records);
	}
	
	function cookie(){
		$isAffiliateCookieSet = false;
		$isReferrerCookieSet = false;
		
		if( isset($_COOKIE['affiliate_referrer_code_signup']) && $_COOKIE['affiliate_referrer_code_signup'] != '' ){
			$isAffiliateCookieSet = true;
		}
		
		if( isset($_COOKIE['referrer_code_signup']) && $_COOKIE['referrer_code_signup'] != '' ){
			$isReferrerCookieSet = true;
		}
		
		/* prioritize only when, both cookies are set, then credit on the basis of latest cookie set. [ */
		if( $isAffiliateCookieSet && $isReferrerCookieSet ){
			$affiliateReferrerCookieArr = unserialize( $_COOKIE['affiliate_referrer_code_signup'] );
			$referrerCookieArr = unserialize( $_COOKIE['referrer_code_signup'] );
			if( $affiliateReferrerCookieArr['creation_time'] > $referrerCookieArr['creation_time'] ){
				$isReferrerCookieSet = false;
			} else {
				$isAffiliateCookieSet = false;
			}
		}
		/* ] */
	}

	public function reviewReminder(){
		
		Cronjob::remindBuyerForPendingReviews();
		
	}
	public function autoRenewSubscription(){
		
		Cronjob::autoRenewSubscription();
		
	}
	
	function get_category_structure(){
		$categoriesDataArr = ProductCategory::getProdCatParentChildWiseArr( $this->siteLangId,0,false);
		commonhelper::printarray($categoriesDataArr);
		die();
	}
	
	function testCache(){
		 $collectionCache =  FatCache::get('testcache',1000,'.txt');
		
		if(!$collectionCache){
			die;
			FatCache::set('testcache','testing the cache','.txt'); 
		}
		echo FatCache::getCachedUrl('testcache', 100000, '.txt') ;

	}
	
	
	function truncateTables( $type = 'orders' ){
		if ( $type == 'orders' ){
			$tables = array('tbl_orders','tbl_orders_lang','tbl_orders_status_history','tbl_order_cancel_requests','tbl_order_extras','tbl_order_payments','tbl_order_products','tbl_order_products_lang','tbl_order_product_charges','tbl_order_product_charges_lang','tbl_order_product_digital_download_links','tbl_order_product_shipping','tbl_order_product_shipping_lang','tbl_order_product_to_shipping_users','tbl_order_return_requests','tbl_order_return_request_messages','tbl_order_seller_subscriptions','tbl_order_seller_subscriptions_lang','tbl_order_user_address','tbl_user_reward_points','tbl_user_reward_point_breakup','tbl_rewards_on_purchase','tbl_user_transactions','tbl_coupons_history','tbl_coupons_hold','tbl_user_cart','tbl_order_product_settings');
			FatApp::getDb()->query('UPDATE `tbl_seller_products` SET `selprod_sold_count` = 0 WHERE 1');
		}elseif ( $type == 'all' ){
			$tables = array('tbl_abusive_words','tbl_admin_auth_token','tbl_admin_password_reset_requests','tbl_admin_permissions','tbl_affiliate_commission_setting_history','tbl_affiliate_commission_settings','tbl_attached_files_temp','tbl_attribute_group_attributes','tbl_attribute_group_attributes_lang','tbl_attribute_groups','tbl_banner_locations_lang','tbl_banners','tbl_banners_clicks','tbl_banners_lang','tbl_banners_logs','tbl_blog_contributions','tbl_blog_post','tbl_blog_post_categories','tbl_blog_post_categories_lang','tbl_blog_post_comments','tbl_blog_post_lang','tbl_blog_post_to_category','tbl_brands','tbl_brands_lang','tbl_catalog_request_messages','tbl_collection_to_product_categories','tbl_collection_to_seller_products','tbl_collection_to_shops','tbl_collections','tbl_collections_lang','tbl_commission_setting_history','tbl_content_block_to_category','tbl_coupon_to_category','tbl_coupon_to_plan','tbl_coupon_to_products','tbl_coupon_to_seller','tbl_coupon_to_users','tbl_coupons','tbl_coupons_history','tbl_coupons_hold','tbl_coupons_lang','tbl_cron_log','tbl_email_archives','tbl_extra_attribute_groups','tbl_extra_attribute_groups_lang','tbl_extra_attributes','tbl_extra_attributes_lang','tbl_failed_login_attempts','tbl_faq_categories','tbl_faq_categories_lang','tbl_faqs','tbl_faqs_lang','tbl_filter_groups','tbl_filter_groups_lang','tbl_filters','tbl_filters_lang','tbl_import_export_settings','tbl_manual_shipping_api','tbl_manual_shipping_api_lang','tbl_meta_tags_lang','tbl_notifications','tbl_option_values','tbl_option_values_lang','tbl_options','tbl_options_lang','tbl_order_cancel_reasons_lang','tbl_order_cancel_requests','tbl_order_extras','tbl_order_payments','tbl_order_product_charges','tbl_order_product_charges_lang','tbl_order_product_shipping','tbl_order_product_shipping_lang','tbl_order_product_to_shipping_users','tbl_order_products','tbl_order_products_lang','tbl_order_return_request_messages','tbl_order_return_requests','tbl_order_seller_subscriptions','tbl_order_seller_subscriptions_lang','tbl_order_seller_subscriptions_lang_old','tbl_order_user_address','tbl_orders','tbl_orders_lang','tbl_orders_status_history','tbl_orders_status_lang','tbl_policy_points','tbl_policy_points_lang','tbl_polling','tbl_polling_feedback','tbl_polling_lang','tbl_polling_to_category','tbl_polling_to_products','tbl_product_categories','tbl_product_categories_lang','tbl_product_groups','tbl_product_groups_lang','tbl_product_numeric_attributes','tbl_product_product_recommendation','tbl_product_shipping_rates','tbl_product_special_prices','tbl_product_specifications','tbl_product_specifications_lang','tbl_product_stock_hold','tbl_product_text_attributes','tbl_product_to_category','tbl_product_to_groups','tbl_product_to_options','tbl_product_to_tags','tbl_product_to_tax','tbl_product_volume_discount','tbl_products','tbl_products_browsing_history','tbl_products_lang','tbl_products_shipped_by_seller','tbl_products_shipping','tbl_products_temp_ids','tbl_promotion_item_charges','tbl_promotions','tbl_promotions_charges','tbl_promotions_clicks','tbl_promotions_lang','tbl_promotions_logs','tbl_promotions_old','tbl_question_banks','tbl_question_banks_lang','tbl_question_to_answers','tbl_questionnaire_feedback','tbl_questionnaires','tbl_questionnaires_lang','tbl_questionnaires_to_question','tbl_questions','tbl_questions_lang','tbl_recommendation_activity_browsing','tbl_related_products','tbl_rewards_on_purchase','tbl_search_items','tbl_seller_brand_requests','tbl_seller_brand_requests_lang','tbl_seller_catalog_requests','tbl_seller_packages','tbl_seller_packages_lang','tbl_seller_packages_plan','tbl_seller_product_options','tbl_seller_product_policies','tbl_seller_product_rating','tbl_seller_product_reviews','tbl_seller_product_reviews_abuse','tbl_seller_product_reviews_helpful','tbl_seller_products','tbl_seller_products_lang','tbl_seller_products_temp_ids','tbl_shipping_company','tbl_shipping_company_lang','tbl_shipping_durations','tbl_shipping_durations_lang','tbl_shippingapi_settings','tbl_shop_collection_products','tbl_shop_collections','tbl_shop_collections_lang','tbl_shop_reports','tbl_shops','tbl_shops_lang','tbl_shops_to_theme','tbl_smart_log_actions','tbl_smart_products_weightage','tbl_smart_remommended_products','tbl_smart_user_activity_browsing','tbl_smart_weightage_settings','tbl_social_platforms','tbl_social_platforms_lang','tbl_success_stories','tbl_success_stories_lang','tbl_tag_product_recommendation','tbl_tags','tbl_tags_lang','tbl_tax_categories','tbl_tax_categories_lang','tbl_tax_values','tbl_testimonials','tbl_testimonials_lang','tbl_theme','tbl_theme_lang','tbl_thread_messages','tbl_threads','tbl_tool_tips','tbl_tool_tips_lang','tbl_upsell_products','tbl_url_rewrite','tbl_user_address','tbl_user_auth_token','tbl_user_bank_details','tbl_user_cart','tbl_user_credentials','tbl_user_email_verification','tbl_user_extras','tbl_user_favourite_products','tbl_user_favourite_shops','tbl_user_password_reset_requests','tbl_user_product_recommendation','tbl_user_return_address','tbl_user_return_address_lang','tbl_user_reward_point_breakup','tbl_user_reward_points','tbl_user_supplier_request_values','tbl_user_supplier_request_values_lang','tbl_user_supplier_requests','tbl_user_transactions','tbl_user_wish_list_products','tbl_user_wish_lists','tbl_user_withdrawal_requests','tbl_users','tbl_order_product_settings','tbl_user_requests_history');
			/* DELETE FROM `tbl_attached_files` WHERE `afile_type` in (1,2,3,4,5,7,9,10,11,12,13,14,22,23,24,25,26,27,28,29,30,32,33,41,42,43,48) */
		}
		
		foreach($tables as $table) 
		{
			$result = FatApp::getDb()->query("TRUNCATE TABLE `".$table."`");
			
			if($result) {
				echo 'Done: '.$table.' <br>';
			} else {
				echo 'Error in: '.$table.' <br>';
			}	
		}
	}
	
	function sendMail()
	{
		$headers = "From: developer@4demo.biz" . "\r\n" .
		"CC: anup.rawat@ablysoft.com";

		if(!mail("manpreet.kaur@fatbit.in", "testing", "Hello Manpreet Kaur", $headers)) {
			die("mail has not been sent");
		}else{
			die("mail has been sent successfully");
		}
	}
	
	
	function testOrder()
	{
		$db = FatApp::getDb();
		$linkData = array();
		$sellerProduct = SellerProduct::getAttributesById(231, array('selprod_downloadable_link'));
		$downlodableLinks = preg_split("/\n|,/", $sellerProduct['selprod_downloadable_link']);
		/* CommonHelper::printArray($downlodableLinks);die; */
		foreach($downlodableLinks as $link) {
			$linkData['opddl_op_id'] = 945;
			$linkData['opddl_downloadable_link'] = $link;
			if(!$db->insertFromArray(OrderProductDigitalLinks::DB_TBL,$linkData)){
				$db->rollbackTransaction();
				$this->error = $opLangRecordObj->getError();
				return false;
			}
		}
	}
	
	function checkEmailTemplate()
	{
		$selprod_id = array(109,141,148,59,66);
		$prodSrch = new ProductSearch(1);
		$prodSrch->setDefinedCriteria(0,0,array(),false);
		$prodSrch->joinProductToCategory();
		$prodSrch->joinSellerSubscription();
		$prodSrch->addSubscriptionValidCondition();
		$prodSrch->doNotCalculateRecords();
		$prodSrch->addCondition( 'selprod_id', 'IN', $selprod_id );
		$prodSrch->addCondition('selprod_deleted','=',applicationConstants::NO);
		$prodSrch->doNotLimitRecords();
		$prodSrch->addMultipleFields( array(
			'product_id','product_identifier', 'IFNULL(product_name,product_identifier) as product_name', 'product_seller_id', 'product_model','product_type', 'prodcat_id', 'IFNULL(prodcat_name,prodcat_identifier) as prodcat_name', 'product_upc', 'product_isbn',
			'selprod_id', 'selprod_user_id', 'selprod_condition', 'selprod_price', 'special_price_found', 'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
			'theprice', 'selprod_stock' , 'selprod_threshold_stock_level', 'IF(selprod_stock > 0, 1, 0) AS in_stock', 'brand_id', 'IFNULL(brand_name, brand_identifier) as brand_name', 'user_name',
			'shop_id', 'shop_name',
			'splprice_display_dis_type', 'splprice_display_dis_val', 'splprice_display_list_price') );
		$productRs = $prodSrch->getResultSet();
		$products = FatApp::getDb()->fetchAll($productRs); 
		
		$this->set('products', $products);
		$this->_template->render(false, false, '_partial/products-in-cart-email.php');
	}
	
	public static function orderProduct($orderId='O1530169223', $opId='428', $isRefunded = true, $isCancelled = true){
		
		/* $op = new Orders();
		$childOrderInfo = $op->getOrderProductsByOpId($op_id,1);
		CommonHelper::printArray($childOrderInfo); */
		$opSrch = OrderProduct::getSearchObject();
		$opSrch->doNotCalculateRecords();
		$opSrch->doNotLimitRecords();
		$opSrch->addMultipleFields(array('op_id','op_selprod_id','op_selprod_user_id','op_unit_price','op_qty','op_actual_shipping_charges'));
		$opSrch->addCondition('op_order_id','=',$orderId);
		if($opId){
			$opSrch->addCondition('op_id','!=',$opId);
		}
		if($isRefunded){
			$opSrch->addCondition(OrderProduct::DB_TBL_PREFIX . 'refund_qty','=',0);
		}
		if($isCancelled){
			$opSrch->joinTable(OrderCancelRequest::DB_TBL,'LEFT OUTER JOIN','ocr.'.OrderCancelRequest::DB_TBL_PREFIX.'op_id = op.op_id','ocr');
			$cnd = $opSrch->addCondition(OrderCancelRequest::DB_TBL_PREFIX . 'status', '!=',1);
			$cnd->attachCondition(OrderCancelRequest::DB_TBL_PREFIX . 'status', 'IS', 'mysql_func_null', 'OR', true);
		}
		echo $opSrch->getQuery(); 	
		$rs = $opSrch->getResultSet();
		$row = FatApp::getDb()->fetchAll($rs);
		CommonHelper::printArray($row); die;
	}
	
	
	
	function changeCustomUrl1(){
		$urlSrch = UrlRewrite::getSearchObject();
		$urlSrch->doNotCalculateRecords();
		$urlSrch->addMultipleFields(array('urlrewrite_id','urlrewrite_original','urlrewrite_custom'));
		$rs = $urlSrch->getResultSet();
		$urlRows = FatApp::getDb()->fetchAll($rs);
		$db = FatApp::getDb();
		foreach($urlRows as $row){
			$url = str_replace("/","-",$row['urlrewrite_custom']);
			if($db->updateFromArray(UrlRewrite::DB_TBL, array('urlrewrite_custom' => $url), array('smt' => 'urlrewrite_id = ?', 'vals' => array($row['urlrewrite_id'])))){
			echo $row['urlrewrite_id']."<br>";
			}			
		}
	}
}
