<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Delivery Entity
 *
 * @property int $id
 * @property int $deliverable_id
 * @property int $user_id
 * @property string $type
 * @property int $del_env_id
 * @property string $action
 * @property int $delivery_id
 * @property int $gmt_created
 * @property int $pre_process_id
 * @property int $post_process_id
 * @property int $vm_process_id
 * @property int $engine_id
 * @property string $status
 * @property string $pause_after
 * @property int $gmt_start
 * @property int $duration
 * @property int $active_pool_id
 * @property string $target_pool
 * @property int $drift_execs_failure
 *
 * @property \DBModel\Model\Entity\Deliverable[] $deliverables
 * @property \DBModel\Model\Entity\User $user
 * @property \DBModel\Model\Entity\DelEnv[] $del_envs
 * @property \DBModel\Model\Entity\Delivery[] $deliveries
 * @property \DBModel\Model\Entity\PreProcess $pre_process
 * @property \DBModel\Model\Entity\PostProcess $post_process
 * @property \DBModel\Model\Entity\VmProcess $vm_process
 * @property \DBModel\Model\Entity\Engine $engine
 * @property \DBModel\Model\Entity\ActivePool $active_pool
 * @property \DBModel\Model\Entity\DeliveryChannel[] $delivery_channels
 * @property \DBModel\Model\Entity\DeliveryProcess[] $delivery_processes
 * @property \DBModel\Model\Entity\DeliveryProperty[] $delivery_properties
 * @property \DBModel\Model\Entity\DeliveryRole[] $delivery_roles
 * @property \DBModel\Model\Entity\DeliverySignoff[] $delivery_signoffs
 * @property \DBModel\Model\Entity\Solid[] $solids
 */
class Delivery extends Entity
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
