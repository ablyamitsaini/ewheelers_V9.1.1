<?php
trait SellerRentalProducts
{
	/* [ Product Rental Functionality */
	public static function isProductRental($selprod_id) {
		if (!$selprod_id) {
			return false;
		}
		$srch = ProductRental::getSearchObject();
		$srch->addCondition('sprodata_selprod_id', '=', $selprod_id);
		$rs = $srch->getResultSet();
		$prodRentalData = FatApp::getDb()->fetch($rs);
		if (!empty($prodRentalData)) {
			if ($prodRentalData['sprodata_is_for_rent'] > 0) {
				return true;
			} else {
				return  false;
			}
		} else {
			return false;
		}
	}
	
	public static function isProductSale($selprod_id) {
		if (!$selprod_id) {
			return false;
		}
		$srch = ProductRental::getSearchObject();
		$srch->addCondition('sprodata_selprod_id', '=', $selprod_id);
		$rs = $srch->getResultSet();
		$prodRentalData = FatApp::getDb()->fetch($rs);
		if (!empty($prodRentalData)) {
			if ($prodRentalData['sprodata_is_for_sell'] > 0) {
				return true;
			} else {
				return  false;
			}
		} else {
			return false;
		}
	}
	
	
	public function productRentalDetailsForm()
    {
		
        $post = FatApp::getPostedData();
        $selprod_id = FatUtility::int($post['selprod_id']);
		
        $sellerProductRow = SellerProduct::getAttributesById($selprod_id);
        if ($sellerProductRow['selprod_user_id'] != UserAuthentication::getLoggedUserId()) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
            FatApp::redirectUser($_SESSION['referer_page_url']);
        }
		
		$productRow = Product::getAttributesById($sellerProductRow['selprod_product_id'], array('product_type'));
		$srch = ProductRental::getSearchObject();
		$srch->addCondition('sprodata_selprod_id', '=', $selprod_id);
		$rs = $srch->getResultSet();
		$prodRentalData = FatApp::getDb()->fetch($rs);
		
		$productRentalForm = $this->getProductRentalForm($selprod_id);
        $productRentalForm->fill($prodRentalData);
		
		$is_rent = $this->isProductRental($selprod_id);
		
		$this->set('productRentalForm', $productRentalForm);
        $this->set('activeTab', 'RENT');
		$this->set('product_id', $sellerProductRow['selprod_product_id']);
        $this->set('selprod_id', $selprod_id);
        $this->set('is_rent', $is_rent);
        $this->set('is_sale', $this->isProductSale($selprod_id));
        $this->set('product_type', $productRow['product_type']);
        $this->_template->render(false, false);
    }
	
	public function setupProdRentalData()
    {
        $post = FatApp::getPostedData();
        $sprod_id = FatUtility::int($post['sprodata_id']);
        $sprod_selprod_id = FatUtility::int($post['sprodata_selprod_id']);
		if(!isset($post['sprodata_rental_is_pickup'])) {
			$post['sprodata_rental_is_pickup'] = 0;
		}
		
		
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

		$record = new ProductRental($sprod_id);
		$record->assignValues($post);

        if (!$record->save()) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
		
		$this->set('msg', Labels::getLabel("MSG_Setup_Successful", $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
	
	public function sellerProductDurationDiscounts($selprod_id)
    {
        $selprod_id = FatUtility::int($selprod_id);
        $sellerProductRow = SellerProduct::getAttributesById($selprod_id, array('selprod_user_id', 'selprod_id', 'selprod_product_id' ));

        if ($sellerProductRow['selprod_user_id'] != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }

        $productRow = Product::getAttributesById($sellerProductRow['selprod_product_id'], array('product_type'));

        $srch = new SellerProductDurationDiscountSearch();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('produr_selprod_id', '=', $selprod_id);
        $rs = $srch->getResultSet();
		$arrListing = FatApp::getDb()->fetchAll($rs);
		//echo "<pre>"; print_r($arrListing); echo "</pre>"; exit;
		$is_rent = $this->isProductRental($selprod_id);
		
        $this->set('arrListing', $arrListing);
        $this->set('selprod_id', $sellerProductRow['selprod_id']);
        $this->set('product_id', $sellerProductRow['selprod_product_id']);
        $this->set('product_type', $productRow['product_type']);
        $this->set('is_rent', $is_rent);
		$this->set('is_sale', $this->isProductSale($selprod_id));
        $this->set('activeTab', 'DURATION_DISCOUNT');
		$this->_template->render(false, false);
    }
	
	public function sellerProductDurationDiscountForm($selprod_id, $durdiscount_id)
    {
        $selprod_id = FatUtility::int($selprod_id);
        $durdiscount_id = FatUtility::int($durdiscount_id);
        if ($selprod_id <= 0) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }
        $sellerProductRow = SellerProduct::getAttributesById($selprod_id, array( 'selprod_id', 'selprod_user_id', 'selprod_product_id'));
        if ($sellerProductRow['selprod_user_id'] != UserAuthentication::getLoggedUserId() || $selprod_id != $sellerProductRow['selprod_id']) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }

        $frmSellerProductDurationDiscount = $this->getSellerProductDurationDiscountForm($this->siteLangId);
        $durationDiscountRow = array();
        if ($durdiscount_id) {
            $durationDiscountRow = SellerProductDurationDiscount::getAttributesById($durdiscount_id);
            if (!$durationDiscountRow) {
                FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
            }
        }
        $durationDiscountRow['produr_selprod_id'] = $sellerProductRow['selprod_id'];
        $frmSellerProductDurationDiscount->fill($durationDiscountRow);
		$is_rent = $this->isProductRental($selprod_id);
		
        $this->set('frmSellerProductDurationDiscount', $frmSellerProductDurationDiscount);
        $this->set('selprod_id', $sellerProductRow['selprod_id']);
        $this->set('product_id', $sellerProductRow['selprod_product_id']);
        $this->set('activeTab', 'DURATION_DISCOUNT');
		$this->set('is_rent', $is_rent);
		$this->set('is_sale', $this->isProductSale($selprod_id));
        $this->_template->render(false, false);
    }
	
	public function setUpSellerProductDurationDiscount()
    {
        $selprod_id = FatApp::getPostedData('produr_selprod_id', FatUtility::VAR_INT, 0);
        if (!$selprod_id) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $produr_id = FatApp::getPostedData('produr_id', FatUtility::VAR_INT, 0);

        $frm = $this->getSellerProductDurationDiscountForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()), $this->siteLangId);
            FatUtility::dieWithError(Message::getHtml());
        }

        $this->updateSelProdDurationDiscount($selprod_id, $produr_id, $post['produr_rental_duration'], $post['produr_discount_percent']);

        $this->set('msg', Labels::getLabel('LBL_Duration_Discount_Setup_Successful', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
	
	public function deleteSellerProductDurationDiscount()
    {
        $post = FatApp::getPostedData();
        $produr_id = FatApp::getPostedData('produr_id', FatUtility::VAR_INT, 0);
        
        $discountRow = SellerProductDurationDiscount::getAttributesById($produr_id);
        $sellerProductRow = SellerProduct::getAttributesById($discountRow['produr_selprod_id'], array('selprod_user_id'), false);
        if (!$discountRow || !$sellerProductRow || $sellerProductRow['selprod_user_id'] != UserAuthentication::getLoggedUserId()) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
            FatApp::redirectUser($_SESSION['referer_page_url']);
        }

		$db = FatApp::getDb();
        if (!$db->deleteRecords(SellerProductDurationDiscount::DB_TBL, array( 'smt' => 'produr_id = ? AND produr_selprod_id = ?', 'vals' => array($produr_id, $discountRow['produr_selprod_id']) ))) {
            Message::addErrorMessage(Labels::getLabel("LBL_".$db->getError(), $this->siteLangId));
            FatApp::redirectUser($_SESSION['referer_page_url']);
        }

        $this->set('selprod_id', $discountRow['produr_selprod_id']);
        $this->set('msg', Labels::getLabel('LBL_Duration_Discount_Record_Deleted', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
	
	
	public function productRentalUnavailableDates($selprod_id)
    {
        $selprod_id = FatUtility::int($selprod_id);
        $sellerProductRow = SellerProduct::getAttributesById($selprod_id, array('selprod_user_id', 'selprod_id', 'selprod_product_id' ));

        if ($sellerProductRow['selprod_user_id'] != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }

        $productRow = Product::getAttributesById($sellerProductRow['selprod_product_id'], array('product_type'));

        $srch = new SellerRentalProductUnavailableDateSearch();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('pu_selprod_id', '=', $selprod_id);
        $rs = $srch->getResultSet();
		$arrListing = FatApp::getDb()->fetchAll($rs);
		//echo "<pre>"; print_r($arrListing); echo "</pre>"; exit;
		$is_rent = $this->isProductRental($selprod_id);
		
        $this->set('arrListing', $arrListing);
        $this->set('selprod_id', $sellerProductRow['selprod_id']);
        $this->set('product_id', $sellerProductRow['selprod_product_id']);
        $this->set('product_type', $productRow['product_type']);
        $this->set('is_rent', $is_rent);
		$this->set('is_sale', $this->isProductSale($selprod_id));
        $this->set('activeTab', 'DURATION_UNAVAILABLE');
		$this->_template->render(false, false);
    }
	
	public function productRentalUnavailableDatesForm($selprod_id, $pu_id)
    {
        $selprod_id = FatUtility::int($selprod_id);
        $pu_id = FatUtility::int($pu_id);
        if ($selprod_id <= 0) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }
        $sellerProductRow = SellerProduct::getAttributesById($selprod_id, array( 'selprod_id', 'selprod_user_id', 'selprod_product_id'));
        if ($sellerProductRow['selprod_user_id'] != UserAuthentication::getLoggedUserId() || $selprod_id != $sellerProductRow['selprod_id']) {
            FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Access', $this->siteLangId));
        }

        $unavailableDatesForm = $this->getRentalProductUnavailableDatesForm($this->siteLangId);
        $datesData = array();
        if ($pu_id) {
            $datesData = SellerRentalProductUnavailableDate::getAttributesById($pu_id);
            if (!$datesData) {
                FatUtility::dieWithError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
            }
        }
        $datesData['pu_selprod_id'] = $sellerProductRow['selprod_id'];
        $unavailableDatesForm->fill($datesData);
		$is_rent = $this->isProductRental($selprod_id);
		
        $this->set('unavailableDatesForm', $unavailableDatesForm);
        $this->set('selprod_id', $sellerProductRow['selprod_id']);
        $this->set('product_id', $sellerProductRow['selprod_product_id']);
        $this->set('activeTab', 'DURATION_DISCOUNT');
		$this->set('is_rent', $is_rent);
		$this->set('is_sale', $this->isProductSale($selprod_id));
        $this->_template->render(false, false);
    }
	
	public function setUpRentalUnavailableDates()
    {
        $selprod_id = FatApp::getPostedData('pu_selprod_id', FatUtility::VAR_INT, 0);
        if (!$selprod_id) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
            FatUtility::dieWithError(Message::getHtml());
        }
        $pu_id = FatApp::getPostedData('pu_id', FatUtility::VAR_INT, 0);
        $frm = $this->getRentalProductUnavailableDatesForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
		
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()), $this->siteLangId);
            FatUtility::dieWithError(Message::getHtml());
        }

		$record = new SellerRentalProductUnavailableDate($pu_id);
		$record->assignValues($post);
        if (!$record->save()) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
		
		$this->set('msg', Labels::getLabel('LBL_Unavailable_Dates_Updated_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
	
	public function deleteRentalUnavailableDates()
    {
        $post = FatApp::getPostedData();
        $pu_id = FatApp::getPostedData('pu_id', FatUtility::VAR_INT, 0);
        $datesRow = SellerRentalProductUnavailableDate::getAttributesById($pu_id);
        $sellerProductRow = SellerProduct::getAttributesById($datesRow['pu_selprod_id'], array('selprod_user_id'), false);
        if (!$datesRow || !$sellerProductRow || $sellerProductRow['selprod_user_id'] != UserAuthentication::getLoggedUserId()) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
            FatApp::redirectUser($_SESSION['referer_page_url']);
        }

		$db = FatApp::getDb();
        if (!$db->deleteRecords(SellerRentalProductUnavailableDate::DB_TBL, array('smt' => 'pu_id = ? AND pu_selprod_id = ?', 'vals' => array($pu_id, $datesRow['pu_selprod_id'])))) {
            Message::addErrorMessage(Labels::getLabel("LBL_".$db->getError(), $this->siteLangId));
            FatApp::redirectUser($_SESSION['referer_page_url']);
        }

        $this->set('selprod_id', $datesRow['pu_selprod_id']);
        $this->set('msg', Labels::getLabel('LBL_Unavailable_Dates_Deleted', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
	
	private function getProductRentalForm($selprod_id = 0)
    {
		$langid = $this->siteLangId;
		$rentalTypeArr = applicationConstants::rentalTypeArr($langid);
		$frm = new Form('frmProductRentalDetails');
        $frm->addHiddenField('', 'sprodata_id', '');
        $frm->addHiddenField('', 'sprodata_selprod_id', $selprod_id);
		
        $sprod_rental_is_pickup = $frm->addCheckBox(Labels::getLabel('LBL_Is_Self_Pickup', $langid), 'sprodata_rental_is_pickup', 1, array(), false, 0);
		
		$sprod_rental_price = $frm->addFloatField(Labels::getLabel('LBL_Rental_Price', $langid).' ['.CommonHelper::getCurrencySymbol(true).']', 'sprodata_rental_price');
		
		$sprod_rental_security = $frm->addFloatField(Labels::getLabel('LBL_Rental_Security', $langid).' ['.CommonHelper::getCurrencySymbol(true).']', 'sprodata_rental_security');
		
		$sprod_rental_type = $frm->addSelectBox(Labels::getLabel('LBL_Rental_Type', $langid), 'sprodata_rental_type', $rentalTypeArr, '', array())->requirements()->setRequired();
		
		$sprod_rental_stock = $frm->addIntegerField(Labels::getLabel('LBL_Rental_Quantity', $langid), 'sprodata_rental_stock');
		
		$sprod_rental_buffer_days = $frm->addIntegerField(Labels::getLabel('LBL_Rental_Buffer_Days', $langid), 'sprodata_rental_buffer_days');
		
		$sprod_minimum_rental_duration = $frm->addIntegerField(Labels::getLabel('LBL_Minimum_Rental_Duration', $langid), 'sprodata_minimum_rental_duration');
		
		$frm->addTextarea(Labels::getLabel("LBL_Rental_Terms", $langid), 'sprodata_rental_terms');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel("LBL_Save_Changes", $langid));
        return $frm; 
    }
	
	private function getSellerProductDurationDiscountForm($langId)
    {
        $frm = new Form('frmSellerProductDurationDiscount');
        $frm->addHiddenField('', 'produr_selprod_id', 0);
        $frm->addHiddenField('', 'produr_id', 0);
        $qtyFld = $frm->addIntegerField(Labels::getLabel("LBL_Minimum_Duration_(_Hours_/_Days_)", $langId), 'produr_rental_duration');
        $qtyFld->requirements()->setPositive();
        $discountFld = $frm->addFloatField(Labels::getLabel("LBL_Discount_in_(%)", $this->siteLangId), "produr_discount_percent");
        $discountFld->requirements()->setPositive();
        $discountFld->requirements()->setRange(1, 100);
        $fld1 = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        $fld2 = $frm->addButton('', 'btn_cancel', Labels::getLabel('LBL_Cancel', $langId), array('onClick' => 'javascript:$("#sellerProductsForm").html(\'\')'));
        $fld1->attachField($fld2);
        return $frm;
    }
	
	private function updateSelProdDurationDiscount($selprod_id, $produr_id, $produr_rental_duration, $perc)
    {
        $sellerProductRow = SellerProduct::getAttributesById($selprod_id, array('selprod_user_id', 'selprod_stock', 'selprod_min_order_qty'), false);
		
		if ($sellerProductRow['selprod_user_id'] != UserAuthentication::getLoggedUserId()) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }
		
		$srch = ProductRental::getSearchObject();
		$srch->addCondition('sprodata_selprod_id', '=', $selprod_id);
		$rs = $srch->getResultSet();
		$prodRentalData = FatApp::getDb()->fetch($rs);
		if (empty($prodRentalData)) {
			FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
		}

		if ($produr_rental_duration < $prodRentalData['sprodata_minimum_rental_duration']) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Duration_cannot_be_less_than_the_Minimum_Rent_Duration', $this->siteLangId). ': '.$prodRentalData['sprodata_minimum_rental_duration']);
        }

        if ($perc > 100 || 1 > $perc) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Percentage', $this->siteLangId));
        }

        /* Check if duration discount for same quantity already exists [ */
        $tblRecord = new TableRecord(SellerProductDurationDiscount::DB_TBL);
        if ($tblRecord->loadFromDb(array('smt' => 'produr_selprod_id = ? AND produr_rental_duration = ?', 'vals' => array($selprod_id, $produr_rental_duration)))) {
            $durDiscountRow = $tblRecord->getFlds();
            if ($durDiscountRow['produr_id'] != $produr_id) {
                FatUtility::dieJsonError(Labels::getLabel('MSG_Duration_discount_for_this_duration_already_added', $this->siteLangId));
            }
        }
        /* ] */
        $data_to_save = array(
			'produr_selprod_id' => $selprod_id,
			'produr_rental_duration' => $produr_rental_duration,
			'produr_discount_percent' => $perc
        );
		
		$record = new SellerProductDurationDiscount($produr_id);
		$record->assignValues($data_to_save);
        if (!$record->save()) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        } else {
			return true;
		}	
    }
	
	private function getRentalProductUnavailableDatesForm($langId)
    {
        $frm = new Form('frmSellerProductRentalUnavailablDates');
        $frm->addHiddenField('', 'pu_selprod_id', 0);
        $frm->addHiddenField('', 'pu_id', 0);
		
		$startDateFld = $frm->addDateField(Labels::getLabel('LBL_Start_Date', $this->siteLangId), 'pu_start_date', '', array('readonly' => 'readonly', 'class' => 'start_date_js'));
		$startDateFld->requirements()->setRequired();
		
		$endDateFld = $frm->addDateField(Labels::getLabel('LBL_End_Date', $this->siteLangId), 'pu_end_date', '', array('readonly' => 'readonly', 'class' => 'end_date_js'));
		$endDateFld->requirements()->setRequired();
		
		$endDateFld->requirements()->setRequired();
        $endDateFld->requirements()->setCompareWith('pu_start_date', 'ge', '');
		
		$qtyFld = $frm->addIntegerField(Labels::getLabel("LBL_Unavailable_Quantity", $langId), 'pu_quantity');
        $qtyFld->requirements()->setPositive();
        
        $fld1 = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        $fld2 = $frm->addButton('', 'btn_cancel', Labels::getLabel('LBL_Cancel', $langId), array('onClick' => 'javascript:$("#sellerProductsForm").html(\'\')'));
        $fld1->attachField($fld2);
        return $frm;
    }
	
	/* ] */
}