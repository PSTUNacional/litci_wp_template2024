<?php

/*
Template Name: Tag Correio Internacional
*/
get_header();


// Obtém o caminho da requisição atual (ex: /pt/categoria/meu-post, /es/contato, /blog/meu-post)
$current_path = $_SERVER['REQUEST_URI'];
$current_language = 'en'; // Define 'en' como padrão

if (strpos($current_path, '/pt/') !== FALSE) {
    $current_language = 'pt';
} elseif (strpos($current_path, '/es/') !== FALSE) {
    $current_language = 'es';
}

$term = get_queried_object();
$current_edition = str_replace('ci', '', $term->slug);

switch ($current_language) {
    case 'pt':
        $title_base = "Correio Internacional Nº" . $current_edition;
        break;
    case 'es':
        $title_base = "Correo Internacional Nº" . $current_edition;
        break;
    case 'en':
    default:
        $title_base = "International Courrier Nº" . $current_edition;
        break;
}

// 1. Define os slugs das tags a serem procuradas
$tag_slugs = array(
    'ci' . $current_edition, 
    'CI' . $current_edition
);

// 2. Define os argumentos para a consulta
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
    'tag_slug__in'   => $tag_slugs,   // Puxa posts que contenham QUALQUER um desses slugs
    'post_type'      => 'post',
    'posts_per_page' => 60,
    'paged'          => $paged,      // Suporte à paginação
);

// 3. Executa a consulta customizada
$post_query = new WP_Query($args);
$posts = $post_query->posts;

?>
<div class="content-area">
    <main>
        <div style="background-color: #e5e5e5; color: white; padding: 48px">
            <div class="container">
                <h1><?= $title_base ?></h1>
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
            for ($i = 4; $i < 60; $i++) {
                if (isset($posts[$i])) {
                    $post = $posts[$i];
                    include(__DIR__ . '/components/units/unit-02.php');
                }
            }
            ?>
        </div>

        <?php
        // ========== Bloco de FAQ Dinâmico ========== //
        $faq_url = "https://litci.org/assets/faqs/ci" . $current_edition . ".json";
        $response = wp_remote_get($faq_url);

        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) == 200) :
            $json_data = json_decode(wp_remote_retrieve_body($response), true);

            // Verifica se existe a chave do idioma atual (ex: 'pt') no JSON
            if (isset($json_data[$current_language])) :
                $faq = $json_data[$current_language];

        ?>

                <section class="faq-correio" style="padding: 48px;">
                    <div class="container">
                        <div style="margin: 0 auto;">
                            <h2 style="font-size: 2rem; margin-bottom: 10px;"><?php echo esc_html($faq['title']); ?></h2>
                            <p style="margin-bottom: 24px; color: #666;"><?php echo esc_html($faq['description']); ?></p>

                            <div class="accordion">
                                <?php foreach ($faq['questions'] as $item) : ?>
                                    <div class="faq-item" style="background: #fff; border: 1px solid #ddd; margin-bottom: 10px; border-radius: 4px;">
                                        <button class="faq-trigger" style="width: 100%; padding: 24px; text-align: left; background: none; border: none; font-weight: bold; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-size: 1.1rem; color: #333;">
                                            <span><?php echo esc_html($item['question']); ?></span>
                                            <span class="faq-icon" style="transition: transform 0.3s;">+</span>
                                        </button>
                                        <div class="faq-content" style="max-height: 0; overflow: hidden; transition: all 0.3s ease-in-out; background: #fff;">
                                            <div style="padding: 0 20px 20px; color: #555; line-height: 1.6;">
                                                <?php echo nl2br(esc_html($item['answer'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </section>

                <script>
                    document.querySelectorAll('.faq-trigger').forEach(button => {
                        button.addEventListener('click', () => {
                            const content = button.nextElementSibling;
                            const icon = button.querySelector('.faq-icon');

                            const isOpen = content.classList.contains('open');

                            // Fecha todos primeiro
                            document.querySelectorAll('.faq-content').forEach(el => {
                                el.style.maxHeight = 0;
                                el.classList.remove('open');
                                const ic = el.previousElementSibling.querySelector('.faq-icon');
                                ic.textContent = '+';
                                ic.style.transform = 'rotate(0deg)';
                            });

                            // Se não estava aberto, abre o clicado
                            if (!isOpen) {
                                content.style.maxHeight = content.scrollHeight + "px";
                                content.classList.add('open');
                                icon.textContent = '-';
                                icon.style.transform = 'rotate(180deg)';
                            }
                        });
                    });
                </script>
        <?php
            endif;
        endif;
        ?>
    </main>
</div>
<?php get_footer(); ?>