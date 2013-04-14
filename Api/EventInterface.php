<?php
/**
 * Event Interface
 *
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event;

defined('MOLAJO') or die;

/**
 * Event Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
interface EventInterface
{
    /**
     * get property
     *
     * @param string $key
     * @param string $default
     *
     * @return mixed
     * @since   1.0
     * @throws  EventException
     */
    public function get($key, $default = '');

    /**
     * set property
     *
     * @param string $key
     * @param string $value
     *
     * @return mixed
     * @since   1.0
     * @throws  EventException
     */
    public function set($key, $value);

    /**
     * The application schedules events at various points within the system.
     *
     * Usage:
     * Services::Event()->scheduleEvent('onAfterDelete', $arguments, $selections);
     *
     * As a result of the schedule request, the Event Service fires off plugins
     *  meeting this criteria:
     *
     * - published (or archived)
     * - registered for the scheduled event
     * - associated with the current extension
     * - authorised for use by the user
     *
     * @param string $event
     * @param array  $arguments
     * @param array  $selections
     *
     * @return boolean
     *
     * @since   1.0
     */
    public function scheduleEvent($event, $arguments = array(), $selections = array());

    /**
     * Instantiate the Plugin Class.
     *
     * Establish initial property values given arguments passed in (could include changes other plugins made).
     * Load Fields for Model Registry, if in the arguments, for Plugin use.
     * Execute each qualified plugin, one at a time, until all have been processed.
     * Return arguments, which could contain changed data, to the calling class.
     *
     * @param string $plugin_class_name includes namespace
     * @param string $event
     * @param array  $arguments
     *
     * @return array|bool
     * @since   1.0
     * @throws  Exception
     * @throws  EventException
     */
    public function processPluginClass($plugin_class_name, $event, $arguments = array());

    /**
     * Registers all Plugins in the folder
     *
     * Extensions can override Plugins by including a like-named folder in a Plugin directory within the extension
     *
     * The application will find and register overrides at the point in time the extension is used in rendering.
     *
     * Usage:
     * Services::Event()->registerPlugin('ExamplePlugin', 'Molajo\\Plugin\\Example');
     *
     * @param string $plugin_name
     * @param string $plugin_class_name
     *
     * @return bool|Event
     * @throws  Exception
     */
    public function registerPlugin($plugin_name = '', $plugin_class_name = '');

    /**
     * Plugins register for events. When the event is scheduled, the plugin will be executed.
     *
     * The last plugin to register is the one that will be invoked.
     *
     * Installed plugins are registered during Application startup process.
     * Other plugins can be created and dynamically registered using this method.
     * Plugins can be overridden by registering after the installed plugins.
     *
     * @param string $plugin_name
     * @param string $plugin_class_name
     * @param string $event
     *
     * @return void
     * @since   1.0
     */
    public function registerPluginEvent($plugin_name, $plugin_class_name, $event);
}
