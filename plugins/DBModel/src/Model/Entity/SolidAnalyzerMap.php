<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * SolidAnalyzerMap Entity.
 *
 * @property int $id
 * @property int $solid_id
 * @property \DBModel\Model\Entity\Solid $solid
 * @property int $analyzer_id
 * @property \DBModel\Model\Entity\Analyzer $analyzer
 * @property int $sequence
 */
class SolidAnalyzerMap extends Entity
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
