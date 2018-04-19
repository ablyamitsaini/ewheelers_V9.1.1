<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<?php if($footerData){ ?>
<section class="upperContent-footer">
    <div class="fixed-container">
	 <?php echo FatUtility::decodeHtmlEntities($footerData['epage_content'] );?>
	</div>
</section>
<?php } ?>
