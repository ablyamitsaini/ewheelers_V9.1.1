<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body bg--gray">
  <section class="top-space ">
    <div class="container">
      <div class="panel panel--centered">
        <div class="box box--white box--tabled">
          <div class="box__cell <?php echo (empty($pageData)) ? 'noborder--right' : '';?>">
            <?php $this->includeTemplate('guest-user/registerationFormTemplate.php', $data,false ); ?>
          </div>
          <?php if(!empty($pageData)) { $this->includeTemplate('_partial/GuestUserRightPanel.php', $pageData ,false); } ?>
        </div>
      </div>
    </div>
    <div class="gap"></div>
  </section>
</div>
