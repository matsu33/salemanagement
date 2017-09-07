/********************************************************************************
 ****** Variables ***************************************************************
 ********************************************************************************/
var selectedPublisher = null;
var searchCondition = {};
var orderGroupPublisherData = {};
var listAllOrder;
var listDisplayOrder;
var listDisplayOrderMonthDetail;
var listDisplayOrderYearDetail;
var datatableOrderList, datatableOrderListDateDetail, datatableOrderListYearDetail, datatableListPhieuDoiChieuCongNo;
var listPaidOrderId = [];
var listOrderIdPhieuDoiChieuCongNo = [];
var excelDataPhieuDoiChieuCongNo = [];

var columnsListDate = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	
   				{ "bSearchable": true},
   				{ "bSearchable": true}, 						
   				{ "bSearchable": true}, 						
   				{ "bSearchable": true},
   				{ "bSearchable": true}, 						
   				{ "bSearchable": true}, 						
   				{ "bSearchable": false, "bSortable": false} ];
var columnsListMonth = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	
          				{ "bSearchable": true},
          				{ "bSearchable": true}, 						
          				{ "bSearchable": true}, 						
          				{ "bSearchable": true},						
          				{ "bSearchable": true}, 						
          				{ "bSearchable": false, "bSortable": false} ];
var columnsListYear = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	
          				{ "bSearchable": true},
          				{ "bSearchable": true}, 						
          				{ "bSearchable": true}, 	
          				{ "bSearchable": true}, 						
          				{ "bSearchable": true}, 						
          				{ "bSearchable": false, "bSortable": false} ];
var columnsListDateDetail = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	
          				{ "bSearchable": true},
          				{ "bSearchable": true}, 						
          				{ "bSearchable": true},
          				{ "bSearchable": true}, 	
          				{ "bSearchable": false, "bSortable": false} ];	
var columnsListMonthDetail = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	
               				{ "bSearchable": true},
               				{ "bSearchable": true}, 						
               				{ "bSearchable": true},
               				{ "bSearchable": true},
               				{ "bSearchable": true},
               				{ "bSearchable": true},
               				{ "bSearchable": false, "bSortable": false} ];	
var columnsListYearDetail = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	
               				{ "bSearchable": true},
               				{ "bSearchable": true},
               				{ "bSearchable": true}, 						
               				{ "bSearchable": true},
               				{ "bSearchable": true}, 	
               				{ "bSearchable": false, "bSortable": false} ];
var columnsListPhieuDoiChieuCongNo = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	
                				{ "bSearchable": true},
                				{ "bSearchable": true},
                				{ "bSearchable": true}, 	
                				{ "bSearchable": false, "bSortable": false} ];
var dataTableOrderDetail = null;
var columnsListOrderDetail = [{ "bSearchable": false, "sClass": "center", "bSortable": false }, 	
                      				{ "bSearchable": true},
                      				{ "bSearchable": true},
                      				{ "bSearchable": true},
                      				{ "bSearchable": true},
                      				{ "bSearchable": true},
                      				{ "bSearchable": true},
                      				{ "bSearchable": true},
                      				{ "bSearchable": true},
                      				{ "bSearchable": true}, 	
                      				{ "bSearchable": true} ];
/********************************************************************************
 ****** ON LOAD *****************************************************************
 ********************************************************************************/
$(document).ready(function(){
	$(".congno_ngay, .congno_thang, .congno_nam").hide();
	
//	datatableOrderList = Omss.dataTable($(".congno_ngay table"), columnsListDate);
// 	datatableOrderListDateDetail = Omss.dataTable($("#danhsachhoadon_ngay_modal table"), columnsListDateDetail);
//	datatableOrderListMonthDetail = Omss.dataTable($("#danhsachhoadon_thang_modal table"), columnsListMonthDetail);
// 	datatableOrderListYearDetail = Omss.dataTable($("#danhsachhoadon_nam_modal table"), columnsListYearDetail);
	datatableListPhieuDoiChieuCongNo = Omss.dataTable($("#phieu_doi_chieu_cong_no_modal table"), columnsListPhieuDoiChieuCongNo);
	
// 	Omss.post('/customers/getAll').done(function(data) {
// 		console.log(data);
// 		if (data.status == 1) {
// 			$(".nhacungcap_group_popup").html("");
// //			$(".nhacungcap_group_popup").append('<a onclick="selectPublisher(null,null)" class="btn btn-primary" data-dismiss="modal">Tất cả</a>');
// 			$.each( data['data'], function(key, item){
// 				var no, category_name, option;
// 				no = item['id'];
// 				customer_name = item['customer_name'];
// 				$(".nhacungcap_group_popup").append('<a onclick="selectPublisher(\''+no+'\',\''+customer_name+'\')" class="btn btn-primary" data-dismiss="modal">'+customer_name+'</a>');
// 			});
//
// 			$('#nhacungcap_modal').modal('show');
// 		} else {
// 			Omss.showError(data.message);
// 		}
// 	});

	fillCustomerToSelectElement(".select_customer");

	$('.js-date-control').datetimepicker({
		defaultDate: new Date(),
		pickTime: false,
		format: "DD/MM/YYYY"
	});
	var selectedSearchDay = $('.selected-search-day').val();
	if(selectedSearchDay != '') {
		$('.js-input-date').val(selectedSearchDay);
	}

	$('.js-month-control').datetimepicker({
		defaultDate: new Date(),
		pickTime: false,
		minViewMode: 'months',
		format: "MM/YYYY"
	});
	var selectedSearchMonth = $('.selected-search-month').val();
	if(selectedSearchMonth != '') {
		$('.js-input-month').val(selectedSearchMonth);
	}

	$('.js-year-control').datetimepicker({
		defaultDate: new Date(),
		pickTime: false,
		minViewMode: 'years',
		format: "YYYY"
	});
	var selectedSearchYear = $('.selected-search-year').val();
	if(selectedSearchYear != '') {
		$('.js-input-year').val(selectedSearchYear);
	}

	var selectedSearchType = $('.selected-search-type').val();
	$('.js-radio-date-'+selectedSearchType).prop("checked", true);

	$(".js-start-search").click(function(){
		startSearch();
	});
	$(".js-reset-search").click(function(){
		resetSearch();
	});

	$('.js-view-list-order').click(function(){
		var listOrderId = $(this).data('listorderid');
		viewListOrder(listOrderId);
	});
	// $(".congno_xemngay_btn").click(function(){
	// 	$('#choncachxem_modal').modal('hide');
	// 	$(".congno_ngay").show();
	// 	$(".congno_thang").hide();
	// 	$(".congno_nam").hide();
	//
	// 	searchCondition.Type = "1";
     //    searchCondition.Value = $('.doanh_thu_ngay_time').find(".input_date").val();
     //    excuteSearch();
	// });
	//
	// $(".congno_xemthang_btn").click(function(){
	// 	$('#choncachxem_modal').modal('hide');
	// 	$(".congno_ngay").hide();
	// 	$(".congno_thang").show();
	// 	$(".congno_nam").hide();
	//
	// 	searchCondition.Type = "2";
     //    searchCondition.Value = $('.doanh_thu_thang_time').find(".input_date").val();
     //    excuteSearch();
	// });
	//
	// $(".congno_xemnam_btn").click(function(){
	// 	$('#choncachxem_modal').modal('hide');
	// 	$(".congno_ngay").hide();
	// 	$(".congno_thang").hide();
	// 	$(".congno_nam").show();
	//
	// 	searchCondition.Type = "3";
     //    searchCondition.Value = $('.doanh_thu_nam_time').find(".input_date").val();
     //    excuteSearch();
	// });
	
});

function selectPublisher(no, customer_name){
	selectedPublisher = {};
	
	selectedPublisher['no'] = no;
	selectedPublisher['customer_name'] = customer_name;
	
	$('#choncachxem_modal').modal('show');
}

function excuteSearch() {
    var url = 'customerdebt/excuteSearch';
    var dateCondition = getFromToDate(searchCondition.Type, searchCondition.Value);
    dateCondition['customerid'] = selectedPublisher['no'];
    dateCondition['datetype'] = searchCondition.Type;
    
    Omss.post(url, dateCondition).done(function(data) {
    	console.log(data);
        if (data.status) {
            $('#choncachxem_modal').modal('hide');
            $('#chonngay_modal').modal('hide');
            $('#chonthang_modal').modal('hide');
            $('#chonnam_modal').modal('hide');
            listAllOrder = data.data;
            listDisplayOrder = {};

        	$.each( listAllOrder, function(key, item){
//            		create_at: "2015-01-08 11:23:13"customer_id: nullcustomer_type: nulldate_paid: "2015-01-15 11:29:16"debt: "748.00"id: "2"order_type: "1"paid: "0.00"customer_id: "2"customer_name: "Thành Hòa"status: "1"total: "748.00"update_at: "2015-01-08 17:23:13"user_id: null
        		var customer_id = item['customer_id'];
        		var dateBuy = item['create_at'];
        		var customerName = item['customer_name'];
        		var status = item['status'];
        		var debt = item['debt'];
        		var paid = item['paid'];
        		var total = item['total'];
        		var orderId = item['id'];
        		var order = {};
        		order['customer_id'] = customer_id;
        		order['create_at'] = dateBuy;
        		order['customerName'] = customerName;
        		order['status'] = status;
        		order['debt'] = debt;
        		order['paid'] = paid;
        		order['total'] = total;
        		order['orderId'] = orderId;
        		if(status == "1"){
        			//paid
        			order['soHoaDonDaThanhToan'] = 1;
        			order['soHoaDonChuaThanhToan'] = 0;
        		}else{
        			//debt
        			order['soHoaDonDaThanhToan'] = 0;
        			order['soHoaDonChuaThanhToan'] = 1;
        		}
        		
        		
        		addOrderToListDisplay(order);
        	});
        	console.log("listDisplayOrder");
        	console.log(listDisplayOrder);
        	
        	//init table to display list
        	if(searchCondition.Type == "1"){
        		datatableOrderList = Omss.dataTable($(".congno_ngay table"), columnsListDate);
        	}else if(searchCondition.Type == "2"){
        		datatableOrderList = Omss.dataTable($(".congno_thang table"), columnsListMonth);
        	}else if(searchCondition.Type == "3"){
        		datatableOrderList = Omss.dataTable($(".congno_nam table"), columnsListYear);
        	}
            
            //display list
        	displayOrderDateInView();
        } else {
        	$(".congno_ngay table tbody, .congno_thang table tbody, .congno_nam table tbody").html("");
            Omss.showError(data.message);
        }
    });
}

function addOrderToListDisplay(order){
	var orderFullDate = new Date(order['create_at']);
	var orderDate = orderFullDate.getDate();
	var orderMonth = orderFullDate.getMonth();
	
	if(Object.keys(listDisplayOrder).length <= 0){
		if(searchCondition.Type == "1"){
			listDisplayOrder[order['customer_id']] = order;
		}else if(searchCondition.Type == "2"){
			listDisplayOrder[orderDate] = order;
		}else if(searchCondition.Type == "3"){
			listDisplayOrder[orderMonth] = order;
		} 
		
		return;
	}
	
	var isDuplicate = false;
	
	$.each( listDisplayOrder, function(key, item){
		if(searchCondition.Type == "1"){
			//date
			if(item['customer_id'] == order['customer_id']){
				item['soHoaDonDaThanhToan'] = item['soHoaDonDaThanhToan'] + order['soHoaDonDaThanhToan'];
				item['soHoaDonChuaThanhToan'] = item['soHoaDonChuaThanhToan'] + order['soHoaDonChuaThanhToan'];
				item['debt'] = parseFloat(item['debt']) + parseFloat(order['debt']);
				item['paid'] = parseFloat(item['paid']) + parseFloat(order['paid']);
				isDuplicate = true;
				if(item['soHoaDonChuaThanhToan'] >= 1){
					item['status'] = "2";
				}
				return;
			}
		}else if(searchCondition.Type == "2"){
			//month
			var itemFullDate = new Date(item['create_at']);
			var itemDate = itemFullDate.getDate();
			if(itemDate == orderDate){
				item['soHoaDonDaThanhToan'] = item['soHoaDonDaThanhToan'] + order['soHoaDonDaThanhToan'];
				item['soHoaDonChuaThanhToan'] = item['soHoaDonChuaThanhToan'] + order['soHoaDonChuaThanhToan'];
				item['debt'] = parseFloat(item['debt']) + parseFloat(order['debt']);
				item['paid'] = parseFloat(item['paid']) + parseFloat(order['paid']);
				isDuplicate = true;
				if(item['soHoaDonChuaThanhToan'] >= 1){
					item['status'] = "2";
				}
				return;
			}
		}else if(searchCondition.Type == "3"){
			//year
			var itemFullDate = new Date(item['create_at']);
			var itemMonth = itemFullDate.getMonth();
			if(itemMonth == orderMonth){
				item['soHoaDonDaThanhToan'] = item['soHoaDonDaThanhToan'] + order['soHoaDonDaThanhToan'];
				item['soHoaDonChuaThanhToan'] = item['soHoaDonChuaThanhToan'] + order['soHoaDonChuaThanhToan'];
				item['debt'] = parseFloat(item['debt']) + parseFloat(order['debt']);
				item['paid'] = parseFloat(item['paid']) + parseFloat(order['paid']);
				isDuplicate = true;
				if(item['soHoaDonChuaThanhToan'] >= 1){
					item['status'] = "2";
				}
				
				return;
			}
		}
	});
	
	if(isDuplicate == false){
		if(searchCondition.Type == "1"){
			listDisplayOrder[order['customer_id']] = order;
		}else if(searchCondition.Type == "2"){
			listDisplayOrder[orderDate] = order;
		}else if(searchCondition.Type == "3"){
			listDisplayOrder[orderMonth] = order;
		}
	}
}

function displayOrderDateInView(){
	datatableOrderList.fnClearTable(0);
	$.each( listDisplayOrder, function(key, item){
		var status = item['status'];
		var dateCreate = item['create_at'];
		var createFullDate = new Date(dateCreate);
		var createdDate = createFullDate.getDate();
		var createdMonth = createFullDate.getMonth();
		var createdYear = createFullDate.getFullYear();
		
		var customer_id = item['customer_id'];
		var customerName = item['customerName'];
		var soHoaDon = 0;
		var thanhTien = 0;
		var soHoaDonDaThanhToan = item['soHoaDonDaThanhToan'];
		var paid = item['paid'];
		var soHoaDonChuaThanhToan = item['soHoaDonChuaThanhToan'];
		var debt = item['debt'];
		
		var linkThanhToan = '';
		
		var checkbox = '';
		
		
		var row;
		if(searchCondition.Type == "1"){
			if(status == "2"){
				checkbox = '<input type="checkbox" value="'+customer_id+'">';
			}
			linkThanhToan = '<a onclick="bindDataCongNoNgay(\''+customer_id+'\')" class="btn btn-inverse btn-primary" data-toggle="modal" data-target="#danhsachhoadon_ngay_modal" ><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanh toán</a>';
			row = [checkbox, createdDate + "/" + (createdMonth + 1) + "/" + createdYear, customerName, soHoaDonDaThanhToan, Omss.numberFormat(paid), soHoaDonChuaThanhToan, Omss.numberFormat(debt), linkThanhToan];
		}else if(searchCondition.Type == "2"){
			if(status == "2"){
				checkbox = '<input type="checkbox" value="'+createdDate+'">';
			}
			linkThanhToan = '<a onclick="bindDataCongNoThang(\''+createdDate+'\')" class="btn btn-inverse btn-primary" data-toggle="modal" data-target="#danhsachhoadon_ngay_modal" ><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanh toán</a>';
			row = [checkbox, createdDate + "/" + (createdMonth + 1) + "/" + createdYear, soHoaDonDaThanhToan, Omss.numberFormat(paid), soHoaDonChuaThanhToan, Omss.numberFormat(debt), linkThanhToan];
		}else if(searchCondition.Type == "3"){
			if(status == "2"){
				checkbox = '<input type="checkbox" value="'+ (createdMonth + 1)+'">';
			}
			linkThanhToan = '<a onclick="bindDataCongNoNam(\''+createdMonth+'\')" class="btn btn-inverse btn-primary" data-toggle="modal" data-target="#danhsachhoadon_nam_modal" ><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanh toán</a>';
			row = [checkbox, (createdMonth + 1) + "/" + createdYear, soHoaDonDaThanhToan, Omss.numberFormat(paid), soHoaDonChuaThanhToan, Omss.numberFormat(debt), linkThanhToan];
		}
		
		datatableOrderList.fnAddData(row, true);
	});
	datatableOrderList.fnDraw();
}

function bindDataCongNoNgay(publisherId){
	datatableOrderListDateDetail.fnClearTable(0);
	$.each( listAllOrder, function(key, item){
		
		var customer_id = item['customer_id'];
		if(customer_id == publisherId){
			var status = item['status'];
			var dateCreate = item['create_at'];
			var createFullDate = new Date(dateCreate);
			var createdDate = createFullDate.getDate();
			var createdMonth = createFullDate.getMonth();
			var createdYear = createFullDate.getFullYear();
			
			var orderId = item['id'];
			var customer_name = item['customer_name'];
			var paid = item['paid'];
			var debt = item['debt'];
			var total = item['total'];
			var date_paid = item['date_paid'];
			var linkThanhToan = '';
//			linkThanhToan = '<a onclick="bindDataCongNoNgay("'+customer_id+'")" class="btn btn-inverse btn-primary" data-toggle="modal" data-target="#danhsachhoadon_ngay_modal" ><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanhtoán</a>';
			linkThanhToan = '<a onclick="viewOrderDetail('+orderId+')" class="btn btn-inverse btn-primary"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Xem chi tiết</a>';
			var checkbox = '';
			
			if(status == "2"){
				checkbox = '<input type="checkbox" value="'+orderId+'">';
				date_paid = "";
			}
			
			var row = [checkbox, createdDate + "/" + (createdMonth + 1) + "/" + createdYear, customer_name, Omss.numberFormat(total), getDateStringWithoutTime(date_paid), linkThanhToan];
			
			datatableOrderListDateDetail.fnAddData(row, true);
		}
	});
	datatableOrderListDateDetail.fnDraw();
}

function bindDataCongNoThang(createDate){
	
	datatableOrderListDateDetail.fnClearTable(0);
	$.each( listAllOrder, function(key, item){
		
		var customer_id = item['customer_id'];
		var dateCreate = item['create_at'];
		
		var createFullDate = new Date(dateCreate);
		var createdDate = createFullDate.getDate();
		
		if(createdDate == createDate){
			var status = item['status'];
			var dateCreate = item['create_at'];
			var createFullDate = new Date(dateCreate);
			var createdDate = createFullDate.getDate();
			var createdMonth = createFullDate.getMonth();
			var createdYear = createFullDate.getFullYear();
			
			var orderId = item['id'];
			var customer_name = item['customer_name'];
			var paid = item['paid'];
			var debt = item['debt'];
			var total = item['total'];
			var date_paid = item['date_paid'];
			var linkThanhToan = "";
//			linkThanhToan = '<a onclick="bindDataCongNoNgay("'+customer_id+'")" class="btn btn-inverse btn-primary" data-toggle="modal" data-target="#danhsachhoadon_ngay_modal" ><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanhtoán</a>';
			linkThanhToan = '<a onclick="viewOrderDetail('+orderId+')" class="btn btn-inverse btn-primary"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Xem chi tiết</a>';
			var checkbox = '';
			
			if(status == "2"){
				checkbox = '<input type="checkbox" value="'+orderId+'">';
				date_paid = "";
			}
			
			var row = [checkbox, createdDate + "/" + (createdMonth + 1) + "/" + createdYear, customer_name, Omss.numberFormat(total), getDateStringWithoutTime(date_paid), linkThanhToan];
			
			datatableOrderListDateDetail.fnAddData(row, true);
		}
	});
	datatableOrderListDateDetail.fnDraw();
}

function bindDataCongNoNam(createMonth){
	listDisplayOrderYearDetail = {};
	var isDuplicate = false;
	
	$(".danhsachhoadon_nam_modal_create_month").val(createMonth);
	$.each( listAllOrder, function(key, item){
		
		var customer_id = item['customer_id'];
		var dateCreate = item['create_at'];
		
		var createFullDate = new Date(dateCreate);
		var createdDate = createFullDate.getDate();
		var createdMonth = createFullDate.getMonth();
		var createdYear = createFullDate.getFullYear();
		
		
		if(createdMonth == createMonth){
			var status = item['status'];
			var dateCreate = item['create_at'];
			
			if(status == "2"){
				//debt
				item['soHoaDonDaThanhToan'] = 0;
				item['soHoaDonChuaThanhToan'] = 1;
			}else{
				//paid
				item['soHoaDonDaThanhToan'] = 1;
				item['soHoaDonChuaThanhToan'] = 0;
			}
			if(Object.keys(listDisplayOrderYearDetail).length <= 0){
				listDisplayOrderYearDetail[createdDate] = item;
				return;
			}
			
			isDuplicate = false;
			
			$.each( listDisplayOrderYearDetail, function(key2, item2){
				var createFullDate2 = new Date(item2['create_at']);
				var createdDate2 = createFullDate2.getDate();
				var createdMonth2 = createFullDate2.getMonth();
				var createdYear2 = createFullDate2.getFullYear();
				
				if(createdDate2 == createdDate){
					item2['soHoaDonDaThanhToan'] = item['soHoaDonDaThanhToan'] + item2['soHoaDonDaThanhToan'];
					item2['soHoaDonChuaThanhToan'] = item['soHoaDonChuaThanhToan'] + item2['soHoaDonChuaThanhToan'];
					item2['debt'] = parseFloat(item['debt']) + parseFloat(item2['debt']);
					item2['paid'] = parseFloat(item['paid']) + parseFloat(item2['paid']);
					isDuplicate = true;
					return;
				}
			});
			
			if(isDuplicate == false){
				listDisplayOrderYearDetail[createdDate] = item;
			}
		}
	});

	datatableOrderListYearDetail.fnClearTable(0);
	$.each( listDisplayOrderYearDetail, function(key, item){
		
		var customer_id = item['customer_id'];
		var customerName = item['customer_name'];
		var status = item['status'];
		var dateCreate = item['create_at'];
		
		var createFullDate = new Date(dateCreate);
		var createdDate = createFullDate.getDate();
		var createdMonth = createFullDate.getMonth();
		var createdYear = createFullDate.getFullYear();
		
		var orderId = item['id'];
		var paid = item['paid'];
		var debt = item['debt'];
		var total = item['total'];
		var date_paid = item['date_paid'];
		var linkThanhToan = '';
		//linkThanhToan = '<a onclick="bindDataCongNoNgay("'+customer_id+'")" class="btn btn-inverse btn-primary" data-toggle="modal" data-target="#danhsachhoadon_ngay_modal" ><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanhtoán</a>';
		var checkbox = '';
		
		if(item['soHoaDonChuaThanhToan'] >= 1){
			checkbox = '<input type="checkbox" value="'+createdDate+'">';
			date_paid = "";
		}
		
		var row = [checkbox, createdDate + "/" + (createdMonth + 1) + "/" + createdYear, item['soHoaDonDaThanhToan'], Omss.numberFormat(paid),  item['soHoaDonChuaThanhToan'], Omss.numberFormat(debt), linkThanhToan];
		
		datatableOrderListYearDetail.fnAddData(row, true);
	});
	datatableOrderListYearDetail.fnDraw();
}

function paidOrderYearInPopupDetail(){
	
	var listDate =  $("#danhsachhoadon_nam_modal table input:checkbox:checked").map(function() {
        return $(this).val();
    }).get(); // <----
	if(listDate.length <= 0){
		return false;
	}
	var createMonth = $(".danhsachhoadon_nam_modal_create_month").val();
	listPaidOrderId = [];
	
	$.each( listAllOrder, function(key, item){
		var orderId = item['id'];
		var dateCreate = item['create_at'];
		
		var createFullDate = new Date(dateCreate);
		var createdDate = createFullDate.getDate();
		var createdMonth = createFullDate.getMonth();
		
		if(createdMonth == createMonth  && $.inArray( createdDate + "", listDate ) >= 0 ){
			listPaidOrderId.push(orderId);
		}
	});
	
	paidWithOrderListId();
	
	$("#danhsachhoadon_nam_modal").modal("hide");
}

function paidOrderDateInPopupDetail(){
	listPaidOrderId = $("#danhsachhoadon_ngay_modal table input:checkbox:checked").map(function() {
        return $(this).val();
    }).get(); // <----
	
	paidWithOrderListId();
}

function paidWithOrderListId(){
	if(listPaidOrderId.length > 0){
		var data = {};

		var dataPost = {
			'dataPost': JSON.stringify({'data' : listPaidOrderId})
		};

		Omss.post('/publisherdebt/paid', dataPost).done(function(data) {
			console.log(data);
			if (data.status == 1) {
				// excuteSearch();
				// $("#danhsachhoadon_ngay_modal").modal("hide");
				location.reload();
			} else {
				Omss.showError(data.message);
			}
		});
	}
}

function clickThanhToanCongNo(){
	console.log("clickThanhToanCongNo");
	var listPublisherId;
	listPaidOrderId =  [];
	
	if(searchCondition.Type == "1"){
		listPublisherId = $(".congno_ngay table input:checkbox:checked").map(function() {
	        return $(this).val();
	    }).get();
		
		if(listPublisherId.length <= 0){
			return;
		}
		
		$.each( listAllOrder, function(key, item){
			
			var customer_id = item['customer_id'];
			var status = item['status'];
			var orderId = item['id'];
			
			if($.inArray(customer_id, listPublisherId) >= 0 && status == 1){
				listPaidOrderId.push(orderId);
			}
		});
		
		paidWithOrderListId();
	}else if(searchCondition.Type == "2"){
		listDate = $(".congno_thang table input:checkbox:checked").map(function() {
	        return $(this).val();
	    }).get();
		
		if(listDate.length <= 0){
			return;
		}
		
		$.each( listAllOrder, function(key, item){
			
			var customer_id = item['customer_id'];
			var status = item['status'];
			var orderId = item['id'];
			
			var dateCreate = item['create_at'];
			
			var createFullDate = new Date(dateCreate);
			var createdDate = createFullDate.getDate() + "";
			
			if($.inArray(createdDate, listDate) >= 0 && status == 1){
				listPaidOrderId.push(orderId);
			}
		});
		
		paidWithOrderListId();
	}else if(searchCondition.Type == "3"){
		listMonth = $(".congno_nam table input:checkbox:checked").map(function() {
	        return $(this).val();
	    }).get();
		
		if(listMonth.length <= 0){
			return;
		}
		
		$.each( listAllOrder, function(key, item){
			
			var customer_id = item['customer_id'];
			var status = item['status'];
			var orderId = item['id'];
			
			var dateCreate = item['create_at'];
			
			var createFullDate = new Date(dateCreate);
			var createdMonth = (createFullDate.getMonth() + 1) + "";
			
			if($.inArray(createdMonth, listMonth) >= 0 && status == 1){
				listPaidOrderId.push(orderId);
			}
		});
		
		paidWithOrderListId();
	}
}

/***********************************************************************************
 * Phieu doi chieu cong no
 ***********************************************************************************/
/**
 * add order id list to phieu doi chieu cong no
 */
function themVaoPhieuDoiChieuCongNo(){
	console.log("themVaoPhieuDoiChieuCongNo");
	listOrderIdPhieuDoiChieuCongNo = $("#danhsachhoadon_ngay_modal table input:checkbox:checked").map(function() {
		return $(this).val();
	}).get(); // <----


	/*if(searchCondition.Type == "1"){
		//ngày
		listOrderIdPhieuDoiChieuCongNo = $("#danhsachhoadon_ngay_modal table input:checkbox:checked").map(function() {
	        return $(this).val();
	    }).get(); // <----
	}else if(searchCondition.Type == "2"){
		//tháng
		listOrderIdPhieuDoiChieuCongNo = $("#danhsachhoadon_ngay_modal table input:checkbox:checked").map(function() {
	        return $(this).val();
	    }).get(); // <----
	}else if(searchCondition.Type == "3"){
		//năm
		var listDate =  $("#danhsachhoadon_nam_modal table input:checkbox:checked").map(function() {
	        return $(this).val();
	    }).get(); // <----
		if(listDate.length <= 0){
			return false;
		}
		var createMonth = $(".danhsachhoadon_nam_modal_create_month").val();
		listOrderIdPhieuDoiChieuCongNo = [];
		
		$.each( listAllOrder, function(key, item){
			var orderId = item['id'];
			var dateCreate = item['create_at'];
			
			var createFullDate = new Date(dateCreate);
			var createdDate = createFullDate.getDate();
			var createdMonth = createFullDate.getMonth();
			
			if(createdMonth == createMonth  && $.inArray( createdDate + "", listDate ) >= 0 ){
				listOrderIdPhieuDoiChieuCongNo.push(orderId);
			}
		});
	}*/
	if(listOrderIdPhieuDoiChieuCongNo.length > 0){
		Omss.showError('Đã thêm vào danh sách');
	}
	
	console.log(listOrderIdPhieuDoiChieuCongNo);
}

/**
 * display phieu doi chieu cong no
 */
function viewPhieuDoiChieuCongNo(){
	excelDataPhieuDoiChieuCongNo = [];
	
	console.log("viewPhieuDoiChieuCongNo");

	datatableListPhieuDoiChieuCongNo.fnClearTable(0);
	$('#phieu_doi_chieu_cong_no_modal').modal('hide');
	if (listOrderIdPhieuDoiChieuCongNo.length <= 0) {
		Omss.showError('Chưa có hóa đơn nào');
		return false;
	}else{
		var dataPost = {
			'listOrderId': listOrderIdPhieuDoiChieuCongNo.toString()
		};
		Omss.post('/customerdebt/getlistorder', dataPost).done(function(data) {

			if (data.status == 1) {
				$('#phieu_doi_chieu_cong_no_modal').modal('show');
				for(var i = 0; i < listOrderIdPhieuDoiChieuCongNo.length; i++) {
					var orderId = listOrderIdPhieuDoiChieuCongNo[i];
					var order = _.where(data.data, {id: orderId + ""})[0];
					if(order){
						var debt = order['debt'];

						var dateCreate = order['create_at'];
						var createFullDate = new Date(dateCreate);
						var createdDate = createFullDate.getDate();
						var createdMonth = createFullDate.getMonth();
						var createdYear = createFullDate.getFullYear();

						var linkThanhToan = '<a onclick="removeOrderOutOfPhieuDoiChieuCongNo('+orderId+')" class="btn btn-inverse btn-primary" ><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Xóa</a>';
						var row = ["", createdDate + "/" + (createdMonth + 1) + "/" + createdYear, "",  Omss.numberFormat(debt), linkThanhToan];

						datatableListPhieuDoiChieuCongNo.fnAddData(row, true);
						order['date'] =  createdDate + "/" + (createdMonth + 1) + "/" + createdYear;
						excelDataPhieuDoiChieuCongNo.push(order);

					}
				}
				datatableListPhieuDoiChieuCongNo.fnDraw();
			} else {
				Omss.showError(data.message);
			}
		});
	}
	/*datatableListPhieuDoiChieuCongNo.fnClearTable(0);
	for(var i = 0; i < listOrderIdPhieuDoiChieuCongNo.length; i++){
		var orderId = listOrderIdPhieuDoiChieuCongNo[i];
		console.log('orderId : '+orderId);
		//TODO: get order by id
		var order = null;

		order = _.where(listAllOrder, {id: orderId + ""})[0];
		if(order){
			var debt = order['debt'];
			
			var dateCreate = order['create_at'];
			var createFullDate = new Date(dateCreate);
			var createdDate = createFullDate.getDate();
			var createdMonth = createFullDate.getMonth();
			var createdYear = createFullDate.getFullYear();
			
			var linkThanhToan = '<a onclick="removeOrderOutOfPhieuDoiChieuCongNo('+orderId+')" class="btn btn-inverse btn-primary" ><span class="glyphicon glyphicon-remove"></span>&nbsp;&nbsp;Xóa</a>';
			var row = ["", createdDate + "/" + (createdMonth + 1) + "/" + createdYear, "",  Omss.numberFormat(debt), linkThanhToan];
			
			datatableListPhieuDoiChieuCongNo.fnAddData(row, true);
			order['date'] =  createdDate + "/" + (createdMonth + 1) + "/" + createdYear;
			excelDataPhieuDoiChieuCongNo.push(order);
			
		}
		
	}
	datatableListPhieuDoiChieuCongNo.fnDraw();*/
	
	
}

function removeOrderOutOfPhieuDoiChieuCongNo(orderIdRemove){
	//remove orderid out of array
	listOrderIdPhieuDoiChieuCongNo = _.reject(listOrderIdPhieuDoiChieuCongNo, function(orderId){ return (orderId == orderIdRemove); });
	
	viewPhieuDoiChieuCongNo();
}

function exportPhieuDoiChieuCongNo(){
	console.log("exportPhieuDoiChieuCongNo");
	
	if (excelDataPhieuDoiChieuCongNo.length <= 0) {
        Omss.showError('Chưa có hóa đơn nào');
        return false;
    } else {
//        var date_buy = $("#input_date").val();
//        var publisher_id = $(".order_date_publisher").find(".select_publisher").val();

        var dataPost = {
            'data': excelDataPhieuDoiChieuCongNo
        };

        post_to_url('customerdebt/excel', dataPost, null);
    }
}

function bindOrderDetailWithData(data){
	if(!dataTableOrderDetail){
		dataTableOrderDetail = Omss.dataTable($("#order_detail_modal table"), columnsListOrderDetail);
	}
	
	dataTableOrderDetail.fnClearTable(0);
	$.each( data.data, function(key, item){
			var image, categoryName, materialName, diameter, length, range, quanlity, unitName, price, total;
			var product_image = item['image'];
			image = '<img class="center-block img-rounded table_thumbnail_image" src="'+imageFolderUrl+'products/'+product_image+'" alt="No-image"'+
			'onerror="this.onerror=null;this.src=\''+noImageUrl+'\'" />'; 

			var dateCreate = item['create_at'];
			var createFullDate = new Date(dateCreate);
			var createdDate = createFullDate.getDate();
			var createdMonth = createFullDate.getMonth();
			var createdYear = createFullDate.getFullYear();
			
			categoryName = item['category_name'];
			materialName = item['material_name'];
			diameter = item['diameter'];
			length = item['length'];
			range = item['product_range'];
			quanlity = item['quanlity'];
			unitName = item['unit_name'];
			price = item['price'];
			total = item['money'];
			
			var row = [image, createdDate + "/" + (createdMonth + 1) + "/" + createdYear, categoryName, materialName, diameter, length, range, Omss.numberFormat(quanlity), unitName, Omss.numberFormat(price), Omss.numberFormat(total)];
			
			dataTableOrderDetail.fnAddData(row, true);
		}
	);
	dataTableOrderDetail.fnDraw();
}

function startSearch(){
	var isCheckcustomer = $('.js-checkbox-select-search-customer').is( ":checked" );
	var searchType = $('input[name="js-select-search-type"]:checked').val();
	var searchDate = $('.js-input-date-' + searchType).val();
	var dateCondition = getFromToDate(searchType, searchDate);
	var searchDay = $('.js-input-date').val();
	var searchMonth = $('.js-input-month').val();
	var searchYear = $('.js-input-year').val();
	console.log('searchType :' +searchType);
	console.log('searchDate :');
	console.log(searchDate);
	// console.log('dateCondition :');
	// console.log(encodeURI(dateCondition.date_from));
	// console.log(encodeURI(dateCondition.date_to));

	var searchcustomerQuery = '';
	var searchTypeQuery = '&search_type=' + searchType;
	var searchDateQuery = '&search_date=' + searchDate;
	var searchDayQuery = '&search_day=' + searchDay;
	var searchMonthQuery = '&search_month=' + searchMonth;
	var searchYearQuery = '&search_year=' + searchYear;

	if(isCheckcustomer){
		searchcustomerQuery = '&customer_id=' + parseInt($(".js-select-customer-indebt" ).val());
	}
	// console.log('?page=1' + searchcustomerQuery + searchTypeQuery + searchDateQuery + searchDayQuery + searchMonthQuery + searchYearQuery);
	// return false;
	window.location = '?page=1' + searchcustomerQuery + searchTypeQuery + searchDateQuery + searchDayQuery + searchMonthQuery + searchYearQuery;



	return false;
}

function resetSearch(){
	window.location = '/no_khach_hang';
}

function viewListOrder(listOrderId){
	console.log(listOrderId);
	var dataPost = {
		'listOrderId': listOrderId
	};

	Omss.post('/customerdebt/getlistorder', dataPost).done(function(data) {
		console.log(data);
		if (data.status == 1) {
			// excuteSearch();
			$("#danhsachhoadon_ngay_modal").modal("show");
			var tableBody = $("#danhsachhoadon_ngay_modal .modal-body table tbody");
			tableBody.html('');
			$.each( data.data, function(key, item){
				var dateCreate = item['create_at'];
				var createFullDate = new Date(dateCreate);
				var createdDate = createFullDate.getDate();
				var createdMonth = createFullDate.getMonth() + 1;
				var createdYear = createFullDate.getFullYear();
				var inputDate = createdDate + '/' + createdMonth + '/' + createdYear;

				var total = item['total'];
				var customer_name = item['customer_name'];
				var date_paid = '';
				var status = item['status'];
				var orderId = item['id'];
				statusString = '';
				var checkboxThanhToan = '';

				if(status == 1){
					statusString = 'Đã thanh toán';
					date_paid = getFormattedDate(item['date_paid']);
				}else{
					checkboxThanhToan = '<input type="checkbox" value="'+orderId+'">';
					statusString = '<a onclick="viewOrderDetail('+orderId+')" class="btn btn-inverse btn-primary"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Xem chi tiết</a>';
				}


				var trStringStart = '<tr>';
				var tdString1 = '<td>'+checkboxThanhToan+'</td>';//checkbox
				var tdString2 = '<td>'+inputDate+'</td>';//ngay nhap hang
				var tdString3 = '<td>'+customer_name+'</td>';//nha cung cap
				var tdString4 = '<td>'+Omss.numberFormat(total)+'</td>';//thanh tien
				var tdString5 = '<td>'+date_paid+'</td>';//ngay thanh toan
				var tdString6 = '<td>'+statusString+'</td>';//status
				var trStringEnd = '</tr>';

				var fullRowString = trStringStart + tdString1 + tdString2 + tdString3 + tdString4 + tdString5 + tdString6 + trStringEnd;
				console.log(total);
				tableBody.append(fullRowString);
			});
		} else {
			Omss.showError(data.message);
		}
	});
}

function paidListOrder(){
	listPaidOrderId = [];
	$('.js-table-list-order input:checkbox:checked').each(function () {
		var listOrderId = $(this).data('listorderid').toString().split(',');
		listPaidOrderId = listPaidOrderId.concat(listOrderId);
	});

	console.log('listPaidOrderId : ');
	console.log(listPaidOrderId);
	paidWithOrderListId();
}