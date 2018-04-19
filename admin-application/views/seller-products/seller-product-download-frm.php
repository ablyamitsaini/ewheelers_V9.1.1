
<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_Digital_Downloads',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">
		<div class="row">
			<div class="col-sm-12">
				<div class="tabs_nav_container responsive flat">
					<?php require_once('sellerCatalogProductTop.php');?>
					<div class="tabs_panel_wrap ">						
						<?php
						$selprodDownloadFrm->setFormTagAttribute('id', 'frmDownload');
						$selprodDownloadFrm->setFormTagAttribute('class','form form--horizontal');
						$selprodDownloadFrm->developerTags['colClassPrefix'] = 'col-md-';
						$selprodDownloadFrm->developerTags['fld_default_col'] = 6; 
						$img_fld = $selprodDownloadFrm->getField('downloadable_file');
						$img_fld->setFieldTagAttribute( 'onchange','setUpSellerProductDownloads(); return false;');
						echo $selprodDownloadFrm->getFormHtml(); ?>	
						
						<?php 
						$arr_flds = array(
							'listserial'=>Labels::getLabel('LBL_Sr_No.', $adminLangId),
							'afile_name' => Labels::getLabel('LBL_File', $adminLangId),
							'afile_lang_id' => Labels::getLabel('LBL_Language', $adminLangId),
							'action' => Labels::getLabel('LBL_Action', $adminLangId),					
						);
						
						$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table'));
						$th = $tbl->appendElement('thead')->appendElement('tr',array('class' => 'hide--mobile'));
						foreach ($arr_flds as $val) {
							$e = $th->appendElement('th', array(), $val);
						}

						$sr_no = 0;
						foreach ($attachments as $sn => $row){
							$sr_no++;
							$tr = $tbl->appendElement('tr');

							foreach ($arr_flds as $key=>$val){
								$td = $tr->appendElement('td');
								switch ($key){
									case 'listserial':
										$td->appendElement('plaintext', array(), $sr_no,true);
									break;
									case 'afile_lang_id':
										$lang_name = Labels::getLabel('LBL_All',$adminLangId);
										if( $row['afile_lang_id'] > 0 ){
											$lang_name = $languages[$row['afile_lang_id']];
										}
										$td->appendElement('plaintext', array(),  $lang_name, true);
									break;
									case 'action':
										$ul = $td->appendElement("ul",array("class"=>"actions"),'',true);
										
										$li = $ul->appendElement("li");
										$li->appendElement("a", array('title' => Labels::getLabel('LBL_Product_Images', $adminLangId),
										'onclick' => 'deleteDigitalFile('.$row['afile_record_id'].','.$row['afile_id'].')', 'href'=>'javascript:void(0)'),
										Labels::getLabel('LBL_Delete', $adminLangId), true);

									break;
									default:
										$td->appendElement('plaintext', array(), $row[$key],true);
									break;
								}
							}
						}
						if( !empty($attachments) ){					
							echo $tbl->getHtml();				
						}
						?>		
					</div>
					</div>	
					</div>
				</div>
			</div>
		</section>