<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Engine Entity.
 *
 * @property int $id
 * @property string $hostname
 * @property int $pid
 * @property int $port
 * @property int $gmt_created
 * @property int $gmt_expires
 * @property int $count
 * @property string $activity
 * @property string $control
 * @property string $host_session_key
 * @property \App\Model\Entity\BuildCheckout[] $build_checkouts
 * @property \App\Model\Entity\Delivery[] $deliveries
 * @property \App\Model\Entity\Process[] $processes
 * @property \App\Model\Entity\Solid[] $solids
 * @property \App\Model\Entity\Task[] $tasks
 */
class Engine extends Entity
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
