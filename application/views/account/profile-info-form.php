<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'profileInfoFrm');
$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 4;

$fld = $frm->getField('user_profile_info');
$fld->developerTags['col'] = 6;

$fld = $frm->getField('user_products_services');
$fld->developerTags['col'] = 6;

$submitFld = $frm->getField('btn_submit');
$submitFld->developerTags['col'] = 12;
$submitFld->developerTags['noCaptionTag'] = true;

$frm->setFormTagAttribute('onsubmit', 'updateProfileInfo(this); return(false);');

$usernameFld = $frm->getField('credential_username');
$usernameFld->setFieldTagAttribute('disabled', 'disabled');

$userDobFld = $frm->getField('user_dob');
if (!empty($data['user_dob']) && $data['user_dob'] != '0000-00-00') {
    $userDobFld->setFieldTagAttribute('disabled', 'disabled');
}

$userDobFld->setFieldTagAttribute('class', 'user_dob_js');

$emailFld = $frm->getField('credential_email');
$emailFld->setFieldTagAttribute('disabled', 'disabled');

$countryFld = $frm->getField('user_country_id');
$countryFld->setFieldTagAttribute('id', 'user_country_id');
$countryFld->setFieldTagAttribute('onChange', 'getCountryStates(this.value,'.$stateId.',\'#user_state_id\')');

$stateFld = $frm->getField('user_state_id');
$stateFld->setFieldTagAttribute('id', 'user_state_id');


$imgFrm->setFormTagAttribute('action', CommonHelper::generateUrl('Account', 'uploadProfileImage'));
/* $imgFrm->setFormTagAttribute('id', 'imageFrm');
$fld = $imgFrm->getField('user_profile_image');
$fld->addFieldTagAttribute('class','btn btn--primary btn--sm'); */
?>
<div class="row">
    <div class="col-md-4">
        <div class="row preview preview--profile align-items-center" id="profileImageFrmBlock">
            <div class="col-md-6">
                <div class="avtar avtar--large"><img src="<?php echo CommonHelper::generateUrl('Account', 'userProfileImage', array(UserAuthentication::getLoggedUserId(), 'croped', true)).'?'.time();?>"
                        alt="<?php echo Labels::getLabel('LBL_Profile_Image', $siteLangId);?>"></div>
            </div>
            <div class="col-md-6">
                <div class="btngroup--fix">
                    <?php echo $imgFrm->getFormTag();    ?>
                    <span class="btn btn--primary btn--sm btn--fileupload">
                        <?php echo $imgFrm->getFieldHtml('user_profile_image'); ?><?php echo ($mode == 'Edit') ? Labels::getLabel('LBL_Change', $siteLangId): Labels::getLabel('LBL_Upload', $siteLangId) ;?>
                    </span>
                    <?php echo $imgFrm->getFieldHtml('update_profile_img');
                    echo $imgFrm->getFieldHtml('rotate_left');
                    echo $imgFrm->getFieldHtml('rotate_right');
                    echo $imgFrm->getFieldHtml('remove_profile_img');
                    echo $imgFrm->getFieldHtml('action');
                    echo $imgFrm->getFieldHtml('img_data');
                    ?>
                    <?php if ($mode == 'Edit') { ?>
                    <a class="btn btn--primary-border btn--sm" href="javascript:void(0)" onClick="removeProfileImage()"><?php echo Labels::getLabel('LBL_Remove', $siteLangId);?></a>
                    <?php }?>
                    </form>
                    <?php echo $imgFrm->getExternalJS();?>
                    <div id="dispMessage"></div>
                </div>
            </div>
        </div>
        <?php if (User::canViewBuyerTab() && User::canViewSupplierTab()) { ?>
        <div class="row preview preview--profile align-items-center">
            <div class="col-md-12">
                <h5><?php echo Labels::getLabel('LBL_Preferred_Dashboard', $siteLangId);?> </h5>
                <ul class="switch setactive-js">
                    <?php if (User::canViewBuyerTab() && ( User::canViewSupplierTab() || User::canViewAdvertiserTab() || User::canViewAffiliateTab() )) { ?>
                    <li <?php echo (User::USER_BUYER_DASHBOARD == $data['user_preferred_dashboard'])?'class="is-active"':''?>><a href="javascript:void(0)"
                            onClick="setPreferredDashboad(<?php echo User::USER_BUYER_DASHBOARD ;?>)"><?php echo Labels::getLabel('LBL_Buyer', $siteLangId);?></a></li>
                    <?php } ?>
                    <?php if (User::canViewSupplierTab() && ( User::canViewBuyerTab() || User::canViewAdvertiserTab() || User::canViewAffiliateTab() )) { ?>
                    <li <?php echo (User::USER_SELLER_DASHBOARD == $data['user_preferred_dashboard'])?'class="is-active"':''?>><a href="javascript:void(0)"
                            onClick="setPreferredDashboad(<?php echo User::USER_SELLER_DASHBOARD ;?>)"><?php echo Labels::getLabel('LBL_Seller', $siteLangId);?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-8">
        <?php echo $frm->getFormHtml();?>
    </div>
</div>
<script language="javascript">
    $(document).ready(function(){
        getCountryStates($( "#user_country_id" ).val(),<?php echo $stateId ;?>,'#user_state_id');
        $('.user_dob_js').datepicker('option', {maxDate: new Date()});
    });
</script>
