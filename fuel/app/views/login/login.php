<script>
	var urlCheckLogin = "<?php echo Router::get('login_check'); ?>";
	var urlHome = "<?php echo Router::get('home'); ?>";
</script>
<?php echo Asset::js('login.js'); ?>
<div class="row" style="" >
	<div
		class="col-md-4 col-md-offset-4 col-sm-offset-4 col-sm-4 col-xs-offset-1 col-xs-10">
		<?php echo Asset::img('01.jpg', array('alt' => 'Phước Thạnh - Đăng nhập', 'class' => 'center-block img-circle img-responsive')); ?>
		<form class="form-horizontal" role="form" id="login_form">
			<fieldset>
				<!-- Form Name -->
				<legend>Đăng nhập</legend>
				<div class="form-group has-success" >
					<div class="col-sm-3">
						<label for="inputUsername" class="control-label">Tài khoản</label>
					</div>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="inputUsername"
							placeholder="Tài khoản">
					</div>
				</div>
				<div class="form-group has-success">
					<div class="col-sm-3">
						<label for="inputPassword" class="control-label">Mật khẩu</label>
					</div>
					<div class="col-sm-9">
						<input type="password" class="form-control" id="inputPassword"
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