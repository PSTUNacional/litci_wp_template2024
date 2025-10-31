<?php

/*
Template Name: Tag COP 30
*/

get_header();


// Obtém o caminho da requisição atual (ex: /pt/categoria/meu-post, /es/contato, /blog/meu-post)
$current_path = $_SERVER['REQUEST_URI'];

// Define as URLs das imagens para cada idioma
$image_url_pt = 'http://litci.org/pt/wp-content/uploads/2025/10/header-cop30-1920x180-pt.jpg';
$image_url_es = 'http://litci.org/pt/wp-content/uploads/2025/10/header-cop30-1920x180-es.jpg';
$image_url_en = 'http://litci.org/pt/wp-content/uploads/2025/10/header-cop30-1920x180-en.jpg'; // Imagem padrão

$selected_image_url = '';
$current_language = 'en'; // Padrão é inglês

// 1. Checa por "/pt"
if (str_contains($current_path, '/pt/')) { // Usamos "/pt/" para evitar falsos positivos como "aptidão"
    $selected_image_url = $image_url_pt;
    $current_language = 'pt';
}
// 2. Checa por "/es"
elseif (str_contains($current_path, '/es/')) { // Usamos "/es/" para evitar falsos positivos
    $selected_image_url = $image_url_es;
    $current_language = 'es';
}
// 3. Se nenhum dos anteriores, usa o padrão (inglês)
else {
    $selected_image_url = $image_url_en;
    $current_language = 'en';
}

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
        <img src="<?=$selected_image_url?>" style="width:100%"/>
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