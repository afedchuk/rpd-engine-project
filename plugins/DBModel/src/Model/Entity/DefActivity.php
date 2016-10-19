<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * DefActivity Entity
 *
 * @property int $id
 * @property string $name
 * @property string $active
 * @property int $def_process_id
 * @property int $lib_activity_id
 * @property int $activity_timeout
 *
 * @property \DBModel\Model\Entity\DefProcess $def_process
 * @property \DBModel\Model\Entity\LibActivity $lib_activity
 * @property \DBModel\Model\Entity\Activity[] $activities
 * @property \DBModel\Model\Entity\DefActivityDepend[] $def_activity_depends
 * @property \DBModel\Model\Entity\DefTaskParamDefault[] $def_task_param_defaults
 * @property \DBModel\Model\Entity\DefTaskParam[] $def_task_params
 */
class DefActivity extends Entity
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
        'id' => false
    ];
}
