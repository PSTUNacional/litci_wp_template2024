(function(wp){
    const { registerPlugin } = wp.plugins;
    const { PluginDocumentSettingPanel } = wp.editPost;
    const { TextControl } = wp.components;
    const { withSelect, withDispatch } = wp.data;
    const { createElement } = wp.element;
    const { compose } = wp.compose;

    const PoliticalAuthorPanel = ({ meta, setMeta }) => {
        return createElement(
            PluginDocumentSettingPanel,
            { name: 'political-author', title: 'Autor Político', className: 'political-author-panel' },
            createElement(TextControl, {
                label: 'Insira o(s) autor(es) político do artigo:',
                value: meta || '',
                onChange: setMeta
            })
        );
    };

    const PoliticalAuthorPanelWithData = compose(
        withSelect(select => ({
            meta: select('core/editor').getEditedPostAttribute('meta')['litci_post_political_author']
        })),
        withDispatch(dispatch => ({
            setMeta: (value) => dispatch('core/editor').editPost({ meta: { 'litci_post_political_author': value } })
        }))
    )(PoliticalAuthorPanel);

    registerPlugin('political-author-sidebar', {
        render: () => createElement(PoliticalAuthorPanelWithData)
    });

})(window.wp);
