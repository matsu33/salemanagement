/********************************************************************************
 ****** Variables ***************************************************************
 ********************************************************************************/
var tableListPriceElement = "#table_so_sanh_gia";
var tableListPublisher = "#table_publisher";

var formSearchPrice = "#frm_so_sanh_gia";
var formInputPriceRate = "#frm_input_price_rate";

var datatable = null;
var listProductPrice = null;
var datatablePublisher = null;

var listPublisherPrice = null;

var selectedProductId = null;
var selectedPublisherId = null;

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columnsList = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	// <th>Hình ảnh</th>
				{ "bSearchable": true}, 						//<th>Tên hàng hóa</th>
				{ "bSearchable": true}, 						//<th>Chất liệu</th>
				{ "bSearchable": true}, 						//<th>Đường kính</th>
				{ "bSearchable": true}, 						//<th>Chiều dài</th>
				{ "bSearchable": true}, 						//<th>Bước răng</th>
				{ "bSearchable": true}, 						//<th>Đơn vị</th>
				{ "bSearchable": true}, 						//<th>Giá bán sỉ</th>
				{ "bSearchable": true}, 						//<th>Giá bán sỉ</th>
				{ "bSearchable": true}, 						//<th>Giá bán sỉ</th>
				{ "bSearchable": true}, 						//<th>Giá bán lẻ</th>
				{ "bSearchable": false, "bSortable": false} ];	//edit delete
				
var columnsListPublisher = [{ "bSearchable": true}, 						//<th>Nhà cung cấp</th>
							{ "bSearchable": true}, 						//<th>Giá mua</th>
							{ "bSearchable": true}, 						//<th>Trạng thái</th>
							{ "bSearchable": false, "bSortable": false} ];	//edit delete
/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){	
	//init datatable
	datatable = Omss.dataTable($(tableListPriceElement), columnsList);
	datatablePublisher = Omss.dataTable($(tableListPublisher), columnsListPublisher);
	
	//fill category
	fillCategoryToSelectElement(".select_category");
	
	//fill material
	fillMaterialToSelectElement(".select_material");

	//stop submit form
	$(("#frm_so_sanh_gia, #frm_input_price_rate")).submit(function (evt) {
		//stop submit
		evt.preventDefault();
	});

	$('.input_diameter, .input_length, .input_product_range, .wholesales_rate, .retail_rate').autoNumeric('init',{aPad: false});
	
	/*************************
	 * EVENT*****************
	 ************************/
	//click btn_search_price
	$(".btn_search_price").click(clickSearchPriceButton);
	
	//click button btn_confirm_input_price_rate
	$("#btn_confirm_input_price_rate").click(clickConfirmInputPriceRate);
	
	$(".btn_print_list_price").click(clickButtonPrintListPrice);
});

function clickButtonPrintListPrice(){
	console.log("clickButtonPrintListPrice");
	filterSearch = null;
	var data = {
	        category_id: $(".select_category").val(),
	        category_name: $(".select_category").text(),
	        material_id: $(".select_material").val(),
	        material_name: $(".select_material").text()
	    };
	post_to_url('/sosanhgia/print',data,null);
	// Omss.post('/sosanhgia/print', filterSearch).done(function(data) {
		// console.log(data);
		// if (data.status == 1) {
			// // listPublisherPrice = data['data'];
			// // drawListPublisherWithPrice(listPublisherPrice);
		// } else {
			// Omss.showError(data.message);
		// }
	// });
}

/**
 * click button search
 */
function clickSearchPriceButton(){
	console.log("clickSearchPriceButton");
	
	Omss.validate($(formSearchPrice), {
			input_diameter : {
				number: true,
				maxlength : 10,
			},
			input_length : {
				number: true,
				maxlength : 10,
			},
			input_product_range : {
				number: true,
				maxlength : 10,
			}
		}, finishValidateSearchForm() );
		
}

function finishValidateSearchForm(){
	console.log("finishValidateSearchForm");
	console.log("===START SEARCH===");
	var filterSearch = {
		'category_id' : $(formSearchPrice).find('.select_category').val(),
		'material_id' : $(formSearchPrice).find('.select_material').val(),
		'diameter' : $(formSearchPrice).find('.input_diameter').autoNumeric('get'),
		'length' : $(formSearchPrice).find('.input_length').autoNumeric('get'),
		'product_range' : $(formSearchPrice).find('.input_product_range').autoNumeric('get')
	};
	Omss.post('/sosanhgia/search', filterSearch).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			listProductPrice = data['data'];
			drawListProductPrice(listProductPrice);
		} else {
			Omss.showError(data.message);
		}
	});
}

/**
 * draw list product to table
 */
function drawListProductPrice(listProductPrice){
	console.log("drawListProductPrice");
	datatable.fnClearTable(0);
	
	if(listProductPrice.length <= 0){
		Omss.showError('Chưa có báo giá nào');
	}
	$.each( listProductPrice, function(key, item){
		var no, image, publisher_name, category_name, material_name, size_id, diameter, length, product_range, unit_name, input_price, link, product_group;
		no = item['product_id'];
		var product_image = item['image'];
		image = '<img class="center-block img-rounded table_thumbnail_image" src="'+imageFolderUrl+'products/'+product_image+'" alt="No-image"'+
		'onerror="this.onerror=null;this.src=\''+noImageUrl+'\'" />';// <th>Hình ảnh</th>
		// publisher_name = item['publisher_name'];// <th>Nhà cung cấp</th>
		category_name = item['category_name'];// <th>Tên hàng hóa</th>
		material_name = item['material_name'];// <th>Chất liệu</th>
		diameter = item['diameter'];// <th>Đường kính</th>
		length = item['length'];// <th>Chiều dài</th>
		product_range = item['product_range'];// <th>Bước răng</th>
		unit_name = item['unit_name'];// <th>Đơn vị</th>
		input_price = item['input_price'];// <th>Giá mua vào</th>
		var wholesales_price = item['wholesales_price'];
		var wholesales_price2 = item['wholesales_price2'];
		var wholesales_price3 = item['wholesales_price3'];
		var retail_price = item['retail_price'];
		
		link = '<a onclick="bindListPublisherToTableWithProductId(\''+no+'\')" class="btn btn-inverse btn-primary" data-toggle="modal" data-target="#nhacungcap_modal"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Chọn nhà cung cấp</a>';
		
		var row = [image, category_name, material_name, diameter, length, product_range, unit_name, Omss.numberFormat(wholesales_price), Omss.numberFormat(wholesales_price2), Omss.numberFormat(wholesales_price3), Omss.numberFormat(retail_price), link];
		// console.log(product_group);
	    datatable.fnAddData(row, true);
	});
	datatable.fnDraw();
}

/**
 * get list publisher have price with product id
 * @param {Object} product_id
 */
function bindListPublisherToTableWithProductId(product_id){
	console.log("bindListPublisherToTableWithProductId : " + product_id);
	selectedProductId = product_id;
	
	var filterSearch = {
		'product_id' : product_id
	};
	Omss.post('/sosanhgia/searchPublisherPrice', filterSearch).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			listPublisherPrice = data['data'];
			drawListPublisherWithPrice(listPublisherPrice);
		} else {
			Omss.showError(data.message);
		}
	});
}

/**
 * draw list publisher to table after get data from server
 * @param {Object} listPublisherPrice
 */
function drawListPublisherWithPrice(listPublisherPrice){
	console.log("drawListPublisherWithPrice");
	datatablePublisher.fnClearTable(0);
	
	if(listPublisherPrice.length <= 0){
		Omss.showError('Chưa có báo giá của nhà cung cấp nào');
	}
	$.each( listPublisherPrice, function(key, item){
		var publisher_id = item['publisher_id'];
		var publisher_name = item['publisher_name'];
		var input_price = item['input_price'];
		var selected_price = item['selected_price'];
		var wholesales_rate = item['wholesales_rate'];
		var wholesales_rate2 = item['wholesales_rate2'];
		var wholesales_rate3 = item['wholesales_rate3'];
		var retail_rate = item['retail_rate'];
		
		var link = '<a onclick="setSelectedPublisher(\''+publisher_id+'\',\'' + wholesales_rate +'\',\''+ wholesales_rate2 +'\',\''+ wholesales_rate3 +'\',\'' + retail_rate + '\')" class="btn btn-primary" href="#" data-toggle="modal" data-target="#nhapgiasile_modal"><span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Chọn</a>';
		var status = selected_price == 1 ? 'Đã chọn' : '';
		var row = [publisher_name, Omss.numberFormat(input_price), status, link];
		// console.log(product_group);
	    datatablePublisher.fnAddData(row, true);
	});
	datatablePublisher.fnDraw();
}

/**
 * click button select publisher
 * save this publisher id to global variable
 * @param {Object} publisher_id
 */
function setSelectedPublisher(publisher_id, wholesales_rate, wholesales_rate2, wholesales_rate3, retail_rate){
	console.log("setSelectedPublisher : " + publisher_id);
	selectedPublisherId = publisher_id;
	
	$("#wholesales_rate").val(Omss.numberFormat(wholesales_rate));
	$("#wholesales_rate2").val(Omss.numberFormat(wholesales_rate2));
	$("#wholesales_rate3").val(Omss.numberFormat(wholesales_rate3));
	
	$("#retail_rate").val(Omss.numberFormat(retail_rate));
//	
//	$("#nhapgiasile_modal").find(".retail_rate").val(Omss.numberFormat(retail_rate));
//	
//	$("#nhapgiasile_modal").find(".wholesales_rate").focus();
}

/**
 * validate input price rate when click ok in modal input
 */
function clickConfirmInputPriceRate(){
	console.log("clickConfirmInputPriceRate");
	Omss.validate($(formInputPriceRate),{
		wholesales_rate : {
				required: true,
				number: true,
				maxlength : 10,
			},
			retail_rate : {
				required: true,
				number: true,
				maxlength : 10,
			},
	},finishValidateInputPriceRate);
}

/**
 * validate input price rate ok
 */
function finishValidateInputPriceRate(){
	console.log("finishValidateInputPriceRate");
	
	var dataUpdate = { 'product_id' : selectedProductId,
						'publisher_id' : selectedPublisherId,
						'wholesales_rate' : $("#wholesales_rate").autoNumeric('get'),
						'wholesales_rate2' : $("#wholesales_rate2").autoNumeric('get'),
						'wholesales_rate3' : $("#wholesales_rate3").autoNumeric('get'),
						'retail_rate' : $(formInputPriceRate).find(".retail_rate").autoNumeric('get')
						};
	console.log('setSelectedPublisher');
	console.log(dataUpdate);
	Omss.post('/sosanhgia/setSelectedPublisher', dataUpdate).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			console.log('---Finish update product price');
			//hide modal
			$("#nhapgiasile_modal").modal("hide");
			$("#nhacungcap_modal").modal("hide");
			finishValidateSearchForm();
		} else {
			Omss.showError(data.message);
		}
	});
}
