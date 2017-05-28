<?php echo Form::open(array("class"=>"", 'id' => 'frm_publisher_add')); ?>
	<div class="form-group col-sm-6 col-xs-12" >
		<label class="control-label" for="exampleInputEmail1">Nhà cung cấp</label>
		<input class="form-control focus_control col-md-6"
		type="text" maxlength="200" name="publisher_name">
	</div>
	<div class="form-group col-sm-6 col-xs-12" >
		<br>
		<button type="submit" class="btn btn-primary col-md-4 col-sm-6 col-sm-push-1 col-xs-12 margin_top_4px" id="btn_publisher_add">
		<span class="glyphicon glyphicon-saved"></span>&nbsp;&nbsp;&nbsp;&nbsp;Lưu dữ liệu</button>
	</div>
<?php echo Form::close(); ?>