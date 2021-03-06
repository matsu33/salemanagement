
<?php 
	    $baseUrl = Uri::base(false);
	    $imageFolderUrl = $baseUrl."assets/img/";
	    $noImageUrl = $imageFolderUrl."02.jpg";
    ?>
    
<div class="modal fade" id="delete_modal" >
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_delete_product_id" />
				<p>Bạn chắc chắn muốn xóa báo giá này ?</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
					class="btn btn-primary btn_product_price_delete" href="#">Đồng ý</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_modal" >
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<form id="frm_edit_product_price">
				<div class="modal-body">
					<div class="form-group col-sm-12" >
						<label class="control-label col-sm-12" >Đơn vị</label>
<!--						<div class="input-group">-->
							<select class="form-control select_unit"></select>

<!--							<span class="input-group-addon edit_group_product">-->
<!--								<a>-->
<!--									<span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>-->
<!--								</a>-->
<!--							</span>-->
<!--						</div>-->
					</div>
					<div class="form-group col-sm-12">
						<label class="control-label" >Chiều dài</label>
						<input maxlength="10" name="input_length" type="text" class="input_length form-control col-sm-12">
					</div>
					<div class="form-group col-sm-12">
						<label class="control-label" >Bước răng</label>
						<input maxlength="10" name="input_product_range" type="text" class="input_product_range form-control col-sm-12">
					</div>
					<div class="form-group col-sm-12" >
						<label class="control-label col-xs-12">Chất liệu</label>
						<select class="form-control select_material"></select>
					</div>
					<div class="form-group col-sm-12" >
						<label class="control-label col-xs-12">Giá mua vào</label>
						<input type="text" name="input_edit_product_price" class="form-control input_edit_product_price col-sm-12" maxlength="10"
							   placeholder="Giá mua vào"/>
					</div>
					<input type="hidden" class="input_edit_product_id" />
					<!--<label>Giá mua vào</label>
					<input type="text" name="input_edit_product_price" class="form-control input_edit_product_price" maxlength="10"
					placeholder="Giá mua vào"/>-->
				</div>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> 
					<button type="submit" class="btn btn-primary btn_product_price_update" href="#">Đồng ý</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo render('hinhanhhanghoa/_form_product_group_insert'); ?>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Bảng báo giá đầu vào</h1>
		<hr>
	</div>
	
		<?php echo render('bangbaogia/_form'); ?>

        <input type="hidden" value="<?php echo $publisher_id; ?>" class="selected-publisher">
        <input type="hidden" value="<?php echo $category_id; ?>" class="selected-category">
        <input type="hidden" value="<?php echo $material_id; ?>" class="selected-material">
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-condensed table-hover table-striped" id="table_bang_bao_gia">
				<thead>
					<tr>
						<th>Hình ảnh</th>
						<th>Nhà cung cấp</th>
						<th>Tên hàng hóa</th>
						<th>Chất liệu</th>
						<th>Đường kính</th>
						<th>Chiều dài</th>
						<th>Bước răng</th>
						<th>Đơn vị</th>
						<th>Giá mua vào</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php if(count($list_price) > 0 ){ ?>
					<?php 
					$count = 1;
					foreach($list_price as $item) : 
					$no = $item['id'];
					$product_image = $item['image'];
					$image = '<img class="center-block img-rounded table_thumbnail_image" src="'.$imageFolderUrl.'products/'.$product_image.'" alt="No-image"'.
					'onerror="this.onerror=null;this.src=\''.$noImageUrl.'\'" />';// <th>Hình ảnh</th>
						$product_id = $item['product_id'];
						$publisher_id = $item['publisher_id'];// <th>Nhà cung cấp</th>
						$publisher_name = $item['publisher_name'];// <th>Nhà cung cấp</th>
						$category_id = $item['category_id'];// <th>Tên hàng hóa</th>
					$category_name = $item['category_name'];// <th>Tên hàng hóa</th>
					$material_name = $item['material_name'];// <th>Chất liệu</th>
					$diameter = $item['diameter'];// <th>Đường kính</th>
					$length = $item['length'];// <th>Chiều dài</th>
					$product_range = $item['product_range'];// <th>Bước răng</th>
					$unit_name = $item['unit_name'];// <th>Đơn vị</th>
					$input_price = $item['input_price'];// <th>Giá mua vào</th>
					$unit_id = $item['unit_id'];
						$material_id = $item['material_id'];
						$size_id = $item['size_id'];

					$linkEdit = '<a class="btn btn-inverse btn-primary btn_edit_delete" onclick="showModalEditPrice(\''.$no.'\',\''.$unit_id.'\',\''.$length.'\',\''.$product_range.'\',\''.$material_id.'\',\''.$input_price.'\')"><i class="fa fa-edit fa-lg"></i></a>';
					$linkDelete = '<a class="btn btn-small btn-danger btn_edit_delete" onclick="showModalDelete(\''.$no.'\')"><i class="fa fa-trash fa-lg"></i></a>';
					$link = $linkEdit . $linkDelete;
					$tr_class = "odd";
					if($count%2 == 0){
						$tr_class = "even";
					}
					$count++;
					?>
						<tr class="<?php echo $tr_class; ?> js-row-price-<?php echo $no; ?>" data-price_id="<?php echo $no; ?>"
							data-publisher_id="<?php echo $publisher_id; ?>"
							data-product_id="<?php echo $product_id; ?>"
							data-category_id="<?php echo $category_id; ?>"
							data-diameter="<?php echo $diameter; ?>"
							data-size_id="<?php echo $size_id; ?>">
							<td class="center"><?php echo $image; ?></td>
							<td class="sorting_1"><?php echo $publisher_name; ?></td>
							<td class=" "><?php echo $category_name; ?></td>
							<td class=" "><?php echo $material_name; ?></td>
							<td class=" "><?php echo $diameter; ?></td>
							<td class=" "><?php echo $length; ?></td>
							<td class=" "><?php echo $product_range; ?></td>
							<td class=" "><?php echo $unit_name; ?></td>
							<td class=" "><?php echo $input_price; ?></td>
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