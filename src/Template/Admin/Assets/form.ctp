<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $asset
 */

$this->extend('Cirici/AdminLTE./Common/form');

$this->Breadcrumbs
    ->add(__d('funayaki', 'Assets'), ['action' => 'index'])
    ->add(__d('funayaki', 'Add'), $this->request->getRequestTarget());

$this->assign('form-start', $this->Form->create($asset, [
    'type' => 'file',
    'novalidate' => true,
]));

$this->start('form-content');
echo $this->Form->control('file_name', [
    'type' => 'file',
]);
$this->end();

$this->start('form-button');
echo $this->Form->button(__d('funayaki', 'Submit'));
$this->end();

$this->assign('form-end', $this->Form->end());
