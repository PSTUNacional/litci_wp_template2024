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

#
# Political Author
#

function political_author_metabox()
{
    add_meta_box(
        'litci_post_political_author',
        'Autor Político',
        'political_author_metabox_callback',
        'post',
        'side',
        'high'
    );
}

add_action('add_meta_boxes', 'political_author_metabox');

function political_author_metabox_callback($post)
{
    $value = get_post_meta($post->ID, 'litci_post_political_author', true);
    ?>
    <p>Insira o(s) autor(es) político do artigo:</p>
    <input type="text" 
           class="panel" 
           name="litci_post_political_author" 
           id="political_author" 
           value="<?= esc_attr($value); ?>"/>
 <?php
}

function political_author_metabox_saver($postId)
{

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $postId;
    }

    if (isset($_POST['litci_post_political_author'])) {
        $sanitized_value = sanitize_text_field($_POST['litci_post_political_author']);
        update_post_meta($postId, 'litci_post_political_author', $sanitized_value);
    }
}

add_action('save_post', 'political_author_metabox_saver');

#
# Menu Order
#

function add_custom_post_type_support()
{
    add_post_type_support('post', 'page-attributes');
}
add_action('init', 'add_custom_post_type_support');

function add_menu_order_meta_box()
{
    add_meta_box(
        'litci_menu_order_meta_box',   // ID da meta box  
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
    <label for="litci_menu_order_meta_box">Ordem do Menu</label>
    <input type="text" name="litci_menu_order_meta_box" value="<?php echo $menu_order; ?>" />
<?php
}

function save_menu_order_meta_box_data($postId)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $postId;
    }

    if (isset($_POST['litci_menu_order_meta_box'], $_POST)) {
        $menu_order = intval($_POST['litci_menu_order_meta_box']);
        remove_action('save_post', 'save_menu_order_meta_box_data');
        wp_update_post(array(
            'ID' => $postId,
            'menu_order' => $menu_order,
        ));
        add_action('save_post', 'save_menu_order_meta_box_data');
    }
}

add_action('save_post', 'save_menu_order_meta_box_data');

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