<?php
/**
 * Dispatcher
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event;

use CommonApi\Event\EventInterface;
use CommonApi\Event\DispatcherInterface;
use CommonApi\Event\EventDispatcherInterface;
use CommonApi\Exception\UnexpectedValueException;

/**
 * Dispatcher
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
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
     * @since 1.0
     */
    public function __construct(
        EventDispatcherInterface $event_dispatcher,
        array $callback_events = array()
    ) {
        $this->event_dispatcher = $event_dispatcher;

        if (count($callback_events) > 0) {
            $this->callback_events  = $callback_events;
            foreach ($callback_events as $event_name => $listeners) {
                if (count($listeners) > 0) {
                    foreach ($listeners as $listener) {
                        $this->registerForEvent($event_name, $listener, 50);
                    }
                }
            }
        }
    }

    /**
     * Listener registers for an Event with the Dispatcher
     *
     * @param   string   $event_name
     * @param   callable $callback
     * @param   int      $priority 0 (lowest) to 100 (highest)
     *
     * @return  mixed
     * @since   0.1
     */
    public function registerForEvent($event_name, $callback, $priority = 50)
    {
        if (isset($this->callback_events[$event_name])) {
            $listeners = $this->callback_events[$event_name];
        } else {
            $listeners = array();
        }

        $listeners[] = $callback;

        $this->callback_events[$event_name] = $listeners;

        return $this;
    }

    /**
     * Requester Schedules Event with Dispatcher
     *
     * @param   string         $event_name
     * @param   EventInterface $event      CommonApi\Event\EventInterface
     *
     * @return  $this
     * @since   0.1
     */
    public function triggerEvent($event_name, EventInterface $event)
    {
        if (isset($this->callback_events[$event_name])) {
            $listeners = $this->callback_events[$event_name];
            return $this->event_dispatcher->triggerListeners($event, $listeners);
        }

        return array();
    }
}
