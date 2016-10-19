<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Oddit Entity.
 *
 * @property string $message
 * @property int $gmt_created
 * @property int $event_id
 * @property \DBModel\Model\Entity\Event $event
 * @property int $id
 */
class Oddit extends Entity
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
