(function (blocks, editor, element, components, data) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var withSelect = wp.data.withSelect;
    var PanelBody = components.PanelBody;
    var CheckboxControl = components.CheckboxControl;
    var SelectControl = components.SelectControl;

    const blockStructure = (videos, videosAmount, columns, blockTitle) => (
        el('div', {},
            el('h3', {}, blockTitle),
            el('div', {
                style: {
                    display: 'grid',
                    gridTemplateColumns: `repeat(${columns}, 1fr)`,
                    width: "100%",
                    gap: '24px'
                }
            },
                videos.slice(0, videosAmount).map(video => (
                    el('div', { className: 'video-item' },
                        el('div', {
                            className: 'video-thumb',
                            style: {
                                backgroundImage: `url('https://i.ytimg.com/vi/${video.video_id}/hqdefault.jpg')`
                            }
                        }),
                        el('div', {className: 'video-info'},
                            el('h3',{ style: {color: '#000'}},video.title)
                        )
                    )
                ))
            )
        )
    );

    blocks.registerBlockType('litci/video-02', {
        title: 'LIT-Video 02',
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
            videoAmount: {
                type: 'number',
                default: 3
            },
            columns: {
                type: 'number',
                default: 3
            }
        },
        edit: function (props) {
            var attributes = props.attributes;
            const { useState, useEffect } = wp.element;
            const [channels, setChannels] = useState([]);
            const [videos, setVideos] = useState([]);
            const [loading, setLoading] = useState(true);

            var onChangeTitle = function (newTitle) {
                props.setAttributes({ blockTitle: newTitle });
            };

            const onSelectChannel = function (channel) {
                props.setAttributes({ selectedChannel: channel });
            };

            const onChangeAmount = function (amount) {
                props.setAttributes({ videoAmount: parseInt(amount, 10) });
            };

            const onChangeColumns = function (amount) {
                props.setAttributes({ columns: parseInt(amount, 10) });
            };

            useEffect(() => {
                fetch('https://videos.litci.org/api/channels')
                    .then(resp => resp.json())
                    .then(data => {
                        setChannels(data.data || []);
                        setLoading(false);
                    })
                    .catch(() => setLoading(false));
            }, []);

            // Fetch para buscar os vídeos
            useEffect(() => {
                setLoading(true);

                if (attributes.selectedChannel.length === 0) {
                    // Se não houver canais selecionados, buscar todos os vídeos
                    fetch('https://videos.litci.org/api/videos')
                        .then(resp => resp.json())
                        .then(data => {
                            setVideos(data.data || []);
                            setLoading(false);
                        })
                        .catch(() => setLoading(false));
                } else {
                    // Se houver canais selecionados, buscar os vídeos de cada canal
                    const fetches = attributes.selectedChannel.map(channelId =>
                        fetch(`https://videos.litci.org/api/videos/channel/${channelId}`)
                            .then(resp => resp.json())
                            .then(data => data.data || [])
                    );

                    Promise.all(fetches)
                        .then(results => {
                            const allVideos = results.flat();
                            setVideos(allVideos);
                            setLoading(false);
                        })
                        .catch(() => setLoading(false));
                }
            }, [attributes.selectedChannel]);

            return el('div', { className: "block-card" },
                blockStructure(videos, attributes.videoAmount, attributes.columns, attributes.blockTitle),
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Geral', initialOpen: true },
                        el(TextControl, {
                            label: 'Título do Bloco',
                            value: attributes.blockTitle,
                            onChange: onChangeTitle
                        }),
                        el(SelectControl, {
                            label: 'Quantidade de vídeos',
                            value: attributes.videoAmount,
                            options: [
                                { label: '3 vídeos', value: 3 },
                                { label: '4 vídeos', value: 4 },
                                { label: '6 vídeos', value: 6 },
                                { label: '8 vídeos', value: 8 },
                                { label: '9 vídeos', value: 9 },
                                { label: '12 vídeos', value: 12 },
                                { label: '15 vídeos', value: 15 },
                                { label: '16 vídeos', value: 16 },
                            ],
                            onChange: onChangeAmount
                        }),
                        el(SelectControl, {
                            label: 'Quantidade de colunas',
                            value: attributes.columns,
                            options: [
                                { label: '2 colunas', value: 2 },
                                { label: '3 colunas', value: 3 },
                                { label: '4 colunas', value: 4 },
                            ],
                            onChange: onChangeColumns
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
            return null;
        },
    });
})(
    window.wp.blocks,
    window.wp.editor,
    window.wp.element,
    window.wp.components,
    window.wp.data
);
