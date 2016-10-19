<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Channel Entity.
 *
 * @property int $id
 * @property int $channel_type_id
 * @property \DBModel\Model\Entity\ChannelType $channel_type
 * @property int $owner_process_id
 * @property \DBModel\Model\Entity\OwnerProcess $owner_process
 * @property int $channel_rev_id
 * @property int $bridge_id
 * @property \DBModel\Model\Entity\Bridge $bridge
 * @property int $lb_id
 * @property \DBModel\Model\Entity\Lb $lb
 * @property int $channel_conf_id
 * @property \DBModel\Model\Entity\ChannelConf $channel_conf
 * @property int $channel_property_set_id
 * @property \DBModel\Model\Entity\ChannelPropertySet $channel_property_set
 * @property string $content
 * @property string $drift_rules
 * @property \DBModel\Model\Entity\ChannelRev[] $channel_revs
 * @property \DBModel\Model\Entity\ArtifactFeed[] $artifact_feeds
 * @property \DBModel\Model\Entity\BuildCheckout[] $build_checkouts
 * @property \DBModel\Model\Entity\ChannelProcess[] $channel_processes
 * @property \DBModel\Model\Entity\ChannelRole[] $channel_roles
 * @property \DBModel\Model\Entity\DelEnvChannel[] $del_env_channels
 * @property \DBModel\Model\Entity\DelEnvPoolChannel[] $del_env_pool_channels
 * @property \DBModel\Model\Entity\DeliveryChannel[] $delivery_channels
 * @property \DBModel\Model\Entity\DeliveryProcess[] $delivery_processes
 */
class Channel extends Entity
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
