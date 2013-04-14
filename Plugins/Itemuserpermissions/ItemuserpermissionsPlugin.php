<?php
/**
 * @package   Molajo
 * @copyright 2013 Amy Stephen. All rights reserved.
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 */
namespace Molajo\Event\Plugins\Itemuserpermissions;

use Molajo\Event\Plugins\Plugin;

defined('MOLAJO') or die;

/**
 * Item Snippet
 *
 * @package     Molajo
 * @license     MIT
 * @since       1.0
 */
class ItemuserpermissionsPlugin extends Plugin
{

    /**
     * After-read processing
     *
     * Use with Grid to determine permissions for buttons and items
     * Validate action-level user permissions on each row - relies upon catalog_id
     *
     * @return boolean
     * @since   1.0
     */
    public function onAfterRead()
    {
        if (isset($this->row->catalog_id)) {
        } else {
            return false;
        }

        $actions = $this->get('toolbar_buttons', '', 'parameters');

        $actionsArray = explode(',', $actions);

        $permissions = Services::Permissions()
            ->verifyTaskList($actionsArray, $this->row->catalog_id);

        foreach ($actionsArray as $action) {
            if ($permissions[$action] === true) {
                $field             = $action . 'Permission';
                $this->row->$field = $permissions[$action];
            }
        }

        return true;
    }
}