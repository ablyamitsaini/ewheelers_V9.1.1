<?php
class TestDriveReportController extends AdminBaseController
{
    private $canView;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewTestDriveReport($this->admin_id, true);
        $this->set("canView", $this->canView);
    }

    public function index()
    {
        $this->objPrivilege->canViewTestDriveReport();
		$srchFrm = $this->getReportSearchForm();
        $this->set("frmSearch", $srchFrm);
        $this->_template->render();
    }
	
	public function search($export='')
	{
		$srchFrm = $this->getReportSearchForm();
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);

		$pagesize = FatApp::getConfig('CONF_PAGE_SIZE');
		
		$srch = TestDrive::getSearchObject();
		$srch->joinTable(Transactions::DB_TBL, 'LEFT JOIN', 'txn.utxn_test_drive_id = ptdr_id', 'txn');
		
		$date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('td.ptdr_request_added_on', '>=', $date_from. ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('td.ptdr_request_added_on', '<=', $date_to. ' 23:59:59');
        }
		
		$srch->addMultipleFields(array('u.user_name as buyername','seller.user_name as sellername','IFNULL(product_name, product_identifier) as product_name','ptdr_id','ptdr_date','ptdr_request_added_on','ptdr_status','utxn_id'));
		
		
		if ($export == "export") {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();
            $arr = array( Labels::getLabel('LBL_Date', $this->adminLangId), Labels::getLabel('LBL_Test_Drive_Number', $this->adminLangId), Labels::getLabel('LBL_Product', $this->adminLangId), Labels::getLabel('LBL_Dealer', $this->adminLangId), Labels::getLabel('LBL_Buyer', $this->adminLangId), Labels::getLabel('LBL_Requested_On', $this->adminLangId),Labels::getLabel('LBL_Status', $this->adminLangId),Labels::getLabel('LBL_Payment_Status', $this->adminLangId));
            array_push($sheetData, $arr);
            while ($row = FatApp::getDb()->fetch($rs)) {
				
				if(!empty($row['utxn_id'])){
					$utxn_status = Labels::getLabel('LBL_Settled', $this->adminLangId); 
				}else{ 
					$utxn_status = 'N/A'; 
				}
				
				$date = FatDate::format($row['ptdr_request_added_on'],true);
				$requestedOn = FatDate::format($row['ptdr_date'],true);
				$testDriveStatusArr = TestDrive::getStatusArr($this->adminLangId);
				$status = $testDriveStatusArr[$row['ptdr_status']];
				
                $arr = array( $date, $row['ptdr_id'], $row['product_name'], $row['sellername'], $row['buyername'] ,$requestedOn,$status,$utxn_status);
                array_push($sheetData, $arr);
            }
            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Test_Drive_Report', $this->adminLangId).date("Y-m-d").'.csv', ',');
            exit;
        } else {
			$srch->setPageNumber($page);
			$srch->setPageSize($pagesize);
			$db = FatApp::getDb();
			$rs = $srch->getResultSet();
			$arr_listing = $db->fetchAll($rs);
			$this->set("arr_listing", $arr_listing);
			$this->set('recordCount', $srch->recordCount());
			$this->set('pageCount', $srch->pages());
			$this->set('page', $page);
			$this->set('pageSize', $pagesize);
			$this->set('postedData', $post);
			$this->set('adminLangId', $this->adminLangId);
	
			unset($post['page']);
			$srchFrm->fill($post);
			$this->set("frmTestDriveReport", $srchFrm);
			$this->_template->render(false, false);
        }
	}
	
	public function export(){
		$this->search("export");
	}

	private function getReportSearchForm()
    {
        $frm = new Form('frmTestDriveReportSrch');
        $frm->addHiddenField('', 'page');
        $frm->addDateField('', 'date_from', '', array('placeholder' => Labels::getLabel('LBL_Date_From', $this->adminLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender' ));
        $frm->addDateField('', 'date_to', '', array('placeholder' => Labels::getLabel('LBL_Date_To', $this->adminLangId), 'readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_clear = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear', $this->adminLangId), array('onclick'=>'clearSearch();'));
		$fld_submit->attachField($fld_clear);
        return $frm;
    }

    
}
