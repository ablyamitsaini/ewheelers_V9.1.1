<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<?php 	$variables= array( 'language'=>$language,'siteLangId'=>$siteLangId,'shop_id'=>$shop_id , 'action' => $action) ;

	$this->includeTemplate('seller/_partial/shop-navigation.php',$variables,false); ?>
<div class="tabs__content">                                               
	<div class="form__content ">
		<div class="row ">
			<div class="col-md-12" id="shopFormChildBlock">
				<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
			</div>
		</div>
	</div>
</div>

