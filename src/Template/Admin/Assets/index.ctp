<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $assets
 */

$this->extend('Cirici/AdminLTE./Common/index');

$this->Breadcrumbs
    ->add(__d('funayaki', 'Assets'), ['action' => 'index']);

$this->start('page-numbers');
echo $this->Paginator->numbers();
$this->end();

$this->append('header-actions');
echo $this->Html->link(__d('funayaki', 'New Asset'),
    ['action' => 'add'],
    ['class' => 'btn btn-default pull-right']
);
$this->end();
?>

<?php $this->start('table-header'); ?>
<thead>
<tr>
    <th><?= $this->Paginator->sort('id') ?></th>
    <th><?= $this->Paginator->sort('file_name') ?></th>
    <th><?= $this->Paginator->sort('file_type') ?></th>
    <th><?= $this->Paginator->sort('file_size') ?></th>
    <th><?= $this->Paginator->sort('modified') ?></th>
    <th><?= $this->Paginator->sort('created') ?></th>
    <th><?= __('Actions') ?></th>
</tr>
</thead>
<?php $this->end(); ?>

<?php $this->start('table-body'); ?>
<tbody>
<?php foreach ($assets as $asset): ?>
    <tr>
        <td><?= $this->Number->format($asset->id) ?></td>
        <td><?= h($asset->file_name) ?></td>
        <td><?= h($asset->file_type) ?></td>
        <td><?= $this->Number->format($asset->file_size) ?></td>
        <td><?= h($asset->modified) ?></td>
        <td><?= h($asset->created) ?></td>
        <td class="actions" style="white-space:nowrap">
            <?= $this->Html->link(__d('funayaki', 'Edit'), ['action' => 'edit', $asset->id], ['class' => 'btn btn-default btn-xs']) ?>
            <?= $this->Form->postLink(__d('funayaki', 'Delete'), ['action' => 'delete', $asset->id], ['confirm' => __('Are you sure you want to delete # {0}?', $asset->id), 'class' => 'btn btn-danger btn-xs']) ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
<?php $this->end(); ?>
