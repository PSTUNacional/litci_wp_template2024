<?php
#
# Tagline
#

function tagline_metabox()
{
    add_meta_box(
        'litci_post_tagline',
        'Linha fina',
        'tagline_metabox_callback',
        'post',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tagline_metabox');
function tagline_metabox_callback($post)
{
    $value = get_post_meta($post->ID, 'litci_post_tagline', true); ?>
    <p>A linha fina é o resumo que aparece logo abaixo do título e funciona como uma síntese da matéria. Esse valor será exibido também na página inicial como chamada. Não havendo esse valor, o site usará o começo do texto (menos recomendável).</p>
    <textarea class="panel" id="litci_post_tagline" name="litci_post_tagline"><?= $value; ?></textarea>
<?php
}

function tagline_metabox_saver($postId)
{

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $postId;
    }

    if (isset($_POST['litci_post_tagline'])) {
        $current_value = get_post_meta($postId, 'litci_post_tagline', true);
        $new_value = sanitize_text_field($_POST['litci_post_tagline']);

        if ($current_value !== $new_value) {
            update_post_meta($postId, 'litci_post_tagline', $new_value);
        }
    } else {
        error_log('tagline_metabox_saver() => Metavalue not saved. The field "litci_post_tagline" missing.');
    }
}

add_action('save_post', 'tagline_metabox_saver');

/*============================================================
    Auto Formater
============================================================*/

function enqueue_autoformat_sidebar_script($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }
    wp_enqueue_script(
        'autoformat-sidebar',
        get_template_directory_uri() . '/assets/js/autoformat-sidebar.js',
        ['wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-compose', 'wp-api-fetch'],
        filemtime(get_template_directory() . '/assets/js/autoformat-sidebar.js'),
        true
    );
}
add_action('admin_enqueue_scripts', 'enqueue_autoformat_sidebar_script');

#
# Political Author
#

function enqueue_political_author_script($hook) {
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }
    wp_enqueue_script(
        'political_author_script',
        get_template_directory_uri() . '/assets/js/political-author.js',
        ['wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-compose'],
        filemtime(get_template_directory() . '/assets/js/political-author.js'),
        true
    );
}
add_action('admin_enqueue_scripts', 'enqueue_political_author_script');

function save_political_author_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;

    if (isset($_POST['litci_post_political_author'])) {
        $value = sanitize_text_field($_POST['litci_post_political_author']);
        update_post_meta($post_id, 'litci_post_political_author', $value);
    }
}
add_action('save_post', 'save_political_author_meta');

#
# Menu Order
#

function enqueue_menu_order_sidebar_script($hook) {
    if ($hook !== 'post.php' && $hook !== 'post-new.php') return;

    wp_enqueue_script(
        'menu-order-sidebar-script',
        get_template_directory_uri() . '/assets/js/menu-order-sidebar.js',
        ['wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-compose'],
        filemtime(get_template_directory() . '/assets/js/menu-order-sidebar.js'),
        true
    );
}
add_action('admin_enqueue_scripts', 'enqueue_menu_order_sidebar_script');

// Adicionar nova coluna na tabela de posts
function add_menu_order_column($columns)
{
    $columns['menu_order'] = 'Prioridade do post';
    return $columns;
}

// Preencher a nova coluna com o valor de menu_order
function show_menu_order_column($column, $postId)
{
    if ($column === 'menu_order') {
        $menu_order = get_post_field('menu_order', $postId);
        echo '<input type="text" class="menu-order-input" value="' . esc_attr($menu_order) . '" data-post-id="' . esc_attr($postId) . '">';
    }
}

add_filter('manage_posts_columns', 'add_menu_order_column');
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
        $postId = intval($_POST['post_id']);
        $menu_order = intval($_POST['menu_order']);

        $post_data = array(
            'ID' => $postId,
            'menu_order' => $menu_order
        );

        wp_update_post($post_data);
        wp_send_json_success();
    } else {
        wp_send_json_error('Dados inválidos.');
    }
}
add_action('wp_ajax_update_menu_order', 'update_menu_order');
