<?php

add_filter('block_categories_all', function ($categories) {

    // Adding a new category.
    $categories[] = array(
        'slug'  => 'litci-category',
        'title' => 'LIT-CI Blocks'
    );

    return $categories;
});

function register_litci_blocks()
{

    $blockList = [
        "block-01",
        "block-02",
        "block-03",
        "block-04",
        "block-05",
        "block-06",
        "block-07",
        "block-08",
        "block-09",
        "block-10",
        "block-11",
        "block-partners",
        "block-socialmedia",
        "video-01",
        "video-02",
        "video-03",
        "stories",
        "ad-01"
    ];

    foreach ($blockList as $block) {
        wp_register_script(
            'litci-' . $block,
            get_template_directory_uri() . '/components/blocks/' . $block . '.js',
            array('wp-blocks', 'wp-editor'),
            null,
            true
        );

        $callback = 'render_litci_' . $block;
        $callback = str_replace('-', '_', $callback);

        register_block_type('litci/' . $block, array(
            'editor_script' => 'litci-' . $block,
            'render_callback' => $callback
        ));
    }
}

add_action('init', 'register_litci_blocks');

function render_litci_block_01($attributes)
{

    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    if (isset($attributes['blockTitle'])) {
        $block_title = $attributes['blockTitle'];
    }

    include get_template_directory() . '/components/blocks/block-01.php';

    wp_reset_postdata();
}

function render_litci_block_02($attributes)
{

    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-02.php';

    wp_reset_postdata();
}

function render_litci_block_03($attributes)
{

    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-03.php';

    wp_reset_postdata();
}

function render_litci_block_04($attributes)
{

    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-04.php';

    wp_reset_postdata();
}


function render_litci_block_05($attributes)
{
    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-05.php';

    wp_reset_postdata();
}

function render_litci_block_06($attributes)
{

    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-06.php';

    wp_reset_postdata();
}

function render_litci_block_07($attributes)
{

    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-07.php';

    wp_reset_postdata();
}

function render_litci_block_08($attributes)
{
    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-08.php';

    wp_reset_postdata();
}

function render_litci_block_09($attributes)
{

    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    $args = prepare_args_to_render($attributes);
    $propaganda = new WP_Query($args);
    $propaganda = $propaganda->posts;

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-09.php';

    wp_reset_postdata();
}

function render_litci_block_10($attributes)
{

    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-10.php';

    wp_reset_postdata();
}

function render_litci_block_11($attributes)
{

    if (isset($attributes['blockCategoriesOne']) && isset($attributes['blockCategoriesTwo'])) {
        $attOne = $attributes;
        $attOne['blockCategories'] = $attributes['blockCategoriesOne'];
        $attOne['sortOption'] = $attributes['sortOptionOne'];
        $argsOne = prepare_args_to_render($attOne);
        $posts_one = new WP_Query($argsOne);
        $posts_one = $posts_one->posts;

        $attTwo = $attributes;
        $attTwo['blockCategories'] = $attributes['blockCategoriesTwo'];
        $argsTwo = prepare_args_to_render($attTwo, array('noticias', 'artigos', 'propaganda', 'post'), false);
        $attTwo['sortOption'] = $attributes['sortOptionTwo'];
        $posts_two = new WP_Query($argsTwo);
        $posts_two = $posts_two->posts;
        isset($attributes['blockTitleOne'])
            ? $block_title_one = $attributes['blockTitleOne']
            : '';

        isset($attributes['blockTitleTwo'])
            ? $block_title_two = $attributes['blockTitleTwo']
            : '';

        include get_template_directory() . '/components/blocks/block-11.php';

        wp_reset_postdata();
    }
}

function render_litci_block_partners($attributes)
{
    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-partners.php';

    wp_reset_postdata();
}

function render_litci_block_socialmedia($attributes)
{
    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    include get_template_directory() . '/components/blocks/block-socialmedia.php';

    wp_reset_postdata();
}

function render_litci_video_01($attributes)
{
    $url = 'https://videos.litci.org/api/videos';
    $isSingle = false;

    if (isset($attributes['selectedChannel']) && sizeof($attributes['selectedChannel']) > 0) {
        $id = $attributes['selectedChannel'][0];
        $url = 'https://videos.litci.org/api/videos/channel/' . $id;
        $channelData = 'https://videos.litci.org/api/channels/' . $id;
        $isSingle = true;
    }

    include get_template_directory() . '/components/blocks/video-01.php';
}

function render_litci_video_02($attributes)
{
    $url = 'https://videos.litci.org/api/videos';

    if (isset($attributes['selectedChannel']) && sizeof($attributes['selectedChannel']) > 0) {
        $id = $attributes['selectedChannel'][0];
        $url = 'https://videos.litci.org/api/videos/channel/' . $id;
        $channelData = 'https://videos.litci.org/api/channels/' . $id;
    }

    include get_template_directory() . '/components/blocks/video-02.php';
}


function render_litci_video_03($attributes)
{
    include get_template_directory() . '/components/blocks/video-03.php';
}

function render_litci_stories($attributes)
{
    include get_template_directory() . '/components/blocks/stories.php';
    wp_reset_postdata();
}

function render_litci_ad_01($attributes)
{
    include get_template_directory() . '/components/blocks/ad-01.php';
}

function render_litci_columns_two($attributes)
{
    include get_template_directory() . '/components/blocks/columns-two.php';
}


function prepare_args_to_render($attributes, $postType = array('noticias', 'artigos', 'propaganda', 'post'), $ignoreFeaturedIds = true)
{
    $args = array(
        'post_type' => $postType,
        'posts_per_page' => 12, // Número de posts a serem exibidos
        'order' => 'desc',
        'ignore_sticky_posts' => true,
    );

    if (isset($attributes['blockCategories'])) {
        $cats = [];
        foreach ($attributes['blockCategories'] as $category) {
            $childrens = prepare_children_categories($category);
            if (is_array($childrens)) {
                foreach ($childrens as $children) {
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
        $args['orderby'] = [
            $attributes['sortOption'] => 'DESC',
            'date' => 'DESC',
        ];
        $args['order'] = 'DESC';
    } 

    if (isset($attributes['customIds']) && strlen($attributes['customIds']) > 1) {
        $args['orderby'] = 'post__in';
        $ids = array_map('intval', explode(',', $attributes['customIds']));
        $args['post__in'] = $ids;
    }

    if (isset($GLOBALS['featured_ids']) && sizeof($GLOBALS['featured_ids']) > 0) {
        $args['post__not_in'] = $GLOBALS['featured_ids'];
    }
	
	if($ignoreFeaturedIds == false)
	{
		$args['post__not_in'] = "";
	}

    return $args;
}
