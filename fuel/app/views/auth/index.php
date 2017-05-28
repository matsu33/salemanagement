<script>
	var urlLogin = "<?php echo Router::get('login'); ?>";
	var urlHome = "<?php echo Router::get('home'); ?>";
</script>
<div class="container" style="" >
	<div
		class="col-md-6 col-md-offset-3 col-sm-offset-3 col-sm-6 col-xs-12">
		<?php echo Asset::img('01.jpg', array('alt' => 'Phước Thạnh - Đăng nhập', 'class' => 'center-block img-circle img-responsive')); ?>
		<form class="form-horizontal" role="form" id="login_form" method="post">
			<fieldset>
				<!-- Form Name -->
				<legend>Đăng nhập</legend>
				<div class="form-group has-success" >
					<div class="col-sm-3">
						<label for="inputUsername" class="control-label">Tài khoản</label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="login_user" name="login_user"
							placeholder="Tài khoản">
					</div>
				</div>
				<div class="form-group has-success">
					<div class="col-sm-3">
						<label for="inputPassword" class="control-label">Mật khẩu</label>
					</div>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="login_password" name="login_password"
							placeholder="Mật khẩu">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-6">
						<button type="submit" class="btn btn-primary" id="btn_submit_login">
							<span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;Đăng
							nhập&nbsp;&nbsp;
						</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>