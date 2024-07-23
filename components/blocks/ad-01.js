(function (blocks, editor, element, components) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;
    var InspectorControls = editor.InspectorControls;
    var MediaUpload = editor.MediaUpload;
    var URLInput = editor.URLInput;
    var Button = components.Button;

    // Adiciona a nova categoria
    blocks.updateCategory('litci-category', {
        title: 'LIT-CI Blocks',
        icon: 'admin-customizer',
        slug: 'litci-category',
    });

    blocks.registerBlockType('litci/ad-01', {
        title: 'LIT-BannerAds 1',
        icon: 'align-pull-left',
        category: 'litci-category', 
        attributes: {
            backgroundColor: {
                type: 'string',
                default: 'white',
            },
            isDark: {
                type: 'boolean',
                default: false,
            },
            backgroundImage: {
                type: 'string',
                default: null,
            },
            link: {
                type: 'string',
                default: '',
            }
        },
        edit: function (props) {
            var attributes = props.attributes;

            var onSelectImage = function (media) {
                props.setAttributes({ backgroundImage: media.url });
            };

            var onChangeLink = function (newLink) {
                props.setAttributes({ link: newLink });
            };

            var onChangeBackgroundColor = function (newColor) {
                var darkColors = ['#666666', '#565656', '#474747', '#323232', '#222222'];
                var isDark = darkColors.includes(newColor);
                props.setAttributes({ backgroundColor: newColor, isDark: isDark });
            };

            return el('div', { className: "block-card", style:{}},
                attributes.backgroundImage ? el('img', { src: attributes.backgroundImage, style: { width: '100%' } }) : el('div', {}, 'Nenhuma imagem selecionada'),
                el(InspectorControls, {},
                    el('div', { className: "block-editor-block-card" },
                        el(MediaUpload, {
                            onSelect: onSelectImage,
                            allowedTypes: ['image'],
                            render: function (obj) {
                                return el(Button, {
                                    className: attributes.backgroundImage ? 'image-button' : 'button button-large',
                                    onClick: obj.open
                                }, !attributes.backgroundImage ? 'Selecione uma imagem de fundo' : 'Alterar imagem de fundo');
                            }
                        })
                    ),
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'Link',
                        value: attributes.link,
                        onChange: onChangeLink
                    }),
                    el(SelectControl, {
                        className: "block-editor-block-card",
                        label: 'Cor de Fundo',
                        value: attributes.backgroundColor,
                        options: [
                            { label: 'White', value: '#ffffff' },
                            { label: 'Gray 50', value: '#f8f8f8' },
                            { label: 'Gray 100', value: '#eaeaea' },
                            { label: 'Gray 200', value: '#d8d8d8' },
                            { label: 'Gray 300', value: '#bababa' },
                            { label: 'Gray 400', value: '#aaaaaa' },
                            { label: 'Gray 500', value: '#9b9b9b' },
                            { label: 'Gray 600', value: '#666666' },
                            { label: 'Gray 700', value: '#565656' },
                            { label: 'Gray 800', value: '#474747' },
                            { label: 'Gray 900', value: '#323232' },
                            { label: 'Gray 950', value: '#222222' },
                        ],
                        onChange: onChangeBackgroundColor
                    })
                )
            );
        },
        save: function () {
            return null; // Não é necessário salvar nada no frontend
        },
    });
})(
    window.wp.blocks,
    window.wp.editor,
    window.wp.element,
    window.wp.components
);
