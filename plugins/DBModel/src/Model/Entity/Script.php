<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Script Entity
 *
 * @property int $id
 * @property int $reference_id
 * @property int $platform_id
 * @property int $gmt_created
 * @property int $version
 * @property string $activ
 * @property string $name
 * @property int $pack_id
 * @property string $md5
 * @property string $content
 *
 * @property \DBModel\Model\Entity\Reference $reference
 * @property \DBModel\Model\Entity\Platform $platform
 * @property \DBModel\Model\Entity\Pack $pack
 */
class Script extends Entity
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
        'id' => false
    ];
}
