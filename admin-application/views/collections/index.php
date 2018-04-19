<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<!--<div class="row">
	<div class="col-sm-12">--> 
<div class='page'>
	<div class='fixed_container'>
		<div class="row">
			<div class="space">
				<div class="page__title">

					<div class="row">
						<div class="col--first col-lg-6">
							<span class="page__icon"><i class="ion-android-star"></i></span>
							<h5><?php echo Labels::getLabel('LBL_Manage_Collections',$adminLangId); ?> </h5>
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
					$search->setFormTagAttribute ( 'onsubmit', 'searchCollection(this); return(false);');
					$search->setFormTagAttribute ( 'class', 'web_form' );
					$search->setFormTagAttribute ( 'id', 'frmSearch' );
					$search->developerTags['colClassPrefix'] = 'col-md-';					
					$search->developerTags['fld_default_col'] = 6;
					$frmId = $search->getFormTagAttribute('id');
					$fld = $search->getField('collection_type');					
					$fld->addFieldTagAttribute('onChange', 'getCollectionTypeLayout("'.$frmId.'",this.value,1); ');
					$search->getField('keyword')->addFieldtagAttribute('class','search-input');
					$search->getField('btn_clear')->addFieldtagAttribute('onclick','clearSearch();');
					
					echo  $search->getFormHtml();
				?>    
			</div>
		</section>
		<section class="section">
		<div class="sectionhead">
			<h4><?php echo Labels::getLabel('Lbl_Collection_Listing',$adminLangId);?></h4>
			<?php 

					$ul = new HtmlElement( "ul",array("class"=>"actions actions--centered") );
	           	 	$li = $ul->appendElement("li",array('class'=>'droplink'));
					$li->appendElement('a', array('href'=>'javascript:void(0)', 'class'=>'button small green','title'=>Labels::getLabel('LBL_Edit',$adminLangId)),'<i class="ion-android-more-horizontal icon"></i>', true);
					$innerDiv=$li->appendElement('div',array('class'=>'dropwrap'));
					$innerUl=$innerDiv->appendElement('ul',array('class'=>'linksvertical'));

			if($canEdit){


					$innerLiCollectionForm=$innerUl->appendElement('li');
					$innerLiCollectionForm->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('Lbl_Add_Collection',$adminLangId),"onclick"=>"addCollectionForm(0)"),Labels::getLabel('Lbl_Add_Collection',$adminLangId), true);

			 /*			<a href="javascript:void(0)" class="themebtn btn-default btn-sm" onClick="collectionForm(0)"><?php echo Labels::getLabel('Lbl_Add_Collection',$adminLangId);?></a>*/
			} 

							$innerLiAddCollectionLayouts=$innerUl->appendElement('li');            
							$innerLiAddCollectionLayouts->appendElement('a', array('href'=>'javascript:void(0)','class'=>'button small green','title'=>Labels::getLabel('Lbl_Collection_Layouts_Instructions',$adminLangId),"onclick"=>"collectionLayouts()"),Labels::getLabel('Lbl_Collection_Layouts_Instructions',$adminLangId), true);

				/*		<a href="javascript:void(0)" onClick="collectionLayouts()" class="themebtn btn-default btn-sm"><?php echo Labels::getLabel('Lbl_Collection_Layouts_Instructions',$adminLangId);?></a>	*/
				echo $ul->getHtml();
			?>		
		</div>
		<div class="sectionbody">
			<div class="tablewrap" >
				<div id="listing"> <?php echo Labels::getLabel('Lbl_Processing',$adminLangId);?>....</div>
			</div> 
		</div>
		</section>
	</div>		
</div>
</div>
</div>