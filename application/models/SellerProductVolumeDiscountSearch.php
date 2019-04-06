<?php
class SellerProductVolumeDiscountSearch extends SearchBase
{

    public function __construct( $langId = 0 ) 
    {
        parent::__construct(SellerProductVolumeDiscount::DB_TBL, 'vd');
    }
}
