<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Loch Entity.
 *
 * @property int $id
 * @property string $owner
 * @property string $name
 * @property int $gmt_expires
 */
class Loch extends Entity
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
