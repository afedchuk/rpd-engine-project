<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Event Entity.
 *
 * @property int $module_id
 * @property \DBModel\Model\Entity\Module $module
 * @property int $id
 * @property int $user_id
 * @property \DBModel\Model\Entity\User $user
 * @property string $source
 * @property int $gmt_created
 * @property \DBModel\Model\Entity\Api[] $api
 * @property \DBModel\Model\Entity\Oddit[] $oddits
 */
class Event extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
