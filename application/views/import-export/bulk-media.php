<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class','form ');

$frm->developerTags['colClassPrefix'] = 'col-lg-4 col-md-';
$frm->developerTags['fld_default_col'] = 4;
$frm->setFormTagAttribute( 'onSubmit', 'uploadZip(); return false;' );

$variables = array('siteLangId'=>$siteLangId,'action'=>$action);
$this->includeTemplate('import-export/_partial/top-navigation.php',$variables,false); ?>
<div class="tabs__content">
	<div class="form__content">
        <div class="row">
			<div class="col-md-12" id="bulkMediaForm">
				<?php echo $frm->getFormHtml();  ?>
			</div>
			<div class="col-md-12 sectionhead">
				<hr>
				<h4><?php echo Labels::getLabel('LBL_Uploaded_Media_Directory_List',$siteLangId); ?></h4>
			</div>
			<div class="col-md-12 sectionbody">
				<div class="tablewrap" >
					<div id="listing"> <?php echo Labels::getLabel('LBL_Processing...',$siteLangId); ?></div>
				</div>
			</div>
        </div>
	</div>
</div>
