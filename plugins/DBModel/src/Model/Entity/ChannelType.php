<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChannelType Entity.
 *
 * @property int $id
 * @property string $name
 * @property int $process_id
 * @property \DBModel\Model\Entity\Process $process
 * @property int $failure_def_process_id
 * @property \DBModel\Model\Entity\FailureDefProcess $failure_def_process
 * @property int $provision_def_process_id
 * @property \DBModel\Model\Entity\ProvisionDefProcess $provision_def_process
 * @property int $post_def_process_id
 * @property \DBModel\Model\Entity\PostDefProcess $post_def_process
 * @property int $removal_def_process_id
 * @property \DBModel\Model\Entity\RemovalDefProcess $removal_def_process
 * @property int $concurrency
 * @property int $ref_channel_id
 * @property \DBModel\Model\Entity\RefChannel $ref_channel
 * @property int $pack_id
 * @property \DBModel\Model\Entity\Pack $pack
 * @property string $managed
 * @property string $content
 * @property string $drift_rules
 * @property \DBModel\Model\Entity\Bridge[] $bridges
 * @property \DBModel\Model\Entity\ChannelTypeProperty[] $channel_type_properties
 * @property \DBModel\Model\Entity\ChannelTypeRole[] $channel_type_roles
 * @property \DBModel\Model\Entity\Channel[] $channels
 * @property \DBModel\Model\Entity\HandlerPattern[] $handler_patterns
 */
class ChannelType extends Entity
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
