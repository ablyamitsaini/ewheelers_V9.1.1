<div class="heading3"><?php echo Labels::getLabel('LBL_Seller_Registration', $siteLangId);?></div>
<div class="registeration-process">
    <ul>
        <li><a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Details', $siteLangId);?></a></li>
        <li><a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Activation', $siteLangId);?></a></li>
        <li class="is--active"><a href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Confirmation', $siteLangId);?></a></li>
    </ul>
</div>
<div class="message message--success align--center"> <i class="fa fa-check-circle"></i>
    <h2><?php echo Labels::getLabel('MSG_Congratulations', $siteLangId);?>!</h2>
    <p><?php echo $success_message; ?></p>
    <div class="gap"></div>
    <a href="<?php echo CommonHelper::generateUrl('guest-user', 'login-form'); ?>" class="btn btn--primary"><?php echo Labels::getLabel('Lbl_Login', $siteLangId);?></a>
</div>
