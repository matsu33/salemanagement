<div class="modal fade" id="product_edit_modal">
	<div class="modal-lg container">
		<div class="modal-content">
			<div class="modal-body">
				<?php echo Form::open(array("class"=>"", 'id' => 'frm_product_edit')); ?>
					<input type="hidden" class="product_id_edit"/>
					<div class="row" >
						<div class="row col-sm-12 col-md-9">
								<div class="form-group col-sm-6">
									<label class="control-label col-sm-12" >Hàng hóa</label>
									<select class="form-control select_category">
									</select>
								</div>
								<div class="form-group col-sm-6" >
									<label class="control-label col-sm-12" >Chất liệu</label>
									<select class="form-control select_material">
									</select>
								</div>
								<div class="form-group col-md-2 col-sm-2" >
									<label class="control-label" >Đường kính</label>
									<input maxlength="10" type="text" name="input_diameter" class="input_diameter form-control col-md-6 col-sm-12" />
								</div>
								<div class="form-group col-md-2 col-sm-2" >
									<label class="control-label" >Chiều dài</label>
									<input maxlength="10" name="input_length" type="text" class="input_length form-control col-md-6 col-sm-12">
								</div>
								<div class="form-group col-md-2 col-sm-2" >
									<label class="control-label" >Bước răng</label>
									<input maxlength="10" name="input_product_range" type="text" class="input_product_range form-control col-md-6 col-sm-12">
								</div>
								<div class="form-group col-md-3 col-sm-3 col-xs-9" >
									<label class="control-label col-sm-12" >Đơn vị</label>
									<div class="input-group">
										<select class="form-control select_unit">
										</select>
										<span class="input-group-addon edit_group_product">
											<a>
												<span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
											</a>
										</span>
									</div>
								</div>
							<div></div>
						</div>
						<div class="col-md-3">
							<br>
							<div class="row">
								<div class="col-md-8 col-sm-6 col-sm-offset-3">
									<img src="assets\img\02.jpg" class="img-responsive img-rounded imgProductPreview">
									<div class="row">
										<br>
										<span class="btn btn-block btn-default btn-file">Chọn hình
											<input type="file" accept="image/*" class="inputImgProduct">
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php echo Form::close(); ?>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> 
				<a class="btn btn-primary btn_product_group_edit_confirm" href="#" data-dismiss="modal">Đồng ý</a>
			</div>
		</div>
	</div>
</div>
