$(document).ready(function() {
    loadForm('general_instructions');
});

(function() {
    var dv = '#importExportBlock';
    var settingDv = '#settingFormBlock';
    var exportDv = '#exportFormBlock';
    var importDv = '#importFormBlock';

    loadForm = function(formType) {
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('ImportExport', 'loadForm', [formType]), '', function(t) {
            $(dv).html(t);
        });
    };
    generalInstructions = function(frmType) {
        fcom.resetEditorInstance();
        $(dv).html(fcom.getLoader());
        fcom.ajax(fcom.makeUrl('Configurations', 'generalInstructions', [frmType]), '', function(t) {
            $(dv).html(t);
        });
    };
    updateSettings = function(frm) {
        var data = fcom.frmData(frm);
        $(settingDv).html(fcom.getLoader());
        fcom.updateWithAjax(fcom.makeUrl('ImportExport', 'updateSettings'), data, function(ans) {
            loadForm('settings');
        });
    };

    exportForm = function(actionType) {
        fcom.ajax(fcom.makeUrl('ImportExport', 'exportForm', [actionType]), '', function(t) {
            $(exportDv).html(t);
        });
    };

    exportData = function(frm, actionType) {
        if (!$(frm).validate()) return;
        document.frmImportExport.action = fcom.makeUrl('ImportExport', 'exportData', [actionType]);
        document.frmImportExport.submit();
    };

    exportMediaForm = function(actionType) {
        fcom.ajax(fcom.makeUrl('ImportExport', 'exportMediaForm', [actionType]), '', function(t) {
            $(exportDv).html(t);
        });
    };

    exportMedia = function(frm, actionType) {
        if (!$(frm).validate()) return;
        document.frmImportExport.action = fcom.makeUrl('ImportExport', 'exportMedia', [actionType]);
        document.frmImportExport.submit();
    };

    importForm = function(actionType) {
        fcom.ajax(fcom.makeUrl('ImportExport', 'importForm', [actionType]), '', function(t) {
            $(importDv).html(t);
        });
    };

    getInstructions = function(actionType) {
        fcom.ajax(fcom.makeUrl('ImportExport', 'importInstructions', [actionType]), '', function(t) {
            $(importDv).html(t);
        });
    };

    importMediaForm = function(actionType) {
        fcom.ajax(fcom.makeUrl('ImportExport', 'importMediaForm', [actionType]), '', function(t) {
            $(importDv).html(t);
        });
    };

    importFile = function(method, actionType) {
        var data = new FormData();
        $inputs = $('#frmImportExport input[type=text],#frmImportExport select,#frmImportExport input[type=hidden]');
        $inputs.each(function() {
            data.append(this.name, $(this).val());
        });
        if ($('#import_file')[0].files.length == 0) {
            $.mbsmessage(langLbl.selectFile, false, 'alert--danger');
        }
        $.each($('#import_file')[0].files, function(i, file) {
            $.mbsmessage(langLbl.processing, false, 'alert--process');
            $('#fileupload_div').html(fcom.getLoader());
            data.append('import_file', file);
            $.ajax({
                url: fcom.makeUrl('ImportExport', method, [actionType]),
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function(t) {
                    try {
                        var ans = $.parseJSON(t);
                        if (ans.status == 1 || ans.status == true) {
                            $(document).trigger('close.facebox');
                            $(document).trigger('close.mbsmessage');
                            $.systemMessage(ans.msg, 'alert--success');
                            if ('importData' == method) {
                                importForm(actionType);
                            } else {
                                importMediaForm(actionType);
                            }
                            if (typeof ans.CSVfileUrl !== 'undefined') {
                                location.href = ans.CSVfileUrl;
                            }
                        } else {
                            $('#fileupload_div').html('');
                            $(document).trigger('close.mbsmessage');
                            $.systemMessage(ans.msg, 'alert--danger');
                        }
                    } catch (exc) {
                        $(document).trigger('close.mbsmessage');
                        $.systemMessage(exc.message, 'alert--danger');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error Occured.");
                }
            });
        });
    };

    showHideExtraFld = function(type, BY_ID_RANGE, BY_BATCHES) {
        if (type == BY_ID_RANGE) {
            $(".range_fld").show();
            $(".batch_fld").hide();
        } else if (type == BY_BATCHES) {
            $(".range_fld").hide();
            $(".batch_fld").show();
        } else {
            $(".range_fld").hide();
            $(".batch_fld").hide();
        }
    };
<<<<<<< HEAD
})();
=======

    $(document).on('click', ".group__head-js", function() {
        if ($(this).parents('.group-js').hasClass('is-active')) {
            $(this).siblings('.group__body-js').slideUp();
            $('.group-js').removeClass('is-active');
        } else {
            $('.group-js').removeClass('is-active');
            $(this).parents('.group-js').addClass('is-active');
            $('.group__body-js').slideUp();
            $(this).siblings('.group__body-js').slideDown();
        }
    });

})();
>>>>>>> task_61864_add_cost_price_in_seller_inventory
