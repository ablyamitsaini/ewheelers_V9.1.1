$(document).ready(function() {     
	$('.time').datetimepicker({
			datepicker: false,
			format:'H:i',
			step: 30
	});
	
	$( "#promotion_budget_period,#promotion_start_date" ).change(function() {
		var new_date = AddDaysToDate($("#promotion_start_date").val(),$("#promotion_budget_period").val(),"-")
		$("#promotion_end_date").val(new_date);
	});
});
