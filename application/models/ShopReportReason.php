<?php
class ShopReportReason extends MyAppModel
{
    const DB_TBL = 'tbl_report_reasons';
    const DB_TBL_PREFIX = 'reportreason_';    
    
    const DB_TBL_LANG = 'tbl_report_reasons_lang';
    
    public function __construct( $id = 0 ) 
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }
    
    public static function getSearchObject( $langId = 0) 
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 'reportreason');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG, 'LEFT OUTER JOIN',
                'reportreason_l.reportreasonlang_reportreason_id = reportreason.reportreason_id
			AND reportreasonlang_lang_id = ' . $langId, 'reportreason_l'
            );
        }
        return $srch;
    }
    
    static function getReportReasonArr( $langId = 0 )
    {
        $srch = static::getSearchObject($langId);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(array('reportreason_id','IFNULL(reportreason_title, reportreason_identifier) as reportreason_title'));
        $srch->addOrder('reportreason_title');
        $rs = $srch->getResultSet();
        return $row = FatApp::getDb()->fetchAllAssoc($rs);
    }
}
