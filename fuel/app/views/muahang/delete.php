<ul class="nav nav-pills">
	<li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('muahang/index','Index');?></li>
	<li class='<?php echo Arr::get($subnav, "save" ); ?>'><?php echo Html::anchor('muahang/save','Save');?></li>
	<li class='<?php echo Arr::get($subnav, "print" ); ?>'><?php echo Html::anchor('muahang/print','Print');?></li>
	<li class='<?php echo Arr::get($subnav, "update" ); ?>'><?php echo Html::anchor('muahang/update','Update');?></li>
	<li class='<?php echo Arr::get($subnav, "delete" ); ?>'><?php echo Html::anchor('muahang/delete','Delete');?></li>

</ul>
<p>Delete</p>