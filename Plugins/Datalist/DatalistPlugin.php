<?php
/**
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event\Plugins\Datalist;

use Molajo\Event\Plugins\Plugin;

defined('MOLAJO') or die;

/**
 * @package     Molajo
 * @license     MIT
 * @since       1.0
 */
class DatalistPlugin extends Plugin
{
    /**
     * Prepares list of Datalist Lists
     *
     * @return boolean
     * @since   1.0
     */
    public function onAfterRoute()
    {
        if (APPLICATION_ID == 2) {
        } else {
            return true;
        }

        if (Services::Registry()->exists('Datalist', 'Datalists')) {
            return true;
        }

        $files = Services::Filesystem()->folderFiles(VENDOR_MOLAJO_FOLDER . '/Mvc' . '/Model/Datalist');
        if (count($files) === 0 || $files === false) {
            $dataLists = array();
        } else {
            $dataLists = $this->processFiles($files);
        }

        $resourceFiles = Services::Filesystem()->folderFiles(
            $this->get('extension_path', '', 'parameters')
                . '/Model/Datalist'
        );

        if (count($resourceFiles) == 0 || $resourceFiles === false) {
            $resourceLists = array();
        } else {
            $resourceLists = $this->processFiles($resourceFiles);
        }

        $new   = array_merge($dataLists, $resourceLists);
        $newer = array_unique($new);
        sort($newer);

        $datalist = array();

        foreach ($newer as $file) {
            $temp_row        = new \stdClass();
            $temp_row->value = $file;
            $temp_row->id    = $file;
            $datalist[]      = $temp_row;
        }

        Services::Registry()->set('Datalist', 'Datalists', $datalist);

        return true;
    }

    /**
     * Prepares list of Datalist Lists
     *
     * @return boolean
     * @since   1.0
     */
    protected function processFiles($files)
    {
        $fileList = array();

        foreach ($files as $file) {

            $length = strlen($file) - strlen('.xml');
            $value  = substr($file, 0, $length);

            $fileList[] = $value;
        }

        return $fileList;
    }
}
