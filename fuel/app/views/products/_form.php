<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Category id', 'category_id', array('class'=>'control-label')); ?>

				<?php echo Form::input('category_id', Input::post('category_id', isset($product) ? $product->category_id : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Category id')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Name', 'name', array('class'=>'control-label')); ?>

				<?php echo Form::input('name', Input::post('name', isset($product) ? $product->name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Name')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>

<div class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1 col-md-offset-0 col-md-9">
					<form>
						<div class="form-group col-sm-6">
							<label class="control-label col-xs-12" for="exampleInputEmail1">Hàng hóa</label>
							<select class="form-control select_category">
								<!-- <option>Bulon</option>
								<option>Tán</option> -->
							</select>
						</div>
						<div class="form-group col-sm-6" draggable="true">
							<label class="control-label col-xs-12" for="exampleInputEmail1">Chất liệu</label>
							<select class="form-control select_material">
								<!-- <option>Sắt</option>
								<option>Thép</option> -->
							</select>
						</div>
						<div class="form-group col-md-2 col-sm-2" draggable="true">
							<label class="control-label" for="exampleInputEmail1">Đường kính</label>
							<input type="text" name="diameter" class="input_diameter form-control col-md-6 col-xs-12" />
							<!-- <select class="form-control"> -->
								<!-- <option>5</option>
								<option>10</option> -->
							<!-- </select> -->
						</div>
						<div class="form-group col-md-2 col-sm-2" draggable="true">
							<label class="control-label" for="exampleInputEmail1">Chiều dài</label>
							<input name="input_length" type="text" class="form-control col-md-6 col-xs-12">
						</div>
						<div class="form-group col-md-2 col-sm-2" draggable="true">
							<label class="control-label" for="exampleInputEmail1">Bước răng</label>
							<input name="input_product_range" type="text" class="form-control col-md-6 col-xs-12">
						</div>
						<div class="form-group col-md-6 col-sm-6" draggable="true">
							<label class="control-label col-xs-12" for="exampleInputEmail1">Đơn vị</label>
							<select class="form-control select_unit">
								<!-- <option>Cái</option>
								<option>Con</option>
								<option>Bộ</option> -->
							</select>
						</div>
					</form>
					<div></div>
				</div>
				<div class="col-md-3">
					<br>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 col-sm-4 col-sm-offset-4 col-xs-10 col-xs-offset-1">
							<img src="img\02.jpg" class="img-responsive img-rounded" id="imgProductPreview">
							<div class="row">
								<br>
								<span class="btn btn-block btn-default btn-file">Browse
									<input type="file" accept="image/*" id="inputImgProduct">
								</span>
							</div>
						</div>
					</div>
				</div>