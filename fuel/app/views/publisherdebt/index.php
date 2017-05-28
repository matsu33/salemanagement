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
		<div class="col-md-12">
			<button type="submit"
				class="btn btn-default col-sm-3 col-xs-12 margin_bottom_10px"
				data-toggle="modal" data-target="#nhacungcap_modal">
				<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;&nbsp;Chọn
				NCC
			</button>
			<button type="submit" onclick="clickThanhToanCongNo();" 
				class="btn btn-primary col-sm-3 col-sm-offset-1 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-saved"></span>&nbsp;&nbsp;&nbsp;&nbsp;Thanh
				toán
			</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 congno_ngay">
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
					
				</tbody>
			</table>
			
			<br>
		</div>
		<div class="col-md-12 congno_thang">
			<table class="table table-condensed table-hover table-striped"
				style="">
				<thead>
					<tr>
						<th>#</th>
						<th>Ngày nhập hàng</th>
						<th >Số hóa đơn đã thanh toán</th>
						<th >Số tiền đã thanh toán</th>
						<th >Số hóa đơn chưa thanh toán</th>
						<th >Công nợ</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
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
		<div class="col-md-12 congno_nam">
			<table class="table table-condensed table-hover table-striped"
				style="">
				<thead>
					<tr>
						<th>#</th>
						<th >Tháng nhập hàng</th>
						<th >Số hóa đơn đã thanh toán</th>
						<th >Số tiền đã thanh toán</th>
						<th >Số hóa đơn chưa thanh toán</th>
						<th >Công nợ</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<!-- <tr>
						<td ><input type="checkbox"></td>
						<td >2014/11</td>
						<td>3</td>
						<td>2.000.000</td>
						<td>3</td>
						<td>2.000.000</td>
						<td ><a class="btn btn-inverse btn-primary"
							data-toggle="modal" data-target="#danhsachhoadon_nam_modal"><span
								class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanh toán</a>
						</td>
					</tr>
					<tr>
						<td ><input type="checkbox"></td>
						<td >2014/10</td>
						<td >3</td>
						<td>12.000.000</td>
						<td >3</td>
						<td>2.000.000</td>
						<td ><a class="btn btn-inverse btn-primary"
							data-toggle="modal" data-target="#danhsachhoadon_nam_modal"><span
								class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Thanh toán</a>
						</td>
					</tr> -->
				</tbody>
			</table>
			
			<br>
		</div>
	</div>
</div>
<?php echo render('customerdebt/_form_order_detail'); ?>