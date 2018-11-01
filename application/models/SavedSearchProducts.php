<?php
class SavedSearchProducts extends MyAppModel{
	const DB_TBL = 'tbl_product_saved_search';
	const DB_TBL_PREFIX = 'pssearch_';	
	
	const PAGE_CATEGORY = 1;
	const PAGE_PRODUCT = 2;
	const PAGE_BRAND = 3;
	const PAGE_SHOP = 4;
	const PAGE_FEATURED_PRODUCT = 5;
	
	public function __construct($id = 0) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id );
		$this->db = FatApp::getDb();
	}
	
	public static function getPageUrl(  ){		
		return array(
			static::PAGE_CATEGORY	=>	'Category/view/',	
			static::PAGE_PRODUCT	=>	'Products/search/',
			static::PAGE_BRAND	=>	'Brands/view/',
			static::PAGE_SHOP	=>	'Shops/view/',
			static::PAGE_FEATURED_PRODUCT	=>	'Products/featured/'
		);
	}
	
	public static function getSearchObject() {
		$srch = new SearchBase(static::DB_TBL, 'sps');		
		return $srch;
	}
		
}	