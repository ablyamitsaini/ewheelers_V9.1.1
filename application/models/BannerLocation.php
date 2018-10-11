<?php
class BannerLocation extends MyAppModel {
	const DB_TBL = 'tbl_banner_locations';
	const DB_TBL_PREFIX = 'blocation_';
	
	const DB_LANG_TBL = 'tbl_banner_locations_lang';
	
	const DB_DIMENSIONS_TBL = 'tbl_banner_location_dimensions';
	const DB_DIMENSIONS_TBL_PREFIX = 'bldimensions_';
	
	const HOME_PAGE_AFTER_FIRST_LAYOUT = 1;	
	const HOME_PAGE_AFTER_THIRD_LAYOUT = 2;	
	const PRODUCT_DETAIL_PAGE_BANNER = 3;
	
	public function __construct($id = 0) {
		parent::__construct ( static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id );
	}
	
	public static function getSearchObject( $langId = 0, $isActive = true  ) {
		$srch = new SearchBase(static::DB_TBL, 'bl');

		if ( $langId > 0 ) {
			$srch->joinTable( static::DB_LANG_TBL, 'LEFT OUTER JOIN',
			'blocationlang_blocation_id = blocation_id
			AND blocationlang_lang_id = ' . $langId,'bl_l');
		}
		
		if( $isActive ){
			$srch->addCondition('blocation_active', '=', applicationConstants::ACTIVE );
		}
		return $srch;
	}
	
	public static function getBannerLocationCost($locationId = 0){
		$locationId = FatUtility::int($locationId);
		$srch = static::getBannerLocationSrchObj();
		$srch->addCondition('blocation_id','=',$locationId);
		$srch->addMultipleField(array('blocation_promotion_cost'));
		$rs = $srch->getResultSet();
		$row = FatApp::getDb()->fetch($rs);
		if(empty($row)) { return 0;}
		return $row['blocation_promotion_cost'];
	}

}