
<?php echo render('taobangbaogia/_form_insert_order'); ?>
<?php echo render('hinhanhhanghoa/_form_product_group_insert'); ?>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Tạo bảng báo giá</h1>
		<hr>
	</div>
	<div class="row">
		<div class="row col-sm-12 order_date_publisher">
			<div class="form-group col-sm-6">
				<label for="input_date" class="control-label col-sm-4">Ngày nhập hàng</label>
				<div class="input-group date datetimepicker col-sm-8">
					<input type="text" name="birthday" class="form-control input-sm" id="input_date" size="10" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
		</div>
		<!-- <div class="row col-sm-12 order_date_publisher">
			<div class="form-group col-sm-6">
				<label class="control-label col-sm-4">Nhà cung cấp</label> 
				<div class="col-sm-8">
					<select class="form-control select_publisher"></select>
				</div>
			</div>
		</div> -->
		<div class="col-md-12">
			<button type="submit" data-toggle="modal"
						data-target="#insert_order_modal"
				class="btn btn-primary col-md-2 col-sm-3 col-md-push-1 col-sm-push-0 col-xs-12 margin_bottom_10px"
				>
				<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;&nbsp;Thêm hàng hóa
			</button>
			<!-- <a id="btn_save_new_order"
				class="btn btn-warning col-md-2 col-md-push-2 col-sm-3 col-sm-push-0 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;&nbsp;&nbsp;&nbsp;Lưu
				dữ liệu
			</a> -->
			<button id="btn_print_order" type="submit"
				class="btn btn-success col-md-2 col-md-push-2 col-sm-3 col-sm-push-0 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;&nbsp;&nbsp;In
				danh sách
			</button>
			<!-- <a
				class="btn btn-default col-md-2 col-md-push-4 col-sm-3 col-sm-push-0 col-xs-12 margin_bottom_10px"
				 href="congno.htm"> <span
				class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;&nbsp;Xem
				công nợ
			</a> -->
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12" >
			<hr>
		</div>
	</div>
	<div class="row">
		<!-- Tổng cộng: <span class="order_total"></span>VNĐ -->
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-condensed table-hover table-striped" id="table_order">
				<thead>
					<tr>
						<th>Hình ảnh</th>
						<th>Ngày nhập hàng</th>
						<th>Nhà cung cấp</th>
						<th>Tên hàng hóa</th>
						<th>Chất liệu</th>
						<th>Đường kính</th>
						<th>Chiều dài</th>
						<th>Bước răng</th>
						<th>Số lượng</th>
						<th>Đơn vị</th>
						<th>Giá mua vào</th>
						<th>Thành tiền</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			<br>
		</div>
	</div>
</div>