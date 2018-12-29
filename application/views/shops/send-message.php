<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php 
	$frm->setFormTagAttribute('class','form form--horizontal');
	$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
	$frm->developerTags['fld_default_col'] = 12;	
	$frm->setFormTagAttribute('onSubmit', 'setUpSendMessage(this); return false;');
	$fromFld = $frm->getField('send_message_from');
	$toFld = $frm->getField('send_message_to');
	
	$fromFldHtml = new HtmlElement( 'div', array( 'class'=>'field-set' ));
	$fromFldCaptionWrapper = $fromFldHtml->appendElement('div', array('class' => 'caption-wraper'));
	$fromFldCaptionWrapper->appendElement( 'label', array('class'=>'field_label'), Labels::getLabel('LBL_From', $siteLangId) );
	
	$fromFldFieldWrapper = $fromFldHtml->appendElement('div', array('class' => 'field-wraper'));
	$fromFldData = $loggedUserData['credential_username'].' (<em>'.$loggedUserData['user_name'].'</em>)';
	$fromFldData .= '<br/><span class="text--small">'.Labels::getLabel('LBL_Contact_info_not_shared', $siteLangId).'</span>';
	$fromFldFieldWrapper->appendElement( 'div', array('class' => 'field_cover'), $fromFldData, true );
	
	$fromFld->value = $fromFldHtml->getHtml();
	
	
	$toFldHtml = new HtmlElement( 'div', array( 'class'=>'field-set' ));
	$toFldCaptionWrapper = $toFldHtml->appendElement('div', array('class' => 'caption-wraper'));
	$toFldCaptionWrapper->appendElement( 'label', array('class'=>'field_label'), Labels::getLabel('LBL_To', $siteLangId) );
	
	$toFldFieldWrapper = $toFldHtml->appendElement('div', array('class' => 'field-wraper'));
	$toFldFieldWrapper->appendElement( 'div', array('class' => 'field_cover'), $shop['shop_owner_name'].' (<em>'.$shop['shop_name'].'</em>)', true );
	
	$toFld->value = $toFldHtml->getHtml();
	
	if(isset($product))
	{
		$productFld = $frm->getField('about_product');
		$productFldHTML = new HtmlElement( 'div', array( 'class'=>'field-set' ));
		$productFldCaptionWrapper = $productFldHTML->appendElement('div', array('class' => 'caption-wraper'));
		$productFldCaptionWrapper->appendElement( 'label', array('class'=>'field_label'), Labels::getLabel('LBL_About_Product', $siteLangId) );
		
		$productFldFieldWrapper = $productFldHTML->appendElement('div', array('class' => 'field-wraper'));
		$productFldFieldWrapper->appendElement( 'div', array('class' => 'field_cover'), $product['selprod_title'] , true );
		
		$productFld->value = $productFldHTML->getHtml();
	}
	
	$shop_city = $shop['shop_city'];
	$shop_state = ( strlen($shop['shop_city']) > 0 ) ? ', '. $shop['shop_state_name'] : $shop['shop_state_name'];
	$shop_country = ( strlen($shop_state) > 0 ) ? ', '.$shop['shop_country_name'] : $shop['shop_country_name']; 
	$shopLocation = $shop_city . $shop_state. $shop_country;
?>

<div id="body" class="body bg--gray">
  <section class="top-space">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-sm-8">
          <div class="cell">
            <div class="avtar__info">
              <h2><?php echo $shop['shop_name']; ?></h2>
              <p><?php echo $shopLocation; ?> <?php echo Labels::getLabel('LBL_Opened_on', $siteLangId); ?> <?php echo FatDate::format($shop['shop_created_on']); ?></p>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4 align--right"><a href="<?php echo CommonHelper::generateUrl('Shops', 'View', array($shop['shop_id'])); ?>" class="btn btn--primary"><?php echo Labels::getLabel('LBL_Back_to_Shop', $siteLangId); ?></a>  </div>
      </div>
       <div class="section clearfix">
		  <div class="section__head">
		    <h4><?php echo Labels::getLabel('LBL_Send_Message_to_shop_owner', $siteLangId); ?></h4>
			<?php if( $shop['shop_user_id'] === $loggedUserData['user_id']){ ?>
			<div class="note-messages"><?php echo Labels::getLabel('LBL_User_is_not_allowed_to_send_message_to_yourself', $siteLangId); ?></div>
			<?php } ?>
		  </div>
		  <div class="section__body">
		    <div class="box box--white  box--space"> <?php echo $frm->getFormHtml(); ?> </div>
		  </div>
		</div>
    </div>
  </section>
	<div class="gap"></div>
</div>
