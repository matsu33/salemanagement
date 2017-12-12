<input type="hidden" value="<?php echo $category_id; ?>" class="selected-category">
<input type="hidden" value="<?php echo $material_id; ?>" class="selected-material">

<div class="modal fade" id="chatlieu_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Chọn chất liệu</h4>
			</div>
			<div class="chatlieu_group_popup">
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="hanghoa_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Chọn hàng hóa</h4>
			</div>
			<div class="hanghoa_group_popup">
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="loc_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<div class="form-group">
					<label class="control-label" for="diameter">Đường kính</label>
					<input type="text" class="form-control" id="product_diameter" />
				</div>
				<div class="form-group" >
					<label class="control-label" for="product_length">Chiều dài</label>
					<input type="text" class="form-control" id="product_length" />
				</div>
				<div class="form-group" >
					<label class="control-label" for="product_range">Bước răng</label>
					<input type="text" class="form-control" id="product_range" />
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
					class="btn btn-primary kiemkho_btn_loc_popup">Lọc</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="chitiet_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Chi tiết hàng hóa</h4>
			</div>
			<div class="modal-body">
				<table class="table table-condensed table-hover table-striped">
					<thead>
						<tr>
							<th>Tên hàng hóa</th>
							<th>Đường kính</th>
							<th>Chiều dài</th>
							<th>Bước răng</th>
							<th>Tồn cũ</th>
							<th>Ngày nhập hàng</th>
							<th>Số lượng nhập</th>
							<th>Tổng</th>
							<th>Ngày xuất hàng</th>
							<th>Số lượng xuất</th>
							<th>Tồn kho</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a>
			</div>
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
<div class="modal fade" id="history_order_detail_modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Lịch sử giao dịch</h4>
			</div>
			<div class="modal-body">
				<table class="table table-condensed table-hover table-striped">
					<thead>
						<tr>
							<th>Ngày tháng</th>
							<th>Tồn cũ</th>
							<th>Loại</th>
							<th>Số lượng</th>
							<th>Tồn cuối</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#update_product_instock_modal" onclick="bindProductInstockToModal();">Cập nhật kho</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="update_product_instock_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">Nhập tồn kho hiện tại</h4>
			</div>
			<div class="modal-body">
				<div class="form-group col-sm-12">
					<label class="control-label col-sm-4" >Tồn kho hiện tại</label>
					<div class="col-sm-8">
						<input maxlength="10" name="input_current_instock" type="text" class="input_current_instock form-control" value="0">
					</div>
				</div>
			</div>
			<div class="modal-footer clear_both">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" onclick="updateProductInstock();">Cập nhật</button>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Kiểm kho</h1>
		<hr>
	</div>
	<div class="row js-form-search-instock">
		<div class="form-group col-sm-2">
			<label class="control-label col-xs-12">Hàng hóa</label>
			<div class="input-group">
				<select class="form-control select_category"></select>

				<span class="input-group-addon">
					<input type="checkbox" class="js-checkbox-select-search-category">
				</span>
			</div>
		</div>
		<div class="form-group col-sm-2" >
			<label class="control-label col-xs-12">Chất liệu</label>
			<div class="input-group">
				<select class="form-control select_material"></select>

				<span class="input-group-addon">
					<input type="checkbox" class="js-checkbox-select-search-material">
				</span>
			</div>
		</div>
		<div class="form-group col-md-2 col-sm-2">
			<label class="control-label" >Đường kính</label>
			<input maxlength="10" type="text" name="input_diameter" class="input_diameter form-control col-md-6 col-sm-12" value="<?php echo $product_diameter; ?>" />
		</div>
		<div class="form-group col-md-2 col-sm-2">
			<label class="control-label" >Chiều dài</label>
			<input maxlength="10" name="input_length" type="text" class="input_length form-control col-md-6 col-sm-12" value="<?php echo $product_length; ?>">
		</div>
		<div class="form-group col-md-2 col-sm-2">
			<label class="control-label" >Bước răng</label>
			<input maxlength="10" name="input_product_range" type="text" class="input_product_range form-control col-md-6 col-sm-12" value="<?php echo $product_range; ?>">
		</div>
		<div class="form-group col-md-2 col-sm-2">
			<label class="control-label" >Tồn kho >=</label>
			<input maxlength="10" type="text" name="input_unit_instock" class="input_unit_instock form-control col-md-6 col-sm-12" value="<?php echo $unit_instock; ?>" />
		</div>
		<div class="col-md-12">
			<button type="submit" class="js-start-search btn btn-default col-md-2 col-sm-3 col-sm-push-1 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;&nbsp;Lọc
			</button>
			<button type="submit" class="js-reset-search btn btn-default col-md-2 col-sm-3 col-sm-push-2 col-xs-12 margin_bottom_10px">
				<span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;&nbsp;&nbsp;Xóa điều kiện lọc
			</button>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-condensed table-hover table-striped" id="table_loc">
				<thead>
					<tr>
						<th>Tên hàng hóa</th>
						<th>Chất liệu</th>
						<th>Đường kính</th>
						<th>Chiều dài</th>
						<th>Bước răng</th>
						<th>Đơn vị</th>
						<th>Tồn kho</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
<!--				var btnDetail = '<a onclick="viewHistoryOrderDetail('+products[i].id+','+Omss.numberFormat(products[i].unit_instock)+')" class="btn btn-inverse btn-primary"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Xem chi tiết</a>';-->

				<?php if(count($list_products) > 0 ){ ?>
					<?php
					$count = 1;
					foreach($list_products as $item) :
						$product_id = $item['id'];
//						$product_image = $item['image'];
//						$image = '<img class="center-block img-rounded table_thumbnail_image" src="'.$imageFolderUrl.'products/'.$product_image.'" alt="No-image"'.
//							'onerror="this.onerror=null;this.src=\''.$noImageUrl.'\'" />';// <th>Hình ảnh</th>
//						$product_id = $item['product_id'];
//						$publisher_id = $item['publisher_id'];// <th>Nhà cung cấp</th>
//						$publisher_name = $item['publisher_name'];// <th>Nhà cung cấp</th>
						$category_id = $item['category_id'];// <th>Tên hàng hóa</th>
						$category_name = $item['category_name'];// <th>Tên hàng hóa</th>
						$material_id = $item['material_id'];
						$material_name = $item['material_name'];// <th>Chất liệu</th>
						$diameter = $item['diameter'];// <th>Đường kính</th>
						$length = $item['length'];// <th>Chiều dài</th>
						$product_range = $item['product_range'];// <th>Bước răng</th>
						$unit_id = $item['unit_id'];
						$unit_name = $item['unit_name'];// <th>Đơn vị</th>
//						$input_price = $item['input_price'];// <th>Giá mua vào</th>
//						$size_id = $item['size_id'];
						$unit_instock = $item['unit_instock'];

//						$linkEdit = '<a class="btn btn-inverse btn-primary btn_edit_delete" onclick="showModalEditPrice(\''.$no.'\',\''.$unit_id.'\',\''.$length.'\',\''.$product_range.'\',\''.$material_id.'\',\''.$input_price.'\')"><i class="fa fa-edit fa-lg"></i></a>';
//						$linkDelete = '<a class="btn btn-small btn-danger btn_edit_delete" onclick="showModalDelete(\''.$no.'\')"><i class="fa fa-trash fa-lg"></i></a>';
						$link = '<a onclick="viewHistoryOrderDetail('.$product_id.')" class="btn btn-inverse btn-primary"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Xem chi tiết</a>';
						$tr_class = "odd";
						if($count%2 == 0){
							$tr_class = "even";
						}
						$count++;
						?>
						<tr class="<?php echo $tr_class; ?> js-product-<?php echo $product_id; ?>" data-instock="<?php echo $unit_instock; ?>">
							<td class=" "><?php echo $category_name; ?></td>
							<td class=" "><?php echo $material_name; ?></td>
							<td class=" "><?php echo $diameter; ?></td>
							<td class=" "><?php echo $length; ?></td>
							<td class=" "><?php echo $product_range; ?></td>
							<td class=" "><?php echo $unit_name; ?></td>
							<td class=" "><?php echo $unit_instock; ?></td>
							<td class=" "><?php echo $link; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagination"><?php echo html_entity_decode($pagination); ?></div>
	</div>
</div>
<div class="modal fade modal-edit-date">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Chọn ngày</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="input-group date col-sm-8 edit-date-group-control">
						<input type="text" name="edit-date" class="form-control input-sm input_date" size="10" readonly="">
						<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
				<button type="button" class="btn btn-primary" onclick="updateOrderDetailDate()">Cập nhật</button>
			</div>
		</div>
	</div>
</div>