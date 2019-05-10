<?php
class ShippingSettings
{
    const DB_SHIPPING_METHODS_TBL = 'tbl_shipping_apis';
    const DB_SHIPPING_METHODS_TBL_PREFIX = 'shippingapi_';
    const DB_SHIPPING_METHOD_SETTINGS_TBL = 'tbl_shippingapi_settings';
    const DB_SHIPPING_METHOD_SETTINGS_TBL_PREFIX = 'shipsetting_';

    private $db;
    private $error;
    private $shippingMethodKey = null;
    private $commonLangId;

    public function __construct($methodIdentifier = '')
    {
        $this->db = FatApp::getDb();
        $this->shippingMethodKey = $methodIdentifier;
        $this->error = '';
        $this->commonLangId = CommonHelper::getLangId();
    }

    public function getError()
    {
        return $this->error;
    }

    public function saveSettings($arr)
    {
        if (empty($arr)) {
            $this->error = Labels::getLabel('ERR_Error:_Please_provide_data_to_save_settings.', $this->commonLangId);
            return false;
        }

        $shippingMethod = $this->getShippingMethodByCode($this->shippingMethodKey);
        if (!$shippingMethod) {
            $this->error = Labels::getLabel('ERR_Error:_Shipping_method_with_defined_shipping_key_does_not_exist.', $this->commonLangId);
            return false;
        }

        $shippingapi_id = $shippingMethod["shippingapi_id"];

        if (!$this->db->deleteRecords(
            static::DB_SHIPPING_METHOD_SETTINGS_TBL,
            array('smt' => static::DB_SHIPPING_METHOD_SETTINGS_TBL_PREFIX.'shippingapi_id = ?', 'vals' => array($shippingapi_id))
        )) {
            $this->error = $this->db->getError();
            return false;
        }

        foreach ($arr as $key => $val) {
            if ($key == "btn_submit") {
                continue;
            }

            $data = array(
            'shipsetting_shippingapi_id' => $shippingapi_id,
            'shipsetting_key' => $key
            );

            if (!is_array($val)) {
                $data['shipsetting_value'] = $val;
            } else {
                $data['shipsetting_value'] = serialize($val);
            }

            if (!$this->db->insertFromArray(static::DB_SHIPPING_METHOD_SETTINGS_TBL, $data, false, array('IGNORE'))) {
                $this->error = $this->db->getError();
                return false;
            }
        }
        return true    ;
    }

    public function getShippingSettings()
    {
        if (!isset($this->shippingMethodKey)) {
            $this->error = Labels::getLabel('ERR_Error:_Please_create_an_object_with_Shipping_Method_Key.', $this->commonLangId);
            return false;
        }

        $shippingMethod = $this->getShippingMethodByCode($this->shippingMethodKey);
        if (!$shippingMethod) {
            $this->error = Labels::getLabel('ERR_Error:_Shipping_method_with_this_shipping_key_does_not_exist.', $this->commonLangId);
            return false;
        }

        $shippingMethodSettings = $this->getShippingMethodFieldsById($shippingMethod["shippingapi_id"]);
        $shippingSettings = array();

        foreach ($shippingMethodSettings as $pkey => $pval) {
            $shippingSettings[$pval["shipsetting_key"]] = $pval["shipsetting_value"];
        }

        return array_merge($shippingSettings, $shippingMethod);
    }

    public function getShippingMethodByCode($code = '')
    {
        if (empty($code)) {
            return false;
        }
        $srch = new SearchBase(static::DB_SHIPPING_METHODS_TBL, 'tpm');
        $srch->addCondition('tpm.'.static::DB_SHIPPING_METHODS_TBL_PREFIX.'code', '=', $code);
        $rs = $srch->getResultSet();
        $shipping_method = $this->db->fetch($rs);
        return $shipping_method;
    }

    private function getShippingMethodFieldsById($shippingapi_id)
    {
        $srch = new SearchBase(static::DB_SHIPPING_METHOD_SETTINGS_TBL, 'tsms');
        $srch->addCondition('tsms.'.static::DB_SHIPPING_METHOD_SETTINGS_TBL_PREFIX.'shippingapi_id', '=', (int)$shippingapi_id);
        $rs = $srch->getResultSet();
        $shippingMethodSettings = $this->db->fetchAll($rs);
        return $shippingMethodSettings;
    }
}
