<input type="hidden" value="<?php echo $publisher_id; ?>" class="selected-publisher">
<input type="hidden" value="<?php echo urldecode($search_date); ?>" class="selected-search-date">
<input type="hidden" value="<?php echo urldecode($search_day); ?>" class="selected-search-day">
<input type="hidden" value="<?php echo urldecode($search_month); ?>" class="selected-search-month">
<input type="hidden" value="<?php echo $search_year; ?>" class="selected-search-year">
<input type="hidden" value="<?php echo $search_type; ?>" class="selected-search-type">

<div class="modal fade" id="choncachxem_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Chọn cách xem</h4>
			</div>
			<div class="modal-body">
				<div class="chatlieu_group_popup col-xs-12" >
					<a class="btn btn-primary col-xs-12" data-toggle="modal"
						data-target="#chonngay_modal" >Xem theo ngày</a> <a
						class="btn btn-primary col-xs-12" data-toggle="modal"
						data-target="#chonthang_modal">Xem theo tháng</a> <a
						class="btn btn-primary col-xs-12" data-toggle="modal"
						data-target="#chonnam_modal">Xem theo năm</a>
				</div>
			</div>
			<div class="modal-footer clear_both"></div>
		</div>
	</div>
</div>
<div class="modal fade" id="chonngay_modal" >
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Chọn ngày</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group date doanh_thu_ngay_time col-sm-8">
						<input type="text" name="doanh_thu_ngay" class="form-control input-sm input_date" size="10" readonly>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary congno_xemngay_btn"
					data-dismiss="modal" >Xem</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="chonthang_modal" >
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Chọn tháng</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group date doanh_thu_thang_time col-sm-8">
						<input type="text" name="doanh_thu_thang" class="form-control input-sm input_date" size="10" readonly>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary congno_xemthang_btn"
					data-dismiss="modal">Xem</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="chonnam_modal" style="">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Chọn năm</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group date doanh_thu_nam_time col-sm-8">
						<input type="text" name="doanh_thu_nam" class="form-control input-sm input_date" size="10" readonly>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary congno_xemnam_btn"
					data-dismiss="modal" >Xem</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="danhsachhoadon_nam_modal" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Danh sách hóa đơn</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" class="danhsachhoadon_nam_modal_create_month">
				<table class="table table-condensed table-hover table-striped"
					style="">
					<thead>
						<tr>
							<th>#</th>
							<th >Ngày nhập hàng</th>
							<th >Số hóa đơn đã thanh toán</th>
							<th >Số tiền đã thanh toán</th>
							<th >Số hóa đơn chưa thanh toán</th>
							<th >Công nợ</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					
					</tbody>
				</table>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" onclick="paidOrderYearInPopupDetail();">Thanh toán</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="danhsachhoadon_ngay_modal" >
	<div class="modal-dialog modal-lg">
		<div class="modal-content" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Danh sách hóa đơn</h4>
			</div>
			<div class="modal-body">
				<table class="table table-condensed table-hover table-striped"
					style="">
					<thead>
						<tr>
							<th>#</th>
							<th>Ngày nhập hàng</th>
							<th >Nhà cung cấp</th>
							<th >Thành tiền</th>
							<th >Ngày thanh toán</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" onclick="paidOrderDateInPopupDetail();" class="paidOrderDateInPopupDetail">Thanh
					toán</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="nhacungcap_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Chọn nhà cung cấp</h4>
			</div>
			<div class="nhacungcap_group_popup">
				<!-- <a class="btn btn-primary" data-dismiss="modal" >Tân Cơ</a> 
				<a class="btn btn-primary" data-dismiss="modal">Thành Hòa</a>
				<a class="btn btn-primary" data-dismiss="modal">Tân Cơ 1</a> <a
					class="btn btn-primary" data-dismiss="modal">Tân Cơ 2</a> <a
					class="btn btn-primary" data-dismiss="modal">Trung Nguyên</a> -->
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="logout_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<p>Bạn có chắc chắn muốn thoát?</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
					class="btn btn-primary" href="login.htm">Đồng ý</a>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Công nợ nhà cung cấp</h1>
		<hr>
	</div>
	<div class="row">
		<div class="form-group col-sm-3">
			<label class="control-label col-xs-12">Nhà cung cấp</label>
			<div class="input-group">
				<select class="form-control select_publisher js-select-publisher-indebt"></select>
				<span class="input-group-addon">
					<input type="checkbox" class="js-checkbox-select-search-publisher">
				</span>
			</div>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label col-xs-12">Chọn ngày</label>
			<div class="input-group">
				<div class="input-group date js-date-control">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
					<input type="text" class="form-control js-input-date-1 js-input-date" readonly>
				</div>
				<span class="input-group-addon">
					<input type="radio" name="js-select-search-type" value="1" class="js-radio-date-1 js-checkbox-select-search-day" checked>
				</span>
			</div>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label col-xs-12">Chọn tháng</label>
			<div class="input-group">
				<div class="input-group date js-month-control">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
					<input type="text" class="form-control js-input-date-2 js-input-month" readonly>
				</div>
				<span class="input-group-addon">
					<input type="radio" name="js-select-search-type" value="2" class="js-radio-date-2 js-checkbox-select-search-month">
				</span>
			</div>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label col-xs-12">Chọn năm</label>
			<div class="input-group">
				<div class="input-group date js-year-control">
					<span class="input-group-addon">
						<span class="glyphicon glyphicon-calendar"></span>
					</span>
					<input type="text" class="form-control js-input-date-3 js-input-year" readonly>
				</div>
				<span class="input-group-addon">
					<input type="radio" name="js-select-search-type" value="3" class="js-radio-date-3 js-checkbox-select-search-year">
				</span>
			</div>
		</div>

		<div class="col-md-12">
			<button type="submit" class="btn btn-success col-md-push-1 col-sm-2 col-xs-12 margin_bottom_10px js-start-search">
				<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;&nbsp;Lọc
			</button>
			<button type="submit" class="btn btn-default col-md-push-2 col-sm-2 col-xs-12 margin_bottom_10px js-reset-search">
				<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;&nbsp;Xóa điều kiện lọc
			</button>
			<button type="submit" onclick="clickThanhToanCongNo();" 
				class="btn btn-primary col-md-push-3 col-sm-2 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-saved"></span>&nbsp;&nbsp;&nbsp;&nbsp;Thanh toán
			</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-condensed table-hover table-striped"
				style="">
				<thead>
					<tr>
						<th>#</th>
						<th>Ngày nhập hàng</th>
						<th >Nhà cung cấp</th>
						<th >Số hóa đơn đã thanh toán</th>
						<th >Số tiền đã thanh toán</th>
						<th >Số hóa đơn chưa thanh toán</th>
						<th >Công nợ</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				<?php if(count($list_debt) > 0 ){ ?>
					<?php
					$count = 1;
					foreach($list_debt as $item) :
						$link = '';
						if($search_type == '1'){
							//day
							$inputDate = $item['day'].'/'.$item['month'].'/'.$item['year'];
							$link = '<a class="btn btn-inverse btn-primary" href="#">Xem chi tiết</a>';
						}elseif($search_type == '2'){
							//month
							$inputDate = $item['day'].'/'.$item['month'].'/'.$item['year'];
							$link = '<a class="btn btn-inverse btn-primary" href="#">Xem chi tiết</a>';
						}elseif($search_type == '3'){
							//year
							$inputDate = $item['month'].'/'.$item['year'];
							$link = '<a class="btn btn-inverse btn-primary" href="#">Xem chi tiết</a>';
						}
						$publisher_id = $item['publisher_id'];
						$publisher_name = $item['publisher_name'];
						$paidCount = $item['paidCount'];
						$debtCount = $item['debtCount'];
						$paidTotal = $item['paidTotal'];
						$debtTotal = $item['debtTotal'];
						$listDebtOrderId = $item['listDebtOrderId'];


						$checkbox = '<input type="checkbox" value="'.$publisher_id.'">';

						$tr_class = "odd";
						if($count%2 == 0){
							$tr_class = "even";
						}
						$count++;
						?>
						<tr class="<?php echo $tr_class; ?>"
							data-inputdate="<?php echo $inputDate; ?>"
							data-publisherid="<?php echo $publisher_id; ?>"
							data-listdebtorderid="<?php echo $listDebtOrderId; ?>"
						>
							<td class=" "><?php echo $checkbox; ?></td>
							<td class=" "><?php echo $inputDate; ?></td>
							<td class=" "><?php echo $publisher_name; ?></td>
							<td class=" "><?php echo $paidCount; ?></td>
							<td class=" "><?php echo $paidTotal; ?></td>
							<td class=" "><?php echo $debtCount; ?></td>
							<td class=" "><?php echo $debtTotal; ?></td>
							<td class=" "><?php echo $link; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php } ?>
				<!-- <tr>
						<td ><input type="checkbox"></td>
						<td >2014/11/04</td>
						<td>3</td>
						<td>2.000.000</td>
						<td>3</td>
						<td>2.000.000</td>
						<td ><a class="btn btn-inverse btn-primary"
							data-toggle="modal" data-target="#danhsachhoadon_thang_modal"
							><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanh
								toán</a></td>
					</tr>
					<tr>
						<td ><input type="checkbox"></td>
						<td >2014/11/03</td>
						<td>3</td>
						<td>2.000.000</td>
						<td>3</td>
						<td>2.000.000</td>
						<td ><a class="btn btn-inverse btn-primary"
							data-toggle="modal" data-target="#danhsachhoadon_thang_modal"
							><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanh
								toán</a></td>
					</tr>
					<tr>
						<td ><input type="checkbox"></td>
						<td >2014/11/02</td>
						<td>3</td>
						<td>2.000.000</td>
						<td>3</td>
						<td>2.000.000</td>
						<td ><a class="btn btn-inverse btn-primary"
							data-toggle="modal" data-target="#danhsachhoadon_thang_modal"
							><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanh
								toán</a></td>
					</tr>
					<tr>
						<td ><input type="checkbox"></td>
						<td >2014/11/01</td>
						<td >3</td>
						<td>12.000.000</td>
						<td >3</td>
						<td>2.000.000</td>
						<td ><a class="btn btn-inverse btn-primary"
							data-toggle="modal" data-target="#danhsachhoadon_thang_modal"
							><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanh
								toán</a></td>
					</tr> -->
				</tbody>
			</table>
			
			<br>
		</div>
		<div class="pagination"><?php echo html_entity_decode($pagination); ?></div>
	</div>
</div>
<?php echo render('customerdebt/_form_order_detail'); ?>