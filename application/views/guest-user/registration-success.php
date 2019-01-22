<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<section class="section">
<div class="container">

<div class="row justify-content-center">
<div class="col-md-6 ">
  <div class="box box--white box--space">
    <div class="message message--success align--center"> <i class="fa fa-check-circle"></i>
      <h2><?php echo Labels::getLabel('MSG_Congratulations',$siteLangId);?></h2>
      <!--<h3><?php // echo Labels::getLabel('LBL_Registration_Successful',$siteLangId);?> </h3>-->
      <h6><?php echo $registrationMsg; ?> </h6>
      </div>
  </div>
</div>
  </div>


</div>
</section>
