<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="container">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full " >
					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('LBL_My_Promotions',$siteLangId) ?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__body">
								   <div class="tabs tabs--small tabs--offset tabs--scroll clearfix">
									   <?php if (!User::isAdvertiser()) { ?>
										<ul class="arrowTabs">
											<li><a href="<?php echo CommonHelper::generateUrl('account', 'promote_product')?>"><?php echo Labels::getLabel('LBL_Promote_Product',$siteLangId) ?></a></li>
											<li><a href="<?php echo CommonHelper::generateUrl('account', 'promote_shop')?>"><?php echo Labels::getLabel('LBL_Promote_Shop',$siteLangId) ?></a></li>
											<li class="active"><a href="<?php echo CommonHelper::generateUrl('account', 'promote_banner')?>"><?php echo Labels::getLabel('LBL_Promote_Banner',$siteLangId) ?></a></li>
										</ul>
									  <div class="fr right-elemnts"> <a href="<?php echo CommonHelper::generateUrl('account', 'promote')?>" class="btn small blue"><?php echo Labels::getLabel('LBL_Back_To_Promotions',$siteLangId) ?></a> </div>
									  <?php } else { ?>
										<ul class="arrowTabs">
											  <li><a href="<?php echo CommonHelper::generateUrl('account', 'promote')?>"><?php echo Labels::getLabel('LBL_Promotions_List',$siteLangId) ?></a></li>
											  <li class="active"><a href="javascript:void()" onclick="promotionGeneralForm(0)"><?php echo Labels::getLabel('LBL_Add_Promotion',$siteLangId) ?></a></li>
										</ul>
									  <?php } ?>
								  </div>
								  <div id="promotionFormBlock"> 
										<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
								  </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </section>
	<div class="gap"></div>
</div>
