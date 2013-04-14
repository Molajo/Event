<?php
/**
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event\Plugins\Logout;

use Molajo\Event\Plugins\Plugin;

defined('MOLAJO') or die;

/**
 * Logout
 *
 * @package     Molajo
 * @license     MIT
 * @since       1.0
 */
class LogoutPlugin extends Plugin
{

    /**
     * Before Authenticating the Logout Process
     *
     * @return boolean
     * @since   1.0
     */
    public function onBeforeLogout()
    {
        return false;
    }

    /**
     * After Authenticating the Logout Process
     *
     * @return boolean
     * @since   1.0
     */
    public function onAfterLogout()
    {
        return false;
    }
}
