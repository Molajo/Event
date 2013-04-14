<?php
/**
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event\Plugins\Events;

use Molajo\Event\Plugins\Plugin;

defined('MOLAJO') or die;

/**
 * @package     Molajo
 * @license     MIT
 * @since       1.0
 */
class EventsPlugin extends Plugin
{
    /**
     * Generates list of Events for use in Datalists
     *
     * @return boolean
     * @since   1.0
     */
    public function onAfterInitialise()
    {
        if (APPLICATION_ID == 2) {
        } else {
            return true;
        }

        $events = array(
            'onConnectDatabase',
            'onAfterInitialise',
            'onAfterRoute',
            'onAfterAuthorise',
            'onBeforeParse',
            'onBeforeParseHead',
            'onBeforeInclude',
            'onBeforeRead',
            'onAfterRead',
            'onAfterReadall',
            'onBeforeRenderview',
            'onAfterRenderview',
            'onAfterInclude',
            'onAfterParse',
            'onAfterExecute',
            'onAfterResponse',
            'onBeforeCreate',
            'onAfterCreate',
            'onBeforeUpdate',
            'onAfterUpdate',
            'onBeforDdelete',
            'onAfterDelete',
            'onAfterLogin',
            'onBeforeLogin',
            'onAfterLogout',
            'onBeforeLogout'
        );

        foreach (Services::Events()->get('Events') as $e) {
            if (in_array(strtolower($e), array_map('strtolower', $events))) {
            } else {
                $events[] = $e;
            }
        }

        $eventArray = array();
        foreach ($events as $key) {

            $temp_row = new \stdClass();

            $temp_row->id    = $key;
            $temp_row->value = trim($key);

            $eventArray[] = $temp_row;
        }

        Services::Registry()->set('Datalist', 'EventsList', $eventArray);

        return true;
    }
}
