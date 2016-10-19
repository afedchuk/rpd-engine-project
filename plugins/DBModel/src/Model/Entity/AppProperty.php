<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;

/**
 * Api Entity.
 *
 * @property string $toc
 * @property string $groops
 * @property int $event_id
 * @property \App\Model\Entity\Event $event
 * @property int $gmt_expires
 * @property string $token
 * @property string $username
 * @property int $id
 */
class AppProperty extends Entity
{
     protected $_virtual = ['encrypt_data'];
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

    protected function _getEncryptData($value) 
    {
        if(isset($this->_properties['value']) && strpos($this->_properties['value'], "!#!") !== false) {
            return true;
        }
        return false;
    }

    public function encryptValue()
    {
        if($this->_properties['value'] == '******'){
            $this->_properties['value'] = null;

        }
        if(!empty($this->_properties['value']) && isset($this->_properties['encrypt_data']) && $this->_properties['encrypt_data']) {
            $this->_properties['value'] =  encodeSecretProperty( $this->_properties['value'] );
        }
        return $this->_properties['value'];

    }
}
