<?php
/**
 * Event Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Event;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;
use stdClass;

/**
 * Event Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class EventFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
{
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

        parent::__construct($options);
    }

    /**
     * Set dependencies
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        parent::setDependencies(array());

        $this->dependencies = array();

        $options = array('if_exists' => true);

        $this->dependencies['Resource']      = $options;
        $this->dependencies['Fieldhandler']  = $options;
        $this->dependencies['Date']          = $options;
        $this->dependencies['Url']           = $options;
        $this->dependencies['Language']      = $options;
        $this->dependencies['Authorisation'] = $options;
        $this->dependencies['rendered_page'] = $options;

        if (isset($this->options['runtime_data'])) {
        } else {
            $this->dependencies['Runtimedata'] = $options;
        }

        if (isset($this->options['plugin_data'])) {
        } else {
            $this->dependencies['Plugindata'] = $options;
        }

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function instantiateClass()
    {
        if (isset($this->options['event_name'])) {
            $event_name = $this->options['event_name'];
        } else {
            throw new RuntimeException
            (
                'EventFactoryMethod: Event name not provided'
            );
        }

        $event_options_keys = $this->dependencies['Runtimedata']->event_options_keys;
        $return_values      = array();

        $resource                 = $this->dependencies['Resource'];
        $fieldhandler             = $this->dependencies['Fieldhandler'];
        $date_controller          = $this->dependencies['Date'];
        $url_controller           = $this->dependencies['Url'];
        $language_controller      = $this->dependencies['Language'];
        $authorisation_controller = $this->dependencies['Authorisation'];

        if (isset($this->options['runtime_data'])) {
            $runtime_data = $this->options['runtime_data'];
        } else {
            $runtime_data = $this->dependencies['Runtimedata'];
        }

        if (isset($this->options['plugin_data'])) {
            $plugin_data = $this->options['plugin_data'];
        } else {
            $plugin_data = $this->dependencies['Plugindata'];
        }

        if (isset($this->options['parameters'])) {
            $parameters = $this->options['parameters'];
        } else {
            $parameters = new stdClass();
        }

        /** Only use from options -- which comes from the Controller */
        if (isset($this->options['query'])) {
            $query = $this->options['query'];
        } else {
            $query = null;
        }

        if (isset($this->options['model_registry'])) {
            $model_registry = $this->options['model_registry'];
        } else {
            $model_registry = new stdClass();
        }

        if (isset($this->options['query_results'])) {
            $query_results = $this->options['query_results'];
        } else {
            $query_results = array();
        }

        if (isset($this->options['row'])) {
            $row = $this->options['row'];
        } else {
            $row = new stdClass();
        }

        if (isset($this->options['rendered_view'])) {
            $rendered_view = $this->options['rendered_view'];
        } else {
            $rendered_view = '';
        }

        if (isset($this->options['rendered_page'])) {
            $rendered_page = $this->options['rendered_page'];
        } elseif (isset($this->dependencies['rendered_page'])) {
            $rendered_page = $this->dependencies['rendered_page'];
        } else {
            $rendered_page = '';
        }

        $class = $this->product_namespace;

        $data                             = array();
        $data['resource']                 = $resource;
        $data['fieldhandler']             = $fieldhandler;
        $data['date_controller']          = $date_controller;
        $data['url_controller']           = $url_controller;
        $data['language_controller']      = $language_controller;
        $data['authorisation_controller'] = $authorisation_controller;
        $data['runtime_data']             = $runtime_data;
        $data['plugin_data']              = $plugin_data;
        $data['parameters']               = $parameters;
        $data['query']                    = $query;

        $return_values                    = $this->setReturnValues($query, $event_options_keys, $return_values);

        $data['model_registry']           = $model_registry;
        $data['query_results']            = $query_results;
        $data['row']                      = $row;
        $data['rendered_view']            = $rendered_view;
        $data['rendered_page']            = $rendered_page;

        try {
            $this->product_result = new $class(
                $event_name,
                $return_values,
                $data
            );

        } catch (Exception $e) {
            throw new RuntimeException
            (
                'Event Factory: Could not instantiate Event Schedule: ' . $class
            );
        }

        return $this;
    }

    /**
     * Set Return Values
     *
     * @param   null|object $query
     * @param   array       $event_options_keys
     * @param   array       $return_values
     *
     * @return array
     */
    protected function setReturnValues(
        $query = null,
        array $event_options_keys = array(),
        array $return_values = array()
    ) {
        if ($query === null) {
            foreach ($event_options_keys as $item) {
                if ($item === 'query') {
                } else {
                    $return_values[] = $item;
                }
            }
        } else {
            $return_values = $event_options_keys;
        }

        return $return_values;
    }
}
