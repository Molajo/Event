<?php
/**
 * Read Plugin Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event\Plugins;

use Molajo\Event\Exception\PluginException;

defined('MOLAJO') or die;

/**
 * Read Plugin Interface
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Interface ReadPluginInterface
{
    /**
     * Pre-read processing
     *
     * @return bool
     * @since   1.0
     */
    public function onBeforeRead();

    /**
     * Post-read processing - one row at a time
     *
     * @return bool
     * @since   1.0
     */
    public function onAfterRead();

    /**
     * Post-read processing - all rows at one time from query_results
     *
     * @return bool
     * @since   1.0
     */
    public function onAfterReadall();
}
