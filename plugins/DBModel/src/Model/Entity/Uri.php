<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Uri Entity.
 *
 * @property string $location
 * @property string $content
 * @property string $active
 * @property string $splode
 * @property string $flag
 * @property int $asset_property_id
 * @property \DBModel\Model\Entity\AssetProperty $asset_property
 * @property int $bridge_id
 * @property \DBModel\Model\Entity\Bridge $bridge
 * @property int $remote
 * @property string $module_name
 * @property int $sequence
 * @property string $name
 * @property int $asset_id
 * @property \DBModel\Model\Entity\Asset $asset
 * @property int $id
 * @property \DBModel\Model\Entity\AnalyzerMap[] $analyzer_maps
 * @property \DBModel\Model\Entity\ArtifactProperty[] $artifact_properties
 * @property \DBModel\Model\Entity\DeliveryPreviewModel[] $delivery_preview_models
 * @property \DBModel\Model\Entity\SolidPattern[] $solid_patterns
 * @property \DBModel\Model\Entity\Solid[] $solids
 * @property \DBModel\Model\Entity\SpinPreviewModel[] $spin_preview_models
 * @property \DBModel\Model\Entity\UriDepend[] $uri_depends
 * @property \DBModel\Model\Entity\UriProperty[] $uri_properties
 */
class Uri extends Entity
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
