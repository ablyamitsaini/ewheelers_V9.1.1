<?php
class SiteDemoController extends MyAppController
{
    public function __construct($action)
    {
        parent::__construct($action);
        if (!FatApp::getConfig('CONF_AUTO_RESTORE_ON', FatUtility::VAR_INT, 0)) {
            Message::addErrorMessage('Auto restore disabled by admin!');
            CommonHelper::redirectUserReferer();
        }
    }
    public function mobile()
    {
        $this->set('width', '375px');
        $this->set('height', '624px');
        $this->set('deviceClass', 'smartphone');
        $this->set('exculdeMainHeaderDiv', true);
        $this->_template->render(true, false, 'site-demo/index.php');
    }

    public function tab()
    {
        $this->set('width', '768px');
        $this->set('height', '1024px');
        $this->set('deviceClass', 'tablet');
        $this->set('exculdeMainHeaderDiv', true);
        $this->_template->render(true, false, 'site-demo/index.php');
    }
}
