<?php
class BannerLocation extends MyAppModel
{
    const DB_TBL = 'tbl_banner_locations';
    const DB_TBL_PREFIX = 'blocation_';

    const DB_LANG_TBL = 'tbl_banner_locations_lang';

    const DB_DIMENSIONS_TBL = 'tbl_banner_location_dimensions';
    const DB_DIMENSIONS_TBL_PREFIX = 'bldimensions_';

    const HOME_PAGE_TOP_BANNER = 1;
    const HOME_PAGE_BOTTOM_BANNER = 2;
    const PRODUCT_DETAIL_PAGE_BANNER = 3;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($langId = 0, $isActive = true, $deviceType = 0)
    {
        $srch = new SearchBase(static::DB_TBL, 'bl');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_LANG_TBL,
                'LEFT OUTER JOIN',
                'blocationlang_blocation_id = blocation_id
			AND blocationlang_lang_id = ' . $langId,
                'bl_l'
            );
        }

        if ($isActive) {
            $srch->addCondition('blocation_active', '=', applicationConstants::ACTIVE);
        }

        $deviceType = FatUtility::int($deviceType);
        if (1 > $deviceType) {
            $deviceType = applicationConstants::SCREEN_DESKTOP;
        }

        $srch->joinTable(BannerLocation::DB_DIMENSIONS_TBL, 'LEFT OUTER JOIN', 'bldim.bldimension_blocation_id = bl.blocation_id AND bldim.bldimension_device_type = ' . $deviceType, 'bldim');

        return $srch;
    }
}
