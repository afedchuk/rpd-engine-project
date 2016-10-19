<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Deliverable Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $artifact_name
 * @property string $type
 * @property int $asset_id
 * @property \App\Model\Entity\Asset $asset
 * @property int $del_route_name_id
 * @property \App\Model\Entity\DelRouteName $del_route_name
 * @property int $artifact_id
 * @property string $status
 * @property int $delivery_id
 * @property int $deliverable_id
 * @property int $gmt_created
 * @property int $locked
 * @property int $frozen
 * @property int $cloaked
 * @property \App\Model\Entity\Artifact[] $artifacts
 * @property \App\Model\Entity\Delivery[] $deliveries
 * @property \App\Model\Entity\Deliverable[] $deliverables
 * @property \App\Model\Entity\DeliverableRole[] $deliverable_roles
 * @property \App\Model\Entity\Solid[] $solids
 */
class Deliverable extends Entity
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
