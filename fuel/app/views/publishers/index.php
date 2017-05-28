<script>
	var publishers = '<?php echo json_encode($publishers); ?>';
</script>
<div class="modal fade" id="delete_modal">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-body">
				<p>Bạn chắc chắn muốn xóa nhà cung cấp:Tân Cơ?</p>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary" href="#">Đồng ý</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container" >
	<div class="row col-md-12 header_top">
		<h1 class="text-center">Danh sách nhà cung cấp</h1>
		<hr>
		<?php
	
				$errors = Session::get_flash('error');
				
				if($errors){
					echo '<p class="error_message">';
					
					foreach ($errors as $error){
						echo $error.'<br>';
					}
					echo '</p>';
				}
				
				$success = Session::get_flash('success');
				if($success){
					echo '<p class="success_message">'.$success.'</p>';
				}
				?>
	</div>
	<div class="row">
		<div class="col-sm-12 col-sm-offset-0 col-xs-10 col-xs-offset-1 col-md-offset-0 col-md-12">
			<?php echo render('publishers/_form'); ?>
			<div></div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<hr>
		</div>
	</div>

<div class="panel panel-default">
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
					<?php if ($publishers): ?>
						<table class="table table-condensed table-hover table-striped dataTable no-footer" id="dataTables-example">
							<thead>
								<tr>
									<th>#</th>
									<th>Nhà cung cấp</th>
									<th class="col-xs-5 col-sm-2" >&nbsp;</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
						
						<?php else: ?>
							<p>Chưa có nhà cung cấp nào.</p>
						<?php endif; ?>
			</div>
	</div>
</div>
