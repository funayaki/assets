<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $assets
 */

$this->extend('Cirici/AdminLTE./Common/index');

$this->assign('title', __d('localized', 'Assets'));

$this->Breadcrumbs
    ->add(__d('localized', 'Assets'), ['action' => 'index']);

$this->start('page-numbers');
echo $this->Paginator->numbers();
$this->end();
?>

<?php $this->start('table-header'); ?>
<thead>
<tr>
    <th></th>
    <th><?= $this->Paginator->sort('file_name', __d('localized', 'File Name')) ?></th>
    <th><?= $this->Paginator->sort('file_type', __d('localized', 'File Type')) ?></th>
    <th><?= $this->Paginator->sort('file_size', __d('localized', 'File Size')) ?></th>
    <th><?= __d('localized', 'Actions') ?></th>
</tr>
</thead>
<?php $this->end(); ?>

<?php $this->start('table-body'); ?>
<tbody>
<?php foreach ($assets as $asset): ?>
    <tr>
        <td><?= $this->Html->image(\Cake\Routing\Router::url(['action' => 'download', $asset->id]), ['width' => 75]) ?></td>
        <td><?= h($asset->file_name) ?></td>
        <td><?= h($asset->file_type) ?></td>
        <td><?= $this->Number->toReadableSize($asset->file_size) ?></td>
        <td class="actions" style="white-space:nowrap">
            <?= $this->Html->link(__d('localized', 'Download'), ['action' => 'download', $asset->id], ['class' => 'btn btn-default btn-xs', 'target' => '_blank']) ?>
            <?= $this->Html->link(__d('localized', 'Edit'), ['action' => 'edit', $asset->id], ['class' => 'btn btn-default btn-xs']) ?>
            <?= $this->Form->postLink(__d('localized', 'Delete'), ['action' => 'delete', $asset->id], ['confirm' => __d('localized', 'Are you sure you want to delete # {0}?', $asset->id), 'class' => 'btn btn-danger btn-xs']) ?>
        </td>
    </tr>
<?php endforeach; ?>
</tbody>
<?php $this->end(); ?>
