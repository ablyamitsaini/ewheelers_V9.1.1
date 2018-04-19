	<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>

<section class="section">
	<div class="sectionhead">
	   
		<h4><?php echo Labels::getLabel('LBL_Shop_Setup',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">
		<div class=" tabs_nav_container  flat">
				
					<ul class="tabs_nav">
						<li><a href="javascript:void(0)" onclick="shopForm(<?php echo $shop_id ?>);"><?php echo Labels::getLabel('LBL_General',$adminLangId); ?></a></li>
						<?php 
						$inactive=($shop_id==0)?'fat-inactive':'';	
						foreach($languages as $langId=>$langName){?>
							<li class="<?php echo $inactive;?>"><a href="javascript:void(0);" <?php if($shop_id>0){?> onclick="addShopLangForm(<?php echo $shop_id ?>, <?php echo $langId;?>);" <?php }?>><?php echo Labels::getLabel('LBL_'.$langName,$adminLangId);?></a></li>
						<?php } ?>
						<li><a href="javascript:void(0);" <?php if($shop_id>0){?> onclick="shopTemplates(<?php echo $shop_id ?>);" <?php }?>><?php echo Labels::getLabel('LBL_Templates',$adminLangId); ?></a></li>
						<li><a href="javascript:void(0);" <?php if($shop_id>0){?> onclick="shopMediaForm(<?php echo $shop_id ?>);" <?php }?>><?php echo Labels::getLabel('LBL_Media',$adminLangId); ?></a></li>
						
						<li><a class="active" href="javascript:void(0);" <?php if($shop_id>0){?> onclick="shopCollectionProducts(<?php echo $shop_id ?>);" <?php }?>><?php echo Labels::getLabel('LBL_Collection',$adminLangId); ?></a></li>
					</ul>
				
					<div class="tabs_panel_wrap">
						
							
						
									
									<ul class="tabs_nav tabs_nav--internal">
										<li><a class="active" onclick="getShopCollectionGeneralForm(<?php echo $shop_id; ?>);" href="javascript:void(0)"><?php echo Labels::getLabel('TXT_GENERAL', $adminLangId);?></a></li>
										<?php if(isset($scollection_id) && $scollection_id >0){
											$scollection_id=$scollection_id;
										}else{
										$scollection_id='';	
										}
					
										foreach($language as $lang_id => $langName){?>	
										<li><a href="javascript:void(0)" onClick="editShopCollectionLangForm(<?php echo $shop_id;?>, <?php echo $scollection_id ?>, <?php echo $lang_id;?>)">
										<?php echo Labels::getLabel('LBL_'.$langName,$adminLangId);?></a></li>
										<?php } ?>
										
										<li><a onclick="sellerCollectionProducts(<?php echo $scollection_id; ?>,<?php echo $shop_id; ?>);" href="javascript:void(0);"><?php echo Labels::getLabel('TXT_LINK', $adminLangId);?></a></li>
									</ul>
								
						
									<div class="tabs_panel_wrap">
										<div class="form__subcontent">
											<?php 
											$colectionForm->setFormTagAttribute('class', 'form form_horizontal web_form');
											$colectionForm->setFormTagAttribute('onsubmit', 'setupShopCollection(this); return(false);');
											$colectionForm->developerTags['colClassPrefix'] = 'col-md-';
											$colectionForm->developerTags['fld_default_col'] = 12; 
											$urlFld = $colectionForm->getField('urlrewrite_custom');
											$urlFld->setFieldTagAttribute('id',"urlrewrite_custom");
											$urlFld->setFieldTagAttribute('onkeyup',"getSlugUrl(this,this.value,'".$baseUrl."')");
											$urlFld->htmlAfterField = "<br><small class='text--small'>" . CommonHelper::generateFullUrl('Shops','Collection',array($shop_id),CONF_WEBROOT_FRONT_URL).'</small>';
												$IDFld = $colectionForm->getField('scollection_id');
											$IDFld->setFieldTagAttribute('id',"scollection_id");
											$identiFierFld = $colectionForm->getField('scollection_identifier');
											$identiFierFld->setFieldTagAttribute('onkeyup',"Slugify(this.value,'urlrewrite_custom','scollection_id')");
											echo $colectionForm->getFormHtml();
											?>
										</div>
									</div>
							
						
						
					</div>

				
			</div>
			
	</div>
</section>