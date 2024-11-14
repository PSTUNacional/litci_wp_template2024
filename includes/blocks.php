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

    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-01.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_block_02($attributes)
{

    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-02.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_block_03($attributes)
{

    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-03.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_block_04($attributes)
{

    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-04.php';
    wp_reset_postdata();
    return ob_get_clean();
}


function render_litci_block_05($attributes)
{
    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-05.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_block_06($attributes)
{

    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-06.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_block_07($attributes)
{

    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-07.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_block_08($attributes)
{
    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-08.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_block_09($attributes)
{

    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    $args = prepare_args_to_render($attributes);
    $propaganda = new WP_Query($args);
    $propaganda = $propaganda->posts;

    ob_start();
    include get_template_directory() . '/components/blocks/block-09.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_block_10($attributes)
{

    $posts = get_posts_by_query($attributes);
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-10.php';
    wp_reset_postdata();
    return ob_get_clean();
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

            ob_start();
            include get_template_directory() . '/components/blocks/block-11.php';
            wp_reset_postdata();
            return ob_get_clean();
    }
}

function render_litci_block_partners($attributes)
{
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-partners.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_block_socialmedia($attributes)
{
    $block_title = $attributes['blockTitle'] ?? '';

    ob_start();
    include get_template_directory() . '/components/blocks/block-socialmedia.php';
    wp_reset_postdata();
    return ob_get_clean();
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

    ob_start();
    include get_template_directory() . '/components/blocks/video-01.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_video_02($attributes)
{
    $url = 'https://videos.litci.org/api/videos';

    if (isset($attributes['selectedChannel']) && sizeof($attributes['selectedChannel']) > 0) {
        $id = $attributes['selectedChannel'][0];
        $url = 'https://videos.litci.org/api/videos/channel/' . $id;
        $channelData = 'https://videos.litci.org/api/channels/' . $id;
    }

    ob_start();
    include get_template_directory() . '/components/blocks/video-02.php';
    wp_reset_postdata();
    return ob_get_clean();
}


function render_litci_video_03($attributes)
{
    ob_start();
    include get_template_directory() . '/components/blocks/video-03.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_stories($attributes)
{
    ob_start();
    include get_template_directory() . '/components/blocks/stories.php';
    wp_reset_postdata();
    return ob_get_clean();

}

function render_litci_ad_01($attributes)
{
    ob_start();
    include get_template_directory() . '/components/blocks/ad-01.php';
    wp_reset_postdata();
    return ob_get_clean();
}

function render_litci_columns_two($attributes)
{
    ob_start();
    include get_template_directory() . '/components/blocks/columns-two.php';
    wp_reset_postdata();
    return ob_get_clean();
}


function prepare_args_to_render($attributes, $postType = array('noticias', 'artigos', 'propaganda', 'post'), $ignoreFeaturedIds = true)
{
    $args = array(
        'post_type'           => $postType,
        'posts_per_page'      => 12,
        'order'               => 'desc',
        'ignore_sticky_posts' => true,
    );

    // Configura categorias
    if (isset($attributes['blockCategories'])) {
        $cats = [];
        foreach ($attributes['blockCategories'] as $category) {
            $childrens = (array) prepare_children_categories($category);
            $cats = array_merge($cats, $childrens);
        }
        $args['category__in'] = $cats;
    }

    // Configurações de ordenação
    if (isset($attributes['sortOption'])) {
        $args['orderby'] = [
            $attributes['sortOption'] => 'DESC',
            'date' => 'DESC',
        ];
    }

    // Configura IDs customizados
    if (isset($attributes['customIds']) && strlen($attributes['customIds']) > 1) {
        $args['orderby'] = 'post__in';
        $args['post__in'] = array_map('intval', explode(',', $attributes['customIds']));
    }

    // Evita IDs destacados globais
    if ($ignoreFeaturedIds && isset($GLOBALS['featured_ids']) && !empty($GLOBALS['featured_ids'])) {
        $args['post__not_in'] = $GLOBALS['featured_ids'];
    }

    return $args;
}

function get_posts_by_query($attributes)
{
    $args = prepare_args_to_render($attributes);
    $posts = new WP_Query($args);
    $posts = $posts->posts;

    return $posts;
}