<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity.
 *
 * @property int $id
 * @property string $name
 * @property int $activity_id
 * @property \DBModel\Model\Entity\Activity $activity
 * @property int $lib_task_id
 * @property \DBModel\Model\Entity\LibTask $lib_task
 * @property int $engine_id
 * @property \DBModel\Model\Entity\Engine $engine
 * @property int $channel_rev_id
 * @property \DBModel\Model\Entity\ChannelRev $channel_rev
 * @property string $explode_type
 * @property string $module
 * @property string $flag
 * @property int $gmt_start
 * @property int $duration
 * @property int $bridge_id
 * @property \DBModel\Model\Entity\Bridge $bridge
 * @property \DBModel\Model\Entity\TaskDepend[] $task_depends
 * @property \DBModel\Model\Entity\TaskFeed[] $task_feeds
 * @property \DBModel\Model\Entity\TaskParam[] $task_params
 */
class Task extends Entity
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
