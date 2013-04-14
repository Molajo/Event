<?php
/**
 * Plugin
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event\Plugins;

use Molajo\Event\Exception\PluginException;

defined('MOLAJO') or die;

/**
 * Plugin Interface
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Interface PluginInterface
{
    /**
     * Initialise Plugin Resources
     *
     * @return  void
     * @since   1.0
     */
    public function initialise();

    /**
     * Get the current value (or default) of the specified property
     *
     * @param   string  $key
     * @param   mixed   $default
     * @param   string  $property
     *
     * @return  mixed
     * @since   1.0
     * @throws  PluginException
     */
    public function get($key, $default = null, $property = '');

    /**
     * Set the value of a property
     *
     * Initially, the setter is used by the plugin_event processPluginclass method
     *  to establish initial property values sent in by the scheduling method
     *
     * Changes to data will be used collected and used by the Mvc
     *
     * @param   string  $key
     * @param   string  $value
     * @param   string  $property
     *
     * @return  mixed
     * @since   1.0
     * @throws  PluginException
     */
    public function set($key, $value = null, $property = '');

    /**
     * Runs before Route and after Services and Helpers have been instantiated
     *
     * @return  bool
     * @since   1.0
     */
    public function onAfterInitialise();

    /**
     * Scheduled after Route has been determined. Parameters contain all instruction to produce primary request.
     *
     * @return  bool
     * @since   1.0
     */
    public function onAfterRoute();

    /**
     * Scheduled after core Authorise to augment, change authorisation process or override a failed test
     *
     * @return  bool
     * @since   1.0
     */
    public function onAfterAuthorise();

    /**
     * Triggered by Controller after Data Object is set for Model Registry
     *
     * @return  bool
     * @since   1.0
     */
    public function onConnectDatabase();

    /**
     * plugin_event fires after execute for both display and non-display task
     *
     * @return  bool
     * @since   1.0
     */
    public function onAfterExecute();

    /**
     * Plugin that fires after all views are rendered
     *
     * @return  bool
     * @since   1.0
     */
    public function onAfterResponse();
}
