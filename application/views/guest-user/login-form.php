<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div id="body" class="body bg--gray">
  <section class="section">
    <div class="container">

        <div class="row justify-content-center">
          <div class="col-md-6 <?php echo (empty($pageData)) ? '' : '';?>">
            <div class="box box--white box--space">
              <?php $this->includeTemplate('guest-user/loginPageTemplate.php', $data,false ); ?>
            </div>
          </div>
          <?php if(!empty($pageData)) { $this->includeTemplate('_partial/GuestUserRightPanel.php', $pageData ,false ); } ?>
        </div>

    </div>

  </section>
</div>
