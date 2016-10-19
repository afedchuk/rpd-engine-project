<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * DeliverySignoff Entity.
 *
 * @property int $id
 * @property int $delivery_id
 * @property \App\Model\Entity\Delivery $delivery
 * @property int $notification_template_id
 * @property \App\Model\Entity\NotificationTemplate $notification_template
 * @property string $type
 * @property string $contact
 * @property string $signoff
 * @property int $gmt_notified
 * @property int $gmt_signed
 * @property int $gmt_active
 * @property string $flag
 * @property string $note
 */
class DeliverySignoff extends Entity
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
