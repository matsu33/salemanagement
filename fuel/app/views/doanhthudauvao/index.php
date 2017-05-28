<div class="modal fade" id="choncachxem_modal" >
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
						<a class="btn btn-primary col-xs-12" data-toggle="modal" data-target="#chonchatlieu_modal">Xem theo chất liệu</a>
				</div>
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="chonchatlieu_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Chọn chất liệu</h4>
			</div>
			<div class="chatlieu_group_popup">
				<input list="material_list" id="material_list_input">
				<datalist id="material_list">
				  <option value="Internet Explorer">
				  <option value="Firefox">
				  <option value="Chrome">
				  <option value="Opera">
				  <option value="Safari">
				</datalist>
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="chonthoigian_modal" >
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Chọn thời gian</h4>
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
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="chonngay_modal" >
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="doanh_thu_ngay">Chọn ngày</h4>
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
				<button type="button" class="btn btn-primary doanhthu_xemngay_btn">Xem</button>
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
				<button type="button" class="btn btn-primary doanhthu_xemthang_btn">Xem</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="chonnam_modal">
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
				<button type="button" class="btn btn-primary doanhthu_xemnam_btn">Xem</button>
			</div>
		</div>
	</div>
</div>
<!-- <div class="modal fade" id="chatlieu_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Chọn chất liệu</h4>
			</div>
			<div class="chatlieu_group_popup">
				<a class="btn btn-primary col-xs-2" data-dismiss="modal">Sắt</a> <a
					class="btn btn-primary col-xs-2" data-dismiss="modal">Thép</a> <a
					class="btn btn-primary col-xs-2" data-dismiss="modal">Nhôm</a> <a
					class="btn btn-primary col-xs-2" data-dismiss="modal">Inox</a> <a
					class="btn btn-primary col-xs-2" data-dismiss="modal">Thao</a> <a
					class="btn btn-primary col-xs-2" data-dismiss="modal">Bạc</a>
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div> -->
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
		<h1 class="text-center">Doanh thu đầu vào</h1>
		<hr>
	</div>
	<div class="row">
		<div
			class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1 col-md-offset-0 col-md-12">
			<div></div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<button type="submit"
				class="doanhthu_loctheongay btn btn-default col-md-2 col-md-push-5 col-sm-3 col-sm-push-3 col-xs-12 margin_bottom_10px"
				>
				<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;&nbsp;Lọc
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
			<table class="table table-condensed table-hover table-striped" id="table_loc">
				<thead>
					<tr>
						<th class="date_text">Ngày</th>
						<th>Khách hàng sỉ</th>
						<th>Khách hàng lẻ</th>
						<th>Tổng tiền</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			<br>
		</div>
	</div>
	<div class="modal fade" id="detail_modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Chi tiết</h4>
				</div>
				<div class="modal-body">
					<table class="table table-condensed table-hover table-striped" id="table_detail">
						<thead>
							<tr>
								<th class="date_text">Ngày</th>
								<th>Tên khách hàng</th>
								<th>Doanh thu</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="modal-footer clear_both">
					<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
				</div>
			</div>
		</div>
	</div>
</div>