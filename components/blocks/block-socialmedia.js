(function (blocks, editor, element, components) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var SelectControl = components.SelectControl;

    // Adiciona a nova categoria
    blocks.updateCategory('litci-category', {
        title: 'LIT-CI Blocks',
        icon: 'admin-customizer',
        slug: 'litci-category',
    });

    blocks.registerBlockType('litci/block-socialmedia', {
        title: 'LIT-Bloco Social Media',
        icon: 'align-full-width',
        category: 'litci-category',
        attributes: {
            blockTitle: {
                type: 'string',
                default: 'Social Media',
            },
            backgroundColor: {
                type: 'string',
                default: 'white',
            },
            isDark: {
                type: 'boolean',
                default: false,
            },
            facebook: {
                type: 'string',
                default: '',
            },
            instagram: {
                type: 'string',
                default: '',
            },
            twitter: {
                type: 'string',
                default: '',
            },
            youtube: {
                type: 'string',
                default: '',
            },
            tiktok: {
                type: 'string',
                default: '',
            },
            whatsapp: {
                type: 'string',
                default: '',
            },
        },
        edit: (function (props) {
            var attributes = props.attributes;

            var onChangeTitle = function (newTitle) {
                props.setAttributes({ blockTitle: newTitle });
            };

            var onChangeBackgroundColor = function (newColor) {
                var darkColors = ['#666666', '#565656', '#474747', '#323232', '#222222'];
                var isDark = darkColors.includes(newColor);
                props.setAttributes({ backgroundColor: newColor, isDark: isDark });
            };

            var onChangeSocialMedia = function (platform, value) {
                var newAttributes = {};
                newAttributes[platform] = value;
                props.setAttributes(newAttributes);
            };

            return el('div', { className: "block-card" },
                el('h3', {}, attributes.blockTitle),
                el('div', {
                    style: { display: 'flex', gap: '24px' }
                },
                    el('div', { className: 'block02-preview' }),
                    el('div', { className: 'block02-preview' }),
                    el('div', { className: 'block02-preview' }),
                ),
                el(InspectorControls, {},
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'Título do Bloco',
                        value: attributes.blockTitle,
                        onChange: onChangeTitle
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
                    }),
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'Facebook',
                        value: attributes.facebook,
                        onChange: function (value) { onChangeSocialMedia('facebook', value); }
                    }),
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'Instagram',
                        value: attributes.instagram,
                        onChange: function (value) { onChangeSocialMedia('instagram', value); }
                    }),
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'Twitter',
                        value: attributes.twitter,
                        onChange: function (value) { onChangeSocialMedia('twitter', value); }
                    }),
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'Youtube',
                        value: attributes.youtube,
                        onChange: function (value) { onChangeSocialMedia('youtube', value); }
                    }),
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'TikTok',
                        value: attributes.tiktok,
                        onChange: function (value) { onChangeSocialMedia('tiktok', value); }
                    }),
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'Whatsapp',
                        value: attributes.whatsapp,
                        onChange: function (value) { onChangeSocialMedia('whatsapp', value); }
                    })
                )
            );
        }),
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
