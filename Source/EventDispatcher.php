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
     * Debug Log Callback
     *
     * @var    callable
     * @since  1.0
     */
    protected $debug_callback;

    /**
     * Event Dispatcher triggers Listeners
     *
     * @param   EventInterface $event
     * @param   array          $listeners - array of callable functions
     * @param   callable       $debug_callback
     *
     * @return  array
     * @since   1.0
     */
    public function triggerListeners(
        EventInterface $event,
        array $listeners = array(),
        callable $debug_callback = null
    ) {
        $this->debug_callback = $debug_callback;
        $return_items         = $event->get('return_items');
        $data                 = $event->get('data');
        $event_name           = $event->get('event_name');

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
            return $this->triggerCallable($listener, $event_name, $data, $return_items);
        }

        $message = 'Class: ' . __CLASS__ . ' Method:' . __METHOD__ . ' Type: Event: ' . $event_name;
        $message .= ' Triggering: ' . $listener;

        $this->setDebugMethodCall($message . ' Started', $event_name, $data);

        $instance = $this->instantiateListener($listener, $event_name, $data);

        $data = $this->storeResults($data, $return_items, $instance);

        $this->setDebugMethodCall($message . ' Finished', $event_name, $data);

        return $data;
    }

    /**
     * Instantiate Listener
     *
     * @param   mixed  $listener
     * @param   string $event_name
     * @param   array  $data
     *
     * @return  array
     * @since   1.0
     */
    protected function instantiateListener($listener, $event_name, $data)
    {
        $instance = new $listener($event_name, $listener, $data);
        $instance->$event_name();

        return $instance;
    }

    /**
     * Store Listener Results
     *
     * @param   array  $data
     * @param   array  $return_items
     * @param   object $instance
     *
     * @return  array
     * @since   1.0
     */
    protected function storeResults($data, $return_items, $instance)
    {
        foreach ($return_items as $key) {
            $data[$key] = $instance->get($key);
        }

        unset($instance);

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

    /**
     * Set Debug Method Call
     *
     * @param  string $message
     * @param  string $debug_type
     * @param  array  $context
     *
     * @return  $this
     * @since   1.0
     */
    protected function setDebugMethodCall($message, $debug_type, array $context = array())
    {
        if ($this->debug_callback === null) {
            return $this;
        }

        $debug_callback = $this->debug_callback;

        return $debug_callback($message, $debug_type, $context);
    }
}
