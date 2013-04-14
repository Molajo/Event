<?php
/**
 * Create Plugin Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event\Plugins;

use Molajo\Event\Exception\PluginException;

defined('MOLAJO') or die;

/**
 * Create Plugin Interface
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Interface CreatePluginInterface
{
    /**
     * Pre-create processing
     *
     * @return bool
     * @since   1.0
     */
    public function onBeforeCreate();

    /**
     * Post-create processing
     *
     * @return bool
     * @since   1.0
     */
    public function onAfterCreate();
}
