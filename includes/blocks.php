<?php

function register_litci_blocks() {

    $blockList = [
        "block-01",
        "block-02",
        "block-03",
        "block-04",
        "block-05",
        "block-06",
        "block-07",
        "block-08",
        "video-01",
        "stories",
        "ad-01"
    ];

    forEach($blockList as $block)
    {
        wp_register_script(
            'litci-'.$block,
            get_template_directory_uri() . '/components/blocks/'.$block.'.js',
            array('wp-blocks', 'wp-editor'),
            null,
            true
        );
    
        $callback = 'render_litci_'.$block;
        $callback = str_replace('-','_', $callback);

        register_block_type('litci/'.$block, array(
            'editor_script' => 'litci-'.$block,
            'render_callback' => $callback
        ));
    
    }
}

add_action('init', 'register_litci_blocks');

function render_litci_block_01($attributes) {
    
    $args = prepare_args_to_render($attributes);
    $posts = get_posts($args);

    if(isset($attributes['blockTitle'])){
        $block_title = $attributes['blockTitle'];
    }
    
    include get_template_directory() . '/components/blocks/block-01.php';

    wp_reset_postdata();

}

function render_litci_block_02($attributes) {

    $args = prepare_args_to_render($attributes);
    $posts = get_posts($args);

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-02.php';

    wp_reset_postdata();

}

function render_litci_block_03($attributes) {

    $args = prepare_args_to_render($attributes);
    $posts = get_posts($args);

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-03.php';

    wp_reset_postdata();

}

function render_litci_block_04($attributes) {
        
    $args = prepare_args_to_render($attributes);
    $posts = get_posts($args);

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-04.php';

    wp_reset_postdata();
}


function render_litci_block_05($attributes) {
    $args = prepare_args_to_render($attributes);
    $posts = get_posts($args);

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-05.php';

    wp_reset_postdata();
}

function render_litci_block_06($attributes) {
        
    $args = prepare_args_to_render($attributes);
    $posts = get_posts($args);

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-06.php';

    wp_reset_postdata();
}

function render_litci_block_07($attributes) {
        
    $args = prepare_args_to_render($attributes);
    $posts = get_posts($args);

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-07.php';

    wp_reset_postdata();
}

function render_litci_block_08($attributes) {
        
    $args = prepare_args_to_render($attributes);
    $posts = get_posts($args);

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-08.php';

    wp_reset_postdata();
}

function render_litci_video_01($attributes) {
    include get_template_directory() . '/components/blocks/video-01.php';
    wp_reset_postdata();
}


function render_litci_stories($attributes) {
    include get_template_directory() . '/components/blocks/stories.php';
    wp_reset_postdata();
}

function render_litci_ad_01($attributes) {
    include get_template_directory() . '/components/blocks/ad-01.php';
}

function prepare_args_to_render($attributes)
{
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 12, // Número de posts a serem exibidos
    );

    if(isset($attributes['blockCategories']))
    {
        $cats = [];
        foreach($attributes['blockCategories'] as $category)
        {
            $childrens = prepare_children_categories($category);
            if(is_array($childrens))
            {
                foreach($childrens as $children)
                {
                    array_push($cats, $children);
                }   
            } else {
                array_push($cats, $childrens);
            }

        }
        $args['category__in'] = $cats;
    }

    if(isset($attributes['sortOption']))
    {
        $args['orderby'] = $attributes['sortOption'];
        $args['sort'] = 'DESC';
    }

    if(isset($GLOBALS['featured_ids']) && sizeof($GLOBALS['featured_ids']) > 0){
        $args['post__not_in'] = $GLOBALS['featured_ids'];
    }
    
    return $args;
}