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

    blocks.registerBlockType('litci/block-partners', {
        title: 'LIT-Bloco Parceiros',
        icon: 'align-full-width',
        category: 'litci-category',
        attributes: {
            blockTitle: {
                type: 'string',
                default: 'Parceiros',
            },
            backgroundColor: {
                type: 'string',
                default: 'white',
            },
            isDark: {
                type: 'boolean',
                default: false,
            },
        },
        edit: (function (props) {
            var attributes = props.attributes;
            var categoryOptions = props.categoryOptions;

            var onChangeTitle = function (newTitle) {
                props.setAttributes({ blockTitle: newTitle });
            };

            var onChangeBackgroundColor = function (newColor) {
                var darkColors = ['#666666', '#565656', '#474747', '#323232', '#222222', '#000000'];
                var isDark = darkColors.includes(newColor);
                props.setAttributes({ backgroundColor: newColor, isDark: isDark });
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
