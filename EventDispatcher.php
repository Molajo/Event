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
use Exception\Event\EventDispatcherException;

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
     * Event Dispatcher triggers Listeners in order of priority
     *
     * @param   EventInterface $event
     * @param   array          $listeners
     *
     * @return  array
     * @since   1.0
     * @throws  \Exception\Event\EventDispatcherException
     */
    public function triggerListeners(EventInterface $event, array $listeners = array())
    {
        if (count($listeners) === 0) {
            return array(
                $event->get('runtime_data'),
                $event->get('parameters'),
                $event->get('query'),
                $event->get('model_registry'),
                $event->get('query_results'),
                $event->get('rendered_view'),
                $event->get('rendered_page')
            );
        }

        foreach ($listeners as $listener) {

            /** Event Class */
            try {
                $instance = new $listener (
                    $listener,
                    $event->get('event_name'),
                    $event->get('resources'),
                    $event->get('fieldhandler'),
                    $event->get('date_controller'),
                    $event->get('url_controller'),
                    $event->get('language_controller'),
                    $event->get('authorisation_controller'),
                    $event->get('runtime_data'),
                    $event->get('parameters'),
                    $event->get('query'),
                    $event->get('model_registry'),
                    $event->get('query_results'),
                    $event->get('rendered_view'),
                    $event->get('rendered_page')
                );

            } catch (Exception $e) {
                throw new EventDispatcherException('Event Dispatcher: Could not instantiate Listener: '
                . $listener . ' ' . $e->getMessage());
            }

            /** Event Method */
            try {
                $method = $event->get('event_name');

                $instance->$method();
            } catch (Exception $e) {
                throw new EventDispatcherException('Event Dispatcher: Exception from: '
                . $listener . ' ' . $method . ' ' . $e->getMessage());
            }

            $event->set('runtime_data', $instance->get('runtime_data'));
            $event->set('parameters', $instance->get('parameters'));
            $event->set('query', $instance->get('query'));
            $event->set('model_registry', $instance->get('model_registry'));
            $event->set('query_results', $instance->get('query_results'));
            $event->set('rendered_view', $instance->get('rendered_view'));
            $event->set('rendered_page', $instance->get('rendered_page'));
        }

        $results                   = array();
        $results['runtime_data']   = $event->get('runtime_data');
        $results['parameters']     = $event->get('parameters');
        $results['query']          = $event->get('query');
        $results['model_registry'] = $event->get('model_registry');
        $results['query_results']  = $event->get('query_results');
        $results['rendered_view']  = $event->get('rendered_view');
        $results['rendered_page']  = $event->get('rendered_page');

        return $results;
    }
}
