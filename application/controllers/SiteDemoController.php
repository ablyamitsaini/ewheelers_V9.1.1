<?php
class SiteDemoController extends MyAppController
{
    public function mobile()
    {
        $this->set('width', '375px');
        $this->set('height', '624px');
		$this->_template->render(false, false, 'site-demo/index.php');
    }

    public function tab()
    {
        $this->set('width', '1024px');
        $this->set('height', '768px');
        $this->_template->render(false, false, 'site-demo/index.php');
    }
}
