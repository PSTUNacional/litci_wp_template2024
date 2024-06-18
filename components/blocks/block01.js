(function (blocks, editor, element) {
    var el = element.createElement;
    var TextControl = wp.components.TextControl
    var InspectorControls = editor.InspectorControls;

    blocks.registerBlockType('litci/block01', {
        title: 'LIT-Bloco 01',
        icon: 'smiley',
        category: 'common',
        attributes: {
            blockTile: {
                type: 'string',
                source: 'html',
                selector: 'h3'
            },
            postsCount: {
                type: 'number',
                default: 5, // Define o número padrão de posts a serem exibidos
            },
        },
        edit: function (props) {
            var onChangeTitulo = function (novoTitulo) {
                props.setAttributes({ titulo: novoTitulo });
            };
            return el('div', { className: props.className },
                el(InspectorControls, {}, // Adiciona controles do bloco à barra lateral direita
                    el('div', { key: 'custom-controls' }, // Adiciona uma seção personalizada aos controles
                        el(TextControl, {
                            label: 'Título',
                            value: props.attributes.titulo,
                            onChange: onChangeTitulo,
                        })
                    )
                ),
                el('div', {}, el('h3', {}, props.attributes.titulo))
            );
        },
        save: function (props) {
            return el('div', {}, el('h3', {}, props.attributes.titulo));
        },
    });
})(
    window.wp.blocks,
    window.wp.editor,
    window.wp.element
);