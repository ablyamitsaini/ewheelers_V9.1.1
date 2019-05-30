<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="post-detail">
    <div class="container">
        <div class="row">
            <div class="col-md-9 mb-4 mb-md-0">
                <div class="posted-content">
                    <div class="row" id="blogs-listing-js"></div>
                </div>
            </div>
            <div class="col-md-3">
                <?php $this->includeTemplate('_partial/blogSidePanel.php', array('popularPostList' => $popularPostList, 'featuredPostList' => $featuredPostList)); ?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    var keyword = '<?php echo (isset($keyword)) ? $keyword : ''; ?>';
</script>
