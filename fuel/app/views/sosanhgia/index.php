<input type="hidden" value="<?php echo $category_id; ?>" class="selected-category">
<input type="hidden" value="<?php echo $material_id; ?>" class="selected-material">
<?php
	$baseUrl = Uri::base(false);
	$imageFolderUrl = $baseUrl."assets/img/";
	$noImageUrl = $imageFolderUrl."02.jpg";
?>
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
<!--	--><?php //echo render('sosanhgia/_form'); ?>
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
				<?php if(count($list_products) > 0 ){ ?>
					<?php
					$count = 1;
					foreach($list_products as $item) :
						$product_image = $item['image'];
						$image = '<img class="center-block img-rounded table_thumbnail_image" src="'.$imageFolderUrl.'products/'.$product_image.'" alt="No-image"'.
							'onerror="this.onerror=null;this.src=\''.$noImageUrl.'\'" />';
						$product_id = $item['product_id'];
						$category_id = $item['category_id'];// <th>Tên hàng hóa</th>
						$category_name = $item['category_name'];// <th>Tên hàng hóa</th>
						$material_id = $item['material_id'];
						$material_name = $item['material_name'];// <th>Chất liệu</th>
						$diameter = $item['diameter'];// <th>Đường kính</th>
						$length = $item['length'];// <th>Chiều dài</th>
						$product_range = $item['product_range'];// <th>Bước răng</th>
						$unit_id = $item['unit_id'];
						$unit_name = $item['unit_name'];// <th>Đơn vị</th>
						$wholesales_price = $item['wholesales_price'];//<th>Giá sỉ 1</th>
						$wholesales_price2 = $item['wholesales_price2'];//<th>Giá sỉ 2</th>
						$wholesales_price3 = $item['wholesales_price3'];//<th>Giá sỉ 3</th>
						$retail_price = $item['retail_price'];//<th>Giá bán lẻ</th>



//						$input_price = $item['input_price'];// <th>Giá mua vào</th>
//						$size_id = $item['size_id'];
//						$unit_instock = $item['unit_instock'];

//						$linkEdit = '<a class="btn btn-inverse btn-primary btn_edit_delete" onclick="showModalEditPrice(\''.$no.'\',\''.$unit_id.'\',\''.$length.'\',\''.$product_range.'\',\''.$material_id.'\',\''.$input_price.'\')"><i class="fa fa-edit fa-lg"></i></a>';
//						$linkDelete = '<a class="btn btn-small btn-danger btn_edit_delete" onclick="showModalDelete(\''.$no.'\')"><i class="fa fa-trash fa-lg"></i></a>';
//						$link = '<a onclick="viewHistoryOrderDetail('.$product_id.')" class="btn btn-inverse btn-primary"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Xem chi tiết</a>';
						$link = '<a onclick="bindListPublisherToTableWithProductId('.$product_id.')" class="btn btn-inverse btn-primary" data-toggle="modal" data-target="#nhacungcap_modal"><span class="glyphicon glyphicon-pencil"></span>&nbsp;&nbsp;Chọn nhà cung cấp</a>';
						$tr_class = "odd";
						if($count%2 == 0){
							$tr_class = "even";
						}
						$count++;
						?>
						<tr class="<?php echo $tr_class; ?> js-product-<?php echo $product_id; ?>">
							<td class=" "><?php echo $image; ?></td>
							<td class=" "><?php echo $category_name; ?></td>
							<td class=" "><?php echo $material_name; ?></td>
							<td class=" "><?php echo $diameter; ?></td>
							<td class=" "><?php echo $length; ?></td>
							<td class=" "><?php echo $product_range; ?></td>
							<td class=" "><?php echo $unit_name; ?></td>
							<td class=" "><?php echo $wholesales_price; ?></td>
							<td class=" "><?php echo $wholesales_price2; ?></td>
							<td class=" "><?php echo $wholesales_price3; ?></td>
							<td class=" "><?php echo $retail_price; ?></td>
							<td class=" "><?php echo $link; ?></td>
						</tr>
					<?php endforeach; ?>
				<?php } ?>
				</tbody>
			</table>
			<br>
		</div>
		<div class="pagination"><?php echo html_entity_decode($pagination); ?></div>
	</div>
</div>