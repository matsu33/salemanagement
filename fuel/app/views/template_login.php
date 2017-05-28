<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="vi">
<head>
<meta charset="utf-8">
<title><?php echo $title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="Nguyen Van Tung" content="">
	<?php echo Asset::render('login_css'); ?>
    <?php echo Asset::render('login_script'); ?>
    </head>
<body>
	<div id="overlay"></div>
	<?php echo $content;?>
</body>
</html>