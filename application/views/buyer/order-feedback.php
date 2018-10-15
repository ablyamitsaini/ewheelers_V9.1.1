<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute( 'class', 'form form--horizontal web_form' );
$frm->setFormTagAttribute('action', CommonHelper::generateUrl('Buyer','setupOrderFeedback'));
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;

/* var_dump($this->variables);
exit; */
?>
<div id="body" class="body bg--gray">
    <section class="dashboard">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
		<div class="container container--fixed">
			<div class="row">
				<?php $this->includeTemplate('_partial/dashboardNavigation.php'); ?>
				<div class="col-xs-10 panel__right--full" >
					<div class="cols--group">
						<div class="panel__head">
							<h2><?php echo Labels::getLabel('LBL_Order_Feedback', $siteLangId); ?></h2>
						</div>
						<div class="panel__body">
							<div class="box box--white box--space">
								<div class="box__head">
									<h6><?php echo Labels::getLabel('LBL_Product',$siteLangId),' : ',(!empty($opDetail['op_selprod_title']) ? $opDetail['op_selprod_title'] : $opDetail['op_product_name']) ,' | ', Labels::getLabel('LBL_Shop',$siteLangId),' : ', $opDetail['op_shop_name'] ; ?></h6>
								</div>
								<div class="box__body">
									<?php echo $frm->getFormHtml(); ?>
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
<script type="text/javascript">
	$(document).ready(function () {
		$('.star-rating').barrating({ showSelectedRating:false });
	});
</script>
