<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>


<?php $this->includeTemplate('_partial/seller/sellerDashboardNavigation.php'); ?>
<main id="main-area" class="main" role="main">
 <div class="content-wrapper content-space">
	<div class="content-header row justify-content-between mb-3">
		<div class="col-md-auto">
			<?php $this->includeTemplate('_partial/dashboardTop.php'); ?>
			<h2 class="content-header-title"><?php echo Labels::getLabel('LBL_Tax_Categories',$siteLangId); ?></h2>
		</div>
	</div>
	<div class="content-body">
		<div class="cards">
			<div class="cards-header p-3">
				<h5 class="cards-title "><?php echo Labels::getLabel('LBL_Manage_Tax_Rates',$siteLangId); ?></h5>
			</div>
			<div class="cards-content p-3">
        <div class="form__cover">
           <div class="search search--sort">
             <div class="search__field">
               <?php
               $frmSearch->setFormTagAttribute ( 'id', 'frmSearchTaxCat' );
               $frmSearch->setFormTagAttribute( 'onsubmit', 'searchTaxCategories(this); return(false);' );
               $frmSearch->getField('keyword')->addFieldTagAttribute('placeholder',Labels::getLabel('LBL_Search' , $siteLangId));
               echo $frmSearch->getFormTag();
               echo $frmSearch->getFieldHtml('keyword');

               echo $frmSearch->getFieldHtml('btn_submit');?>
               <i class="fa fa-search"></i>
               </form>
             </div>
           </div>
         </div>
         <span class="gap"></span>
           <div id="listing"><?php echo Labels::getLabel('LBL_Loading..',$siteLangId); ?></div>
			</div>
		</div>
	</div>
  </div>
</main>
