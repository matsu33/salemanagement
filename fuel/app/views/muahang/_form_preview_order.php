<div class="modal fade" id="preview_order_modal"> <!-- data-backdrop="static" -->
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		    	<h4 class="modal-title">Danh sách hàng hóa</h4>
		    </div>
			<div class="modal-body">
				<table>
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
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a>
				<button type="submit" data-toggle="modal" data-target="#preview_order_paid_modal" type="submit" class="btn btn-primary btn_add_order" href="#">Lưu dữ liệu</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="preview_order_paid_modal"> <!-- data-backdrop="static" -->
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		    	<h4 class="modal-title">Đã thanh toán hay chưa?</h4>
		    </div>
			<div class="modal-body">
				<div class="form-group col-sm-12">
					<input type="radio" name="cbxpaid" id="cbx_paid" value="1"><label for="cbx_paid">Rồi</label>
				</div>
				<div class="form-group col-sm-12">
					<input type="radio" name="cbxpaid" id="cbx_notpaid" value="0" checked="checked"><label for="cbx_notpaid">Chưa</label>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a>
				<button id="btn_save_new_order" type="submit" class="btn btn-primary btn_add_order" href="#">Lưu dữ liệu</button>
			</div>
		</div>
	</div>
</div>