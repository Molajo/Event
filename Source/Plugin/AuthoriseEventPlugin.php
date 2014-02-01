<?php
/**
 * Authorise Event Plugin
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Plugin;

use CommonApi\Event\AuthoriseInterface;

/**
 * Authorise Event Plugin
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
abstract class AuthoriseEventPlugin extends AbstractPlugin implements AuthoriseInterface
{
    /**
     * Before Authorisation
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeAuthorise()
    {
        return $this;
    }

    /**
     * After Authorisation
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterAuthorise()
    {
        return $this;
    }
}
