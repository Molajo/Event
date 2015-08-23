<?php
/**
 * Scheduled Event
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event;

use CommonApi\Event\EventInterface;
use CommonApi\Exception\InvalidArgumentException;

/**
 * Scheduled Event
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014-2015 Amy Stephen. All rights reserved.
 * @since      1.0.0
 */
final class Scheduled implements EventInterface
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
     * @var    array
     * @since  1.0
     */
    protected $return_items = array();

    /**
     * Data
     *
     * @var    array
     * @since  1.0
     */
    protected $data = array();

    /**
     * Class Properties
     *
     * @var    array
     * @since  1.0
     */
    protected $properties = array('event_name', 'return_items', 'data');

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
//echo '<br><br><br><br> EVENT:: ' . $event_name . '<br>';
        $this->event_name   = $event_name;
        $this->return_items = $return_items;
        $this->data         = $data;
    }

    /**
     * Get a property
     *
     * @param    $key
     *
     * @return   mixed
     * @since    1.0.0
     * @throws   \CommonApi\Exception\InvalidArgumentException
     */
    public function get($key)
    {
        $key = strtolower($key);

        if (in_array($key, $this->properties)) {
            return $this->$key;
        }

        if (isset($this->data[$key])) {
            return $this->data[$key];
        }

        throw new InvalidArgumentException('Event: Invalid Get Key: ' . $key);
    }

    /**
     * Set a property value
     *
     * @param    string $key
     * @param    mixed  $value
     *
     * @return   $this
     * @since    1.0.0
     * @throws   \CommonApi\Exception\InvalidArgumentException
     */
    public function set($key, $value)
    {
        $key = strtolower($key);

        if (in_array($key, $this->properties)) {
            $this->$key = $value;
            return $this;
        }

        if (isset($this->data[$key])) {
            $this->data[$key] = $value;
            return $this;
        }

        throw new InvalidArgumentException('Event: Invalid Set Key: ' . $key);
    }
}
