<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>


<?php if(!empty($messagesList)){ ?>

	<?php foreach($messagesList as $message){ ?>
	<li>
		<div class="grid grid--first">
			<div class="avtar">
				<?php if($message['orrmsg_from_admin_id']){ ?>
				<img src="<?php echo CommonHelper::generateUrl('Image', 'siteLogo', array( $siteLangId, 'THUMB' )); ?>" title="<?php echo $message['admin_name']; ?>" alt="<?php echo $message['admin_name']; ?>">
				<?php } else { ?>
				<img src="<?php echo CommonHelper::generateUrl('Image', 'user', array($message['orrmsg_from_user_id'], 'THUMB', 1)); ?>" title="<?php echo $message['msg_user_name'].' - '.$message['shop_identifier'];; ?>" alt="<?php echo $message['msg_user_name']; ?>">
				<?php } ?>
			</div>
		</div>
		<div class="grid grid--second">
			<span class="media__title"><?php echo ($message['orrmsg_from_admin_id']) ? $message['admin_name']: $message['msg_user_name'].' - '.$message['shop_identifier']; ?></span>
			<span class="media__date"><?php echo FatDate::format($message['orrmsg_date'], true); ?></span>
		</div>
		<div class="grid grid--third">
		<div class="media__description"><?php echo nl2br($message['orrmsg_msg']); ?> </div>
		</div>
	</li>
	<?php } ?>
<?php 
	$postedData['page'] = $page;
	echo FatUtility::createHiddenFormFromData ( $postedData, array ('name' => 'frmOrderReturnRequestMsgsSrchPaging') );
	
} else {
	//echo Labels::getLabel('MSG_No_Record_Found', $siteLangId);
} ?>