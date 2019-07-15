<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (isset($listCategories) && is_array($listCategories)) {
    $faqMainCat = FatApp::getConfig("CONF_FAQ_PAGE_MAIN_CATEGORY", null, '');
    foreach ($listCategories as $faqCat) {
        ?>
        <a href="javascript:void(0);" onClick="searchFaqs(<?php echo $faqCat['faqcat_id']; ?>);" id="<?php echo $faqCat['faqcat_id']; ?>" class="<?php echo($faqMainCat == $faqCat['faqcat_id'] ? 'is--active' : '')?>"><?php echo $faqCat['faqcat_name']; ?></a>
        <?php
    }
}
