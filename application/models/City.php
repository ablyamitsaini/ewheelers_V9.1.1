<?php
class City extends MyAppModel
{
    const DB_TBL = 'tbl_cities';
    const DB_TBL_PREFIX = 'city_';

    const DB_TBL_LANG = 'tbl_cities_lang';
    const DB_TBL_LANG_PREFIX = 'citylang_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($isActive = true, $langId = 0)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 'ct');

        if ($isActive==true) {
            $srch->addCondition('ct.'.static::DB_TBL_PREFIX.'active', '=', applicationConstants::ACTIVE);
        }

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'ct_l.'.static::DB_TBL_LANG_PREFIX.'city_id = ct.'.static::tblFld('id').' and
            ct_l.'.static::DB_TBL_LANG_PREFIX.'lang_id = '.$langId,
                'ct_l'
            );
        }
        return $srch;
    }

    public static function requiredFields()
    {
        return array(
            ImportexportCommon::VALIDATE_POSITIVE_INT => array(
                'city_id',
                'city_state_id',
                'city_country_id',
            ),
            ImportexportCommon::VALIDATE_NOT_NULL => array(
                'city_identifier',
                'state_code',
                'country_code',
                'city_name'
            ),
        );
    }

    public static function validateFields($columnIndex, $columnTitle, $columnValue, $langId)
    {
        $requiredFields = static::requiredFields();
        return ImportexportCommon::validateFields($requiredFields, $columnIndex, $columnTitle, $columnValue, $langId);
    }

    public static function getAttributesByIdentifierStateAndCountry($identifier, $countryId, $stateId, $attr = array())
    {
        $identifier = FatUtility::convertToType($identifier, FatUtility::VAR_STRING);
        $db = FatApp::getDb();

        $srch = new SearchBase(static::DB_TBL);
        $srch->addCondition(static::tblFld('identifier'), '=', $identifier);
        $srch->addCondition(static::tblFld('country_id'), '=', $countryId);
        $srch->addCondition(static::tblFld('state_id'), '=', $stateId);

        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);

        if (!is_array($row)) {
            return false;
        }

        if (is_string($attr)) {
            return $row[$attr];
        }

        return $row;
    }

    public static function getCitiesByCountryAndState($countryId, $stateId, $langId = 0)
    {
        $db = FatApp::getDb();
        $langId = FatUtility::int($langId);
        $countryId = FatUtility::int($countryId);
        $stateId = FatUtility::int($stateId);
        $srch = self::getSearchObject(true, $langId);
        $srch->addCondition('city_country_id', '=', $countryId);
        $srch->addCondition('city_state_id', '=', $stateId);
        $srch->addOrder('city_name', 'ASC');
        $srch->addMultipleFields(
            array(
                'city_id',
                'IFNULL(city_name, city_identifier) as city_name'
                )
        );

        $rs = $srch->getResultSet();
        $cities = $db->fetchAllAssoc($rs);
        $cities['-1'] = Labels::getLabel('LBL_Other', $langId);
        if (!is_array($cities)) {
            return false;
        }

        return $cities;
    }
}
