<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * DelRoute Entity
 *
 * @property int $id
 * @property int $del_route_name_id
 * @property int $del_env_id
 * @property int $sequence
 * @property int $groop_id
 *
 * @property \DBModel\Model\Entity\DelRouteName $del_route_name
 * @property \DBModel\Model\Entity\DelEnv $del_env
 * @property \DBModel\Model\Entity\Groop $groop
 */
class DelRoute extends Entity
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
