<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body">
  <!--slider[-->
  <?php if( isset($slides) && count($slides) ){
		$this->includeTemplate( '_partial/homePageSlides.php', array( 'slides' =>$slides, 'siteLangId' => $siteLangId ),false );
	} ?>
  <!--]-->
  <?php
	/* collection Layout1[ */
	if(count($sponsoredProds)>0){
		$this->includeTemplate( '_partial/collection/sponsored-products.php', array( 'products' => $sponsoredProds, 'siteLangId' => $siteLangId ),false );
	}

	if( isset( $collections[Collections::COLLECTION_LAYOUT1_TYPE] ) ){
		$this->includeTemplate( '_partial/collection/collection-layout-1.php', array( 'collections' => $collections[Collections::COLLECTION_LAYOUT1_TYPE], 'siteLangId' => $siteLangId ),false );
	}
	/* ] */

	/* Banner After First Layout[ */
	if( isset($banners['Home_Page_After_First_Layout'] ) ){
		$this->includeTemplate( '_partial/banners/banner-after-first-layout.php', array( 'bannerLayout1' => $banners['Home_Page_After_First_Layout'], 'siteLangId' => $siteLangId ),false );
	}
	/* ] */



	/* collection Layout2  and  collection Layout3[ */
	if(isset( $collections[Collections::COLLECTION_LAYOUT2_TYPE] ) || isset( $collections[Collections::COLLECTION_LAYOUT3_TYPE] ) ||
	isset($banners['Home_Page_After_Third_Layout'] )){
		?>
  <section class="clearfix">
    <?php
		if( isset( $collections[Collections::COLLECTION_LAYOUT2_TYPE] ) ){
			$this->includeTemplate( '_partial/collection/collection-layout-2.php', array( 'collections' => $collections[Collections::COLLECTION_LAYOUT2_TYPE], 'siteLangId' => $siteLangId,'action'=>$action ) ,false);
		}
		/* ] */
		/* collection Layout3[ */
		if( isset( $collections[Collections::COLLECTION_LAYOUT3_TYPE] ) ){
			$this->includeTemplate( '_partial/collection/collection-layout-3.php', array( 'collections' => $collections[Collections::COLLECTION_LAYOUT3_TYPE], 'siteLangId' => $siteLangId ),false );
		}
		/* Banner After Third Layout[ */
		if( isset($banners['Home_Page_After_Third_Layout'] ) ){
			$this->includeTemplate( '_partial/banners/banner-after-third-layout.php', array( 'bannerLayout2' => $banners['Home_Page_After_Third_Layout'], 'siteLangId' => $siteLangId ),false );
		}
		/* ] */ ?>
  </section>
  <?php
	}
	/* ] */
	/* collection Layout4 and collection Layout5 [ */
	?>
  <?php if( isset( $collections[Collections::COLLECTION_LAYOUT4_TYPE] )  ){ ?>
  <section class="bg-gray-light padd40">
    <div class="container">
      <?php
			if( isset( $collections[Collections::COLLECTION_LAYOUT4_TYPE] ) ){
				$this->includeTemplate( '_partial/collection/collection-layout-4.php', array( 'collections' => $collections[Collections::COLLECTION_LAYOUT4_TYPE], 'siteLangId' => $siteLangId ,'action'=>$action),false );
			}


			/* ] */
		?>
    </div>
  </section>
  <?php } ?>

   <?php  if( count( $sponsoredShops ) > 0 ){ ?>
  <section class="bg-gray-light padd40">
    <div class="container">
  <?php
  if( count( $sponsoredShops)>0 ){
	$this->includeTemplate( '_partial/collection/sponsored-shops.php', array( 'sponsoredShops' => $sponsoredShops, 'siteLangId' => $siteLangId ,'action'=>$action),false );
	}

  	?>
    </div>
  </section>
  <?php } ?>

   <?php if( isset( $collections[Collections::COLLECTION_LAYOUT5_TYPE] ) ){
	$haveBgImage = AttachedFile::getAttachment( AttachedFile::FILETYPE_CATEGORY_COLLECTION_BG_IMAGE, 0, 0, $siteLangId );
	$bgImageUrl = ($haveBgImage) ? "background-image:url(" . CommonHelper::generateUrl( 'Image', 'CategoryCollectionBgImage', array($siteLangId) ) . ")" : '';
	/* CommonHelper::printArray($bgImageUrl);die; */
   ?>
  <section class="trending-bg padd40" style="<?php echo $bgImageUrl; ?>">
    <div class="container">
	  <?php
		if( isset( $collections[Collections::COLLECTION_LAYOUT5_TYPE] ) ){
			$this->includeTemplate( '_partial/collection/collection-layout-5.php', array( 'collections' => $collections[Collections::COLLECTION_LAYOUT5_TYPE], 'siteLangId' => $siteLangId,'action'=>$action ),false );
	    }
		?>
    </div>
  </section>
  <?php } ?>
  <?php
	/* collection Layout6[ */
	if( isset( $collections[Collections::COLLECTION_LAYOUT6_TYPE] ) ){
		$this->includeTemplate( '_partial/collection/collection-layout-1.php', array( 'collections' => $collections[Collections::COLLECTION_LAYOUT6_TYPE], 'siteLangId' => $siteLangId ,'action'=>$action) ,false);
	}
	/* collection Layout3[ */
	?>
  <!--<div class="gap"></div>-->
</div>
