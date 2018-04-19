<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
	$pSrchFrm->setFormTagAttribute( 'class','form custom-form');
	$keywordFld = $pSrchFrm->getField('keyword');
	$submitFld = $pSrchFrm->getField('btnSiteSrchSubmit');
	$submitFld->setFieldTagAttribute('class','');
	$keywordFld->setFieldTagAttribute('class','search--keyword--js');
	$keywordFld->setFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search_for_Product...',$siteLangId));
	/* $keywordFld->setFieldTagAttribute('autofocus','autofocus'); */
	$keywordFld->setFieldTagAttribute('id','header_search_keyword');
	$keywordFld->setFieldTagAttribute('onkeyup','animation(this)');
?>
 

<div class=" align--center">
	<div class="no-product">
		<div class="rel-icon"><img src="<?php echo CONF_WEBROOT_URL; ?>images/retina/empty_cart.svg" alt="<?php echo Labels::getLabel('LBL_No_Product_found', $siteLangId);?>"></div>
		<div class="no-product-txt"> <span>
			<?php echo Labels::getLabel('LBL_WE_COULD_NOT_FIND_ANY_MATCHES!', $siteLangId); ?> </span> 
			<?php echo Labels::getLabel('LBL_Please_check_if_you_misspelt_something_or_try_searching_again_with_fewer_keywords.', $siteLangId); ?>
		</div>
		<div class="query-form">
			<?php echo $pSrchFrm->getFormTag(); ?>			
			<?php echo $pSrchFrm->getFieldHTML('btnSiteSrchSubmit'); ?>
            <?php echo $pSrchFrm->getFieldHTML('keyword'); ?>
			</form>
			<?php echo $pSrchFrm->getExternalJS(); ?>
			<?php if (count($top_searched_keywords)>0): /* CommonHelper::printArray($top_searched_keywords); die; */ ?>
				<p class="txt-popular"><strong><?php echo Labels::getLabel('L_Popular_Searches', $siteLangId)?></strong> &nbsp;
				<?php $inc = 0; foreach ($top_searched_keywords as $record) { $inc++; if($inc >1) {echo "|";}?>
					<a href="<?php echo CommonHelper::generateUrl('products', 'search',array( 'keyword',$record['searchitem_keyword']));?>"><?php echo $record['searchitem_keyword']?> </a>
				<?php } ?>
				</p>
		   <?php endif; ?>
		</div>
	</div>
</div>
<?php
$postedData['page'] = 1;
	echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmProductSearchPaging','id' => 'frmProductSearchPaging') );
?>