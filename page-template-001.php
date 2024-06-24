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
            $ad = 'banner_ad_header_';
            include(__DIR__ . '/components/ads/ads_banner.php');
        }

        // ========== Header Block ========== //
        render_section('block01');

        // ========== Ad Middle ========== //

        if(get_theme_mod('banner_ad_middle_status'))
        {
            $ad = 'banner_ad_middle_';
            include(__DIR__ . '/components/ads/ads_banner.php');
        }

        render_section('block02');

        render_section('block03');

        render_section('block04');

        render_section('block05');

        render_section('block06');
        ?>
    </main>
    <script src="wp-content/themes/litci/assets/js/story-slider.js"></script>
</div>
<?php get_footer(); ?>