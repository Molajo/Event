<?php
/**
 * Update Plugin Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event\Plugins;

use Molajo\Event\Exception\PluginException;

defined('MOLAJO') or die;

/**
 * Update Plugin Interface
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Interface UpdatePluginInterface
{
    /**
     * Before update processing
     *
     * @return bool
     * @since   1.0
     */
    public function onBeforeUpdate();

    /**
     * After update processing
     *
     * @return bool
     * @since   1.0
     */
    public function onAfterUpdate();
}
