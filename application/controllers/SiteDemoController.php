<?php
class SiteDemoController extends MyAppController
{
    public function mobile()
    {
        $this->set('width', '375px');
        $this->set('height', '624px');
        $this->set('exculdeMainHeaderDiv', true);
        $this->_template->render(true, false, 'site-demo/index.php');
    }

    public function tab()
    {
        $this->set('width', '1024px');
        $this->set('height', '768px');
        $this->set('exculdeMainHeaderDiv', true);
        $this->_template->render(true, false, 'site-demo/index.php');
    }
}
