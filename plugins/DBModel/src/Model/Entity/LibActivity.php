<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * LibActivity Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $connectivity
 * @property string $needs_channel
 * @property \DBModel\Model\Entity\Activity[] $activities
 * @property \DBModel\Model\Entity\DefActivity[] $def_activities
 * @property \DBModel\Model\Entity\LibTask[] $lib_tasks
 */
class LibActivity extends Entity
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
