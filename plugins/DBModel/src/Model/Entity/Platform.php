<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Platform Entity.
 *
 * @property int $id
 * @property int $reference_id
 * @property \DBModel\Model\Entity\Reference $reference
 * @property string $name
 * @property \DBModel\Model\Entity\Module[] $modules
 * @property \DBModel\Model\Entity\PlatformProperty[] $platform_properties
 * @property \DBModel\Model\Entity\Platstring[] $platstrings
 * @property \DBModel\Model\Entity\Renore[] $renores
 * @property \DBModel\Model\Entity\Script[] $scripts
 */
class Platform extends Entity
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
