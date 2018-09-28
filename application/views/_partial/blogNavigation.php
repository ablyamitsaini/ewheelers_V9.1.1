<div class="logo"><a href="<?php echo CommonHelper::generateUrl(); ?>"><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a></div>
<?php if(!empty($categoriesArr)){ /* CommonHelper::printArray($categoriesArr); die; */
	$noOfCharAllowedInNav = 60;
	$navLinkCount = 0;
	foreach( $categoriesArr as $cat ){
		if( !$cat ){ break;}
		$noOfCharAllowedInNav = $noOfCharAllowedInNav - mb_strlen($cat);
		if($noOfCharAllowedInNav < 0){
			break;
		}
		$navLinkCount++;
	} ?>
	<nav class="nav-blog">
		<ul>
			<li><a href="<?php echo CommonHelper::generateUrl('Blog'); ?>"><?php echo Labels::getLabel('LBL_Blog_Home', $siteLangId); ?></a> </li>
			<?php $mainNavigation = array_slice($categoriesArr, 0, $navLinkCount, true);
			foreach($mainNavigation as $id => $cat){ ?>
			<li><a href="<?php echo CommonHelper::generateUrl('Blog','category', array($id)); ?>"><?php echo $cat; ?></a> </li>
			<?php }?>
		</ul>
		<?php $subMoreNavigation = ( count($categoriesArr) > $navLinkCount ) ? array_slice($categoriesArr, $navLinkCount, true) : array(); ?>
		
		<div class="wrapper-menu <?php if(count($subMoreNavigation)==0) echo "wrapper-menu-mobile";?>">
			<div class="line-menu half start"></div>
			<div class="line-menu"></div>
			<div class="line-menu half end"></div>
		</div>
	</nav>
	
	<div class="nav__secondary nav__secondary-js">
		<div class="container container--fixed">
			<ul>
				<li class="on-mobile"><a href="<?php echo CommonHelper::generateUrl('Blog'); ?>"><?php echo Labels::getLabel('LBL_Blog_Home', $siteLangId); ?></a> </li>
				<?php foreach($mainNavigation as $id => $cat){ ?>
				<li class="on-mobile"><a href="<?php echo CommonHelper::generateUrl('Blog','category', array($id)); ?>"><?php echo $cat; ?></a> </li>
				<?php }?>
				<?php if( count( $subMoreNavigation ) ){ ?>
				<?php foreach($subMoreNavigation as $id => $cat){ ?>
				<li><a href="<?php echo CommonHelper::generateUrl('Blog','category', array($id)); ?>"><?php echo $cat; ?></a> </li>
				<?php }?>
				<?php }?>
			</ul>
		</div>
	</div>
	
	<div class="searchform-holder">
		<div class="search-toggle">
			<span class="search-icon"></span>
		</div>
		<div class="search-form active">
			<?php $srchFrm->setFormTagAttribute ( 'onSubmit', 'submitBlogSearch(this); return(false);' ); 
			$srchFrm->setFormTagAttribute('class','form-main-search');
			$srchFrm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
			$srchFrm->developerTags['fld_default_col'] = 12;
			$keywordFld = $srchFrm->getField('keyword');
			$keywordFld->setFieldTagAttribute('class','no-focus');
			$keywordFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Keyword', $siteLangId));
			echo $srchFrm->getFormTag(); 
			echo $srchFrm->getFieldHTML('keyword');
			echo $srchFrm->getFieldHTML('btnProductSrchSubmit');
			echo $srchFrm->getExternalJS();
			?>
			</form>
		</div>
	</div>
<?php }?>