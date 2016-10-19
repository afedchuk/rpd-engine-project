<?php
namespace DBModel\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Analyzer Entity.
 *
 * @property int $id
 * @property string $name
 * @property string $module
 * @property string $copy_on_explode
 * @property \DBModel\Model\Entity\AnalyzerMap[] $analyzer_maps
 * @property \DBModel\Model\Entity\AnalyzerProperty[] $analyzer_properties
 * @property \DBModel\Model\Entity\SolidAnalyzerMap[] $solid_analyzer_maps
 */
class Analyzer extends Entity
{

    protected $_virtual = ['info_module'];
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
     * Get module information after analyzer found.
     * @return bool false | DBModel\Model\Entity\Module The module object.
    **/
    protected function _getInfoModule()
    {
        $module = TableRegistry::get('DBModel.Modules');
        if($module !== null && isset($this->_properties['module'])) {
            return  $module->findByName($this->_properties['module'])->first();
        }
        return false;
    }
}
