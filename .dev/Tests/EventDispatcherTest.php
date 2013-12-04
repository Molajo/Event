<?php
/**
 * Event Dispatcher Test
 *
 * @package    Molajo
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event;

use Molajo\Event\Event;
use Molajo\Event\EventDispatcher;
use CommonApi\Event\EventInterface;
use CommonApi\Event\EventDispatcherInterface;
use PHPUnit_Framework_TestCase;

/**
 * Event Dispatcher
 *
 * @package    Molajo
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
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
     * @covers  Molajo\Event\Event::get
     * @return void
     * @since   1.0
     */
    public function testGet()
    {
        $event_name   = 'Test';
        $return_items = array('data1', 'data2');
        $data         = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->event = new Event($event_name, $return_items, $data);

        $listeners     = array('Molajo\Event\Listener1', 'Molajo\Event\Listener2', 'Molajo\Event\Listener3');

        $this->event_dispatcher = new EventDispatcher();
        $results = $this->event_dispatcher->triggerListeners($this->event, $listeners);
        var_dump($results);
/**
        $this->assertEquals($event_name, $this->event->get('event_name'));
        $this->assertEquals($return_items, $this->event->get('return_items'));
        $this->assertEquals($data, $this->event->get('data'));
*/
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

/**
 * Event Dispatcher
 *
 * @package    Molajo
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
class Listener
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
        $this->event_name   = $event_name;
        $this->data         = $data;
    }
}

class Listener1 extends Listener
{
    public function get ($key)
    {

    }
    public function set ($key, $value)
    {

    }
    public function test ()
    {

    }
}
class Listener2 extends Listener
{
    public function get ($key)
    {

    }
    public function set ($key, $value)
    {

    }
    public function test ()
    {

    }
}
class Listener3 extends Listener
{
    public function get ($key)
    {

    }
    public function set ($key, $value)
    {

    }
    public function test ()
    {

    }
}
