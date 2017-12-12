var searchCondition = {};
var datatableLoc = {};
var datatableHistory = {};
var columnsList = [{ "bSearchable": true }, { "bSearchable": true }, { "bSearchable": true }, { "bSearchable": true },
                   { "bSearchable": true }, { "bSearchable": true }, { "bSearchable": true }, { "bSearchable": true }];
var columnsHistory = [{ "bSearchable": true }, { "bSearchable": true }, { "bSearchable": true }, { "bSearchable": true },
                   { "bSearchable": true }, { "bSearchable": false }];
var selectProductIdToViewHistory = null;
var selectProductInstockToViewHistory = null;
var editDatePicker = null;

/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function() {
	//fill category
	fillCategoryToSelectElement(".select_category");

	//fill material
	fillMaterialToSelectElement(".select_material");

	// datatableLoc = Omss.dataTable($("#table_loc"), columnsList);
	datatableHistory = Omss.dataTable($("#history_order_detail_modal table"), columnsHistory);

	$('#product_diameter, #product_length, #product_range, .input_current_instock, .input_unit_instock, .input_diameter, .input_length, .input_product_range').autoNumeric('init',{aPad: false});
	
    // initSearch();
    
    $(".js-start-search").click(function() {
        // initSearch();
		startSearch();
    });

	$(".js-reset-search").click(function() {
		window.location = '/kiemkho';
	});

	editDatePicker = $('.edit-date-group-control').datetimepicker({
		defaultDate: new Date(),
		pickTime: false,
		format: "DD/MM/YYYY"
	});
});

function initSearch() {
    showListMaterial();
}

function showListMaterial() {
    var url = 'kiemkho/getListMaterial';
    var data = {};
    Omss.post(url, data).done(function(data) {
        var html = '';
        $(".chatlieu_group_popup").html(html);
        if (data) {
            for (var i = 0; i < data.length; i++) {
                html += '<a class="btn btn-primary col-xs-2" data-toggle="modal">';
                html += data[i].material_name;
                html += '<input type="hidden" class="material_id" value="' + data[i].id + '" /></a>';
            }
            $(".chatlieu_group_popup").html(html);
            $('#chatlieu_modal').modal('show');
            $(".chatlieu_group_popup a").click(function() {
                searchCondition.material_id = $(this).find('.material_id').val();
                showListCategories();
                $('#chatlieu_modal').modal('hide');
            });
        } else {
            Omss.showError("Không có dữ liệu chất liệu!");
        }
    });
}

function showListCategories() {
    var url = 'kiemkho/getListCategories';
    var data = {};
    Omss.post(url, data).done(function(data) {
        var html = '';
        $(".hanghoa_group_popup").html(html);
        if (data) {
            for (var i = 0; i < data.length; i++) {
                html += '<a class="btn btn-primary col-xs-2" data-toggle="modal">';
                html += data[i].category_name;
                html += '<input type="hidden" class="category_id" value="' + data[i].id + '" /></a>';
            }
            $(".hanghoa_group_popup").html(html);
            $('#hanghoa_modal').modal('show');
            $(".hanghoa_group_popup a").click(function() {
                searchCondition.category_id = $(this).find('.category_id').val();
                showSearchDetail();
                $('#hanghoa_modal').modal('hide');
            });
        } else {
            Omss.showError("Không có dữ liệu hàng hóa!");
        }
    });
}

function showSearchDetail() {
    $('#loc_modal').modal('show');
    $(".kiemkho_btn_loc_popup").click(function() {
        searchCondition.product_diameter = $("#product_diameter").autoNumeric('get');
        searchCondition.product_length = $("#product_length").autoNumeric('get');
        searchCondition.product_range = $("#product_range").autoNumeric('get');
        excuteSearch();
    });
}

function excuteSearch() {
    var url = 'kiemkho/excuteSearch';
    var data = searchCondition;
    
    Omss.post(url, data).done(function(data) {
        if(data.status){
        	datatableLoc.fnClearTable(0);
        	var products = data.data;
        	for(var i = 0; i < products.length; i++){
        		var btnDetail = '<a onclick="viewHistoryOrderDetail('+products[i].id+','+Omss.numberFormat(products[i].unit_instock)+')" class="btn btn-inverse btn-primary"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Xem chi tiết</a>';
        		var row = [products[i].category_name, products[i].material_name, searchCondition.product_diameter, searchCondition.product_length, searchCondition.product_range, products[i].unit_name, Omss.numberFormat(products[i].unit_instock), btnDetail];
        		datatableLoc.fnAddData(row, true);
        	}
        	datatableLoc.fnDraw();
            $('#loc_modal').modal('hide');
        }else{
        	Omss.showError(data.message);
        }
    });
}

var editingDate = '';
function viewHistoryOrderDetail(pid){
	selectProductIdToViewHistory = pid;
	selectProductInstockToViewHistory = $('.js-product-'+pid).data('instock');
	
	console.log("viewHistoryOrderDetail");
	var url = 'kiemkho/getHistory';
	var dataPost = {
	        'pid': pid
	    };
    
    Omss.post(url, dataPost).done(function(data) {
        if(data.status){
        	console.log(data);
        	datatableHistory.fnClearTable(0);
        	var products = data.data;
        	for(var i = 0; i < products.length; i++){
        		//var btnDetail = '<a onclick="viewHistoryOrderDetail('+products[i].product_id+')" class="btn btn-inverse btn-primary"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Xem chi tiết</a>';
        		var btnDetail = '';
        		var orderDetailId = products[i].id;
				var productId = products[i].product_id;
				var orderId = products[i].order_id;
        		var dateCreate = products[i]['update_at'];
        		
        		var createFullDate = new Date(dateCreate);
        		var createdDate = createFullDate.getDate();
        		var createdMonth = createFullDate.getMonth();
        		var createdYear = createFullDate.getFullYear();
        		var dateString = createdDate + "/" + (createdMonth + 1) + "/" + createdYear;
        		//button edit date
				var buttonEditDate = '<a class="btn btn-inverse btn-primary mr-10" onclick="showModalEditDateOfOrderDetail('+orderDetailId+','+orderId+','+productId+',\''+dateCreate.toString()+'\')" href="#"><i class="fa fa-edit fa-lg"></i></a>';
				dateString = buttonEditDate + dateString;
				//END button edit date
        		var orderType = products[i].order_type;
        		var orderTypeString = "Nhập hàng";
        		var orderQualityString = "+";
        		if(orderType == 2){
        			orderTypeString = "Bán hàng";
        			orderQualityString = "-";
        		}else if(orderType == 3){
        			orderTypeString = "Cập nhật kho";
        			orderQualityString = "#";
        		}
        		orderQualityString += Omss.numberFormat(products[i].quanlity);
        		
        		var row = [dateString, Omss.numberFormat(products[i].old_instock), orderTypeString, orderQualityString, Omss.numberFormat(products[i].new_instock), ""];
        		datatableHistory.fnAddData(row, true);
        	}
        	datatableHistory.fnDraw();
        	$("#history_order_detail_modal").modal("show");
        }else{
        	Omss.showError(data.message);
        }
    });
}

function bindProductInstockToModal(){
	$('.input_current_instock').val(selectProductInstockToViewHistory);
	$('.input_current_instock').select();
}

function updateProductInstock(){
	console.log("updateProductInstock");
	var newInstock = $('.input_current_instock').autoNumeric('get');
	
	var url = 'kiemkho/updateProductInstock';
	var dataPost = {
	        'pid': selectProductIdToViewHistory,
	        'old_instock' : selectProductInstockToViewHistory,
	        'new_instock' : newInstock
	    };
    
    Omss.post(url, dataPost).done(function(data) {
        if(data.status){
        	$("#update_product_instock_modal").modal("hide");
        	$("#history_order_detail_modal").modal("hide");
        	
        	excuteSearch();
        }else{
        	Omss.showError(data.message);
        }
    });
}

function startSearch(){
	var isCheckCategory = $('.js-checkbox-select-search-category').is( ":checked" );
	var isCheckMaterial = $('.js-checkbox-select-search-material').is( ":checked" );

	var searchCategoryQuery = '';
	var searchMaterialQuery = '';
	var searchDiameterQuery = '';
	var searchLengthQuery = '';
	var searchRangeQuery = '';
	var searchInstockQuery = '';

	if(isCheckCategory){
		searchCategoryQuery = '&category_id=' + parseInt($(".js-form-search-instock .select_category" ).val());
	}

	if(isCheckMaterial){
		searchMaterialQuery = '&material_id=' + parseInt($(".js-form-search-instock .select_material" ).val());
	}

	if($(".js-form-search-instock .input_diameter" ).val() != ''){
		searchDiameterQuery = '&product_diameter=' + parseInt($(".js-form-search-instock .input_diameter" ).autoNumeric('get'));
	}
	if($(".js-form-search-instock .input_length" ).val() != ''){
		searchLengthQuery = '&product_length=' + parseInt($(".js-form-search-instock .input_length" ).autoNumeric('get'));
	}
	if($(".js-form-search-instock .input_product_range" ).val() != ''){
		searchRangeQuery = '&product_range=' + parseInt($(".js-form-search-instock .input_product_range" ).autoNumeric('get'));
	}
	if($(".js-form-search-instock .input_unit_instock" ).val() != ''){
		searchInstockQuery = '&unit_instock=' + parseInt($(".js-form-search-instock .input_unit_instock" ).autoNumeric('get'));
	}

	window.location = '?page=1' + searchCategoryQuery + searchMaterialQuery + searchDiameterQuery + searchLengthQuery + searchRangeQuery + searchInstockQuery;

	return false;
}

//START - Edit date of order detail
var editDateOrderDetailId = '';
var editDateOrderDetailProductId = '';
var editDateOrderDetailOrderId = '';
var oldEditDate = '';
function showModalEditDateOfOrderDetail(orderDetailId, orderId, productId, createFullDate) {
	editDateOrderDetailId = orderDetailId;
	editDateOrderDetailProductId = productId;
	editDateOrderDetailOrderId = orderId;
	oldEditDate = createFullDate;

	editDatePicker.data("DateTimePicker").setDate(new Date(createFullDate));
	$('.modal-edit-date').modal('show');
}

function updateOrderDetailDate() {
	console.log('updateOrderDetailDate');
	var newDate = editDatePicker.find(".input_date").val();
	console.log(newDate);

	//check order has 1 or many product
	var url = 'kiemkho/checkOrderProductNumber';
	var dataPost = {
		'orderid': editDateOrderDetailOrderId
	};

	var promiseCheckOrderProductNumber = Omss.post(url, dataPost);
	var willUpdateAll = false;
	promiseCheckOrderProductNumber.then(function (data) {
		if(data.status){
			var countProduct = data.count;
			if(countProduct > 1){
				if(confirm('Có '+(countProduct - 1)+' khác chung hóa đơn, bạn có muốn cập nhật luôn không?')){
					willUpdateAll = true;
				}
			}
		}
	}).then(function () {
		console.log('willUpdateAll');
		console.log(willUpdateAll);

		var url = 'kiemkho/updateOrderDetailDate';
		var dataPost = {
			'orderdetailid': editDateOrderDetailId,
			'productid' : editDateOrderDetailProductId,
			'newdate' : newDate,
			'orderid': editDateOrderDetailOrderId,
			'updateall' : willUpdateAll
		};

		Omss.post(url, dataPost).done(function(data) {
			if(data.status){
				$(".modal-edit-date").modal("hide");
				location.reload();
			}else{
				Omss.showError(data.message);
			}
		});
	});
}
//END - Edit date of order detail