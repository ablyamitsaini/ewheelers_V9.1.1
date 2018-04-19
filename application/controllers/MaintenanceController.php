<?php
class MaintenanceController extends MyAppController{
	function index(){
		$this->set('maintenanceText', FatApp::getConfig("CONF_MAINTENANCE_TEXT_".$this->siteLangId, FatUtility::VAR_STRING ,''));
		$this->_template->render();	
	}
}
