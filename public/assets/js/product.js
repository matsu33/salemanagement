/********************************************************************************
 ****** Variables ***************************************************************
 ********************************************************************************/
var UNIT_GROUP = 3;
function Product(){};

var product = new Product();
var productToAdd = {};
var productToEdit = {};
var productGroupInsert = {};
var productGroupEdit = {};
var datatable = null;
var products = null;
var datatableProductGroupInsert = null;
var datatableProductGroupEdit = null;
var newProductNeedToAddToGroup = {};
var newProductNeedToAddToGroupEdit = {};

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columnsListProduct = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	//id
				{ "bSearchable": true}, 						//
				{ "bSearchable": true}, 						//
				{ "bSearchable": true}, 						//
				{ "bSearchable": true}, 						//
				{ "bSearchable": true}, 						//
				{ "bSearchable": true}, 						//
				{ "bSearchable": false, "bSortable": false} ];	//edit delete
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
	//init datatable
	//datatable = Omss.dataTable($("#table_product"), columnsListProduct);
	
	//fill category
	fillCategoryToSelectElement(".select_category");
	
	//fill material
	fillMaterialToSelectElement(".select_material");
	
	//fill unit
	fillUnitToSelectElement(".select_unit");

	$('.input_diameter, .input_length, .input_product_range').autoNumeric('init',{aPad: false});
	
	//get list Product data
	//initListProduct();
	
	datatableProductGroupInsert = Omss.dataTable($("#table_product_group"), columnsProductGroup);
	
	// datatableProductGroupEdit
	//stop submit form
	$('#frm_product_add, #frm_product_group_add, #frm_product_group_edit').submit(function (evt) {
		//stop submit
		evt.preventDefault();
	});
	
	/*************************
	 * EVENT*****************
	 ************************/
	//click add product
	$("#btn_product_add").click(clickAddProduct);
	
	//click delete button to confirm delete
	$(".btn_product_delete").click(deleteProduct);
	
	//click update in modal
	$(".btn_product_update").click(product.updateProduct);
	
	// select_unit
	// $( "#frm_product_add .select_unit" ).change(changeUnit);
	
	//click edit group product
	$("#frm_product_add .edit_group_product").click(editProductGroup);
	$("#product_edit_modal .edit_group_product").click(showEditGroup);
	
	//add product to group
	$("#btn_product_group_add").click(clickAddProductToGroup);
	$("#btn_product_group_edit_add").click(clickAddProductToGroupEdit);
	
	
	//add product to group
	$(".btn_product_group_edit_confirm").click(clickUpdateProductButton);
	
});

/**
 * get list Product data
 */
function initListProduct(){
	console.log('initListProduct');
	/*
	Omss.post('hinhanhhanghoa/getAll').done(function(data) {
		if (data) {
			var result = data['status'];
			console.log('hinhanhhanghoa data');
			console.log(data);
			//return false;
			if(result == true)
			{
				products = data['data'];
				drawListProduct(products);
			}
			else
			{
				Omss.showError(message.getFailtFail);
			}
		} else {
			Omss.showError(message.getFail);
		}
	}).fail(function(){
		// Omss.showError(message.getFail);
	});
	*/
}

/**
 * draw list product to table
 */
function drawListProduct(products){
	console.log("drawListProduct");
	datatable.fnClearTable(0);
	
	if(products.length <= 0){
		Omss.showError('Chưa có hàng hóa nào');
	}
	$.each( products, function(key, item){
		var no, image, category_name, material_name, size_id, diameter, length, product_range, unit_name, link, product_group;
		no = item['id'];
		var product_image = item['image'];
		image = '<img class="center-block img-rounded table_thumbnail_image" src="'+imageFolderUrl+'products/'+product_image+'" alt="No-image"'+
		'onerror="this.onerror=null;this.src=\''+noImageUrl+'\'" />'; 
		category_name = item['category_name'];
		material_name = item['material_name'];
		size_id = item['size_id'];
		diameter = item['diameter'];
		length = item['length'];
		product_range = item['product_range'];
		unit_name = item['unit_name'];
		product_group = item['product_group'];
		link = '<a class="btn btn-inverse btn-primary btn_edit_delete" onclick="showModalEdit(\''+no+'\',\''+item['category_id']+'\',\''+item['material_id']+'\',\''+
		item['unit_id']+'\',\''+size_id+'\',\''+diameter+'\',\''+length+'\',\''+product_range+'\',\''+product_group+'\',\''+product_image+'\')" href="#"><i class="fa fa-edit fa-lg"></i></a>'+
		'<a class="btn btn-small btn-danger btn_edit_delete" onclick="showModalDelete(\''+no+'\',\''+product_image+'\')"><i class="fa fa-trash fa-lg"></i></a>';
		var row = [image, category_name, material_name, diameter, length, product_range, unit_name, link];
		console.log(product_group);
	    datatable.fnAddData(row, true);
	});
	datatable.fnDraw();
}

/**
 * delete product and refresh table
 */
function deleteProduct() {
	var data = {
		'id': $("#delete_modal .input_delete_product_id").val(),
		'image': $("#delete_modal .input_delete_product_image").val()
	};

	$('#delete_modal').modal('hide');
	
	Omss.post('/hinhanhhanghoa/delete', data).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			//initListProduct();
			location.reload();
			// $('#frm_product_add input[name$="product_name"]').focus();
		} else {
			Omss.showError(data.message);
		}
	});
};

/*******************************************************************
 ***START Add Product***********************************************
 *******************************************************************/
/**
 * click add button to add new product
 */
function clickAddProduct(){
	console.log("clickAddProduct");
	var formToValidate = '#frm_product_add';
	validateProductSize(formToValidate, addProductWithSize);
}

function addProductWithSize(size_id){
	console.log("addProductWithSize : " + size_id);
					
	productToAdd.size_id = size_id;
	productToAdd.category_id = $( "#frm_product_add .select_category" ).val();
	productToAdd.material_id = $( "#frm_product_add .select_material" ).val();
	productToAdd.unit_id = $( "#frm_product_add .select_unit" ).val();
	
	getProductGroupId(productGroupInsert, productToAdd, function(){checkProductExistInDatabase(productToAdd,addProductImage);} );
}


function saveProduct(){
	console.log("saveProduct");
	Omss.post('/hinhanhhanghoa/add', productToAdd).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			initListProduct();
			productGroupInsert = {};
		} else {
			console.log(productToAdd);
			Omss.showError(data.message);
			removeProductImage(productToAdd.image);
		}
	});
}

function removeProductImage(image){
	console.log("removeProductImage :" + image);
	var data = { 'image' : image };
	Omss.post('/hinhanhhanghoa/removeImage', data);
}

function addProductImage(){
	console.log("addProductImage");
	uploadProductImage("#frm_product_add", ".inputImgProduct",finishAddProductImage);
}

function finishAddProductImage(filename){
	productToAdd.image = filename;
	
	saveProduct();
}



function editProductGroup(){
	console.log("editProductGroup");
	//draw product group
	drawDatatableWithProductGroupInsert(datatableProductGroupInsert, productGroupInsert);
	
	//show modal
	$("#product_group_modal").modal('show');
}

function clearGroupProduct(){
	productGroupInsert = {};
	productGroupEdit = {};
}

function clickAddProductToGroup(){
	console.log("clickAddProductToGroup");
	newProductNeedToAddToGroup = {
						'unit_id' : $("#frm_product_group_add .select_unit").val(),
						'category_id' : $("#frm_product_group_add .select_category").val(),
						'material_id' : $("#frm_product_group_add .select_material").val()
						};
						
	validateFormAddProductGroup("#frm_product_group_add", checkProductExistInGroupInsert);
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

function checkProductExistInGroupInsert(){
	console.log('checkProductExistInGroupInsert');
	if(checkProductExistInGroup("#frm_product_group_add", productGroupInsert)){
		Omss.showError('Đã thêm hàng hóa này rồi');
	}else{
		var diameter = $("#frm_product_group_add .input_diameter").autoNumeric('get');
		var length = $("#frm_product_group_add .input_length").autoNumeric('get');
		var product_range = $("#frm_product_group_add .input_product_range").autoNumeric('get');
		
		checkSizeExist(diameter, length, product_range, setProductInfoWithSizeId);
	}
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

function setProductInfoWithSizeId(size_id){
	console.log('setProductInfoWithSizeId' + size_id);
	newProductNeedToAddToGroup.size_id = size_id;
	
	getProductInfoWithProductAttribute(newProductNeedToAddToGroup, setProductInsertWithData);
}

function setProductEditInfoWithSizeId(size_id){
	console.log('setProductEditInfoWithSizeId' + size_id);
	newProductNeedToAddToGroupEdit.size_id = size_id;
	
	getProductInfoWithProductAttribute(newProductNeedToAddToGroupEdit, setProductEditWithData);
}

function setProductInsertWithData(data){
	newProductNeedToAddToGroup = data;
	
	//add quanlity
	newProductNeedToAddToGroup.quanlity = $("#frm_product_group_add .input_group_quanlity").val();
	
	//get product id
	var productid = newProductNeedToAddToGroup.id;
	
	//set product to group
	productGroupInsert[productid] = newProductNeedToAddToGroup;
	
	//redraw list group product
	drawDatatableWithProductGroupInsert(datatableProductGroupInsert, productGroupInsert);
}

function setProductEditWithData(data){
	console.log('setProductEditWithData');
	console.log(data);
	newProductNeedToAddToGroupEdit = data;
	
	//add quanlity
	newProductNeedToAddToGroupEdit.quanlity = $("#frm_product_group_edit .input_group_quanlity").val();
	
	//get product id
	var productid = newProductNeedToAddToGroupEdit.id;
	
	//set product to group
	productGroupEdit[productid] = newProductNeedToAddToGroupEdit;
	
	//redraw list group product
	drawDatatableWithProductGroupEdit(datatableProductGroupEdit, productGroupEdit);
}

function removeProductFromGroupInsert(productid){
	console.log("removeProductFromGroupInsert" + productid);
	delete productGroupInsert[productid];
	
	drawDatatableWithProductGroupInsert(datatableProductGroupInsert, productGroupInsert);
}

function removeProductFromGroupEdit(productid){
	console.log("removeProductFromGroupEdit" + productid);
	delete productGroupEdit[productid];
	
	drawDatatableWithProductGroupEdit(datatableProductGroupEdit, productGroupEdit);
}

/**
 * Draw table with group product
 */
function drawDatatableWithProductGroupInsert(datatable, group){
	console.log("drawDatatableWithProductGroupInsert");
	datatable.fnClearTable(0);
	$.each( group, function(key, item){
		var imageLink = '<img class="center-block img-rounded table_thumbnail_image" src="'+imageFolderUrl+'products/'+item.image+'" alt="No-image"'+
		'onerror="this.onerror=null;this.src=\''+noImageUrl+'\'" />';  
		var linkDelete = '<a class="btn btn-danger edit_group_product" onclick="removeProductFromGroupInsert(\''+item.id+'\')"><span class="glyphicon glyphicon-remove"></span></a>';
		var row = [imageLink, item.category_name, item.material_name, item.diameter, item.length, 
		item.product_range, item.unit_name, item.quanlity, linkDelete];
		
		datatable.fnAddData(row, true);
	});
	datatable.fnDraw();
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
		var linkDelete = '<a class="btn btn-danger edit_group_product" onclick="removeProductFromGroupEdit(\''+item.sub_product_id+'\')"><span class="glyphicon glyphicon-remove"></span></a>';
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
	if(diameter != productToEdit.diameter || productToEdit.length != length || productToEdit.product_range != product_range){
		checkSizeExist(diameter, length, product_range, addSizeIdToProduct);
	}else{
		addSizeIdToProduct(productToEdit.size_id);
	}

	
}

function addSizeIdToProduct(size_id){
	productToEdit.size_id = size_id;
	
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
			//update product success
			//initListProduct();
			location.reload();
			//$("#product_group_modal_edit").modal('hide');
		} else {
			console.log(productToEdit);
			Omss.showError(data.message);
		}
	});
}

