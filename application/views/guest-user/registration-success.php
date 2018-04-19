<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="fixed-container">
  <div class="row">
    <div class="container container--fluid">
      <div class="panel panel--centered">
        <div class="box box--white box--tabled">
          <div class="message message--success align--center"> <i class="fa fa-check-circle"></i>
            <h2><?php echo Labels::getLabel('MSG_Congratulations',$siteLangId);?></h2>
            <!--<h3><?php // echo Labels::getLabel('LBL_Registration_Successful',$siteLangId);?> </h3>-->
            <h6><?php echo $registrationMsg; ?> </h6>
            <span class="gap"></span> </div>
        </div>
      </div>
    </div>
  </div>
</div>
