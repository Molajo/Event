<?php
/**
 * Dispatcher Test
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event;

use CommonApi\Event\EventInterface;
use CommonApi\Event\EventDispatcherInterface;
use Molajo\Event\Scheduled;
use Molajo\Event\Dispatcher;
use PHPUnit_Framework_TestCase;

/**
 * Event Dispatcher
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class DispatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test Get Method
     *
     * @covers  Molajo\Event\Dispatcher::__construct
     *
     * @return void
     * @since   1.0
     */
    public function testGet()
    {
        $event_dispatcher = new MockEventDispatcher();

        $x = function ($event_name, $data) {
            $instance = new ListenerA1 ($event_name, $data);
            if ($event_name === 'onBeforeRead') {
                $instance->set('a', 100);
            }
            return $instance->getData();
        };
        $y = function ($event_name, $data) {
            $instance = new ListenerA2 ($event_name, $data);
            if ($event_name === 'onBeforeUpdate') {
                $instance->set('a', 200);
            }
            return $instance->getData();
        };
        $z = function ($event_name, $data) {
            $instance = new ListenerA3 ($event_name, $data);
            if ($event_name === 'onAfterDelete') {
                $instance->set('a', 300);
            }
            return $instance->getData();
        };

        $dispatcher = new Dispatcher($event_dispatcher);

        $dispatcher->registerForEvent('onBeforeRead', $x, 2);
        $dispatcher->registerForEvent('onBeforeRead', $y, 1);
        $dispatcher->registerForEvent('onBeforeUpdate', $y, 1);
        $dispatcher->registerForEvent('onAfterDelete', $x, 3);
        $dispatcher->registerForEvent('onAfterDelete', $y, 2);
        $dispatcher->registerForEvent('onAfterDelete', $z, 1);

        $return = array('a', 'e');
        $data = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        $event_instance = new Scheduled('onBeforeRead', $return, $data);

        $results = $dispatcher->scheduleEvent('onBeforeRead', $event_instance);

        $this->assertEquals(100, $results['a']);
        $this->assertEquals(5, $results['e']);
        $this->assertEquals(2, count($results));

        return;
    }
    /**
     * Test Get Method
     *
     * @covers  Molajo\Event\Dispatcher::__construct
     *
     * @return void
     * @since   1.0
     */
    public function testNoListeners()
    {
        $event_dispatcher = new MockEventDispatcher();

        $x = function ($event_name, $data) {
            $instance = new ListenerA1 ($event_name, $data);
            if ($event_name === 'onBeforeRead') {
                $instance->set('a', 100);
            }
            return $instance->getData();
        };
        $y = function ($event_name, $data) {
            $instance = new ListenerA2 ($event_name, $data);
            if ($event_name === 'onBeforeUpdate') {
                $instance->set('a', 200);
            }
            return $instance->getData();
        };
        $z = function ($event_name, $data) {
            $instance = new ListenerA3 ($event_name, $data);
            if ($event_name === 'onAfterDelete') {
                $instance->set('a', 300);
            }
            return $instance->getData();
        };

        $dispatcher = new Dispatcher($event_dispatcher);

        $dispatcher->registerForEvent('onBeforeRead', $x, 2);
        $dispatcher->registerForEvent('onBeforeRead', $y, 1);
        $dispatcher->registerForEvent('onBeforeUpdate', $y, 1);
        $dispatcher->registerForEvent('onAfterDelete', $x, 3);
        $dispatcher->registerForEvent('onAfterDelete', $y, 2);
        $dispatcher->registerForEvent('onAfterDelete', $z, 1);

        $return = array('a', 'e');
        $data = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
        $event_instance = new Scheduled('onBeforeRead', $return, $data);

        $results = $dispatcher->scheduleEvent('NotAnEvent', $event_instance);

        $this->assertEquals(1, $results['a']);
        $this->assertEquals(5, $results['e']);

        return;
    }

    /**
     * Tear down
     *
     * @return void
     * @since   1.0
     */
    protected function tearDown()
    {
        parent::tearDown();
    }
}

class MockEventDispatcher implements EventDispatcherInterface
{
    public function triggerListeners(EventInterface $event, array $listeners = array())
    {
        $return_items = $event->get('return_items');
        $data = $event->get('data');

        foreach ($listeners as $listener) {

            $data = $listener($event->get('event_name'), $event->get('data'));

            $event->set('data', $data);
        }

        $new = array();

        foreach ($return_items as $key) {
            $new[$key] = $data[$key];
        }

        return $new;
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
class ListenerA
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

    public function getData()
    {
        return $this->data;
    }
}

class ListenerA1 extends ListenerA
{
}

class ListenerA2 extends ListenerA
{
}

class ListenerA3 extends ListenerA
{
}
