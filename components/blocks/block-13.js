(function (blocks, editor, element, components, data) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var CheckboxControl = components.CheckboxControl;
    var withSelect = wp.data.withSelect;
    var SelectControl = components.SelectControl;
    var useSelect = data.useSelect;

    const blockStructure = (postsLeft, postsRight) => {
        if (!Array.isArray(postsLeft) || postsLeft.length === 0) {
            return el('div', { className: 'block-13-empty' }, 'Nenhum post disponível na coluna esquerda.');
        }

        if (!Array.isArray(postsRight)) {
            postsRight = []; // fallback para evitar erro no .slice()
        }

        return el('div', { className: "block-13" },
            el('div', { className: "column" },
                el('article', { className: "unit-07" },
                    el('div', { className: "column" },
                        el('h2', { style: { fontSize: "2em" } }, postsLeft[0].title.rendered),
                        el('div', { className: 'grid' },
                            el('div', { className: "featured-image-container" },
                                el('img', { src: postsLeft[0].fimg_url, style: { width: "100%" } })
                            ),
                            el('p', { className: "excerpt", style: { fontSize: "0.7em" } }, postsLeft[0].excerpt.rendered)
                        )
                    )
                ),
                el('div', { className: "post-grid" },
                    postsLeft.slice(1, 4).map(post => (
                        el('div', { className: "unit-05" },
                            el('div', { className: "featured-image-container" },
                                el('img', { src: post.fimg_url, style: { width: '100%' } })
                            ),
                            el('div', { className: 'info' },
                                el('h3', { style: { fontSize: "0.6em" } }, post.title.rendered),
                            )
                        )
                    ))
                )
            ),
            el('div', { className: "separator" }),
            el('div', { className: "column" },
                el('div', { className: "video-story-container" },
                    el('div', { className: "video-story" }),
                    el('div', { className: "video-story" }),
                ),
                el('div', { className: "post-grid" },
                    postsRight.slice(0, 3).map(post => (
                        el('div', { className: "unit-05" },
                            el('div', { className: "featured-image-container" },
                                el('img', { src: post.fimg_url, style: { width: '100%' } })
                            ),
                            el('div', { className: 'info' },
                                el('h3', { style: { fontSize: "0.6em" } }, post.title.rendered),
                            )
                        )
                    ))
                )
            )
        );
    };


    const icon = el('img', { src: '../wp-content/themes/litci/components/blocks/icons/block08.svg' })

    blocks.registerBlockType('litci/block-13', {
        title: 'LIT-Bloco 13',
        icon: icon,
        category: 'litci-category',
        attributes: {
            blockTitle: {
                type: 'string',
                default: '',
            },
            columnLeft: {
                type: 'object',
                default: {
                    blockCategories: [],
                    sortOption: 'recent',
                    customIds: ''
                }
            },
            columnRight: {
                type: 'object',
                default: {
                    videosList: '',
                    blockCategories: [],
                    sortOption: 'recent',
                    customIds: ''
                }
            },
            backgroundColor: {
                type: 'string',
                default: 'white',
            },
            isDark: {
                type: 'boolean',
                default: false,
            },
            videosList: {
                type: 'string',
                default: ''
            }
        },
        edit: withSelect(function (select) {
            // Busca todas as catgorias
            var categories = select('core').getEntityRecords('taxonomy', 'category', { per_page: -1 });
            var categoryOptions = [];

            if (categories) {
                categoryOptions = categories.map(function (category) {
                    return {
                        label: category.name,
                        value: category.id,
                    };
                });
            }

            return {
                categories: categories,
                categoryOptions: categoryOptions,
            };
        })(function (props) {

            var attributes = props.attributes;
            var categoryOptions = props.categoryOptions;

            const onChange = (attribute, value) => {
                let updatedAttributes = { [attribute]: value };

                // Checa se o atributo é 'backgroundColor' e atualiza 'isDark' se necessário
                if (attribute === 'backgroundColor') {
                    const darkColors = ['#666666', '#565656', '#474747', '#323232', '#222222', '#000000'];
                    const isDark = darkColors.includes(value);
                    updatedAttributes = { ...updatedAttributes, isDark };
                }

                props.setAttributes(updatedAttributes);
            }


            function getPosts(attributesPart) {
                const query = {
                    per_page: 4,
                    orderby: attributesPart.customIds?.length > 0
                        ? 'include'
                        : (attributesPart.sortOption === 'menu_order' ? 'menu_order' : 'date'),
                    order: 'desc',
                };

                if (Array.isArray(attributesPart.blockCategories) && attributesPart.blockCategories.length > 0 && attributesPart.customIds.length === 0) {
                    query.categories = attributesPart.blockCategories.join(',');
                }

                if (attributesPart.customIds?.length > 0) {
                    query.include = attributesPart.customIds.split(',').map(id => id.trim());
                }

                return query;
            }

            const postsLeft = useSelect((select) =>
                select('core').getEntityRecords('postType', 'post', getPosts(attributes.columnLeft)),
                [attributes.columnLeft.sortOption, attributes.columnLeft.blockCategories, attributes.columnLeft.customIds]
            );

            const postsRight = useSelect((select) =>
                select('core').getEntityRecords('postType', 'post', getPosts(attributes.columnRight)),
                [attributes.columnRight.sortOption, attributes.columnRight.blockCategories, attributes.columnRight.customIds]
            );

            return el('div', { className: "block-card", style: { backgroundColor: attributes.backgroundColor } },
                el('h3', {}, attributes.blockTitle),
                el('div', { style: { display: 'flex' } },
                    postsLeft && postsLeft.length > 0
                        ? blockStructure(postsLeft, postsRight)
                        : el('li', {}, 'Nenhum post encontrado.')
                ),
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Geral', initialOpen: true },
                        el(TextControl, {
                            label: 'Título do Bloco',
                            value: attributes.blockTitle,
                            onChange: (value) => onChange('blockTitle', value)
                        }),
                        el(SelectControl, {
                            label: 'Cor de Fundo',
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
                                { label: 'Black', value: '#000000' },
                            ],
                            onChange: (value) => onChange('backgroundColor', value)
                        })
                    ),
                    el(PanelBody, { title: 'Coluna Esquerda', initialOpen: false },
                        el(PanelBody, { title: 'Filtro automático', initialOpen: false },
                            el(SelectControl, {
                                label: 'Ordenação',
                                value: attributes.columnLeft.sortOption,
                                options: [
                                    { label: 'Mais recentes', value: 'date' },
                                    { label: 'Prioritários primeiro', value: 'menu_order' }
                                ],
                                onChange: (value) => onChange('columnLeft', {
                                    ...attributes.columnLeft,
                                    sortOption: value
                                })
                            }),
                            el('fieldset', { className: "category-multi-select-container" },
                                el('legend', {}, 'Categorias do Bloco'),
                                categoryOptions.map(function (option) {
                                    return el(CheckboxControl, {
                                        key: option.value,
                                        label: option.label,
                                        checked: attributes.columnLeft.blockCategories.includes(option.value),
                                        onChange: function (checked) {
                                            var newCategories = attributes.columnLeft.blockCategories.slice();
                                            if (checked) {
                                                newCategories.push(option.value);
                                            } else {
                                                newCategories = newCategories.filter(function (category) {
                                                    return category !== option.value;
                                                });
                                            }
                                            onChange('columnLeft', {
                                                ...attributes.columnLeft,
                                                blockCategories: newCategories
                                            });
                                        }
                                    });
                                })
                            )
                        ),
                        el(PanelBody, { title: "Filtro manual", initialOpen: false },
                            el(TextControl, {
                                label: 'IDs dos posts',
                                value: attributes.columnLeft.customIds,
                                onChange: (value) => onChange('columnLeft', {
                                    ...attributes.columnLeft,
                                    customIds: value
                                })
                            })
                        )
                    ),
                    el(PanelBody, { title: 'Coluna Direita', initialOpen: false },
                        el(PanelBody, { title: "Videos", initialOpen: false },
                            el(TextControl, {
                                label: 'IDs dos vídeos no YouTube',
                                value: attributes.columnRight.videosList,
                                onChange: (value) => onChange('columnRight', {
                                    ...attributes.columnRight,
                                    videosList: value
                                })
                            })
                        ),
                        el(PanelBody, { title: 'Filtro automático', initialOpen: false },
                            el(SelectControl, {
                                label: 'Ordenação',
                                value: attributes.columnRight.sortOption,
                                options: [
                                    { label: 'Mais recentes', value: 'date' },
                                    { label: 'Prioritários primeiro', value: 'menu_order' }
                                ],
                                onChange: (value) => onChange('columnRight', {
                                    ...attributes.columnRight,
                                    sortOption: value
                                })
                            }),
                            el('fieldset', { className: "category-multi-select-container" },
                                el('legend', {}, 'Categorias do Bloco'),
                                categoryOptions.map(function (option) {
                                    return el(CheckboxControl, {
                                        key: option.value,
                                        label: option.label,
                                        checked: attributes.columnRight.blockCategories.includes(option.value),
                                        onChange: function (checked) {
                                            var newCategories = attributes.columnRight.blockCategories.slice();
                                            if (checked) {
                                                newCategories.push(option.value);
                                            } else {
                                                newCategories = newCategories.filter(function (category) {
                                                    return category !== option.value;
                                                });
                                            }
                                            onChange('columnRight', {
                                                ...attributes.columnRight,
                                                blockCategories: newCategories
                                            });
                                        }
                                    });
                                })
                            )
                        ),
                        el(PanelBody, { title: "Filtro manual", initialOpen: false },
                            el(TextControl, {
                                label: 'IDs dos posts',
                                value: attributes.columnRight.customIds,
                                onChange: (value) => onChange('columnRight.customIds', value)
                            })
                        )
                    ),
                ),
            );
        }),
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
