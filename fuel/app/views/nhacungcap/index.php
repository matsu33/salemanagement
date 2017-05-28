<div class="modal fade" id="delete_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_publisher_id" />
				<p>Bạn chắc chắn muốn xóa nhà cung cấp:<span class="span_publisher_name"></span>?</p>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_publisher_delete" href="#">Đồng ý</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_publisher_id" />
				<input type="text" class="span_publisher_name form-control" maxlength="200" />
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_publisher_update" href="#">Cập nhật</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Danh sách nhà cung cấp</h1>
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-12 col-sm-offset-0 col-md-offset-0 col-md-12">
			<?php echo render('nhacungcap/_form'); ?>
			<div></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>

<div class="panel panel-default" id="panel_publisher_list">
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
						<table class="table table-condensed table-hover table-striped dataTable no-footer" id="table_publisher">
							<thead>
								<tr>
									<th>#</th>
									<th>Nhà cung cấp</th>
									<th class="col-xs-5 col-sm-2" >&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
			</div>
	</div>
</div>
