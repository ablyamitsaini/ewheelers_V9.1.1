(function() {
	uploadZip = function() {
        var data = new FormData();
        $.each($('#bulk_images')[0].files, function(i, file) {
            fcom.displayProcessing(langLbl.processing, ' ', true);
            data.append('bulk_images', file);
            $.ajax({
                url: fcom.makeUrl('UploadBulkImages', 'upload'),
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function(t) {
					try {
                        var ans = $.parseJSON(t);
                        if (ans.status == 1) {
                            $(document).trigger('close.facebox');
                            $(document).trigger('close.mbsmessage');
                            fcom.displaySuccessMessage(ans.msg, 'alert--success', false);
							document.uploadBulkImages.reset();
							$("#uploadFileName").text('');
                        } else {
                            $(document).trigger('close.mbsmessage');
                            fcom.displayErrorMessage(ans.msg);
                        }
                    } catch (exc) {
                        $(document).trigger('close.mbsmessage');
                        fcom.displayErrorMessage(t);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error Occured.");
                }
            });
        });
    };
})();
