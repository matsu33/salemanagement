<?php echo render('hinhanhhanghoa/_form_edit'); ?>
<?php echo render('hinhanhhanghoa/_form_product_group_insert'); ?>
<?php echo render('hinhanhhanghoa/_form_product_group_edit'); ?>

    <?php 
	    $baseUrl = Uri::base(false);
	    $imageFolderUrl = $baseUrl."assets/img/";
	    $noImageUrl = $imageFolderUrl."02.jpg";
    ?>
<div class="modal fade" id="delete_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_delete_product_id" />
				<input type="hidden" class="input_delete_product_image" />
				<p>Bạn chắc chắn muốn xóa hàng hóa này?</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
					class="btn btn-primary btn_product_delete" href="#">Đồng ý</a>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_product_id" />
				<input type="text" class="span_product_name form-control" maxlength="100" />
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
					class="btn btn-primary btn_product_update" href="#">Cập nhật</a>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Danh sách hàng hóa</h1>
		<hr>
	</div>
	<?php echo render('hinhanhhanghoa/_form'); ?>
	
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>

<div class="panel panel-default" id="panel_product_list">
	<div class="panel-body">
			<div class="row">
					<div class="input-group col-md-6">
						<input type="text" class="form-control global_filter" id="txtKeyword">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</span>
					</div>
			</div>
			<div class="row">
						<table class="table table-condensed table-hover table-striped dataTable no-footer" id="table_product">
							<thead>
								<tr>
									<th>Hình ảnh</th>
									<th>Tên hàng hóa</th>
									<th>Chất liệu</th>
									<th>Đường kính</th>
									<th>Chiều dài</th>
									<th>Bước răng</th>
									<th>Đơn vị</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php if(count($list_product) > 0 ){ ?>
									<?php 
									$count = 1;
									foreach($list_product as $item) : 
									$no = $item['id'];
									$product_image = $item['image'];
									$image = '<img class="center-block img-rounded table_thumbnail_image" src="'.$imageFolderUrl.'products/'.$product_image.'" alt="No-image"'.
									'onerror="this.onerror=null;this.src=\''.$noImageUrl.'\'" />';
									$category_name = $item['category_name'];
									$material_name = $item['material_name'];
									$size_id = $item['size_id'];
									$diameter = $item['diameter'];
									$length = $item['length'];
									$product_range = $item['product_range'];
									$unit_name = $item['unit_name'];
									$product_group = $item['product_group'];
									$link = '<a class="btn btn-inverse btn-primary btn_edit_delete" onclick="showModalEdit(\''.$no.'\',\''.$item['category_id'].'\',\''.$item['material_id'].'\',\''.
									$item['unit_id'].'\',\''.$size_id.'\',\''.$diameter.'\',\''.$length.'\',\''.$product_range.'\',\''.$product_group.'\',\''.$product_image.'\')" href="#"><i class="fa fa-edit fa-lg"></i></a>'.
									'<a class="btn btn-small btn-danger btn_edit_delete" onclick="showModalDelete(\''.$no.'\',\''.$product_image.'\')"><i class="fa fa-trash fa-lg"></i></a>';
									$tr_class = "odd";
									if($count%2 == 0){
										$tr_class = "even";
									}
									$count++;
									?>
										<tr class="<?php echo $tr_class; ?>">
											<td class=" center"><?php echo $image; ?></td>
											<td class=" "><?php echo $category_name; ?></td>
											<td class=" "><?php echo $material_name; ?></td>
											<td class=" "><?php echo $diameter; ?></td>
											<td class=" "><?php echo $length; ?></td>
											<td class=" "><?php echo $product_range; ?></td>
											<td class=" "><?php echo $unit_name; ?></td>
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
