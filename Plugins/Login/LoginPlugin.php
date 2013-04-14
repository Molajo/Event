<?php
/**
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event\Plugins\login;

use Molajo\Event\Plugins\Plugin;

defined('MOLAJO') or die;

/**
 * login
 *
 * @package     Molajo
 * @license     MIT
 * @since       1.0
 */
class LoginPlugin extends Plugin
{
    /**
     * Before Authenticating the Login Process
     *
     * @return boolean
     * @since   1.0
     */
    public function onBeforeLogin()
    {
        return false;
    }

    /**
     * After Authenticating the Login Process
     *
     * @return boolean
     * @since   1.0
     */
    public function onAfterLogin()
    {
        return false;
    }
}
