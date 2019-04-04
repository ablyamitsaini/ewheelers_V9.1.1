<?php
if(isset($shippingDetails['ps_free']) && $shippingDetails['ps_free']==applicationConstants::YES){
	echo '<div class="gap"></div><div class="">'.Labels::getLabel('LBL_This_product_is_available_for_free_shipping',$siteLangId).'</div>';
}else if(count($shippingRates)>0){?>
<div class="delivery-term">
	<div class=""> <p class="note"><?php echo Labels::getLabel('LBL_Shipping_Policies',$siteLangId);?>
		<a href="#shipRates" rel="facebox" ><i class="fa fa-question-circle"></i></a></p>
		<div id= "shipRates" style="display:none">
			  <div class="delivery-term-data-inner">
			<?php

			$arr_flds = array(
				'country_name'=> Labels::getLabel('LBL_Ship_to',$siteLangId),
				'pship_charges'=> Labels::getLabel('LBL_Cost',$siteLangId),
				'pship_additional_charges'=> Labels::getLabel('LBL_With_Another_item',$siteLangId),
			);
			$tbl = new HtmlElement('table', array('width'=>'100%', 'class'=>'table'));
			$th = $tbl->appendElement('thead')->appendElement('tr');
			foreach ($arr_flds as $val) {
				$e = $th->appendElement('th', array(), $val);
			}

			foreach ($shippingRates as $sn=>$row){


				$tr = $tbl->appendElement('tr');

				foreach ($arr_flds as $key=>$val){
					$td = $tr->appendElement('td');
					switch ($key){
						case 'pship_additional_charges':
							$td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key]));
							break;
						case 'pship_charges':
							$td->appendElement('plaintext', array(), CommonHelper::displayMoneyFormat($row[$key]));
							break;
						case 'country_name':

							$td->appendElement('plaintext', array(), Product::getProductShippingTitle($row,$siteLangId),true);
							break;
						default:
							$td->appendElement('plaintext', array(), $row[$key], true);
						break;
					}
				}
			}
			echo $tbl->getHtml();
			?>
			</div>

		</div>
	</div>
</div>
<?php } ?>
