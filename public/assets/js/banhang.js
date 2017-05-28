/********************************************************************************
 ****** Variables ***************************************************************
 ********************************************************************************/
var formInsertOrder = "#frm_order";

var tableOrder = "#table_order";

var orderToAdd = {};

var datatableOrderList = {};

var orderList;

var orderTotal = 0;

var finishValidateFunction = null;

var willPaidOrder = false;

/**
 * Define column's properties
 * Tham khảo: http://legacy.datatables.net/usage/columns
 */
var columnsList = [{
        "bSearchable": false,
        "sClass": "center",
        "bSortable": false
    }, // <th>Hình ảnh</th>
    {
        "bSearchable": true
    }, //<th>Ngày nhập hàng</th>
    {
        "bSearchable": true
    }, //<th>Nhà cung cấp</th>
    {
        "bSearchable": true
    }, //<th>Tên hàng hóa</th>
    {
        "bSearchable": true
    }, //<th>Chất liệu</th>
    {
        "bSearchable": true
    }, //<th>Đường kính</th>
    {
        "bSearchable": true
    }, //<th>Chiều dài</th>
    {
        "bSearchable": true
    }, //<th>Bước răng</th>
    {
        "bSearchable": true
    }, //<th>Số lượng</th>
    {
        "bSearchable": true
    }, //<th>Đơn vị</th>
    {
        "bSearchable": true
    }, //<th>Giá mua vào</th>
    {
        "bSearchable": true
    }, //<th>Thành tiền</th>
    {
        "bSearchable": false,
        "bSortable": false
    }
]; //edit delete


/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function() {
    orderList = {};

    $('.datetimepicker').datetimepicker({
        defaultDate: new Date(),
        pickTime: false,
        format: "DD/MM/YYYY"
    });

    //init datatableOrderList
    datatableOrderList = Omss.dataTable($(tableOrder), columnsList);

    //fill publisher
    fillCustomerToSelectElement(".select_customer");

    //fill publisher
    fillPublisherToSelectElement(".select_publisher");

    //fill category
    fillCategoryToSelectElement(".select_category");

    //fill material
    fillMaterialToSelectElement(".select_material");

    //fill unit
    fillUnitToSelectElement(".select_unit");

    $('#frm_order .input_diameter,#frm_order .input_length,#frm_order .input_product_range,#frm_order .input_quanlity ,#frm_order .input_price').autoNumeric('init',{aPad: false});
    
    //stop submit form
//    $(("#insert_order_modal, #frm_order")).submit(function(evt) {
//        //stop submit
//        evt.preventDefault();
//    });

    /*************************
     * EVENT*****************
     ************************/
    //click btn_add_order
    $(".btn_add_order").click(clickButtonAddOrder);

    //click btn_save_new_order
    $("#btn_save_new_order").click(clickSaveNewOrder);

    //click btn_check_instock
    $(".btn_check_instock").click(clickCheckInstock);
    
    $("#frm_order .input_quanlity,#frm_order .input_price").on('change keyup paste mouseup', function() {
    	updateTotalPrice();
	});
    
    $('#frm_order input[type=radio][name=price_type]').change(function() {
    	updateTotalPrice();
    });

    $('#frm_order .input_quanlity').autoNumeric('update', {'vMax': 1});
    
    $( ".wholesales_price" ).change(function() {
    	var priceType = $("#frm_order input[name=price_type]:checked").val();
    	var price = 0;
    	if(priceType == 1){
    		updateTotalPrice();
    	}
	});
});

function updateTotalPrice(){
	var inputPrice = getSelectedPrice();
	var input_quanlity = $('#frm_order .input_quanlity').autoNumeric('get');
	$("#frm_order .input_amount").val(input_quanlity * inputPrice);
}
//function setPaid(isPaid){
//	if(isPaid == 0){
//		willPaidOrder = false;
//	}else{
//		willPaidOrder = true;
//	}
//	clickSaveNewOrder();
//}
/**************************************************************
 * START CHECK PRODUCT INSTOCK
 *************************************************************/

var productWholeSale = {};
/**
 * click button check product instock
 */
function clickCheckInstock() {
    console.log("clickCheckInstock");
    
    var inputDiameter = $('#frm_order .input_diameter').autoNumeric('get');

    //Omss.resetForm(formInsertOrder);
//    if ($(formInsertOrder).validate().element(".input_diameter") && $(formInsertOrder).validate().element(".input_length")) {
//        finishValidateFormAddOrderWholeSale();
//    }
    if(inputDiameter == "" || inputDiameter <= 0){
    	$('#frm_order .input_diameter').focus();
    }else{
    	finishValidateFormAddOrderWholeSale();
    }
    
}

/**
 * call back finish validate form
 */
function finishValidateFormAddOrderWholeSale() {
    console.log("finishValidateFormAddOrderWholeSale");
    validateProductSizeExist(formInsertOrder, finishGetSizeIdOfProductWholeSale);
}

/**
 * call back after finish get size id
 */
function finishGetSizeIdOfProductWholeSale(size_id) {
    console.log("finishGetSizeIdOfProductWholeSale : " + size_id);
    //init product
    productWholeSale = {};
    productWholeSale.size_id = size_id;

    productWholeSale.category_id = $(formInsertOrder).find(".select_category").val();
    productWholeSale.material_id = $(formInsertOrder).find(".select_material").val();
    productWholeSale.unit_id = $(formInsertOrder).find(".select_unit").val();

    //get product group id
    getProductGroupId(productGroupInsert, productWholeSale, finishGetProductGroupIdWholeSale);
}

/**
 * call back after get product group id
 */
function finishGetProductGroupIdWholeSale() {
    console.log("finishGetProductGroupIdWholeSale");
    getProductInfoWithProductAttribute(productWholeSale, showInstockOfProduct);
}

function showInstockOfProduct(product) {
    console.log("showInstockOfProduct");
    var unitInstock = product.unit_instock;

    $(formInsertOrder).find(".input_instock").val(unitInstock);
    $('#frm_order .input_quanlity').autoNumeric('update', {'vMax': unitInstock});
    //Omss.showSuccess("Tồn kho : " + unitInstock);
    
    getPriceOfProductThenCallBack(product.id, function(data){
    	var wholesales_price = Omss.numberFormat(data.data[0].wholesales_price);
    	var wholesales_price2 = Omss.numberFormat(data.data[0].wholesales_price2);
    	var wholesales_price3 = Omss.numberFormat(data.data[0].wholesales_price3);
    	var retail_price = Omss.numberFormat(data.data[0].retail_price);
    	////////////////////////////////////////////////////////////////////
    	$('.wholesales_price').html("");
    	$('.wholesales_price').append("<option value='"+wholesales_price+"' selected='selected'>"+wholesales_price+"</option>");
    	$('.wholesales_price').append("<option value='"+wholesales_price2+"' >"+wholesales_price2+"</option>");
    	$('.wholesales_price').append("<option value='"+wholesales_price3+"' >"+wholesales_price3+"</option>");

    	//$('.wholesales_price').val(wholesales_price);
    	$('.retail_price').val(retail_price);
    	updateTotalPrice();
    });
}

function getSelectedPrice(){
	var priceType = $("#frm_order input[name=price_type]:checked").val();
	var price = 0;
	if(priceType == 1){
		price = $('.wholesales_price').val();
	}else if(priceType == 2){
		price = $('.retail_price').val();
	}else if(priceType == 3){
		price = $('.input_price').autoNumeric('get');
	}
	return price;
}

function getPriceOfProductThenCallBack(pid, callbackFunction){
	var dataPost = {
            'pid': pid
        };
        Omss.post('/kiemkho/getPriceOfProduct', dataPost).done(function(data) {
            console.log(data);
            if (data.status) {
            	callbackFunction(data);
            } else {
                console.log(orderList);
                Omss.showError(data.message);
            }
        });
}

/**************************************************************
 * END CHECK PRODUCT INSTOCK
 *************************************************************/

/**************************************************************
 * START ADD ORDER LIST
 *************************************************************/
/**
 * click add order in modal
 */
function clickButtonAddOrder() {
    console.log('clickButtonAddOrder');
    if ($(formInsertOrder).validate()) {
        finishValidateFormAddOrder();
    }
}

/**
 * validate ok form insert order
 */
function finishValidateFormAddOrder() {
    console.log("finishValidateFormAddOrder");
    //check size exist

    var isAddedProductToList = checkProductExistInGroup(formInsertOrder, orderList);

    if (isAddedProductToList) {
        Omss.showError("Đã thêm sản phẩm này vào danh sách rồi");
    } else {
        validateProductSizeExist(formInsertOrder, finishGetSizeId);
    }
}

/**
 * finish get size id
 */
function finishGetSizeId(size_id) {
    console.log("finishGetSizeId");
    //init product info
    orderToAdd = {};
    orderToAdd.size_id = size_id;
    // orderToAdd.create_at = $("#input_date" ).val();
    // orderToAdd.publisher_id = $(formInsertOrder).find(".select_publisher" ).val();
    // orderToAdd.publisher_name = $(formInsertOrder).find(".select_publisher" ).children(':selected').text();
    orderToAdd.category_id = $(formInsertOrder).find(".select_category").val();
    orderToAdd.category_name = $(formInsertOrder).find(".select_category").children(':selected').text();
    orderToAdd.material_id = $(formInsertOrder).find(".select_material").val();
    orderToAdd.material_name = $(formInsertOrder).find(".select_material").children(':selected').text();
    orderToAdd.unit_id = $(formInsertOrder).find(".select_unit").val();
    orderToAdd.unit_name = $(formInsertOrder).find(".select_unit").children(':selected').text();
    orderToAdd.diameter = $(formInsertOrder).find(".input_diameter").autoNumeric('get');
    orderToAdd.length = $(formInsertOrder).find(".input_length").autoNumeric('get');
    orderToAdd.product_range = $(formInsertOrder).find(".input_product_range").autoNumeric('get');
    orderToAdd.quanlity = $(formInsertOrder).find(".input_quanlity").autoNumeric('get');
    orderToAdd.buy_price = getSelectedPrice();

    orderToAdd.amount = orderToAdd.quanlity * orderToAdd.buy_price;
    $(formInsertOrder).find(".input_amount").val(orderToAdd.amount);

    //get product group id
    getProductGroupId(productGroupInsert, orderToAdd, finishGetProductGroupId);
}

function finishGetProductGroupId() {
    console.log("finishGetProductGroupId");
    console.log(orderToAdd);

    getProductInfoWithProductAttribute(orderToAdd, setProductIdWithData);
}

/**
 * do sth after get product info
 */
function setProductIdWithData(product) {
    console.log("setProductIdWithData");
    if (parseInt(product.unit_instock) < parseInt(orderToAdd.quanlity)) {
        Omss.showError('Không đủ số lượng trong kho!');
        return;
    }
    orderToAdd.product_id = product.id;
    orderToAdd.unit_instock = product.unit_instock;
    orderToAdd.image = product.image;

    console.log('orderToAdd');
    console.log(orderToAdd);

    orderList[product.id] = orderToAdd;
    drawListOrder(datatableOrderList, orderList);
}


/**
 * draw list product to table
 */
function drawListOrder(datatable, orderList) {
    console.log("drawListOrder");
    datatable.fnClearTable(0);

    orderTotal = 0;
    var date_buy = $("#input_date").val();
    var publisher_name = $(".order_date_publisher").find(".select_customer").children(':selected').text();

    $.each(orderList, function(key, item) {
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

        var linkDelete = '<a class="btn btn-danger" onclick="removeOrderFromGroup(\'' + item.product_id + '\')"><span class="glyphicon glyphicon-remove"></span></a>';

        var row = [image, date_buy, publisher_name, product_name, material_name, diameter, length, product_range, Omss.numberFormat(quanlity), unit_name, Omss.numberFormat(buy_price), Omss.numberFormat(amount), linkDelete];
        // console.log(product_group);
        datatableOrderList.fnAddData(row, true);
    });

    datatableOrderList.fnDraw();

    $(".order_total").text(Omss.numberFormat(orderTotal));
}

/**
 * remove product order from list
 * @param {Object} product_id
 */
function removeOrderFromGroup(product_id) {
    console.log("removeOrderFromGroup" + product_id);
    delete orderList[product_id];

    drawListOrder(datatableOrderList, orderList);
}
/**************************************************************
 * END ADD ORDER LIST
 *************************************************************/

/**************************************************************
 * START SAVE ORDER LIST
 *************************************************************/
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

function openPreviewModal(){
	var customer_type = $("#frm_order input[name=customer_type]:checked").val();
	if(customer_type == 1){
		//wholesale
		$("#cbx_notpaid").prop("checked", true);
		$("#cbx_paid").prop("checked", false);
		$("#preview_order_paid_modal").modal("show");
	}else{
		//retail
		$("#cbx_notpaid").prop("checked", false);
		$("#cbx_paid").prop("checked", true);
		clickSaveNewOrder();
	}
}

function clickSaveNewOrder() {
    console.log('clickSaveNewOrder - Order list: ');
    console.log(orderList);
    if (Object.keys(orderList).length <= 0) {
        Omss.showError('Chưa có sản phẩm nào');
        return false;
    } else {
        var date_buy = $("#input_date").val();
        var customer_id = $(".order_date_publisher").find(".select_customer").val();

        var willPaidOrder = $("#preview_order_paid_modal input[name=cbxpaid]:checked").val();
        var customer_type = $("#frm_order input[name=customer_type]:checked").val();
        var dataPost = {
            'data': orderList,
            'total': orderTotal,
            'date_buy': date_buy,
            'customer_id': customer_id,
            'willPaidOrder' : willPaidOrder,
            'customer_type' : customer_type
        };
        Omss.post('/bansi/add', dataPost).done(function(data) {
            console.log(data);
            if (data.status == 1) {
                Omss.showSuccess(data.message);
                orderList = {};
                drawListOrder(datatableOrderList, orderList);
                $("#preview_order_paid_modal").modal("hide");
                $("#preview_order_modal").modal("hide");
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