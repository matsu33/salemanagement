<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('auth/index','Index');?></li>
	<li class='<?php echo Arr::get($subnav, "loglout" ); ?>'><?php echo Html::anchor('auth/loglout','Loglout');?></li>
	<li class='<?php echo Arr::get($subnav, "check_account" ); ?>'><?php echo Html::anchor('auth/check_account','Check account');?></li>
	<li class='<?php echo Arr::get($subnav, "check_login" ); ?>'><?php echo Html::anchor('auth/check_login','Check login');?></li>

</ul>
<p>Loglout</p>