<?php

/*
Template Name: Category Page
*/

// Obtém a categoria atual
$current_category = get_queried_object();
$category_id = $current_category->term_id;

// Obtém as categorias filhas
$child_categories = get_term_children($category_id, 'category');

// Verifica se existem categorias filhas e as adiciona à consulta
if (!empty($child_categories)) {
    $category_id = array_merge(array($category_id), $child_categories);
}

// Define os argumentos para a nova consulta
$args = array(
    'category__in' => $category_id,
    'post_type' => 'post',
    'posts_per_page' => 20,
);
$posts = new WP_Query($args);
$posts = $posts->posts;

get_header(); ?>
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
            echo '<section><h3 class="ta-center">Ainda não há conteúdo aqui...</h3></section>';
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