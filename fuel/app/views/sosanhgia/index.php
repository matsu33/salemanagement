<div class="modal fade" id="nhacungcap_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Chọn nhà cung cấp</h4>
			</div>
			<div class="modal-body">
				<table class="table table-condensed table-hover table-striped" id="table_publisher">
					<thead>
						<tr>
							<th>Nhà cung cấp</th>
							<th>Giá mua</th>
							<th>Trạng thái</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="nhapgiasile_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content" >
			<?php echo Form::open(array("class"=>"", 'id' => 'frm_input_price_rate')); ?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">Nhập % giá sỉ và lẻ</h4>
				</div>
				<div class="modal-body">
						<div class="form-group col-sm-12 row">
							<label class="control-label" for="wholesales_rate">% giá sỉ 1</label> 
							<input type="text" name="wholesales_rate" id="wholesales_rate" class="wholesales_rate form-control col-md-6" maxlength="10" value="0">
						</div>
						<div class="form-group col-sm-12 row">
							<label class="control-label" for="wholesales_rate">% giá sỉ 2</label> 
							<input type="text" name="wholesales_rate" id="wholesales_rate2" class="wholesales_rate form-control col-md-6" maxlength="10" value="0">
						</div>
						<div class="form-group col-sm-12 row">
							<label class="control-label" for="wholesales_rate">% giá sỉ 3</label> 
							<input type="text" name="wholesales_rate" id="wholesales_rate3" class="wholesales_rate form-control col-md-6" maxlength="10" value="0">
						</div>
						<div class="form-group col-sm-12 row" >
							<label class="control-label" for="retail_rate">% giá lẻ</label> 
							<input type="text" name="retail_rate" id="retail_rate" class="retail_rate form-control col-md-6" maxlength="10" value="0">
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
					<button type="submit" class="btn btn-primary" id="btn_confirm_input_price_rate">Lưu</button>
				</div>
			<?php echo Form::close(); ?>
		</div>
	</div>
</div>
<div class="modal fade" id="logout_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<p>Bạn có chắc chắn muốn thoát?</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> 
				<a class="btn btn-primary" href="login.htm">Đồng ý</a>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">So sánh giá nhà cung cấp</h1>
		<hr>
	</div>
	<?php echo render('sosanhgia/_form'); ?>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-condensed table-hover table-striped" id="table_so_sanh_gia">
				<thead>
					<tr>
						<th>Hình ảnh</th>
						<th>Tên hàng hóa</th>
						<th>Chất liệu</th>
						<th>Đường kính</th>
						<th>Chiều dài</th>
						<th>Bước răng</th>
						<th>Đơn vị</th>
						<th>Giá sỉ 1</th>
						<th>Giá sỉ 2</th>
						<th>Giá sỉ 3</th>
						<th>Giá bán lẻ</th>
						<th></th>
					</tr>
				</thead>
				<tbody>

				</tbody>
			</table>
			<br>
		</div>
	</div>
</div>