<?php echo Form::open(array("class"=>"", 'id' => 'frm_product_price_add')); ?>
<div class="row">
	
<div class="col-sm-12">
	
		<div class="form-group col-sm-6">
			<label class="col-xs-12 control-label">Nhà cung cấp</label> 
			<select class="form-control select_publisher"></select>
		</div>
		<div class="form-group col-sm-6">
			<label class="control-label col-xs-12">Hàng
				hóa</label> <select class="form-control select_category"></select>
		</div>
		<div class="form-group col-sm-6" >
			<label class="control-label col-xs-12">Chất
				liệu</label> <select class="form-control select_material"></select>
		</div>
		<div class="form-group col-md-2 col-sm-2">
			<label class="control-label" >Đường kính</label>
			<input maxlength="10" type="text" name="input_diameter" class="input_diameter form-control col-md-6 col-sm-12" />
		</div>
		<div class="form-group col-md-2 col-sm-2">
			<label class="control-label" >Chiều dài</label>
			<input maxlength="10" name="input_length" type="text" class="input_length form-control col-md-6 col-sm-12">
		</div>
		<div class="form-group col-md-2 col-sm-2">
			<label class="control-label" >Bước răng</label>
			<input maxlength="10" name="input_product_range" type="text" class="input_product_range form-control col-md-6 col-sm-12">
		</div>
		<div class="form-group col-md-6 col-sm-6" >
			<label class="control-label col-sm-12" >Đơn vị</label>
			<div class="input-group">
				<select class="form-control select_unit"></select>
				
				<span class="input-group-addon edit_group_product">
					<a>
						<span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
					</a>
				</span>
			</div>
		</div>
		<div class="form-group col-md-6 col-sm-6">
			<label class="control-label col-xs-12" >Giá
				đầu vào</label> 
			<input maxlength="10" name="input_product_price" type="text" class="input_product_price form-control col-md-6 col-sm-12">
		</div>
	
	<div></div>
</div>
</div>
	<br>
	<div class="row">
		<div class="col-md-12">
			<button type="submit"
				class="btn_price_add btn btn-primary col-md-2 col-sm-3 col-sm-push-1 col-xs-12 margin_bottom_10px"
				>
				<span class="glyphicon glyphicon-saved"></span>&nbsp;&nbsp;&nbsp;&nbsp;Lưu
				dữ liệu
			</button>
			<!-- <button type="submit"
				class="btn btn-success col-md-2 col-md-push-3 col-sm-3 col-sm-push-2 col-xs-12 margin_bottom_10px"
				>
				<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;&nbsp;&nbsp;In
				danh sách
			</button>
			 -->
			 <button type="submit"
				class="btn btn-default col-md-2 col-md-push-5 col-sm-3 col-sm-push-3 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;&nbsp;Tìm
				kiếm
			</button>
		</div>
	</div>
<?php echo Form::close(); ?>