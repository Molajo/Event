<?php
/**
 * Event Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Service\Event;

use stdClass;
use Exception;
use Molajo\IoC\AbstractServiceProvider;
use CommonApi\IoC\ServiceProviderInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Event Event Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class EventServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
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
        $options['service_namespace'] = 'Molajo\\Event\\Event';
        $options['service_name']      = basename(__DIR__);

        parent::__construct($options);
    }

    /**
     * Instantiate a new handler and inject it into the Adapter for the ServiceProviderInterface
     * Retrieve a list of Interface dependencies and return the data ot the controller.
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function setDependencies(array $reflection = null)
    {
        parent::setDependencies(null);

        $this->dependencies = array();

        return $this->dependencies;
    }

    /**
     * Instantiate Class
     *
     * @return  $this
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException;
     */
    public function instantiateService()
    {
        if (isset($this->options['event_name'])) {
            $event_name = $this->options['event_name'];
        } else {
            $event_name = '';
        }

        if (isset($this->options['resource'])) {
            $resource = $this->options['resource'];
        } else {
            $resource = new stdClass();
        }

        if (isset($this->options['fieldhandler'])) {
            $fieldhandler = $this->options['fieldhandler'];
        } else {
            $fieldhandler = new stdClass();
        }

        if (isset($this->options['date_controller'])) {
            $date_controller = $this->options['date_controller'];
        } else {
            $date_controller = new stdClass();
        }

        if (isset($this->options['url_controller'])) {
            $url_controller = $this->options['url_controller'];
        } else {
            $url_controller = new stdClass();
        }

        if (isset($this->options['language_controller'])) {
            $language_controller = $this->options['language_controller'];
        } else {
            $language_controller = new stdClass();
        }

        if (isset($this->options['authorisation_controller'])) {
            $authorisation_controller = $this->options['authorisation_controller'];
        } else {
            $authorisation_controller = new stdClass();
        }

        if (isset($this->options['runtime_data'])) {
            $runtime_data = $this->options['runtime_data'];
        } else {
            $runtime_data = new stdClass();
        }

        if (isset($this->options['parameters'])) {
            $parameters = $this->options['parameters'];
        } else {
            $parameters = new stdClass();
        }

        if (isset($this->options['query'])) {
            $query = $this->options['query'];
        } else {
            $query = array();
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

        if (isset($this->options['rendered_view'])) {
            $rendered_view = $this->options['rendered_view'];
        } else {
            $rendered_view = '';
        }

        if (isset($this->options['rendered_page'])) {
            $rendered_page = $this->options['rendered_page'];
        } else {
            $rendered_page = '';
        }

        $class = 'Molajo\\Event\\Event';

        $return_items   = array();
        $return_items[] = 'runtime_data';
        $return_items[] = 'parameters';
        $return_items[] = 'query';
        $return_items[] = 'model_registry';
        $return_items[] = 'query_results';
        $return_items[] = 'rendered_view';
        $return_items[] = 'rendered_page';

        $data                             = array();
        $data['resource']                 = $resource;
        $data['fieldhandler']             = $fieldhandler;
        $data['date_controller']          = $date_controller;
        $data['url_controller']           = $url_controller;
        $data['language_controller']      = $language_controller;
        $data['authorisation_controller'] = $authorisation_controller;
        $data['runtime_data']             = $runtime_data;
        $data['parameters']               = $parameters;
        $data['query']                    = $query;
        $data['model_registry']           = $model_registry;
        $data['query_results']            = $query_results;
        $data['rendered_view']            = $rendered_view;
        $data['rendered_page']            = $rendered_page;

        try {
            $this->service_instance = new $class(
                $event_name,
                $return_items,
                $data
            );
        } catch (Exception $e) {
            throw new RuntimeException
            ('Render: Could not instantiate Handler: ' . $class);
        }

        return $this;
    }
}
