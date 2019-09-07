<?php
class Labels extends MyAppModel
{
    const DB_TBL = 'tbl_language_labels';
    const DB_TBL_PREFIX = 'label_';
    const JSON_FILE_DIR_NAME = 'language-labels';

    public function __construct($labelId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $labelId);
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function getSearchObject($langId = 0, $attr = '')
    {
        $langId =  FatUtility::int($langId);

        $srch = new SearchBase(static::DB_TBL, 'lbl');
        $srch->addOrder('lbl.' . static::DB_TBL_PREFIX . 'id', 'DESC');

        $columns = array(
            'lbl.' . static::DB_TBL_PREFIX . 'id',
            'lbl.' . static::DB_TBL_PREFIX . 'lang_id',
            'lbl.' . static::DB_TBL_PREFIX . 'key',
            'lbl.' . static::DB_TBL_PREFIX . 'caption',
        );

        $attr = (!empty($attr) && is_array($attr)) ? $attr : $columns;

        $srch->addMultipleFields($attr);

        if ($langId > 0) {
            $srch->addCondition('lbl.' . static::DB_TBL_PREFIX . 'lang_id', '=', $langId);
        }
        return $srch;
    }

    public static function getLabel($lblKey, $langId)
    {
        if (empty($lblKey)) {
            return;
        }

        if (preg_match('/\s/', $lblKey)) {
            return $lblKey;
        }

        $langId = FatUtility::int($langId);
        if ($langId == 0) {
            return;
        }

        $cacheAvailable = static::isAPCUcacheAvailable();
        if ($cacheAvailable) {
            $cacheKey = static::getAPCUcacheKey($lblKey, $langId);
            if (apcu_exists($cacheKey)) {
                return strip_tags(trim(apcu_fetch($cacheKey)));
            }
        }

        global $lang_array;

        if (isset($lang_array[$lblKey][$langId])) {
            if (!empty($lang_array[$lblKey][$langId])) {
                return strip_tags($lang_array[$lblKey][$langId]);
            }

            $arr = explode(' ', ucwords(str_replace('_', ' ', strtolower($lblKey))));
            array_shift($arr);
            return $lang_array[$lblKey][$langId] = strip_tags(implode(' ', $arr));
        }

        $key_original = $lblKey;
        $key = strtoupper($lblKey);

        $str = '';
        global $langFileData;
        if (!isset($langFileData[$langId])) {
            $langFileData[$langId] = static::readDataFromFile($langId, $key);
        }

        if (isset($langFileData[$langId]) && array_key_exists($key, $langFileData[$langId])) {
            $str = $langFileData[$langId][$key];
        }

        if (empty($str)) {
            $db = FatApp::getDb();

            $srch = static::getSearchObject($langId);
            $srch->addCondition(static::DB_TBL_PREFIX . 'key', '=', $key);
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();

            if ($lbl = $db->fetch($srch->getResultSet())) {
                if (isset($lbl[static::DB_TBL_PREFIX . 'caption']) && $lbl[static::DB_TBL_PREFIX . 'caption']!='') {
                    $str = $lbl[static::DB_TBL_PREFIX . 'caption'];
                } else {
                    $arr = explode(' ', ucwords(str_replace('_', ' ', strtolower($lblKey))));
                    array_shift($arr);
                    $str = implode(' ', $arr);
                }
            } else {
                $arr = explode(' ', ucwords(str_replace('_', ' ', strtolower($key_original))));
                array_shift($arr);

                $str = implode(' ', $arr);
                $assignValues = array(
                    static::DB_TBL_PREFIX . 'key' => $lblKey,
                    static::DB_TBL_PREFIX . 'caption' => $str,
                    static::DB_TBL_PREFIX . 'lang_id' => $langId
                );

                FatApp::getDB()->insertFromArray(static::DB_TBL, $assignValues, false, array(), $assignValues);

                $labelsUpdatedAt = array('conf_name'=>'CONF_LANG_LABELS_UPDATED_AT','conf_val'=>time());
                FatApp::getDb()->insertFromArray('tbl_configurations', $labelsUpdatedAt, false, array(), $labelsUpdatedAt);
            }
        }

        if ($cacheAvailable) {
            apcu_store($cacheKey, $str);
            return strip_tags($str);
        }

        global $lang_array;
        $lang_array[$lblKey][$langId] = $str;
        return strip_tags($str);
    }

    public static function readDataFromFile($langId, $key, $returnArr = true)
    {
        global $languages;
        if (!isset($languages[$langId])) {
            $languages[$langId] = Language::getAttributesById($langId, 'language_code', false);
        }

        $jsonfile = CONF_UPLOADS_PATH.static::JSON_FILE_DIR_NAME.'/'.$languages[$langId].'.json';
        if (!file_exists($jsonfile)) {
            Labels::updateDataToFile($langId, $languages[$langId]);
        }

        if ($returnArr === true) {
            return json_decode(file_get_contents($jsonfile), true);
        }
        return file_get_contents($jsonfile);
    }

    public function addUpdateData($data = array())
    {
        $assignValues = array(
            static::DB_TBL_PREFIX . 'key' => $data['label_key'],
            static::DB_TBL_PREFIX . 'caption' => $data['label_caption'],
            static::DB_TBL_PREFIX . 'lang_id' => $data['label_lang_id']
        );

        if (!FatApp::getDB()->insertFromArray(static::DB_TBL, $assignValues, false, array(), $assignValues)) {
            return false;
        }

        $labelsUpdatedAt = array('conf_name'=>'CONF_LANG_LABELS_UPDATED_AT','conf_val'=>time());
        FatApp::getDb()->insertFromArray('tbl_configurations', $labelsUpdatedAt, false, array(), $labelsUpdatedAt);

        $cacheAvailable = static::isAPCUcacheAvailable();
        if ($cacheAvailable) {
            $cacheKey = static::getAPCUcacheKey($data['label_key'], $data['label_lang_id']);
            apcu_store($cacheKey, $data['label_caption']);
        }

        return true;
    }

    public static function isAPCUcacheAvailable()
    {
        return $cacheAvailable = (extension_loaded('apcu') && ini_get('apcu.enabled')) ;
    }

    public static function getAPCUcacheKey($key, $langId)
    {
        return $cacheKey = $_SERVER['SERVER_NAME'] . '_' . $key . '_' . $langId;
    }

    public static function updateDataToFile($langId, $langCode = '')
    {
        if (empty($langCode)) {
            $langCode = Language::getAttributesById($langId, 'language_code', false);
        }

        $lastLabelsUpdatedAt = FatApp::getConfig('CONF_LANG_LABELS_UPDATED_AT', FatUtility::VAR_INT, time());

        $path = CONF_UPLOADS_PATH.static::JSON_FILE_DIR_NAME.'/';
        if (!file_exists($path)) {
            if (!mkdir($path, 0777, true)) {
                return false;
            }
        }

        $langFile = $path . $langCode.'.json';
        if (!file_exists($langFile) || (filemtime($langFile) < $lastLabelsUpdatedAt) || 1 > filesize($langFile)) {
            $records = static::fetchAllAssoc($langId, array('label_key','label_caption'));
            return file_put_contents($langFile, json_encode($records));
        }
        return true;
    }


    public static function fetchAllAssoc($langId, $attr = '')
    {
        $srch = static::getSearchObject($langId, $attr);
        $srch->joinTable('tbl_languages', 'inner join', 'label_lang_id = language_id and language_active = ' .applicationConstants::ACTIVE);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetchAllAssoc($rs);
    }
}
