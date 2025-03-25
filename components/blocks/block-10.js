(function (blocks, editor, element, components, data) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var CheckboxControl = components.CheckboxControl;
    var withSelect = wp.data.withSelect;
    var SelectControl = components.SelectControl;
    var useSelect = data.useSelect;
    var useState = element.useState;
    var ComboboxControl = components.ComboboxControl;

    const blockStructure = (posts, columns) => (
        el('div', { className: "block-10", style: { display: "grid", gridTemplateColumns: `repeat(${columns}, 1fr)`, width:"100%" } },
            posts.map(post => (
                el('article', { className: "unit-03" },
                    el('div', { className: "featured-image-container" },
                        el('img', { src: post.fimg_url, style: { width: '100%' } })
                    ),
                    el('div', { className: 'info', style: { fontSize: "0.7em" } },
                        el('h3', { style: { fontSize: "0.7em" } }, post.title.rendered),
                        el('p', { className: 'excerpt' }, post.excerpt.rendered)
                    )
                )
            ))
        )
    )

    const icon = el('img', {src:'../wp-content/themes/litci/components/blocks/icons/block10.svg'})

    blocks.registerBlockType('litci/block-10', {
        title: 'LIT-Bloco 10',
        icon: icon,
        category: 'litci-category',
        attributes: {
            blockTitle: {
                type: 'string',
                default: '',
            },
            blockCategories: {
                type: 'array',
                default: [],
            },
            blockTags: {
                type: 'array',
                default: [],
            },            
            sortOption: {
                type: 'string',
                default: 'recent',
            },
            backgroundColor: {
                type: 'string',
                default: 'white',
            },
            isDark: {
                type: 'boolean',
                default: false,
            },
            customIds: {
                type: 'string',
                default: ''
            },
            postAmount:
            {
                type: 'int',
                default: 4
            },
            columns:
            {
                type: 'int',
                default: 4
            },
            excerpt: {
                type: 'boolean',
                default: false,
            }
        },
        edit: withSelect(function (select) {
            // Busca todas as catgorias
            var categories = select('core').getEntityRecords('taxonomy', 'category', { per_page: -1 });
            var categoryOptions = [];

            var tags = select('core').getEntityRecords('taxonomy', 'post_tag', { per_page: -1 });
            var tagOptions = tags ? tags.map(tag => ({ label: tag.name, value: tag.id })) : [];

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
                tags: tags,
                tagOptions: tagOptions
            };
        })(function (props) {
            var attributes = props.attributes;
            var categoryOptions = props.categoryOptions;
            var [categorySearch, setCategorySearch] = useState('');
            var tagOptions = props.tagOptions

            var filteredCategories = categoryOptions.filter(category =>
                category.label.toLowerCase().includes(categorySearch.toLowerCase())
            );

            var onChangeTitle = function (newTitle) {
                props.setAttributes({ blockTitle: newTitle });
            };

            var onChangeCategories = function (newCategory) {
                props.setAttributes({ blockCategories: newCategory });
            };

            var onChangeSortOption = function (newSortOption) {
                props.setAttributes({ sortOption: newSortOption });
            };

            var onChangeBackgroundColor = function (newColor) {
                var darkColors = ['#666666', '#565656', '#474747', '#323232', '#222222', '#000000'];
                var isDark = darkColors.includes(newColor);
                props.setAttributes({ backgroundColor: newColor, isDark: isDark });
            };

            var onCustomIdsChange = function (newIds) {
                props.setAttributes({ customIds: newIds })
            }
            
            var onChangeAmount = function (amount) {
                props.setAttributes({ postAmount: amount })
            }

            var onChangeColumns = function (amount) {
                props.setAttributes({columns: parseInt(amount)})
            }

            var onChangeExcerpt = function (excerpt) {
                props.setAttributes({excerpt: excerpt})
            }

            // Obtém os posts baseados na opção de ordenação
            var posts = useSelect((select) => {

                // Constrói o objeto de parâmetros para a consulta
                var query = {
                    per_page: attributes.postAmount, // Número de posts a serem exibidos
                    orderby: attributes.customIds.length > 0 ? 'include' : (attributes.sortOption === 'menu_order' ? 'menu_order' : 'date'),
                    order: 'desc',
                };

                // Adiciona filtro de categorias se blockCategories não estiver vazio
                if (attributes.blockCategories.length > 0 && attributes.customIds.length == 0) {
                    query.categories = attributes.blockCategories; // Une os IDs em uma string separada por vírgula
                }

                // Adiciona filtro de tags se blockTags não estiver vazio
                if (attributes.blockTags.length > 0 && attributes.customIds.length == 0) {
                    query.tags = attributes.blockTags; 
                }

                if (attributes.customIds.length > 0) {
                    query.include = attributes.customIds.split(',').map(id => id.trim())
                }

                // Retorna os posts filtrados
                return select('core').getEntityRecords('postType', 'post', query);

            }, [attributes.sortOption, attributes.blockCategories, attributes.customIds, attributes.postAmount, attributes.columns, attributes.excerpt, attributes.blockTags]);

            return el('div', { className: "block-card", style: { backgroundColor: attributes.backgroundColor } },
                el('h3', {}, attributes.blockTitle),
                el('div', { style: { display: 'flex' } },
                    posts && posts.length > 0
                        ? blockStructure(posts, attributes.columns)
                        : el('li', {}, 'Nenhum post encontrado.')
                ),
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Geral', initialOpen: true },
                        el(TextControl, {
                            label: 'Título do Bloco',
                            value: attributes.blockTitle,
                            onChange: onChangeTitle
                        }),
                        el(SelectControl,{
                            label: 'Quantidade de posts',
                            value: attributes.postAmount,
                            options: [
                                {label: '3 posts', value: 3},
                                {label: '4 posts', value: 4},
                                {label: '6 posts', value: 6},
                                {label: '8 posts', value: 8},
                                {label: '9 posts', value: 9},
                                {label: '12 posts', value: 12},
                                {label: '15 posts', value: 15},
                                {label: '16 posts', value: 16},
                            ],
                            onChange: onChangeAmount
                        }),
                        el(SelectControl,{
                            label: 'Quantidade de colunas',
                            value: attributes.columns,
                            options: [
                                {label: '2 colunas', value: 2},
                                {label: '3 colunas', value: 3},
                                {label: '4 colunas', value: 4},
                                {label: '5 colunas', value: 5},
                            ],
                            onChange: onChangeColumns
                        }),
                        el(SelectControl,{
                            label: 'Exibir resumo',
                            value: attributes.excerpt,
                            options: [
                                {label: 'Sim', value: true},
                                {label: 'Não', value: false}
                            ],
                            onChange: onChangeExcerpt
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
                            onChange: onChangeBackgroundColor
                        })
                    ),
                    el(PanelBody, { title: 'Filtro automático', initialOpen: false },
                        el(SelectControl, {
                            label: 'Ordenação',
                            value: attributes.sortOption,
                            options: [
                                { label: 'Mais recentes', value: 'date' },
                                { label: 'Prioritários primeiro', value: 'menu_order' }
                            ],
                            onChange: onChangeSortOption
                        }),
                        el(ComboboxControl, {
                                label: 'Buscar tags',
                                value: '',
                                options: tagOptions.map(tag => ({
                                    label: tag.label,
                                    value: tag.value
                                })),
                                onChange: (newTagId) => {
                                    if (!attributes.blockTags.includes(newTagId)) {
                                        props.setAttributes({ blockTags: [...attributes.blockTags, newTagId] });
                                    }
                                }
                            }),
                            el('div', { className: 'selected-tags' },
                                attributes.blockTags.map(tagId => {
                                    const tag = tagOptions.find(tag => tag.value === tagId);
                                    return tag ? el('span', {
                                        key: tagId,
                                        className: 'category-pill',
                                        style: { padding: '5px 10px', background: '#007cba', color: '#fff', borderRadius: '15px', margin: '3px', display: 'inline-flex', alignItems: 'center' }
                                    },
                                        tag.label,
                                        el('span', {
                                            style: { marginLeft: '8px', cursor: 'pointer' },
                                            onClick: () => {
                                                props.setAttributes({
                                                    blockTags: attributes.blockTags.filter(id => id !== tagId)
                                                });
                                            }
                                        }, ' × ')
                                    ) : null;
                                })
                            ),                       
                        el(TextControl, {
                            label: 'Buscar categoria',
                            value: categorySearch,
                            onChange: setCategorySearch,
                            placeholder: 'Digite para filtrar...',
                        }),
                        
                        el('fieldset', { className: "category-multi-select-container" },
                            el('legend', {}, 'Categorias do Bloco'),
                            filteredCategories.map(function (option) {
                                return el(CheckboxControl, {
                                    key: option.value,
                                    label: option.label,
                                    checked: attributes.blockCategories.includes(option.value),
                                    onChange: function (checked) {
                                        var newCategories = attributes.blockCategories.slice();
                                        if (checked) {
                                            newCategories.push(option.value);
                                        } else {
                                            newCategories = newCategories.filter(function (category) {
                                                return category !== option.value;
                                            });
                                        }
                                        onChangeCategories(newCategories);
                                    }
                                });
                            })
                        )
                    ),
                    el(PanelBody, { title: "Filtro manual", initialOpen: false },
                        el(TextControl, {
                            label: 'IDs dos posts',
                            value: attributes.customIds,
                            onChange: onCustomIdsChange
                        })
                    ),
                )
            );
        }),
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
