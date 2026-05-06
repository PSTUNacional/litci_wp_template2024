(function (blocks, editor, element, components) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;
    var InspectorControls = editor.InspectorControls;
    var MediaUpload = editor.MediaUpload;
    var Button = components.Button;
    var PanelBody = components.PanelBody;

    const icon = el('img', {src:'../wp-content/themes/litci/components/blocks/icons/block01.svg'})

    blocks.registerBlockType('litci/ad-01', {
        title: 'LIT-Banner Ads 1',
        icon: icon,
        category: 'litci-category', 
        attributes: {
            backgroundColor: {
                type: 'string',
                default: 'white',
            },
            isDark: {
                type: 'boolean',
                default: false,
            },
            backgroundImage: {
                type: 'string',
                default: null,
            },
            backgroundImageMobile: {
                type: 'string',
                default: null,
            },
            link: {
                type: 'string',
                default: '',
            }
        },
        
        edit: function (props) {
            var attributes = props.attributes;

            var onSelectImage = function (media) {
                props.setAttributes({ backgroundImage: media.url });
            };

            var onSelectImageMobile = function (media) {
                props.setAttributes({ backgroundImageMobile: media.url });
            };

            var onChangeLink = function (newLink) {
                props.setAttributes({ link: newLink });
            };

            var onChangeBackgroundColor = function (newColor) {
                var darkColors = ['#666666', '#565656', '#474747', '#323232', '#222222', '#000000'];
                var isDark = darkColors.includes(newColor);
                props.setAttributes({ backgroundColor: newColor, isDark: isDark });
            };

            // Helper: renderiza um campo de imagem com título, preview e botão
            var renderImageField = function (title, currentImage, onSelect) {
                return el('div', { className: 'litci-image-field' },
                    el('p', { className: 'litci-image-field__title' }, title),
                    currentImage && el('div', { className: 'litci-image-field__preview' },
                        el('img', { src: currentImage })
                    ),
                    el(MediaUpload, {
                        onSelect: onSelect,
                        allowedTypes: ['image'],
                        render: function (obj) {
                            return el(Button, {
                                className: 'litci-image-field__button',
                                variant: currentImage ? 'secondary' : 'primary',
                                onClick: obj.open
                            }, !currentImage ? 'Selecionar imagem' : 'Alterar imagem');
                        }
                    })
                );
            };

            var previewSrc = attributes.backgroundImage || attributes.backgroundImageMobile;

            return el('div', { className: "block-card", style:{}},
                previewSrc 
                    ? el('img', { src: previewSrc, style: { width: '100%' } }) 
                    : el('div', {}, 'Nenhuma imagem selecionada'),
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Imagens do banner', initialOpen: true },
                        renderImageField(
                            'Imagem desktop',
                            attributes.backgroundImage,
                            onSelectImage
                        ),
                        renderImageField(
                            'Imagem mobile',
                            attributes.backgroundImageMobile,
                            onSelectImageMobile
                        )
                    ),
                    el(PanelBody, { title: 'Configurações', initialOpen: true },
                        el(TextControl, {
                            label: 'Link',
                            value: attributes.link,
                            onChange: onChangeLink
                        }),
                        el(SelectControl, {
                            label: 'Cor de fundo',
                            value: attributes.backgroundColor,
                            options: [
                                { label: 'White', value: '#ffffff' },
                                { label: 'Gray 50', value: '#f8f8f8' },
                                { label: 'Gray 100', value: '#eaeaea' },
                                { label: 'Gray 200', value: '#d8d8d8' },
                                { label: 'Gray 300', value: '#bababa' },
                                { label: 'Gray 400', value: '#aaaaaa' },
                                { label: 'Gray 500', value: '#9b9b9b' },
                                { label: 'Gray 600', value: '#666666' },
                                { label: 'Gray 700', value: '#565656' },
                                { label: 'Gray 800', value: '#474747' },
                                { label: 'Gray 900', value: '#323232' },
                                { label: 'Gray 950', value: '#222222' },
                            ],
                            onChange: onChangeBackgroundColor
                        })
                    )
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
    window.wp.components
);