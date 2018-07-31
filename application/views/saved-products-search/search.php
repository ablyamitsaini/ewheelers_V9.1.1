<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if(!empty($arrListing)){?>
<div class="saved-search-list">
	<ul>
	  <?php foreach ($arrListing as $sn => $row){ ?>
		<li>
			<div class="detail-side">
				<div class="heading3"><?php echo ucfirst($row['pssearch_name']); ?></div>
				<div class="heading5"><?php echo $row['search_items'];?></div>
				<div class="date"><?php echo FatDate::format($row['pssearch_added_on']); ?></div>
			</div>
			<div class="results-side">
				<?php /*?><span class="newly-added"><?php echo $row['newRecords'];?></span><?php */?>
				<strong><a href="<?php echo $row['search_url'];?>"><?php echo Labels::getLabel('LBL_View_results', $siteLangId); ?></a></strong> <?php /* echo Labels::getLabel('LBL_Out_of',$siteLangId); */?> <?php /* echo $row['totalRecords']; */?>
			</div>
		</li>
	  <?php }?>
	</ul>
</div>
<?php  
	$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount,'siteLangId'=>$siteLangId);
	$this->includeTemplate('_partial/pagination.php', $pagingArr,false);
}else{ 
	$this->includeTemplate('_partial/no-record-found.php' , array('siteLangId'=>$siteLangId),false);
}?>