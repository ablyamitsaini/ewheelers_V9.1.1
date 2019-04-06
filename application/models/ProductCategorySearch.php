<?php
class ProductCategorySearch extends SearchBase
{
    private $langId;

    function __construct( $langId = 0, $isActive = true, $isDeleted = true, $isOrderByCatCode = true, $doNotLimitRecords = true ) 
    {
        parent::__construct(ProductCategory::DB_TBL, 'c');
        $this->langId = FatUtility::int($langId);

        if ($this->langId > 0) {
            $this->joinTable(
                ProductCategory::DB_LANG_TBL, 'LEFT OUTER JOIN',
                'prodcatlang_prodcat_id = c.prodcat_id
			AND prodcatlang_lang_id = ' . $langId, 'c_l'
            );
        }
        //$this->addMultipleFields( array('GETCATCODE(prodcat_id) AS prodcat_code') );

        if($isActive ) {
            $this->addCondition('c.prodcat_active', '=', applicationConstants::ACTIVE);
        }

        if($isDeleted ) {
            $this->addCondition('c.prodcat_deleted', '=', applicationConstants::NO);
        }

        if($isOrderByCatCode ) {
            $this->addOrder('c.prodcat_ordercode');
        }

        if($doNotLimitRecords ) {
            $this->doNotCalculateRecords();
            $this->doNotLimitRecords();
        }
    }

    public function setParent( $parentId = 0 )
    {
        $this->addCondition('prodcat_parent', '=', $parentId);
    }

    /* public function getSearchObject($includeChildCount = false) {
    $srch = new SearchBase(static::DB_TBL, 'm');
    $srch->addOrder('m.prodcat_active', 'DESC');

    if ($includeChildCount) {
    $srch->joinTable(static::DB_TBL, 'LEFT OUTER JOIN', 's.prodcat_parent = m.prodcat_id', 's');
    $srch->addGroupBy('m.prodcat_id');
    $srch->addFld('COUNT(s.prodcat_id) AS child_count');
    }
    return $srch;
    }

    public function setRecordParent($srch,$parent){
    $srch->addCondition('m.prodcat_parent', '=', FatUtility::int($parent));
    }

    public function setRecordNotDeleted($srch){
    $srch->addCondition('m.prodcat_deleted', '=', 0);
    }

    public function setRecordDisplayOrder($srch,$arr=array()){
    foreach($arr as $k=>$v){
    $srch->addOrder($k,$v);
    }
    }
    */
}
?>
