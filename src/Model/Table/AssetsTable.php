<?php
namespace Assets\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Assets Model
 *
 * @method \Assets\Model\Entity\Asset get($primaryKey, $options = [])
 * @method \Assets\Model\Entity\Asset newEntity($data = null, array $options = [])
 * @method \Assets\Model\Entity\Asset[] newEntities(array $data, array $options = [])
 * @method \Assets\Model\Entity\Asset|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Assets\Model\Entity\Asset patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Assets\Model\Entity\Asset[] patchEntities($entities, array $data, array $options = [])
 * @method \Assets\Model\Entity\Asset findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssetsTable extends Table
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

        $this->setTable('assets');
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
                'keepFilesOnDelete' => false,
                'fields' => [
                    'size' => 'file_size',
                    'type' => 'file_type',
                ],
                'path' => 'webroot{DS}files{DS}{model}{DS}{field}{DS}{microtime}{DS}',
            ],
        ]);

        $this->addBehavior('Utility.ModelMarker');
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
            ->maxLength('dir', 100);

        $validator
            ->scalar('file_type')
            ->maxLength('file_type', 50);

        $validator
            ->integer('file_size');

        $validator
            ->boolean('active');

        $validator
            ->scalar('params')
            ->allowEmpty('params');

        return $validator;
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!$entity->isNew()) {
            $folder = new Folder(ROOT . DS . $entity->getOriginal('dir'));
            $folder->delete();
        }
    }

    /**
     * Return file
     *
     * @param $id
     * @return \Cake\Filesystem\File
     */
    public function getFile($id)
    {
        $asset = $this->get($id);
        return new File(ROOT . DS . $asset->dir . $asset->file_name);
    }
}
