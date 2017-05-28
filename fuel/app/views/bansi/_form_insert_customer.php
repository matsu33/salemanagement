<div class="modal fade" id="insert_customer_modal"><!-- data-backdrop="static" -->
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<?php echo Form::open(array("class"=>"form-horizontal", 'id' => 'frm_customer_insert')); ?>
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		    	<h4 class="modal-title">Thêm khách hàng</h4>
		    </div>
			<div class="modal-body">
				<div class="form-group col-sm-12">
					<label class="control-label col-sm-4" >Tên khách hàng</label>
					<div class="col-sm-8">
						<input maxlength="10" type="text" name="input_customer_name" class="input_customer_name form-control" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default" data-dismiss="modal">Hủy</a>
				<button type="submit" class="btn btn-primary btn_add_customer" href="#">Thêm và tiếp tục</button>
			</div>
			<?php echo Form::close(); ?>
		</div>
	</div>
</div>