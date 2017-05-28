
<?php echo render('bansi/_form_insert_customer'); ?>
<?php echo render('bansi/_form_insert_order_wholesale'); ?>
<?php echo render('hinhanhhanghoa/_form_product_group_insert'); ?>
<div class="modal fade" id="delete_modal" >
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<p>Bạn chắc chắn muốn xóa:100 Cái Bulon Sắt 1 10 ?</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
					class="btn btn-primary" href="#" 
					data-dismiss="modal">Đồng ý</a>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Bán sỉ</h1>
		<hr>
	</div>
	<div class="row">
		<div class="row col-sm-12 order_date_publisher">
			<div class="form-group col-sm-6">
				<label for="input_date" class="control-label col-sm-4">Ngày bán hàng</label>
				<div class="input-group date datetimepicker col-sm-8">
					<input type="text" name="birthday" class="form-control input-sm" id="input_date" size="10" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
		</div>
		<div class="row col-sm-12 order_date_publisher">
			<div class="form-group col-sm-6">
				<label class="control-label col-sm-4">Khách hàng</label>
				<div class="input-group col-sm-8">
					<select class="form-control select_customer"></select>
					<span class="input-group-addon" data-toggle="modal"
						data-target="#insert_customer_modal"><span class="glyphicon glyphicon-plus"></span></span>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<a data-toggle="modal"
						data-target="#insert_order_modal"
				class="btn btn-primary col-md-2 col-sm-3 col-md-push-1 col-sm-push-0 col-xs-12 margin_bottom_10px"
				>
				<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;&nbsp;Thêm hàng hóa
			</a>
			<a class="btn_save_new_order btn btn-warning col-md-2 col-md-push-2 col-sm-3 col-sm-push-0 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;&nbsp;&nbsp;&nbsp;Lưu
				dữ liệu
			</a>
			<a class="btn_save_new_order2 btn btn-success col-md-2 col-md-push-3 col-sm-3 col-sm-push-0 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;&nbsp;&nbsp;Thanh toán
			</a>
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
		Tổng cộng: <span class="order_total"></span>VNĐ
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-condensed table-hover table-striped" id="table_order">
				<thead>
					<tr>
						<th>Hình ảnh</th>
						<th>Ngày bán hàng</th>
						<th>Khách hàng</th>
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