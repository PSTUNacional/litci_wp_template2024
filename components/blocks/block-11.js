(function (blocks, editor, element, components, data) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var CheckboxControl = components.CheckboxControl;
    var withSelect = wp.data.withSelect;
    var SelectControl = components.SelectControl;
    var useSelect = data.useSelect;

    const blockStructure = (posts) => (
        el('div', {},
            el('div', { className: "block-06 main" },
                posts.slice(0, 2).map(post => (
                    el('div', { className: "unit-03" },
                        el('div', { className: "featured-image-container" },
                            el('img', { src: post.fimg_url, style: { width: '100%' } })
                        ),
                        el('div', { className: 'info', style: { fontSize: "0.7em" } },
                            el('h3', { style: {} }, post.title.rendered),
                            el('p', { className: 'excerpt' }, post.excerpt.rendered)
                        )
                    )
                ))
            ),
            el('div', { className: "block-06 minor", style: { gridTemplateColumns: "repeat(auto-fit, minmax(160px, 1fr))" } },
                posts.slice(2, 6).map(post =>
                (el('article', { className: "unit-04" },
                    el('div', { className: "column" },
                        el('div', { className: "featured-image-container" },
                            el('img', { src: post.fimg_url, style: { width: '100%' } })
                        ),
                    ),
                    el('div', { className: "column" },
                        el('h4', { style: {} }, post.title.rendered)
                    )
                ))
                )
            ),
        )
    )

    const icon = el('img', {src:'./icons/block06.svg'})

    blocks.registerBlockType('litci/block-11', {
        title: 'LIT-Bloco 11',
        icon: icon,
        category: 'litci-category',
        supports: {
            align: ['wide', 'full'],
        },
        attributes: {
            blockTitleOne: {
                type: 'string',
                default: '',
            },
            blockCategoriesOne: {
                type: 'array',
                default: [],
            },
            sortOptionOne: {
                type: 'string',
                default: 'recent',
            },
            customIdsOne: {
                type: 'string',
                default: ''
            },
            blockTitleTwo: {
                type: 'string',
                default: '',
            },
            blockCategoriesTwo: {
                type: 'array',
                default: [],
            },
            sortOptionTwo: {
                type: 'string',
                default: 'recent',
            },
            customIdsTwo: {
                type: 'string',
                default: ''
            },
            backgroundColor: {
                type: 'string',
                default: 'white',
            },
            isDark: {
                type: 'boolean',
                default: false,
            },

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

            // Block 01
            var onChangeTitleOne = function (newTitle) {
                props.setAttributes({ blockTitleOne: newTitle });
            };

            var onChangeCategoriesOne = function (newCategory) {
                props.setAttributes({ blockCategoriesOne: newCategory });
            };

            var onChangeSortOptionOne = function (newSortOption) {
                props.setAttributes({ sortOptionOne: newSortOption });
            };

            var onCustomIdsOneChange = function (newIds) {
                props.setAttributes({ customIdsOne: newIds })
            };

            // Block02
            var onChangeTitleTwo = function (newTitle) {
                props.setAttributes({ blockTitleTwo: newTitle });
            };

            var onChangeCategoriesTwo = function (newCategory) {
                props.setAttributes({ blockCategoriesTwo: newCategory });
            };

            var onChangeSortOptionTwo = function (newSortOption) {
                props.setAttributes({ sortOptionTwo: newSortOption });
            };

            var onCustomIdsTwoChange = function (newIds) {
                props.setAttributes({ customIdsTwo: newIds })
            }


            var onChangeBackgroundColor = function (newColor) {
                var darkColors = ['#666666', '#565656', '#474747', '#323232', '#222222', '#000000'];
                var isDark = darkColors.includes(newColor);
                props.setAttributes({ backgroundColor: newColor, isDark: isDark });
            };

            // Obtém os posts baseados na opção de ordenação
            var posts = useSelect((select) => {

                // Constrói o objeto de parâmetros para a consulta
                var query = {
                    per_page: 6, // Número de posts a serem exibidos
                    orderby: attributes.customIdsOne.length > 0 ? 'include' : (attributes.sortOptionOne === 'menu_order' ? 'menu_order' : 'date'),
                    order: 'desc',
                };

                // Adiciona filtro de categorias se blockCategories não estiver vazio
                if (attributes.blockCategoriesOne.length > 0 && attributes.customIdsOne.length == 0) {
                    query.categories = attributes.blockCategoriesOne.join(','); // Une os IDs em uma string separada por vírgula
                }

                if (attributes.customIdsOne.length > 0) {
                    query.include = attributes.customIdsOne

                }

                // Retorna os posts filtrados
                return select('core').getEntityRecords('postType', 'post', query);

            }, [attributes.sortOptionOne, attributes.blockCategoriesOne, attributes.customIdsOne,attributes.sortOptionTwo, attributes.blockCategoriesTwo, attributes.customIdsTwo]);

            return el('div', { className: "block-card", style: { backgroundColor: attributes.backgroundColor } },
                el('h3', {}, attributes.blockTitleOne),
                el('div', { style: { display: 'flex' } },
                    posts && posts.length > 0
                        ? blockStructure(posts)
                        : el('li', {}, 'Nenhum post encontrado.')
                ),
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Coluna Esq', initialOpen: true },
                        el(PanelBody, { title: 'Geral', initialOpen: true },
                            el(TextControl, {
                                label: 'Título do Bloco',
                                value: attributes.blockTitleOne,
                                onChange: onChangeTitleOne
                            })
                        ),
                        el(PanelBody, { title: 'Filtro automático', initialOpen: false },
                            el(SelectControl, {
                                label: 'Ordenação',
                                value: attributes.sortOptionOne,
                                options: [
                                    { label: 'Mais recentes', value: 'date' },
                                    { label: 'Prioritários primeiro', value: 'menu_order' }
                                ],
                                onChange: onChangeSortOptionOne
                            }),
                            el('fieldset', { className: "category-multi-select-container" },
                                el('legend', {}, 'Categorias do Bloco'),
                                categoryOptions.map(function (option) {
                                    return el(CheckboxControl, {
                                        key: option.value,
                                        label: option.label,
                                        checked: attributes.blockCategoriesOne.includes(option.value),
                                        onChange: function (checked) {
                                            var newCategories = attributes.blockCategoriesOne.slice();
                                            if (checked) {
                                                newCategories.push(option.value);
                                            } else {
                                                newCategories = newCategories.filter(function (category) {
                                                    return category !== option.value;
                                                });
                                            }
                                            onChangeCategoriesOne(newCategories);
                                        }
                                    });
                                })
                            )
                        ),
                        el(PanelBody, { title: "Filtro manual", initialOpen: false },
                            el(TextControl, {
                                label: 'IDs dos posts',
                                value: attributes.customIdsOne,
                                onChange: onCustomIdsOneChange
                            })
                        ),
                    ),
                    el(PanelBody, { title: 'Coluna Dir', initialOpen: true },
                        el(PanelBody, { title: 'Geral', initialOpen: true },
                            el(TextControl, {
                                label: 'Título do Bloco',
                                value: attributes.blockTitleTwo,
                                onChange: onChangeTitleTwo
                            })
                        ),
                        el(PanelBody, { title: 'Filtro automático', initialOpen: false },
                            el(SelectControl, {
                                label: 'Ordenação',
                                value: attributes.sortOptionTwo,
                                options: [
                                    { label: 'Mais recentes', value: 'date' },
                                    { label: 'Prioritários primeiro', value: 'menu_order' }
                                ],
                                onChange: onChangeSortOptionTwo
                            }),
                            el('fieldset', { className: "category-multi-select-container" },
                                el('legend', {}, 'Categorias do Bloco'),
                                categoryOptions.map(function (option) {
                                    return el(CheckboxControl, {
                                        key: option.value,
                                        label: option.label,
                                        checked: attributes.blockCategoriesTwo.includes(option.value),
                                        onChange: function (checked) {
                                            var newCategories = attributes.blockCategoriesTwo.slice();
                                            if (checked) {
                                                newCategories.push(option.value);
                                            } else {
                                                newCategories = newCategories.filter(function (category) {
                                                    return category !== option.value;
                                                });
                                            }
                                            onChangeCategoriesTwo(newCategories);
                                        }
                                    });
                                })
                            )
                        ),
                        el(PanelBody, { title: "Filtro manual", initialOpen: false },
                            el(TextControl, {
                                label: 'IDs dos posts',
                                value: attributes.customIdsTwo,
                                onChange: onCustomIdsTwoChange
                            })
                        ),
                    ),
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
