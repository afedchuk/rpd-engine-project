<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Solid Entity.
 *
 * @property int $uri_require
 * @property string $remote_location
 * @property string $content
 * @property string $meta
 * @property string $stamp
 * @property int $product_id
 * @property \DBModel\Model\Entity\Product $product
 * @property int $deliverable_id
 * @property \DBModel\Model\Entity\Deliverable $deliverable
 * @property int $engine_id
 * @property \DBModel\Model\Entity\Engine $engine
 * @property int $uri_id
 * @property \DBModel\Model\Entity\Uri $uri
 * @property int $solid_id
 * @property string $active
 * @property string $splode
 * @property string $md5
 * @property string $toc
 * @property int $delivery_id
 * @property \DBModel\Model\Entity\Delivery $delivery
 * @property int $ref_artifact_id
 * @property \DBModel\Model\Entity\RefArtifact $ref_artifact
 * @property int $reference_id
 * @property \DBModel\Model\Entity\Reference $reference
 * @property string $analyz
 * @property int $gmt_fetched
 * @property string $status
 * @property int $pct
 * @property int $siz
 * @property string $module_name
 * @property int $bridge_id
 * @property \DBModel\Model\Entity\Bridge $bridge
 * @property string $store_uri
 * @property string $location
 * @property int $sequence
 * @property string $name
 * @property int $artifact_id
 * @property \DBModel\Model\Entity\Artifact $artifact
 * @property int $id
 * @property \DBModel\Model\Entity\Solid[] $solids
 * @property \DBModel\Model\Entity\ArtifactFeed[] $artifact_feeds
 * @property \DBModel\Model\Entity\Blob[] $blobs
 * @property \DBModel\Model\Entity\BuildCheckout[] $build_checkouts
 * @property \DBModel\Model\Entity\DeliveryProcess[] $delivery_processes
 * @property \DBModel\Model\Entity\SolidAnalyzerMap[] $solid_analyzer_maps
 * @property \DBModel\Model\Entity\SolidDepend[] $solid_depends
 * @property \DBModel\Model\Entity\Toc[] $tocs
 */
class Solid extends Entity
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
