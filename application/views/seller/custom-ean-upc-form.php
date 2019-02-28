<?php require_once(CONF_THEME_PATH.'_partial/seller/customCatalogProductNavigationLinks.php'); ?>  
	<div class="box__body">		
			<div class="tabs tabs--small   tabs--scroll clearfix">
				<?php require_once(CONF_THEME_PATH.'seller/seller-custom-catalog-product-top.php');?>
			</div>
			<div class="tabs__content form">
		
				<div class="form__content">
					<div class="col-md-12">
						 
							<div class="tabs tabs-sm tabs--scroll clearfix">
								<ul>
									<li ><a onClick="customCatalogProductForm(<?php echo $preqId;?>,<?php echo $preqCatId;?>)" href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Basic', $siteLangId );?></a></li>
									<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a  <?php echo ($preqId) ? "onclick='customCatalogSellerProductForm( ".$preqId." );'" : ""; ?> href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Inventory/Info', $siteLangId );?></a></li>
									<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a  <?php echo ($preqId) ? "onclick='customCatalogSpecifications( ".$preqId." );'" : ""; ?> href="javascript:void(0);"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId );?></a></li>
									<?php foreach($languages as $langId=>$langName){?>
									<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a href="javascript:void(0);" <?php echo ($preqId) ? "onclick='customCatalogProductLangForm( ".$preqId.",".$langId." );'" : ""; ?>><?php echo $langName;?></a></li>									
									<?php } ?>
									<li class="is-active"><a  <?php echo ($preqId) ? "onclick='customEanUpcForm( ".$preqId." );'" : ""; ?> href="javascript:void(0);"><?php echo Labels::getLabel('LBL_EAN/UPC_setup', $siteLangId );?></a></li>
									<li class="<?php echo (!$preqId) ? 'fat-inactive' : ''; ?>"><a href="javascript:void(0);" <?php echo ($preqId) ? "onclick='customCatalogProductImages( ".$preqId." );'" : ""; ?>><?php echo Labels::getLabel('Lbl_Product_Images',$siteLangId);?></a></li>
								</ul>	
							</div>
					 
						<div class="form__subcontent">
						<?php if(!empty($productOptions)){?>
						<form name="upcFrm" onSubmit="setupEanUpcCode(<?php echo $preqId;?>,this); return(false);">
						<table width="100%" class="table table-responsive" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th><?php echo Labels::getLabel('LBL_Sr.',$siteLangId);?></th>
									<?php 
									foreach($productOptions as $option){
										echo "<th>".$option['option_name']."</th>";
									}
									?>
									<th><?php echo Labels::getLabel('LBL_EAN/UPC_code',$siteLangId);?></th></tr>
									<?php 
									$arr  = array();
									$count = 0;												
									foreach($optionCombinations as $optionValueId=>$optionValue){
										$count++;
										$arr = explode('|',$optionValue);
										$key = str_replace('|',',',$optionValueId);
									?>
									<tr>
										<td><?php echo $count;?></td>							
										<?php 							
										foreach($arr as $val){	
											echo "<td>".$val."</td>";							
										}
										?>
										<td><input type="text" id="code<?php echo $optionValueId?>" name="code<?php echo $optionValueId?>" value="<?php echo (isset($upcCodeData[$optionValueId]))?$upcCodeData[$optionValueId]:'';?>" onBlur="validateEanUpcCode(this.value)"></td>
									</tr>
									<?php }?>	
								<tr>
									<td></td>
									<td colspan="<?php echo count($arr);?>"></td>
									<td><input type="submit" name="submit" value="<?php echo Labels::getLabel('LBL_Update',$siteLangId);?>"></td>
								</tr>
							</thead>
						</table>
						</form>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
</div>