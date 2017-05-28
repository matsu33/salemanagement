/*
 * Utilities Javascript OMSS
 */
function Omss() {};

/*
 * format date
 */
Omss.dateFormat = function(date, format) {
    // Parse to Date object of parameter is string
    if (typeof date === 'string') date = new Date(date);
    // Return empty string if date is invalid
    if (!date || !date.getMonth || isNaN(date.getTime())) return '';
    // Default format is dd/MM/yyyy
    var result = format ? format : 'dd/MM/yyyy';

    if (result.indexOf('dd') >= 0) {
        result = result.split('dd').join(('00' + date.getDate()).slice(-2));
    }

    if (result.indexOf('MM') >= 0) {
        result = result.split('MM').join(('00' + (date.getMonth() + 1)).slice(-2));
    }

    if (result.indexOf('yyyy') >= 0) {
        result = result.split('yyyy').join(date.getFullYear());
    }

    return result;
}

Omss.numberFormat = function(number) {
    // Convert to number
    if (typeof number === 'string') {
        if (number === '') return '';
        number = Number(number);
    } else if (typeof number !== 'number') return '';
    // Check number is valid
    if (isNaN(number)) return '';
    // Return formated string
    return number.toFixed(10).replace(/\d(?=(\d{3})+\D)/g, '$&,').replace(/\.?0+$/g, '');
};

/*******************************************************************************
 * Utilitiy method for comunicate with server
 ******************************************************************************/
Omss.uriBase = '';
Omss.loadingCount = 0;
Omss.loadingPanel = null;

Omss.post = function(url, data) {
    // Mark there is one more loading request
    Omss.loadingCount++;
    // Create loading panel
    if (!Omss.loadingPanel) {
        Omss.loadingPanel = $('<div class="loading-panel"><div>').appendTo($('body'));
    }
    // Show or hide loading panel
    Omss.loadingPanel.toggle(Omss.loadingCount > 0);

    // Make ajax call
    return $.ajax({
        url: Omss.uriBase + url,
        data: data,
        type: 'POST',
        dataType: 'json'
    }).always(Omss.ajaxAlways).done(Omss.ajaxDone).fail(Omss.ajaxFail);
}

Omss.upload = function(url, data) {
    // Mark there is one more loading request
    Omss.loadingCount++;
    // Create loading panel
    if (!Omss.loadingPanel) {
        Omss.loadingPanel = $('<div class="loading-panel"><div>').appendTo($('body'));
    }
    // Show or hide loading panel
    Omss.loadingPanel.toggle(Omss.loadingCount > 0);

    // Make ajax call
    return $.ajax({
        url: Omss.uriBase + url,
        data: data,
        type: 'POST',
        dataType: 'json',
        async: false,
        contentType: false,
        processData: false,
    }).always(Omss.ajaxAlways).done(Omss.ajaxDone).fail(Omss.ajaxFail);
}

Omss.ajaxDone = function(data, textStatus, jqXHR) {
    // console.log(data);
}

Omss.ajaxFail = function(jqXHR, textStatus, errorThrown) {
    console.log(jqXHR, textStatus, errorThrown);
}

Omss.ajaxAlways = function(data_jqXHR, textStatus, jqXHR_errorThrown) {
    // console.log(errorThrown);
    // Mark there is one less loading request
    Omss.loadingCount--;
    // Show or hide loading panel
    Omss.loadingPanel.toggle(Omss.loadingCount > 0);
}

/*******************************************************************************
 * Utilitiy method for display message
 ******************************************************************************/
Omss.showInfo = function(message, hidden) {
    Omss.showMessage(message, hidden, 'info');
}

Omss.showSuccess = function(message, hidden) {
    Omss.showMessage(message, hidden, 'success');
}

Omss.showWarning = function(message, hidden) {
    Omss.showMessage(message, hidden, 'warning');
}

Omss.showError = function(message, hidden) {
    Omss.showMessage(message, hidden, 'error');
}

Omss.showMessage = function(message, hidden, type) {
    // Create popup if not yet
    if (!Omss.$messagePopup) {
        Omss.$messagePopup = $(Template.get('omss_message_popup'));
        $('body').append(Omss.$messagePopup);
    }
    // Chose popup by type
    var alert = null;
    switch (type) {
        case 2:
        case 'success':
            alert = Omss.$messagePopup.find('.alert.alert-success');
            break;

        case 3:
        case 'warning':
            alert = Omss.$messagePopup.find('.alert.alert-warning');
            break;

        case 4:
        case 'error':
            alert = Omss.$messagePopup.find('.alert.alert-danger');
            break;

        default:
            alert = Omss.$messagePopup.find('.alert.alert-info');
            break;
    }
    // Hide other alert
    alert.show().siblings().hide();
    // Set message for popup
    Omss.$messagePopup.find('.message').html(message);
    // Add close handler
    Omss.$messagePopup.off('hidden.bs.modal');
    if (hidden && typeof hidden === 'function') {
        Omss.$messagePopup.on('hidden.bs.modal', hidden);
    }
    // Show popup
    Omss.$messagePopup.modal('show');
}

Template
    .add(
        'omss_message_popup',
        '\
<div class="modal fade" data-backdrop="true" data-keyboard="true">\
	<div class="alert alert-info modal-dialog" role="alert">\
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>\
		<span class="sr-only">Error:</span>&nbsp;\
		<span class="message"></span>\
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\
	</div>\
	<div class="alert alert-success modal-dialog" role="alert">\
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>\
		<span class="sr-only">Error:</span>&nbsp;\
		<span class="message"></span>\
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\
	</div>\
	<div class="alert alert-warning modal-dialog" role="alert">\
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>\
		<span class="sr-only">Error:</span>&nbsp;\
		<span class="message"></span>\
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\
	</div>\
	<div class="alert alert-danger modal-dialog" role="alert">\
		<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>\
		<span class="sr-only">Error:</span>&nbsp;\
		<span class="message"></span>\
		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>\
	</div>\
</div>\
');

/*******************************************************************************
 * Utilitiy method for validation
 ******************************************************************************/
jQuery.validator.setDefaults({
    errorPlacement: function(error, element) {
        var text = $(error).html();
        $(element).attr('data-original-title', text).parents('.form-group').toggleClass(
            'has-error', true).toggleClass('has-success', false);
    },
    success: function(label, element) {
        $(element).attr('data-original-title', '').tooltip('hide').parents('.form-group')
            .toggleClass('has-error', false).toggleClass('has-success', true);
    },
});

Omss.validate = function(form, rules, submitHandler) {
    // Add tooltip for input in form
    for (var key in rules) {
        // Check input is exist
        if (!(input = $(form).find('input[name="' + key + '"]'))) continue;
        // Apply tooltip for input
        input.tooltip({
            trigger: 'focus'
        });
        // Add maxlength to input
        if (rules[key].maxlength) input.attr('maxlength', rules[key].maxlength);
    }
    return $(form).validate({
        rules: rules,
        submitHandler: submitHandler
    });
}

Omss.resetForm = function(form) {
    $(form).validate().resetForm();
    $(form).find('.has-error').toggleClass('has-error', false);
    $(form).find('.has-success').toggleClass('has-success', false);
    $(form).find('input,select').tooltip('hide');
}

/*******************************************************************************
 * Utilitiy method for convert data form from serialArray method
 ******************************************************************************/
Omss.dataFromSerializeArray = function(form) {
    var data = $(form).serializeArray();
    var result = {};
    $.each(data, function(key, value) {
        result[value.name] = value.value;
    });
    return result;
}

/*******************************************************************************
 * Utilitiy method for apply mask to input tag
 ******************************************************************************/
Omss.applyInputMask = function(element) {
    if (!element.is('input')) element = element.find('input');
    element.filter('.omss_decimal').inputmask("decimal", {
        alias: 'decimal',
        groupSeparator: ',',
        autoGroup: true
    });
}

/*******************************************************************************
 * datatable
 ******************************************************************************/
Omss.dataTable = function(element, columns) {
    dt = element.dataTable({
        "lengthChange": false,
        "bDestroy": true,
        "info": false,
		"bDeferRender": true,
        "pageLength": 10, //number of row
        "pagingType": "full_numbers",
        "aoColumns": columns, //add custom class for each column
        "deferRender": true, //Deferred rendering for speed
        "aaSorting": [], //Default sort http://legacy.datatables.net/ref#aaSorting
        "language": {
            "search": "Tìm kiếm:",
            "zeroRecords": "Không có dữ liệu",
            "paginate": {
                "first": "<<",
                "last": ">>",
                "previous": "<",
                "next": ">"
            }
        },
        "fnDrawCallback": function(oSettings) {
            if ($(element).find('tr').length <= 10) {
                //$('.dataTables_paginate').hide();
            }
        }
    });
    $('input.global_filter').on('keyup click', function() {
        element.DataTable().search($(this).val(), false, true).draw();
    });
    $(".dataTables_filter").hide();
    return dt;
}

Omss.dataTableHandle = function(datatable, action, data) {
    switch (action) {
        case 2:
        case 'addRow':
            alert = "Add row";
            break;

        case 3:
        case 'deleteRow	':
            alert = Omss.$messagePopup.find('.alert.alert-warning');
            break;

        case 4:
        case 'error':
            alert = Omss.$messagePopup.find('.alert.alert-danger');
            break;

        default:
            alert = Omss.$messagePopup.find('.alert.alert-info');
            break;
    }

}

Omss.parseFloat = function(inputValue, defaultValue) {
	return Omss.parseNumer(inputValue, defaultValue, 'Float');
}

Omss.parseInt = function(inputValue, defaultValue) {
	return Omss.parseNumer(inputValue, defaultValue, 'Int');
}

Omss.parseNumer = function(inputValue, defaultValue, type) {
	// Default value is 0
	defaultValue = typeof defaultValue === 'undefined' ? NaN : defaultValue;
	// Check input value
	if (typeof inputValue === 'number') return isNaN(inputValue) ? defaultValue : inputValue;
	else inputValue = (inputValue + '').replace(/,/g, '');
	// Parse float
	var result = defaultValue;
	if (type === 'Int') result = parseInt(inputValue) || defaultValue
	else if (type === 'Float') result = parseFloat(inputValue) || defaultValue;
	return result;
}