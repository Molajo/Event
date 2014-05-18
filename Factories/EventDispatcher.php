<?php
/**
 * Event Dispatcher
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
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

        $this->getData($event);

        if (count($listeners) === 0) {
            return $this->getData($event);
        }

        $event_name     = $event->get('event_name');
        $model_registry = $event->get('model_registry');

        if (is_array($model_registry)
            && isset($model_registry['plugins'])
            && ($event_name == 'onBeforeRead' || $event_name == 'onAfterRead' || $event_name == 'onAfterReadall')
        ) {
            $plugins = $model_registry['plugins'];

            if (isset($model_registry['get_customfields'])
                && $model_registry['get_customfields'] == 1
                && $event_name == 'onAfterRead'
            ) {
                $plugins[] = 'Customfields';
            }

            $x = array_unique($plugins);
            sort($x);
            $plugins = $x;

            if (count($plugins) > 0 && is_array($plugins)) {

                $filtered = array();

                foreach ($plugins as $plugin) {
                    $qcn = 'Molajo\\Plugins\\' . $plugin . '\\' . $plugin . 'Plugin';

                    if (in_array($qcn, $listeners)) {
                        $filtered[] = $qcn;
                    }
                }

                $listeners = $filtered;
            }
        }

        foreach ($listeners as $listener) {

            /** Event Class */
            try {

//echo 'Listener: ' . $listener . ' ' . $event->get('event_name') . '<br />';

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

        $return_items = array();
        $return_items[] = 'runtime_data';
        $return_items[] = 'plugin_data';
        $return_items[] = 'parameters';
        $return_items[] = 'query';
        $return_items[] = 'model_registry';
        $return_items[] = 'query_results';
        $return_items[] = 'row';
        $return_items[] = 'rendered_view';
        $return_items[] = 'rendered_page';

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
