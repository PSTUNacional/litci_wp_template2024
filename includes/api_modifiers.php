<?php

/****
 * 
 * Featured image url
 * Returns the original path direct on JSON root
 * 
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

function get_rest_featured_image($object) {
    // Verifique se 'featured_media' está definido e não é falso
    if (!empty($object['featured_media'])) {
        $imgArr = wp_get_attachment_image_src($object['featured_media'], 'full');
        
        // Verifique se $imgArr é um array válido e não é falso
        if (is_array($imgArr) && isset($imgArr[0])) {
            return $imgArr[0];
        }
    }
    
    // Como fallback, use get_the_post_thumbnail_url
    $img = get_the_post_thumbnail_url($object['id']);
    return $img ? $img : false; // Retorne a URL ou false se não houver thumbnail
}



add_action('rest_api_init', 'register_rest_images');

/***
 * 
 * Categories names
 * Returns the names as a array of strings
 * 
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

/***
 * 
 * Author name and profile pic
 * 
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
