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

var willPaidOrder = 0;

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

    $('.input_quanlity , .input_price').autoNumeric('init',{aPad: false});
    
    //stop submit form
    $(("#insert_order_modal, #frm_order")).submit(function(evt) {
        //stop submit
        evt.preventDefault();
    });

    /*************************
     * EVENT*****************
     ************************/
    //click btn_add_order
    $(".btn_add_order").click(clickButtonAddOrder);

    //click btn_save_new_order
    $(".btn_save_new_order").click(function(){setPaid(0);});
    $(".btn_save_new_order2").click(function(){setPaid(1);});
	$(".js-customer-link").click(function(){
	    var selectedCustomer = $('.select_customer').val();
	    console.log('selectedCustomer : ' + selectedCustomer);
	    window.location = '/no_khach_hang?page=1&customer_id='+selectedCustomer+'&search_type=3';
	});

    //click btn_check_instock
    $(".btn_check_instock").click(clickCheckInstock);
    
    $(".input_quanlity, .input_price").on('change keyup paste mouseup', function() {
		var inputPrice = $(".input_price").autoNumeric('get');
		var input_quanlity = $('.input_quanlity').autoNumeric('get');
		$(".input_amount").val(input_quanlity * inputPrice);
	});
    $('.input_quanlity').autoNumeric('update', {'vMax': 1});
});

function setPaid(isPaid){
	willPaidOrder = isPaid;

	clickSaveNewOrder();
}
/**************************************************************
 * START CHECK PRODUCT INSTOCK
 *************************************************************/

$.validator.addMethod('lessThanEqual', function(value, element, param) {
    return this.optional(element) || parseInt(value) <= parseInt($(param).val());
}, "Số lượng phải nhỏ hơn tồn kho");

var productWholeSale = {};
/**
 * click button check product instock
 */
function clickCheckInstock() {
    console.log("clickCheckInstock");
    Omss.resetForm(formInsertOrder);
    if ($(formInsertOrder).validate().element(".input_diameter") && $(formInsertOrder).validate().element(".input_length")) {
        finishValidateFormAddOrderWholeSale();
    }
}

Omss.validate($(formInsertOrder), {
    input_diameter: {
        required: true,
        number: true,
        maxlength: 10,
    },
    input_length: {
        required: false,
        number: true,
        maxlength: 10,
    },
    input_product_range: {
        number: true,
        maxlength: 10,
    },
    input_quanlity: {
        required: true,
        number: true,
        maxlength: 10,
        //		lessThanEqual : ".input_instock"
    },
    input_price: {
        required: true,
        number: true,
        maxlength: 10,
    }
}, null);

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
    $('.input_quanlity').autoNumeric('update', {'vMax': unitInstock});
    //Omss.showSuccess("Tồn kho : " + unitInstock);
    
    getPriceOfProductThenCallBack(product.id, function(data){
    	var wholesales_price = data.data[0].wholesales_price;
    	$('.input_price').autoNumeric('set', wholesales_price);
    	var input_quanlity = $('.input_quanlity').autoNumeric('get');
    	var total = wholesales_price * input_quanlity;
    	$('.input_amount').val(total);
    });
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
    orderToAdd.buy_price = $(formInsertOrder).find(".input_price").autoNumeric('get');

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
function clickSaveNewOrder() {
    console.log('clickSaveNewOrder - Order list: ');
    console.log(orderList);
    if (Object.keys(orderList).length <= 0) {
        Omss.showError('Chưa có sản phẩm nào');
        return false;
    } else {
        var date_buy = $("#input_date").val();
        var customer_id = $(".order_date_publisher").find(".select_customer").val();

        var dataPost = {
            'data': orderList,
            'total': orderTotal,
            'date_buy': date_buy,
            'customer_id': customer_id,
            'willPaidOrder' : willPaidOrder
        };
        Omss.post('/bansi/add', dataPost).done(function(data) {
            console.log(data);
            if (data.status == 1) {
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