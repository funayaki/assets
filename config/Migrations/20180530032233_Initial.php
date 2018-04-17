<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {

        $this->table('assets')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('model', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => true,
            ])
            ->addColumn('foreign_key', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('file_name', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('dir', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('file_type', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('file_size', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('viewable', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('params', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created_by', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('modified_by', 'integer', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addIndex(
                [
                    'model',
                    'foreign_key',
                ]
            )
            ->addIndex(
                [
                    'created_by',
                ]
            )
            ->addIndex(
                [
                    'modified_by',
                ]
            )
            ->create();
    }

    public function down()
    {
        $this->dropTable('assets');
    }
}
