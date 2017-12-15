<script>
    var latestVersion = <?= $latestVersion ?>;
</script>
<div class="container" >
    <div class="row col-md-12 header_top ">
        <h1 class="text-center">Cập nhật ứng dụng</h1>
        <hr>
    </div>
    <div class="row mb-10">
        <div class="col-md-3">
            <?php if($hasInternet){ ?>
                <button class="btn btn-primary col-md-12"><span class="glyphicon glyphicon-ok mr-10"></span>Có kết nối internet</button>
            <?php } else { ?>
                <button class="btn btn-warning col-md-12"><span class="glyphicon glyphicon-remove mr-10"></span>Chưa kết nối internet</button>
            <?php } ?>
        </div>
    </div>
    <div class="row mb-10">
        <div class="col-md-3">
            <button class="btn btn-primary col-md-12">Version hiện tại : <?= $currentVersion ?></button>
        </div>
        <?php if($displayUpdateButton){ ?>
            <div class="col-md-3">
                <button class="btn btn-primary col-md-12">Version mới nhất : <?= $latestVersion ?></button>
            </div>
        <?php } ?>
    </div>
    <div class="row mb-10">
        <?php if($displayUpdateButton){ ?>
            <div class="col-md-3">
                <button class="btn btn-primary col-md-12" onclick="callUpdateCodeFromGithub()">Cập nhật</button>
            </div>
		<?php } else { ?>
			<div class="col-md-3">
				<button class="btn btn-primary col-md-12" onclick="callUpdateCodeFromGithub()">Refresh code</button>
			</div>
		<?php } ?>
    </div>
</div>