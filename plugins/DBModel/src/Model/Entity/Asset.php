<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Asset Entity.
 *
 * @property int $id
 * @property int $product_id
 * @property \App\Model\Entity\Product $product
 * @property int $gmt_created
 * @property string $name
 * @property string $type
 * @property string $revision
 * @property int $nextrev
 * @property int $locked
 * @property \App\Model\Entity\AssetProperty[] $asset_properties
 * @property \App\Model\Entity\AssetRole[] $asset_roles
 * @property \App\Model\Entity\Deliverable[] $deliverables
 * @property \App\Model\Entity\DeliveryPreview[] $delivery_previews
 * @property \App\Model\Entity\SpinPreview[] $spin_previews
 * @property \App\Model\Entity\Uri[] $uris
 */
class Asset extends Entity
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
