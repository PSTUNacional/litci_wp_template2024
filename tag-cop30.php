<?php

/*
Template Name: Tag COP 30
*/

get_header();

// 1. Define os slugs das tags a serem procuradas
$tag_slugs = array('cop30', 'cop-30', 'cop 30');
$display_tag_name = 'COP 30'; // Nome para exibição no cabeçalho

// 2. Define os argumentos para a consulta
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
    'tag_slug__in'   => $tag_slugs,   // Puxa posts que contenham QUALQUER um desses slugs
    'post_type'      => 'post',
    'posts_per_page' => 20,
    'paged'          => $paged,      // Suporte à paginação
);

// 3. Executa a consulta customizada
$posts_query = new WP_Query($args);

?>
<div class="content-area">
    <main>
        <div class="container">
            <div class="category-title">
            <?php custom_breadcrumbs() ?>
                <h1><?php single_cat_title(); ?></h1>
            </div>
        </div>
        <?php


        // ========== Header Block ========== //

        if (sizeof($posts) > 0) {
        ?>
            <section>
                <div class="container">
                    <div class="column">
                        <div class="block-05">
                            <div class="featured">
                                <?php
                                $post = $posts[0];
                                include get_template_directory() . '/components/units/unit-03.php';
                                ?>
                            </div>
                            <div class="grid">
                                <?php
                                $i = 1;
                                for ($i = 1; $i < 4; $i++) {
                                    if (isset($posts[$i])) {
                                        $post = $posts[$i];
                                        include get_template_directory() . '/components/units/unit-04.php';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php
        } else {
            echo '><section><div class="container"><h5 class="ta-center">Ainda não há conteúdo aqui...</h5></div></section>';
        } ?>
        <div class="container result-list">
            <?php
            for ($i = 4; $i < 20; $i++) {
                if (isset($posts[$i])) {
                    $post = $posts[$i];
                    include(__DIR__ . '/components/units/unit-02.php');
                }
            }
            ?>
        </div>
    </main>
</div>
<?php get_footer(); ?>