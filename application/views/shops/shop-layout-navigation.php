<?php defined('SYSTEM_INIT') or die('Invalid Usage'); 
	$class="";
switch($template_id){
	case Shop::TEMPLATE_ONE:
	$class="";
	break;
	case Shop::TEMPLATE_TWO:
	case Shop::TEMPLATE_THREE:
	case Shop::TEMPLATE_FOUR:
	case Shop::TEMPLATE_FIVE:
	$class="shop-navigations";
	break;
}
?>

<ul class="<?php echo $class; ?>">
  <li class="<?php echo $action == 'view' ? 'is--active' : '' ?>"><a href="<?php echo CommonHelper::generateUrl('shops','view',array($shop_id));?>" class="ripplelink"><?php echo Labels::getLabel('LBL_SHOP_STORE_HOME', $siteLangId); ?></a></li>
  <li class="<?php echo $action == 'topProducts' ? 'is--active' : '' ?>"><a href="<?php echo CommonHelper::generateUrl('shops','topProducts',array($shop_id));?>" class="ripplelink"><?php echo Labels::getLabel('LBL_SHOP_TOP_PRODUCTS', $siteLangId); ?></a></li>
  <?php if(!empty($collectionData)){ ?>
  <li class="<?php echo $action == 'collection' ? 'is--active' : '' ?>"><a href="<?php echo CommonHelper::generateUrl('shops','collection',array($shop_id));?>" class="ripplelink"><?php echo $collectionData['collectionName']; ?></a></li>
  <?php } ?>
  <li class="<?php echo $action == 'shop' ? 'is--active' : '' ?>"><a href="<?php echo CommonHelper::generateUrl('reviews','shop',array($shop_id));?>" class="ripplelink"><?php echo Labels::getLabel('LBL_SHOP_REVIEW', $siteLangId); ?></a></li>
  <li class="<?php echo $action == 'sendMessage' ? 'is--active' : '' ?>"><a href="<?php echo CommonHelper::generateUrl('shops','sendMessage',array($shop_id));?>" class="ripplelink"><?php echo Labels::getLabel('LBL_SHOP_CONTACT', $siteLangId); ?></a></li>
  <li class="<?php echo $action == 'policy' ? 'is--active' : '' ?>"><a href="<?php echo CommonHelper::generateUrl('shops','policy',array($shop_id));?>" class="ripplelink"><?php echo Labels::getLabel('LBL_SHOP_POLICY', $siteLangId); ?></a></li>
</ul>
