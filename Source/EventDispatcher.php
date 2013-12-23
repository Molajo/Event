<?php
/**
 * Event Dispatcher
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event;

use Exception;
use CommonApi\Event\EventInterface;
use CommonApi\Event\EventDispatcherInterface;
use CommonApi\Exception\UnexpectedValueException;

/**
 * Event Dispatcher
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class EventDispatcher implements EventDispatcherInterface
{
    /**
     * Event Dispatcher triggers Listeners
     *
     * @param   EventInterface $event
     * @param   array          $listeners - array of callable anonymous functions
     *
     * @return  array
     * @since   0.1
     */
    public function triggerListeners(EventInterface $event, array $listeners = array())
    {
        $return_items = $event->get('return_items');

        if (count($listeners) === 0) {
            return $this->getData($event);
        }

        foreach ($listeners as $listener) {

            /** Event Class */
            try {
//echo $listener . ' ' . $event->get('event_name') . '<br />';

                $instance = new $listener(
                    $event->get('event_name'),
                    $listener,
                    $event->get('data')
                );

            } catch (Exception $e) {
                throw new UnexpectedValueException('Event Dispatcher: Could not instantiate Listener: '
                . $listener . ' ' . $e->getMessage());
            }

            /** Event Method */
            $method = '';

            try {
                $method = $event->get('event_name');

                $instance->$method();

            } catch (Exception $e) {
                throw new UnexpectedValueException('Event Dispatcher: Exception from: '
                . $listener . ' ' . $method . ' ' . $e->getMessage());
            }

            foreach ($return_items as $key) {
                $event->set($key, $instance->get($key));
            }
        }

        return $this->getData($event);
    }

    /**
     * Get data from event to return to scheduling process
     *
     * @param   EventInterface $event
     *
     * @return  array
     * @throws  \CommonApi\Exception\UnexpectedValueException
     */
    protected function getData(EventInterface $event)
    {
        $return_items = $event->get('return_items');

        if (count($return_items) === 0) {
            return array();
        }

        $collect = array();

        foreach ($return_items as $key) {

            try {
                $collect[$key] = $event->get($key);

            } catch (Exception $e) {
                throw new UnexpectedValueException('Event Dispatcher Undefined Key: ' . $key);
            }
        }

        return $collect;
    }
}
