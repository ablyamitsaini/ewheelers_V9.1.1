<?php
class SellerRentalProductUnavailableDate extends MyAppModel
{
    const DB_TBL = 'tbl_prod_unavailable_rental_durations';
    const DB_TBL_PREFIX = 'pu_';

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
            if (!empty($data['pu_id']))
			{
                return $data['pu_id'];
            }
            return $db->getInsertId();
        }
        return true;
    }
}