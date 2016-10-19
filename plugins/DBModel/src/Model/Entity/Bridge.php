<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bridge Entity.
 *
 * @property int $agent_writable
 * @property int $agent_up
 * @property string $agent_info
 * @property int $zone_id
 * @property \DBModel\Model\Entity\Zone $zone
 * @property int $vm_id
 * @property \DBModel\Model\Entity\Vm $vm
 * @property int $channel_type_id
 * @property \DBModel\Model\Entity\ChannelType $channel_type
 * @property string $remote_platform
 * @property string $platform
 * @property string $despatcher
 * @property string $hostname
 * @property int $id
 * @property \DBModel\Model\Entity\ArtifactFeed[] $artifact_feeds
 * @property \DBModel\Model\Entity\BridgeProperty[] $bridge_properties
 * @property \DBModel\Model\Entity\BridgeRole[] $bridge_roles
 * @property \DBModel\Model\Entity\ChannelRev[] $channel_revs
 * @property \DBModel\Model\Entity\Channel[] $channels
 * @property \DBModel\Model\Entity\Solid[] $solids
 * @property \DBModel\Model\Entity\Task[] $tasks
 * @property \DBModel\Model\Entity\Uri[] $uris
 */
class Bridge extends Entity
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
