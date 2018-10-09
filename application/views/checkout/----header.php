<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$commonHead1Data = array( 
	'siteLangId'		=>	$siteLangId,
	'controllerName'	=>	$controllerName,
	'jsVariables'		=>	$jsVariables,
	);
$this->includeTemplate( '_partial/header/commonHead1.php', $commonHead1Data); 

/* This is not included in common head, because, if we are adding any css/js from any controller then that file is not included[ */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE);
/* ] */

$commonHead2Data = array(
	'siteLangId'		=>	$siteLangId,
	'controllerName'	=>	$controllerName,
);
	
if( isset($layoutTemplate) && $layoutTemplate != '' ){
	$commonHead2Data['layoutTemplate']	= $layoutTemplate;
	$commonHead2Data['layoutRecordId']	= $layoutRecordId;
}
if( isset($socialShareContent) && $socialShareContent != '' ){
	$commonHead2Data['socialShareContent']	= $socialShareContent;
}
$this->includeTemplate( '_partial/header/commonHead2.php', $commonHead2Data);
?>

<div class="wrapper">
  <div class="header-checkout">
    <div class="container">
      <div class="logo zoomIn"> <a href="<?php echo CommonHelper::generateUrl(); ?>"><img src="<?php echo FatUtility::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a> </div>
      <div class="right-info">
        <ul class="trust-banners">
          <li><i class="svg-icn"> <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="22.852px" height="27.422px" viewBox="0 0 22.852 27.422" enable-background="new 0 0 22.852 27.422" xml:space="preserve">
            <path fill="none" d="M19.424,14.854c0,2.589-2.285,4.928-4.195,6.428c-1.429,1.124-2.893,1.963-3.803,2.445V3.428h7.998V14.854z
	 M22.852,1.143C22.852,0.518,22.334,0,21.709,0H1.143C0.518,0,0,0.518,0,1.143v13.711c0,7.516,10.516,12.266,10.962,12.461
	c0.143,0.072,0.303,0.107,0.464,0.107c0.16,0,0.321-0.035,0.464-0.107c0.446-0.195,10.962-4.945,10.962-12.461V1.143z"/>
            </svg> </i>
            <p><?php echo Labels::getLabel('LBL_Secure', $siteLangId); ?> <br>
              <?php echo Labels::getLabel('LBL_Payments', $siteLangId); ?></p>
          </li>
          <li><i class="svg-icn"> <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="36.566px" height="29.707px" viewBox="0 0 36.566 29.707" enable-background="new 0 0 36.566 29.707" xml:space="preserve">
            <path fill="none" d="M3.787,11.426h5.766l5.356,11.872L3.787,11.426z M18.283,25.209l-6.23-13.783h12.461L18.283,25.209z
	 M9.606,9.141H3.43l5.142-6.855h4.678L9.606,9.141z M21.657,23.298l5.356-11.872h5.766L21.657,23.298z M12.195,9.141l3.642-6.855
	h4.892l3.643,6.855H12.195z M26.96,9.141l-3.643-6.855h4.678l5.142,6.855H26.96z M29.477,0.465C29.263,0.16,28.924,0,28.566,0H8
	C7.643,0,7.304,0.16,7.09,0.465L0.234,9.605c-0.34,0.428-0.304,1.053,0.071,1.463L17.444,29.35c0.214,0.232,0.518,0.357,0.839,0.357
	s0.625-0.125,0.839-0.357l17.139-18.281c0.375-0.41,0.411-1.035,0.071-1.463L29.477,0.465z"/>
            </svg> </i>
            <p><?php echo Labels::getLabel('LBL_Authentic', $siteLangId); ?><br><?php echo Labels::getLabel('LBL_Products', $siteLangId); ?></p>
          </li>
          <li><i class="svg-icn"> <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="27.422px" height="27.422px" viewBox="0 0 27.422 27.422" enable-background="new 0 0 27.422 27.422" xml:space="preserve">
            <path fill="none" d="M15.996,7.427c0-0.321-0.25-0.571-0.571-0.571h-1.143c-0.321,0-0.571,0.25-0.571,0.571v6.284H9.712
	c-0.321,0-0.571,0.25-0.571,0.571v1.143c0,0.321,0.25,0.571,0.571,0.571h5.713c0.321,0,0.571-0.25,0.571-0.571V7.427z
	 M23.423,13.711c0,5.355-4.356,9.712-9.712,9.712s-9.712-4.356-9.712-9.712s4.356-9.712,9.712-9.712S23.423,8.355,23.423,13.711z
	 M27.422,13.711C27.422,6.142,21.28,0,13.711,0S0,6.142,0,13.711c0,7.57,6.142,13.711,13.711,13.711S27.422,21.281,27.422,13.711z"
	/>
            </svg> </i>
            <p>24x7 <?php echo Labels::getLabel('LBL_Customer', $siteLangId); ?> <br>
              <?php echo Labels::getLabel('LBL_Support', $siteLangId); ?> </p>
          </li>
          <li><i class="svg-icn"> <svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 width="30.85px" height="25.137px" viewBox="0 0 30.85 25.137" enable-background="new 0 0 30.85 25.137" xml:space="preserve">
            <path fill="none" d="M10.283,20.566c0,1.25-1.035,2.285-2.285,2.285s-2.285-1.035-2.285-2.285c0-1.25,1.035-2.285,2.285-2.285
	S10.283,19.317,10.283,20.566z M3.428,11.426V10.89c0-0.071,0.107-0.339,0.16-0.393l3.481-3.481
	c0.054-0.053,0.321-0.161,0.394-0.161h2.82v4.57H3.428z M26.279,20.566c0,1.25-1.035,2.285-2.285,2.285s-2.285-1.035-2.285-2.285
	c0-1.25,1.035-2.285,2.285-2.285S26.279,19.317,26.279,20.566z M30.85,1.143C30.85,0.518,30.332,0,29.707,0H11.426
	c-0.625,0-1.143,0.518-1.143,1.143V4.57H7.427c-0.643,0-1.5,0.357-1.946,0.804L1.946,8.909c-0.982,0.982-0.804,2.392-0.804,3.66
	v5.713C0.518,18.281,0,18.799,0,19.424c0,1.321,1.393,1.143,2.285,1.143h1.143c0,2.518,2.053,4.57,4.57,4.57s4.57-2.053,4.57-4.57
	h6.855c0,2.518,2.053,4.57,4.57,4.57s4.57-2.053,4.57-4.57c0.893,0,2.285,0.179,2.285-1.143V1.143z"/>
            </svg> </i>
            <p><?php echo Labels::getLabel('LBL_Fast', $siteLangId); ?><br>
              <?php echo Labels::getLabel('LBL_Delivery', $siteLangId); ?></p>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="after-header"></div>