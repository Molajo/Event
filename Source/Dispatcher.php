<?php
/**
 * Dispatcher
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
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
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class Dispatcher implements DispatcherInterface
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
    protected $callback_events = array();

    /**
     * Class Constructor
     *
     * @param  EventDispatcherInterface $event_dispatcher
     *
     * @since  1.0
     */
    public function __construct(
        EventDispatcherInterface $event_dispatcher,
        array $callback_events = array()
    ) {
        $this->event_dispatcher = $event_dispatcher;

        if (count($callback_events) > 0) {
            $this->registerCallbackEvents($callback_events);
        }
    }

    /**
     * Requester Schedules Event with Dispatcher
     *
     * @param   string         $event_name
     * @param   EventInterface $event
     *
     * @return  $this
     * @since   1.0
     */
    public function scheduleEvent($event_name, EventInterface $event)
    {
        if (isset($this->callback_events[$event_name])) {
            $listeners = $this->sortEventListenersByPriority($event_name);

            return $this->event_dispatcher->triggerListeners($event, $listeners);
        }

        return array();
    }

    /**
     * Sort Listeners by Priority
     *
     * @param   string $event_name
     *
     * @return  $this
     * @since   1.0
     */
    public function sortEventListenersByPriority($event_name)
    {
        $priorities = $this->callback_events[$event_name];
        krsort($priorities);

        $listeners = array();
        foreach ($priorities as $priority => $callbacks) {
            foreach ($callbacks as $callback) {
                $listeners[] = $callback;
            }
        }

        return $listeners;
    }

    /**
     * Listener registers for an Event with the Dispatcher
     *
     * @param   string   $event_name
     * @param   callable $callback
     * @param   int      $priority 0 (lowest) to 100 (highest)
     *
     * @return  mixed
     * @since   1.0
     */
    public function registerForEvent($event_name, $callback, $priority = 50)
    {
        if (isset($this->callback_events[$event_name])) {
            $priorities = $this->callback_events[$event_name];
        } else {
            $priorities = array();
        }

        if (isset($priorities[$priority])) {
            $callback_array = $priorities[$priority];
        } else {
            $callback_array = array();
        }

        $callback_array[]                   = $callback;
        $priorities[]                       = $callback_array;
        $this->callback_events[$event_name] = $priorities;

        return $this;
    }

    /**
     * Requester Schedules Event with Dispatcher
     *
     * @param   array $callback_events
     *
     * @return  $this
     * @since   1.0
     */
    protected function registerCallbackEvents(array $callback_events = array())
    {
        foreach ($callback_events as $event_name => $priorities) {
            if (count($priorities) > 0) {
                $this->registerEventListeners($event_name, $priorities);
            }
        }

        return $this;
    }

    /**
     * Requester Schedules Event with Dispatcher
     *
     * @param   string $event_name
     * @param   array  $callback_events
     *
     * @return  $this
     * @since   1.0
     */
    protected function registerEventListeners($event_name, array $callback_events = array())
    {
        foreach ($callback_events as $priority => $callbacks) {
            if (count($callbacks) > 0) {
                foreach ($callbacks as $callback) {
                    $this->registerForEvent($event_name, $callback, $priority);
                }
            }
        }

        return $this;
    }
}
