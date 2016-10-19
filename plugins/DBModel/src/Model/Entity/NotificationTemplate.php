<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * NotificationTemplate Entity.
 *
 * @property int $id
 * @property string $name
 * @property \App\Model\Entity\DelEnv[] $del_envs
 * @property \App\Model\Entity\DeliverySignoff[] $delivery_signoffs
 * @property \App\Model\Entity\NotificationTemplateLang[] $notification_template_langs
 */
class NotificationTemplate extends Entity
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
