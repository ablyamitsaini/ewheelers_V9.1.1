<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$variables = array('siteLangId'=>$siteLangId,'action'=>$action);
$this->includeTemplate('import-export/_partial/top-navigation.php',$variables,false); ?>
<div class="tabs__content">
	<div class="form__content">
        <div class="row">
			<div class="col-md-12" id="exportFormBlock">
				<?php
					if( !empty($pageData) ){
						?>
						<h2><?php echo $pageData['epage_label'];?></h2>
						<?php
						echo FatUtility::decodeHtmlEntities( nl2br($pageData['epage_content']) );
					}else{
						echo 'Sorry!! No Instructions.';
					}
				?>
			</div>
        </div>
	</div>
</div>
