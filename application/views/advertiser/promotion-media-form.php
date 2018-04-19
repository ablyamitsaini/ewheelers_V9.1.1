<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$mediaFrm->setFormTagAttribute('class', 'form form--horizontal');
$mediaFrm->setFormTagAttribute('onsubmit', 'setupPromotionMedia(this); return(false);');

$fld1 = $mediaFrm->getField('banner_image');	
$fld1->addFieldTagAttribute('class','btn btn--primary btn--sm');
$langFld = $mediaFrm->getField('lang_id');	
$langFld->addFieldTagAttribute('class','banner-language-js');

$screenFld = $mediaFrm->getField('banner_screen');	
$screenFld->addFieldTagAttribute('class','banner-screen-js');

$preferredDimensionsStr = '<span class="uploadimage--info" > '.sprintf(Labels::getLabel('LBL_Preferred_Dimensions',$siteLangId),$bannerWidth . ' * ' . $bannerHeight).'</span>';

$htmlAfterField = $preferredDimensionsStr; 
$htmlAfterField.='<div id="image-listing-js"></div>';
$fld1->htmlAfterField = $htmlAfterField;

?>
<div class="tabs tabs--small tabs--offset tabs--scroll clearfix setactive-js">
	<ul>
		<li><a href="javascript:void(0);" onClick="promotionForm(<?php echo $promotionId;?>)"><?php echo Labels::getLabel('LBL_General',$siteLangId);?></a></li>	
		<?php $inactive = ($promotionId==0)?'fat-inactive':'';
		foreach($languages as $langId => $langName){?>	
			<li class="<?php echo $inactive ; ?>"><a href="javascript:void(0)" <?php if($promotionId>0){ ?> onClick="promotionLangForm(<?php echo $promotionId;?>,<?php echo $langId;?>)" <?php }?>>
		<?php echo $langName;?></a></li>
		<?php } ?>
		<?php if($promotionType == Promotion::TYPE_BANNER || $promotionType == Promotion::TYPE_SLIDES){?>
		<li class="is-active"><a href="javascript:void(0)" <?php if($promotionId>0){ ?> onClick="promotionMediaForm(<?php echo $promotionId;?>)" <?php }?>><?php echo Labels::getLabel('LBL_Media',$siteLangId); ?></a></li>		
		<?php }?>
	</ul>
</div>
<div class="tabs__content">                                               
	<div class="form__content">		
        <div class="row">
			<div class="col-md-8">
			<?php echo $mediaFrm->getFormHtml(); ?>
			</div>
        </div>
	</div>
</div>