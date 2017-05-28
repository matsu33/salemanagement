<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Customer type', 'customer_type', array('class'=>'control-label')); ?>

				<?php echo Form::input('customer_type', Input::post('customer_type', isset($customer) ? $customer->customer_type : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Customer type')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Customer name', 'customer_name', array('class'=>'control-label')); ?>

				<?php echo Form::input('customer_name', Input::post('customer_name', isset($customer) ? $customer->customer_name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Customer name')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>