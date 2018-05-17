<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmOptions->setFormTagAttribute('class', 'web_form form_horizontal');
$frmOptions->setFormTagAttribute('onsubmit', 'submitOptionForm(this); return(false);');
?>
<div class="col-sm-12">
	<h1>Options Setup</h1>
	<div class="tabs_nav_container responsive flat">		
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php echo $frmOptions->getFormHtml(); ?>
			</div>
		</div>
	</div>
</div>
<div class="col-sm-12">
	<section class="section">                        
			<div class="sectionbody">
					<?php 						
						$arr_flds = array(
							'listserial'=>'Sr no.',
							'optionvalue_identifier'=>'Option Value Identifier',										
							'language_variables'=>$languages,										
							'action'=>'Action',										
						);						
						
						$tbl = new HtmlElement('table',array('width'=>'100%',
						'class'=>'table table-bordered'));
						$th = $tbl->appendElement('thead')->appendElement('tr');
						
						foreach ($arr_flds as $key=>$val) {
							if($key=='language_variables'){
								foreach ($val as $v) {
									$e = $th->appendElement('th', array(), $v);
								}
							}else{
								$e = $th->appendElement('th', array(), $val);
							}
						}
						
						$sr_no = 0;
						
						foreach ($arr_listing as $sn=>$row){ 
							$sr_no++;
							$tr = $tbl->appendElement('tr');
							
							foreach ($arr_flds as $key=>$val){
								$td = $tr->appendElement('td');
								
								switch ($key){
									case 'listserial':
										$td->appendElement('plaintext', array(), $sr_no);
									break;
									
									case 'language_variables':										
										$td->appendElement('plaintext', array(), '');
									break;
									
									default:
										if(!isset($row[$key])){ break;}
										$td->appendElement('plaintext', array(), $row[$key], true);
									break;
								}
							}
						}						
						echo $tbl->getHtml();
					?>					
			 </div>
		</section>
</div>
