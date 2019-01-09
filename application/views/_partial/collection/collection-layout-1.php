<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if( isset( $collections ) && count($collections) ){

	$counter = 1;

	foreach( $collections as $collection_id => $row ){ ?>
<?php if( isset($row['products']) && count($row['products']) ) {
	?>

<section class="padd40">
  <div class="container">
    <div class="section-head"> <?php echo ($row['collection_name'] != '') ? ' <div class="section_heading">' . $row['collection_name'] .'</div>' : ''; ?> <?php /* echo ($row['collection_description'] != '') ? '<p>' . nl2br($row['collection_description']) . '</p>' : ''; */ ?>
      <?php if( count($row['products']) > Collections::COLLECTION_LAYOUT1_LIMIT ){ ?>
      <div class="section_action"> <a href="<?php echo CommonHelper::generateUrl('Collections','View',array($row['collection_id']));?>" class="btn btn--primary ripplelink"><?php echo Labels::getLabel('LBL_View_All',$siteLangId); ?></a> </div>
      <?php }  ?>
    </div>
    <div class="shops">
      <div class="trending-corner" dir="<?php echo CommonHelper::getLayoutDirection();?>">
        <?php foreach( $row['products'] as $product ){ include('collection-1-products-list.php'); } ?>
      </div>
    </div>
  </div>
</section>
<?php } ?>
<?php $counter++; }
} ?>
