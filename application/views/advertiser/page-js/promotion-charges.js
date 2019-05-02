$(document).ready(function(){
	searchPromotionCharges();
});

searchPromotionCharges = function(){
    var dv = '#listing';
    /* var data = '';
    if (form) {
        data = fcom.frmData(form);
    } */
    $(dv).html(fcom.getLoader());
    fcom.ajax(fcom.makeUrl('Advertiser', 'searchPromotionCharges'), '' , function(t) {
        $(dv).html(t);
    });
};
