<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="vi">
<head>
<meta charset="utf-8">
<title><?php echo $title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="Nguyen Van Tung" content="">
	<?php echo Asset::render('banhang_css'); ?>
    <?php echo Asset::render('banhang_script'); ?>
    
    <script type="text/javascript">
        var lang = <?php echo isset($lang)?json_encode($lang):'null'; ?>;
        var baseUrl = "<?php echo Uri::base(false); ?>";
        var imageFolderUrl = baseUrl + "assets/img/";
        var noImageUrl = imageFolderUrl + "02.jpg";
    </script>
    
    </head>
<body>
	<?php echo render('bansi/_form_insert_customer'); ?>
	<?php echo render('hinhanhhanghoa/_form_product_group_insert'); ?>
	<div class="modal fade" id="preview_order_modal"> <!-- data-backdrop="static" -->
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
			    	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			    	<h4 class="modal-title">Danh sách hàng hóa</h4>
			    </div>
				<div class="modal-body">
					<table>
						<thead>
							<tr>
								<th>Hình ảnh</th>
								<th>Ngày bán hàng</th>
								<th>Khách hàng</th>
								<th>Tên hàng hóa</th>
								<th>Chất liệu</th>
								<th>Đường kính</th>
								<th>Chiều dài</th>
								<th>Bước răng</th>
								<th>Số lượng</th>
								<th>Đơn vị</th>
								<th>Giá mua vào</th>
								<th>Thành tiền</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a>
					<a onclick="openPreviewModal();" class="btn btn-primary" href="#">Lưu dữ liệu</a>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="preview_order_paid_modal"> <!-- data-backdrop="static" -->
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
			    	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			    	<h4 class="modal-title">Đã thanh toán hay chưa?</h4>
			    </div>
				<div class="modal-body">
					<div class="form-group col-sm-12">
						<input type="radio" name="cbxpaid" id="cbx_paid" value="1"><label for="cbx_paid">Rồi</label>
					</div>
					<div class="form-group col-sm-12">
						<input type="radio" name="cbxpaid" id="cbx_notpaid" value="0" checked="checked"><label for="cbx_notpaid">Chưa</label>
					</div>
				</div>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a>
					<button id="btn_save_new_order" type="submit" class="btn btn-primary" href="#">Lưu dữ liệu</button>
				</div>
			</div>
		</div>
	</div>
	<!-- navbar -->
	<div class="navbar navbar-default navbar-fixed-top navbar-inverse">
		<div class="container text-center">
			<div class="navbar-header"> <a
					type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-collapse"></a> <span class="sr-only">Toggle
					navigation</span>
			</div>
			<div class="collapse navbar-collapse navbar-ex1-collapse max_height_100_percent">
				<ul class="nav navbar-nav navbar-right">
					<!--<li class="active"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"> <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;user&nbsp;&nbsp;<span
							class="caret"></span>
					</a>
						<ul class="dropdown-menu list-unstyled text-left" role="menu">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"> </a>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('luu_du_lieu');?>">Lưu dữ liệu</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('phuc_hoi_du_lieu');?>">Phục hồi dữ liệu</a></li>
						</ul></li> -->
					<li class="active"><a href="#" data-toggle="modal"
						data-target="#logout_modal"> <span
							class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Đăng
							xuất&nbsp;&nbsp;
					</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!-- .navbar -->
	<!-- logout_modal -->
	<div class="modal fade" id="logout_modal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-body">
					<p>Bạn có chắc chắn muốn thoát?</p>
				</div>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary" href="#" id="btn_logout">Đồng ý</a>
				</div>
			</div>
		</div>
	</div>
	<!-- .logout_modal -->
	<div class="container" id="frm_order">
		<!-- row -->
		<div class="row col-md-12 header_top">
			<div class="form-group col-sm-3 col-md-3 order_date_publisher">
				<label for="input_date" class="control-label">Ngày bán hàng</label>
				<div class="input-group date datetimepicker">
					<input type="text" name="birthday" class="form-control input-sm" id="input_date" size="10" readonly>
					<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				</div>
			</div>
			<div class="form-group col-sm-3 order_date_publisher">
				<label class="control-label">Khách hàng</label>
				<div class="input-group">
					<select class="form-control select_customer"></select>
					<span class="input-group-addon" data-toggle="modal"
						data-target="#insert_customer_modal"><span class="glyphicon glyphicon-plus"></span></span>
				</div>
			</div>
			<div class="form-group col-sm-3" style="padding-top:15px;">
				<input type="radio" name="customer_type" id="customer_retail" value="2" checked="checked">
				<label for="customer_retail">Khách lẻ</label>
				<br>
				<input type="radio" name="customer_type" id="customer_wholesale" value="1">
				<label for="customer_wholesale">Khách sỉ</label>
			</div>
		</div>
		<!-- .row -->
		
		<hr>
		<div class="form-group col-sm-3">
			<label class="control-label">Hàng hóa</label> 
			<div class="">
				<select class="form-control select_category" name="select_category"></select>
			</div>
		</div>
		<div class="form-group col-sm-3" >
			<label class="control-label">Chất liệu</label> 
			<div class="">
				<select class="form-control select_material" name="select_material"></select>
			</div>
		</div>
		<div class="form-group col-sm-2 col-md-2">
			<label class="control-label" >Đường kính</label>
			<div class="">
				<input maxlength="10" type="text" name="input_diameter" class="input_diameter form-control" value="0" />
			</div>
		</div>
		<div class="form-group col-sm-2">
			<label class="control-label" >Chiều dài</label>
			<div class="">
				<input maxlength="10" name="input_length" type="text" class="input_length form-control">
			</div>
		</div>
		<div class="form-group col-sm-2">
			<label class="control-label" >Bước răng</label>
			<div class="">
				<input maxlength="10" name="input_product_range" type="text" class="input_product_range form-control">
			</div>
		</div>
		<div class="form-group col-sm-3" >
			<label class="control-label" >Đơn vị</label>
			<div class="input-group">
				<select class="form-control select_unit" name="select_unit"></select>
				
				<span class="input-group-addon edit_group_product" data-toggle="modal" data-target="#product_group_modal">
					<a>
						<span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
					</a>
				</span>
			</div>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label" >Số lượng</label>
			<div class="">
				<input maxlength="10" name="input_quanlity" type="text" class="input_quanlity form-control" value="1">
			</div>
		</div>
		<div class="form-group col-sm-4">
			<label class="control-label" >Tồn kho</label>
			<div class="">
				<input maxlength="10" name="input_instock" type="text" class="input_instock form-control" value="0" readonly>
			</div>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label col-xs-12">Giá bán sỉ</label>
			<div class="col-xs-10">
				<select readonly="" class="wholesales_price"></select>
			</div>
			<div class="radio col-xs-2">
			      <label><input type="radio" name="price_type" value="1"></label>
			</div>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label col-xs-12">Giá bán lẻ</label>
			<div class="col-xs-10">
				<input maxlength="10" name="input_price" type="text" class="retail_price form-control" readonly="" value="0">
			</div>
			<div class="radio col-xs-2">
			      <label><input type="radio" name="price_type" value="2" checked="checked"></label>
			</div>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label col-xs-12">Giá khác</label>
			<div class="col-xs-10">
				<input maxlength="10" name="input_price" type="text" class="input_price form-control" value="0">
			</div>
			<div class="radio col-xs-2">
			      <label><input type="radio" name="price_type" value="3"></label>
			</div>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label" >Thành tiền</label>
			<div class="">
				<input maxlength="10" name="input_amount" type="text" class="input_amount form-control" readonly value="0">
			</div>
		</div>
				<!-- <a class="btn btn-default" data-dismiss="modal">Hủy</a>
				<a class="btn btn-success btn_check_instock" href="#">Kiểm tra kho</a>
				<a class="btn btn-primary btn_add_order" href="#">Thêm và tiếp tục</a> -->
		<!-- row -->
		<div class="col-md-12 clear_both">
			<a data-toggle="modal" data-target="#insert_order_modal"
				class="btn_check_instock btn btn-primary col-md-2 col-sm-3 col-md-push-1 col-sm-push-0 col-xs-12 margin_bottom_10px"
				>
				<span class="glyphicon glyphicon-floppy-saved"></span>&nbsp;&nbsp;&nbsp;&nbsp;Kiểm tra kho
			</a>
			<a class="btn_add_order btn btn-success col-md-2 col-md-push-2 col-sm-3 col-sm-push-0 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;&nbsp;&nbsp;Thêm hàng hóa
			</a>
			<a onclick="bindOrderData();" class="btn_save_new_order btn btn-warning col-md-2 col-md-push-3 col-sm-3 col-sm-push-0 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-print"></span>&nbsp;&nbsp;&nbsp;&nbsp;Xem dữ liệu
			</a>
		</div>
		<!-- .row -->
		<div class="col-md-12 clear_both">
			<hr>
		</div>
		<!-- row -->
		<div class="col-md-12 clear_both">
			<table class="table table-condensed table-hover table-striped" id="table_order">
				<thead>
					<tr>
						<th>Hình ảnh</th>
						<th>Ngày bán hàng</th>
						<th>Khách hàng</th>
						<th>Tên hàng hóa</th>
						<th>Chất liệu</th>
						<th>Đường kính</th>
						<th>Chiều dài</th>
						<th>Bước răng</th>
						<th>Số lượng</th>
						<th>Đơn vị</th>
						<th>Giá mua vào</th>
						<th>Thành tiền</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>
			<br>
		</div>
		<!-- .row -->
	</div>
</div>
</body>
</html>
