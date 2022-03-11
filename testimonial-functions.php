<?php
include 'testimonial-fields.php';

// функция для общего файла плагина
function add_blocks_categories($categories, $post)
{
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'sections',
                'title' => __('Custom blocks', 'tally'),
                'icon'  => 'admin-generic',
            ),
        )
    );
}

add_filter('block_categories', 'add_blocks_categories', 10, 2);
function register_acf_block_types_testimonial()
{
    acf_register_block_type(array(
        'name'              => 'testimonial',
        'title'             => __('Testimonial'),
        'description'       => __('Theme block.'),
        'render_template'   => 'template-parts/blocks/testimonial/testimonial.php',
        'category'          => 'sections',
        'icon'              => 'archive',
        'keywords'          => array('testimonial', 'post'),
        'enqueue_style'     => get_template_directory_uri() . '/template-parts/blocks/testimonial/testimonial.css',
        'enqueue_script'    => get_template_directory_uri() . '/template-parts/blocks/testimonial/testimonial.js',

    ));
}


if (function_exists('acf_register_block_type')) {
    add_action('acf/init', 'register_acf_block_types_testimonial');
}


add_action('wp_enqueue_scripts', 'ajax_url');
function ajax_url()
{
    wp_localize_script('jquery', 'loadmore_params', array(
        'ajaxurl' => site_url() . '/wp-admin/admin-ajax.php'
    ));
}

