<?php

namespace Reserving\extensions\frontend\product;

/**
 * Product_Single class
 *
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */
class Product_Single
{
    public function register()
    {
        add_action('woocommerce_before_add_to_cart_quantity', array($this, 'add_extra_items'));
        add_filter('woocommerce_quantity_input_classes', array($this, 'add_custom_class_to_quantity_input'), 10, 2);
        add_action('woocommerce_product_options_pricing', array($this, 'add_custom_field_to_general_tab'));
        add_action('woocommerce_process_product_meta', array($this, 'save_branches_meta_product'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('pre_get_posts', array($this, 'filter_products_by_branch'));
    }

    public function enqueue_admin_scripts()
    {
        global $post_type;

        if ($post_type === 'product') {
            wp_enqueue_script('wc-enhanced-select');
            wp_enqueue_style('woocommerce_admin_styles');
        }
    }

    function filter_products_by_branch($query)
    {
        // Check if we are in the main query and on the shop page
        if (!is_admin() && $query->is_main_query() && is_post_type_archive('product')) {
            if (isset($_GET['branch']) && !empty($_GET['branch'])) {
                // Get the branch ID from the URL
                $branch_id = intval($_GET['branch']);

                // Convert the branch ID to a slug
                $branch_slug = get_post_field('post_name', $branch_id, 'reserving-branches');

                // Check if the branch slug exists
                if ($branch_slug) {
                    $meta_query = $query->get('meta_query');
                    $meta_query[] = [
                        'relation' => 'OR', // Set relation to OR
                        [
                            'key'     => '_custom_select_field', // Your custom field key
                            'value'   => $branch_slug,           // The branch slug
                            'compare' => 'LIKE',                 // Use LIKE to allow for multiple selections
                        ],
                        [
                            'key'     => '_custom_select_field', // Check for products with no branches
                            'compare' => 'NOT EXISTS',            // No branch selected
                        ],
                    ];
                    $query->set('meta_query', $meta_query);
                }
            }
        }
    }

    public function save_branches_meta_product($post_id)
    {
        if (isset($_POST['_custom_select_field']) && is_array($_POST['_custom_select_field'])) {

            $selected_branches = array_map('sanitize_text_field', $_POST['_custom_select_field']);
            update_post_meta($post_id, '_custom_select_field', $selected_branches);
        }
    }


    public function add_custom_field_to_general_tab()
    {
        $args = [];

        $args['post_type'] = 'reserving-branches';
        $args['posts_per_page'] = -1;
        $args['post_status'] = 'publish';
        $branches = new \WP_Query($args);

        $branchhes_options = [];
        if ($branches->have_posts()) {
            while ($branches->have_posts()) {
                $branches->the_post();
                $post_slug = get_post_field('post_name', get_the_ID()); // Get post slug
                $branchhes_options[$post_slug] = get_the_title(); // Use post slug as key, title as value
            }
            wp_reset_postdata(); // Reset post data after the loop
        }

        $product_id = isset($_GET['post']) ? intval($_GET['post']) : (isset($_POST['post_ID']) ? intval($_POST['post_ID']) : 0);
        // Retrieve the saved options
        $saved_values = get_post_meta($product_id, '_custom_select_field', true);

        // Output the multi-select field with preselected values
        echo '<div class="options_group">';
        echo '<p class="form-field _custom_select_field_field">';
        echo '<label for="_custom_select_field">' . __('Select Branches', 'your-text-domain') . '</label>';
        echo '<select id="_custom_select_field" name="_custom_select_field[]" class="wc-enhanced-select" multiple="multiple">';

        foreach ($branchhes_options as $slug => $title) {
            $selected = (is_array($saved_values) && in_array($slug, $saved_values)) ? 'selected="selected"' : '';
            echo '<option value="' . esc_attr($slug) . '" ' . $selected . '>' . esc_html($title) . '</option>';
        }

        echo '</select>';
        echo '<span class="description">' . __('Leave the field empty, product will be shown on all branches', 'your-text-domain') . '</span>';
        echo '</p>';
        echo '</div>';
    }

    public function add_custom_class_to_quantity_input($classes, $product)
    {
        $classes[] = 'reserving_add_quantity';
        return $classes;
    }
    public function add_extra_items()
    {
        echo do_shortcode("[reserving_single_product_extra_items]");
    }
    public function add_total_price()
    {
        echo do_shortcode("[reserving_single_product_price]");
    }
}
