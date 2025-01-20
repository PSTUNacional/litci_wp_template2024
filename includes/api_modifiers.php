<?php

/**
 * Featured image url
 * Returns the original path direct on JSON root
 */

function register_rest_images()
{
    register_rest_field(
        array('post', 'search-result'),
        'fimg_url',
        array(
            'get_callback'    => 'get_rest_featured_image',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_rest_featured_image($object)
{
    if (!empty($object['featured_media'])) {
        $imgArr = wp_get_attachment_image_src($object['featured_media'], 'full');
        if (is_array($imgArr) && isset($imgArr[0])) {
            return $imgArr[0];
        }
    }

    $img = get_the_post_thumbnail_url($object['id']);
    return $img ? $img : false;
}

add_action('rest_api_init', 'register_rest_images');

/**
 * Categories names
 * Returns the names as an array of strings
 */

function register_categories_names()
{
    register_rest_field(
        array('post', 'search-result'),
        'categories_names',
        array(
            'get_callback'    => 'get_categories_names',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_categories_names($object, $field_name, $request)
{
    $names = [];
    $cats = wp_get_post_categories($object['id']);
    foreach ($cats as $cat) {
        $name = get_cat_name($cat);
        array_push($names, $name);
    }
    return $names;
}

add_action('rest_api_init', 'register_categories_names');

/**
 * Author name and profile pic
 */

function register_author_info()
{
    register_rest_field(
        array('post', 'search-result'),
        'author_info',
        array(
            'get_callback'    => 'get_author_info',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_author_info($object, $field_name, $request)
{
    $name = get_the_author_meta('display_name');
    $profile = get_avatar_url($object['author']);

    $arr = [
        'name' => $name,
        'pic'   => $profile,
    ];
    return $arr;
}

add_action('rest_api_init', 'register_author_info');

/**
 * Menu order
 * Adds the menu order field to the REST API response
 */

function register_menu_order()
{
    register_rest_field(
        array('post', 'search-result'),
        'menu_order',
        array(
            'get_callback'    => 'get_menu_order',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_menu_order($object, $field_name, $request)
{
    return get_post_field('menu_order', $object['id']);
}

add_action('rest_api_init', 'register_menu_order');


/**
 * Political Author
 * Adds the political author field to the REST API response
 */

function register_political_author(){
    register_rest_field(
        array('post', 'search-result'),
        'political_author',
        array(
            'get_callback'    => 'get_political_author',
            'update_callback' => null,
            'schema'          => null,
        )
    );
}

function get_political_author($object, $field_name, $request){
    $author = get_the_author_meta('ID');
    $political_author = get_user_meta($author, 'political_author', true);
    return $political_author ? $political_author : null;
}

add_action('rest_api_init', 'register_political_author');