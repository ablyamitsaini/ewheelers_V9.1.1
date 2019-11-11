<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="section">
	<div class="sectionhead">
		<h4><?php echo Labels::getLabel('LBL_Add_Test_Drive_Credit_Slabs',$adminLangId); ?></h4>
	</div>
	<div class="sectionbody space">
		<div class="row">	
			<div class="col-sm-12">
				<div class="tabs_nav_container responsive flat">
					<ul class="tabs_nav">
						
					</ul>
					<div class="tabs_panel_wrap">
						<div class="tabs_panel">
							<?php 
								$frm->setFormTagAttribute('onsubmit', 'addSlabRates(this); return(false);'); 
								$frm->developerTags['fld_default_col'] = 12;
								$fld = $frm->getField('btn_submit');
								$fld->developerTags['col'] = 12;
								$fld->setFieldTagAttribute('class', 'btn btn--primary block-on-mobile');
								$fld->setFieldTagAttribute('id', 'setupWalletRates');
								echo $frm->getFormHtml();
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
