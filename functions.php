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
    if ($hook === 'edit.php' || $hook === 'customize.php') {
        wp_enqueue_script('custom-admin-js', get_template_directory_uri() . '/assets/js/custom-admin.js', array('jquery'), null, true);
        wp_localize_script('custom-admin-js', 'customAdminAjax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('custom_admin_nonce')
        ));
    }

    wp_enqueue_style('custom-admin-css', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0', 'all');
}
add_action('admin_enqueue_scripts', 'load_admin_scripts');

function load_customize_scripts($hook)
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
}

add_action('after_setup_theme', 'litci_config', 0);

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

    Add METABOXES
    Tagline

==============================*/

function tagline_metabox()
{
    add_meta_box(
        'post_tagline',
        'Linha fina',
        'tagline_metabox_callback',
        'post',
        'normal',
        'high'
    );
}

function tagline_metabox_callback($post)
{
    $value = get_post_meta($post->ID, 'post_tagline', true); ?>
    <p>A linha fina é o resumo que aparece logo abaixo do título e funciona como uma síntese da matéria. Esse valor será exibido também na página inicial como chamada. Não havendo esse valor, o site usará o começo do texto (menos recomendável).</p>
    <textarea class="panel" id="post_tagline" name="post_tagline"><?= $value; ?></textarea>
<?php

}

add_action('add_meta_boxes', 'tagline_metabox');


function tagline_metabox_saver($postId)
{
    if (array_key_exists('post_tagline', $_POST)) {
        update_post_meta(
            $postId,
            'post_tagline',
            $_POST['post_tagline']
        );
    }
}

add_action('save_post', 'tagline_metabox_saver');

// Edit menu_order capability
function add_custom_post_type_support()
{
    add_post_type_support('post', 'page-attributes');
}
add_action('init', 'add_custom_post_type_support');

function add_menu_order_meta_box()
{
    add_meta_box(
        'menu_order_meta_box',   // ID da meta box
        'Prioridade do post',         // Título da meta box
        'display_menu_order_meta_box', // Callback para exibir o conteúdo
        'post',                  // Tipo de post onde a meta box será adicionada
        'side',                  // Contexto onde a meta box aparecerá ('side', 'normal', 'advanced')
        'default'                // Prioridade da meta box ('high', 'low')
    );
}
add_action('add_meta_boxes', 'add_menu_order_meta_box');

function display_menu_order_meta_box($post)
{
    $menu_order = $post->menu_order;
?>
    <label for="menu_order_field">Ordem do Menu</label>
    <input type="text" name="menu_order_field" value="<?php echo $menu_order; ?>" />
<?php
}

function save_menu_order_meta_box_data($post_id)
{
    if (array_key_exists('menu_order_field', $_POST)) {
        $menu_order = intval($_POST['menu_order_field']);
        wp_update_post(array(
            'ID' => $post_id,
            'menu_order' => $menu_order,
        ));
    }
}
add_action('save_post', 'save_menu_order_meta_box_data');

// Adicionar nova coluna na tabela de posts
function add_menu_order_column($columns)
{
    $columns['menu_order'] = 'Prioridade do post';
    return $columns;
}
add_filter('manage_posts_columns', 'add_menu_order_column');

// Preencher a nova coluna com o valor de menu_order
function show_menu_order_column($column, $post_id)
{
    if ($column === 'menu_order') {
        $menu_order = get_post_field('menu_order', $post_id);
        echo '<input type="text" class="menu-order-input" value="' . esc_attr($menu_order) . '" data-post-id="' . esc_attr($post_id) . '">';
    }
}
add_action('manage_posts_custom_column', 'show_menu_order_column', 10, 2);

// Tornar a coluna 'menu_order' ordenável
function set_menu_order_column_sortable($columns)
{
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter('manage_edit-post_sortable_columns', 'set_menu_order_column_sortable');

// Ajustar a consulta principal para ordenar pelo 'menu_order'
function sort_posts_by_menu_order($query)
{
    // Verificar se estamos na administração, na tela de edição de posts e se a coluna correta foi selecionada para ordenar
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->query['orderby'] == 'menu_order') {
        $query->set('orderby', 'menu_order');
    }
}
add_action('pre_get_posts', 'sort_posts_by_menu_order');

// Função PHP para atualizar o menu_order via AJAX
function update_menu_order()
{
    check_ajax_referer('custom_admin_nonce', 'nonce');

    if (isset($_POST['post_id']) && isset($_POST['menu_order'])) {
        $post_id = intval($_POST['post_id']);
        $menu_order = intval($_POST['menu_order']);

        $post_data = array(
            'ID' => $post_id,
            'menu_order' => $menu_order
        );

        wp_update_post($post_data);
        wp_send_json_success();
    } else {
        wp_send_json_error('Dados inválidos.');
    }
}
add_action('wp_ajax_update_menu_order', 'update_menu_order');

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
    if (sizeof($cats) == 0) {
        $cat = 'Sem categoria';
    } else {
        $cat = get_cat_name($cats[0]);
        if ($cat == 'Opinião Socialista' && sizeof($cats) > 1) {
            $cat = get_cat_name($cats[1]);
        } elseif ($cat == 'Opinião Socialista' && sizeof($cats) <= 1) {
            $cat = 'Especial';
        }
    }
    return $cat;
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


function register_litci_blocks() {

    $blockList = [
        "block-01",
        "block-02",
        "block-03",
        "block-04",
        "block-05",
        "video-01",
        "stories"
    ];

    forEach($blockList as $block)
    {
        wp_register_script(
            'litci-'.$block,
            get_template_directory_uri() . '/components/blocks/'.$block.'.js',
            array('wp-blocks', 'wp-editor'),
            null,
            true
        );
    
        $callback = 'render_litci_'.$block;
        $callback = str_replace('-','_', $callback);

        register_block_type('litci/'.$block, array(
            'editor_script' => 'litci-'.$block,
            'render_callback' => $callback
        ));
    
    }
}

add_action('init', 'register_litci_blocks');

function render_litci_block_01($attributes) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4, // Número de posts a serem exibidos
    );

    $posts = get_posts($args);
    if(isset($attributes['blockTitle'])){
        $block_title = $attributes['blockTitle'];
    }
    
    include get_template_directory() . '/components/blocks/block-01.php';

    wp_reset_postdata();

}

function render_litci_block_02($attributes) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4, // Número de posts a serem exibidos
    );

    isset($attributes['blockCategories'])
        ? $args['category__in'] = $attributes['blockCategories']
        : '';

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    $posts = get_posts($args);

    include get_template_directory() . '/components/blocks/block-02.php';

    wp_reset_postdata();

}

function render_litci_block_03($attributes) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 4, // Número de posts a serem exibidos
    );

    isset($attributes['blockCategories'])
        ? $args['category__in'] = $attributes['blockCategories']
        : '';

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';


    $posts = get_posts($args);
    include get_template_directory() . '/components/blocks/block-03.php';

    wp_reset_postdata();

}

function render_litci_block_04($attributes) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5, // Número de posts a serem exibidos
    );

    isset($attributes['blockCategories'])
        ? $args['category__in'] = $attributes['blockCategories']
        : '';

    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    $posts = get_posts($args);
    include get_template_directory() . '/components/blocks/block-04.php';

    wp_reset_postdata();
}


function render_litci_block_05($attributes) {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 5, // Número de posts a serem exibidos
    );

    isset($attributes['blockCategories'])
        ? $args['category__in'] = $attributes['blockCategories']
        : '';
    isset($attributes['blockTitle'])
        ? $block_title = $attributes['blockTitle']
        : '';

    $posts = get_posts($args);
    include get_template_directory() . '/components/blocks/block-05.php';

    wp_reset_postdata();
}

function render_litci_video_01($attributes) {
    include get_template_directory() . '/components/blocks/video-01.php';
    wp_reset_postdata();
}


function render_litci_stories($attributes) {
    include get_template_directory() . '/components/blocks/stories.php';
    wp_reset_postdata();
}

function custom_breadcrumbs() {
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

    if ( is_single() ) {
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
    } elseif ( is_page() ) {
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
    } elseif ( is_category() ) {
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
    } elseif ( is_search() ) {
        echo '<li>Search results for: ' . get_search_query() . '</li>';
    } elseif ( is_404() ) {
        echo '<li>Error 404</li>';
    }

    echo '</ul>';
}
