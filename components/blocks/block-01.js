(function (blocks, editor, element, components) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;
    var InspectorControls = editor.InspectorControls;
    

    blocks.registerBlockType('litci/block-01', {
        title: 'LIT-Bloco 1',
        icon: 'align-pull-left',
        category: 'common',
        attributes: {
            blockTitle: {
                type: 'string',
                default: 'Bloco 01',
            },
            sortOption: { // Novo atributo para a opção de ordenação
                type: 'string',
                default: 'recent',
            },
        },
        edit: function (props) {
            var attributes = props.attributes;

            var onChangeTitle = function (newTitle) {
                props.setAttributes({ blockTitle: newTitle });
            };

            var onChangeSortOption = function (newSortOption) {
                props.setAttributes({ sortOption: newSortOption });
            };

            return el('div', { className: "block-card" },
                el('h3', {}, attributes.blockTitle),
                el('div', {
                    style: { display: 'flex', gap: '24px' }
                },
                    el('div', { className: 'block01-preview' }),
                    el('div', { className: 'block01-preview', style: {backgroundColor: "#fff"} }),
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
                        label: 'Opção de Ordenação',
                        value: attributes.sortOption,
                        options: [
                            { label: 'Mais recentes', value: 'publish_date' },
                            { label: 'Prioritários primeiro', value: 'menu_order' }
                        ],
                        onChange: onChangeSortOption
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
