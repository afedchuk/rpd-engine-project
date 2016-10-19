<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Activity Entity.
 *
 * @property int $id
 * @property string $name
 * @property int $process_id
 * @property \DBModel\Model\Entity\Process $process
 * @property int $def_activity_id
 * @property \DBModel\Model\Entity\DefActivity $def_activity
 * @property int $lib_activity_id
 * @property \DBModel\Model\Entity\LibActivity $lib_activity
 * @property string $flag
 * @property int $gmt_start
 * @property int $duration
 * @property int $activity_timeout
 * @property \DBModel\Model\Entity\ActivityDepend[] $activity_depends
 * @property \DBModel\Model\Entity\TaskParam[] $task_params
 * @property \DBModel\Model\Entity\Task[] $tasks
 */
class Activity extends Entity
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
