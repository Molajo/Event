<?php
/**
 * System Event Plugin
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 */
namespace Molajo\Plugin;

use CommonApi\Event\SystemInterface;
use CommonApi\Exception\RuntimeException;

/**
 * System Event Plugin
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2013 Amy Stephen. All rights reserved.
 * @since      1.0
 */
abstract class SystemEventPlugin extends AbstractPlugin implements SystemInterface
{
    /**
     * Before Initialise Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeInitialise()
    {
        return $this;
    }

    /**
     * After Initialise Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterInitialise()
    {
        return $this;
    }

    /**
     * Before Route Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeRoute()
    {
        return $this;
    }

    /**
     * After Route Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterRoute()
    {
        return $this;
    }

    /**
     * Before Authorise Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeAuthorise()
    {
        return $this;
    }

    /**
     * After Authorise Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterAuthorise()
    {
        return $this;
    }

    /**
     * Before Execute Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeExecute()
    {
        return $this;
    }

    /**
     * After Execute Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterExecute()
    {
        return $this;
    }

    /**
     * Before Render Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeRender()
    {
        return $this;
    }

    /**
     * After Render Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterRender()
    {
        return $this;
    }
    /**
     * Before Response Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeResponse()
    {
        return $this;
    }

    /**
     * After Response Processing
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterResponse()
    {
        return $this;
    }
}
