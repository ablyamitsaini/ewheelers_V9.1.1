<?php if (count($arrListing) > 0){
	foreach($arrListing as $row){
?>
	<li>
	   <div class="grid grid--first">
		   <div class="avtar"><img src="<?php echo CommonHelper::generateUrl('Image','user',array($row['message_from_user_id'],'thumb',true));?>" alt="<?php echo $row['message_from_name'];?>"></div>
	   </div>
	   <div class="grid grid--second">
		   <span class="media__date"><?php echo FatDate::format($row['message_date'],true);?></span>
		   <span class="media__title"><?php echo $row['message_from_name'];?></span>
			 <div class="grid grid--third">
			 <div class="media__description"><?php echo nl2br($row['message_text']);?> </div>
			</div>
	   </div>

	</li>
<?php } }
$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmMessageSrchPaging') );
