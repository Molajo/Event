<?php
/**
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event\Plugins\Referencedata;

use Molajo\Event\Plugins\Plugin;

defined('MOLAJO') or die;

/**
 * Reference Data Fields
 *
 * @package     Molajo
 * @license     MIT
 * @since       1.0
 */
class ReferencedataPlugin extends Plugin
{
    /**
     * Retrieve textual values for primary keys
     *
     * @return boolean
     * @since   1.0
     */
    public function onAfterRead()
    {
        return;
        $fkFields = $this->retrieveFieldsByType('foreignkeys');

        if (count($fkFields) == 0 || $fkFields === false || $fkFields == null) {
            return false;
        }

        if (is_array($fkFields) && count($fkFields) > 0) {

            foreach ($fkFields as $fk) {

                $fkName = $fk->name;
                $name   = substr($fkName, 3, strlen($fkName) - 3);

                $field = $this->getField($name);
                if ($field === false) {
                    $fieldValue = false;
                } else {
                    $fieldValue = $this->getFieldValue($field);
                }

                if ($fieldValue === false) {
                } else {

                    $new_name = $field['name'] . '_value';

                    $controllerclass = CONTROLLER_CLASS_NAMESPACE;
                    $controller      = new $controllerClass();
                    $controller->getModelRegistry('datasource', $fk->source_model, 1);
                    $controller->set('get_customfields', 0, 'model_registry');
                    $controller->set('get_item_children', 0, 'model_registry');
                    $controller->set('use_special_joins', 0, 'model_registry');
                    $controller->set('check_view_level_access', 0, 'model_registry');

                    $controller->set(
                        $controller->get('primary_key', 'id', 0, 'model_registry')
                        ,
                        (int) $fieldValue,
                        'model_registry'
                    );

                    $value = $controller->getData(QUERY_OBJECT_RESULT);

                    if ($value === false) {
                    } else {
                        $this->saveForeignKeyValue($new_name, $value);
                    }
                }
            }
        }

        return true;
    }
}
