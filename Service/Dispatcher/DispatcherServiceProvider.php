<?php
/**
 * Event Dispatcher Service Provider
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Service\Dispatcher;

use Exception;
use CommonApi\Exception\RuntimeException;
use Molajo\IoC\AbstractServiceProvider;
use CommonApi\IoC\ServiceProviderInterface;

/**
 * Event Dispatcher Service Provider
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class DispatcherServiceProvider extends AbstractServiceProvider implements ServiceProviderInterface
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
        $options['service_namespace']        = 'Molajo\\Event\\Dispatcher';
        $options['store_instance_indicator'] = true;
        $options['service_name']             = basename(__DIR__);

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
        parent::setDependencies();

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
        $class            = 'Molajo\\Event\\EventDispatcher';
        $event_dispatcher = new $class();

        $callback_events = $this->readFile(
            BASE_FOLDER . '/vendor/molajo/resource/Source/Files/Output/Events.json'
        );

        $class = 'Molajo\\Event\\Dispatcher';

        try {
            $this->service_instance = new $class(
                $event_dispatcher,
                $callback_events
            );
        } catch (Exception $e) {
            throw new RuntimeException
            ('Render: Could not instantiate Handler: ' . $class);
        }

        return $this;
    }

    /**
     * Read File
     *
     * @param  string $file_name
     * @param  string $property_name_array
     *
     * @since  1.0
     */
    protected function readFile($file_name)
    {
        if (file_exists($file_name)) {
        } else {
            return array();
        }

        $input = file_get_contents($file_name);
        $temp  = json_decode($input);

        if (count($temp) > 0) {
            $events = array();

            foreach ($temp as $key => $classes) {

                $functions = array();
                foreach ($classes as $class) {
                    $functions[] = $class;
                }

                sort($functions);
                $events[$key] = $functions;
            }
        }

        ksort($events);

        return $events;
    }
}
