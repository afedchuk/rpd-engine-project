<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;
use DBModel\Model\Entity\AppProperty;

/**
 * ArtifactProperty Entity.
 *
 * @property int $uri_id
 * @property \DBModel\Model\Entity\Uri $uri
 * @property int $locked
 * @property string $name
 * @property int $artifact_id
 * @property \DBModel\Model\Entity\Artifact $artifact
 * @property int $id
 * @property string $value
 */
class ArtifactProperty extends AppProperty
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
