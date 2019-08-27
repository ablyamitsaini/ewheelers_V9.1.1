<?php
class Labels extends MyAppModel
{
    const DB_TBL = 'tbl_language_labels';
    const DB_TBL_PREFIX = 'label_';

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
        } else {
            global $lang_array;

            if (isset($lang_array[$lblKey][$langId])) {
                if ($lang_array[$lblKey][$langId]!='') {
                    return strip_tags($lang_array[$lblKey][$langId]);
                } else {
                    $arr = explode(' ', ucwords(str_replace('_', ' ', strtolower($lblKey))));
                    array_shift($arr);
                    return $str = strip_tags(implode(' ', $arr));
                }
            }
        }

        $key_original = $lblKey;
        $key = strtoupper($lblKey);

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
            $configurationObj = new Configurations();
            $configurationObj->update(array('CONF_LANG_LABELS_UPDATED_AT' => time()));
        }

        if ($cacheAvailable) {
            apcu_store($cacheKey, $str);
        } else {
            global $lang_array;
            $lang_array[$lblKey][$langId] = $str;
        }

        return strip_tags($str);
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

    public static function getAll($langId, $attr = '')
    {
        $srch = static::getSearchObject($langId, $attr);
        $srch->joinTable('tbl_languages', 'inner join', 'label_lang_id = language_id and language_active = ' .applicationConstants::ACTIVE);
        $srch->addOrder('lbl.' . Labels::DB_TBL_PREFIX . 'lang_id', 'ASC');
        $srch->addGroupBy('lbl.' . Labels::DB_TBL_PREFIX . 'key');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetchAll($rs);
    }
}
