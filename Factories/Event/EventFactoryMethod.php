<?php
/**
 * Event Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Event;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

/**
 * Event Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class EventFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
    /**
     * Dependencies Array
     *
     * @var    array
     * @since  1.0
     */
    protected $dependencies_array
        = array(
            'resource'              => 'Resource',
            'fieldhandler'          => 'Fieldhandler',
            'date'                  => 'Date',
            'url'                   => 'Url',
            'language'              => 'Language',
            'rendered_page'         => 'rendered_page',
            'user'                  => 'User',
            'plugin_data'           => 'Plugindata',
            'runtime_data'          => 'Runtimedata',
            'get_cache_callback'    => 'Getcachecallback',
            'set_cache_callback'    => 'Setcachecallback',
            'delete_cache_callback' => 'Deletecachecallback'
        );

    /**
     * Additional Properties passed in via the options array or set to null
     *
     * @var    array
     * @since  1.0
     */
    protected $passed_in_options
        = array(
            'exclude_tokens' => 'exclude_tokens',
            'token_objects'  => 'token_objects',
            'parameters'     => 'parameters',
            'query'          => 'query',
            'model_registry' => 'model_registry',
            'query_results'  => 'query_results',
            'row'            => 'row',
            'rendered_view'  => 'rendered_view'
        );

    /**
     * Additional Properties passed in via the options array
     *
     * @var    array
     * @since  1.0
     */
    protected $event_return_keys
        = array(
            'rendered_page',
            'rendered_view',
            'exclude_tokens',
            'plugin_data',
            'query_results',
            'query',
            'model_registry',
            'parameters',
            'token_objects',
            'row'
        );

    /**
     * Plugin Name
     *
     * @var    string
     * @since  1.0.0
     */
    protected $plugin_name = null;

    /**
     * Event Name
     *
     * @var    string
     * @since  1.0.0
     */
    protected $event_name = null;

    /**
     * Constructor
     *
     * @param  array $options
     *
     * @since  1.0
     */
    public function __construct(array $options = array())
    {
        $options['product_namespace'] = 'Molajo\\Event\\Scheduled';
        $options['product_name']      = basename(__DIR__);

        $this->event_name = $options['event_name'];
        unset($options['event_name']);

        parent::__construct($options);
    }

    /**
     * Set dependencies
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        parent::setDependencies(array());

        $this->dependencies = array();
        $options            = array('if_exists' => true);

        foreach ($this->dependencies_array as $key => $value) {
            if (isset($this->options[$value])) {
            } else {
                $this->dependencies[$value] = $options;
            }
        }

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        $class = $this->product_namespace;
        $data  = $this->setEventData();

        try {
            $this->product_result = new $class(
                $this->event_name,
                $this->event_return_keys,
                $data
            );

        } catch (Exception $e) {
            throw new RuntimeException(
                'EventFactoryMethod Could not instantiate Event: ' . $this->event_name
            );
        }

        return $this;
    }

    /**
     * Set Event Data
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setEventData()
    {
        $new_array = array_merge($this->dependencies_array, $this->passed_in_options);

        $event_options = array();

        foreach ($new_array as $key => $value) {
            if (isset($this->dependencies[$value])) {
                $event_options[$key] = $this->dependencies[$value];

            } elseif (isset($this->options[$value])) {
                $event_options[$key] = $this->options[$value];

            } else {
                $event_options[$key] = null;
            }
        }

        return $event_options;
    }
}
