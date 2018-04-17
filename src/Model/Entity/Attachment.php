<?php
namespace Attachments\Model\Entity;

use Cake\ORM\Entity;

/**
 * Attachment Entity
 *
 * @property int $id
 * @property string $model
 * @property int $foreign_key
 * @property $file_name
 * @property string $dir
 * @property string $type
 * @property int $size
 * @property bool $active
 * @property string $params
 * @property \Cake\I18n\FrozenTime $updated
 * @property \Cake\I18n\FrozenTime $created
 */
class Attachment extends Entity
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
        'type' => true,
        'size' => true,
        'active' => true,
        'params' => true,
        'updated' => true,
        'created' => true
    ];
}
