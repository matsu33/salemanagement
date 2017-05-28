<?php echo Form::open(array("class"=>"", 'id' => 'frm_so_sanh_gia')); ?>
	<div class="row">
		<div class="col-sm-12">
			<form>
				<div class="form-group col-sm-3">
					<label class="control-label col-xs-12">Hàng
						hóa</label> <select class="form-control select_category"></select>
				</div>
				<div class="form-group col-sm-3" >
					<label class="control-label col-xs-12">Chất
						liệu</label> <select class="form-control select_material"></select>
				</div>
				<div class="form-group col-md-2 col-sm-2">
					<label class="control-label" >Đường kính</label>
					<input type="text" name="input_diameter" class="input_diameter form-control col-md-6 col-sm-12" />
				</div>
				<div class="form-group col-md-2 col-sm-2">
					<label class="control-label" >Chiều dài</label>
					<input name="input_length" type="text" class="input_length form-control col-md-6 col-sm-12">
				</div>
				<div class="form-group col-md-2 col-sm-2">
					<label class="control-label" >Bước răng</label>
					<input name="input_product_range" type="text" class="input_product_range form-control col-md-6 col-sm-12">
				</div>
			</form>
			<div></div>
		</div>
	</div>
		
	<br>
	<div class="row">
		<div class="col-sm-12">
			<button type="submit"
				class="btn_search_price btn btn-default col-md-2 col-md-push-3 col-sm-3 col-sm-push-2 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;&nbsp;Tìm
				kiếm
			</button>
			<!-- <button type="submit" 
				class="btn_print_list_price btn btn-success col-md-2 col-md-push-5 col-sm-3 col-sm-push-3 col-xs-12 margin_bottom_10px"
				>
				<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;&nbsp;&nbsp;In
				danh sách
			</button> -->
		</div>
	</div>
<?php echo Form::close(); ?>