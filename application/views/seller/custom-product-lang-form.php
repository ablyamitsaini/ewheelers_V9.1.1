<?php defined('SYSTEM_INIT') or die('Invalid Usage.');  ?>
<?php require_once(CONF_THEME_PATH.'_partial/seller/customProductNavigationLinks.php'); ?>  
	<div class="box__body">	
		<div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
			<?php require_once('sellerCustomProductTop.php');?>
		</div>
			<div class="tabs__content form">
			
			<div class="form__content">
				<div class="col-md-12">
					<div class="container container--fluid">
						<div class="tabs--inline tabs--scroll clearfix">
							<ul>
								<li><a href="javascript:void(0);" onclick="customProductForm(<?php echo $product_id ?>);"><?php echo Labels::getLabel('LBL_Basic', $siteLangId);?></a></li>
						
								<?php foreach($languages as $langId=>$langName){?>
								<li class="<?php echo ($langId == $product_lang_id) ? 'is-active' : ''; ?>"><a class="<?php echo ($product_lang_id==$langId) ? ' active' : ''; ?>" href="javascript:void(0);" <?php echo ($product_id) ? "onclick='customProductLangForm( ".$product_id.",".$langId." );'" : ""; ?>><?php echo $langName;?></a></li>
								<?php } ?>

							</ul>	
						</div>
						</div>
						<div class="form__subcontent">
							<?php 
							$customProductLangFrm->setFormTagAttribute('class', 'form form--horizontal layout--'.$formLayout);
							$customProductLangFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
							$customProductLangFrm->developerTags['fld_default_col'] = 12;	
							//$customProductLangFrm->setFormTagAttribute('onsubmit', 'setupCustomProductLang(this); return(false);');
							echo $customProductLangFrm->getFormHtml();
							?> 
						</div>	
					
				</div>
			</div>
		</div>
	</div>
<script>

		var frm = $('form[name=frmCustomProductLang]');
				var validator = $(frm).validation({errordisplay: 3});
				$(frm).submit(function(e) {
					e.preventDefault();
					if (validator.validate() == false) {	
						return ;
					}
					if (!$(frm).validate()) return;
					var data = fcom.frmData(frm);
					fcom.updateWithAjax(fcom.makeUrl('Seller', 'setupCustomProductLang'), data, function(t) {
						runningAjaxReq = false;
						$.mbsmessage.close();
						fcom.resetEditorInstance();
									
						if (t.lang_id>0) {
							customProductLangForm(t.product_id, t.lang_id);
							return ;
						}
						fcom.scrollToTop($("#listing"));
					
						return ;
					});
				});	</script>