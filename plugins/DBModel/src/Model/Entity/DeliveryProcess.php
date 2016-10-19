<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliveryProcess Entity.
 *
 * @property string $paths
 * @property string $status
 * @property string $pattern
 * @property int $provision_process_id
 * @property \DBModel\Model\Entity\ProvisionProcess $provision_process
 * @property int $process_id
 * @property \DBModel\Model\Entity\Process $process
 * @property int $channel_id
 * @property \DBModel\Model\Entity\Channel $channel
 * @property int $handler_id
 * @property \DBModel\Model\Entity\Handler $handler
 * @property int $solid_id
 * @property \DBModel\Model\Entity\Solid $solid
 * @property int $delivery_id
 * @property \DBModel\Model\Entity\Delivery $delivery
 * @property int $id
 */
class DeliveryProcess extends Entity
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
