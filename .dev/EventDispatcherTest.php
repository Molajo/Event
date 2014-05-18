<?php
/**
 * Event Dispatcher Test
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event;

use Molajo\Event\Scheduled;
use Molajo\Event\ScheduledDispatcher;
use PHPUnit_Framework_TestCase;

/**
 * Event Dispatcher
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class EventDispatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * Event Dispatcher Instance
     *
     * @var    object  CommonApi\Event\EventDispatcherInterface
     * @since  1.0
     */
    protected $event_dispatcher;

    /**
     * Event Instance
     *
     * @var    object  CommonApi\Event\EventInterface
     * @since  1.0
     */
    protected $event;

    /**
     * Test Get Method
     *
     * @covers  Molajo\Event\Scheduled::get
     * @return void
     * @since   1.0
     */
    public function testGet()
    {
        $listeners = array(

            $x = function ($event_name, $data) {
                $class    = 'Molajo\Event\ListenerZ1';
                $instance = new $class ($event_name, $data);
                return $instance;
            },
            $x = function ($event_name, $data) {
                $class    = 'Molajo\Event\ListenerZ2';
                $instance = new $class ($event_name, $data);
                return $instance;
            },
            $x = function ($event_name, $data) {
                $class    = 'Molajo\Event\ListenerZ3';
                $instance = new $class ($event_name, $data);
                return $instance;
            }
        );

        $event_name   = 'Test';
        $return_items = array('data1', 'data2');
        $data         = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->event = new Event($event_name, $return_items, $data);

        $this->event_dispatcher = new EventDispatcher();
        $results                = $this->event_dispatcher->triggerListeners($this->event, $listeners);

        $this->assertEquals($data['data1'], $results['data1']);
        $this->assertEquals($data['data2'], $results['data2']);
        $this->assertEquals(2, count($results));

        return;
    }
}

/**
 * Mock Listener Classes
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class ListenerZ
{
    /**
     * Return Items
     *
     * List of data items to be returned to the scheduling process
     *
     * @var    array
     * @since  1.0
     */
    protected $event_name = array();

    /**
     * Data
     *
     * Array of properties
     *
     * @var    array
     * @since  1.0
     */
    protected $data = array();

    /**
     * Constructor
     *
     * @param  null  $event_name
     * @param  array $return_items
     * @param  array $data
     *
     * @since  1.0
     */
    public function __construct(
        $event_name = null,
        array $data = array()
    ) {
        $this->event_name = $event_name;
        $this->data       = $data;
    }

    public function get($key)
    {
        return $this->data[$key];
    }

    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function test()
    {

    }
}

class ListenerZ1 extends ListenerZ
{
}

class ListenerZ2 extends ListenerZ
{
}

class ListenerZ3 extends ListenerZ
{
}
