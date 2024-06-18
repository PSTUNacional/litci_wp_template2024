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

    // The list of banners places to iterate
    $blockList = [
        [
            "slug" => "block01",
            "name"  => __("Bloco 01"),
        ],
        [
            "slug" => "block02",
            "name"  => __("Bloco 02"),
        ],
        [
            "slug" => "block03",
            "name"  => __("Bloco 03"),
        ],
        [
            "slug" => "block04",
            "name"  => __("Bloco 04"),
        ],
        [
            "slug" => "block05",
            "name"  => __("Bloco 05"),
        ],
        [
            "slug" => "block06",
            "name"  => __("Bloco 06"),
        ],
        [
            "slug" => "block07",
            "name"  => __("Bloco 07"),
        ],
        [
            "slug" => "block08",
            "name"  => __("Bloco 08"),
        ],


    ];

    // Iterate block list to render Theme Customization sections
    foreach ($blockList as $block) {
        $wp_customize->add_section('content_' . $block['slug'], [
            'title' => __($block['name']),
            'panel' => 'blocks_panel',
            'priority'  => 10,
        ]);

        // Is active
        $wp_customize->add_setting('content_' . $block['slug'] . '_status', [
            'default' => true,
            'sanitize_callback' => 'wp_validate_boolean',
        ]);
        $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'content_' . $block['slug'] . '_status',
            [
                'label'     => __('Mostrar bloco'),
                'section'   => 'content_' . $block['slug'],
                'settings'  => 'content_' . $block['slug'] . '_status',
                'type'     => 'checkbox',
            ]
        ));

        // Title
        $wp_customize->add_setting('content_' . $block['slug'] . '_title', [
            'default' => '',
            'sanitize_callback' => null,
        ]);
        $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'content_' . $block['slug'] . '_title',
            [
                'label'     => __('Título do bloco'),
                'section'   => 'content_' . $block['slug'],
                'settings'  => 'content_' . $block['slug'] . '_title',
                'type'     => 'text',
            ]
        ));

        // Layout
        $wp_customize->add_setting('content_' . $block['slug'] . '_layout', [
            'default' => 'block-01',
            'sanitize_callback' => null,
        ]);
        $wp_customize->add_control(new WP_Customize_Control(
            $wp_customize,
            'content_' . $block['slug'] . '_layout',
            [
                'label' => __('Lauyout do bloco'),
                'section' => 'content_' . $block['slug'],
                'settings'  => 'content_' . $block['slug'] . '_layout',
                'type'  => 'radio',
                'choices'   => [
                    'block-01' => __('Bloco 01'),
                    'block-02' => __('Bloco 02'),
                    'block-03' => __('Bloco 03'),
                    'block-04' => __('Bloco 04'),
                    'video-01' => __('Video 01'),
                    'stories' => __('Stories'),
                ]
            ]
        ));

        // Category list
        $wp_customize->add_setting('content_' . $block['slug'] . '_category', [
            'default'   => '',
            'sanitize_callback' => 'litci_sanitize_categories',
        ]);
        $wp_customize->add_control(new WP_Customize_Multi_Select_Control(
            $wp_customize,
            'content_' . $block['slug'] . '_category',
            [
                'label' => __('Categoria do bloco'),
                'section' => 'content_' . $block['slug'],
                'settings' => 'content_' . $block['slug'] . '_category',
            ]
        ));
    }
}

add_action('customize_register', 'litci_theme_customizer');

function litci_sanitize_categories($input)
{
    return array_map('absint', explode(',', $input));
}

if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Multi_Select_Control extends WP_Customize_Control
    {
        public $type = 'multi-select';

        public function valueOf()
        {
            if (is_array($this->value())) {
                return $this->value();
            }
            return explode(',', $this->value());
        }


        public function render_content()
        {
            $categories = get_categories();
            if (empty($categories)) {
                return;
            }
?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <div class="category-multi-select-container" id="cat-selector-<?= esc_attr($this->id) ?>">
                    <?php
                    foreach ($categories as $cat) : ?>
                        <label>
                            <input type="checkbox" value="<?= $cat->term_id ?>" id="cat_<?= $cat->term_id ?>" <?php checked(in_array($cat->term_id, $this->valueOf())); ?>> <?= $cat->name ?>
                        </label>
                    <?php
                    endforeach;
                    ?>
                    <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr(implode(',', $this->valueOf())); ?>" />
            </label>
            </div>
            </label>
    <?php
        }
    }
}

function litci_customizer_block_scripts()
{
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.category-multi-select-container').on('change', 'input[type="checkbox"]', function() {
                target_id = '#' + this.parentNode.parentNode.id;
                var selectedCategories = [];
                $(target_id + ' input[type="checkbox"]:checked').each(function() {
                    selectedCategories.push($(this).val());
                });
                $(target_id + ' input[type="hidden"]').val(selectedCategories.join(',')).change();
            });
        });
    </script>
<?php
}
add_action('customize_controls_print_footer_scripts', 'litci_customizer_block_scripts');
