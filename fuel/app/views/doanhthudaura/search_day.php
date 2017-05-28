<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('doanhthudaura/index','Index');?></li>
	<li class='<?php echo Arr::get($subnav, "search_day" ); ?>'><?php echo Html::anchor('doanhthudaura/search_day','Search day');?></li>
	<li class='<?php echo Arr::get($subnav, "search_month" ); ?>'><?php echo Html::anchor('doanhthudaura/search_month','Search month');?></li>
	<li class='<?php echo Arr::get($subnav, "search_year" ); ?>'><?php echo Html::anchor('doanhthudaura/search_year','Search year');?></li>
	<li class='<?php echo Arr::get($subnav, "print" ); ?>'><?php echo Html::anchor('doanhthudaura/print','Print');?></li>

</ul>
<p>Search day</p>