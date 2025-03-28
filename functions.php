<?php

include get_template_directory() . '/autoloader.php';

/***
 * 
 * Load JS and CSS
 * 
 */
function load_scripts()
{
    // CSSs
    wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0', 'all');

    // JS Scripts
    wp_enqueue_script('functions', get_template_directory_uri() . '/assets/js/functions.js', array(), '1.0', true);
    wp_enqueue_script('cookies', get_template_directory_uri() . '/assets/js/cookies.js', array(), '1.0', true);
}

add_action('wp_enqueue_scripts', 'load_scripts');

function load_admin_scripts($hook)
{

    // Load admin CSS for all admin pages
    wp_enqueue_style('custom-admin-css', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0', 'all');

    if ($hook === 'edit.php' || $hook === 'customize.php') {
        wp_enqueue_script('custom-admin-js', get_template_directory_uri() . '/assets/js/custom-admin.js', array('jquery'), null, true);
        wp_localize_script('custom-admin-js', 'customAdminAjax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('custom_admin_nonce')
        ));
    }

    if ($hook === 'post.php' || $hook === 'post-new.php') {
        $screen = get_current_screen();
        if($screen && $screen->post_type === 'post')
        {
            wp_enqueue_script('post-validation', get_template_directory_uri() . '/assets/js/post-validation.js', array('jquery'), '1.0', true);
    
            // Translations
            wp_localize_script('post-validation', 'postValidationMessages', array(
                'politicalAuthor' => [
                    'title' => __('Oops... who signs?', 'litci'),
                    'text' => __('You must include at least one political author to publish it.', 'litci')
                ],
                'links' => [
                    'success'=> [
                        'title' => __('The text has links.', 'litci'),
                        'text' => __('Links help connect different contents and politically deepen the discussions.', 'litci')
                    ],
                    'error' => [
                        'title' => __('The text does not have links.', 'litci'),
                        'text' => __('Links help connect different contents and politically deepen the discussions.', 'litci')
                    ]
                ],
                'headings' => [
                    'success'=> [
                        'title' => __('The headings are ok.', 'litci'),
                        'text' => __('The text has explicitly defined subtitles.', 'litci')
                    ],
                    'error' => [
                        'title' => __('There is no headings.', 'litci'),
                        'text' => __('There appear to be no intertitles in the text. It is important to insert some and ensure that they are marked as such.', 'litci')
                    ]
                ],
                'tags' => [
                    'success'=> [
                        'title' => __('The tags are ok.', 'litci'),
                        'text' => __('The text has tags added.', 'litci')
                    ],
                    'error' => [
                        'title' => __('There is no tags.', 'litci'),
                        'text' => __('Consider adding tags and keywords that identify the content of this text.', 'litci')
                    ]
                ],
                'modal' => [
                    'title' => __('Good practices', 'litci'),
                    'description'   => __('None of these items are mandatory, but maintaining good practices is always important.', 'litci'),
                    'confirm' => __("I'll fix it", "litci"),
                    'deny'  => __('I want to continue anyway', 'litci')
                ]
            ));
        }
        wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0', 'all');
    }

    // SweetAlert2 Library
    wp_enqueue_style('sweetalert2-css', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.min.css', array(), '11.3.0', 'all');
    wp_enqueue_script('sweetalert2-js', 'https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.min.js', array(), '11.3.0', true);

    // FontAwesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css', array(), '6.5.0', 'all');
}
add_action('admin_enqueue_scripts', 'load_admin_scripts');

function load_customize_scripts()
{
    wp_enqueue_style('custom-admin-css', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0', 'all');
}
add_action('customize_controls_enqueue_scripts', 'load_customize_scripts');


function litci_config()
{

    /***
     * 
     * Register NAVs 
     * 
     */

    register_nav_menus(
        array(
            'main_menu' => 'Main Menu',
            'top_menu' => 'Top Menu'
        )
    );

    $args = array(
        'height'    => 225,
        'width'     => 1920
    );
    add_theme_support('custom-header', $args);

    add_theme_support('post-thumbnails');

    add_theme_support('align-wide');

    load_theme_textdomain('litci', get_template_directory() . '/languages');
}

add_action('after_setup_theme', 'litci_config');

add_action('init', 'edition_rewrite_rule');

function edition_rewrite_rule()
{
    add_rewrite_rule(
        'edicao/([0-9]+)[/]?$',
        'edicao/?edicao=$1',
        'top'
    );
}

add_filter('query_vars', 'edition_query_vars');

function edition_query_vars($query_vars)
{
    $query_vars[] = 'edicao';
    return $query_vars;
}

add_action('template_include', function ($template) {
    if (get_query_var('edicao') == false || get_query_var('edicao') == '') {
        return $template;
    }
    return get_template_directory() . '/os-edition.php';
});

function custom_author_base()
{
    global $wp_rewrite;
    $wp_rewrite->author_base = 'coluna';
    $wp_rewrite->author_structure = '/' . $wp_rewrite->author_base . '/%author%';
}
add_action('init', 'custom_author_base');


/*==============================

    API Modifiers

==============================*/

include __DIR__ . '/includes/api_modifiers.php';

/*==============================

    THEME CUSTOMIZER

==============================*/

include __DIR__ . '/includes/theme_customizer.php';

/*==============================

    SECURITY

==============================*/

include __DIR__ . '/includes/security.php';

/*==============================

    METABOXES

==============================*/

include __DIR__ . '/includes/metaboxes.php';

/*==============================

    HELPERS

==============================*/

function formatDate($str)
{
    $months = ['jan', 'fev', 'mar', 'abr', 'mai', 'jun', 'jul', 'ago', 'set', 'out', 'nov', 'dez'];
    $date = strtotime($str);
    $d = date('d', $date);
    $m = date('n', $date);
    $m = $months[$m - 1];
    $y = date('Y', $date);

    $result = $d . " de " . $m . " de " . $y;
    return $result;
}

function escape_categories($cats)
{
    if (empty($cats)) {
        return ['id' => null, 'name' => 'Sem categoria'];
    }

    $id = $cats[0];
    $name = get_cat_name($id);

    if ($name === 'Destacado' && isset($cats[1])) {
        $id = $cats[1];
        $name = get_cat_name($id);
    }

    return ['id' => $id, 'name' => $name];
}

function lit_render_thumbnail($post, $size = "medium")
{
    $cats = wp_get_post_categories($post->ID);
    $link =  get_permalink($post->ID);
    $thumbURL = get_the_post_thumbnail_url($post->ID, $size);

    $tb = '<a class="featured-image-container" href="' . $link . '" title="' . $post->post_title . '" aria-label="' . $post->post_title . '"><img class="featured-image" src="' . $thumbURL . '" load="lazy" alt="' . $post->post_title . '"/></a>';

    foreach ($cats as $cat) {
        $name = get_cat_name($cat);

        if ($name == 'Colunas') {
            $tb = '<a class="featured-image-container" href="' . $link . '" title="' . $post->post_title . '" aria-label="' . $post->post_title . '"><div class="opinion-ribbon">Opinião</div><img class="featured-image" src="' . $thumbURL . '" load="lazy" alt="' . $post->post_title . '"/></a>';
        }
    }
    return $tb;
}

include get_template_directory() . '/includes/blocks.php';

function custom_breadcrumbs()
{
    // Configurações
    $separator = ' &gt; ';
    $home_title = 'Home';

    // Pega a URL do home
    $home_link = get_home_url();

    // Início dos breadcrumbs
    echo '<ul class="breadcrumbs">';

    // Home
    echo '<li><a href="' . $home_link . '">' . $home_title . '</a></li>';
    echo '<li>' . $separator . '</li>';

    if (is_single()) {
        $category = get_the_category();
        if (!empty($category)) {
            $cat = $category[0];
            $parents = array();
            while ($cat->parent) {
                $cat = get_category($cat->parent);
                array_unshift($parents, $cat);
            }
            foreach ($parents as $parent) {
                $parent_link = get_category_link($parent->term_id);
                echo '<li><a href="' . $parent_link . '">' . $parent->name . '</a></li>';
                echo '<li>' . $separator . '</li>';
            }
            $category_link = get_category_link($category[0]->term_id);
            echo '<li><a href="' . $category_link . '">' . $category[0]->name . '</a></li>';
            echo '<li>' . $separator . '</li>';
        }
        echo '<li>' . get_the_title() . '</li>';
    } elseif (is_page()) {
        if (isset($post) && $post->post_parent) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                echo $crumb . ' ' . $separator . ' ';
            }
        }
        echo '<li>' . get_the_title() . '</li>';
    } elseif (is_category()) {
        $category = get_queried_object();
        if ($category->parent != 0) {
            $parents = array();
            $cat = $category;
            while ($cat->parent) {
                $cat = get_category($cat->parent);
                array_unshift($parents, $cat);
            }
            foreach ($parents as $parent) {
                $parent_link = get_category_link($parent->term_id);
                echo '<li><a href="' . $parent_link . '">' . $parent->name . '</a></li>';
                echo '<li>' . $separator . '</li>';
            }
        }
        echo '<li>' . single_cat_title('', false) . '</li>';
    } elseif (is_search()) {
        echo '<li>Search results for: ' . get_search_query() . '</li>';
    } elseif (is_404()) {
        echo '<li>Error 404</li>';
    }

    echo '</ul>';
}

function prepare_children_categories($category)
{
    // Obtém as categorias filhas
    $child_categories = get_term_children($category, 'category');

    // Verifica se existem categorias filhas e as adiciona à consulta
    if (!empty($child_categories)) {
        $category = array_merge(array($category), $child_categories);
    }

    return $category;
}

function create_custom_post_types()
{
    // Notícias
    register_post_type(
        'noticias',
        array(
            'labels'      => array(
                'name'               => __('Notícias'),
                'singular_name'      => __('Notícia'),
                'add_new'            => __('Adicionar Nova'),
                'add_new_item'       => __('Adicionar Nova Notícia'),
                'edit_item'          => __('Editar Notícia'),
                'new_item'           => __('Nova Notícia'),
                'view_item'          => __('Ver Notícia'),
                'search_items'       => __('Procurar Notícias'),
                'not_found'          => __('Nenhuma Notícia Encontrada'),
                'not_found_in_trash' => __('Nenhuma Notícia Encontrada na Lixeira'),
                'all_items'          => __('Todas as Notícias'),
                'menu_name'          => __('Notícias'),
                'name_admin_bar'     => __('Notícia'),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array('slug' => 'noticias'),
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'categories', 'tags'),
            'taxonomies'  => array('category', 'post_tag'),
        )
    );

    // Análises
    register_post_type(
        'analises',
        array(
            'labels'      => array(
                'name'               => __('Análises'),
                'singular_name'      => __('Análise'),
                'add_new'            => __('Adicionar Nova'),
                'add_new_item'       => __('Adicionar Nova Análise'),
                'edit_item'          => __('Editar Análise'),
                'new_item'           => __('Nova Análise'),
                'view_item'          => __('Ver Análise'),
                'search_items'       => __('Procurar Análises'),
                'not_found'          => __('Nenhuma Análise Encontrada'),
                'not_found_in_trash' => __('Nenhuma Análise Encontrada na Lixeira'),
                'all_items'          => __('Todas as Análises'),
                'menu_name'          => __('Análises'),
                'name_admin_bar'     => __('Análise'),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array('slug' => 'analises'),
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'categories', 'tags'),
            'taxonomies'  => array('category', 'post_tag'),
        )
    );

    // Propaganda
    register_post_type(
        'propaganda',
        array(
            'labels'      => array(
                'name'               => __('Propaganda'),
                'singular_name'      => __('Propaganda'),
                'add_new'            => __('Adicionar Nova'),
                'add_new_item'       => __('Adicionar Nova Propaganda'),
                'edit_item'          => __('Editar Propaganda'),
                'new_item'           => __('Nova Propaganda'),
                'view_item'          => __('Ver Propaganda'),
                'search_items'       => __('Procurar Propaganda'),
                'not_found'          => __('Nenhuma Propaganda Encontrada'),
                'not_found_in_trash' => __('Nenhuma Propaganda Encontrada na Lixeira'),
                'all_items'          => __('Todas as Propagandas'),
                'menu_name'          => __('Propaganda'),
                'name_admin_bar'     => __('Propaganda'),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array('slug' => 'propaganda'),
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'comments', 'categories', 'tags'),
            'taxonomies'  => array('post_tag'),
        )
    );
}

add_action('init', 'create_custom_post_types');

// Adicionar uma nova taxonomia específica para o post type 'propaganda'
function create_custom_taxonomies()
{
    // Categoria de Propaganda
    register_taxonomy(
        'categoria_propaganda',
        'propaganda',
        array(
            'labels' => array(
                'name'              => __('Categorias de Propaganda'),
                'singular_name'     => __('Categoria de Propaganda'),
                'search_items'      => __('Procurar Categorias de Propaganda'),
                'all_items'         => __('Todas as Categorias de Propaganda'),
                'parent_item'       => __('Categoria de Propaganda Mãe'),
                'parent_item_colon' => __('Categoria de Propaganda Mãe:'),
                'edit_item'         => __('Editar Categoria de Propaganda'),
                'update_item'       => __('Atualizar Categoria de Propaganda'),
                'add_new_item'      => __('Adicionar Nova Categoria de Propaganda'),
                'new_item_name'     => __('Novo Nome de Categoria de Propaganda'),
                'menu_name'         => __('Categoria de Propaganda'),
            ),
            'hierarchical' => true, // Se verdadeiro, funciona como categorias. Se falso, funciona como tags.
            'show_ui'      => true,
            'show_admin_column' => true,
            'query_var'    => true,
            'rewrite'      => array('slug' => 'categoria-propaganda'),
        )
    );
}

add_action('init', 'create_custom_taxonomies');


// Desativa o oEmbed para links nos posts
function disable_embed()
{
    remove_filter('the_content', [$GLOBALS['wp_embed'], 'autoembed'], 8);
}
add_action('wp_enqueue_scripts', 'disable_embed');

// Adiciona parametros UTMs nos posts e paginas
function add_custom_utms()
{
    // Adiciona o script diretamente no HTML
?>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                window.history.replaceState(null, null, "?utm_source=copylink&utm_medium=browser");
            }, 2000);
        });
    </script>
<?php
}
add_action('wp_footer', 'add_custom_utms');

include get_template_directory() . '/includes/admin/functions.php';
