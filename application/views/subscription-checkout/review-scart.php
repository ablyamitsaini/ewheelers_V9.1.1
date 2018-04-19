<?php defined('SYSTEM_INIT') or die('Invalid Usage.');


 ?>
<div class="section-head">1.<?php echo Labels::getLabel('LBL_Review_Subscription_Details', $siteLangId);?> </div>

   <div class="review-wrapper">
              <div class="short-detail">
                <table class="cart-summary item-yk">
                  <tbody>
				  <?php if( count($subscriptions) ){
					  foreach( $subscriptions as $subscription){?>
                    <tr>
                      <td class="text-left"><div class="item-yk-head">
                         <div class="item-yk-head-title"><a href="javascript:void(0)"><a href="javascript:void(0)"><?php echo $subscription['spackage_name'] ?>--<?php echo SellerPackagePlans::getPlanPriceWithPeriod($subscription,$subscription[SellerPackagePlans::DB_TBL_PREFIX.'price']);?><?php if($subscription[SellerPackagePlans::DB_TBL_PREFIX.'trial_interval']>0){?><span><?php /* echo SellerPackagePlans::getPlanTrialPeriod($subscription); */?></span><?php } ?></a></div>
                        </div></td>
                      <td class="text-right" ><div class="product_price"><?php echo CommonHelper::displayMoneyFormat($subscription[SellerPackagePlans::DB_TBL_PREFIX.'price']); ?> </div>
                       <a href="javascript:void(0)" onclick="subscription.remove('<?php echo md5($subscription['key']); ?>')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>" class="btn btn--sm btn--gray ripplelink"><?php echo Labels::getLabel('LBL_Remove',$siteLangId); ?></a></td>
                    </tr>
				  <?php }
				  } else{?>
				   <tr>
                      <td colspan="2" class="text-left">
                        <?php echo Labels::getLabel('LBL_Your_cart_is_empty', $siteLangId);?></td>
                    </tr>
				  <?php
				  }?> 
                  </tbody>
                </table>
              </div>
              <div class="cartdetail__footer">
                <table>
                  <tr>
                    <td class="text-left"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId);?></td>
                    <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($scartSummary['cartTotal']);?></td>
                  </tr>
                   <?php  if(!empty($scartSummary['cartAdjustableAmount'])){?>
						<tr>
                      <td class="text-left"><?php echo Labels::getLabel('LBL_Adjusted_Amount', $siteLangId); ?> </td>
                      <td class="text-right"><?php echo CommonHelper::displayMoneyFormat($scartSummary['cartAdjustableAmount']); ?></td>
                    </tr>
						<?php }?>
						<?php if(!empty($scartSummary['scartDiscounts'])){?>
				  <tr>
					<td class="text-left"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></td>
					<td class="text-right"><?php echo CommonHelper::displayMoneyFormat($scartSummary['scartDiscounts']['coupon_discount_total']); ?></td>
				  </tr>
				<?php } ?>
                  <tr>
                    <td class="text-left hightlighted"><?php echo Labels::getLabel('LBL_You_Pay', $siteLangId);?></td>
                    <td class="text-right hightlighted">    
					<?php echo $amount = CommonHelper::displayMoneyFormat($scartSummary['cartTotal']-$scartSummary['cartAdjustableAmount']-$scartSummary['scartDiscounts']['coupon_discount_total']);?></td>

					
                  </tr>
                  <tr>
                    <td></td>
					<?php if($amount>0){ 
						$paymentText=Labels::getLabel('LBL_Proceed_To_Pay', $siteLangId) ;
					}  
					else{
						$paymentText=Labels::getLabel('LBL_Proceed_To_Confirm', $siteLangId) ;
					}
					?>
                    <td class="text-right"><a href="javascript:void(0)" class="btn btn--secondary ripplelink block-on-mobile confirmReview"><?php echo $paymentText ;?></a></td>
					
				 </tr>
                </table>
              </div>
            </div>
          
  