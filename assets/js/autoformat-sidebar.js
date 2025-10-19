(function (wp) {
    const { registerPlugin } = wp.plugins;
    const { PluginDocumentSettingPanel } = wp.editPost;
    const { Button } = wp.components;
    const { withSelect, withDispatch } = wp.data;
    const { compose } = wp.compose;
    const { createElement } = wp.element;
    const { apiFetch } = wp;
    const { rawHandler, parse } = wp.blocks;


    const AutoformatSidebar = ({ content, editPost }) => {



        const handleClick = async () => {
            if (!content) return; // conteúdo atual do post

            // Mostra modal de carregamento
            Swal.fire({
                title: 'Enviando para OpenAI...',
                text: 'Aguarde enquanto processamos seu conteúdo.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            })

            // Monta o payload para a API
            const payload = {
                model: "gpt-4o-mini",
                messages: [
                    {
                        role: "system",
                        content: "Você é um assistente que formata textos em HTML para WordPress. Use <p> para parágrafos e <h3> para intertítulos."
                    },
                    {
                        role: "user",
                        content: content
                    }
                ],
                temperature: 0.3
            };

            try {

                const data = await apiFetch({
                    path: '/autoformater/v1/openai', // Caminho limpo da API
                    method: 'POST',
                    data: payload // apiFetch usa 'data' para body
                });

                // O texto HTML formatado vem em:
                const formattedHtml = data.choices[0].message.content;

                // Insere no Gutenberg
                const cleanHtml = formattedHtml.replace(/```html|```/g, "").trim();
                const newBlocks = rawHandler({ HTML: cleanHtml });
                const serializedBlocks = wp.blocks.serialize(newBlocks);
                wp.data.dispatch('core/editor').editPost({
                    content: serializedBlocks
                });

                // Fecha o loading e mostra sucesso
                Swal.fire({
                    icon: 'success',
                    title: 'Pronto!',
                    text: 'Conteúdo atualizado com HTML formatado.'
                });
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Falha ao processar o texto com OpenAI.'
                });
            }
        };


        return createElement(
            PluginDocumentSettingPanel,
            { name: 'autoformat-panel', title: 'Autoformatar' },
            createElement(
                Button,
                { isPrimary: true, onClick: handleClick },
                'Autoformatar'
            )
        );
    };

    const AutoformatSidebarWithData = compose(
        withSelect(select => ({ content: select('core/editor').getCurrentPost().content })),
        withDispatch(dispatch => ({ editPost: dispatch('core/editor').editPost }))
    )(AutoformatSidebar);

    registerPlugin('autoformat-sidebar', {
        render: () => createElement(AutoformatSidebarWithData)
    });
})(window.wp);
