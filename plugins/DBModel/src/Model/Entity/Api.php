<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Api Entity.
 *
 * @property string $toc
 * @property string $groops
 * @property int $event_id
 * @property \DBModel\Model\Entity\Event $event
 * @property int $gmt_expires
 * @property string $token
 * @property string $username
 * @property int $id
 */
class Api extends Entity
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

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
}
