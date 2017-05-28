var searchCondition = {};
var datatableLoc = {};
var columnsList = [{
    "bSearchable": true
}, {
    "bSearchable": true
}];
var orderDatas = null;

var datatableDetail = {};
var columnsDetailList = [{
    "bSearchable": true
}, {
    "bSearchable": true
}, {
    "bSearchable": true
}];

$(document).ready(function() {
    datatableLoc = Omss.dataTable($("#table_loc"), columnsList);
    datatableDetail = Omss.dataTable($("#table_detail"), columnsDetailList);

    $(".doanhthu_loctheongay").click(function() {
    	searchCondition.Material = false;
    });
    
    initSearch();

    $('.doanh_thu_ngay_time').datetimepicker({
        defaultDate: new Date(),
        pickTime: false,
        format: "DD/MM/YYYY"
    });

    $('.doanh_thu_thang_time').datetimepicker({
        defaultDate: new Date(),
        pickTime: false,
        minViewMode: 'months',
        format: "MM/YYYY"
    });

    $('.doanh_thu_nam_time').datetimepicker({
        defaultDate: new Date(),
        pickTime: false,
        minViewMode: 'years',
        format: "YYYY"
    });

    $(".doanhthu_loctheongay").click(function() {
        initSearch();
    });

    $(".doanhthu_xemngay_btn").click(function() {
        searchCondition.Type = "1";
        searchCondition.Value = $('.doanh_thu_ngay_time').find(".input_date").val();
        excuteSearch();
    });

    $(".doanhthu_xemthang_btn").click(function() {
        searchCondition.Type = "2";
        searchCondition.Value = $('.doanh_thu_thang_time').find(".input_date").val();
        excuteSearch();
    });

    $(".doanhthu_xemnam_btn").click(function() {
        searchCondition.Type = "3";
        searchCondition.Value = $('.doanh_thu_nam_time').find(".input_date").val();
        excuteSearch();
    });
    
    $('#chonchatlieu_modal').on('show.bs.modal', function () {
    	var url = 'kiemkho/getListMaterial';
        var data = {};
        Omss.post(url, data).done(function(data) {
            var html = '';
            $("#chonchatlieu_modal .chatlieu_group_popup").html(html);
            if (data) {
                for (var i = 0; i < data.length; i++) {
                    html += '<a class="btn btn-primary col-xs-2" data-toggle="modal">';
                    html += data[i].material_name;
                    html += '<input type="hidden" class="material_id" value="' + data[i].id + '" /></a>';
                }
                $("#chonchatlieu_modal .chatlieu_group_popup").html(html);
                $("#chonchatlieu_modal .chatlieu_group_popup a").click(function() {
                    searchCondition.Type = "4";
                    searchCondition.Value = $(this).find('.material_id').val();
                    //excuteMaterialSearch();
                    $("#chonthoigian_modal").modal("show");
                });
            } else {
                Omss.showError("Không có dữ liệu chất liệu!");
            }
        });
	});
});

function initSearch() {
    showSearchType();
}

function showSearchType() {
    $('#choncachxem_modal').modal('show');
}

function excuteMaterialSearch() {
    var url = 'doanhthudaura/excuteMaterialSearch';
    var data = {
    		material_id: searchCondition.Value
    }
    Omss.post(url, data).done(function(data) {
    	console.log(data);
    });
}

function excuteSearch() {
    var url = 'doanhthudaura/excuteSearch';
    var dateCondition = getFromToDate(searchCondition.Type, searchCondition.Value);

    if(searchCondition.Material){
    	dateCondition.materialId = searchCondition.MaterialValue;
    	url = 'doanhthudauvao/excuteMaterialSearch';
    }
    
    Omss.post(url, dateCondition).done(function(data) {
        if (data.status) {
            $('#choncachxem_modal').modal('hide');
            $('#chonngay_modal').modal('hide');
            $('#chonthang_modal').modal('hide');
            $('#chonnam_modal').modal('hide');
            $('#chonthoigian_modal').modal('hide');
            $('#chonchatlieu_modal').modal('hide');
            
            datatableLoc.fnClearTable(0);
            orderDatas = data.data;
            var total_whole_sale = 0;
            var total_retail_sale = 0;
            var total = 0;

            for (var i = 0; i < orderDatas.length; i++) {
                orderDatas[i].date_group_by = Omss.dateFormat(orderDatas[i].date_paid, 'dd/MM/yyyy');
                orderDatas[i].year_group_by = Omss.dateFormat(orderDatas[i].date_paid, 'MM/yyyy');
            }
            if (searchCondition.Type == "3") {
                $("#table_loc .date_text").html("Tháng");
                var obj_group_by = groupBy(orderDatas, function(item) {
                    return item.year_group_by;
                });
                for (var i = 0; i < obj_group_by.length; i++) {
                    total = 0;
                    for (var j = 0; j < obj_group_by[i].length; j++) {
                        total = total + Omss.parseFloat(obj_group_by[i][j].total, 0);
                    }
                    var linkDetail = '<a class="btn btn-inverse btn-primary btn_detail" onclick="showDetailType3(\'' + obj_group_by[i][0].year_group_by + '\');"><i class="fa fa-edit fa-lg"></i></a>';
                    var row = [obj_group_by[i][0].year_group_by, Omss.numberFormat(total) + linkDetail];
                    datatableLoc.fnAddData(row, true);
                }
                datatableLoc.fnDraw();
            } else {
                $("#table_loc .date_text").html("Ngày");
                var obj_group_by = groupBy(orderDatas, function(item) {
                    return item.date_group_by;
                });
                for (var i = 0; i < obj_group_by.length; i++) {
                    total = 0;
                    for (var j = 0; j < obj_group_by[i].length; j++) {
                        total = total + Omss.parseFloat(obj_group_by[i][j].total, 0);
                    }
                    var linkDetail = '<a class="btn btn-inverse btn-primary btn_detail" onclick="showDetail(\'' + obj_group_by[i][0].date_group_by + '\');"><i class="fa fa-edit fa-lg"></i></a>';
                    var row = [obj_group_by[i][0].date_group_by, Omss.numberFormat(total) + linkDetail];
                    datatableLoc.fnAddData(row, true);
                }
                datatableLoc.fnDraw();
            }
        } else {
            Omss.showError(data.message);
        }
    });
}

function showDetailType3(date) {

    $("#table_detail .date_text").html("Tháng");
    var dsplit = date.split("/");
    var date_from = dsplit[1] + '-' + dsplit[0] + '-01 00:00:00';
    var date_to = dsplit[1] + '-' + dsplit[0] + '-31 59:59:59';

    datatableDetail.fnClearTable(0);
    var obj_group_by = groupBy(orderDatas, function(item) {
        return item.publisher_id;
    });
    var total = 0;
    var isShow = false;
    for (var i = 0; i < obj_group_by.length; i++) {
        total = 0;
        isShow = false;
        for (var j = 0; j < obj_group_by[i].length; j++) {
            if (obj_group_by[i][j].date_paid >= date_from && obj_group_by[i][j].date_paid <= date_to) {
                isShow = true;
                total = total + Omss.parseFloat(obj_group_by[i][j].total, 0);
            }
        }
        if (isShow) {
            var row = [date, obj_group_by[i][0].publisher_name, Omss.numberFormat(total)];
            datatableDetail.fnAddData(row, true);
        }
    }
    datatableDetail.fnDraw();
    $('#detail_modal').modal('show');
}

function showDetail(date) {
    $("#table_detail .date_text").html("Ngày");
    datatableDetail.fnClearTable(0);
    var obj_group_by = groupBy(orderDatas, function(item) {
        return item.publisher_id;
    });
    var total = 0;
    var isShow = false;
    for (var i = 0; i < obj_group_by.length; i++) {
        total = 0;
        isShow = false;
        for (var j = 0; j < obj_group_by[i].length; j++) {
            if (obj_group_by[i][j].date_group_by == date) {
                isShow = true;
                total = total + Omss.parseFloat(obj_group_by[i][j].total, 0);
            }
        }
        if (isShow) {
            var row = [date, obj_group_by[i][0].publisher_name, Omss.numberFormat(total)];
            datatableDetail.fnAddData(row, true);
        }
    }
    datatableDetail.fnDraw();
    $('#detail_modal').modal('show');
}

function groupBy(array, f) {
    var groups = {};
    array.forEach(function(e) {
        var group = JSON.stringify(f(e));
        groups[group] = groups[group] || [];
        groups[group].push(e);
    });
    return Object.keys(groups).map(function(group) {
        return groups[group];
    })
}

function getFromToDate(type, date) {
    var dateCondition = {};
    switch (type) {
        case "1":
            var dsplit = date.split("/");
            dateCondition.date_from = dsplit[2] + '-' + dsplit[1] + '-' + dsplit[0] + ' 00:00:00';
            dateCondition.date_to = dsplit[2] + '-' + dsplit[1] + '-' + dsplit[0] + ' 59:59:59';
            break;
        case "2":
            var dsplit = date.split("/");
            dateCondition.date_from = dsplit[1] + '-' + dsplit[0] + '-01 00:00:00';
            dateCondition.date_to = dsplit[1] + '-' + dsplit[0] + '-31 59:59:59';
            break;
        case "3":
            dateCondition.date_from = date + '-01-01 00:00:00';
            dateCondition.date_to = date + '-12-31 59:59:59';
            break;
    }
    return dateCondition;
}
