<?php
/**
 * Authenticate Plugin Interface
 *
 * @package   Molajo
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Event\Plugins;

use Molajo\Event\Exception\PluginException;

defined('MOLAJO') or die;

/**
 * Authenticate Plugin Interface
 *
 * @author    Amy Stephen
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @since     1.0
 */
Interface AuthenticatePluginInterface
{
    /**
     * Before logging in processing
     *
     * @return  bool
     * @since   1.0
     */
    public function onBeforeLogin();

    /**
     * After Logging in event
     *
     * @return  bool
     * @since   1.0
     */
    public function onAfterLogin();

    /**
     * Before logging out processing
     *
     * @return  bool
     * @since   1.0
     */
    public function onBeforeLogout();

    /**
     * After Logging out event
     *
     * @return  bool
     * @since   1.0
     */
    public function onAfterLogout();
}
