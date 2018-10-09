<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?> 						   
				<div class="col-xs-10 panel__right--full ">
					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('LBL_MY_Favorites',$siteLangId);?></h2>						   
						</div>					   
						<div class="panel__body">                            
							<div class="box box--white box--space">
								<div class="box__head"><h4><?php echo Labels::getLabel('LBL_MY_Favorites',$siteLangId);?></h4></div>
								<div class="box__body">
									<div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
										<ul>
											<li class="is-active" id="tab-wishlist"><a onClick="searchWishList();" href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Wishlist', $siteLangId); ?></a></li>
											<li id="tab-fav-shop"><a onClick="searchFavoriteShop();" href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Shops', $siteLangId); ?></a></li>
										</ul>
									</div>
									<div class="section__head" id="back-js">
										<h5><?php echo Labels::getLabel('LBL_Products_That_I_Love',$siteLangId);?></h5>
										<a class="btn btn--primary btn--sm btn--positioned" onClick="searchWishList();" href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Back', $siteLangId); ?></a>
									</div>
									<div class="" id="listingDiv"></div>
								</div>
								<div class="gap"></div>
								<div id="loadMoreBtnDiv"></div>
							</div>
						</div>  
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>
