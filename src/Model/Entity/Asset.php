<?php
namespace Assets\Model\Entity;

use Cake\Filesystem\File;
use Cake\ORM\Entity;

/**
 * Asset Entity
 *
 * @property int $id
 * @property string $model
 * @property int $foreign_key
 * @property $file_name
 * @property string $dir
 * @property string $file_type
 * @property int $file_size
 * @property bool $active
 * @property string $params
 * @property \Cake\I18n\FrozenTime $modified
 * @property \Cake\I18n\FrozenTime $created
 * @property string $path
 * @property \Cake\Filesystem\File $file
 */
class Asset extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'model' => true,
        'foreign_key' => true,
        'file_name' => true,
        'dir' => true,
        'file_type' => true,
        'file_size' => true,
        'active' => true,
        'params' => true,
        'modified' => true,
        'created' => true
    ];

    /**
     * @return string
     */
    protected function _getPath()
    {
        return $this->_properties['dir'] . $this->_properties['file_name'];
    }

    /**
     * @return \Cake\Filesystem\File
     */
    public function _getFile()
    {
        return new File(ROOT . DS . $this->_getPath());
    }
}
