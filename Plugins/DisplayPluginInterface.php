<?php
/**
 * Display Plugin Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event\Plugins;

use Molajo\Event\Exception\PluginException;

defined('MOLAJO') or die;

/**
 * Display Plugin Interface
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Interface DisplayPluginInterface
{
    /**
     * After Route and Permissions, the Theme/Page are parsed
     *
     * @return bool
     * @since   1.0
     */
    public function onBeforeParse();

    /**
     * After the body render is complete and before the document head rendering starts
     *
     * @return bool
     * @since   1.0
     */
    public function onBeforeParseHead();

    /**
     * On after parsing and rendering is complete
     *
     * @return bool
     * @since   1.0
     */
    public function onAfterParse();

    /**
     * After the Read Query has executed but Before Query results are injected into the View
     *
     * @return bool
     * @since   1.0
     */
    public function onBeforeRenderView();

    /**
     * After the View has been rendered but before the output has been passed back to the Includer
     *
     * @return bool
     * @since   1.0
     */
    public function onAfterRenderView();
}
