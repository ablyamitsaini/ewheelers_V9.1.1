<?php 
define ('CONF_FORM_ERROR_DISPLAY_TYPE', Form::FORM_ERROR_TYPE_AFTER_FIELD);
define('CONF_FORM_REQUIRED_STAR_WITH', Form::FORM_REQUIRED_STAR_WITH_CAPTION);
define('CONF_FORM_REQUIRED_STAR_POSITION', Form::FORM_REQUIRED_STAR_POSITION_AFTER);

FatApplication::getInstance()->setControllersForStaticFileServer(array('images', 'fonts', 'js', 'img', 'innovas','assetmanager'));

$innova_settings  =  array('width'=>'650', 'height'=>'400','arrStyle'=>'[["body",false,"","min-height:250px;"]]',  'groups'=>' [
        ["group1", "", ["FontName", "FontSize", "Superscript", "ForeColor", "BackColor", "FontDialog", "BRK", "Bold", "Italic", "Underline", "Strikethrough", "TextDialog", "Styles", "RemoveFormat"]],
        ["group2", "", ["JustifyLeft", "JustifyCenter", "JustifyRight", "Paragraph", "BRK", "Bullets", "Numbering", "Indent", "Outdent"]],
        ["group3", "", ["TableDialog", "Emoticons", "FlashDialog", "BRK", "LinkDialog","YoutubeDialog"]],        
		["group4", "", ["CharsDialog", "Line", "BRK", "ImageDialog", "MyCustomButton"]],
        ["group5", "", ["SearchDialog", "SourceDialog", "BRK", "Undo", "Redo"]]]',
		'fileBrowser'=> '"'.CONF_WEBROOT_URL.'innova/assetmanager/asset.php"',
		'css'=> '"'.CONF_WEBROOT_URL.'innovas/styles/default.css"',
		/* 'css'=>'"' . CommonHelper::generateFullUrl ( 'JsCss', 'cssCommon', array (), '', false ) . '&f=' . rawurlencode ( 'style.css' ) */		);

		$innova_settings  =  array('width'=>'650', 'height'=>'400','arrStyle'=>'[["body",false,"","min-height:250px;"]]','fileBrowser'=> '"'.CONF_WEBROOT_URL.'innova/assetmanager/asset.php"',
		'css'=> '"'.CONF_WEBROOT_URL.'innovas/styles/default.css"' );
FatApp::setViewDataProvider('_partial/header/left-navigation.php', array('Navigation', 'setLeftNavigationVals'));
FatApp::setViewDataProvider('_partial/header/header-breadcrumb.php', array('Common', 'setHeaderBreadCrumb'));
