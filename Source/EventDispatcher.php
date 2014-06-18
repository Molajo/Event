<?php
/**
 * Event Dispatcher
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event;

use CommonApi\Event\EventInterface;
use CommonApi\Event\EventDispatcherInterface;

/**
 * Event Dispatcher
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * Event Dispatcher triggers Listeners
     *
     * @param   EventInterface $event
     * @param   array          $listeners - array of callable functions
     *
     * @return  array
     * @since   1.0
     */
    public function triggerListeners(EventInterface $event, array $listeners = array())
    {
        $return_items = $event->get('return_items');
        $data         = $event->get('data');
        $event_name   = $event->get('event_name');

        if (count($listeners) > 0) {
            foreach ($listeners as $listener) {
                $data = $this->triggerListener($listener, $event_name, $data, $return_items);
            }
        }

        $new = array();
        foreach ($return_items as $key) {
            $new[$key] = $data[$key];
        }

        return $new;
    }

    /**
     * Trigger Listener
     *
     * @param   mixed  $listener
     * @param   string $event_name
     * @param   array  $data
     * @param   array  $return_items
     *
     * @return  array
     * @since   1.0
     */
    protected function triggerListener($listener, $event_name, $data, $return_items)
    {
        if (is_callable($listener)) {
            return $this->triggerListener($listener, $event_name, $data, $return_items);
        }

        $instance = new $listener($event_name, $listener, $data);
        $instance->$event_name();
        foreach ($return_items as $key) {
            $data[$key] = $instance->get($key);
        }

        return $data;
    }

    /**
     * Trigger Callable
     *
     * @param   callable $listener
     * @param   string   $event_name
     * @param   array    $data
     * @param   array    $return_items
     *
     * @return  array
     * @since   1.0
     */
    protected function triggerCallable($listener, $event_name, $data, $return_items)
    {
        return $listener($event_name, $data, $return_items);
    }
}
