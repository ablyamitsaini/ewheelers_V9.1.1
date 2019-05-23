<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset($includeEditor) && $includeEditor == true ){
	$extendEditorJs	= 'true';
}else{
	$extendEditorJs	= 'false';
}
if( CommonHelper::isThemePreview() && isset($_SESSION['preview_theme'] ) ){
	$themeActive = 'true';
}else{
	$themeActive = 'false';
}
$commonHead1Data = array(
	'siteLangId'		=>	$siteLangId,
	'controllerName'	=>	$controllerName,
	'jsVariables'		=>	$jsVariables,
	'extendEditorJs'	=>	$extendEditorJs,
	'themeDetail'	    =>	$themeDetail,
	'themeActive'         =>    $themeActive,
	'currencySymbolLeft'  =>    $currencySymbolLeft,
	'currencySymbolRight' =>    $currencySymbolRight,
	'canonicalUrl' =>    isset($canonicalUrl)?$canonicalUrl:'',
	);
$this->includeTemplate( '_partial/header/commonHead1.php', $commonHead1Data,false);
/* This is not included in common head, because, commonhead file not able to access the $this->Controller and $this->action[ */
echo $this->writeMetaTags();
if(CommonHelper::demoUrl() && $controllerName == 'Blog'){
	echo '<meta name="robots" content="noindex">';
}

/* ] */
echo $this->getJsCssIncludeHtml(!CONF_DEVELOPMENT_MODE);

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
$this->includeTemplate('_partial/header/commonHead2.php', $commonHead2Data,false);
?>

<header class="header-blog">
	<div class="main-bar-blog"><div class="container">
		<div class="header-blog-inner">
			<?php $this->includeTemplate( '_partial/blogNavigation.php'); ?>
		</div>
		</div>
	</div>
	<div class="last-bar">
    <div class="container">
        <div class="navigations__overlayx"></div>
        <a class="navs_toggle" href="javascript:void(0)"><span></span></a>
        <div class="navigation-wrapper">
            <ul class="navigations">			                                                                                                                                    
                                <li class=""><a target="_self" data-org-url="/yokartv8/cms/view/1" href="/yokartv8/cms/view/1">Blog Home</a></li>
								<li class=""><a target="_self" data-org-url="/yokartv8/category/view/113" href="javascript:void(0)">eCommerce</a></li>
								<li class=""><a target="_self" data-org-url="/yokartv8/category/view/156" href="javascript:void(0)">Multi-Vendor Store</a></li>
								<li class=""><a target="_self" data-org-url="/yokartv8/category/view/112" href="javascript:void(0)">Startups</a></li>
                                <li class=""><a target="_self" data-org-url="/yokartv8/category/view/109" href="javascript:void(0)">Tips & Trends</a></li>
                                <li class=""><a target="_self" data-org-url="/yokartv8/blog" href="/yokartv8/blog">YoKart Features</a></li>
                            
            </ul>
        </div>
    </div>
</div>
</header>
<div class="after-header-blog"></div>
<div class="clear"></div>
