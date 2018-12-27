<?php if (count($messages) > 0){ ?>
<div class="box box--white box--space ">
	<div class="box__head">
	   <h4><?php echo Labels::getLabel('LBL_Message',$siteLangId);?></h4>
	   <a href="<?php echo CommonHelper::generateUrl('Account','messages');?>" class="link--arrow"><?php echo Labels::getLabel('LBL_View_All',$siteLangId);?></a>
	</div>
	<div class="box__body">
	   <ul class="media media--small">

				<?php foreach($messages as $row){
					$liClass = 'is-read';
					if($row['message_is_unread'] == Thread::MESSAGE_IS_UNREAD ) {
						$liClass = '';
					}
			?>
			<li class="<?php echo $liClass; ?>" >
			<div class="grid grid--first">
				<div class="avtar">
					<img src="<?php echo CommonHelper::generateUrl('Image','user',array($row['message_from_user_id'],'thumb',true));?>" alt="<?php echo $row['message_from_name']; ?>">
				</div>
			</div>
		   <div class="grid grid--second">
			   <span class="media__date"><?php echo FatDate::format($row['message_date'],true);?></span>
			   <span class="media__title"><?php echo htmlentities($row['message_from_name']);?></span>
				 <div class="grid grid--third">
				 <div class="media__description"><?php  echo CommonHelper::truncateCharacters($row['message_text'],85,'','',true);?></div>
				</div>
		   </div>

		</li>
		<?php }?>
	   </ul>
	</div>
</div>
<?php }?>
