<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<?php if (!empty($arr_listing) && is_array($arr_listing) ){?>
<ul class="media">
	<?php foreach ($arr_listing as $sn => $row){
		$liClass = 'is-read';
		if($row['message_is_unread'] == Thread::MESSAGE_IS_UNREAD && $row['message_to'] == $loggedUserId) {
			$liClass = '';
		}
		?>
		<li class="<?php echo $liClass; ?>">
		   <div class="grid grid--first">
			   <div class="avtar"><img src="<?php echo CommonHelper::generateUrl('Image','user',array($row['message_from_user_id'],'thumb',true));?>" alt="<?php echo $row['message_from_name']; ?>"></div>
		   </div>
		   <div class="grid grid--second">
			   <span class="media__date"><?php echo FatDate::format($row['message_date'])?></span>
			   <span class="media__title"><?php echo $row['message_from_name'];?></span>
		   </div>
		   <div class="grid grid--third">
				  <div class="media__description"><?php echo CommonHelper::truncateCharacters($row['message_text'],85,'','',true); ?></div>
		   </div>
		   <div class="grid grid--fourth">
			   <ul class="actions">
				   <li><a href="<?php echo CommonHelper::generateUrl('Account','viewMessages',array($row['thread_id'],$row['message_id']));?>"><i class="fa fa-eye"></i></a></li>			   
			   </ul>
		   </div>
		</li>
   <?php }?>
</ul>
<?php }
else{
	$this->includeTemplate('_partial/no-record-found.php' ,array('siteLangId'=>$siteLangId),false);
}

$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmMessageSrchPaging') );
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToOrderSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr,false);