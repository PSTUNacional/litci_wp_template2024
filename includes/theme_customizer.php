<?php

add_theme_support('custom-logo');
function litci_custom_logo_setup()
{
    $defaults = [
        'height'               => 100,
        'width'                => 400,
        'flex-height'          => true,
        'flex-width'           => true,
        'header-text'          => ['site-title', 'site-description'],
        'unlink-homepage-logo' => true,
    ];
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'litci_custom_logo_setup');

function litci_theme_customizer($wp_customize)
{

    $wp_customize->add_section('logo_section', array(
        'title' => __('Logos', 'litci_theme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('footer_logo');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo', array(
        'label' => __('Upload da logo do rodapé'),
        'section' => 'logo_section',
        'settings' => 'footer_logo',
    )));

    /***
     * 
     * Ads sections
     * 
     */

    $wp_customize->add_panel('ads_panel', [
        'title' => __('Banners', 'litci_theme'),
        'description'   => __('Configurações dos banners e anúncios.'),
        'priority' => 30,
    ]);

    // The list of banners places to iterate
    $bannersList = [
        [
            "slug" => "header",
            "name"  => __("Banner no cabeçalho"),
            "description"  => __("Banner exibido acima das notícias principais.")
        ],
        [
            "slug" => "middle",
            "name"  => __("Banner ao meio"),
            "description"  => __("Banner exibido logo após das notícias principais.")
        ],
        [
            "slug" => "bottom",
            "name"  => __("Banner no fim"),
            "description"  => __("Banner exibido logo antes do rodapé.")
        ],
    ];

    // Iterate banner list to render Theme Customization sections
    foreach ($bannersList as $banner) {
        $wp_customize->add_section('ad_' . $banner['slug'], [
            'title' => __($banner['name']),
            'panel' => 'ads_panel',
            'priority'  => 10,
        ]);
        $wp_customize->add_setting('banner_ad_' . $banner['slug'] . '_status', [
            'default' => false,
            'sanitize_callback' => 'wp_validate_boolean',
        ]);
        $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'banner_ad_' . $banner['slug'] . '_status',
            [
                'label'     => __('Mostrar banner no cabeçalho'),
                'section'   => 'ad_' . $banner['slug'],
                'settings'  => 'banner_ad_' . $banner['slug'] . '_status',
                'type'     => 'checkbox',
            ]
        ));
        $wp_customize->add_setting('banner_ad_' . $banner['slug'] . '_source', [
            'default'   => '',
            'sanitize_callback' => 'esc_url_raw',
        ]);
        $wp_customize->add_control(new WP_Customize_Image_Control(
            $wp_customize,
            'banner_ad_' . $banner['slug'] . '_source',
            [
                'label' => __('Upload da imagem do banner'),
                'section' => 'ad_' . $banner['slug'],
                'settings' => 'banner_ad_' . $banner['slug'] . '_source',
            ]
        ));
    }

    /***
     * 
     * Blocks Section
     * 
     */

    $wp_customize->add_panel('blocks_panel', [
        'title' => __('Blocos', 'litci_theme'),
        'description'   => __('Configurações dos blocos.'),
        'priority' => 40,
    ]);
}

add_action('customize_register', 'litci_theme_customizer');
