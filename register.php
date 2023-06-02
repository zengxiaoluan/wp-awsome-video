<?php

register_post_type('video', [
    'labels' => [
        'name' => _x('Videos', 'Post type general name', 'slide'),
        'singular_name' => _x('Video', 'Post type singular name', 'slide'),
        'menu_name' => _x('Videos', 'Admin Menu text', 'slide'),
        'name_admin_bar' => _x('Presentation', 'Add New on Toolbar', 'slide'),
        'add_new' => __('Add New', 'slide'),
        'add_new_item' => __('Add New Presentation', 'slide'),
        'new_item' => __('New Presentation', 'slide'),
        'edit_item' => __('Edit Video', 'slide'),
        'view_item' => __('View Video', 'slide'),
        'all_items' => __('All Videos', 'slide'),
        'search_items' => __('Search Presentations', 'slide'),
        'parent_item_colon' => __('Parent Presentations:', 'slide'),
        'not_found' => __('No videos found.', 'slide'),
        'not_found_in_trash' => __('No presentations found in Trash.', 'slide'),
        'featured_image' => _x(
            'Video Cover Image',
            'Overrides the “Featured Image” phrase for this post type. Added in 4.3',
            'slide'
        ),
        'set_featured_image' => _x(
            'Set cover image',
            'Overrides the “Set featured image” phrase for this post type. Added in 4.3',
            'slide'
        ),
        'remove_featured_image' => _x(
            'Remove cover image',
            'Overrides the “Remove featured image” phrase for this post type. Added in 4.3',
            'slide'
        ),
        'use_featured_image' => _x(
            'Use as cover image',
            'Overrides the “Use as featured image” phrase for this post type. Added in 4.3',
            'slide'
        ),
        'archives' => _x(
            'Presentation archives',
            'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4',
            'slide'
        ),
        'insert_into_item' => _x(
            'Insert into presentation',
            'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4',
            'slide'
        ),
        'uploaded_to_this_item' => _x(
            'Uploaded to this presentation',
            'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4',
            'slide'
        ),
        'filter_items_list' => _x(
            'Filter presentations list',
            'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4',
            'slide'
        ),
        'items_list_navigation' => _x(
            'Presentations list navigation',
            'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4',
            'slide'
        ),
        'items_list' => _x(
            'Presentations list',
            'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4',
            'slide'
        ),
    ],
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_icon' => 'dashicons-media-interactive',
    'query_var' => true,
    'rewrite' => ['slug' => 'video'],
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => [
        'title',
        'editor',
        'author',
        'thumbnail',
        'excerpt',
        'custom-fields',
        // 'revisions',
    ],
    'show_in_rest' => true,
]);

foreach (
    [
        'css',
        'color',
        'background-color',
        'background-gradient',
        'background-url',
        'background-id',
        'background-position',
        'background-opacity',
        'font-size',
        'font-family',
        'font-family-url',
        'font-family-heading',
        'font-family-heading-url',
        'font-weight-heading',
        'transition',
        'background-transition',
        'transition-speed',
        'controls',
        'progress',
        'width',
        'horizontal-padding',
        'vertical-padding',
        'color-palette',
        'contain',
    ]
    as $key
) {
    register_post_meta('presentation', "presentation-$key", [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
    ]);
}
