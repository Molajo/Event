<?php
/**
 * Event Schedule
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event;

use CommonApi\Event\EventInterface;
use CommonApi\Controller\UrlInterface;
use CommonApi\Controller\DateInterface;
use CommonApi\Language\LanguageInterface;
use CommonApi\Model\FieldhandlerInterface;
use CommonApi\Authorisation\AuthorisationInterface;
use CommonApi\Exception\InvalidArgumentException;

/**
 * Event Schedule
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class Event implements EventInterface
{
    /**
     * Event Name
     *
     * @var    string
     * @since  1.0
     */
    protected $event_name = null;

    /**
     * Data
     *
     * @var    array
     * @since  1.0
     */
    protected $data = array();

    /**
     * Parameters
     *
     * @var    object
     * @since  1.0
     */
    protected $parameters = null;

    /**
     * Page Rendered Output
     *
     * @var    string
     * @since  1.0
     */
    protected $rendered_page = null;

    /**
     * View Rendered Output
     *
     * @var    string
     * @since  1.0
     */
    protected $rendered_view = null;

    /**
     * Resource
     *
     * @var    object
     * @since  1.0
     */
    protected $resources = null;

    /**
     * Date Controller
     *
     * @var    object  CommonApi\Controller\DateInterface;
     * @since  1.0
     */
    protected $date_controller = null;

    /**
     * Url
     *
     * @var    object  CommonApi\Controller\UrlInterface;
     * @since  1.0
     */
    protected $url_controller = null;

    /**
     * Fieldhandler
     *
     * @var    object  CommonApi\Model\FieldhandlerInterface
     * @since  1.0
     */
    protected $fieldhandler = null;

    /**
     * Model Registry
     *
     * @var    object
     * @since  1.0
     */
    protected $model_registry = null;

    /**
     * Query
     *
     * @var    object
     * @since  1.0
     */
    protected $query = null;

    /**
     * Language Controller
     *
     * @var    object  CommonApi\Language\LanguageInterface
     * @since  1.0
     */
    protected $language_controller;

    /**
     * Authorisation Controller
     *
     * @var    object  CommonApi\Authorisation\AuthorisationInterface
     * @since  1.0
     */
    protected $authorisation_controller;

    /**
     * Constructor
     *
     * @param  null                   $event_name
     * @param  null                   $resources
     * @param  FieldhandlerInterface  $fieldhandler
     * @param  DateInterface          $date_controller
     * @param  UrlInterface           $url_controller
     * @param  LanguageInterface      $language_controller
     * @param  AuthorisationInterface $authorisation_controller
     * @param  null|mixed             $runtime_data
     * @param  null                   $parameters
     * @param  null                   $query
     * @param  null                   $model_registry
     * @param  null                   $query_results
     * @param  null                   $rendered_view
     * @param  null                   $rendered_page
     *
     * @since   1.0
     */
    public function __construct(
        $event_name = null,
        $resources = null,
        FieldhandlerInterface $fieldhandler = null,
        DateInterface $date_controller = null,
        UrlInterface $url_controller = null,
        LanguageInterface $language_controller = null,
        AuthorisationInterface $authorisation_controller = null,
        $runtime_data = null,
        $parameters = null,
        $query = null,
        $model_registry = null,
        $query_results = null,
        $rendered_view = null,
        $rendered_page = null
    ) {
        $this->event_name               = $event_name;
        $this->resources                = $resources;
        $this->fieldhandler             = $fieldhandler;
        $this->date_controller          = $date_controller;
        $this->url_controller           = $url_controller;
        $this->language_controller      = $language_controller;
        $this->authorisation_controller = $authorisation_controller;
        $this->runtime_data             = $runtime_data;
        $this->parameters               = $parameters;
        $this->query                    = $query;
        $this->model_registry           = $model_registry;
        $this->query_results            = $query_results;
        $this->rendered_view            = $rendered_view;
        $this->rendered_page            = $rendered_page;
    }

    /**
     * Get a property
     *
     * @param    $key
     *
     * @return   array|null|object|string
     * @since    1.0
     * @throws   \CommonApi\Exception\InvalidArgumentException
     */
    public function get($key)
    {
        $key = strtolower($key);

        if ($key == 'event_name') {
            return $this->event_name;
        } elseif ($key == 'resources') {
            return $this->resources;
        } elseif ($key == 'fieldhandler') {
            return $this->fieldhandler;
        } elseif ($key == 'date_controller') {
            return $this->date_controller;
        } elseif ($key == 'url_controller') {
            return $this->url_controller;
        } elseif ($key == 'language_controller') {
            return $this->language_controller;
        } elseif ($key == 'authorisation_controller') {
            return $this->authorisation_controller;
        } elseif ($key == 'runtime_data') {
            return $this->runtime_data;
        } elseif ($key == 'parameters') {
            return $this->parameters;
        } elseif ($key == 'query') {
            return $this->query;
        } elseif ($key == 'model_registry') {
            return $this->model_registry;
        } elseif ($key == 'query_results') {
            return $this->query_results;
        } elseif ($key == 'rendered_view') {
            return $this->rendered_view;
        } elseif ($key == 'rendered_page') {
            return $this->rendered_page;
        }

        throw new InvalidArgumentException
            ('Event: Invalid Get Key: ' . $key);
    }

    /**
     * Set a property value
     *
     * @param    string $key
     * @param    mixed  $value
     *
     * @return   $this
     * @since    1.0
     * @throws   \CommonApi\Exception\InvalidArgumentException
     */
    public function set($key, $value)
    {
        $key = strtolower($key);

        if ($key == 'event_name') {
            $this->event_name = $value;
        } elseif ($key == 'resources') {
            $this->resources = $value;
        } elseif ($key == 'fieldhandler') {
            $this->fieldhandler = $value;
        } elseif ($key == 'date_controller') {
            $this->date_controller = $value;
        } elseif ($key == 'url_controller') {
            $this->url_controller = $value;
        } elseif ($key == 'language_controller') {
            $this->language_controller = $value;
        } elseif ($key == 'authorisation_controller') {
            $this->authorisation_controller = $value;
        } elseif ($key == 'runtime_data') {
            $this->runtime_data = $value;
        } elseif ($key == 'parameters') {
            $this->parameters = $value;
        } elseif ($key == 'query') {
            $this->query = $value;
        } elseif ($key == 'model_registry') {
            $this->model_registry = $value;
        } elseif ($key == 'query_results') {
            $this->query_results = $value;
        } elseif ($key == 'rendered_view') {
            $this->rendered_view = $value;
        } elseif ($key == 'rendered_page') {
            $this->rendered_page = $value;
        } else {
            throw new InvalidArgumentException
                ('Event: Invalid Set Key: ' . $key);
        }

        return $this;
    }
}
