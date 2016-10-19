<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * EngineHost Entity.
 *
 * @property int $id
 * @property string $hostname
 * @property string $session_key
 * @property int $max_engines
 * @property int $gmt_expires
 * @property int $zone_id
 * @property \App\Model\Entity\Zone $zone
 */
class EngineHost extends Entity
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
