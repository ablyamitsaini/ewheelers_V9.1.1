<?php
class TestDrive extends MyAppModel
{
    const DB_TBL = 'tbl_product_test_drive_request';
    const DB_TBL_PREFIX = 'ptdr_';

    const STATUS_PENDING = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_DELIVERED = 3;
    const STATUS_COMPLETED = 4;
    const STATUS_ACCEPTED = 5;

    private $requestId;

    public function __construct($reqId = 0)
    {
        $this->requestId =  $reqId;
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $reqId);
        $this->objMainTableRecord->setSensitiveFields(array('ptdr_status'));
    }

    public static function getStatusArr($langId)
    {
        return array(
        static::STATUS_PENDING  => Labels::getLabel('LBL_PENDING', $langId),
        static::STATUS_CONFIRMED  => Labels::getLabel('LBL_CONFIRMED', $langId),
        static::STATUS_CANCELLED  => Labels::getLabel('LBL_CANCELLED', $langId),
        static::STATUS_ACCEPTED  => Labels::getLabel('LBL_ACCEPTED', $langId),
        static::STATUS_DELIVERED  => Labels::getLabel('LBL_DELIVERED', $langId),
        static::STATUS_COMPLETED  => Labels::getLabel('LBL_COMPLETED', $langId),
        );
    }

    public function canRequest($userId, $selprod_id, $siteLangId)
    {
        $user_is_buyer = User::getAttributesById($userId, 'user_is_buyer');
        if (!$user_is_buyer) {
            $this->error = Labels::getLabel('MSG_Please_login_with_buyer_account_to_request_for_test_drive', $siteLangId);
            return false;
        }

        $selprod_data = SellerProduct::getAttributesById($selprod_id);
        if ($selprod_data['selprod_user_id'] == $userId) {
            $this->error = Labels::getLabel('LBL_You_Cannot_Request_For_Your_Own_Products', $siteLangId);
            return false;
        }

        $db = FatApp::getDb();
        $srch = new SearchBase(static::DB_TBL);
        $srch->addCondition(static::DB_TBL_PREFIX.'user_id', '=', $userId);
        $srch->addCondition(static::DB_TBL_PREFIX.'selprod_id', '=', $selprod_id);
        $cnd = $srch->addCondition(static::DB_TBL_PREFIX.'status', '=', Self::STATUS_PENDING);
        $cnd->attachCondition(static::DB_TBL_PREFIX.'status', '=', Self::STATUS_DELIVERED, 'OR');
		$cnd->attachCondition(static::DB_TBL_PREFIX.'status', '=', Self::STATUS_ACCEPTED, 'OR');
		$cnd->attachCondition(static::DB_TBL_PREFIX.'status', '=', Self::STATUS_COMPLETED, 'OR');
        $cnd->attachCondition(static::DB_TBL_PREFIX.'status', '=', Self::STATUS_CONFIRMED);

        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);
        if (!empty($row)) {
            $this->error = Labels::getLabel('MSG_You_already_Placed_request_for_same_product', $siteLangId);
            return false;
        }

        return true;
    }

    public function canChangeStatus($loggedUserId, $status)
    {
        $BuyerUserId = parent::getAttributesById($this->requestId, static::DB_TBL_PREFIX.'user_id');
        if ($loggedUserId == $BuyerUserId) {
            if ($status == static::STATUS_CANCELLED || $status == static::STATUS_CONFIRMED) {
                return true;
            }
            return false;
        }

        $selProdId = parent::getAttributesById($this->requestId, static::DB_TBL_PREFIX.'selprod_id');
        $sellerUserId = SellerProduct::getAttributesById($selProdId, 'selprod_user_id', false);

        if ($loggedUserId == $sellerUserId) {
            if ($status == static::STATUS_CANCELLED || $status == static::STATUS_PENDING || $status == static::STATUS_DELIVERED || $status == static::STATUS_ACCEPTED ) {
                return true;
            }
            return false;
        }

        return false;
    }

    public static function getSearchForm($langId)
    {
        $frm = new Form('frmTestDriveRequest');
        $frm->addTextBox(Labels::getLabel('LBL_Search_By', $langId), 'keyword');
        $frm->addSelectBox(Labels::getLabel('LBL_Request_Type', $langId), 'status', array( '-1' => Labels::getLabel('LBL_All', $langId) ) + Self::getStatusArr($langId), '-1', array(), '');
        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Submit', $langId));
        $frm->addButton('&nbsp;', 'btn_clear', Labels::getLabel('LBL_Clear', $langId));
        $frm->addHiddenField('', 'page');
        return $frm;
    }

    public static function getSearchObject()
    {
        $srch = new SearchBase(static::DB_TBL, 'td');
        $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'sp.selprod_id = td.ptdr_selprod_id', 'sp');
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'u.user_id = td.ptdr_user_id', 'u');
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_LANG_TBL, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = '.CommonHelper::getLangId(), 'p_l');
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'seller.user_id = sp.selprod_user_id', 'seller');
        $srch->joinTable(AttributeGroup::DB_TBL, 'LEFT OUTER JOIN', 'p.product_attrgrp_id = attrgrp_id', 'attrgrp');
        return $srch;
    }


    public static function addSearchFields($extraFields = array())
    {
        $multipleFlds =	array(
                            'product_id',
                            'product_identifier',
                            'IFNULL(product_name, product_identifier) as product_name',
                            'attrgrp_name',
                            'product_seller_id ',
                            'product_type',
                            'product_active',
                            'product_approved',
                            'ptdr_status',
                            'ptdr_selprod_id',
                            'ptdr_contact',
                            'ptdr_id',
                            'ptdr_location',
                            'ptdr_comments',
                            'ptdr_date',
							'ptdr_feedback',
							'ptdr_request_added_on',
                            'u.user_name as buyername',
                            'seller.user_name as sellername',
                            );

        if (!empty($extraFields)) {
            $multipleFlds = $extraFields + $multipleFlds;
        }

        return $multipleFlds;
    }


    public function sendTestDriveRequestEmail($testDriveId, $langId)
    {
        $tpl = 'new_test_drive_request_to_seller';
        $srch = TestDrive::getSearchObject();
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'u_c.credential_user_id = selprod_user_id', 'u_c');
        $srch->addCondition('td.ptdr_id', '=', $testDriveId);
        $srch->addMultipleFields(array('u.user_name as buyername', 'ptdr_location', 'credential_email', 'ptdr_contact', 'ptdr_date', 'product_name' ));
        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetch($rs);

        $vars = array(
        '{product_name}' => $arr_listing['product_name'],
        '{requestee_name}' => $arr_listing['buyername'],
        '{requestee_location}' => $arr_listing['ptdr_location'],
        '{requestee_contact}' => $arr_listing['ptdr_contact'],
        '{requested_date}' => FatDate::format($arr_listing['ptdr_date'],true),
        );

        if (EmailHandler::sendMailTpl($arr_listing['credential_email'], $tpl, $langId, $vars)) {
            return true;
        }
        return false;
    }
	
	public function sendTestDriveRequestDetailEmailBuyer($testDriveId, $langId)
    {
        $tpl = 'test_drive_request_detail_buyer';
        $srch = TestDrive::getSearchObject();
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'u_c.credential_user_id = ptdr_user_id', 'u_c');
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'users.user_id = selprod_user_id', 'users');
        $srch->addCondition('td.ptdr_id', '=', $testDriveId);
        $srch->addMultipleFields(array('u.user_name as buyername', 'ptdr_location', 'credential_email', 'ptdr_comments', 'ptdr_feedback', 'ptdr_contact', 'ptdr_date', 'product_name','seller.user_name as sellername','users.user_phone as seller_contact'));
        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetch($rs);
	
        $vars = array(
        '{product_name}' => $arr_listing['product_name'],
        '{requestee_name}' => $arr_listing['buyername'],
        '{requestee_location}' => $arr_listing['ptdr_location'],
        '{requestee_contact}' => $arr_listing['ptdr_contact'],
        '{requested_date}' => FatDate::format($arr_listing['ptdr_date'],true),
		'{buyer_name}' => $arr_listing['buyername'],
		'{seller_name}' => $arr_listing['sellername'],
		'{seller_contact}' => $arr_listing['seller_contact'],
        );

        if (EmailHandler::sendMailTpl($arr_listing['credential_email'], $tpl, $langId, $vars)) {
            return true;
        }
        return false;
    }
	
	public function sendStatusChangedEmailUpdateSeller($testDriveId,$status,$langId){

		switch ($status) {
			case static::STATUS_CONFIRMED:
				$request_status = 'Confirmed';
				$request_changed_by = 'Buyer';
				$tpl = 'test_drive_status_change_updates_seller';
				break;
			case static::STATUS_CANCELLED:
				$request_status = 'Cancelled';
				$request_changed_by = 'Buyer';
				$tpl = 'test_drive_status_cancel_update_seller';
				break;
			case static::STATUS_COMPLETED:
				$request_status = 'Completed';
				$request_changed_by = 'Admin';
				$tpl = 'test_drive_status_change_updates_seller';
				break;
		}
				
		$srch = TestDrive::getSearchObject();
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'u_c.credential_user_id = selprod_user_id', 'u_c');
        $srch->addCondition('td.ptdr_id', '=', $testDriveId);
        $srch->addMultipleFields(array('u.user_name as buyername', 'ptdr_location', 'credential_email', 'ptdr_comments', 'ptdr_feedback', 'ptdr_contact', 'ptdr_date', 'product_name','seller.user_name as sellername'));
        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetch($rs);

        $vars = array(
        '{product_name}' => $arr_listing['product_name'],
        '{requestee_name}' => $arr_listing['buyername'],
		'{seller_name}' => $arr_listing['sellername'],
        '{requestee_location}' => $arr_listing['ptdr_location'],
        '{requestee_contact}' => $arr_listing['ptdr_contact'],
        '{requested_date}' => FatDate::format($arr_listing['ptdr_date'],true),
        '{cancellation_comment}' => $arr_listing['ptdr_comments'],
        '{feedback}' => $arr_listing['ptdr_feedback'],
        '{request_status}' => $request_status,
        '{receiver_user_type}' => 'Seller', 
		'{request_changed_by}' => $request_changed_by
        );

        if (EmailHandler::sendMailTpl($arr_listing['credential_email'], $tpl, $langId, $vars)) {
            return true;
        }
        return false;
		
	} 
	
 	public function sendStatusChangedEmailUpdateBuyer($testDriveId,$status,$langId){
		
		switch ($status) {
			case static::STATUS_ACCEPTED:
				$request_status = 'Accepted';
				$request_changed_by = 'Seller';
				$tpl = 'test_drive_status_change_update_accepted';
				break;
			case static::STATUS_CANCELLED:
				$request_status = 'Cancelled';
				$request_changed_by = 'Seller';
				$tpl = 'test_drive_cancel_update_to_buyer';
				break;
			case static::STATUS_COMPLETED:
				$request_status = 'Completed';
				$request_changed_by = 'Admin';
				$tpl = 'test_drive_status_change_updates_buyer';
				break;
			case static::STATUS_DELIVERED:
				$request_status = 'Delivered';
				$request_changed_by = 'Seller';
				$tpl = 'test_drive_status_change_updates_buyer';
				break;
		}
		
		
		$srch = TestDrive::getSearchObject();
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'u_c.credential_user_id = ptdr_user_id', 'u_c');
		$srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'users.user_id = selprod_user_id', 'users');
        $srch->addCondition('td.ptdr_id', '=', $testDriveId);
        $srch->addMultipleFields(array('u.user_name as buyername', 'ptdr_location', 'credential_email', 'ptdr_comments', 'ptdr_feedback', 'ptdr_contact', 'ptdr_date', 'product_name','seller.user_name as sellername','users.user_phone as seller_contact'));
        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $arr_listing = $db->fetch($rs);

        $vars = array(
        '{product_name}' => $arr_listing['product_name'],
        '{requestee_name}' => $arr_listing['buyername'],
		'{seller_name}' => $arr_listing['sellername'],
		'{seller_contact}' => $arr_listing['seller_contact'],
        '{requestee_location}' => $arr_listing['ptdr_location'],
        '{requestee_contact}' => $arr_listing['ptdr_contact'],
        '{requested_date}' => FatDate::format($arr_listing['ptdr_date'],true),
        '{cancellation_comment}' => $arr_listing['ptdr_comments'],
        '{seller_comment}' => $arr_listing['ptdr_comments'],
        '{feedback}' => $arr_listing['ptdr_feedback'],
		'{receiver_user_type}' => 'Buyer',
        '{request_status}' => $request_status,
		'{request_changed_by}' => $request_changed_by
        );

        if (EmailHandler::sendMailTpl($arr_listing['credential_email'], $tpl, $langId, $vars)) {
            return true;
        }
        return false;
	}
	
	
}
