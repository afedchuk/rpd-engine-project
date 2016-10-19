<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliverableRole Entity
 *
 * @property int $id
 * @property int $deliverable_id
 * @property int $role_id
 *
 * @property \DBModel\Model\Entity\Deliverable $deliverable
 * @property \DBModel\Model\Entity\Role $role
 */
class DeliverableRole extends Entity
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
