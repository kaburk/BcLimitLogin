<?php echo $this->BcForm->create('BcLimitLogin', ['url' => ['action' => 'index']]) ?>
<p class="bca-search__input-list">
	<span class="bca-search__input-item">
		<?php
		echo $this->BcForm->label(
			'user_id',
			__d('baser', 'ユーザー'),
			[
				'class' => 'bca-search__input-item-label',
			]
		);
		echo $this->BcForm->input(
			'user_id',
			[
				'type' => 'select',
				'options' => $users,
				'empty' => __d('baser', '指定なし'),
			]
		);
		?>
	</span>
	<span class="bca-search__input-item">
		<?php
		echo $this->BcForm->label(
			'login_status',
			__d('baser', 'ログイン状態'),
			[
				'class' => 'bca-search__input-item-label',
			]
		);
		echo $this->BcForm->input(
			'login_status',
			[
				'type' => 'select',
				'options' => $loginStatus,
				'empty' => __d('baser', '指定なし'),
			]
		);
		?>
	</span>
	<span class="bca-search__input-item">
		<?php
		echo $this->BcForm->label(
			'search_text',
			__d('baser', 'IPアドレス、ユーザーエージェント'),
			[
				'class' => 'bca-search__input-item-label',
			]
		);
		echo $this->BcForm->input(
			'search_text',
			[
				'type' => 'text',
				'size' => '30',
				'class' => 'bca-textbox__input',
			]
		);
		?>
	</span>

	<?php echo $this->BcSearchBox->dispatchShowField() ?>
</p>
<div class="submit button bca-search__btns">
	<div class="bca-search__btns-item">
		<?php
		$this->BcBaser->link(
			__d('baser', '検索'),
			"javascript:void(0)",
			[
				'id' => 'BtnSearchSubmit',
				'class' => 'button bca-btn bca-btn-lg',
				'data-bca-btn-size' => 'lg',
			]
		);
		?>
	</div>
	<div class="bca-search__btns-item">
		<?php
		$this->BcBaser->link(
			__d('baser', 'クリア'),
			"javascript:void(0)",
			[
				'id' => 'BtnSearchClear',
				'class' => 'button bca-btn',
			]
		);
		?>
	</div>
</div>
<?php echo $this->Form->end() ?>
