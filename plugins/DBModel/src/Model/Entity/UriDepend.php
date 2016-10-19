<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * UriDepend Entity
 *
 * @property int $id
 * @property int $uri_id
 * @property int $uri_depend_id
 * @property string $type
 * @property int $scope
 *
 * @property \DBModel\Model\Entity\Uri $uri
 * @property \DBModel\Model\Entity\UriDepend[] $uri_depends
 */
class UriDepend extends Entity
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
