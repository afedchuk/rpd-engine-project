<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * DelEnv Entity.
 *
 * @property int $id
 * @property string $name
 * @property int $notification_template_id
 * @property \App\Model\Entity\NotificationTemplate $notification_template
 * @property int $init_def_process_id
 * @property \App\Model\Entity\InitDefProcess $init_def_process
 * @property int $success_def_process_id
 * @property \App\Model\Entity\SuccessDefProcess $success_def_process
 * @property int $failure_def_process_id
 * @property \App\Model\Entity\FailureDefProcess $failure_def_process
 * @property int $drift_def_process_id
 * @property \App\Model\Entity\DriftDefProcess $drift_def_process
 * @property int $drift_execs_failure
 * @property int $delivery_id
 * @property int $group_id
 * @property \App\Model\Entity\Group $group
 * @property int $protected
 * @property string $content
 * @property \App\Model\Entity\Delivery[] $deliveries
 * @property \App\Model\Entity\DelEnvChannel[] $del_env_channels
 * @property \App\Model\Entity\DelEnvPool[] $del_env_pools
 * @property \App\Model\Entity\DelEnvProperty[] $del_env_properties
 * @property \App\Model\Entity\DelEnvRole[] $del_env_roles
 * @property \App\Model\Entity\DelEnvSignoff[] $del_env_signoffs
 * @property \App\Model\Entity\DelRoute[] $del_routes
 * @property \App\Model\Entity\DeliveryPreview[] $delivery_previews
 * @property \App\Model\Entity\SpinPreview[] $spin_previews
 */
class DelEnv extends Entity
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
