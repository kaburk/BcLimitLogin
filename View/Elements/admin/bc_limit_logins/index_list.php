<?php
$this->BcListTable->setColumnNumber(9);
?>

<div class="bca-data-list__top">
	<!-- 一括処理 -->
	<?php if ($this->BcBaser->isAdminUser()) : ?>
		<div>
			<?php
			echo $this->BcForm->input(
				'ListTool.batch',
				[
					'type' => 'select',
					'options' => [
						'del' => __d('baser', '削除'),
					],
					'empty' => __d('baser', '一括処理'),
					'data-bca-select-size' => 'lg',
				]
			);
			echo $this->BcForm->button(
				__d('baser', '適用'),
				[
					'id' => 'BtnApplyBatch',
					'disabled' => 'disabled',
					'class' => 'bca-btn',
					'data-bca-btn-size' => 'lg',
				]
			);
			?>
		</div>
	<?php endif ?>
	<div class="bca-data-list__sub">
		<!-- pagination -->
		<?php $this->BcBaser->element('pagination') ?>
	</div>
</div>

<!-- list -->
<table class="list-table bca-table-listup" id="ListTable">
	<thead class="bca-table-listup__thead">
		<tr>
			<th class="list-tool bca-table-listup__thead-th  bca-table-listup__thead-th--select">
				<?php echo $this->BcForm->input('ListTool.checkall', ['type' => 'checkbox', 'label' => __d('baser', '&nbsp;')]) ?>
			</th>
			<th class="bca-table-listup__thead-th">
				<?php
				echo $this->Paginator->sort(
					'id',
					[
						'asc' => '<i class="bca-icon--asc"></i>' . __d('baser', 'No'),
						'desc' => '<i class="bca-icon--desc"></i>' . __d('baser', 'No')
					],
					[
						'escape' => false,
						'class' => 'btn-direction bca-table-listup__a'
					]
				);
				?>
			</th>
			<th class="bca-table-listup__thead-th">
				<?php
				echo $this->Paginator->sort(
					'user_id',
					[
						'asc' => '<i class="bca-icon--asc"></i>' . __d('baser', 'ユーザー'),
						'desc' => '<i class="bca-icon--desc"></i>' . __d('baser', 'ユーザー')
					],
					[
						'escape' => false,
						'class' => 'btn-direction bca-table-listup__a'
					]
				);
				?>
			</th>
			<th class="bca-table-listup__thead-th">
				<?php
				echo $this->Paginator->sort(
					'login_status',
					[
						'asc' => '<i class="bca-icon--asc"></i>' . __d('baser', 'ログイン状態'),
						'desc' => '<i class="bca-icon--desc"></i>' . __d('baser', 'ログイン状態')
					],
					[
						'escape' => false,
						'class' => 'btn-direction bca-table-listup__a'
					]
				);
				?>
			</th>
			<th class="bca-table-listup__thead-th">
				<?php
				echo $this->Paginator->sort(
					'ip_address',
					[
						'asc' => '<i class="bca-icon--asc"></i>' . __d('baser', 'IPアドレス'),
						'desc' => '<i class="bca-icon--desc"></i>' . __d('baser', 'IPアドレス'),
					],
					[
						'escape' => false,
						'class' => 'btn-direction bca-table-listup__a',
					]
				);
				?>
			</th>
			<th class="bca-table-listup__thead-th">
				<?php
				echo $this->Paginator->sort(
					'user_agent',
					[
						'asc' => '<i class="bca-icon--asc"></i>' . __d('baser', 'ユーザーエージェント'),
						'desc' => '<i class="bca-icon--desc"></i>' . __d('baser', 'ユーザーエージェント'),
					],
					[
						'escape' => false,
						'class' => 'btn-direction bca-table-listup__a',
					]
				);
				?>
			</th>

			<?php echo $this->BcListTable->dispatchShowHead() ?>

			<th class="bca-table-listup__thead-th">
				<?php
				echo $this->Paginator->sort(
					'created',
					[
						'asc' => '<i class="bca-icon--asc"></i>' . __d('baser', '登録日時'),
						'desc' => '<i class="bca-icon--desc"></i>' . __d('baser', '登録日時'),
					],
					[
						'escape' => false,
						'class' => 'btn-direction bca-table-listup__a',
					]
				);
				?><br>
				<?php
				echo $this->Paginator->sort(
					'modified',
					[
						'asc' => '<i class="bca-icon--asc"></i>' . __d('baser', '更新日時'),
						'desc' => '<i class="bca-icon--desc"></i>' . __d('baser', '更新日時'),
					],
					[
						'escape' => false,
						'class' => 'btn-direction bca-table-listup__a',
					]
				);
				?>
			</th>
			<th class="bca-table-listup__thead-th">
				<?php echo __d('baser', 'アクション') ?>
			</th>
		</tr>
	</thead>
	<tbody class="bca-table-listup__tbody">
		<?php
		if (!empty($posts)) :
			foreach ($posts as $data) :
				$this->BcBaser->element('bc_limit_logins/index_row', ['data' => $data]);
			endforeach;
		else :
		?>
			<tr>
				<td colspan="<?php echo $this->BcListTable->getColumnNumber() ?>" class="bca-table-listup__tbody-td">
					<p class="no-data">
						<?php echo __d('baser', 'データが見つかりませんでした。') ?>
					</p>
				</td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

<div class="bca-data-list__bottom">
	<div class="bca-data-list__sub">
		<!-- pagination -->
		<?php $this->BcBaser->element('pagination') ?>
		<!-- list-num -->
		<?php $this->BcBaser->element('list_num') ?>
	</div>
</div>
