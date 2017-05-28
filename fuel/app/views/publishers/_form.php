<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('Publisher name', 'publisher_name', array('class'=>'control-label')); ?>

				<?php echo Form::input('publisher_name', Input::post('publisher_name', isset($publisher) ? $publisher->publisher_name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Publisher name')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Status', 'status', array('class'=>'control-label')); ?>

				<?php echo Form::input('status', Input::post('status', isset($publisher) ? $publisher->status : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Status')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Create at', 'create_at', array('class'=>'control-label')); ?>

				<?php echo Form::input('create_at', Input::post('create_at', isset($publisher) ? $publisher->create_at : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Create at')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('Update at', 'update_at', array('class'=>'control-label')); ?>

				<?php echo Form::input('update_at', Input::post('update_at', isset($publisher) ? $publisher->update_at : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Update at')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>