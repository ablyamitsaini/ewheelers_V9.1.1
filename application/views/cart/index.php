<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body bg-gray-dark" role="main">
	<section class="section section--fill">
		<div class="container">
			<div class="section-head section--white--head section--head--center">
				<div class="section__heading">
					<h2><?php echo Labels::getLabel('LBL_My_Shopping_Cart', $siteLangId); ?></h2>
				</div>
			</div>
		</div>
	</section>
    <section class="section">
		<div class="container" id="cartList"></div>
	</section>
	<div class="gap"></div>
</div>
