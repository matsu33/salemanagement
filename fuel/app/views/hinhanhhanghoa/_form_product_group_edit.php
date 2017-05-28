<div class="modal fade" id="product_group_modal_edit"><!-- data-backdrop="static" -->
	<div class="modal-lg container">
		<div class="modal-content">
			<div class="modal-body">
				<?php echo Form::open(array("class"=>"", 'id' => 'frm_product_group_edit')); ?>
					<div class="col-sm-3 form-group">
						<!-- <label class="control-label col-sm-12">Số lượng</label> -->
						<input maxlength="10" type="text" name="input_group_quanlity" class="input_group_quanlity col-sm-4 form-control col-md-6 col-sm-12" placeholder="Số lượng" value="1"/></div>
					<div class="col-sm-3 form-group">
						<!-- <label class="control-label col-sm-12">Đơn vị</label> -->
						<select class="col-sm-4 form-control select_unit"></select></div>
					<div class="col-sm-3 form-group">
						<!-- <label class="control-label col-sm-12">Hàng hóa</label> -->
						<select class="form-control select_category"></select></div>
					<div class="col-sm-3 form-group">
						<!-- <label class="control-label col-sm-12">Chất liệu</label> -->
						<select class="form-control select_material col-sm-6"></select></div>
					<div class="col-sm-4 form-group">
						<!-- <label class="control-label col-sm-12">Đường kính</label> -->
						<input maxlength="10" type="text" name="input_diameter" class="input_diameter col-sm-4 form-control col-md-6 col-sm-12" placeholder="Đường kính"/></div>
					<div class="col-sm-4 form-group">
						<!-- <label class="control-label col-sm-12">Chiều dài</label> -->
						<input maxlength="10" name="input_length" type="text" class="col-sm-4 input_length form-control col-md-6 col-sm-12" placeholder="Chiều dài"></div>
					<div class="col-sm-4 form-group">
						<!-- <label class="control-label col-sm-12">Bước răng</label> -->
						<input maxlength="10" name="input_product_range" type="text" class="col-sm-4 input_product_range form-control col-md-6 col-sm-12" placeholder="Bước răng"></div>
				
					<button type="submit" class="btn btn-success" id="btn_product_group_edit_add">
					<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;&nbsp;Thêm hàng hóa</button>
					<?php echo Form::close(); ?>
					<hr>
					<table class="table table-condensed table-hover table-striped dataTable no-footer" id="table_product_group_edit">
						<thead>
							<tr>
								<th>Hình ảnh</th>
								<th>Hàng hóa</th>
								<th>Chất liệu</th>
								<th>Đường kính</th>
								<th>Chiều dài</th>
								<th>Bước răng</th>
								<th>Đơn vị</th>
								<th>Số lượng</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal" onclick="clearGroupProduct()">Hủy</a> 
				<a class="btn btn-primary btn_product_group_add_confirm" href="#" data-dismiss="modal">Đồng ý</a>
			</div>
		</div>
	</div>
</div>
