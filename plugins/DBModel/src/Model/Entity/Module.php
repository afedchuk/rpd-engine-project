<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Module Entity.
 *
 * @property int $id
 * @property int $platform_id
 * @property \DBModel\Model\Entity\Platform $platform
 * @property string $name
 * @property int $version
 * @property int $gmt_created
 * @property int $siz
 * @property string $md5
 * @property int $bits_id
 * @property string $description
 * @property \DBModel\Model\Entity\Bit[] $bits
 * @property \DBModel\Model\Entity\Analyzer[] $analyzers
 * @property \DBModel\Model\Entity\Event[] $events
 * @property \DBModel\Model\Entity\Lb[] $lbs
 * @property \DBModel\Model\Entity\Lbs1[] $lbs1
 * @property \DBModel\Model\Entity\Vm[] $vms
 */
class Module extends Entity
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
