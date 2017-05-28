<div class="modal fade" id="delete_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_size_id" />
				<p>Bạn chắc chắn muốn xóa qui cách:<span class="span_diameter"></span> -
					<span class="span_length"></span> - <span class="span_product_range"></span>?</p>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_size_delete" href="#">Đồng ý</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body row">
				<input type="hidden" class="input_size_id" />
				<div class="form-group col-sm-4 col-xs-12">
					<input class="form-control focus_control span_diameter" type="text" name="diameter" maxlength="10">
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<input class="form-control span_length" type="text" name="length" maxlength="10">
				</div>
				<div class="form-group col-sm-4 col-xs-12">
					<input class="form-control span_product_range" type="text" name="product_range" maxlength="10">
				</div>
			</div>
			<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_size_update" href="#">Cập nhật</a>
				</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Danh sách quy cách</h1>
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-12 col-sm-offset-0 col-md-offset-0 col-md-12">
			<?php echo render('sizes/_form'); ?>
			<div></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>

<div class="panel panel-default" id="panel_size_list">
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
						<table class="table table-condensed table-hover table-striped dataTable no-footer" id="table_size">
							<thead>
								<tr>
									<th>#</th>
									<th>Đường kính</th>
									<th>Chiều dài</th>
									<th>Bước răng</th>
									<th class="col-xs-5 col-sm-2" >&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
			</div>
	</div>
</div>
