(function(wp) {
    const { registerPlugin } = wp.plugins;
    const { PluginDocumentSettingPanel } = wp.editPost;
    const { TextControl } = wp.components;
    const { withSelect, withDispatch } = wp.data;
    const { compose } = wp.compose;
    const { createElement } = wp.element;

    const MenuOrderPanel = ({ menuOrder, setMenuOrder }) => {
        return createElement(
            PluginDocumentSettingPanel,
            {
                name: 'menu-order-panel',
                title: 'Prioridade do post',
                className: 'menu-order-panel'
            },
            createElement(TextControl, {
                label: 'Ordem do Menu',
                type: 'number',
                value: menuOrder,
                onChange: setMenuOrder
            })
        );
    };

    const MenuOrderPanelWithData = compose(
        withSelect((select) => ({
            menuOrder: select('core/editor').getEditedPostAttribute('menu_order')
        })),
        withDispatch((dispatch) => ({
            setMenuOrder: (value) => dispatch('core/editor').editPost({
                menu_order: parseInt(value) || 0
            })
        }))
    )(MenuOrderPanel);

    registerPlugin('menu-order-sidebar', {
        render: function() {
            return createElement(MenuOrderPanelWithData);
        }
    });

})(window.wp);
