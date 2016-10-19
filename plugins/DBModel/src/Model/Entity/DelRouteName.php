<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * DelRouteName Entity
 *
 * @property int $id
 * @property string $name
 * @property string $type
 *
 * @property \DBModel\Model\Entity\DelRoute[] $del_routes
 * @property \DBModel\Model\Entity\Deliverable[] $deliverables
 */
class DelRouteName extends Entity
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
