<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
$currencySymbolLeft = isset($currencySymbolLeft) ? $currencySymbolLeft : CommonHelper::getCurrencySymbolLeft(); 
$currencySymbolRight = isset($currencySymbolRight) ? $currencySymbolRight : CommonHelper::getCurrencySymbolRight(); 

if( !empty($priceArr) ){
	$priceArr = array_map( function( $item ){ return CommonHelper::displayMoneyFormat( $item, false, false ,false ); } , $priceArr );
}

 $catCodeArr = array();
 
 if(isset($prodcat_code)){ 
$currentCategoryCode= substr($prodcat_code,0,-1);
$catCodeArr =  explode("_",$currentCategoryCode);
array_walk($catCodeArr,function(&$n) {
 $n = FatUtility::int($n);
}) ;
 }
?>
<?php /* CommonHelper::printArray($conditionsArr); */ ?>
<div id="fixed__panel" class="filter section__filter fixed__panel">
   <!--Filters[ -->
  <div class="widgets filter-search">
	<div class="widgets-head">
	  <div class="heading4"><?php echo Labels::getLabel('LBL_FILTERS',$siteLangId);?>  <a  class="btn btn--link action ripplelink" id="resetAll"><?php echo Labels::getLabel('LBL_RESET_ALL',$siteLangId);?></a></div>
	</div>
	<div class="selected-filters" id="filters"> </div>
  </div>
  <div class="divider"></div>
  <!-- ] -->
  
  <!--Categories Filters[ resetAll-->
  
 
  <?php 
  if( isset( $categoriesArr ) && $categoriesArr ){ ?>
  <div class="widgets-heading"><?php echo Labels::getLabel('LBL_Categories',$siteLangId);?> </div>
 <?php if( !isset( $shopCatFilters ) ){ ?>
  <div id="accordian" class="cat-accordion toggle-target scrollbar">
	<ul class="">
		<?php foreach( $categoriesArr as $cat ){
			$catUrl = CommonHelper::generateUrl('category','view', array($cat['prodcat_id'])); ?>			
			<li>
				<?php if( count($cat['children']) > 0 ){ echo '<span class="acc-trigger"></span>'; } ?>
				<a class="filter_categories" data-id = "<?php echo $cat['prodcat_id']; ?>" href="<?php echo $catUrl; ?>"><?php echo $cat['prodcat_name']; ?></a>
				<?php if( count($cat['children']) > 0 ){
					echo '<ul>';
					foreach( $cat['children'] as $children ){ ?>
						<li>
							<?php if( isset($children['children']) && count($children['children']) > 0 ){ echo '<span class="acc-trigger"></span>'; } ?>
							<a class="filter_categories" data-id = "<?php echo $children['prodcat_id']; ?>" href="<?php echo CommonHelper::generateUrl('category','view',array($children['prodcat_id'])); ?>"><?php echo $children['prodcat_name']; ?></a>
							
							<?php if( isset($children['children']) && count($children['children']) > 0 ){
								echo '<ul>';
								foreach( $children['children'] as $subChildren ){ ?>
								<li>
									<?php if( isset($subChildren['children']) && count($subChildren['children']) > 0 ){ echo '<span class="acc-trigger"></span>'; } ?>
									<a class="filter_categories" data-id = "<?php echo $subChildren['prodcat_id']; ?>" href="<?php echo CommonHelper::generateUrl('category','view',array($subChildren['prodcat_id'])); ?>"><?php echo $subChildren['prodcat_name']; ?></a>
									
									<?php if( isset($subChildren['children']) && count($subChildren['children']) > 0 ){
										echo '<ul>';
										foreach( $subChildren['children'] as $subSubChildren ){ ?>
										
										<li>
											<?php if(  isset($subSubChildren['children']) && count($subSubChildren['children']) > 0 ){ echo '<span class="acc-trigger"></span>'; } ?>
											<a class="filter_categories" data-id = "<?php echo $subSubChildren['prodcat_id']; ?>" href="<?php echo CommonHelper::generateUrl('category','view',array($subSubChildren['prodcat_id'])); ?>"><?php echo $subSubChildren['prodcat_name']; ?></a>
										</li>
										<?php	
										}
										echo '</ul>';
									 } ?>
								</li>
								<?php
								}
								echo '</ul>';
							} ?>
						</li>
						<?php
					}
					echo '</ul>';
				} ?>
				
			</li>
		<?php } ?>
	  <?php /* foreach( $categoriesArr as $cat ){
			//$cat['children'] = array(); 
			$catUrl = CommonHelper::generateUrl('category','view', array($cat['prodcat_id']));
			//$catUrl = 'javascript:void(0)';
			?>
		<li> <a class="filter_categories" data-id = "<?php echo $cat['prodcat_id']; ?>" <?php if( count($cat['children']) == 0 ){ ?> href="<?php echo $catUrl; ?>" <?php } ?>><?php echo $cat['prodcat_name']; ?></a>
		<?php if( count($cat['children']) ){ ?>
		<ul>
		<?php foreach($cat['children'] as $children){ 
			$catUrl = CommonHelper::generateUrl('category','view',array($children['prodcat_id'])); 
			//$catUrl = 'javascript:void(0)';
			?>
		  <li> <a <?php if( count($children['children']) == 0 ){ ?> href="<?php echo $catUrl; ?>" <?php }?>><?php echo $children['prodcat_name']; ?></a>
			<?php if(count($children['children'])){ ?>
			<ul>
			<?php foreach($children['children'] as $subChildren){ 
				$catUrl = CommonHelper::generateUrl('category','view',array($subChildren['prodcat_id'])); 
				//$catUrl = 'javascript:void(0)';
				?>
			  <li> <a <?php if(count($subChildren['children']) == 0) { ?> href="<?php echo $catUrl; ?>" <?php }?>><?php echo $subChildren['prodcat_name']; ?></a>
				<ul>
				<?php if(count($subChildren['children'])) { 
				$catUrl = CommonHelper::generateUrl('category','view',array($subSubChildren['prodcat_id'])); 
				//$catUrl = 'javascript:void(0)';
				?>
				<?php foreach($subChildren['children'] as $subSubChildren){ ?>
				<li><a href="<?php echo $catUrl; ?>"><?php echo $subSubChildren['prodcat_name']; ?> </a></li>
				<?php } ?>
				<?php }?>
				</ul>
			  </li>
			<?php } ?>
			</ul>
			<?php } ?>
		  </li>
		<?php } ?>
		</ul>
		<?php } ?>
	  </li>
	  <?php } */ ?>
	</ul>
	<!--<a onClick="alert('Pending')" class="btn btn--link ripplelink"><?php echo Labels::getLabel('LBL_View_more', $siteLangId); ?> </a> -->
   </div>
  <?php }else{
	  
	  //Work in Progress
	  ?>
	  
	  <div class="brands-list toggle-target scrollbar">
	<ul>
		<?php 
	
		
		$seprator = '&raquo;&raquo;&nbsp;&nbsp;';
		foreach($categoriesArr as $cat){
		//	var_dump($cat);
			$catName= $cat['prodcat_name'];
			$productCatCode = explode("_",$cat['prodcat_code']);
			$productCatName = '';
			$seprator = '';
			foreach($productCatCode as $code){
				$code = FatUtility::int($code);
				if($code){
					if(isset( $productCategories[$code]['prodcat_name'])){						
						$productCatName.= $seprator. $productCategories[$code]['prodcat_name'];
						$seprator = '&raquo;&raquo;&nbsp;&nbsp;';
					}
				}
			}?>
			<li>
				<label class="checkbox brand" id="prodcat_<?php echo $cat['prodcat_id']; ?>"><input name="category" value="<?php echo $cat['prodcat_id']; ?>" type="checkbox" ><i class="input-helper"></i><?php echo $productCatName; ?></label></a>
			</li>
			
	<?php } ?>
	</ul>
	<!--<a onClick="alert('Pending')" class="btn btn--link ripplelink"><?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?> </a> -->
	</div>
	  
	  <?php
		}?>
   <div class="divider"></div>
 <?php }
  ?>
  <!-- ] -->
  
  <!--Price Filters[ -->
  <?php if( isset($priceArr) && $priceArr ){ ?>
    <div class="widgets-heading"><?php echo Labels::getLabel('LBL_Price', $siteLangId).' ('.(CommonHelper::getCurrencySymbolRight()?CommonHelper::getCurrencySymbolRight():CommonHelper::getCurrencySymbolLeft()).')'; ?> </div>
	  <div class="filter-content toggle-target">
		<div class="prices " id="perform_price">
			<input type="text" value="<?php echo floor($priceArr['minPrice']); ?>-<?php echo ceil($priceArr['maxPrice']); ?>" name="price_range" id="price_range" />
			<input type="hidden" value="<?php echo floor($priceArr['minPrice']); ?>" name="price_min_range" id="price_min_range" />
			<input type="hidden" value="<?php echo ceil($priceArr['maxPrice']); ?>" name="price_max_range" id="price_max_range" />
		</div>
		<div class="clear"></div>
		<div class="slide__fields form">
			<div class="price-input">
			  <div class="price-text-box">
				<input class="input-filter form-control " value="<?php echo floor($priceArr['minPrice']); ?>" name="priceFilterMinValue" type="text">
				<span class="rsText"><?php echo CommonHelper::getCurrencySymbolRight()?CommonHelper::getCurrencySymbolRight():CommonHelper::getCurrencySymbolLeft();?></span> </div>
			</div>
			<span class="dash"> - </span>
			<div class="price-input">
			  <div class="price-text-box">
				<input value="<?php echo ceil($priceArr['maxPrice']); ?>" class="input-filter form-control " name="priceFilterMaxValue" type="text">
				<span class="rsText"><?php echo CommonHelper::getCurrencySymbolRight()?CommonHelper::getCurrencySymbolRight():CommonHelper::getCurrencySymbolLeft(); ?></span> </div>
			</div>
		</div>
		<!--<input value="GO" class="btn " name="toVal" type="submit">-->
	  </div>
	<div class="divider"></div>
	<?php } ?>
	<!-- ] -->
	
	
	<!--Brand Filters[ -->
    <?php if(isset($brandsArr) && $brandsArr){ 
	 $brandsCheckedArr = (isset($brandsCheckedArr) && !empty($brandsCheckedArr))? $brandsCheckedArr : array();
	?>
	<div class="widgets-heading"><?php echo Labels::getLabel('LBL_Brand', $siteLangId); ?></div>
	<div class="brands-list toggle-target scrollbar">
	<ul>
		<?php foreach($brandsArr as $brand){ ?>
		<li><label class="checkbox brand" id="brand_<?php echo $brand['brand_id']; ?>"><input name="brands" value="<?php echo $brand['brand_id']; ?>" type="checkbox" <?php if(in_array($brand['brand_id'],$brandsCheckedArr)){ echo "checked='true'";}?>><i class="input-helper"></i><?php echo $brand['brand_name']; ?> </label></li>
		<?php } ?>
	</ul>
	<!--<a onClick="alert('Pending')" class="btn btn--link ripplelink"><?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?> </a> -->
	</div>
	<div class="divider"></div>
	<?php }?>
	<!-- ] -->
	
	<!-- Option Filters[ -->
	<?php 
		$optionIds = array();
		$optionValueCheckedArr = (isset($optionValueCheckedArr) && !empty($optionValueCheckedArr))? $optionValueCheckedArr : array();
		
		if(isset($options) && $options){ 
		function sortByOrder($a, $b) {
			return $a['option_id'] - $b['option_id'];
		}
		
		usort($options, 'sortByOrder');	
		$optionName = '';
		$liData = '';
		
		foreach( $options as $optionRow ){
			if( $optionName != $optionRow['option_name'] ){ 
				if($optionName!=''){
					echo "</ul></div><div class='divider'></div>";
				}
				$optionName = $optionRow['option_name'];?>
				<div class="widgets-heading"><?php echo $optionRow['option_name']; ?></div>
				<div class="brands-list toggle-target scrollbar">
				<ul><?php
			}	
			$optionValueId = $optionRow['option_id'].'_'.$optionRow['optionvalue_id'];	
				//$liData.= "<li>".$optionRow['optionvalue_name']."</li>"; 				
			?>
				<li><label class="checkbox optionvalue" id="optionvalue_<?php echo $optionRow['optionvalue_id']; ?>"><input name="optionvalues" value="<?php echo $optionValueId; ?>" type="checkbox" <?php if(in_array($optionValueId,$optionValueCheckedArr)){ echo "checked='true'";}?>><i class="input-helper"></i><?php echo $optionRow['optionvalue_name'];?> </label></li>			
			
		<?php }
			echo "</ul></div>
			<div class='divider'></div>";
		}?>
	<!-- ]->
	
	<!--Condition Filters[ -->
	
	<?php if( isset($conditionsArr) && $conditionsArr ){ 
	$conditionsCheckedArr = (isset($conditionsCheckedArr) && !empty($conditionsCheckedArr))? $conditionsCheckedArr : array();
	?>
	<div class="widgets">
		<div class="widgets-heading"><?php echo Labels::getLabel('LBL_Condition', $siteLangId); ?></div>
		<div class="selected-filters toggle-target">
			<ul class="listing--vertical listing--vertical-chcek">
			<?php foreach($conditionsArr as $condition){ if($condition['selprod_condition']==0) continue; ?>
			<li><label class="checkbox condition" id="condition_<?php echo $condition['selprod_condition']; ?>"><input value="<?php echo $condition['selprod_condition']; ?>" name="conditions" type="checkbox" <?php if(in_array($condition['selprod_condition'],$conditionsCheckedArr)){ echo "checked='true'";}?>><i class="input-helper"></i><?php echo Product::getConditionArr($siteLangId)[$condition['selprod_condition']]; ?> </label></li>
			<?php } ?>
			</ul>
		</div>
	</div>
	<div class="divider"></div>
	<?php } ?>
	<!-- ] -->
	
	<!--Availability Filters[ -->
	<?php $availability = isset($availability)?$availability:0;?>
	<div class="widgets ">
		<div class="widgets-heading"><?php echo Labels::getLabel('LBL_Availability', $siteLangId);?></div>
		<div class="selected-filters toggle-target">
			<ul class="listing--vertical listing--vertical-chcek">
			<li><label class="checkbox availability" id="availability_1"><input name="out_of_stock" value="1" type="checkbox" <?php if($availability == 1){ echo "checked='true'";}?>><i class="input-helper"></i><?php echo Labels::getLabel('LBL_Exclude_out_of_stock', $siteLangId); ?> </label></li>
			</ul>
		</div>
	</div>
	<div class="divider "></div>
	<!-- ] -->
	
</div>
	
	
<!--Shipping Filters[ -->
<!--<div class="widgets">
	<div class="widgets-head"><h6>Shipping </h6></div>
	<div class="selected-filters">
		<ul class="listing--vertical listing--vertical-chcek">
		<li><label class="checkbox"><input name="free_shipping" type="checkbox"><i class="input-helper"></i>Free </label></li>
		</ul>
	</div>
</div>-->
<!-- ] -->
 <script language="javascript">
  var catCodeArr = <?php echo json_encode($catCodeArr); ?>;
	$.each( catCodeArr, function( key, value ) {
		if($("ul li a[data-id='" + value +"']").parent().find('span')){
			$("ul li a[data-id='" + value +"']").parent().find('span:first').addClass('is--active');
			$("ul li a[data-id='" + value +"']").parent().find('ul:first').css('display','block');
		}
	  
	});
  </script>

<script type="text/javascript">
$("document").ready(function(){
	var min=0;
	var max=0;
	<?php if( isset($priceArr) && $priceArr ){ ?>
	var range,
	min = Math.floor(<?php echo $priceArr['minPrice']; ?>),
    max = Math.floor(<?php echo $priceArr['maxPrice']; ?>),
    from  = Math.floor(<?php echo $priceArr['minPrice']; ?>),
    to = Math.floor(<?php echo $priceArr['maxPrice']; ?>);
	var $from = $('input[name="priceFilterMinValue"]');
	var $to = $('input[name="priceFilterMaxValue"]');
	var $range = $("#price_range");
	var updateValues = function () {
		$from.prop("value", from);
		$to.prop("value", to);
	};
	$(document.frmProductSearch).append('<input type="hidden" id="old-min-value" name="old-min-value" value='+<?php echo $priceArr['minPrice']; ?>+' />');
	$(document.frmProductSearch).append('<input type="hidden" id="old-max-value" name="old-max-value" value='+<?php echo $priceArr['maxPrice']; ?>+' />');
	$("#price_range").ionRangeSlider({
		hide_min_max: true,
		hide_from_to: true,
		keyboard: true,
		min: min,
		max: max,
		from: min,
		to: max,
		type: 'double',
		prettify_enabled: true,
		prettify_separator: ',',
		grid: false,
		// grid_num: 1,
		prefix: "<?php echo $currencySymbolLeft; ?>",
		postfix: "<?php echo $currencySymbolRight; ?>",
		
		input_values_separator: '-',
		onFinish: function () {
			
			var minMaxArr = $("#price_range").val().split('-');
			if(minMaxArr.length == 2){
				var min = Number(minMaxArr[0]);
				var max = Number(minMaxArr[1]);
				$('input[name="priceFilterMinValue"]').val(min);
				$('input[name="priceFilterMaxValue"]').val(max);
				return addPricefilter();
			}

		},
		onChange: function (data) {
			from = data.from;
			to = data.to;
			updateValues();
			
		}
	});


range = $range.data("ionRangeSlider");

var updateRange = function () {
    range.update({
        from: from,
        to: to
    });
	addPricefilter();
};

$from.on("change", function () {
    from = $(this).prop("value");
	if(!$.isNumeric(from)){
		from = 0;
	}
    if (from < min) {
        from = min;
    }
    if (from > max) {
        from = max;
    }

    updateValues();    
    updateRange();
});

$to.on("change", function () {
	
    to = $(this).prop("value");
	if(!$.isNumeric(to)){
		to = 0;
	}
    if (to > max) {
        to = max;
    }
    if (to < min) {
        to = min;
    }

    updateValues();    
    updateRange();
});

<?php } ?>
	
	/* left side filters scroll bar[ */
	<?php /* if( isset($brandsArr) && $brandsArr && count($brandsArr) > 5 ){ */
	/* code is here, becoz brands section has defined height, and looking bad when there are less brands in the box, so, added this to avoid height */
	?>
	if($(window).width()>1050){
		$('.scrollbar').enscroll({
			verticalTrackClass: 'scroll__track',
			verticalHandleClass: 'scroll__handle'
		});
	}
	<?php /* } */ ?>
	/* ] */
	
	/* left side filters expand-collapse functionality [ */
	$('.span--expand').bind('click',function(){
		$(this).parent('li.level').toggleClass('is-active');
		$(this).toggleClass('is--active');
		$(this).next('ul').toggle("");
	});
	$('.span--expand').click();
	/* ] */
});

/*  $(window).load(function(){
	$('#accordian').viewMore({limit: <?php echo intval($count_for_view_more); ?>});
 }); */
</script>