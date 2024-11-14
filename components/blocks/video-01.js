(function (blocks, editor, element, components, data) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var withSelect = wp.data.withSelect;
    var PanelBody = components.PanelBody;
    var CheckboxControl = components.CheckboxControl;

    const channels = fetch('https://videos.litci.org/api/channels')
    .then(resp=>resp.json())
    .then(data=>{
        return data.data
    })
    
    blocks.registerBlockType('litci/video-01', {
        title: 'LIT-Video 01',
        icon: 'video-alt3',
        category: 'litci-category',
        attributes: {
            blockTitle: {
                type: 'string',
                default: 'Videos',
            },
            selectedChannel:{
                type: 'array',
                default: [],    
            }
        },
        edit: function (props) {
            var attributes = props.attributes;
            const { useState, useEffect } = wp.element;
            const [channels, setChannels] = useState([]);
            const [loading, setLoading] = useState(true);
            
            var onChangeTitle = function (newTitle) {
                props.setAttributes({ blockTitle: newTitle });
            };

            const onSelectChannel = function (channel) {
                props.setAttributes({ selectedChannel: channel });
            };

            useEffect(() => {
                // Fazer a chamada à API
                fetch('https://videos.litci.org/api/channels')
                    .then(resp => resp.json())
                    .then(data => {
                        setChannels(data.data || []);
                        setLoading(false);
                    })
                    .catch(() => setLoading(false)); // Em caso de erro, parar o carregamento
            }, []);

            return el('div', { className: "block-card" },
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
                    el(PanelBody, { title: 'Geral', initialOpen: true },
                        el(TextControl, {
                            label: 'Título do Bloco',
                            value: attributes.blockTitle,
                            onChange: onChangeTitle
                        }),
                    ),
                    el(PanelBody, { title: 'Canais', initialOpen: false },
                        el('fieldset', { className: "category-multi-select-container" },
                            el('legend', {}, 'Canais'),
                            loading ? el('p', {}, 'Carregando canais...') : channels.map((channel) => {
                                return el(CheckboxControl, {
                                    key: channel.channel_id,
                                    label: channel.name,
                                    checked: attributes.selectedChannel.includes(channel.channel_id),
                                    onChange: (checked) => {
                                        let newChannel = [...attributes.selectedChannel];
                                        if (checked) {
                                            newChannel.push(channel.channel_id);
                                        } else {
                                            newChannel = newChannel.filter(id => id !== channel.channel_id);
                                        }
                                        onSelectChannel(newChannel);
                                    }
                                });
                            })
                        )
                    ),
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
    window.wp.components,
    window.wp.data
);
