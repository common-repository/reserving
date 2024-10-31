<?php

namespace Reserving;

class Installer
{
    public function plugin_activate()
    {
        $this->add_roles();
    }

    public function add_roles()
    {
        if (!get_role('branch_manager')) {
            add_role('branch_manager', esc_html__('Branch Manager', 'reserving'), array('read' => true, 'level_0' => true));
        }

        if (!get_role('kitchen_manager')) {
            add_role('kitchen_manager', esc_html__('Kitchen Manager', 'reserving'), array('read' => true, 'level_0' => true));
        }

        if (!get_role('delivery_man')) {
            add_role('delivery_man', esc_html__('Delivery Man', 'reserving'), array('read' => true, 'level_0' => true));
        }
    }

    public function plugin_deactivate()
    {
        $this->remove_roles();
    }

    public function remove_roles()
    {
        remove_role('branch_manager');
        remove_role('kitchen_manager');
        remove_role('delivery_man');
    }
}
