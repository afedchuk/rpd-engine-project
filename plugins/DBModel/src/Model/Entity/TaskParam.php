<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * TaskParam Entity.
 *
 * @property int $id
 * @property int $sequence
 * @property int $task_id
 * @property \DBModel\Model\Entity\Task $task
 * @property int $activity_id
 * @property \DBModel\Model\Entity\Activity $activity
 * @property string $occurance
 * @property string $type
 * @property string $correlation
 * @property string $name
 * @property string $optional
 * @property string $description
 * @property string $separator
 * @property string $modifiable
 * @property string $explode
 * @property \DBModel\Model\Entity\TaskParamDefault[] $task_param_defaults
 * @property \DBModel\Model\Entity\TaskParamOpt[] $task_param_opts
 */
class TaskParam extends Entity
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
