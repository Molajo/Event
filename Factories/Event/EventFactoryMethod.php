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
     * Dependencies Array
     *
     * @var    array
     * @since  1.0
     */
    protected $dependencies_array
        = array(
            'Resource'      => 'Resource',
            'Fieldhandler'  => 'Fieldhandler',
            'Date'          => 'Date',
            'Url'           => 'Url',
            'Language'      => 'Language',
            'Authorisation' => 'Authorisation',
            'rendered_page' => 'rendered_page',
            'User'          => 'User',
            'runtime_data'  => 'Runtimedata',
            'plugin_data'   => 'Plugindata'
        );

    /**
     * Additional Array
     *
     * @var    array
     * @since  1.0
     */
    protected $additional_array
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
     * Resource
     *
     * @var    object
     * @since  1.0.0
     */
    protected $resource = null;

    /**
     * Fieldhandler
     *
     * @var    object  CommonApi\Model\FieldhandlerInterface
     * @since  1.0.0
     */
    protected $fieldhandler = null;

    /**
     * Date Controller
     *
     * @var    object  CommonApi\Controller\DateInterface
     * @since  1.0.0
     */
    protected $date = null;

    /**
     * Url Controller
     *
     * @var    object  CommonApi\Controller\UrlInterface
     * @since  1.0.0
     */
    protected $url = null;

    /**
     * Language Instance
     *
     * @var    object CommonApi\Language\LanguageInterface
     * @since  1.0.0
     */
    protected $language = null;

    /**
     * Authorisation Controller
     *
     * @var    object  CommonApi\Authorisation\AuthorisationInterface
     * @since  1.0.0
     */
    protected $authorisation = null;

    /**
     * Page Rendered Output
     *
     * @var    string
     * @since  1.0.0
     */
    protected $rendered_page = null;

    /**
     * User
     *
     * @var    object  CommonApi\User\UserInterface
     * @since  1.0.0
     */
    protected $user = null;

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
     * Exclude Tokens
     *
     * @var    array
     * @since  1.0.0
     */
    protected $exclude_tokens = array();

    /**
     * Token Objects
     *
     * @var    array
     * @since  1.0.0
     */
    protected $token_objects = array();

    /**
     * Parameters
     *
     * @var    object
     * @since  1.0.0
     */
    protected $parameters = null;

    /**
     * Query
     *
     * @var    object
     * @since  1.0.0
     */
    protected $query = null;

    /**
     * Model Registry
     *
     * @var    object
     * @since  1.0.0
     */
    protected $model_registry = null;

    /**
     * Query Results
     *
     * @var    array
     * @since  1.0.0
     */
    protected $query_results = array();

    /**
     * Query Results
     *
     * @var    object
     * @since  1.0.0
     */
    protected $row = null;

    /**
     * View Rendered Output
     *
     * @var    string
     * @since  1.0.0
     */
    protected $rendered_view = null;

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
        $options            = array('if_exists' => true);

        foreach ($this->dependencies_array as $key => $value) {
            if (isset($this->options[$key])) {
            } else {
                $this->dependencies[$value] = $options;
            }
        }

        return $this->dependencies;
    }

    /**
     * Set Dependencies for Instantiation
     *
     * @return  array
     * @since   1.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function onBeforeInstantiation(array $dependency_values = null)
    {
        parent::onBeforeInstantiation($dependency_values);

        if (isset($this->options['event_name'])) {
            $event_name = $this->options['event_name'];
        } else {
            throw new RuntimeException(
                'EventFactoryMethod: Event name not provided'
            );
        }

        $data = $this->setEventData();

        $return_values = $this->setReturnValues(
            $data['query'],
            $data['runtime_data']->event_options_keys,
            array()
        );

        $this->options['event_name']    = $event_name;
        $this->options['return_values'] = $return_values;
        $this->options['data']          = $data;

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
        $class = $this->product_namespace;

        try {
            $this->product_result = new $class(
                $this->options['event_name'],
                $this->options['return_values'],
                $this->options['data']
            );

        } catch (Exception $e) {
            throw new RuntimeException(
                'Schedule Factory: Could not instantiate Event Scheduled: ' . $class
            );
        }

        return $this;
    }

    /**
     * Set Data Array using Dependencies and Options Array
     *
     * @return  array
     * @since   1.0
     */
    protected function setEventData()
    {
        $this->setClassProperties('dependencies_array');
        $this->setClassProperties('additional_array');

        $data = array();

        $data = $this->initialiseDataArray('dependencies_array', $data);
        $data = $this->initialiseDataArray('additional_array', $data);

        $data = $this->setDataArray('dependencies_array', $data);
        $data = $this->setDataArray('additional_array', $data);

        return $data;
    }

    /**
     * Set Class Properties using Dependencies and Options Array
     *
     * @param   array $property_array
     *
     * @return  $this
     * @since   1.0
     */
    protected function setClassProperties($property_array)
    {
        foreach ($this->$property_array as $key => $value) {

            $key = strtolower($key);

            if (isset($this->dependencies[$value])) {
                $this->$key = $this->dependencies[$value];

            } elseif (isset($this->options[$key])) {
                $this->$key = $this->options[$key];

            } else {
                $this->$key = $this->setNullClassProperty($key);
            }
        }

        return $this;
    }

    /**
     * Set Null Class Property
     *
     * @param   string $key
     *
     * @return  mixed
     * @since   1.0
     */
    protected function setNullClassProperty($key)
    {
        $stdClass_array = array('row', 'parameters', 'model_registry');
        $array          = array('query_results');
        $value          = null;

        if (in_array($key, $stdClass_array)) {
            $value = new stdClass();

        } elseif (in_array($key, $array)) {
            $value = array();
        }

        return $value;
    }

    /**
     * Initialise Data Array
     *
     * @param   array $property_array
     * @param   array $data_array
     *
     * @return  $this
     * @since   1.0
     */
    protected function initialiseDataArray($property_array, $data_array)
    {
        foreach ($this->$property_array as $key => $value) {
            $key              = strtolower($key);
            $data_array[$key] = null;
        }

        return $data_array;
    }

    /**
     * Set Data Array using Dependencies and Options Array
     *
     * @param   array $property_array
     * @param   array $data_array
     *
     * @return  $this
     * @since   1.0
     */
    protected function setDataArray($property_array, $data_array)
    {
        foreach ($this->$property_array as $key => $value) {
            $key              = strtolower($key);
            $data_array[$key] = $this->$key;
        }

        return $data_array;
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
