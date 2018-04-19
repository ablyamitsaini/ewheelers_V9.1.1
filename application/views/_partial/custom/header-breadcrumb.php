<?php defined('SYSTEM_INIT') or die('Invalid usage'); ?>
<ul class="clearfix">
	<li><a href="<?php echo CommonHelper::generateUrl();?>"><?php echo Labels::getLabel('LBL_Home',$siteLangId);?> </a></li>
  <?php 
	if(!empty($this->variables['nodes'])){	
		foreach($this->variables['nodes'] as $nodes){?>
			<?php if(!empty($nodes['href'])){?>
					<li><a href="<?php echo $nodes['href'];?>" <?php echo (!empty($nodes['other']))?$nodes['other']:'';?>><?php echo $nodes['title'];?></a></li>
			<?php }else{?>
					<li><?php echo (isset($nodes['title']))?$nodes['title']:'';?></li>  			
		<?php 	} 
		} 
	}?>
</ul>
