<?php
/**
 * Update Event Plugin
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Plugins;

use CommonApi\Event\UpdateInterface;

/**
 * Create Event Plugin
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
abstract class UpdateEventPlugin extends AbstractPlugin implements UpdateInterface
{
    /**
     * Before update processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeUpdate()
    {
    }

    /**
     * After update processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterUpdate()
    {
    }
}
