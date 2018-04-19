<?php 
defined('SYSTEM_INIT') or die('Invalid Usage.');
$blockLangFrm->setFormTagAttribute('class', 'web_form layout--'.$formLayout);
$blockLangFrm->setFormTagAttribute('onsubmit', 'setupBlockLang(this); return(false);');	

$blockLangFrm->developerTags['colClassPrefix'] = 'col-md-';
$blockLangFrm->developerTags['fld_default_col'] = 12;


$edFld = $blockLangFrm->getField('epage_content');
$edFld->htmlBeforeField = '<br/><a class="themebtn btn-primary" onClick="resetToDefaultContent();" href="javascript:void(0)">Reset Editor Content to default</a>';

if(array_key_exists($epageData['epage_id'],$contentBlockArrWithBg)) {
	$fld = $blockLangFrm->getField('cblock_bg_image');
	$fld->addFieldTagAttribute('class','btn btn--primary btn--sm');

	$preferredDimensionsStr = '<small class="text--small"> '.Labels::getLabel('LBL_This_will_be_displayed_on_Registration_Page',$adminLangId).'</small>';

	$htmlAfterField = $preferredDimensionsStr; 
	/* CommonHelper::printArray($bgImages);die; */
	if( !empty($bgImages) ){
		$htmlAfterField .= '<ul class="image-listing grids--onethird">';
		foreach($bgImages as $bgImage){
		$htmlAfterField .= '<li>'.$bannerTypeArr[$bgImage['afile_lang_id']].'<div class="uploaded--image"><img src="'.CommonHelper::generateFullUrl('image','cblockBackgroundImage',array($epageData['epage_id'],$bgImage['afile_lang_id'],'THUMB',$bgImage['afile_type']),CONF_WEBROOT_FRONT_URL).'?'.time().'"> <a href="javascript:void(0);" onClick="removeBgImage('.$bgImage['afile_record_id'].','.$bgImage['afile_lang_id'].','.$bgImage['afile_type'].')" class="remove--img"><i class="ion-close-round"></i></a></div>';
		}
		$htmlAfterField.='</li></ul>';
	} else {
		$htmlAfterField.='<div class="hide"><ul class="image-listing grids--onethird"><li><div class="uploaded--image"></div></li></ul></div>';
	}
	$fld->htmlAfterField = $htmlAfterField; 
}
?>



<!-- editor's default content[ -->
<div id="editor_default_content" style="display:none;">
	<?php 
	if( isset($epageData) ){
	switch ($epageData['epage_type']){
		case Extrapage::CONTACT_US_CONTENT_BLOCK:
			?>
			<h6 class="txt--uppercase">IMPORTANT INFORMATION REGARDING ONLINE PHISHING FRAUD</h6>
			<p>If you have recently received suspect correspondence or a link regarding your data security on yoKart.com, please<a href="#">Click Here</a>.</p>
			<h6 class="txt--uppercase">ORDER ACCEPTANCE POLICIES</h6>
			<p>Yokart Does not accept the order by 
			<a href="#">Manufacturers contact page</a>.</p>
			<?php
			break;
			
			case Extrapage::SELLER_PAGE_BLOCK1:
			?>
			 <div class="row">
			  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="growth" style="background-image:url(images/customer.png);"><strong>5+</strong><br>
				  Millions Customers</div>
				<div class="growth" style="background-image:url(images/bussiness.png);"><strong>1000+</strong><br>
				  Business Growing rapidly with us </div>
			  </div>
			  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<ul class="growth-txt">
				  <li><i class="icn"><img src="images/star-unique.png" alt=""></i>
					<h4>Consectetur adipisicing</h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do 
					  incididunt ut labore et dolore magna aliqua. </p>
				  </li>
				  <li><i class="icn"><img src="images/folder.png" alt=""></i>
					<h4>Consectetur adipisicing</h4>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do 
					  incididunt ut labore et dolore magna aliqua.</p>
				  </li>
				</ul>
			  </div>
			</div>
			<?php
			break;case Extrapage::SELLER_PAGE_BLOCK2:
			?>
			 <div class="heading1">Simple steps to start selling online</div>
        
        
				<div class="seller-steps">
			  <ul>
				<li><i class="icn"><img src="/images/easyto-use.png" alt=""></i>
				  <h3>Easy to Use</h3>
				  <p>Set up simulation exercises for large group of students in a few steps.</p>
				</li>
				<li><i class="icn"><img src="/images/real-market.png" alt=""></i>
				  <h3>Real Market Data</h3>
				  <p>Use real financial markets data in simulation activities.</p>
				</li>
				<li><i class="icn"><img src="/images/simulated.png" alt=""></i>
				  <h3>Simulated Market Data</h3>
				  <p>Simulate past market events and data over a specific historical time period.</p>
				</li>
				<li><i class="icn"><img src="/images/customization.png" alt=""></i>
				  <h3>Fully Customisable</h3>
				  <p>Fully customise activities to meet various learning outcomes, disciplines and levels of difficulty.</p>
				</li>
			  </ul>
			</div>
			
    
			<?php
			break;case Extrapage::SELLER_PAGE_BLOCK3:
			?>
			  <div class="heading1">Simple Pricing Structure</div>
				<div class="pricing-structure">
				  <ul>
					<li><span>10%</span>
					  <p>Commission Fee</p>
					</li>
					<li class="sign">+</li>
					<li><span>$1</span>
					  <p>Shipping Fee</p>
					</li>
					<li class="sign">+</li>
					<li><span>$4 </span>
					  <p>Marketplace Fee</p>
					</li>
					<li class="sign">+</li>
					<li><span>15% </span>
					  <p>Service Tax</p>
					</li>
					<li class="sign">+</li>
					<li><span>Amt. </span>
					  <p>Amount You Earned</p>
					</li>
					<li class="sign">=</li>
					<li><span>Price </span>
					  <p>Price You Decide</p>
					</li>
				  </ul>
				</div>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum voluptatem.</p>
				<a href="#" class="btn btn--primary btn--custom">Learn More About Pricing</a>
			<?php
			break;
			
			
			}
		}
	 ?>
</div>
<!-- ] -->
<section class="section">
<div class="sectionhead">
   
    <h4><?php echo Labels::getLabel('LBL_Content_Block_Setup',$adminLangId); ?></h4>
</div>
<div class="sectionbody space">
<div class="row">	

<div class="col-sm-12">
	<div class="tabs_nav_container responsive flat">
		<ul class="tabs_nav">
			<li><a href="javascript:void(0);" onclick="addBlockForm(<?php echo $epage_id ?>);"><?php echo Labels::getLabel('LBL_General',$adminLangId); ?></a></li>
			<?php 
			if ( $epage_id > 0 ) {
				foreach( $languages as $langId => $langName ){ ?>
					<li><a class="<?php echo ($epage_lang_id == $langId)?'active':''?>" href="javascript:void(0);" 
					onclick="addBlockLangForm(<?php echo $epage_id ?>, <?php echo $langId;?>);"><?php echo Labels::getLabel('LBL_'.$langName,$adminLangId);?></a></li>
				<?php }
				}
			?>
		</ul>
		<div class="tabs_panel_wrap">
			<div class="tabs_panel">
				<?php 
					echo $blockLangFrm->getFormTag();
					echo $blockLangFrm->getFormHtml(false);
					echo '</form>';
				?>	
			</div>
		</div>
	</div>	
</div>
</div></div></section>
