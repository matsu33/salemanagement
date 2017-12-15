/********************************************************************************
 ****** Unit Prototype ****************************************************
 ********************************************************************************/
function Unit(){};

var unit = new Unit();

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columns = [{ "bSearchable": true, "sClass": "center" }, 	//id
				{ "bSearchable": true}, 						//unit_name
				{ "bSearchable": false, "bSortable": false} ];	//edit delete

/**
 * add unit and refresh table
 */
Unit.prototype.addUnit = function() {
	Omss.post('/units/add', $("#frm_unit_add").serialize()).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListUnit();
			$('#frm_unit_add input[name$="unit_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};

/**
 * delete unit and refresh table
 */
Unit.prototype.deleteUnit = function() {
	var data = {
		'id': $("#delete_modal .input_unit_id").val()
	};

	$('#delete_modal').modal('hide');
	
	Omss.post('/units/delete', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListUnit();
			$('#frm_unit_add input[name$="unit_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};


/**
 * update unit and refresh table
 */
Unit.prototype.updateUnit = function() {
	var data = {
		'id': $("#edit_modal .input_unit_id").val(),
		'unit_name': $("#edit_modal .span_unit_name").val()
	};

	$('#edit_modal').modal('hide');
	
	Omss.post('/units/update', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListUnit();
			$('#frm_unit_add input[name$="unit_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};


var datatable = null;
var units = null;

/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){
	// datatable = $('#dataTables-example').dataTable();
//	datatable = Omss.dataTable($("#table_unit"), columns);
	
	$('#frm_unit_add').submit(function (evt) {
		console.log("frm_unit_add submit");
		//stop submit
		evt.preventDefault();
	});
	
	//click add button
	$("#btn_unit_add").click(function(){
		console.log("btn_unit_add click");
		Omss.validate($('#frm_unit_add'), {
			unit_name : {
				required : true,
				maxlength : 200,
			}
		}, unit.addUnit);
	});
	
	//click delete button to confirm delete
	$(".btn_unit_delete").click(function(){
		console.log("btn_unit_delete click");
		unit.deleteUnit();
	});
	
	//click update in modal
	$(".btn_unit_update").click(function(){
		console.log("btn_unit_update click");
		unit.updateUnit();
	});

	//get list Unit data
//	initListUnit();
});

/**
 * get list Unit data
 */
function initListUnit(){
    location.reload();
    return false;
	console.log('getAll');
	Omss.post('units/getAll').done(function(data) {
		if (data) {
			var result = data['status'];
			console.log(data);
			if(result == true)
			{
				units = data['data'];
				drawListUnit(units);
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
 * draw list unit to table
 */
function drawListUnit(units){
	datatable.fnClearTable(0);
	
	if(units.length <= 0){
		Omss.showError('Chưa có đơn vị nào');
	}
	$.each( units, function(key, item){
		var no, name, link;
		no = item['id'];
		name = item['unit_name'];
		link = '<a class="btn btn-inverse btn-primary btn_edit_delete" onclick="showModalEdit(\''+no+'\',\''+name+'\')" href="#"><i class="fa fa-edit fa-lg"></i></a>'+
		'<a class="btn btn-small btn-danger btn_edit_delete" onclick="showModalDelete(\''+no+'\',\''+name+'\')"><i class="fa fa-trash fa-lg"></i></a>';
		var row = [no, name, link];
		console.log(row);
	    datatable.fnAddData(row, true);
	});
	datatable.fnDraw();
}

/**
 * show delete modal
 * @param {Object} id
 * @param {Object} unit_name
 */
function showModalDelete(id, unit_name){
	//bind data to modal
	$("#delete_modal .input_unit_id").val(id);
	$("#delete_modal .span_unit_name").html(unit_name);
	$('#delete_modal').modal('show');
}

/**
 * show edit modal
 * @param {Object} id
 * @param {Object} unit_name
 */
function showModalEdit(id, unit_name){
	//bind data to modal
	$("#edit_modal .input_unit_id").val(id);
	$("#edit_modal .span_unit_name").val(unit_name);
	$('#edit_modal').modal('show');
}