/********************************************************************************
 ****** NhaCungCap Prototype ****************************************************
 ********************************************************************************/
function NhaCungCap(){};

var nhacungcap = new NhaCungCap();

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columns = [{ "bSearchable": true, "sClass": "center" }, 	//id
				{ "bSearchable": true}, 						//publisher_name
				{ "bSearchable": false, "bSortable": false} ];	//edit delete

/**
 * add publisher and refresh table
 */
NhaCungCap.prototype.addPublisher = function() {
	Omss.post('/nhacungcap/add', $("#frm_publisher_add").serialize()).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListPublisher();
			$('#frm_publisher_add input[name$="publisher_name"]').focus();
			Omss.showMessage("Đã thêm thành công");
		} else {
			Omss.showError(data.message);
		}
	});
};

/**
 * delete publisher and refresh table
 */
NhaCungCap.prototype.deletePublisher = function() {
	var data = {
		'id': $("#delete_modal .input_publisher_id").val()
	};

	$('#delete_modal').modal('hide');
	
	Omss.post('/nhacungcap/delete', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListPublisher();
			$('#frm_publisher_add input[name$="publisher_name"]').focus();
			Omss.showMessage("Đã xóa thành công");
		} else {
			Omss.showError(data.message);
		}
	});
};


/**
 * update publisher and refresh table
 */
NhaCungCap.prototype.updatePublisher = function() {
	var data = {
		'id': $("#edit_modal .input_publisher_id").val(),
		'publisher_name': $("#edit_modal .span_publisher_name").val()
	};

	$('#edit_modal').modal('hide');
	
	Omss.post('/nhacungcap/update', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListPublisher();
			$('#frm_publisher_add input[name$="publisher_name"]').focus();
			Omss.showMessage("Đã cập nhật thành công");
		} else {
			Omss.showError(data.message);
		}
	});
};


var datatable = null;
var publishers = null;

/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){
	// datatable = $('#dataTables-example').dataTable();
//	datatable = Omss.dataTable($("#table_publisher"), columns);
	
	$('#frm_publisher_add').submit(function (evt) {
		console.log("frm_publisher_add submit");
		//stop submit
		evt.preventDefault();
	});
	
	//click add button
	$("#btn_publisher_add").click(function(){
		console.log("btn_publisher_add click");
		Omss.validate($('#frm_publisher_add'), {
			publisher_name : {
				required : true,
				maxlength : 200,
			}
		}, nhacungcap.addPublisher);
	});
	
	//click delete button to confirm delete
	$(".btn_publisher_delete").click(function(){
		console.log("btn_publisher_delete click");
		nhacungcap.deletePublisher();
	});
	
	//click update in modal
	$(".btn_publisher_update").click(function(){
		console.log("btn_publisher_update click");
		nhacungcap.updatePublisher();
	});

	//get list publisher data
//	initListPublisher();
});

/**
 * get list publisher data
 */
function initListPublisher(){
    location.reload();
    return false;
	console.log('getAll');
	Omss.post('nhacungcap/getAll').done(function(data) {
		if (data) {
			var result = data['status'];
			console.log(data);
			if(result == true)
			{
				publishers = data['data'];
				drawListPublisher(publishers);
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
 * draw list publisher to table
 */
function drawListPublisher(publishers){
	datatable.fnClearTable(0);
	
	if(publishers.length <= 0){
		Omss.showError('Chưa có nhà cung cấp nào');
	}
	$.each( publishers, function(key, item){
		var no, name, link;
		no = item['id'];
		name = item['publisher_name'];
		link = '<a class="btn btn-inverse btn-primary btn_edit_delete" onclick="showModalEdit(\''+no+'\',\''+name+'\')" href="#"><i class="fa fa-edit fa-lg"></i></a>'+
		'<a class="btn btn-small btn-danger btn_edit_delete" onclick="showModalDelete(\''+no+'\',\''+name+'\')"><i class="fa fa-trash fa-lg"></i></a>';
		var row = [no, name, link];

	    datatable.fnAddData(row, true);
	});
	datatable.fnDraw();
}

/**
 * show delete modal
 * @param {Object} id
 * @param {Object} publisher_name
 */
function showModalDelete(id, publisher_name){
	//bind data to modal
	$("#delete_modal .input_publisher_id").val(id);
	$("#delete_modal .span_publisher_name").html(publisher_name);
	$('#delete_modal').modal('show');
}

/**
 * show edit modal
 * @param {Object} id
 * @param {Object} publisher_name
 */
function showModalEdit(id, publisher_name){
	//bind data to modal
	$("#edit_modal .input_publisher_id").val(id);
	$("#edit_modal .span_publisher_name").val(publisher_name);
	$('#edit_modal').modal('show');
}