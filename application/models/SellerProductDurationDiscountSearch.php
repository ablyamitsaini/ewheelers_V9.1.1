<?php
class SellerProductDurationDiscountSearch extends SearchBase
{
    public function __construct($langId = 0)
    {
        parent::__construct(SellerProductDurationDiscount::DB_TBL, 'dd');
    }

    public static function getSearchObject($durDiscountId = '', $selprod_id = '', $userId = '', $attr = '')
    {
        $srch = new SearchBase(SellerProductDurationDiscount::DB_TBL, 'dd');
        if (!empty($attr)) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } else {
                $srch->addfld($attr);
            }
        }
        if (!empty($durDiscountId) && 0 < $durDiscountId) {
            $srch->addCondition('produr_id', '=', $durDiscountId);
            $srch->setPageSize(1);
        }
        if (!empty($selprod_id) && 0 < $selprod_id) {
            $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'sp.selprod_id = dd.produr_selprod_id', 'sp');
            $srch->addCondition('produr_selprod_id', '=', $selprod_id);
        }

        if (!empty($userId) && 0 < $userId) {
            $srch->addCondition('selprod_user_id', '=', $userId);
        }
        return $srch;
    }
}
