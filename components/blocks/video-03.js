(function (blocks, editor, element, components, data) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var CheckboxControl = components.CheckboxControl;

    blocks.registerBlockType('litci/video-03', {
        title: 'LIT-Video 03',
        icon: 'video-alt3',
        category: 'litci-category',
        attributes: {
            blockTitle: {
                type: 'string',
                default: 'Videos',
            },
            selectedChannel: {
                type: 'array',
                default: [],
            },
        },
        edit: function (props) {
            var attributes = props.attributes;
            const { useState, useEffect } = wp.element;
            const [channels, setChannels] = useState([]);
            const [loading, setLoading] = useState(true);
            const [contentList, setContentList] = useState([]);

            var onChangeTitle = function (newTitle) {
                props.setAttributes({ blockTitle: newTitle });
            };

            const onSelectChannel = function (channel) {
                props.setAttributes({ selectedChannel: channel });
            };

            useEffect(() => {
                // Busca os canais
                fetch('https://videos.litci.org/api/channels')
                    .then(resp => resp.json())
                    .then(data => {
                        setChannels(data.data || []);
                        setLoading(false);
                    })
                    .catch(() => setLoading(false)); // Em caso de erro, parar o carregamento
            }, []);

            useEffect(() => {
                if (attributes.selectedChannel.length > 0) {
                    // Para buscar os vídeos dos canais selecionados
                    const fetchVideos = attributes.selectedChannel.map(channelId => 
                        fetch(`https://videos.litci.org/api/videos/channel/${channelId}`)
                            .then(resp => resp.json())
                            .then(data => data.data[0]) // Pegar o primeiro vídeo
                    );

                    Promise.all(fetchVideos).then(videos => {
                        setContentList(videos);
                    });
                }
            }, [attributes.selectedChannel]);

            return el('div', { className: "block-card" },
                el('h3', {}, attributes.blockTitle),
                el('div', {
                    style: { display: 'flex', gap: '24px' }
                },
                    el('div', { style: { display: 'flex', flexBasis: "66%" } },
                        contentList.map((video, index) => 
                            el('div', { key: index, className: 'block02-preview' }, video ? video.title : 'Sem vídeo')
                        ),
                    ),
                    el('div', {
                        style: { display: 'flex', gap: '24px', flexDirection: "column", flexBasis: '33%' }
                    },
                        contentList.slice(1, 3).map((video, index) =>
                            el('div', { key: index, className: 'block02-preview' }, video ? video.title : 'Sem vídeo')
                        )
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
