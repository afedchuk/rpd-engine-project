<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Process Entity.
 *
 * @property int $id
 * @property int $def_process_id
 * @property \DBModel\Model\Entity\DefProcess $def_process
 * @property string $name
 * @property string $type
 * @property string $flag
 * @property int $engine_id
 * @property \DBModel\Model\Entity\Engine $engine
 * @property int $gmt_flag
 * @property int $gmt_start
 * @property int $duration
 * @property string $message
 * @property \DBModel\Model\Entity\Activity[] $activities
 * @property \DBModel\Model\Entity\ChannelConf[] $channel_confs
 * @property \DBModel\Model\Entity\ChannelProcess[] $channel_processes
 * @property \DBModel\Model\Entity\ChannelType[] $channel_types
 * @property \DBModel\Model\Entity\DeliveryProcess[] $delivery_processes
 * @property \DBModel\Model\Entity\Message[] $messages
 * @property \DBModel\Model\Entity\ProcessDepend[] $process_depends
 */
class Process extends Entity
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
     * Sets values to gmt_flag and flag fields
     *
     * @param string $flag value of flag field
     * @return string
     */
    protected function _setFlag(string $flag) {
        $this->set('gmt_flag', time());
        return $flag;
    }
}
