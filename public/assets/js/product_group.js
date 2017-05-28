/********************************************************************************
 ****** Variables ***************************************************************
 ********************************************************************************/
var productGroupInsert = {};
var productGroupEdit = {};

var datatableProductGroupInsert = null;
var datatableProductGroupEdit = null;

var newProductNeedToAddToGroup = {};
var newProductNeedToAddToGroupEdit = {};

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columnsProductGroup = [	{ "bSearchable": false, "sClass": "center", "bSortable": false },
							{ "bSearchable": true}, 	
							{ "bSearchable": true}, 						//
							{ "bSearchable": true}, 						//
							{ "bSearchable": true}, 						//
							{ "bSearchable": true}, 						//
							{ "bSearchable": true}, 						//
							{ "bSearchable": true}, 						//
							{ "bSearchable": false, "bSortable": false} ];	//edit delete


/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){	
	datatableProductGroupInsert = Omss.dataTable($("#table_product_group"), columnsProductGroup);
	
	$('.input_diameter, .input_length, .input_product_range, .input_group_quanlity').autoNumeric('init',{aPad: false});
	
	// datatableProductGroupEdit
	//stop submit form
	$('#frm_product_group_add, #frm_product_group_edit').submit(function (evt) {
		//stop submit
		evt.preventDefault();
	});
	
	/*************************
	 * EVENT*****************
	 ************************/	
	//add product to group
	$("#btn_product_group_add").click(clickAddProductToGroup);
	$("#btn_product_group_edit_add").click(clickAddProductToGroupEdit);
	
	//add, edit product group
	$(".edit_group_product").click(editProductGroup);
});
/*************************************************
 * COMMON FUNCTION
 *************************************************/

/**************************************************
 * START INSERT PRODUCT GROUP FUNCTION
 *************************************************/
/**
 * 1.click button add product to group
 */
function clickAddProductToGroup(){
	console.log("clickAddProductToGroup");
	newProductNeedToAddToGroup = {
						'unit_id' : $("#frm_product_group_add .select_unit").val(),
						'category_id' : $("#frm_product_group_add .select_category").val(),
						'material_id' : $("#frm_product_group_add .select_material").val()
						};
	//call common function validate form product group						
	validateFormAddProductGroup("#frm_product_group_add", checkProductExistInGroupInsert);
}

/**
 * 2.check product exist in group insert
 */
function checkProductExistInGroupInsert(){
	console.log('checkProductExistInGroupInsert');
	if(checkProductExistInGroup("#frm_product_group_add", productGroupInsert)){
		Omss.showError('Đã thêm hàng hóa này rồi');
	}else{
		var diameter = $("#frm_product_group_add .input_diameter").autoNumeric('get');
		var length = $("#frm_product_group_add .input_length").autoNumeric('get');
		var product_range = $("#frm_product_group_add .input_product_range").autoNumeric('get');
		
		//call common function to check and get size id if exist
		checkSizeExist(diameter, length, product_range, setProductInsertInfoWithSizeId);
	}
}

/**
 * 3. set size id to product insert
 */
function setProductInsertInfoWithSizeId(size_id){
	console.log('setProductInsertInfoWithSizeId' + size_id);
	newProductNeedToAddToGroup.size_id = size_id;
	
	//call common function to get product info
	getProductInfoWithProductAttribute(newProductNeedToAddToGroup, setProductInsertWithData);
}

/**
 * 4. set product insert with data callback from server
 */
function setProductInsertWithData(data){
	newProductNeedToAddToGroup = data;
	
	//add quanlity
	newProductNeedToAddToGroup.quanlity = $("#frm_product_group_add .input_group_quanlity").autoNumeric('get');
	
	//get product id
	var productid = newProductNeedToAddToGroup.id;
	
	//set product to group
	productGroupInsert[productid] = newProductNeedToAddToGroup;
	
	//redraw list group product
	drawDatatableWithProductGroupInsert(datatableProductGroupInsert, productGroupInsert);
}


/**
 * 4. Draw table with group product
 */
function drawDatatableWithProductGroupInsert(datatable, group){
	console.log("drawDatatableWithProductGroupInsert");
	datatable.fnClearTable(0);
	$.each( group, function(key, item){
		var imageLink = '<img class="center-block img-rounded table_thumbnail_image" src="'+imageFolderUrl+'products/'+item.image+'" alt="No-image"'+
		'onerror="this.onerror=null;this.src=\''+noImageUrl+'\'" />';  
		var linkDelete = '<a class="btn btn-danger" onclick="removeProductFromGroupInsert(\''+item.id+'\')"><span class="glyphicon glyphicon-remove"></span></a>';
		var row = [imageLink, item.category_name, item.material_name, item.diameter, item.length, 
		item.product_range, item.unit_name, item.quanlity, linkDelete];
		
		datatable.fnAddData(row, true);
	});
	datatable.fnDraw();
}

/**
 * 4.1 Remove product from group insert
 */
function removeProductFromGroupInsert(productid){
	console.log("removeProductFromGroupInsert" + productid);
	delete productGroupInsert[productid];
	
	drawDatatableWithProductGroupInsert(datatableProductGroupInsert, productGroupInsert);
}

/**
 * 4.2 clear list product group
 */
function clearGroupProduct(){
	productGroupInsert = {};
	productGroupEdit = {};
}


/**************************************************
 * END INSERT PRODUCT GROUP FUNCTION
 *************************************************/

/**************************************************
 * START EDIT PRODUCT GROUP FUNCTION
 *************************************************/
/**
 * click edit product group
 */
function editProductGroup(){
	console.log("editProductGroup");
	//draw product group
	drawDatatableWithProductGroupInsert(datatableProductGroupInsert, productGroupInsert);
	
	//show modal
	// $("#product_group_modal").modal('show');
}

function clickAddProductToGroupEdit(){
	console.log("clickAddProductToGroup");
	newProductNeedToAddToGroupEdit = {
						'unit_id' : $("#frm_product_group_edit .select_unit").val(),
						'category_id' : $("#frm_product_group_edit .select_category").val(),
						'material_id' : $("#frm_product_group_edit .select_material").val()
						};
						
	validateFormAddProductGroup("#frm_product_group_edit", checkProductExistInGroupEdit);
}



function checkProductExistInGroupEdit(){
	console.log('checkProductExistInGroupEdit');
	if(checkProductExistInGroup("#frm_product_group_edit", productGroupEdit)){
		Omss.showError('Đã thêm hàng hóa này rồi');
	}else{
		var diameter = $("#frm_product_group_edit .input_diameter").autoNumeric('get');
		var length = $("#frm_product_group_edit .input_length").autoNumeric('get');
		var product_range = $("#frm_product_group_edit .input_product_range").autoNumeric('get');
		
		checkSizeExist(diameter, length, product_range, setProductEditInfoWithSizeId);
	}
}



function setProductEditInfoWithSizeId(size_id){
	console.log('setProductEditInfoWithSizeId' + size_id);
	newProductNeedToAddToGroupEdit.size_id = size_id;
	
	getProductInfoWithProductAttribute(newProductNeedToAddToGroupEdit, setProductEditWithData);
}



function setProductEditWithData(data){
	console.log('setProductEditWithData');
	console.log(data);
	newProductNeedToAddToGroupEdit = data;
	
	//add quanlity
	newProductNeedToAddToGroupEdit.quanlity = $("#frm_product_group_edit .input_group_quanlity").autoNumeric('get');
	
	//get product id
	var productid = newProductNeedToAddToGroupEdit.id;
	
	//set product to group
	productGroupEdit[productid] = newProductNeedToAddToGroupEdit;
	
	//redraw list group product
	drawDatatableWithProductGroupEdit(datatableProductGroupEdit, productGroupEdit);
}


function removeProductFromGroupEdit(productid){
	console.log("removeProductFromGroupEdit" + productid);
	delete productGroupEdit[productid];
	
	drawDatatableWithProductGroupEdit(datatableProductGroupEdit, productGroupEdit);
}


/**
 * Draw table with group product
 */
function drawDatatableWithProductGroupEdit(datatable, group){
	console.log("drawDatatableWithProductGroupEdit");
	datatable.fnClearTable(0);
	$.each( group, function(key, item){
		var imageLink = '<img class="center-block img-rounded table_thumbnail_image" src="'+imageFolderUrl+'products/'+item.image+'" alt="No-image"'+
		'onerror="this.onerror=null;this.src=\''+noImageUrl+'\'" />';  
		var linkDelete = '<a class="btn btn-danger" onclick="removeProductFromGroupEdit(\''+item.sub_product_id+'\')"><span class="glyphicon glyphicon-remove"></span></a>';
		var row = [imageLink, item.category_name, item.material_name, item.diameter, item.length, 
		item.product_range, item.unit_name, item.quanlity, linkDelete];
		
		datatable.fnAddData(row, true);
	});
	datatable.fnDraw();
}

/**
 * show delete modal
 * @param {Object} id
 * @param {Object} product_name
 */
function showModalDelete(id, image){
	//bind data to modal
	$("#delete_modal .input_delete_product_id").val(id);
	$("#delete_modal .input_delete_product_image").val(image);
	$('#delete_modal').modal('show');
}


/*******************************************************************
 ***END Add Product***********************************************
 *******************************************************************/

/*******************************************************************
 ***START Edit Product***********************************************
 *******************************************************************/

/**
 * show edit modal
 * @param {Object} id
 * @param {Object} product_name
 */
function showModalEdit(id, category_id, material_id, unit_id, size_id, diameter, length, product_range, product_group, product_image){
	console.log("showModalEdit product_group : " + product_group);
	productToEdit = { 'id' : id ,
						'category_id' : category_id ,
						'material_id' : material_id ,
						'unit_id' : unit_id ,
						'size_id' : size_id ,
						'diameter' : diameter ,
						'length' : length ,
						'product_range' : product_range ,
						'product_image' : product_image ,
						'product_group' : product_group
					};
	//bind data to modal
	$("#product_edit_modal .product_id_edit").val(id);
	$("#product_edit_modal .select_category").val(category_id);
	$("#product_edit_modal .select_material").val(material_id);
	$("#product_edit_modal .input_diameter").val(diameter);
	$("#product_edit_modal .input_length").val(length);
	$("#product_edit_modal .input_product_range").val(product_range);
	$("#product_edit_modal .select_unit").val(unit_id);
	$("#product_edit_modal .imgProductPreview").attr("src",imageFolderUrl+'products/'+product_image);
	$("#product_edit_modal .imgProductPreview").attr("onerror","this.onerror=null;this.src=\''+noImageUrl+'\'");
	$('#product_edit_modal').modal('show');
	
	productGroupEdit = {};
	
	if(!datatableProductGroupEdit){
		datatableProductGroupEdit = Omss.dataTable($("#table_product_group_edit"), columnsProductGroup);
	}
	
	//get product group
	if(product_group != 0){
		// getListProductGroup
		var data = {
			'product_group': product_group
		};
		console.log('getListProductGroup : ' + product_group);
		Omss.post('/hinhanhhanghoa/getListProductGroup', data).done(function(data) {
			console.log(data);
			if (data.status == 1) {
				// productGroupEdit = data.data;
				
				console.log('===================');
				$.each( data.data, function(key, item){
					productGroupEdit[item.sub_product_id] = item;
					console.log(item);
				});
				console.log('===================');
				console.log('productGroupEdit');
				console.log(productGroupEdit);
				drawDatatableWithProductGroupEdit(datatableProductGroupEdit, productGroupEdit);
			} else {
				Omss.showError(data.message);
			}
		});		
	}else{
		drawDatatableWithProductGroupEdit(datatableProductGroupEdit, productGroupEdit);
	}
}

function showEditGroup(){
	$("#product_group_modal_edit").modal('show');
}
function clickUpdateProductButton(){
	console.log('clickUpdateProductButton');
	var category_id = $("#product_edit_modal .select_category").val();
	var material_id = $("#product_edit_modal .select_material").val();
	var unit_id = $("#product_edit_modal .select_unit").val();
	
	productToEdit.category_id = category_id;
	productToEdit.material_id = material_id;
	productToEdit.unit_id = unit_id;
	
	var diameter = $("#product_edit_modal .input_diameter").autoNumeric('get');
	var length = $("#product_edit_modal .input_length").autoNumeric('get');
	var product_range = $("#product_edit_modal .input_product_range").autoNumeric('get');
	
	//check size
	if(diameter == productToEdit.diameter && productToEdit.length == length && productToEdit.product_range == product_range){
		checkSizeExist(diameter, length, product_range, addSizeIdToProduct);
	}else{
		addSizeIdToProduct(productToEdit.size_id);
	}

	
}

function addSizeIdToProduct(size_id){
	productToEdit.size_id = productToEdit.size_id;
	
	//check product group
	getProductGroupId(productGroupEdit, productToEdit, checkImageProductEdit);
}

function checkImageProductEdit(){
	// var arr = $('#inputImgProductEdit').attr('src').split('.');
	// var imageName = $('#imgProductPreviewEdit').attr('src').split('/').pop();
	
	uploadProductImage("#frm_product_edit", ".inputImgProduct",finishEditProductImage);
}

function finishEditProductImage(filename){
	if(filename != ''){
		productToEdit.image = filename;
	}
	
	updateProduct();
}

function updateProduct(){
	console.log("updateProduct");
	Omss.post('/hinhanhhanghoa/update', productToEdit).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListProduct();
			$("#product_group_modal_edit").modal('hide');
		} else {
			console.log(productToEdit);
			Omss.showError(data.message);
		}
	});
}

