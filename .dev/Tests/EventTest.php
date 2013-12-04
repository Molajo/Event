<?php
/**
 * Event Test
 *
 * @package    Molajo
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event\Tests;

use Molajo\Event\Event;
use CommonApi\Event\EventInterface;
use PHPUnit_Framework_TestCase;

/**
 * Accepted Event
 *
 * @package    Molajo
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0
 */
class EventTest extends PHPUnit_Framework_TestCase
{
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

        $this->assertEquals($event_name, $this->event->get('event_name'));
        $this->assertEquals($return_items, $this->event->get('return_items'));
        $this->assertEquals($data, $this->event->get('data'));

        return;
    }

    /**
     * Test Get Method
     *
     * @covers  Molajo\Event\Event::set
     * @return void
     * @since   1.0
     */
    public function testSet()
    {
        $event_name   = 'Test';
        $return_items = array('data1', 'data2');
        $data         = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->event = new Event($event_name, $return_items, $data);

        $this->event->set('event_name', 'NewName');

        $this->assertEquals('NewName', $this->event->get('event_name'));

        return;
    }

    /**
     * Test Get Exception
     *
     * @covers  Molajo\Event\Event::get
     * @expectedException \CommonApi\Exception\InvalidArgumentException
     * @return  void
     * @since   1.0
     */
    public function testInvalidGetKey()
    {
        $event_name   = 'Test';
        $return_items = array('data1', 'data2');
        $data         = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->event = new Event($event_name, $return_items, $data);

        $this->event->get('key_does_not_exist');

        return;
    }

    /**
     * Test Get Exception
     *
     * @covers  Molajo\Event\Event::get
     * @expectedException \CommonApi\Exception\InvalidArgumentException
     * @return  void
     * @since   1.0
     */
    public function testInvalidSetKey()
    {
        $event_name   = 'Test';
        $return_items = array('data1', 'data2');
        $data         = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->event = new Event($event_name, $return_items, $data);

        $this->event->set('key_does_not_exist', 3);

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
