//import TagsFilter from "./components/TagsFilter";

(function (blocks, editor, element, components, data) {
    var el = element.createElement;
    var TextControl = components.TextControl;
    var InspectorControls = editor.InspectorControls;
    var PanelBody = components.PanelBody;
    var CheckboxControl = components.CheckboxControl;
    var withSelect = wp.data.withSelect;
    var SelectControl = components.SelectControl;
    var useSelect = data.useSelect;
    var ComboboxControl = components.ComboboxControl;

/*=============================
*
*  Block Structure
*
=============================*/

const blockStructure = (posts) => (
    posts.map(post =>
        el('article', { className: "unit-02", style: { fontSize: "0.7rem", gap: "0px" } },
            el('div', { className: "featured-image-container" },
                el('img', { src: post.fimg_url })
            ),
            el('h3', {}, post.title.rendered),
            el('p', {}, post.excerpt.rendered)
        )
    )
)

/*=============================
*
*   Elements
*
=============================*/

/***
 *  Tags Filter
 */

const TagsFilter = ({ blockTags, setAttributes, tagOptions }) => {
    const onRemoveTag = (tagIdToRemove) => {
        const updatedTags = blockTags.filter(id => id !== tagIdToRemove);
        setAttributes({ blockTags: updatedTags });
    };

    return el('div', { className: 'tags-filter' },
        el(ComboboxControl, {
            label: 'Buscar tags',
            value: '',
            options: tagOptions.map(tag => ({
                label: tag.label,
                value: tag.value
            })),
            onChange: (newTagId) => {
                if (!blockTags.includes(newTagId)) {
                    setAttributes({ blockTags: [...blockTags, newTagId] });
                }
            }
        }),
        el('div', { className: 'selected-tags' },
            blockTags.map(tagId => {
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
                            setAttributes({
                                blockTags: blockTags.filter(id => id !== tagId)
                            });
                        }
                    }, ' × ')
                ) : null;
            })
        ),  
    );
};


    const icon = el('img', {src:'../wp-content/themes/litci/components/blocks/icons/block02.svg'})

    blocks.registerBlockType('litci/block-02', {
        title: 'LIT-Bloco 2',
        icon: icon,
        category: 'litci-category',
        attributes: {
            blockTitle: { type: 'string', default: 'Bloco 02' },
            blockCategories: { type: 'array', default: [] },
            blockTags: { type: 'array', default: [] },
            sortOption: { type: 'string', default: 'recent' },
            backgroundColor: { type: 'string', default: 'white' },
            isDark: { type: 'boolean', default: false },
            customIds: { type: 'string', default: '' }
        },
        edit: withSelect(function (select) {

            // Busca categorias
            var categories = select('core').getEntityRecords('taxonomy', 'category', { per_page: -1 });
            var categoryOptions = categories ? categories.map(category => ({ label: category.name, value: category.id })) : [];


            if (categories) {
                categoryOptions = categories.map(function (category) {
                    return {
                        label: category.name,
                        value: category.id,
                    };
                });
            }

            // Busca tags
            var tags = select('core').getEntityRecords('taxonomy', 'post_tag', { per_page: -1 });
            var tagOptions = tags ? tags.map(tag => ({ label: tag.name, value: tag.id })) : [];

            return {
                categories: categories,
                categoryOptions: categoryOptions,
                tags: tags,
                tagOptions: tagOptions,
            };
        })(function (props) {
            var attributes = props.attributes;
            var categoryOptions = props.categoryOptions;
            var tagOptions = props.tagOptions

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

            // Obtém os posts baseados na opção de ordenação
            var posts = useSelect((select) => {

                // Constrói o objeto de parâmetros para a consulta
                var query = {
                    per_page: 4, // Número de posts a serem exibidos
                    orderby: attributes.customIds.length > 0 ? 'include' : (attributes.sortOption === 'menu_order' ? 'menu_order' : 'date'),
                    order: 'desc',
                };

                // Adiciona filtro de categorias se blockCategories não estiver vazio
                if (attributes.blockCategories.length > 0 && attributes.customIds.length == 0) {
                    query.categories = attributes.blockCategories.join(','); // Une os IDs em uma string separada por vírgula
                }

                if (attributes.blockTags.length > 0) {
                    query.tags = attributes.blockTags.join(','); // Incluindo tags na consulta
                }

                if (attributes.customIds.length > 0) {
                    query.include = attributes.customIds.split(',').map(id => id.trim())

                }

                // Retorna os posts filtrados
                return select('core').getEntityRecords('postType', 'post', query);

            }, [attributes.sortOption, attributes.blockCategories, attributes.customIds, attributes.blockTags]);

            return el('div', { className: "block-card", style: { backgroundColor: attributes.backgroundColor } },
                el('h3', {}, attributes.blockTitle),
                el('div', {
                    style: { display: 'flex', gap: '24px' }
                },
                    posts && posts.length > 0
                        ? blockStructure(posts)
                        : el('li', {}, "Nenhum post encontrado.")
                ),
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Geral', initialOpen: true },
                        el(TextControl, {
                            label: 'Título do Bloco',
                            value: attributes.blockTitle,
                            onChange: onChangeTitle
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
                        el(TagsFilter, {
                            blockTags: attributes.blockTags,
                            setAttributes: props.setAttributes,
                            tagOptions: tagOptions,
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