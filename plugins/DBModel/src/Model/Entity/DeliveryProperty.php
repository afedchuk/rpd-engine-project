<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliveryProperty Entity.
 *
 * @property int $id
 * @property int $delivery_id
 * @property \DBModel\Model\Entity\Delivery $delivery
 * @property string $name
 * @property string $value
 * @property int $artifact_uri_id
 * @property \DBModel\Model\Entity\ArtifactUri $artifact_uri
 */
class DeliveryProperty extends AppProperty
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
