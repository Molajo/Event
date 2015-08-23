<?php
/**
 * Dispatcher
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event;

use CommonApi\Event\DispatcherInterface;
use CommonApi\Event\EventDispatcherInterface;
use CommonApi\Event\EventInterface;

/**
 * Dispatcher
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
final class Dispatcher implements DispatcherInterface
{
    /**
     * Event Dispatcher
     *
     * @var    object  CommonApi\Event\EventDispatcherInterface
     * @since  1.0
     */
    protected $event_dispatcher = null;

    /**
     * Registered Listeners by Callback
     *
     * @var    array
     * @since  1.0
     */
    protected $class_namespace_events = array();

    /**
     * Class Constructor
     *
     * @param  EventDispatcherInterface $event_dispatcher
     *
     * @since  1.0
     */
    public function __construct(
        EventDispatcherInterface $event_dispatcher
    ) {
        $this->event_dispatcher = $event_dispatcher;
    }

    /**
     * Requester Schedules Event with Dispatcher
     *
     * @param   string         $event_name
     * @param   EventInterface $event CommonApi\Event\EventInterface
     * @param   callable       $debug_callback
     *
     * @return  $this
     * @since   1.0.0
     */
    public function scheduleEvent($event_name, EventInterface $event, callable $debug_callback = null)
    {
        $listeners = array();

        if (isset($this->class_namespace_events[$event_name])) {
            $listeners = $this->sortEventListenersByPriority($event_name);
        }

        return $this->event_dispatcher->triggerListeners($event, $listeners, $debug_callback);
    }

    /**
     * Sort Listeners by Priority
     *
     * @param   string $event_name
     *
     * @return  $this
     * @since   1.0.0
     */
    public function sortEventListenersByPriority($event_name)
    {
        $priorities = $this->class_namespace_events[$event_name];
        krsort($priorities);

        $listeners = array();
        foreach ($priorities as $priority => $class_namespaces) {
            foreach ($class_namespaces as $class_namespace) {
                $listeners[] = $class_namespace;
            }
        }

        return $listeners;
    }

    /**
     * Listener registers for an Event with the Dispatcher
     *
     * @param   string $event_name
     * @param   string $class_namespace
     * @param   int    $priority 1 is highest
     *
     * @return  $this
     * @since   1.0.0
     */
    public function registerForEvent($event_name, $class_namespace, $priority = 50)
    {
        if (isset($this->class_namespace_events[$event_name])) {
            $priorities = $this->class_namespace_events[$event_name];
        } else {
            $priorities = array();
        }

        if (isset($priorities[$priority])) {
            $class_namespace_array = $priorities[$priority];
        } else {
            $class_namespace_array = array();
        }

        $class_namespace_array[]                   = $class_namespace;
        $priorities[$priority]                     = $class_namespace_array;
        $this->class_namespace_events[$event_name] = $priorities;

        return $this;
    }
}
