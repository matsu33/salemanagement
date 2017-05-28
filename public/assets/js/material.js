/********************************************************************************
 ****** Material Prototype ****************************************************
 ********************************************************************************/
function Material(){};

var material = new Material();

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columns = [{ "bSearchable": true, "sClass": "center" }, 	//id
				{ "bSearchable": true}, 						//material_name
				{ "bSearchable": false, "bSortable": false} ];	//edit delete

/**
 * add material and refresh table
 */
Material.prototype.addMaterial = function() {
	Omss.post('/materials/add', $("#frm_material_add").serialize()).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListMaterial();
			$('#frm_material_add input[name$="material_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};

/**
 * delete material and refresh table
 */
Material.prototype.deleteMaterial = function() {
	var data = {
		'id': $("#delete_modal .input_material_id").val()
	};

	$('#delete_modal').modal('hide');
	
	Omss.post('/materials/delete', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListMaterial();
			$('#frm_material_add input[name$="material_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};


/**
 * update material and refresh table
 */
Material.prototype.updateMaterial = function() {
	var data = {
		'id': $("#edit_modal .input_material_id").val(),
		'material_name': $("#edit_modal .span_material_name").val()
	};

	$('#edit_modal').modal('hide');
	
	Omss.post('/materials/update', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListMaterial();
			$('#frm_material_add input[name$="material_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};


var datatable = null;
var materials = null;

/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){
	// datatable = $('#dataTables-example').dataTable();
	datatable = Omss.dataTable($("#table_material"), columns);
	
	$('#frm_material_add').submit(function (evt) {
		console.log("frm_material_add submit");
		//stop submit
		evt.preventDefault();
	});
	
	//click add button
	$("#btn_material_add").click(function(){
		console.log("btn_material_add click");
		Omss.validate($('#frm_material_add'), {
			material_name : {
				required : true,
				maxlength : 200,
			}
		}, material.addMaterial);
	});
	
	//click delete button to confirm delete
	$(".btn_material_delete").click(function(){
		console.log("btn_material_delete click");
		material.deleteMaterial();
	});
	
	//click update in modal
	$(".btn_material_update").click(function(){
		console.log("btn_material_update click");
		material.updateMaterial();
	});

	//get list Material data
	initListMaterial();
});

/**
 * get list Material data
 */
function initListMaterial(){
	console.log('getAll');
	Omss.post('materials/getAll').done(function(data) {
		if (data) {
			var result = data['status'];
			console.log(data);
			if(result == true)
			{
				materials = data['data'];
				drawListMaterial(materials);
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
 * draw list material to table
 */
function drawListMaterial(materials){
	datatable.fnClearTable(0);
	
	if(materials.length <= 0){
		Omss.showError('Chưa có chất liệu nào');
	}
	$.each( materials, function(key, item){
		var no, name, link;
		no = item['id'];
		name = item['material_name'];
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
 * @param {Object} material_name
 */
function showModalDelete(id, material_name){
	//bind data to modal
	$("#delete_modal .input_material_id").val(id);
	$("#delete_modal .span_material_name").html(material_name);
	$('#delete_modal').modal('show');
}

/**
 * show edit modal
 * @param {Object} id
 * @param {Object} material_name
 */
function showModalEdit(id, material_name){
	//bind data to modal
	$("#edit_modal .input_material_id").val(id);
	$("#edit_modal .span_material_name").val(material_name);
	$('#edit_modal').modal('show');
}