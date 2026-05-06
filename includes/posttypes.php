<?php

function create_custom_post_types()
{
    /* ==================================================

        Notíticas

    ================================================== */
    register_post_type(
        'news',
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
            'rewrite'     => array('slug' => 'news'),
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'show_in_rest' => true,
            'taxonomies'  => array('category', 'post_tag'),
        )
    );

    /* ==================================================

        Análises

    ================================================== */
    register_post_type(
        'analysis',
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
            'rewrite'     => array('slug' => 'analysis'),
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'show_in_rest' => true,
            'taxonomies'  => array('category', 'post_tag'),
        )
    );

    /* ==================================================

        Propaganda

    ================================================== */
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
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'show_in_rest' => true,
            'taxonomies'  => array('post_tag'),
        )
    );

    /* ==================================================

        Correio Internacional

    ================================================== */
    register_post_type(
        'courier',
        array(
            'labels'      => array(
                'name'               => __('Correio Internacional'),
                'singular_name'      => __('Correio Internacional'),
                'add_new'            => __('Adicionar'),
                'add_new_item'       => __('Adicionar texto da CI'),
                'edit_item'          => __('Editar'),
                'new_item'           => __('Novo texto'),
                'view_item'          => __('Ver'),
                'search_items'       => __('Procurar texto da CI'),
                'not_found'          => __('Nenhuma texto da Correio Internacional encontrado'),
                'not_found_in_trash' => __('Nenhuma texto da Correio Internacional encontrado na Lixeira'),
                'all_items'          => __('Todas os textos da CI'),
                'menu_name'          => __('Correio Internacional'),
                'name_admin_bar'     => __('Correio Internacional'),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array('slug' => 'courier'),
            'supports'    => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
            'show_in_rest' => true,
            'taxonomies'  => array('post_tag'),
        )
    );
}

add_action('init', 'create_custom_post_types');

/* ==================================================

        Taxonomias Personalizadas

================================================== */
function create_custom_taxonomies()
{
    /* ==================================================

        Categorias de Propaganda

    ================================================== */
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
            'show_in_rest' => true,
            'query_var'    => true,
            'rewrite'      => array('slug' => 'categoria-propaganda'),
        )
    );

    /* ==================================================

        Categorias de Correio Internacional

    ================================================== */
    register_taxonomy(
        'courier_category',
        'courier',
        array(
            'labels' => array(
                'name'              => __('Categorias de CI'),
                'singular_name'     => __('Categoria de CI'),
                'search_items'      => __('Procurar Categorias de CI'),
                'all_items'         => __('Todas as Categorias de CI'),
                'parent_item'       => __('Categoria de CI Mãe'),
                'parent_item_colon' => __('Categoria de CI Mãe:'),
                'edit_item'         => __('Editar Categoria de CI'),
                'update_item'       => __('Atualizar Categoria de CI'),
                'add_new_item'      => __('Adicionar Nova Categoria de CI'),
                'new_item_name'     => __('Novo Nome de Categoria de CI'),
                'menu_name'         => __('Categoria de CI'),
            ),
            'hierarchical' => true, // Se verdadeiro, funciona como categorias. Se falso, funciona como tags.
            'show_ui'      => true,
            'show_admin_column' => true,
            'show_in_rest' => true,
            'query_var'    => true,
            'rewrite'      => array('slug' => 'courier-category'),
        )
    );
}

add_action('init', 'create_custom_taxonomies');
