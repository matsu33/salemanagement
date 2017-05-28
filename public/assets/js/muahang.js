/********************************************************************************
 ****** Variables ***************************************************************
 ********************************************************************************/
var formInserOrder = "#frm_order";

var tableOrder = "#table_order";

var orderToAdd = {};

var datatableOrderList = {};

var orderList;

var orderTotal = 0;

var current_priceid, current_price;

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columnsList = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	// <th>Hình ảnh</th>
				{ "bSearchable": true},							//<th>Ngày nhập hàng</th>
				{ "bSearchable": true}, 						//<th>Nhà cung cấp</th>
				{ "bSearchable": true}, 						//<th>Tên hàng hóa</th>
				{ "bSearchable": true}, 						//<th>Chất liệu</th>
				{ "bSearchable": true}, 						//<th>Đường kính</th>
				{ "bSearchable": true}, 						//<th>Chiều dài</th>
				{ "bSearchable": true}, 						//<th>Bước răng</th>
				{ "bSearchable": true}, 						//<th>Số lượng</th>
				{ "bSearchable": true}, 						//<th>Đơn vị</th>
				{ "bSearchable": true}, 						//<th>Giá mua vào</th>
				{ "bSearchable": true}, 						//<th>Thành tiền</th>
				{ "bSearchable": false, "bSortable": false} ];	//edit delete


/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){	
	orderList	 = {};
	
	$('.datetimepicker').datetimepicker({
		defaultDate : new Date(),
		pickTime : false,
		format: "DD/MM/YYYY"
	});
	
	$('.input_diameter, .input_length, .input_product_range, .input_quanlity , .input_price').autoNumeric('init',{aPad: false});
	
	//init datatableOrderList
	datatableOrderList = Omss.dataTable($(tableOrder), columnsList);
	
	//fill publisher
	fillPublisherToSelectElement(".select_publisher");
	
	//fill category
	fillCategoryToSelectElement(".select_category");
	
	//fill material
	fillMaterialToSelectElement(".select_material");
	
	//fill unit
	fillUnitToSelectElement(".select_unit");
	
	//stop submit form
	$("#insert_order_modal").submit(function (evt) {
		//stop submit
		evt.preventDefault();
	});
	
	/*************************
	 * EVENT*****************
	 ************************/
	//click btn_add_order
	$(".btn_add_order").click(clickButtonAddOrder);
	
	//click btn_save_new_order
	$("#btn_save_new_order").click(clickSaveNewOrder);
	
	$(".input_quanlity, .input_price").on('change keyup paste mouseup', function() {
		var inputPrice = $(".input_price").autoNumeric('get');
		var input_quanlity = $('.input_quanlity').autoNumeric('get');
		$(".input_amount").val(input_quanlity * inputPrice);
	});
});

/**************************************************************
 * START ADD ORDER LIST
 *************************************************************/
/**
 * click add order in modal 
 */
function clickButtonAddOrder(){
	console.log('clickButtonAddOrder');
	//validate form
	Omss.validate($(formInserOrder), {
			input_diameter : {
				required: true,
				number: true,
				maxlength : 10,
			},
			input_length : {
				required: false,
				number: true,
				maxlength : 10,
			},
			input_product_range : {
				number: true,
				maxlength : 10,
			},
			input_quanlity : {
				required: true,
				number: true,
				maxlength : 10,
			},
			input_price : {
				required: true,
				number: true,
				maxlength : 10,
			}
		}, finishValidateFormAddOrder);
	//
}

/**
 * validate ok form insert order 
 */
function finishValidateFormAddOrder(){
	//check size exist
	
	var isAddedProductToList = checkProductExistInGroup(formInserOrder, orderList);
	
	if(isAddedProductToList){
		Omss.showError("Đã thêm sản phẩm này vào danh sách rồi");
	}else{
		validateProductSizeExist(formInserOrder, finishGetSizeId);	
	}
}

/**
 * finish get size id 
 */
function finishGetSizeId(size_id){
	//init product info
	orderToAdd = {};
	orderToAdd.size_id = size_id;
	// orderToAdd.create_at = $("#input_date" ).val();
	// orderToAdd.publisher_id = $(formInserOrder).find(".select_publisher" ).val();
	// orderToAdd.publisher_name = $(formInserOrder).find(".select_publisher" ).children(':selected').text();
	orderToAdd.category_id = $(formInserOrder).find(".select_category" ).val();
	orderToAdd.category_name = $(formInserOrder).find(".select_category" ).children(':selected').text();
	orderToAdd.material_id = $(formInserOrder).find(".select_material" ).val();
	orderToAdd.material_name = $(formInserOrder).find(".select_material" ).children(':selected').text();
	orderToAdd.unit_id = $(formInserOrder).find(".select_unit" ).val();
	orderToAdd.unit_name = $(formInserOrder).find(".select_unit" ).children(':selected').text();
	orderToAdd.diameter = $(formInserOrder).find(".input_diameter" ).autoNumeric('get');
	orderToAdd.length = $(formInserOrder).find(".input_length" ).autoNumeric('get');
	orderToAdd.product_range = $(formInserOrder).find(".input_product_range" ).autoNumeric('get');
	orderToAdd.quanlity = $(formInserOrder).find(".input_quanlity" ).autoNumeric('get');
	orderToAdd.buy_price = $(formInserOrder).find(".input_price" ).autoNumeric('get');
	
	orderToAdd.amount = orderToAdd.quanlity * orderToAdd.buy_price;
	$(formInserOrder).find(".input_amount" ).val(orderToAdd.amount);
	
	//get product group id
	getProductGroupId(productGroupInsert, orderToAdd, finishGetProductGroupId);
}

function finishGetProductGroupId(){
	console.log("finishGetProductGroupId");
	console.log(orderToAdd);
	
	getProductInfoWithProductAttribute(orderToAdd, setProductIdWithData);
}

/**
 * do sth after get product info 
 */
function setProductIdWithData(product){
	console.log("setProductIdWithData");
	var pid = product.id;
	orderToAdd.product_id = pid;
	orderToAdd.unit_instock = product.unit_instock;
	orderToAdd.image = product.image;
	
	console.log('orderToAdd');
	console.log(orderToAdd);
	
	orderList[product.id] = orderToAdd;
	
	var publisher_id = $(".order_date_publisher").find(".select_publisher" ).val();
	var newPrice = $(".input_price").autoNumeric('get');
	
	searchPriceThenCallback(pid, publisher_id, function(dataCallback){
		if(dataCallback.data.length <= 0){
			addPriceThenCallback(pid, publisher_id, newPrice, function(){
				
			});
		}else{
			var oldPrice = dataCallback.data[0]["input_price"];
			if(Omss.numberFormat(oldPrice) != Omss.numberFormat(newPrice)){
				$(".update_price_value").html(oldPrice);
				$(".update_price_value2").html(newPrice);
				current_priceid = dataCallback.data[0]['id'];
				current_price = newPrice;
				$("#update_price_modal").modal("show");
			}
		}
	});
	
	drawListOrder(datatableOrderList, orderList);
}

function searchPriceThenCallback(pid, pubid, callbackFunction){
	//get price of product of publisher
	var dataPost = {
            'pid': pid,
            'pubid': pubid
        };
	Omss.post('bangbaogia/search', dataPost).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			callbackFunction(data);
		} else {
			//Omss.showError('');
		}
	});
}

function updatePriceThenCallback(current_priceid, newPrice, callbackFunction){
	//get price of product of publisher
	var dataPost = {
            'id': current_priceid,
            'input_price': newPrice
        };
	Omss.post('bangbaogia/update', dataPost).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			callbackFunction(data);
		} else {
			//Omss.showError('');
		}
	});
}

function addPriceThenCallback(pid, pubid, newPrice, callbackFunction){	
	//get price of product of publisher
	var dataPost = {
            'product_id': pid,
            'publisher_id': pubid,
            'input_price': newPrice
        };
	Omss.post('bangbaogia/add', dataPost).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			callbackFunction(data);
		} else {
			//Omss.showError('');
		}
	});
}

function updatePrice(){
	updatePriceThenCallback(current_priceid, current_price, function(){
		$("#update_price_modal").modal("hide");
	});
}

/**
 * draw list product to table
 */
function drawListOrder(datatable, orderList){
	console.log("drawListOrder");
	datatable.fnClearTable(0);
	
	orderTotal = 0;
	var date_buy = $("#input_date" ).val();
	var publisher_name = $(".order_date_publisher").find(".select_publisher" ).children(':selected').text();
		
	$.each( orderList, function(key, item){
		// var no, image, publisher_name, category_name, material_name, size_id, diameter, length, product_range, unit_name, input_price, link, product_group;
		var product_image = item['image'];
		
		var product_name = item['category_name'];
		var material_name = item['material_name'];
		var diameter = item['diameter'];
		var length = item['length'];
		var product_range = item['product_range'];
		var quanlity = item['quanlity'];
		var unit_name = item['unit_name'];
		var buy_price = item['buy_price'];
		var amount = item['amount'];
		orderTotal += amount;
		
		var image = getProductImageHtmlWithName(product_image);
		
		var linkDelete = '<a class="btn btn-danger" onclick="removeOrderFromGroup(\''+item.product_id+'\')"><span class="glyphicon glyphicon-remove"></span></a>';
		
		var row = [image, date_buy, publisher_name, product_name, material_name, diameter, length, product_range, quanlity, unit_name, buy_price, amount, linkDelete];
		// console.log(product_group);
	    datatableOrderList.fnAddData(row, true);
	});
	
	datatableOrderList.fnDraw();
	
	$(".order_total").text(orderTotal);
}

/**
 * remove product order from list 
 * @param {Object} product_id
 */
function removeOrderFromGroup(product_id){
	console.log("removeOrderFromGroup" + product_id);
	delete orderList[product_id];
	
	drawListOrder(datatableOrderList, orderList);
}

function bindOrderData(){
	$("#preview_order_modal table > tbody").html("");
	
	var rowCount = Object.keys(orderList).length;
	
	if(rowCount > 0){
		$("#table_order > tbody > tr").each(function() {
		  $this = $(this).clone();
		  $this.find("td:last").remove();
		  $("#preview_order_modal table > tbody").append($this);
		});
		$("#preview_order_modal").modal("show");
	}
}
/**************************************************************
 * END ADD ORDER LIST
 *************************************************************/

/**************************************************************
 * START SAVE ORDER LIST
 *************************************************************/
function clickSaveNewOrder(){
	console.log('clickSaveNewOrder - Order list: ');
	console.log(orderList);
	if(Object.keys(orderList).length <= 0){
		Omss.showError('Chưa có sản phẩm nào');
		return false;
	}else{
		var date_buy = $("#input_date" ).val();
		var publisher_id = $(".order_date_publisher").find(".select_publisher" ).val();
		var willPaid = $("#preview_order_paid_modal input[name=cbxpaid]:checked").val();
		var dataPost = {'data' : orderList,
			'total': orderTotal,
			'date_buy' : date_buy,
			'publisher_id' : publisher_id,
			'willPaid' : willPaid
		};
		Omss.post('/muahang/add', dataPost).done(function(data) {
			console.log(data);
			if (data.status == 1) {
				$("#preview_order_paid_modal").modal("hide");
				$("#preview_order_modal").modal("hide");
				Omss.showSuccess(data.message);
				orderList = {};
				drawListOrder(datatableOrderList, orderList);
			} else {
				console.log(orderList);
				Omss.showError(data.message);
			}
		});
		
	}
}
/**************************************************************
 * END SAVE ORDER LIST
 *************************************************************/

