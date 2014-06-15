<?php
/**
 * Abstract Plugin
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Plugins;

/**
 * Abstract Plugin
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
abstract class AbstractPlugin
{
    /**
     * Plugin Name
     *
     * @var    string
     * @since  1.0
     */
    protected $plugin_name = null;

    /**
     * Event Name
     *
     * @var    string
     * @since  1.0
     */
    protected $event_name = null;

    /**
     * Resource Instance
     *
     * @var    object
     * @since  1.0
     */
    protected $resource;

    /**
     * Date Controller
     *
     * @var    object
     * @since  1.0
     */
    protected $data_controller;

    /**
     * Language Controller
     *
     * @var    object
     * @since  1.0
     */
    protected $language_controller;

    /**
     * Runtime Data
     *
     * @var    object
     * @since  1.0.0
     */
    protected $runtime_data = null;

    /**
     * Plugin Data
     *
     * @var    object
     * @since  1.0.0
     */
    protected $plugin_data = null;

    /**
     * Parameters
     *
     * @var    array
     * @since  1.0.0
     */
    protected $parameters = array();

    /**
     * Model Registry
     *
     * @var    array
     * @since  1.0.0
     */
    protected $model_registry = array();

    /**
     * Query Results
     *
     * @var    array
     * @since  1.0.0
     */
    protected $query_results = array();

    /**
     * Object containing a single row for using within View
     *
     * @var    array
     * @since  1.0.0
     */
    protected $row = null;

    /**
     * Path to Include File
     *
     * @var    string
     * @since  1.0.0
     */
    protected $include_path;

    /**
     * View Rendered Output
     *
     * @var    string
     * @since  1.0.0
     */
    protected $rendered_view = null;

    /**
     * Page Rendered Output
     *
     * @var    string
     * @since  1.0.0
     */
    protected $rendered_page = null;

    /**
     * Constructor
     *
     * @param   string $plugin_name
     * @param   string $event_name
     * @param   array  $data
     *
     * @since  1.0
     */
    public function __construct(
        $plugin_name = '',
        $event_name = '',
        array $data = array()
    ) {
        $this->plugin_name = $plugin_name;
        $this->event_name  = $event_name;

        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Get the current value (or default) of the specified property
     *
     * @param   string $key
     *
     * @return  mixed
     * @since   1.0
     */
    public function get($key)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }

        return $this;
    }

    /**
     * Set the value of a property
     *
     * Initially, the setter is used by the plugin_event processPluginclass method
     *  to establish initial property values sent in by the scheduling method
     *
     * Changes to data will be used collected and used by the Mvc
     *
     * @param   string $key
     * @param   string $value
     *
     * @return  AbstractPlugin
     * @since   1.0
     */
    public function set($key, $value = null)
    {
        $this->$key = $value;

        return $this;
    }
}
