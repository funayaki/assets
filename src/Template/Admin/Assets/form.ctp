<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $asset
 */

$this->extend('Cirici/AdminLTE./Common/form');

$this->Breadcrumbs
    ->add(__d('localized', 'Assets'), ['action' => 'index']);

if ($this->request->params['action'] == 'edit') {
    $this->Breadcrumbs->add(__d('localized', 'Edit'), $this->request->getRequestTarget());
}

if ($this->request->params['action'] == 'add') {
    $this->Breadcrumbs->add(__d('localized', 'Add'), $this->request->getRequestTarget());
}

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
echo $this->Form->button(__d('localized', 'Upload'));
$this->end();

$this->assign('form-end', $this->Form->end());
