<?php echo Form::open(array("class"=>"", 'id' => 'frm_size_add')); ?>
	<div class="form-group col-sm-3 col-xs-12">
		<label class="col-xs-12 control-label" for="exampleInputEmail1">Đường kính</label>
		<input class="form-control focus_control" type="text" name="diameter" maxlength="10">
	</div>
	<div class="form-group col-sm-3 col-xs-12">
		<label class="col-xs-12 control-label" for="exampleInputEmail1">Chiều dài</label>
		<input class="form-control" type="text" name="length" maxlength="10">
	</div>
	<div class="form-group col-sm-3 col-xs-12">
		<label class="col-xs-12 control-label" for="exampleInputEmail1">Bước răng</label>
		<input class="form-control" type="text" name="product_range" maxlength="10">
	</div>
	<div class="form-group col-sm-3 col-xs-12">
		<br>
		<button type="submit" class="btn btn-primary margin_top_4px" id="btn_size_add">
		<span class="glyphicon glyphicon-saved"></span>&nbsp;&nbsp;&nbsp;&nbsp;Lưu dữ liệu</button>
	</div>
<?php echo Form::close(); ?>