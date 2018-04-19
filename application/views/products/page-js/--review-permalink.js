function reviewAbuse(reviewId){
	if(reviewId){
		$.facebox(function() {
			fcom.ajax(fcom.makeUrl('Products', 'reviewAbuse', [reviewId]), '', function(t) {
				$.facebox(t,'faceboxWidth');
			});
		});
	}
}

function setupReviewAbuse(frm){
	if (!$(frm).validate()) return;
	var data = fcom.frmData(frm);
	fcom.updateWithAjax(fcom.makeUrl('Products', 'setupReviewAbuse'), data, function(t) {
		$(document).trigger('close.facebox');
	});
	return false;
}

function productAttributes( product_id ){
	$("#itemSpecifications").html(fcom.getLoader());
	
	fcom.ajax( fcom.makeUrl('Products','productAttributes',[product_id]),'',function(ans){
		$("#itemSpecifications").html(ans);
	});
}

(function() {
	
	markReviewHelpful = function(reviewId , isHelpful){
		isHelpful = (isHelpful) ? isHelpful : 0;
		var data = 'reviewId='+reviewId+'&isHelpful=' + isHelpful;
		fcom.updateWithAjax(fcom.makeUrl('Products','markReviewHelpful'), data, function(ans){
			$.mbsmessage.close();
			reviews(document.frmReviewSearch);
			/* if(isHelpful == 1){
				
			} else {
				
			} */
		});
	}
	
})();