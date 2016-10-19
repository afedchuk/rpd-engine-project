<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * ActivityDepend Entity.
 *
 * @property int $id
 * @property int $activity_id
 * @property \App\Model\Entity\Activity $activity
 * @property int $def_depend_id
 * @property \App\Model\Entity\DefDepend $def_depend
 * @property string $type
 * @property int $scope
 * @property int $count
 */
class ActivityDepend extends Entity
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