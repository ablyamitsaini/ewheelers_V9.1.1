<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (!empty($arr_listing) && is_array($arr_listing)) { ?>
    <div class="messages-list">
        <ul>
            <?php foreach ($arr_listing as $sn => $row) {
                $liClass = 'is-read';
                if ($row['message_is_unread'] == Thread::MESSAGE_IS_UNREAD && $row['message_to'] == $loggedUserId) {
                    $liClass = '';
                } ?> <li class="<?php echo $liClass; ?>">
                    <div class="msg_db"><img src="<?php echo CommonHelper::generateUrl('Image', 'user', array($row['message_from_user_id'],'thumb',true)); ?>" alt="<?php echo $row['message_from_name']; ?>"></div>
                    <div class="msg__desc">
                        <span class="msg__title"><?php echo htmlentities($row['message_from_name']); ?></span>
                        <p class="msg__detail"><?php  echo CommonHelper::truncateCharacters($row['message_text'], 85, '', '', true); ?></p>
                        <span class="msg__date"><?php echo FatDate::format($row['message_date'], true); ?></span>
                    </div>
                    <ul class="actions">
                        <li><a href="<?php echo CommonHelper::generateUrl('Account', 'viewMessages', array($row['thread_id'],$row['message_id'])); ?>"><i class="fa fa-eye"></i></a></li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </div> 
<?php } else {
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId'=>$siteLangId), false);
}

$postedData['page'] = $page;
echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmMessageSrchPaging'));
$pagingArr=array('pageCount'=>$pageCount,'page'=>$page,'recordCount'=>$recordCount, 'callBackJsFunc' => 'goToMessageSearchPage');
$this->includeTemplate('_partial/pagination.php', $pagingArr, false);
