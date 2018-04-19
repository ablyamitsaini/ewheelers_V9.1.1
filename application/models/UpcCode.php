<?php
class UpcCode extends MyAppModel{
	const DB_TBL = 'tbl_upc_codes';
	const DB_TBL_PREFIX = 'upc_';
	
	private $db;
	
	public function __construct($id = 0) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'code_id', $id );
		$this->db=FatApp::getDb();
	}
	
	public static function getSearchObject() {
		$srch = new SearchBase(static::DB_TBL, 'upc');		
		return $srch;
	}
}