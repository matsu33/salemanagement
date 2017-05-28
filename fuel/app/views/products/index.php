<div class="modal fade" id="delete_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_delete_product_id" />
				<input type="hidden" class="input_delete_product_image" />
				
				<p>Bạn chắc chắn muốn xóa hàng hóa:<span class="span_product_name"></span>?</p>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_product_delete" href="#">Đồng ý</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_product_id" />
				<input type="text" class="span_product_name form-control" maxlength="100" />
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_product_update" href="#">Cập nhật</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Danh sách hàng hóa</h1>
		<hr>
	</div>
	<div class="row">
		<?php echo render('products/_form'); ?>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>

<div class="panel panel-default" id="panel_product_list">
	<div class="panel-body">
			<div class="row">
					<div class="input-group col-md-6">
						<input type="text" class="form-control global_filter" id="txtKeyword">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</span>
					</div>
			</div>
			<div class="row">
						<table class="table table-condensed table-hover table-striped dataTable no-footer" id="table_product">
							<thead>
								<tr>
									<th>Hình ảnh</th>
									<th>Tên hàng hóa</th>
									<th>Chất liệu</th>
									<th>Đường kính</th>
									<th>Chiều dài</th>
									<th>Bước răng</th>
									<th>Đơn vị</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
			</div>
	</div>
</div>
