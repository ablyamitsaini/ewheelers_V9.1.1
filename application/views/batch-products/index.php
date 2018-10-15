<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>  
<div class="panel panel--dashboard">
	<div class="container container--fixed">
		<div class="row">
			<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>                                 
			<div class="col-xs-10 panel__right--full ">
				<div class="cols--group">
					<div class="panel__head">
						<h2><?php echo Labels::getLabel('LBL_Batch_Products',$siteLangId); ?></h2>
					</div>
					<div class="panel__body">
						<div class="box box--white box--space">
							<div class="box__head box__head--large">
								<h4><?php echo Labels::getLabel('LBL_Batch_Listing',$siteLangId); ?></h4>
								<div class="group--btns">
									<a href="javascript:void(0)" class="btn btn--primary btn--sm" title="<?php echo Labels::getLabel('LBL_Add/Create_New_Batch', $siteLangId); ?>" onclick="batchForm(0)"><?php echo Labels::getLabel('LBL_Add/Create_New_Batch', $siteLangId); ?> </a>
								</div>
								<?php /* if($product_id){ ?>
								<div class="group--btns">
								<a href="javascript:void(0);" onClick="sellerProductForm(<?php echo $product_id; ?>,0);" class = "btn btn--primary btn--sm"><?php echo Labels::getLabel( 'LBL_Add_New_Product', $siteLangId);?></a>
								<a href="<?php echo CommonHelper::generateUrl('seller','catalog');?>" class = "btn btn--secondary btn--sm"><?php echo Labels::getLabel( 'LBL_Back', $siteLangId)?></a>
								</div>
								<?php } */ ?>	
							</div>
							<div class="box__body">
								<div class="form__cover">
									<div class="search search--sort">
										<div class="search__field">
											<?php
											$frmSearch->setFormTagAttribute ( 'id', 'frmSearch' );
											$frmSearch->setFormTagAttribute( 'onsubmit', 'searchBatches(this); return(false);' );
											//$frmSearch->setFormTagAttribute( 'placeholder', 'dsdsd' );
											$fldKeyword = $frmSearch->getField('keyword');
											$fldKeyword->setFieldTagAttribute( 'placeholder', Labels::getLabel('LBL_Search', $siteLangId) );
											echo $frmSearch->getFormTag();
											echo $frmSearch->getFieldHtml('keyword');
											echo $frmSearch->getFieldHtml('page');
											echo $frmSearch->getFieldHtml('btn_submit'); ?>  
											<i class="fa fa-search"></i>
											</form>
										</div>
									</div>
								</div>
								<span class="gap"></span>
								<?php //echo $frmSearch->getExternalJS();	?>
								<div id="listing"> 
									<?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?>
								</div> 									
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>