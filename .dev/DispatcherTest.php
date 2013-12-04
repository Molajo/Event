<?php
/**
 * Dispatcher Test
 *
 * @package    Molajo
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event;

use CommonApi\Event\EventDispatcherInterface;
use Molajo\Event\Dispatcher;
use CommonApi\Event\DispatcherInterface;
use CommonApi\Event\EventInterface;
use PHPUnit_Framework_TestCase;

/**
 * Accepted Dispatcher
 *
 * @package    Molajo
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
class DispatcherTest extends PHPUnit_Framework_TestCase
{
    /**
     * Dispatcher Instance
     *
     * @var    object  CommonApi\Dispatcher\DispatcherInterface
     * @since  1.0
     */
    protected $dispatcher;

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
     * @covers  Molajo\Dispatcher\Dispatcher::get
     * @return void
     * @since   1.0
     */
    public function testGet()
    {
        $event = new Event();
        $event_dispatcher = new EventDispatcher();
        $callback_events = array('1', '2', '3');

        $this->dispatcher = new Dispatcher($event_dispatcher, $callback_events);

        var_dump($this->dispatcher);

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

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * Event Dispatcher triggers Listeners in order of priority
     *
     * @param   EventInterface $event
     * @param   array          $listeners
     *
     * @return  array
     * @since   0.1
     */
    public function triggerListeners(EventInterface $event, array $listeners = array())
    {
        return array($event, $listeners);
    }

    /**
     * Get data from event to return to scheduling process
     *
     * @param   EventInterface  $event
     *
     * @return  array
     */
    public function getData(EventInterface $event)
    {
        return $event;
    }
}


/**
 * Event Schedule
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class Event implements EventInterface
{
    /**
     * Event Name
     *
     * @var    string
     * @since  1.0
     */
    protected $event_name = null;

    /**
     * Return Items
     *
     * List of data items to be returned to the scheduling process
     *
     * @var    array
     * @since  1.0
     */
    protected $return_items = array();

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
        array $return_items = array(),
        array $data = array()
    ) {
        $this->event_name   = $event_name;
        $this->return_items = $return_items;
        $this->data         = $data;
    }

    /**
     * Get a property
     *
     * @param    $key
     *
     * @return   array|null|object|string
     * @since    1.0
     * @throws   \CommonApi\Exception\InvalidArgumentException
     */
    public function get($key)
    {

    }

    /**
     * Set a property value
     *
     * @param    string $key
     * @param    mixed  $value
     *
     * @return   $this
     * @since    1.0
     * @throws   \CommonApi\Exception\InvalidArgumentException
     */
    public function set($key, $value)
    {

    }
}
