<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset( $collections ) && count($collections) ){

	$counter = 1;

	foreach( $collections as $collection_id => $row ){ ?>
<?php if( isset($row['products']) && count($row['products']) ) {
	?>

<section class="section">
	<div class="container">
		<div class="section-head">
			<div class="section__heading">
				<h2><?php echo ($row['collection_name'] != '') ?  $row['collection_name'] : ''; ?></h2>
			</div>
			<?php if( count($row['products']) > Collections::LIMIT_PRODUCT_LAYOUT2 ){ ?>
				<div class="section__action"><a href="<?php echo CommonHelper::generateUrl('Collections','View',array($row['collection_id']));?>" class="link"><?php echo Labels::getLabel('LBL_View_More',$siteLangId); ?></a> </div>
			<?php }  ?>
		</div>
		<div class="ft-products">
			<div class="row">
				<?php foreach( $row['products'] as $product ){ ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<?php $layoutClass = 'products--layout'; include('product-layout-1-list.php'); ?>
				</div> 
				<?php } ?>
			</div>
		</div>
	</div>
</section>

<?php } ?>
<?php $counter++; }
} ?>
