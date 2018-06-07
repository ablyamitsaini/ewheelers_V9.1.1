<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<script type="text/javascript">
var  productId  =  <?php echo $productId ;?>
</script>
<div id="body" class="body bg--gray">
    <section class="top-space">
		<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
		<div class="fixed-container">
			<div class="cols--group">
				<div class="panel__head">
					<h2><?php echo Labels::getLabel('LBL_Product_Setup',$siteLangId); ?></h2>
				</div>
				<div class="panel__body">
					<div class="box box--white box--space box--height">
						<div id="listing">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="gap"></div>
</div>