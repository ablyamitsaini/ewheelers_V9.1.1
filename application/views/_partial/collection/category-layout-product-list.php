<div id="tabUl" class="tabs tabs--flat-js">
	<ul>
	<?php foreach( $row['categories'] as $key => $category ){?>
		<li class=""><a href="#tb-<?php echo $key; ?>"><?php echo $category['catData']['prodcat_name']; ?></a></li>
	<?php }?>
	</ul>
</div>
<?php foreach( $row['categories'] as $key => $category ){?>
	<div id="tb-<?php echo $key; ?>" class="tabs-content tabs-content-js" style="display: block;">
		<div class="ft-pro-wrapper">
		<?php $i=1; foreach( $category['products'] as $key => $product ){ ?>
			<div class="ft-pro ft-pro-<?php echo $i; ?>">
				<?php $prodImgSize = 'MEDIUM'; include('product-layout-1-list.php'); ?>
			</div>
		<?php $i++; } ?>
		</div>
	
	</div>
<?php }?>
