<?php
$this->BcBaser->css([
	'BcLimitLogin.admin/style',
]);
?>
<?php echo $this->BcFormTable->dispatchBefore() ?>

<section class="bca-section">
	<table id="FormTable" class="form-table bca-form-table">
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.id', __d('baser', 'No')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php echo $this->BcForm->value('BcLimitLogin.id') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.key', __d('baser', 'セッションID')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php echo $this->BcForm->value('BcLimitLogin.key') ?>
			</td>
		</tr>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.user_id', __d('baser', 'ユーザー')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php if (isset($users[$this->BcForm->value('BcLimitLogin.user_id')])) : ?>
					<?php echo h($users[$this->BcForm->value('BcLimitLogin.user_id')]) ?>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.status', __d('baser', 'ログイン状態')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php if (isset($loginStatus[$this->BcForm->value('BcLimitLogin.login_status')])) : ?>
					<?php echo h($loginStatus[$this->BcForm->value('BcLimitLogin.login_status')]) ?>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.ip_address', __d('baser', 'IPアドレス')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php echo $this->BcForm->value('BcLimitLogin.ip_address'); ?>
			</td>
		</tr>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.user_agent', __d('baser', 'ユーザーエージェント')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php echo $this->BcForm->value('BcLimitLogin.user_agent'); ?>
			</td>
		</tr>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.referer', __d('baser', 'リファラ')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php echo $this->BcForm->value('BcLimitLogin.referer'); ?>
			</td>
		</tr>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.login_data', __d('baser', 'ログイン時詳細データ')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<pre class="plain-text">
				<?php echo $this->BcForm->value('BcLimitLogin.login_data'); ?>
				</pre>
			</td>
		</tr>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.created', __d('baser', '作成日')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php echo $this->BcTime->format('Y-m-d H:i:s', $this->BcForm->value('BcLimitLogin.created')); ?>
			</td>
		</tr>
		<tr>
			<th class="col-head bca-form-table__label">
				<?php echo $this->BcForm->label('BcLimitLogin.modified', __d('baser', '更新日')) ?>
			</th>
			<td class="col-input bca-form-table__input">
				<?php echo $this->BcTime->format('Y-m-d H:i:s', $this->BcForm->value('BcLimitLogin.modified')); ?>
			</td>
		</tr>
		<?php echo $this->BcForm->dispatchAfterForm() ?>
	</table>
</section>

<?php echo $this->BcFormTable->dispatchAfter() ?>

<section class="submit bca-actions">
	<div class="bca-actions__main">
		<?php
		$this->BcBaser->link(
			__d('baser', '一覧に戻る'),
			[
				'action' => 'index',
			],
			[
				'class' => 'button bca-btn bca-actions__item',
			]
		);
		?>
	</div>
</section>

<?php echo $this->BcForm->end() ?>
