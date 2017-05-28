<div class="modal fade" id="chatlieu_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Chọn chất liệu</h4>
			</div>
			<div class="chatlieu_group_popup">
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="hanghoa_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Chọn hàng hóa</h4>
			</div>
			<div class="hanghoa_group_popup">
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="loc_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label" for="diameter">Đường kính</label>
					<input type="text" class="form-control" id="product_diameter" />
				</div>
				<div class="form-group" >
					<label class="control-label" for="product_length">Chiều dài</label>
					<input type="text" class="form-control" id="product_length" />
				</div>
				<div class="form-group" >
					<label class="control-label" for="product_range">Bước răng</label>
					<input type="text" class="form-control" id="product_range" />
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
					class="btn btn-primary kiemkho_btn_loc_popup">Lọc</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="chitiet_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Chi tiết hàng hóa</h4>
			</div>
			<div class="modal-body">
				<table class="table table-condensed table-hover table-striped">
					<thead>
						<tr>
							<th>Tên hàng hóa</th>
							<th>Đường kính</th>
							<th>Chiều dài</th>
							<th>Bước răng</th>
							<th>Tồn cũ</th>
							<th>Ngày nhập hàng</th>
							<th>Số lượng nhập</th>
							<th>Tổng</th>
							<th>Ngày xuất hàng</th>
							<th>Số lượng xuất</th>
							<th>Tồn kho</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a>
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
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> 
				<a class="btn btn-primary" href="login.htm">Đồng ý</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="history_order_detail_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Lịch sử giao dịch</h4>
			</div>
			<div class="modal-body">
				<table class="table table-condensed table-hover table-striped">
					<thead>
						<tr>
							<th>Ngày tháng</th>
							<th>Tồn cũ</th>
							<th>Loại</th>
							<th>Số lượng</th>
							<th>Tồn cuối</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_product_instock_modal" onclick="bindProductInstockToModal();">Cập nhật kho</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="update_product_instock_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Nhập tồn kho hiện tại</h4>
			</div>
			<div class="modal-body">
				<div class="form-group col-sm-12">
					<label class="control-label col-sm-4" >Tồn kho hiện tại</label>
					<div class="col-sm-8">
						<input maxlength="10" name="input_current_instock" type="text" class="input_current_instock form-control" value="0">
					</div>
				</div>
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" onclick="updateProductInstock();">Cập nhật</button>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Kiểm kho</h1>
		<hr>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button type="submit" class="btn-loc btn btn-default col-md-2 col-sm-3 col-sm-push-1 col-xs-12 margin_bottom_10px">
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
						<th>Tên hàng hóa</th>
						<th>Chất liệu</th>
						<th>Đường kính</th>
						<th>Chiều dài</th>
						<th>Bước răng</th>
						<th>Đơn vị</th>
						<th>Tồn kho</th>
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