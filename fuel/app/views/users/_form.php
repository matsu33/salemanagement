<?php echo Form::open(array("class"=>"form-horizontal")); ?>

	<fieldset>
		<div class="form-group">
			<?php echo Form::label('User name', 'user_name', array('class'=>'control-label')); ?>

				<?php echo Form::input('user_name', Input::post('user_name', isset($user) ? $user->user_name : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'User name')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('User password', 'user_password', array('class'=>'control-label')); ?>

				<?php echo Form::input('user_password', Input::post('user_password', isset($user) ? $user->user_password : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'User password')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('User type', 'user_type', array('class'=>'control-label')); ?>

				<?php echo Form::input('user_type', Input::post('user_type', isset($user) ? $user->user_type : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'User type')); ?>

		</div>
		<div class="form-group">
			<?php echo Form::label('User realname', 'user_realname', array('class'=>'control-label')); ?>

				<?php echo Form::input('user_realname', Input::post('user_realname', isset($user) ? $user->user_realname : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'User realname')); ?>

		</div>
		<div class="form-group">
			<label class='control-label'>&nbsp;</label>
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>		</div>
	</fieldset>
<?php echo Form::close(); ?>