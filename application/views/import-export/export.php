<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class','form form--horizontal');

$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12; 	

$variables = array('siteLangId'=>$siteLangId,'action'=>$action);
$this->includeTemplate('import-export/_partial/top-navigation.php',$variables,false); ?>
<div class="tabs__content">                                               
	<div class="form__content">		
        <div class="row">			
			<div class="col-md-8" id="exportFormBlock">				
				<?php echo $frm->getFormHtml();  ?>
			</div>
        </div>
	</div>
</div>