/********************************************************************************
 ****** Variables ***************************************************************
 ********************************************************************************/
var formInserOrder = "#frm_order";

var tableOrder = "#table_order";

var orderToAdd = {};

var datatableOrderList = {};

var orderList;

var orderTotal = 0;
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
//    fillPublisherToSelectElement(".select_publisher");

    //fill category
    fillCategoryToSelectElement(".select_category");

    //fill material
    fillMaterialToSelectElement(".select_material");

    //fill unit
    fillUnitToSelectElement(".select_unit");

    //stop submit form
    $("#insert_order_modal").submit(function(evt) {
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

    $("#btn_print_order").click(clickPrintNewOrder);
    
    $(".btn_get_price").click(clickGetPrice);
    
    $("input[type=text][name=retail_price], input[type=text][name=input_quanlity], input[type=radio][name=price_type]").change(priceChange);

});

function clickGetPrice(){
	if ($(formInserOrder).validate().element(".input_diameter") 
			&& $(formInserOrder).validate().element(".input_length")) {
		finishValidateFormGetPrice();
    }
}

function finishValidateFormGetPrice() {
	validateProductSizeExist(formInserOrder, finishGetSizeIdForPrice);
}

function finishGetSizeIdForPrice(size_id) {
    //init product info
    orderToAdd = {};
    orderToAdd.size_id = size_id;
    orderToAdd.category_id = $(formInserOrder).find(".select_category").val();
    orderToAdd.category_name = $(formInserOrder).find(".select_category").children(':selected').text();
    orderToAdd.material_id = $(formInserOrder).find(".select_material").val();
    orderToAdd.material_name = $(formInserOrder).find(".select_material").children(':selected').text();
    orderToAdd.unit_id = $(formInserOrder).find(".select_unit").val();
    orderToAdd.unit_name = $(formInserOrder).find(".select_unit").children(':selected').text();
    orderToAdd.diameter = $(formInserOrder).find(".input_diameter").val();
    orderToAdd.length = $(formInserOrder).find(".input_length").val();
    orderToAdd.product_range = $(formInserOrder).find(".input_product_range").val();
    orderToAdd.quanlity = $(formInserOrder).find(".input_quanlity").val();

    //get product group id
    getProductGroupId(productGroupInsert, orderToAdd, finishGetProductGroupIdForPrice);
}

function finishGetProductGroupIdForPrice() {
    getProductInfoWithProductAttribute(orderToAdd, getProductPrice);
}

/**
 * do sth after get product info
 */
function getProductPrice(product) {
	console.log(product);
	var url = 'dondathang/getProductPrice';
	var data = {
        product_id: product.id
    };
    Omss.post(url, data).done(function(data) {
    	console.log(data);
        if (data && data.length > 0) {
            Omss.showSuccess('Lấy giá sản phẩm thành công');
            $(formInserOrder).find("input[type=text][name=retail_price]").val(Omss.numberFormat(data[0].retail_price));
            $(formInserOrder).find("input[type=text][name=wholesales_price]").val(Omss.numberFormat(data[0].wholesales_price));
            priceChange();
        } else {
            Omss.showError('Sản phẩm chưa thiết lập giá!');

            $(formInserOrder).find("input[type=text][name=retail_price]").val('0');
            $(formInserOrder).find("input[type=text][name=wholesales_price]").val('0');
            priceChange();
        }
    });
}

function priceChange(){
	var price_type = $("input[type=radio][name=price_type]:checked").val();
	var quantity = $(formInserOrder).find(".input_quanlity").val();
	var price = 0;
	if(price_type == "1"){
		price = $("input[type=text][name=retail_price]").val();
	}else{
		price = $("input[type=text][name=wholesales_price]").val();
	}
	var total_amount = Omss.parseInt(quantity) * Omss.parseInt(price);
	$(formInserOrder).find(".input_amount").val(Omss.numberFormat(total_amount));
}
/**************************************************************
 * START ADD ORDER LIST
 *************************************************************/

function clickPrintNewOrder() {
    //window.location.href = "taobangbaogia/excel";
    if (Object.keys(orderList).length <= 0) {
        Omss.showError('Chưa có sản phẩm nào');
        return false;
    } else {
        var date_buy = $("#input_date").val();
        var publisher_id = $(".order_date_publisher").find(".select_publisher").val();

        var dataPost = {
            'data': orderList,
            'total': orderTotal,
            'date_buy': date_buy,
            'publisher_id': publisher_id
        };

        post_to_url('dondathang/excel', dataPost, null);
    }
}

Omss.validate($(formInserOrder), {
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
    },
    input_price: {
        required: true,
        number: true,
        maxlength: 10,
    }
}, null);

/**
 * click add order in modal
 */
function clickButtonAddOrder() {
    //validate form
	if ($(formInserOrder).validate()) {
		finishValidateFormAddOrder();
    }
}

/**
 * validate ok form insert order
 */
function finishValidateFormAddOrder() {
    //check size exist

    var isAddedProductToList = checkProductExistInGroup(formInserOrder, orderList);

    if (isAddedProductToList) {
        Omss.showError("Đã thêm sản phẩm này vào danh sách rồi");
    } else {
        validateProductSizeExist(formInserOrder, finishGetSizeId);
    }
}

/**
 * finish get size id
 */
function finishGetSizeId(size_id) {
    //init product info
    orderToAdd = {};
    orderToAdd.size_id = size_id;
    // orderToAdd.create_at = $("#input_date" ).val();
    // orderToAdd.publisher_id = $(formInserOrder).find(".select_publisher" ).val();
    // orderToAdd.publisher_name = $(formInserOrder).find(".select_publisher" ).children(':selected').text();
    orderToAdd.category_id = $(formInserOrder).find(".select_category").val();
    orderToAdd.category_name = $(formInserOrder).find(".select_category").children(':selected').text();
    orderToAdd.material_id = $(formInserOrder).find(".select_material").val();
    orderToAdd.material_name = $(formInserOrder).find(".select_material").children(':selected').text();
    orderToAdd.unit_id = $(formInserOrder).find(".select_unit").val();
    orderToAdd.unit_name = $(formInserOrder).find(".select_unit").children(':selected').text();
    orderToAdd.diameter = $(formInserOrder).find(".input_diameter").val();
    orderToAdd.length = $(formInserOrder).find(".input_length").val();
    orderToAdd.product_range = $(formInserOrder).find(".input_product_range").val();
    orderToAdd.quanlity = Omss.parseInt($(formInserOrder).find(".input_quanlity").val());
    
    var price_type = $("input[type=radio][name=price_type]:checked").val();
	var price = 0;
	if(price_type == "1"){
		price = $("input[type=text][name=retail_price]").val();
	}else{
		price = $("input[type=text][name=wholesales_price]").val();
	}
    orderToAdd.buy_price = Omss.parseInt(price);
    orderToAdd.amount = orderToAdd.quanlity * orderToAdd.buy_price;
    //$(formInserOrder).find(".input_amount").val(orderToAdd.amount);

    //get product group id
    getProductGroupId(productGroupInsert, orderToAdd, finishGetProductGroupId);
}

function finishGetProductGroupId() {
    getProductInfoWithProductAttribute(orderToAdd, setProductIdWithData);
}

/**
 * do sth after get product info
 */
function setProductIdWithData(product) {
    orderToAdd.product_id = product.id;
    orderToAdd.image = product.image;
    
    var url = 'dondathang/getProductPrice';
	var data = {
        product_id: product.id
    };
    Omss.post(url, data).done(function(data) {
        if (data && data.length > 0) {
            $(formInserOrder).find("input[type=text][name=retail_price]").val(Omss.numberFormat(data[0].retail_price));
            $(formInserOrder).find("input[type=text][name=wholesales_price]").val(Omss.numberFormat(data[0].wholesales_price));
            priceChange();
            if(orderToAdd.quanlity <= 0){
            	Omss.showError("Vui lòng nhập số lượng sản phẩm!");
            	return;
            }
            var price_type = $("input[type=radio][name=price_type]:checked").val();
        	var price = 0;
        	if(price_type == "1"){
        		price = $("input[type=text][name=retail_price]").val();
        	}else{
        		price = $("input[type=text][name=wholesales_price]").val();
        	}
            orderToAdd.buy_price = Omss.parseInt(price);
            orderToAdd.amount = Omss.parseInt($(formInserOrder).find("input[type=text][name=input_amount]").val());
            if(orderToAdd.amount <= 0){
            	Omss.showError("Số tiền phải lớn hơn 0 VND!");
            	return;
            }

            orderList[product.id] = orderToAdd;
            drawListOrder(datatableOrderList, orderList);
        } else {
            Omss.showError('Sản phẩm chưa thiết lập giá!');

            $(formInserOrder).find("input[type=text][name=retail_price]").val('0');
            $(formInserOrder).find("input[type=text][name=wholesales_price]").val('0');
            priceChange();
        }
    });
}


/**
 * draw list product to table
 */
function drawListOrder(datatable, orderList) {
    datatable.fnClearTable(0);

    orderTotal = 0;
    var date_buy = $("#input_date").val();
    var publisher_name = $(".order_date_publisher").find(".select_publisher").children(':selected').text();

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
    if (Object.keys(orderList).length <= 0) {
        Omss.showError('Chưa có sản phẩm nào');
        return false;
    } else {
        var date_buy = $("#input_date").val();
        var publisher_id = $(".order_date_publisher").find(".select_publisher").val();
        var dataPost = {
            'data': orderList,
            'total': orderTotal,
            'date_buy': date_buy,
            'publisher_id': publisher_id
        };
        Omss.post('/dondathang/add', dataPost).done(function(data) {
            if (data.status == 1) {
                Omss.showSuccess(data.message);
                orderList = {};
                drawListOrder(datatableOrderList, orderList);
            } else {
                Omss.showError(data.message);
            }
        });

    }
}
/**************************************************************
 * END SAVE ORDER LIST
 *************************************************************/