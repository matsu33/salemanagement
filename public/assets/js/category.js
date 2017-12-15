/********************************************************************************
 ****** Category Prototype ****************************************************
 ********************************************************************************/
function Category(){};

var category = new Category();

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columns = [{ "bSearchable": true, "sClass": "center" }, 	//id
				{ "bSearchable": true}, 						//category_name
				{ "bSearchable": false, "bSortable": false} ];	//edit delete

/**
 * add category and refresh table
 */
Category.prototype.addCategory = function() {
	Omss.post('/categories/add', $("#frm_category_add").serialize()).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListCategory();
			$('#frm_category_add input[name$="category_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};

/**
 * delete category and refresh table
 */
Category.prototype.deleteCategory = function() {
	var data = {
		'id': $("#delete_modal .input_category_id").val()
	};

	$('#delete_modal').modal('hide');
	
	Omss.post('/categories/delete', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListCategory();
			$('#frm_category_add input[name$="category_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};


/**
 * update category and refresh table
 */
Category.prototype.updateCategory = function() {
	var data = {
		'id': $("#edit_modal .input_category_id").val(),
		'category_name': $("#edit_modal .span_category_name").val()
	};

	$('#edit_modal').modal('hide');
	
	Omss.post('/categories/update', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListCategory();
			$('#frm_category_add input[name$="category_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};


var datatable = null;
var categorys = null;

/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){
	// datatable = $('#dataTables-example').dataTable();
//	datatable = Omss.dataTable($("#table_category"), columns);
	
	$('#frm_category_add').submit(function (evt) {
		console.log("frm_category_add submit");
		//stop submit
		evt.preventDefault();
	});
	
	//click add button
	$("#btn_category_add").click(function(){
		console.log("btn_category_add click");
		Omss.validate($('#frm_category_add'), {
			category_name : {
				required : true,
				maxlength : 200,
			}
		}, category.addCategory);
	});
	
	//click delete button to confirm delete
	$(".btn_category_delete").click(function(){
		console.log("btn_Category_delete click");
		category.deleteCategory();
	});
	
	//click update in modal
	$(".btn_category_update").click(function(){
		console.log("btn_Category_update click");
		category.updateCategory();
	});

	//get list Category data
//	initListCategory();
});

/**
 * get list Category data
 */
function initListCategory(){
    location.reload();
    return false;
	console.log('getAll');
	Omss.post('categories/getAll').done(function(data) {
		if (data) {
			var result = data['status'];
			console.log(data);
			if(result == true)
			{
				categorys = data['data'];
				drawListCategory(categorys);
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
 * draw list category to table
 */
function drawListCategory(categorys){
	datatable.fnClearTable(0);
	
	if(categorys.length <= 0){
		Omss.showError('Chưa có loại hàng hóa nào');
	}
	$.each( categorys, function(key, item){
		var no, name, link;
		no = item['id'];
		name = item['category_name'];
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
 * @param {Object} category_name
 */
function showModalDelete(id, category_name){
	//bind data to modal
	$("#delete_modal .input_category_id").val(id);
	$("#delete_modal .span_category_name").html(category_name);
	$('#delete_modal').modal('show');
}

/**
 * show edit modal
 * @param {Object} id
 * @param {Object} category_name
 */
function showModalEdit(id, category_name){
	//bind data to modal
	$("#edit_modal .input_category_id").val(id);
	$("#edit_modal .span_category_name").val(category_name);
	$('#edit_modal').modal('show');
}