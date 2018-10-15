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
									  <ul class="arrowTabs">
										<li><a href="<?php echo CommonHelper::generateUrl('account', 'promote_product')?>"><?php echo Labels::getLabel('LBL_Promote_Product',$siteLangId) ?></a></li>
										<li class="active"><a href="<?php echo CommonHelper::generateUrl('account', 'promote_shop')?>"><?php echo Labels::getLabel('LBL_Promote_Shop',$siteLangId) ?></a></li>
										<li><a href="<?php echo CommonHelper::generateUrl('account', 'promote_banner')?>"><?php echo Labels::getLabel('LBL_Promote_Banner',$siteLangId) ?></a></li>
									  </ul>
									</div>
								  <div class="fr right-elemnts"> <a href="<?php echo CommonHelper::generateUrl('account', 'promote')?>" class="btn small blue"><?php echo Labels::getLabel('LBL_Back_To_Promotions',$siteLangId) ?></a> </div>
								  <div class="space-lft-right">
									<div class="wrapform">
										<?php echo $frmPromote->getFormHtml(); ?>
									</div>
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
