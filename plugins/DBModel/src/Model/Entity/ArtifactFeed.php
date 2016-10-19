<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * ArtifactFeed Entity.
 *
 * @property int $id
 * @property int $artifact_id
 * @property \DBModel\Model\Entity\Artifact $artifact
 * @property int $solid_id
 * @property \DBModel\Model\Entity\Solid $solid
 * @property int $bridge_id
 * @property \DBModel\Model\Entity\Bridge $bridge
 * @property int $channel_id
 * @property \DBModel\Model\Entity\Channel $channel
 * @property int $gmt_created
 * @property string $line
 * @property string $flag
 */
class ArtifactFeed extends Entity
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
