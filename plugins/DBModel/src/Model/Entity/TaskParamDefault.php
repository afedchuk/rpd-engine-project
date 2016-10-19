<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * TaskParamDefault Entity.
 *
 * @property int $id
 * @property int $task_param_id
 * @property \DBModel\Model\Entity\TaskParam $task_param
 * @property string $value
 */
class TaskParamDefault extends Entity
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
