<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchedUriAssetProp Entity.
 *
 * @property int $id
 * @property int $sched_id
 * @property \DBModel\Model\Entity\Sched $sched
 * @property int $property_type
 * @property string $name
 * @property string $value
 * @property int $property_id
 * @property \DBModel\Model\Entity\Property $property
 */
class SchedUriAssetProp extends Entity
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
