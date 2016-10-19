<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Artifact Entity.
 *
 * @property int $ref_artifact_id
 * @property \DBModel\Model\Entity\RefArtifact $ref_artifact
 * @property int $locked
 * @property int $nextrev
 * @property string $revision
 * @property int $gmt_created
 * @property string $status
 * @property string $name
 * @property int $channel_rev_id
 * @property \DBModel\Model\Entity\ChannelRev $channel_rev
 * @property int $deliverable_id
 * @property int $id
 * @property \DBModel\Model\Entity\Deliverable[] $deliverables
 * @property \DBModel\Model\Entity\ArtifactFeed[] $artifact_feeds
 * @property \DBModel\Model\Entity\ArtifactProperty[] $artifact_properties
 * @property \DBModel\Model\Entity\ArtifactRole[] $artifact_roles
 * @property \DBModel\Model\Entity\Solid[] $solids
 */
class Artifact extends Entity
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
