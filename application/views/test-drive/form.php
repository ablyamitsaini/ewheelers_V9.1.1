<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 
if(empty($termsAndConditionsLinkHref)){
	$termsAndConditionsLinkHref = 'javascript:void(0)';
}
?>

<div class="-request-form">
		<?php 
		$frmTestDrive->setFormTagAttribute('class', 'form form--normal');
		$frmTestDrive->developerTags['colClassPrefix'] = 'col-lg- col-md- col-sm-';
		$frmTestDrive->developerTags['fld_default_col'] = 6;	
		$frmTestDrive->setFormTagAttribute('onsubmit', 'addTestDrive(this); return(false);'); 
		
		$fld = $frmTestDrive->getField('ptdr_location');
		$fld->developerTags['col'] = 12;
		
		$fld = $frmTestDrive->getField('ptdr_contact');
		$fld->setFieldTagAttribute('class', 'phone-js ltr-right');
		$fld->setFieldTagAttribute('placeholder', '(XXX) XXX-XXXX');
		$fld->setFieldTagAttribute('maxlength', 14);
		
		$fld = $frmTestDrive->getField('ptdr_date');
		$fld->setFieldTagAttribute('readonly', 'readonly');
		$fld->setFieldTagAttribute('id', 'datetimepicker');
		
		$fld = $frmTestDrive->getField('terms');
		$fld->developerTags['col'] = 12;
		$fld->htmlAfterField = "<a target='_blank' href='$termsAndConditionsLinkHref' class='link'>".Labels::getLabel('LBL_Terms_Conditions',$siteLangId)."</a>";
		$fld->addWrapperAttribute('class', '-col-custom');
		
		$fld = $frmTestDrive->getField('btn_submit');
		$fld->developerTags['col'] = 12;
		$fld->setFieldTagAttribute('class', 'btn btn--primary block-on-mobile');
		$fld->setFieldTagAttribute('id', 'addTestDriveRequest');
		$fld->addWrapperAttribute('class', '-col-custom');
		
		echo $frmTestDrive->getFormHtml();
		?>
		
</div>
	<!--</div>
</div>-->
<script type="text/javascript">
    $(document).ready(function () {
		var currentDate = new Date();
		
		currentDate.setDate(currentDate.getDate()+2);
		currentDate.setHours(0);
		currentDate.setMinutes(0);
		
		//DatePicker Example
		$('#datetimepicker').datetimepicker({
			minDate: currentDate,
		});
	});
	
	$(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 100;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";
    

    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});
</script>