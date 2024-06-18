(function (blocks, editor, element, components) {
    var el = element.createElement;
    var ServerSideRender = components.ServerSideRender;

    blocks.registerBlockType('litci/block02', {
        title: 'LIT-Bloco 2',
        icon: 'list-view',
        category: 'common',
        edit: function (props) {
            return el('div', {}, 
                el('h3', {}, 'Título do Bloco'), // Adiciona o título H3
                el(ServerSideRender, {
                    block: 'litci/block02',
                    attributes: props.attributes,
                })
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
