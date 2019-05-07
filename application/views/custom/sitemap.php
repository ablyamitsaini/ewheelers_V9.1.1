<div id="body" class="body bg--gray">
    <section class="dashboard">
        <div class="container">
            <div class="breadcrumbs">
                <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel--centered">
                        <h3>
                            <?php echo Labels::getLabel('LBL_SITEMAP',$siteLangId);?>
                        </h3>
                        <div class="sitemapcontainer">

 




                            <?php  if(!empty($contentPages)){ ?>
                            <h2>
                                <?php echo Labels::getLabel('LBL_CONTENT_PAGES',$siteLangId);?>
                            </h2>
                            <div class="box box--white  p-4">
                                <div class="site-map-list">

                                    <ul>
                                        <?php
                        foreach($contentPages as $contentId=> $contentPageName){
                        ?>
                                            <li>
                                                <a href="<?php echo CommonHelper::generateUrl('cms','view',array($contentId));?>">
                                                    <?php echo $contentPageName;?>
                                                </a>
                                            </li>

                                            <?php }?>
                                    </ul>

                                </div>
                            </div>
                            <?php
			}
			if($categoriesArr){
			?>

                            <h2>
                                <?php echo Labels::getLabel('LBL_Categories', $siteLangId);?>
                            </h2>
                            <div class="box box--white  p-4">
                                <div class="site-map-list">
                                    <?php $this->includeTemplate('_partial/custom/categories-list.php',array('categoriesArr'=>$categoriesArr),false);?>

                                </div>
                            </div>

                            <?php

			}
			if(!empty($allShops)){ ?>

                                <h2>
                                    <?php echo Labels::getLabel('LBL_Shops',$siteLangId);?>
                                </h2>
                                <div class="box box--white  p-4">
   <div class="site-map-list">
                                    <ul>
                                        <?php foreach($allShops as $shop){
					?>
                                        <li>
                                            <a href="<?php echo CommonHelper::generateUrl('Shops','view',array($shop['shop_id']));?>">
                                                <?php echo $shop['shop_name'];?>
                                            </a>
                                        </li>
                                        <?php }?>
                                    </ul>
                                    </div>

                                </div>
                                <?php
				}
				
			if(!empty($allBrands)){ ?>
                                   
                                    <h2>
                                        <?php echo Labels::getLabel('LBL_Brands',$siteLangId);?>
                                    </h2>
                                    <div class="box box--white  p-4">
   <div class="site-map-list">
                                        <ul>
                                            <?php foreach($allBrands as $brands){
					?>
                                            <li>
                                                <a href="<?php echo CommonHelper::generateUrl('Brands','view',array($brands['brand_id']));?>">
                                                    <?php echo $brands['brand_name'];?>
                                                </a>
                                            </li>
                                            <?php }?>
                                        </ul>
                                        </div>

                                    </div>
                                    <?php
				}
				?>
                        </div>










                       





                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="gap"></div>
</div>
