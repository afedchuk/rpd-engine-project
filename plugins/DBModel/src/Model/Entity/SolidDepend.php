<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * SolidDepend Entity.
 *
 * @property int $id
 * @property int $solid_id
 * @property \DBModel\Model\Entity\Solid $solid
 * @property int $solid_depend_id
 * @property string $type
 * @property int $scope
 * @property int $count
 * @property \DBModel\Model\Entity\SolidDepend[] $solid_depends
 */
class SolidDepend extends Entity
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
