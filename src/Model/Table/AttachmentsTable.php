<?php
namespace Attachments\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Attachments Model
 *
 * @method \Attachments\Model\Entity\Attachment get($primaryKey, $options = [])
 * @method \Attachments\Model\Entity\Attachment newEntity($data = null, array $options = [])
 * @method \Attachments\Model\Entity\Attachment[] newEntities(array $data, array $options = [])
 * @method \Attachments\Model\Entity\Attachment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Attachments\Model\Entity\Attachment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Attachments\Model\Entity\Attachment[] patchEntities($entities, array $data, array $options = [])
 * @method \Attachments\Model\Entity\Attachment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AttachmentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('attachments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            // You can configure as many upload fields as possible,
            // where the pattern is `field` => `config`
            //
            // Keep in mind that while this plugin does not have any limits in terms of
            // number of files uploaded per request, you should keep this down in order
            // to decrease the ability of your users to block other requests.
            'file_name' => [
                'deleteCallback' => function ($path, $entity, $field, $settings) {
                    // When deleting the entity, the original will be removed
                    // when keepFilesOnDelete is set to false
                    return [
                        $path . $entity->{$field},
                    ];
                },
                'keepFilesOnDelete' => false
            ]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('model')
            ->maxLength('model', 50)
            ->allowEmpty('model');

        $validator
            ->integer('foreign_key')
            ->allowEmpty('foreign_key');

        $validator
            ->maxLength('file_name', 100)
            ->requirePresence('file_name', 'create')
            ->notEmpty('file_name');

        $validator
            ->scalar('dir')
            ->maxLength('dir', 50);

        $validator
            ->scalar('type')
            ->maxLength('type', 50);

        $validator
            ->integer('size');

        $validator
            ->boolean('active');

        $validator
            ->scalar('params')
            ->allowEmpty('params');

        return $validator;
    }
}
