<?php

/*
Template Name: Home Template 001
*/

get_header(); ?>
<div class="content-area">
    <main>
        <?php
        // ========== Ad Header ========== //
        if(get_theme_mod('banner_ad_header_status'))
        {
            include(__DIR__ . '/components/ads/ads_banner.php');
        }

        // ========== Header Block ========== //
        $args = array(
            'posts_per_page' => 1,
            'orderby' => '',
            'order' => 'DESC'
        );
        $posts = get_posts($args);
        include(__DIR__ . '/components/blocks/block-01.php');

        // ========== Ad Middle ========== //

        if(get_theme_mod('banner_ad_middle_status'))
        {
            include(__DIR__ . '/components/ads/ads_banner.php');
        }
        // ====

        $args = array(
            'posts_per_page' => 4,
            'offset' => 1,
            'orderby' => '',
            'order' => 'DESC'
        );
        $posts = get_posts($args);
        include(__DIR__ . '/components/blocks/block-02.php');


        include(__DIR__ . '/components/blocks/stories.php');

        $args = array(
            'posts_per_page' => 4,
            'offset' => 5,
            'orderby' => '',
            'order' => 'DESC'
        );
        $posts = get_posts($args);
        include(__DIR__ . '/components/blocks/block-03.php');

        $args = array(
            'posts_per_page' => 5,
            'offset' => 9,
            'orderby' => '',
            'order' => 'DESC'
        );
        $posts = get_posts($args);
        include(__DIR__ . '/components/blocks/block-04.php');

        ?>

    </main>
    <script src="wp-content/themes/litci/assets/js/story-slider.js"></script>
</div>
<?php get_footer(); ?>