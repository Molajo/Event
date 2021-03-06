<?php
/**
 * Event Dispatch Factory Method
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Factories\Dispatch;

use Exception;
use CommonApi\Exception\RuntimeException;
use CommonApi\IoC\FactoryInterface;
use CommonApi\IoC\FactoryBatchInterface;
use Molajo\IoC\FactoryMethod\Base as FactoryMethodBase;

/**
 * Event Dispatch Factory Method
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class DispatchFactoryMethod extends FactoryMethodBase implements FactoryInterface, FactoryBatchInterface
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
        $options['product_namespace']        = 'Molajo\\Event\\Dispatcher';
        $options['store_instance_indicator'] = true;
        $options['product_name']             = basename(__DIR__);

        parent::__construct($options);
    }

    /**
     * Define dependencies or use dependencies automatically defined by base class using Reflection
     *
     * @return  array
     * @since   1.0.0
     * @throws  \CommonApi\Exception\RuntimeException
     */
    public function setDependencies(array $reflection = array())
    {
        parent::setDependencies(array());

        $this->dependencies = array();

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
        $class            = 'Molajo\\Event\\EventDispatcher';
        $event_dispatcher = new $class();

        $class = 'Molajo\\Event\\Dispatcher';

        try {
            $this->product_result = new $class(
                $event_dispatcher
            );

        } catch (Exception $e) {
            throw new RuntimeException(
                'Render: Could not instantiate Handler: ' . $class
            );
        }

        return $this;
    }

    /**
     * Follows the completion of the instantiate method
     *
     * @return  $this
     * @since   1.0.0
     */
    public function onAfterInstantiation()
    {
        $events = $this->readFile(
            $this->base_path . '/Bootstrap/Files/Output/Events.json'
        );

        foreach ($events as $event_name => $class_namespace_events) {

            foreach ($class_namespace_events as $class_namespace) {
                $this->product_result->registerForEvent($event_name, $class_namespace, 1);
            }
        }
    }
}
