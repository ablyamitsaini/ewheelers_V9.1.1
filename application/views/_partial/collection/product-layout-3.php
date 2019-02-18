<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset( $collections ) && count($collections) ){

	$counter = 1;

	foreach( $collections as $collection_id => $row ){ ?>
<?php if( isset($row['products']) && count($row['products']) ) {
	?>

<section class="section bg--second-color">
	<div class="container">
		<div class="section-head section--white--head">
			<div class="section__heading">
				<h2><?php echo ($row['collection_name'] != '') ? ' <div class="section_heading">' . $row['collection_name'] .'</div>' : ''; ?></h2>
			</div>
			<?php if( count($row['products']) > Collections::LIMIT_PRODUCT_LAYOUT3 ){ ?>
				<div class="section__action"><a href="<?php echo CommonHelper::generateUrl('Collections','View',array($row['collection_id']));?>" class="link"><?php echo Labels::getLabel('LBL_View_More',$siteLangId); ?></a> </div>
			<?php }  ?>
		</div>
		<div class="row collection-corner js-collection-corner" dir="<?php echo CommonHelper::getLayoutDirection();?>">
			<?php foreach( $row['products'] as $product ){ ?>
			<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
				<?php include('product-layout-1-list.php'); ?>
			</div>
			<?php } ?>
		</div>
	</div>
</section>

<?php } ?>
<?php $counter++; }
} ?>
