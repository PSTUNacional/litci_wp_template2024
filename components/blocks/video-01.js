(function (blocks, editor, element, components) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;

    blocks.registerBlockType('litci/video-01', {
        title: 'LIT-Video 01',
        icon: 'video-alt3',
        category: 'litci-category',
        attributes: {
            blockTitle: {
                type: 'string',
                default: 'Videos',
            },
        },
        edit: function (props) {
            var attributes = props.attributes;

            var onChangeTitle = function (newTitle) {
                props.setAttributes({ blockTitle: newTitle });
            };

            return el('div', { className: "block-card"},
                el('h3', {}, attributes.blockTitle),
                el('div', {
                    style: { display: 'flex', gap: '24px' }
                },
                    el('div', { style: { display: 'flex', flexBasis: "66%" } },
                        el('div', { className: 'block02-preview' }),
                    ),
                    el('div', {
                        style: { display: 'flex', gap: '24px', flexDirection: "column", flexBasis: '33%' }
                    },
                        el('div', { className: 'block02-preview' }),
                        el('div', { className: 'block02-preview' }),
                    ),
                ),
                el(InspectorControls, {},
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'Título do Bloco',
                        value: attributes.blockTitle,
                        onChange: onChangeTitle
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
