<?php
/**
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event\Plugins\Head;

use Molajo\Event\Plugins\Plugin;

defined('MOLAJO') or die;

/**
 * @package     Molajo
 * @license     MIT
 * @since       1.0
 */
class HeadPlugin extends Plugin
{
    /**
     * Prepares data for the JS links and Declarations for the Head
     *
     * @return boolean
     * @since   1.0
     */
    public function onBeforeRead()
    {
        if (strtolower($this->get('template_view_path_node', '', 'parameters')) == 'head') {
        } else {
            return true;
        }

        /** JS */
        $controllerclass = CONTROLLER_CLASS_NAMESPACE;
        $controller      = new $controllerClass();
        $controller->getModelRegistry('dbo', 'Assets');
        $controller->setDataobject();
        $controller->connectDatabase();
        $controller->set('model_parameter', 'Js', 'model_registry');

        $temp_query_results = $controller->getData('getAssets');

        Services::Registry()->set('Assets', 'js', $temp_query_results);

        /** JS Declarations */
        $controllerclass = CONTROLLER_CLASS_NAMESPACE;
        $controller      = new $controllerClass();
        $controller->getModelRegistry('dbo', 'Assets');
        $controller->setDataobject();
        $controller->connectDatabase();

        $controller->set('model_parameter', 'JsDeclarations', 'model_registry');
        $temp_query_results = $controller->getData('getAssets');

        Services::Registry()->set('Assets', 'jsdeclarations', $temp_query_results);

        return true;
    }
}
