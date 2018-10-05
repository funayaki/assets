<?php
namespace Assets\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Filesystem\Folder;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Josegonzalez\Upload\File\Path\ProcessorInterface;

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
class AssetsTable extends Table implements DuplicateAwareInterface
{

    const FIELD_NAME = 'file_name';

    /**
     * @var
     */
    protected $_basepath;

    /**
     * @var
     */
    protected $_pathProcessor;

    /**
     * @var
     */
    protected $_foreign_key;

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
            self::FIELD_NAME => [
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

        // add Duplicatable behavior
        $this->addBehavior('Duplicatable.Duplicatable', [
            'finder' => 'all',
            'remove' => ['created', 'modified', 'created_by', 'modified_by'],
            'set' => [
                'dir' => function ($entity) {
                    return $this->_getBasepath();
                },
                'foreign_key' => function ($entity) {
                    return $this->getForeignKey();
                }
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
     * @param \Cake\Event\Event $event
     * @param \Cake\Datasource\EntityInterface $entity
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
     * @param \Cake\Datasource\EntityInterface $entity
     * @param null $foreignKey
     * @return \Cake\Datasource\EntityInterface
     * @throws \Exception
     */
    public function duplicate(EntityInterface $entity, $foreignKey = null)
    {
        $this->_foreign_key = $foreignKey;

        $uploadSettings = $this->behaviors()->get('Upload')->getConfig(self::FIELD_NAME);
        $pathProcessor = $this->getPathProcessor($entity, [], self::FIELD_NAME, $uploadSettings);
        $basepath = $this->_getBasepath($pathProcessor);

        $source = $entity->file;
        if (!$source->exists()) {
            throw new \Exception('The file could not be found');
        }

        // TODO Duplicate just the file instead of duplicating the folder
        if ($source->folder()->copy(ROOT . DS . $basepath)
            && $this->behaviors()->unload('Upload') // Prevent entity from unsetting file_name by UploadBehavior
            && $newEntity = $this->behaviors()->get('Duplicatable')->duplicate($entity->id)
        ) {
            return $newEntity;
        }

        throw new \Exception();
    }

    /**
     * @param \Josegonzalez\Upload\File\Path\ProcessorInterface $pathProcessor
     * @return string
     */
    protected function _getBasepath(ProcessorInterface $pathProcessor = null)
    {
        if ($this->_basepath === null) {
            $this->_basepath = $pathProcessor->basepath();
        }

        return $this->_basepath;
    }

    public function getForeignKey()
    {
        return $this->_foreign_key;
    }
}
