<?php
/**
 * Scheduled Event Test
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event\Tests;

use Molajo\Event\Scheduled;
use PHPUnit_Framework_TestCase;

/**
 * Scheduled Event Test
 *
 * @package    Molajo
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @since      1.0.0
 */
class ScheduledTest extends PHPUnit_Framework_TestCase
{
    /**
     * Scheduled Event Instance
     *
     * @var    object  CommonApi\Event\EventInterface
     * @since  1.0
     */
    protected $scheduled;

    /**
     * Set up
     *
     * @covers  Molajo\Event\Scheduled::__construct
     *
     * @return void
     * @since   1.0
     */
    protected function setUp()
    {
        $event_name   = null;
        $return_items = array();
        $data         = array();

        $this->scheduled = new Scheduled($event_name, $return_items, $data);
    }

    /**
     * Test Get Method
     *
     * @covers  Molajo\Event\Scheduled::__construct
     * @covers  Molajo\Event\Scheduled::get
     *
     * @return  void
     * @since   1.0
     */
    public function testGet()
    {
        $scheduled_name = 'Test';
        $return_items   = array('data1', 'data2');
        $data           = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->scheduled = new Scheduled($scheduled_name, $return_items, $data);

        $this->assertEquals($scheduled_name, $this->scheduled->get('event_name'));
        $this->assertEquals($return_items, $this->scheduled->get('return_items'));
        $this->assertEquals($data, $this->scheduled->get('data'));

        return;
    }

    /**
     * Test Get Method Data array
     *
     * @covers  Molajo\Event\Scheduled::__construct
     * @covers  Molajo\Event\Scheduled::get
     *
     * @return  void
     * @since   1.0
     */
    public function testGetData()
    {
        $scheduled_name = 'Test';
        $return_items   = array('data1', 'data2');
        $data           = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->scheduled = new Scheduled($scheduled_name, $return_items, $data);

        $this->assertEquals(1, $this->scheduled->get('data1'));
        $this->assertEquals(2, $this->scheduled->get('data2'));
        $this->assertEquals(3, $this->scheduled->get('data3'));

        return;
    }

    /**
     * Test Set Method
     *
     * @covers  Molajo\Event\Scheduled::__construct
     * @covers  Molajo\Event\Scheduled::set
     *
     * @return  void
     * @since   1.0
     */
    public function testSet()
    {
        $scheduled_name = 'Test';
        $return_items   = array('data1', 'data2');
        $data           = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->scheduled = new Scheduled($scheduled_name, $return_items, $data);

        $this->scheduled->set('event_name', 'NewName');

        $this->assertEquals('NewName', $this->scheduled->get('event_name'));

        return;
    }

    /**
     * Test Set Data Method
     *
     * @covers  Molajo\Event\Scheduled::__construct
     * @covers  Molajo\Event\Scheduled::set
     *
     * @return  void
     * @since   1.0
     */
    public function testSetData()
    {
        $scheduled_name = 'Test';
        $return_items   = array('data1', 'data2');
        $data           = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->scheduled = new Scheduled($scheduled_name, $return_items, $data);

        $this->scheduled->set('data1', 10);
        $this->scheduled->set('data2', 20);
        $this->scheduled->set('data3', 30);

        $this->assertEquals(10, $this->scheduled->get('data1'));
        $this->assertEquals(20, $this->scheduled->get('data2'));
        $this->assertEquals(30, $this->scheduled->get('data3'));

        return;
    }

    /**
     * Test Get Exception
     *
     * @covers                   Molajo\Event\Scheduled::__construct
     * @covers                   Molajo\Event\Scheduled::get
     *
     * @expectedException \CommonApi\Exception\InvalidArgumentException
     * @expectedExceptionMessage Event: Invalid Get Key: key_does_not_exist
     *
     * @return  void
     * @since                    1.0
     */
    public function testInvalidGetKey()
    {
        $scheduled_name = 'Test';
        $return_items   = array('data1', 'data2');
        $data           = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->scheduled = new Scheduled($scheduled_name, $return_items, $data);

        $this->scheduled->get('key_does_not_exist');

        return;
    }

    /**
     * Test Set Exception
     *
     * @covers                   Molajo\Event\Scheduled::__construct
     * @covers                   Molajo\Event\Scheduled::set
     *
     * @expectedException \CommonApi\Exception\InvalidArgumentException
     * @expectedExceptionMessage Event: Invalid Set Key: key_does_not_exist
     *
     * @return  void
     * @since                    1.0
     */
    public function testInvalidSetKey()
    {
        $scheduled_name = 'Test';
        $return_items   = array('data1', 'data2');
        $data           = array('data1' => 1, 'data2' => 2, 'data3' => 3);

        $this->scheduled = new Scheduled($scheduled_name, $return_items, $data);

        $this->scheduled->set('key_does_not_exist', 3);

        return;
    }
}
