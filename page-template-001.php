<?php

/*
Template Name: Home Template 001
*/

get_header(); ?>
<div class="content-area">
    <main>
        <?php

        // ========== Header Block ========== //

        $args = array(
            'posts_per_page' => 1,
            'orderby' => '',
            'order' => 'DESC'
        );
        $posts = get_posts($args);
        include(__DIR__ . '/components/blocks/block-01.php');

        $args = array(
            'posts_per_page' => 4,
            'offset' => 1,
            'orderby' => '',
            'order' => 'DESC'
        );
        $posts = get_posts($args);
        include(__DIR__ . '/components/blocks/block-02.php');


        ?>


        <section class="story-container">
            <div data-slide="slide" class="story-slide" id="story-slider">
                <div class="slide-items">
                </div>
                <nav class="slide-nav">
                    <div class="slide-thumb"></div>
                    <button class="slide-prev">Anterior</button>
                    <button class="slide-next">Próximo</button>
                </nav>
            </div>
            <div class="backdrop"></div>
        </section>
        <section>
            <div class="container">
                <div class="block-header">
                    <h3>Nossos partidos</h3>
                </div>
                <div class="party-grid">
                    <a class="party-item">
                        <div class="logo"></div>
                        <div class="circle"></div>
                        <span class="fi fi-br fis"></span>
                    </a>
                    <a class="party-item">
                        <div class="logo"></div>
                        <div class="circle"></div>
                        <span class="fi fi-ar fis"></span>
                    </a>
                    <a class="party-item">
                        <div class="logo"></div>
                        <div class="circle"></div>
                        <span class="fi fi-es fis"></span>
                    </a>
                    <a class="party-item">
                        <div class="logo"></div>
                        <div class="circle"></div>
                        <span class="fi fi-it fis"></span>
                    </a>
                    <a class="party-item">
                        <div class="logo"></div>
                        <div class="circle"></div>
                        <span class="fi fi-gb fis"></span>
                    </a>
                    <a class="party-item">
                        <div class="logo"></div>
                        <div class="circle"></div>
                        <span class="fi fi-us fis"></span>
                    </a>
                    <a class="party-item">
                        <div class="logo"></div>
                        <div class="circle"></div>
                        <span class="fi fi-pt fis"></span>
                    </a>
                    <a class="party-item">
                        <div class="logo"></div>
                        <div class="circle"></div>
                        <span class="fi fi-pk fis"></span>
                    </a>
                </div>
            </div>
        </section>
        <?php




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