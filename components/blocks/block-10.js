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
        el('div', { className: "block-10", style: { gridTemplateColumns: "repeat(auto-fit, minmax(128px, 1fr))", width:"100%" } },
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

    const icon = el('img', {src:'./icons/block10.svg'})

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
                default: 3
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
                    query.categories = attributes.blockCategories.join(','); // Une os IDs em uma string separada por vírgula
                }

                if (attributes.customIds.length > 0) {
                    query.include = attributes.customIds

                }

                // Retorna os posts filtrados
                return select('core').getEntityRecords('postType', 'post', query);

            }, [attributes.sortOption, attributes.blockCategories, attributes.customIds, attributes.postAmount]);

            return el('div', { className: "block-card", style: { backgroundColor: attributes.backgroundColor } },
                el('h3', {}, attributes.blockTitle),
                el('div', { style: { display: 'flex' } },
                    posts && posts.length > 0
                        ? blockStructure(posts)
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
                            ],
                            onChange: onChangeAmount
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
                        el('fieldset', { className: "category-multi-select-container" },
                            el('legend', {}, 'Categorias do Bloco'),
                            categoryOptions.map(function (option) {
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
