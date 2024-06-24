(function (blocks, editor, element, components) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;

    blocks.registerBlockType('litci/stories', {
        title: 'LIT-Stories',
        icon: 'ellipsis',
        category: 'common',
        attributes: {
            blockTitle: {
                type: 'string',
                default: 'Nossos partidos',
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
                    style: { display: 'flex', gap: '8px' }
                },
                    el('div', { className: "story-preview"}),
                    el('div', { className: "story-preview"}),
                    el('div', { className: "story-preview"}),
                    el('div', { className: "story-preview"}),
                    el('div', { className: "story-preview"}),
                    el('div', { className: "story-preview"}),
                 
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
