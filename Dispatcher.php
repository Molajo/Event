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
use Exception\Event\DispatcherException;

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
        EventDispatcherInterface $eventdispatcher,
        array $callback_events = array()
    ) {
        $this->event_dispatcher = $eventdispatcher;
        $this->callback_events  = $callback_events;
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
     * @throws  \Exception\Event\DispatcherException
     */
    public function registerForEvent($event_name, callable $callback, $priority = 50)
    {
        if (isset($this->callback_events[$event_name])) {
            $listeners = $this->callback_events[$event_name];
        } else {
            $listeners = array();
        }

        $listeners[] = $callback;

        $this->callback_events[$event_name] = array_unique($listeners);

        return $this;
    }

    /**
     * Requester schedules an Event with Dispatcher
     *
     * @param   string $event_name
     * @param   object $event \CommonApi\Event\EventInterface
     *
     * @return  array
     * @since   1.0
     * @throws  \Exception\Event\DispatcherException
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
