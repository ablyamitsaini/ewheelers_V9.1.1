<?php defined('SYSTEM_INIT') or die('Invalid Usage.');?>
<div class="selected-panel " id="alreadyLoginDiv">
  <div class="selected-panel-type">1. <?php echo Labels::getLabel('LBL_Login', $siteLangId); ?></div>
  <div class="selected-panel-data"><?php echo UserAuthentication::getLoggedUserAttribute('user_email'); ?></div>
  <!--<div class="selected-panel-action"><a onClick="showLoginDiv();" class="btn btn--primary ripplelink"><?php echo Labels::getLabel('LBL_Change_Login', $siteLangId); ?></a></div>-->
</div>