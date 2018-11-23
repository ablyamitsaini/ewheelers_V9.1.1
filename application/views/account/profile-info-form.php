<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'profileInfoFrm');
$frm->setFormTagAttribute('class','form');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('onsubmit', 'updateProfileInfo(this); return(false);');

$usernameFld = $frm->getField('credential_username');
$usernameFld->setFieldTagAttribute('disabled','disabled');

$userDobFld = $frm->getField('user_dob');
if(!empty($data['user_dob']) && strtotime($data['user_dob']) > 0 ){
	$userDobFld->setFieldTagAttribute('disabled','disabled');
}

$userDobFld->setFieldTagAttribute('class','user_dob_js');

$emailFld = $frm->getField('credential_email');
$emailFld->setFieldTagAttribute('disabled','disabled');

$countryFld = $frm->getField('user_country_id');
$countryFld->setFieldTagAttribute('id','user_country_id');
$countryFld->setFieldTagAttribute('onChange','getCountryStates(this.value,'.$stateId.',\'#user_state_id\')');

$stateFld = $frm->getField('user_state_id');
$stateFld->setFieldTagAttribute('id','user_state_id');


$imgFrm->setFormTagAttribute('action', CommonHelper::generateUrl('Account','uploadProfileImage'));
/* $imgFrm->setFormTagAttribute('id', 'imageFrm');
$fld = $imgFrm->getField('user_profile_image');	
$fld->addFieldTagAttribute('class','btn btn--primary btn--sm'); */
?>
<div class="row">
	<div class="col-md-5">
		<div class="preview preview--profile" id="profileImageFrmBlock">
			<div class="avtar avtar--large"><img src="<?php echo CommonHelper::generateUrl('Account','userProfileImage',array(UserAuthentication::getLoggedUserId(),'croped',true)).'?'.time();?>" alt="<?php echo Labels::getLabel('LBL_Profile_Image', $siteLangId);?>"></div>
			<span class="gap"></span>
			<div class="btngroup--fix">
				<?php echo $imgFrm->getFormTag();	?>
				<span class="btn btn--primary btn--sm btn--fileupload">	
				<?php echo $imgFrm->getFieldHtml('user_profile_image'); ?><?php echo ($mode == 'Edit') ? Labels::getLabel('LBL_Change',$siteLangId): Labels::getLabel('LBL_Upload',$siteLangId) ;?>
				</span>
				<?php echo $imgFrm->getFieldHtml('update_profile_img'); 
				echo $imgFrm->getFieldHtml('rotate_left'); 
				echo $imgFrm->getFieldHtml('rotate_right'); 
				echo $imgFrm->getFieldHtml('remove_profile_img'); 
				echo $imgFrm->getFieldHtml('action'); 
				echo $imgFrm->getFieldHtml('img_data'); 				
				?>	
				<?php if($mode == 'Edit'){?>
					<a class="btn btn--secondary btn--sm" href="javascript:void(0)" onClick="removeProfileImage()"><?php echo Labels::getLabel('LBL_Remove',$siteLangId);?></a>
				 <?php }?>				
				</form>
				<?php echo $imgFrm->getExternalJS();?>
				 
				<div id="dispMessage"></div> 
			</div>
		</div>
	</div>
	<div class="col-md-7" >
		<?php echo $frm->getFormHtml();?>
	</div>
</div>
<script language="javascript">
	$(document).ready(function(){
		getCountryStates($( "#user_country_id" ).val(),<?php echo $stateId ;?>,'#user_state_id');
		$('.user_dob_js').datepicker('option', {maxDate: new Date()});
	});
</script>