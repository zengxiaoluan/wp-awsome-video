<?php

/*
 * Plugin Name: Awesome Video
 * Plugin URI:  https://wordpress.org/plugins/awesome-video
 * Description: Allows you to create m3u8 movie with the block editor.
 * Version:     0.0.1
 * Author:      zengyimeng
 * Author URI:  https://zengyimeng.com
 * Text Domain: video
 * License:     GPL-2.0+
 */

// Show posts of 'post', 'page' and 'courses' post types on home page
function add_my_post_types_to_query($query)
{
    if (is_home() && $query->is_main_query()) {
        $query->set('post_type', ['post', 'page', 'video']);
    }
    return $query;
}
add_action('pre_get_posts', 'add_my_post_types_to_query');

add_action('init', function () {
    require 'register.php';
});

register_activation_hook(__FILE__, function () {
    require 'register.php';
    flush_rewrite_rules();
});

/*
引入 post 模板
add_filter('template_include', function ($path) {
    if (!is_singular('video')) {
        return $path;
    }

    if (isset($_GET['speaker'])) {
        return dirname(__FILE__) . '/speaker.php';
    }

    the_post();

    return dirname(__FILE__) . '/template.php';
});
*/

add_filter('the_content', function ($content) {
    if (!is_singular('video')) {
        return $content;
    }

    $post_id = get_the_ID();

    $temp = get_post_meta($post_id);

    $meta = json_encode($temp);
    return $content .
        '<div id="root-video"></div>' .
        '<script> var __meta=' .
        $meta .
        '</script>';
});

// Dequeue the theme style. It is not needed for the presentations, as they are
// individually crafted.
add_action(
    'wp_enqueue_scripts',
    function () {
        if (!is_singular('video')) {
            return;
        }

        global $wp_styles;

        $template_directory_uri = get_template_directory_uri();

        foreach ($wp_styles->queue as $handle) {
            $info = $wp_styles->registered[$handle];

            if (
                substr($info->src, 0, strlen($template_directory_uri)) ===
                $template_directory_uri
            ) {
                // wp_dequeue_style($handle);
            }
        }

        wp_enqueue_script(
            'video',
            plugins_url('./dist/video.js', __FILE__),
            [],
            filemtime(dirname(__FILE__) . '/dist/video.js'),
            true
        );

        return;
    },
    99999
);

foreach (['load-post.php', 'load-post-new.php'] as $tag) {
    add_action(
        $tag,
        function () {
            if (get_current_screen()->post_type !== 'video') {
                return;
            }

            remove_editor_styles();
            remove_theme_support('editor-color-palette');
            remove_theme_support('editor-font-sizes');
            add_theme_support('align-wide');

            if (!isset($_GET['post'])) {
                return;
            }

            $post = get_post($_GET['post']);

            if (!$post) {
                return;
            }

            $palette = get_post_meta(
                $post->ID,
                'presentation-color-palette',
                true
            );

            if (!$palette) {
                return;
            }

            $palette = explode(',', $palette);
            $palette = array_map('trim', $palette);
            $palette = array_map('sanitize_hex_color', $palette);
            $palette = array_map(function ($hex) {
                return ['color' => $hex];
            }, $palette);

            if (count($palette)) {
                add_theme_support('editor-color-palette', $palette);
            }
        },
        99999
    );
}

add_filter(
    'block_editor_settings',
    function ($settings) {
        if (get_current_screen()->post_type !== 'video') {
            return $settings;
        }

        $settings['styles'] = [];
        return $settings;
    },
    99999
);

add_filter(
    'default_content',
    function ($post_content, $post) {
        if ($post->post_type !== 'presentation') {
            return $post_content;
        }

        return file_get_contents(__DIR__ . '/default-content.html');
    },
    10,
    2
);

add_filter(
    'render_block',
    function ($block_content, $block) {
        if (!current_user_can('edit_posts')) {
            return $block_content;
        }

        if ($block['blockName'] !== 'slide/slide') {
            return $block_content;
        }

        if (empty($block['attrs']['notes'])) {
            return $block_content;
        }

        $pos = strrpos($block_content, '</section>', -1);
        $notes =
            '<aside class="notes">' . $block['attrs']['notes'] . '</aside>';

        return substr_replace($block_content, $notes, $pos, 0);
    },
    10,
    2
);
