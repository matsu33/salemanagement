<div class="modal fade" id="delete_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_unit_id" />
				<p>Bạn chắc chắn muốn xóa đơn vị:<span class="span_unit_name"></span>?</p>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_unit_delete" href="#">Đồng ý</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="edit_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<input type="hidden" class="input_unit_id" />
				<input type="text" class="span_unit_name form-control" maxlength="30" />
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary btn_unit_update" href="#">Cập nhật</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Danh sách đơn vị</h1>
		<hr>
	</div>
	<div class="row">
		<div class="col-sm-12 col-sm-offset-0 col-md-offset-0 col-md-12">
			<?php echo render('units/_form'); ?>
			<div></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>

<div class="panel panel-default" id="panel_unit_list">
	<div class="panel-body">
			<!--<div class="row">
					<div class="input-group col-md-6">
						<input type="text" class="form-control global_filter" id="txtKeyword">
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
						</span>
					</div>
			</div>
			<div class="row">
						<table class="table table-condensed table-hover table-striped dataTable no-footer" id="table_unit">
							<thead>
								<tr>
									<th>#</th>
									<th>Đơn vị</th>
									<th class="col-xs-5 col-sm-2" >&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
			</div>-->
        <div class="row">
            <?php if(count($listData) > 0 ){
                for($i = 0; $i < count($listData); $i++){
                    $publisher = $listData[$i];
                    $publisherId = $publisher['id'];
                    $publisherName = $publisher['unit_name'];
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
                Không tìm thấy đơn vị nào
            <?php } ?>
        </div>
	</div>
</div>
