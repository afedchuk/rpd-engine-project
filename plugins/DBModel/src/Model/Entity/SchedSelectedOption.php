<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * SchedSelectedOption Entity.
 *
 * @property int $id
 * @property int $sched_id
 * @property \DBModel\Model\Entity\Sched $sched
 * @property string $type
 * @property int $option_id
 * @property \DBModel\Model\Entity\Option $option
 */
class SchedSelectedOption extends Entity
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
