<div class="modal fade" id="insert_order_modal"> <!-- data-backdrop="static" -->
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<?php echo Form::open(array("class"=>"form-horizontal", 'id' => 'frm_order')); ?>
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		    	<h4 class="modal-title">Thêm sản phẩm vào hóa đơn nhập hàng</h4>
		    </div>
			<div class="modal-body">
					<div class="form-group col-sm-12">
						<label class="control-label col-sm-4">Hàng hóa</label> 
						<div class="col-sm-8">
							<select class="form-control select_category"></select>
						</div>
					</div>
					<div class="form-group col-sm-12" >
						<label class="control-label col-sm-4">Chất liệu</label> 
						<div class="col-sm-8">
							<select class="form-control select_material"></select>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label class="control-label col-sm-4" >Đường kính</label>
						<div class="col-sm-8">
							<input maxlength="10" type="text" name="input_diameter" class="input_diameter form-control" />
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label class="control-label col-sm-4" >Chiều dài</label>
						<div class="col-sm-8">
							<input maxlength="10" name="input_length" type="text" class="input_length form-control">
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label class="control-label col-sm-4" >Bước răng</label>
						<div class="col-sm-8">
							<input maxlength="10" name="input_product_range" type="text" class="input_product_range form-control">
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label class="control-label col-sm-4" >Số lượng</label>
						<div class="col-sm-8">
							<input maxlength="10" name="input_quanlity" type="text" class="input_quanlity form-control" value="1">
						</div>
					</div>
					<div class="form-group col-sm-12" >
						<label class="control-label col-sm-4" >Đơn vị</label>
						<div class="input-group col-sm-8">
							<select class="form-control select_unit"></select>
							
							<span class="input-group-addon edit_group_product" data-toggle="modal" data-target="#product_group_modal">
								<a>
									<span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
								</a>
							</span>
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label class="control-label col-sm-4" >Giá mua vào</label>
						<div class="col-sm-8">
							<input maxlength="10" name="input_price" type="text" class="input_price form-control" value="0">
						</div>
					</div>
					<div class="form-group col-sm-12">
						<label class="control-label col-sm-4" >Thành tiền</label>
						<div class="col-sm-8">
							<input maxlength="10" name="input_amount" type="text" class="input_amount form-control" readonly value="0">
						</div>
					</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a>
				<button type="submit" class="btn btn-primary btn_add_order" href="#">Thêm và tiếp tục</button>
			</div>
			<?php echo Form::close(); ?>
		</div>
	</div>
</div>