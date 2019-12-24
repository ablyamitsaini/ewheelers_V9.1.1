<?php
class SellerProductDurationDiscount extends MyAppModel
{
    const DB_TBL = 'tbl_product_duration_discount';
    const DB_TBL_PREFIX = 'produr_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function updateData($data, $return = false)
    {
        $db = FatApp::getDb();
        if (!$db->insertFromArray(static::DB_TBL, $data, false, array(), $data))
		{
            return false;
        }
        if (true === $return)
		{
            if (!empty($data['produr_id']))
			{
                return $data['produr_id'];
            }
            return $db->getInsertId();
        }
        return true;
    }
}