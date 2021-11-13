<?php
$this->BcBaser->js([
	'admin/libs/jquery.baser_ajax_data_list',
	'admin/libs/jquery.baser_ajax_batch',
	'admin/libs/baser_ajax_data_list_config',
	'admin/libs/baser_ajax_batch_config'
]);
?>

<script type="text/javascript">
	$(document).ready(function() {
		$.baserAjaxDataList.init();
		$.baserAjaxBatch.init({
			url: $("#AjaxBatchUrl").html()
		});
	});
</script>

<div id="AjaxBatchUrl" hidden><?php $this->BcBaser->url(['action' => 'ajax_batch']) ?></div>
<div id="AlertMessage" class="message" hidden></div>
<div id="MessageBox" hidden>
	<div id="flashMessage" class="notice-message"></div>
</div>
<div id="DataList" class="bca-data-list"><?php $this->BcBaser->element('bc_limit_logins/index_list') ?></div>
