<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
?>
<div class='page'>
	<div class='container container-fluid'>
		<div class="row">
			<div class="col-lg-12 col-md-12 space">
				<div class="page__title">
					<div class="row">
						<div class="col--first col-lg-6">
							<span class="page__icon"><i class="ion-android-star"></i></span>
							<h5><?php echo Labels::getLabel('LBL_Manage_Faq_Categories',$adminLangId); ?> </h5>
							<?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
						</div>
					</div>
				</div>

<!--<div class="row">
	<div class="col-sm-12">--> 
		<h1><?php //echo Labels::getLabel('LBL_Manage_Faq_Categories',$adminLangId); ?></h1>
			<section class="section searchform_filter">
			<div class="sectionhead">
				<h4> <?php echo Labels::getLabel('LBL_Search...',$adminLangId); ?></h4>
			</div>
			<div class="sectionbody space togglewrap" style="display:none;">
				<?php 
					$searchFrm->setFormTagAttribute ( 'onsubmit', 'searchFaqCategories(this); return(false);');
					$searchFrm->setFormTagAttribute ( 'class', 'web_form' );
					$searchFrm->developerTags['colClassPrefix'] = 'col-md-';					
					$searchFrm->developerTags['fld_default_col'] = 6;					
					echo  $searchFrm->getFormHtml();
				?>    
			</div>
		</section> 
	<!--</div>
	<div class="col-sm-12">--> 		
		<section class="section">
		<div class="sectionhead">
			<h4><?php echo Labels::getLabel('LBL_Faq_Category_List',$adminLangId); ?></h4>
			<?php if($canEdit){
							$ul = new HtmlElement( "ul",array("class"=>"actions actions--centered") );
							$li = $ul->appendElement("li",array('class'=>'droplink'));
							$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit',$adminLangId)),'<i class="ion-android-more-horizontal icon"></i>', true);
							$innerDiv=$li->appendElement('div',array('class'=>'dropwrap'));
							$innerUl=$innerDiv->appendElement('ul',array('class'=>'linksvertical'));
							$innerLiAddCat=$innerUl->appendElement('li');            
							$innerLiAddCat->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('LBL_Add_category',$adminLangId),"onclick"=>"addFaqCatForm(0)"),Labels::getLabel('LBL_Add_category',$adminLangId), true);
							
							echo $ul->getHtml();
			
							/*			<a href="javascript:void(0)" class="themebtn btn-default btn-sm" onClick="faqCatForm(0)";><?php echo Labels::getLabel('LBL_Add_category',$adminLangId); ?></a>
							<!--<a href="javascript:void(0)" class="themebtn btn-default btn-sm" onClick="faqToCmsForm(0)";><?php echo Labels::getLabel('LBL_Faq_To_CMS',$adminLangId); ?></a>-->*/
			 } ?>
		</div>
		<div class="sectionbody">
			<div class="tablewrap" >
				<div id="listing"> <?php echo Labels::getLabel('LBL_Processing',$adminLangId); ?></div>
			</div> 
		</div>
		</section>
	</div>		
</div>
</div></div>