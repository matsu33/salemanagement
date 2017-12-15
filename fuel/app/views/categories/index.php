<div class="modal fade" id="delete_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_category_id" />
				<p>Bạn chắc chắn muốn xóa hàng hóa:<span class="span_category_name"></span>?</p>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_category_delete" href="#">Đồng ý</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_category_id" />
				<input type="text" class="span_category_name form-control" maxlength="200" />
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_category_update" href="#">Cập nhật</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Danh sách hàng hóa</h1>
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-12 col-sm-offset-0 col-md-offset-0 col-md-12">
			<?php echo render('categories/_form'); ?>
			<div></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>

<div class="panel panel-default" id="panel_category_list">
	<div class="panel-body">
        <div class="row">
            <?php if(count($listData) > 0 ){
                for($i = 0; $i < count($listData); $i++){
                    $publisher = $listData[$i];
                    $publisherId = $publisher['id'];
                    $publisherName = $publisher['category_name'];
                    ?>
                    <div class="col-md-3">
                        <a class="btn btn-inverse btn-primary btn_edit_delete" onclick="showModalEdit('<?= $publisherId ?>','<?= $publisherName ?>')" href="#"><i class="fa fa-edit fa-lg"></i></a>
                        <a class="btn btn-small btn-danger btn_edit_delete" onclick="showModalDelete('<?= $publisherId ?>','<?= $publisherName ?>')"><i class="fa fa-trash fa-lg"></i></a>
                        <span><?= $publisherName ?></span>
                    </div>
                    <?php
                }
                ?>
            <?php } else { ?>
                Không tìm thấy loại hàng hóa nào
            <?php } ?>
        </div>
			<!--<div class="row">
					<div class="input-group col-md-6">
						<input type="text" class="form-control global_filter" id="txtKeyword">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</span>
					</div>
			</div>
			<div class="row">
						<table class="table table-condensed table-hover table-striped dataTable no-footer" id="table_category">
							<thead>
								<tr>
									<th>#</th>
									<th>Hàng hóa</th>
									<th class="col-xs-5 col-sm-2" >&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
			</div>-->
	</div>
</div>
