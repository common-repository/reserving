<?php

namespace Reserving\base\cpt;

abstract class Custom_Taxonomy
{
    public $taxonomies = [];

    public function init($type, $singular_label, $plural_label, $post_types, $settings = array())
    {

        $default_settings = array(

            'labels' => array(
                'name'                  => $plural_label,
                'singular_name'         => $singular_label,
                'add_new_item'          => esc_html__('Add New ' . $singular_label, 'reserving'),
                'new_item_name'         => esc_html__('Add New ' . $singular_label, 'reserving'),
                'edit_item'             => esc_html__('Edit ' . $singular_label, 'reserving'),
                'update_item'           => esc_html__('Update ' . $singular_label, 'reserving'),
                'add_or_remove_items'   => esc_html__('Add or remove ' . strtolower($plural_label), 'reserving'),
                'search_items'          => esc_html__('Search ' . $plural_label, 'reserving'),
                'popular_items'         => esc_html__('Popular ' . $plural_label, 'reserving'),
                'all_items'             => esc_html__('All ' . $plural_label, 'reserving'),
                'parent_item'           => esc_html__('Parent ' . $singular_label, 'reserving'),
                'choose_from_most_used' => esc_html__('Choose from the most used ' . strtolower($plural_label), 'reserving'),
                'parent_item_colon'     => esc_html__('Parent ' . $singular_label, 'reserving'),
                'menu_name'             => $singular_label
            ),

            'public'            => true,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
            'hierarchical'      => true,
            'show_tagcloud'     => false,
            'show_ui'           => true,
            'show_in_rest'      => true,
            'rewrite'           => array(
                'slug' => sanitize_title_with_dashes($plural_label)
            )
        );

        $this->taxonomies[$type]['post_types'] = $post_types;
        $this->taxonomies[$type]['args']       = array_merge($default_settings, $settings);
    }

    public function register_taxonomy()
    {
        foreach ($this->taxonomies as $key => $value) {
            register_taxonomy($key, $value['post_types'], $value['args']);
        }
    }
}
