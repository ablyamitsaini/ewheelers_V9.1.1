<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
    <div class='page'>
        <div class='container container-fluid'>
            <div class="row">
                <div class="col-lg-12 col-md-12 space">
                    <div class="page__title">
                        <div class="row">
                            <div class="col--first col-lg-6">
                                <span class="page__icon">
								<i class="ion-android-star"></i></span>
                                <h5><?php echo Labels::getLabel('LBL_Manage_Deleted_Users',$adminLangId); ?> </h5>
                                <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                            </div>
						</div>
					</div>
					<section class="section searchform_filter">
						<div class="sectionhead">
							<h4> <?php echo Labels::getLabel('LBL_Search...',$adminLangId); ?></h4>
						</div>
						<div class="sectionbody space togglewrap" style="display:none;">
							<?php 
							$frmSearch->setFormTagAttribute ( 'onsubmit', 'searchDeletedUsers(this,1); return(false);');
							$frmSearch->setFormTagAttribute ( 'class', 'web_form' );
							$frmSearch->developerTags['colClassPrefix'] = 'col-md-';					
							$frmSearch->developerTags['fld_default_col'] = 6;					

							$fld = $frmSearch->getField('btn_clear');
							$fld->addFieldTagAttribute('onclick','clearDeletedUserSearch()');
							echo  $frmSearch->getFormHtml();
								?>
						</div>
					</section>
                   
                    <section class="section">
						<div class="sectionhead">
							<h4><?php echo Labels::getLabel('LBL_Users_List',$adminLangId); ?> </h4>
							<?php 
								$ul = new HtmlElement("ul",array("class"=>"actions actions--centered"));
								$li = $ul->appendElement("li",array('class'=>'droplink'));						
								$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit',$adminLangId)),'<i class="ion-android-more-horizontal icon"></i>', true);
								
								$innerDiv=$li->appendElement('div',array('class'=>'dropwrap'));	
								$innerUl=$innerDiv->appendElement('ul',array('class'=>'linksvertical'));
								$innerLi=$innerUl->appendElement('li');
								$innerLi->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_users',$adminLangId),"onclick"=>"userListing()"),Labels::getLabel('LBL_users',$adminLangId), true);								
								echo $ul->getHtml();		
							?>
						</div>
						<div class="sectionbody">
							<div class="tablewrap">
								<div id="userListing">
									<?php echo Labels::getLabel('LBL_Processing...',$adminLangId); ?>
								</div>
							</div>
						</div>
					</section>
			 
				</div>
			</div>
		</div>
	</div>