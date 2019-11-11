<div class='page'>
    <div class='container container-fluid'>
        <div class="row">
            <div class="col-lg-12 col-md-12 space">
                <div class="page__title">
                    <div class="row">
                        <div class="col--first col-lg-12">
                            <span class="page__icon">
							<i class="ion-android-star"></i></span>
                            <h5><?php echo Labels::getLabel('LBL_Test_Drive_Management',$adminLangId); ?> </h5>
                            <?php $this->includeTemplate('_partial/header/header-breadcrumb.php'); ?>
                        </div>
					</div>
				</div>
				<div class="tabs_nav_container vertical">
					<ul class="tabs_nav outerul"> 
						<li><a class="default" rel="tabs_1" href="javascript:void(0)" onClick="getSettings()"><?php echo Labels::getLabel('LBL_Settings',$adminLangId); ?></a></li>	
						<li><a class="" rel="tabs_2" href="javascript:void(0)" onClick="getSlabRates()"><?php echo Labels::getLabel('LBL_Seller_Credit_Slab_Rates',$adminLangId); ?></a></li>
							
					</ul>

					<div class="tabs_panel_wrap">
						<div class="tabs_nav_container" id="frmBlock"> 
						</div>
					</div>
				</div>
				</div>
		</div>
	</div>
</div>
	
