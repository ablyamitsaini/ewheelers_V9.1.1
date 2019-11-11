$(".tabs_nav li a").click(function() {
        $(this).parents('.tabs_nav_container:first').find(".tabs_panel").hide();
        var activeTab = $(this).attr("rel");
        $("#" + activeTab).fadeIn();

        $(this).parents('.tabs_nav_container:first').find(".tabs_nav li a").removeClass("active");
        $(this).addClass("active");

    });

$(document).ready(function(){
	$( ".default" ).trigger( "click" );
});

(function() {
	var runningAjaxMsg = 'some requests already running or this stucked into runningAjaxReq variable value, so try to relaod the page and update the same to WebMaster. ';
	var runningAjaxReq = false;
	var dv = '#frmBlock';
	
	getSlabRates = function(){
		fcom.ajax(fcom.makeUrl('TestDriveManagement', 'slabRates'), '', function(res) {
			$(dv).html(res);
			
		});
	};
	
	getSettings = function(){
		fcom.ajax(fcom.makeUrl('TestDriveManagement', 'frm'), '', function(res) {
			$(dv).html(res);
			
		});
	};
	
	addTestDriveSettings = function(frm){
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('TestDriveManagement', 'updateSettings'), data, function(t) {
			/* profileInfoForm();
			$.mbsmessage.close();
			console.log(t); */

		});
	};
	
	slabRateForm = function(){
		fcom.ajax(fcom.makeUrl('TestDriveManagement', 'slabRateFrm'), '', function(res) {
			$.facebox(res, 'faceboxMgt');
		});
	};
	
	addSlabRates = function(frm){
		if (!$(frm).validate()) return;
		var data = fcom.frmData(frm);
		fcom.updateWithAjax(fcom.makeUrl('TestDriveManagement', 'setupSlabRates'), data, function(res) {
			getSlabRates();
			$(document).trigger('close.facebox');
		});
	};
	
	editSlabRates = function(id){
		fcom.ajax(fcom.makeUrl('TestDriveManagement', 'slabRateFrm',[id]),'', function(res) {
			$.facebox(res, 'faceboxEditRates');
		});
	};
	
	deleteSlabRates = function(id){
		var data = 'id=' + id;
		fcom.updateWithAjax(fcom.makeUrl('TestDriveManagement', 'deleteSlabRateFrm'),data, function(res) {
			getSlabRates();
		});
	};
	
})();
