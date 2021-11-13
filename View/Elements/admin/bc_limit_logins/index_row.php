<tr>
	<td class="bca-table-listup__tbody-td bca-table-listup__tbody-td--select">
		<?php // 選択
		?>
		<?php if ($this->BcBaser->isAdminUser()) : ?>
			<?php
			echo $this->BcForm->input(
				'ListTool.batch_targets.' . $data['BcLimitLogin']['id'],
				[
					'type' => 'checkbox',
					'label' => '<span class="bca-visually-hidden">' . __d('baser', 'チェックする') . '</span>',
					'class' => 'batch-targets bca-checkbox__input',
					'value' => $data['BcLimitLogin']['id'],
				]
			);
			?>
		<?php endif ?>
	</td>
	<td class="bca-table-listup__tbody-td bca-table-listup__tbody-td--id">
		<?php echo $data['BcLimitLogin']['id']; ?>
	</td>
	<td class="bca-table-listup__tbody-td bca-table-listup__tbody-td--user_id">
		<?php if (!empty($users[$data['BcLimitLogin']['user_id']])) : ?>
			<?php echo h($users[$data['BcLimitLogin']['user_id']]) ?>
		<?php endif; ?>
	</td>
	<td class="bca-table-listup__tbody-td bca-table-listup__tbody-td--login_status">
		<?php if (!empty($loginStatus[$data['BcLimitLogin']['login_status']])) : ?>
			<?php echo h($loginStatus[$data['BcLimitLogin']['login_status']]) ?>
		<?php endif; ?>
	</td>
	<td class="bca-table-listup__tbody-td bca-table-listup__tbody-td--ip_address">
		<?php echo $data['BcLimitLogin']['ip_address']; ?>
	</td>
	<td class="bca-table-listup__tbody-td bca-table-listup__tbody-td--user_agent">
		<?php echo $data['BcLimitLogin']['user_agent']; ?>
	</td>
	<td class="bca-table-listup__tbody-td bca-table-listup__tbody-td--date">
		<?php echo $this->BcTime->format('Y-m-d H:i:s', $data['BcLimitLogin']['created']) ?><br />
		<?php echo $this->BcTime->format('Y-m-d H:i:s', $data['BcLimitLogin']['modified']) ?>
	</td>

	<?php echo $this->BcListTable->dispatchShowRow($data) ?>

	<td class="bca-table-listup__tbody-td bca-table-listup__tbody-td--actions">
		<?php
		$this->BcBaser->link(
			'',
			[
				'action' => 'view',
				$data['BcLimitLogin']['id'],
			],
			[
				'title' => __d('baser', '詳細'),
				'class' => ' bca-btn-icon',
				'data-bca-btn-type' => 'preview',
				'data-bca-btn-size' => 'lg',
			]
		);
		echo '&nbsp;&nbsp;';
		$this->BcBaser->link(
			'',
			[
				'action' => 'ajax_delete',
				$data['BcLimitLogin']['id'],
			],
			[
				'title' => __d('baser', '削除'),
				'class' => 'btn-delete bca-btn-icon',
				'data-bca-btn-type' => 'delete',
				'data-bca-btn-size' => 'lg',
			]
		);
		?>
	</td>
</tr>
