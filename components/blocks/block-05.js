(function (blocks, editor, element, components) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var CheckboxControl = components.CheckboxControl;
    var withSelect = wp.data.withSelect;

    blocks.registerBlockType('litci/block-05', {
        title: 'LIT-Bloco 5',
        icon: 'align-full-width',
        category: 'common',
        attributes: {
            blockTitle: {
                type: 'string',
                default: 'Bloco 02',
            },
            blockCategories: {
                type: 'array',
                default: [],
            },
        },
        edit: withSelect(function (select) {
            // Busca todas as catgorias
            var categories = select('core').getEntityRecords('taxonomy', 'category',{ per_page: -1 });
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
                    el('fieldset', { className: "category-multi-select-container"},
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
}) (
    window.wp.blocks,
    window.wp.editor,
    window.wp.element,
    window.wp.components
);
