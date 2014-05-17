<?php
/**
 * Dispatcher Test
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event;

use Molajo\Event\Scheduled;
use CommonApi\Event\EventInterface;
use CommonApi\Event\DispatcherInterface;
use CommonApi\Event\EventDispatcherInterface;
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
     * Dispatcher Instance
     *
     * @var    object  CommonApi\Event\DispatcherInterface
     * @since  1.0
     */
    protected $dispatcher;

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
     * Set up
     *
     * @return void
     * @since   1.0
     */
    protected function setUp()
    {

    }

    /**
     * Test Get Method
     *
     * @covers  Molajo\Event\Scheduled::get
     * @return void
     * @since   1.0
     */
    public function testGet()
    {
        $class            = 'Molajo\\Event\\EventDispatcher';
        $event_dispatcher = new $class();

        $listeners = array(
            'test' => array(

                $x = function ($event_name, $data) {
                    $class    = 'Molajo\Event\ListenerA1';
                    $instance = new $class ($event_name, $data);
                    return $instance;
                },
                $x = function ($event_name, $data) {
                    $class    = 'Molajo\Event\ListenerA2';
                    $instance = new $class ($event_name, $data);
                    return $instance;
                },
                $x = function ($event_name, $data) {
                    $class    = 'Molajo\Event\ListenerA3';
                    $instance = new $class ($event_name, $data);
                    return $instance;
                }
            )
        );

        $class    = 'Molajo\\Event\\Dispatcher2';
        $instance = new $class($event_dispatcher, $listeners);

        $callback = function ($event_name, $data) {
            $class    = 'Molajo\Event\ListenerA4';
            $instance = new $class ($event_name, $data);
            return $instance;
        };

        $instance->registerForEvent('Wacky', $callback);
        $this->assertEquals(array($callback), $instance->getWacky());


        $event_name   = 'Test';
        $return_items = array('data1', 'data2');
        $data         = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $event_instance = new Event($event_name, $return_items, $data);

        $results = $instance->scheduleEvent('test', $event_instance);

        $this->assertEquals($data['data1'], $results['data1']);
        $this->assertEquals($data['data2'], $results['data2']);
        $this->assertEquals(2, count($results));

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

class Dispatcher2 extends Dispatcher implements DispatcherInterface
{
    public function getWacky()
    {
        return $this->callback_events['Wacky'];
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

    public function test()
    {

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
