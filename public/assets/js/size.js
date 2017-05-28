/********************************************************************************
 ****** Size Prototype ****************************************************
 ********************************************************************************/
function Size(){};

var size = new Size();

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columns = [{ "bSearchable": true, "sClass": "center" }, 	//id
				{ "bSearchable": true}, 						//diameter
				{ "bSearchable": true}, 						//length
				{ "bSearchable": true}, 						//product_range
				{ "bSearchable": false, "bSortable": false} ];	//edit delete

/**
 * add size and refresh table
 */
Size.prototype.addSize = function() {
	Omss.post('/sizes/add', $("#frm_size_add").serialize()).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListSize();
			$('#frm_size_add input[name$="diameter"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};

/**
 * delete size and refresh table
 */
Size.prototype.deleteSize = function() {
	var data = {
		'id': $("#delete_modal .input_size_id").val()
	};

	$('#delete_modal').modal('hide');
	
	Omss.post('/sizes/delete', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListSize();
			$('#frm_size_add input[name$="diameter"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};


/**
 * update size and refresh table
 */
Size.prototype.updateSize = function() {
	var data = {
		'id': $("#edit_modal .input_size_id").val(),
		'diameter': $("#edit_modal .span_diameter").val(),
		'length': $("#edit_modal .span_length").val(),
		'product_range': $("#edit_modal .span_product_range").val()
	};

	$('#edit_modal').modal('hide');
	
	Omss.post('/sizes/update', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListSize();
			$('#frm_size_add input[name$="diameter"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};


var datatable = null;
var sizes = null;

/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){
	// datatable = $('#dataTables-example').dataTable();
	datatable = Omss.dataTable($("#table_size"), columns);
	
	$('#frm_size_add').submit(function (evt) {
		console.log("frm_size_add submit");
		//stop submit
		evt.preventDefault();
	});
	
	//click add button
	$("#btn_size_add").click(function(){
		console.log("btn_size_add click");
		Omss.validate($('#frm_size_add'), {
			diameter : {
				required: true,
				number: true,
				maxlength : 10,
			},
			length : {
				required: false,
				number: true,
				maxlength : 10,
			},
			product_range : {
				required: false,
				number: true,
				maxlength : 10,
			}
		}, size.addSize);
	});
	
	//click delete button to confirm delete
	$(".btn_size_delete").click(function(){
		console.log("btn_size_delete click");
		size.deleteSize();
	});
	
	//click update in modal
	$(".btn_size_update").click(function(){
		console.log("btn_size_update click");
		size.updateSize();
	});

	//get list Size data
	initListSize();
});

/**
 * get list Size data
 */
function initListSize(){
	console.log('getAll');
	Omss.post('sizes/getAll').done(function(data) {
		if (data) {
			var result = data['status'];
			console.log(data);
			if(result == true)
			{
				sizes = data['data'];
				drawListSize(sizes);
			}
			else
			{
				Omss.showError(message.getFailtFail);
			}
		} else {
			Omss.showError(message.getFail);
		}
	}).fail(function(){
		Omss.showError(message.getFail);
	});
	
}

/**
 * draw list size to table
 */
function drawListSize(sizes){
	datatable.fnClearTable(0);
	if(sizes.length <= 0){
		Omss.showError('Chưa có quy cách nào');
	}
	$.each( sizes, function(key, item){
		var no, diameter, length, product_range, link;
		no = item['id'];
		diameter = item['diameter'];
		length = item['length'];
		product_range = item['product_range'];
		link = '<a class="btn btn-inverse btn-primary btn_edit_delete" onclick="showModalEdit(\''+no+'\',\''+diameter+'\',\''+length+'\',\''+product_range+'\')" href="#"><i class="fa fa-edit fa-lg"></i></a>'+
		'<a class="btn btn-small btn-danger btn_edit_delete" onclick="showModalDelete(\''+no+'\',\''+diameter+'\',\''+length+'\',\''+product_range+'\')"><i class="fa fa-trash fa-lg"></i></a>';
		var row = [no, diameter, length, product_range, link];
		console.log(row);
	    datatable.fnAddData(row, true);
	});
	datatable.fnDraw();
}

/**
 * show delete modal
 * @param {Object} id
 * @param {Object} size_name
 */
function showModalDelete(id, diameter, length, product_range){
	//bind data to modal
	$("#delete_modal .input_size_id").val(id);
	$("#delete_modal .span_diameter").html(diameter);
	$("#delete_modal .span_length").html(length);
	$("#delete_modal .span_product_range").html(product_range);
	$('#delete_modal').modal('show');
}

/**
 * show edit modal
 * @param {Object} id
 * @param {Object} size_name
 */
function showModalEdit(id, diameter, length, product_range){
	//bind data to modal
	$("#edit_modal .input_size_id").val(id);
	$("#edit_modal .span_diameter").val(diameter);
	$("#edit_modal .span_length").val(length);
	$("#edit_modal .span_product_range").val(product_range);
	$('#edit_modal').modal('show');
}