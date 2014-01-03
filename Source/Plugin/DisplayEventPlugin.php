<?php
/**
 * Display Event for Molajo Plugins
 *
 * @package    Molajo
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 */
namespace Molajo\Plugin;

use CommonApi\Event\DisplayInterface;
use CommonApi\Exception\RuntimeException;

/**
 * Display Abstract Class
 *
 * @author     Amy Stephen
 * @license    http://www.opensource.org/licenses/mit-license.html MIT License
 * @copyright  2014 Amy Stephen. All rights reserved.
 * @since      1.0
 */
abstract class DisplayEventPlugin extends AbstractPlugin implements DisplayInterface
{
    /**
     * After Route and Authorisation, the Theme/Page are parsed
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeParse()
    {
        return $this;
    }

    /**
     * After the body render is complete and before the document head rendering starts
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeParseHead()
    {
        return $this;
    }

    /**
     * After the Read Query has executed but Before Query results are injected into the View
     *
     * @return  $this
     * @since   1.0
     */
    public function onBeforeRenderView()
    {
        return $this;
    }

    /**
     * After the View has been rendered but before the output has been passed back to the Includer
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterRenderView()
    {
        return $this;
    }

    /**
     * On after parsing and rendering is complete
     *
     * @return  $this
     * @since   1.0
     */
    public function onAfterParse()
    {
        return $this;
    }
}
