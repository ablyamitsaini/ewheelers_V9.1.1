<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div id="body" class="body" role="main">
 
   
    <div class="section section--pagebar">
      <div class="container container--fixed">
        <div class="row align-items-center">
          <div class="col-md-8 col-sm-8">
                <h1><?php echo Labels::getLabel('LBL_Shopping_Cart', $siteLangId); ?></h2></h1>
                
          </div>
          <div class="col-md-4 col-sm-4 align--right"><a href="javascript:void(0)" onclick="cart.remove('all','cart')" class="btn btn--primary-border"><?php echo Labels::getLabel('LBL_Empty_Cart', $siteLangId); ?></a></div>
        </div>
      </div>
    </div>
   
    <section class="section">
		<div class="container" id="cartList"></div>
	</section>
	<div class="gap"></div>
</div>
