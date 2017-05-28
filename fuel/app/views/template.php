<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="vi">
<head>
<meta charset="utf-8">
<title><?php echo $title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="Nguyen Van Tung" content="">    
	<?php echo Asset::render('common_css'); ?>
    <?php echo Asset::render('common_script'); ?>
    <script type="text/javascript">
        var lang = <?php echo isset($lang)?json_encode($lang):'null'; ?>;
        var baseUrl = "<?php echo Uri::base(false); ?>";
        var imageFolderUrl = baseUrl + "assets/img/";
        var noImageUrl = imageFolderUrl + "02.jpg";
    </script>
    <?php echo Asset::render('current_script'); ?>
</head>
<body>
	<div id="overlay"></div>
	<div class="navbar navbar-default navbar-fixed-top navbar-inverse">
		<div class="container text-center">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo Router::get('home');?>">Trang chủ</a> <a
					type="button" class="navbar-toggle" data-toggle="collapse"
					data-target=".navbar-collapse"></a> <span class="sr-only">Toggle
					navigation</span>
			</div>
			<div
				class="collapse navbar-collapse navbar-ex1-collapse max_height_100_percent">
				<ul class="nav navbar-left navbar-nav text-left">
					<li class="active"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"> Nhập liệu <span class="caret"></span>
					</a>
						<ul class="dropdown-menu list-unstyled" role="menu">
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('nhacungcap');?>">Nhà cung cấp</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('loaihanghoa');?>">Hàng hóa</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('donvi');?>">Đơn vị</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('chatlieu');?>">Chất liệu</a></li>
							<!--<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('quicach');?>">Qui cách</a></li>  -->
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('hinh_anh_hang_hoa');?>">Hình ảnh hàng hóa</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('bang_bao_gia');?>">Bảng báo giá</a></li>
						</ul></li>
					<li class="active"><a href="<?php echo Router::get('mua_hang');?>">Nhà cung cấp</a></li>
					<li class="active"><a href="<?php echo Router::get('so_sanh_gia');?>">So sánh giá</a></li>
					<li class="active"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"> Bán hàng <span class="caret"></span>
					</a>
						<ul class="dropdown-menu list-unstyled text-left" role="menu">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"> </a>
							<li role="presentation"><a class="dropdown-toggle"
								data-toggle="dropdown" href="#"> </a> <a role="menuitem"
								tabindex="-1" href="<?php echo Router::get('ban_si');?>">Khách hàng sỉ</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('ban_le');?>">Khách hàng lẻ</a></li>
						</ul></li>
					<li class="active"><a href="<?php echo Router::get('kiem_kho');?>">Kiểm kho</a></li>
					<li class="active"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"> Báo cáo <span class="caret"></span>
					</a>
						<ul class="dropdown-menu list-unstyled text-left" role="menu">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"> </a>
							<li role="presentation"><a class="dropdown-toggle"
								data-toggle="dropdown" href="#"> </a> <a role="menuitem"
								tabindex="-1" href="<?php echo Router::get('doanh_thu_dau_vao');?>">Doanh thu đầu vào</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('doanh_thu_dau_ra');?>">Doanh thu đầu ra</a></li>
						</ul></li>
					<li class="active"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"> Công nợ <span class="caret"></span>
					</a>
						<ul class="dropdown-menu list-unstyled text-left" role="menu">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"> </a>
							<li role="presentation"><a class="dropdown-toggle"
								data-toggle="dropdown" href="#"> </a> <a role="menuitem"
								tabindex="-1" href="<?php echo Router::get('no_nha_cung_cap');?>">Nhà cung cấp</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('no_khach_hang');?>">Khách hàng sỉ</a></li>
						</ul></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="#" class="dropdown-toggle"
						data-toggle="dropdown"> <span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;admin&nbsp;&nbsp;<span
							class="caret"></span>
					</a>
						<ul class="dropdown-menu list-unstyled text-left" role="menu">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"> </a>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('tao_bang_bao_gia');?>">Tạo bảng báo giá</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('phieu_giao_hang');?>">Phiếu giao hàng</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('don_dat_hang');?>">Đơn đặt hàng</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('luu_du_lieu');?>">Lưu dữ liệu</a></li>
							<li role="presentation"><a role="menuitem" tabindex="-1"
								href="<?php echo Router::get('phuc_hoi_du_lieu');?>">Phục hồi dữ liệu</a></li>
						</ul></li>
					<li class="active"><a href="#" data-toggle="modal"
						data-target="#logout_modal"> <span
							class="glyphicon glyphicon-log-out"></span>&nbsp;&nbsp;Đăng
							xuất&nbsp;&nbsp;
					</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="modal fade" id="logout_modal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-body">
					<p>Bạn có chắc chắn muốn thoát?</p>
				</div>
				<div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal">Hủy</a> <a
						class="btn btn-primary" href="#" id="btn_logout">Đồng ý</a>
				</div>
			</div>
		</div>
	</div>
	<?php echo $content;?>
</body>
</html>