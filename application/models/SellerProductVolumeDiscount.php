<?php
class SellerProductVolumeDiscount extends MyAppModel{
	const DB_TBL = 'tbl_product_volume_discount';
	const DB_TBL_PREFIX = 'voldiscount_';
	
	public function __construct( $id = 0 ) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id );
	}
}