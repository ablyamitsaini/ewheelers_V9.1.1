<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php
if( CommonHelper::isThemePreview() && isset($_SESSION['preview_theme'] ) ){
	$logoUrl = CommonHelper::generateUrl('home','index');
}else{
	$logoUrl = CommonHelper::generateUrl();
}
?>
<div class="logo zoomIn">
	<a href="<?php echo $logoUrl; ?>"><img src="<?php echo CommonHelper::generateFullUrl('Image','siteLogo',array($siteLangId), CONF_WEBROOT_FRONT_URL); ?>" alt="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>" title="<?php echo FatApp::getConfig('CONF_WEBSITE_NAME_'.$siteLangId) ?>"></a>
</div>
<?php $this->includeTemplate('_partial/headerSearchFormArea.php'); ?>
<?php if( $headerNavigation && count( $headerNavigation ) ){ ?>
<div class="navigations__overlay"></div>
<a class="navs_toggle" href="javascript:void(0)"><span></span></a>
<div class="navigation-wrapper">
	<ul class="navigations">
		<?php
		$noOfCharAllowedInNav = 90;
		$rightNavCharCount = 5;
		if( !$isUserLogged ){
			$rightNavCharCount = $rightNavCharCount + mb_strlen(Labels::getLabel('LBL_Sign_In', $siteLangId));
		}else{
			$rightNavCharCount = $rightNavCharCount + mb_strlen(Labels::getLabel( 'LBL_Hi,', $siteLangId ).' '.$userName);
		}
		$rightNavCharCount = $rightNavCharCount + mb_strlen(Labels::getLabel("LBL_Cart", $siteLangId));
		$noOfCharAllowedInNav = $noOfCharAllowedInNav - $rightNavCharCount;

		$navLinkCount = 0;


			foreach( $headerNavigation as $nav ){
				if( !$nav['pages'] ){ break;}
				foreach($nav['pages'] as $link){
					$noOfCharAllowedInNav = $noOfCharAllowedInNav - mb_strlen($link['nlink_caption']);
					if($noOfCharAllowedInNav < 0){
						break;
					}
					$navLinkCount++;
				}
			}

			foreach( $headerNavigation as $nav ){
				if( $nav['pages'] ){
					$mainNavigation = array_slice($nav['pages'], 0, $navLinkCount);
					foreach( $mainNavigation as $link ){

						$navUrl = CommonHelper::getnavigationUrl( $link['nlink_type'], $link['nlink_url'], $link['nlink_cpage_id'], $link['nlink_category_id'] );
						?>
						<li class="<?php if( count($link['children']) ){ ?>navchild<?php } ?>"><a target="<?php echo $link['nlink_target']; ?>" href="<?php echo $navUrl; ?>"><?php echo $link['nlink_caption']; ?></a>

						<?php if( isset($link['children']) && count($link['children']) > 0 ){ ?>
							<span class="link__mobilenav"></span>
							<div class="subnav">
								<div class="subnav__wrapper ">
									<div class="fixed-container">
										<div class="subnav_row">
											<ul class="sublinks">
												<?php $subyChild=0;
												foreach($link['children'] as $children) {
													$subCatUrl = CommonHelper::generateUrl('category','view',array($children['prodcat_id']));
												?>
												<li><a href="<?php echo $subCatUrl;?>"><?php echo $children['prodcat_name'];?></a>
												<?php if(isset($children['children']) && count($children['children'])>0){ ?>
													<ul>
														<?php $subChild=0;
														foreach($children['children'] as $childCat){
															$catUrl = CommonHelper::generateUrl('category','view',array($childCat['prodcat_id']));
														?>
														<li><a href="<?php echo $catUrl; ?>"><?php echo $childCat['prodcat_name'];?></a></li>
														<?php if ( $subChild++ == 4 ){ break; }
														}
														if(count($children['children'])>5) { ?>
														<li class="seemore"><a href="<?php echo $subCatUrl;?>"><?php echo Labels::getLabel('LBL_View_All',$siteLangId);?></a></li>
														<?php } ?>
													</ul>
												<?php } ?>
												</li>
												<?php  if ( $subyChild++ == 7 ) { break; }
												} ?>
											</ul>
											<?php if( count($link['children']) > 8 ) { ?>
											<a class="btn btn--sm btn--secondary ripplelink " href="<?php echo $navUrl; ?>"><?php echo Labels::getLabel('LBL_View_All',$siteLangId);?></a>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
						</li>
						<?php
					}
				}
			}

			foreach( $headerNavigation as $nav ){
				$subMoreNavigation = ( count($nav['pages']) > $navLinkCount ) ? array_slice($nav['pages'], $navLinkCount) : array();

				if( count( $subMoreNavigation ) ){	?>
				<li class="navchild three-pin">
					<a href="javascript:void(0)" class="more"><span><?php echo Labels::getLabel('L_More',$siteLangId);?></span><i class="icn"> <svg   xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					width="512px" height="121.904px" viewBox="0 195.048 512 121.904" enable-background="new 0 195.048 512 121.904"
					xml:space="preserve">
					<g id="XMLID_27_">
					<path id="XMLID_28_" d="M60.952,195.048C27.343,195.048,0,222.391,0,256s27.343,60.952,60.952,60.952s60.952-27.343,60.952-60.952
					S94.562,195.048,60.952,195.048z"/>
					<path id="XMLID_30_" d="M256,195.048c-33.609,0-60.952,27.343-60.952,60.952s27.343,60.952,60.952,60.952
					s60.952-27.343,60.952-60.952S289.61,195.048,256,195.048z"/>
					<path id="XMLID_71_" d="M451.047,195.048c-33.609,0-60.952,27.343-60.952,60.952s27.343,60.952,60.952,60.952S512,289.609,512,256
					S484.656,195.048,451.047,195.048z"/>
					</g>
					</svg> </i></a>
					<span class="link__mobilenav"></span>
					<div class="subnav">
						<div class="subnav__wrapper ">
							<div class="fixed-container">
								<div class="subnav_row">
									<ul class="sublinks">
									<?php
									//var_dump($subMoreNavigation); die;
									foreach(  $subMoreNavigation  as $index => $link ){
										$url = CommonHelper::getnavigationUrl($link['nlink_type'],$link['nlink_url'],$link['nlink_cpage_id'],$link['nlink_category_id']); ?>
										<li><a target="<?php echo $link['nlink_target']; ?>" href="<?php echo $url;?>"><?php echo $link['nlink_caption']; ?></a></li>
										<?php
										if( count($link['children']) > 0 ){
											foreach( $link['children'] as $subCat ) {
												$catUrl = CommonHelper::generateUrl('category','view',array($subCat['prodcat_id'])); ?>
												<li><a href="<?php echo $catUrl; ?>"><?php echo $subCat['prodcat_name'];?></a>
												<?php if(isset($subCat['children'])){
													?>
													<ul>
													<?php
													$subChild = 0;
													foreach( $subCat['children'] as $childCat ){
														$childCatUrl = CommonHelper::generateUrl('category','view',array( $childCat['prodcat_id']) ); ?>
														<li><a href="<?php echo $childCatUrl; ?>"><?php echo $childCat['prodcat_name'];?></a></li>
														<?php if ( $subChild++ == 4 ) { break; }
													}
													if( count( $subCat['children'] ) > 5 ) { ?>
													<li class="seemore"><a href="<?php echo $catUrl;?>"><?php echo Labels::getLabel('LBL_View_All',$siteLangId);?></a></li>
													<?php } ?>
												</ul>
												<?php }?>
												</li>
											<?php
											}
										}
									} ?>
									</ul>
									<a href="<?php echo CommonHelper::generateUrl('category');?>" class="btn view-all"><?php Labels::getLabel('LBL_View_All_Categories',$siteLangId);?></a>
								</div>
							</div>
						</div>
					</div>
				</li>
			<?php }
		} ?>

	</ul>
</div>
<?php } ?>
