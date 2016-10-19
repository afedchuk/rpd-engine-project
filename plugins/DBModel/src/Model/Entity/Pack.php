<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pack Entity.
 *
 * @property int $id
 * @property string $name
 * @property \DBModel\Model\Entity\ChannelType[] $channel_types
 * @property \DBModel\Model\Entity\Cmap[] $cmaps
 * @property \DBModel\Model\Entity\Lognote[] $lognotes
 * @property \DBModel\Model\Entity\Renore[] $renores
 * @property \DBModel\Model\Entity\Script[] $scripts
 */
class Pack extends Entity
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
     * Modifies the name field of entity.
     *
     * @return strind
     */
    protected function _setName(string $packName)
    {
        return str_replace(" ", "_", strtolower($packName));
    }
}
