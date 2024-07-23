(function (blocks, editor, element, components) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var CheckboxControl = components.CheckboxControl;
    var SelectControl = components.SelectControl;
    var withSelect = wp.data.withSelect;

    // Adiciona a nova categoria
    blocks.updateCategory('litci-category', {
        title: 'LIT-CI Blocks',
        icon: 'admin-customizer',
        slug: 'litci-category',
    });

    blocks.registerBlockType('litci/block-05', {
        title: 'LIT-Bloco 5',
        icon: 'align-full-width',
        category: 'litci-category',
        attributes: {
            blockTitle: {
                type: 'string',
                default: 'Bloco 05',
            },
            blockCategories: {
                type: 'array',
                default: [],
            },
            sortOption: { // Novo atributo para a opção de ordenação
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
                var darkColors = ['#666666', '#565656', '#474747', '#323232', '#222222'];
                var isDark = darkColors.includes(newColor);
                props.setAttributes({ backgroundColor: newColor, isDark: isDark });
            };

            return el('div', { className: "block-card" },
                el('h3', {}, attributes.blockTitle),
                el('div', {
                    style: { display: 'flex', gap: '24px' }
                },
                    el('div', { className: 'block02-preview' }),
                    el('div', { className: 'block02-preview' }),
                    el('div', { className: 'block02-preview' }),
                    el('div', { className: 'block02-preview' }),
                ),
                el(InspectorControls, {},
                    el(TextControl, {
                        className: "block-editor-block-card",
                        label: 'Título do Bloco',
                        value: attributes.blockTitle,
                        onChange: onChangeTitle
                    }),
                    el(SelectControl, {
                        className: "block-editor-block-card",
                        label: 'Opção de Ordenação',
                        value: attributes.sortOption,
                        options: [
                            { label: 'Mais recentes', value: 'publish_date' },
                            { label: 'Prioritários primeiro', value: 'menu_order' }
                        ],
                        onChange: onChangeSortOption
                    }),
                    el(SelectControl, {
                        className: "block-editor-block-card",
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
                        ],
                        onChange: onChangeBackgroundColor
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
    window.wp.components
);
