<?php
/**
 * Scheduled Event
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event;

use CommonApi\Event\EventInterface;
use CommonApi\Exception\InvalidArgumentException;

/**
 * Scheduled Event
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
class Scheduled implements EventInterface
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
     * @return   mixed
     * @since    0.1
     * @throws   \CommonApi\Exception\InvalidArgumentException
     */
    public function get($key)
    {
        $key = strtolower($key);

        if ($key == 'event_name') {
            return $this->event_name;

        } elseif ($key == 'return_items') {
            return $this->return_items;

        } elseif ($key == 'data') {
            return $this->data;

        } elseif (isset($this->data[$key])) {
            return $this->data[$key];
        }

        throw new InvalidArgumentException
        ('Event: Invalid Get Key: ' . $key);
    }

    /**
     * Set a property value
     *
     * @param    string $key
     * @param    mixed  $value
     *
     * @return   $this
     * @since    0.1
     * @throws   \CommonApi\Exception\InvalidArgumentException
     */
    public function set($key, $value)
    {
        $key = strtolower($key);

        if ($key == 'event_name') {
            $this->event_name = $value;

        } elseif (isset($this->data[$key])) {
            $this->data[$key] = $value;

        } else {
            throw new InvalidArgumentException
            ('Event: Invalid Set Key: ' . $key);
        }

        return $this;
    }
}
