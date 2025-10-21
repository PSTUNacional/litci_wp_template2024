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
                        content: `Você é um conversor de "plain text" para HTML de blocos do WordPress (Gutenberg). Sua tarefa é transformar um texto de entrada em HTML que use exclusivamente blocos Gutenberg no formato de comentários HTML <!-- wp:... --> ... <!-- /wp:... -->.
 
REGRAS GERAIS
 
1. Saída: retorne SOMENTE o HTML final dos blocos, sem explicações, sem Markdown e sem texto fora dos blocos.
 
 
2. Cada bloco deve ter o par de comentários de abertura e fechamento correspondente.
 
 
3. Escape seguro de HTML: converta <, >, & literais do conteúdo para entidades quando necessário, mantendo tags que você próprio gerar.
 
 
4. Não inclua atributos que você não possa determinar com segurança (ex.: id de imagem). Prefira atributos mínimos e válidos.
 
 
5. Não envolva a saída em <html>, <body> ou similares. É apenas o conteúdo do post.
 
 
 
MAPEAMENTO DE PADRÕES DO TEXTO PURO PARA BLOCOS
A) Parágrafos
 
Blocos de texto separados por linha em branco viram:
 
<!-- wp:paragraph -->    <p>...</p>    
<!-- /wp:paragraph -->    
B) Títulos
 
Linha que começa com "# " vira heading nível 1; "## " nível 2; "### " nível 3; até "###### " nível 6:
 
<!-- wp:heading {"level":N} -->    <hN>...</hN>
 
<!-- /wp:heading -->    Alternativamente, se uma linha é seguida por "====" (nível 1) ou "----" (nível 2), trate como heading.
 
 
C) Listas
 
Linhas que começam com "- " ou "* " viram lista não ordenada wp:list.
 
Linhas que começam com "1. ", "2. " etc. viram lista ordenada wp:list com {"ordered":true}.
Exemplo:
 
<!-- wp:list -->    <ul>    
  <li>Item 1</li>    
  <li>Item 2</li>    
</ul>    
<!-- /wp:list -->    
D) Citações
 
Linhas iniciadas por "> " viram:
 
<!-- wp:quote -->    <blockquote class="wp-block-quote"><p>Texto citado</p></blockquote>    
<!-- /wp:quote -->    
E) Código
 
Bloco iniciado por "" e finalizado por "" vira:
 
<!-- wp:code -->    <pre class="wp-block-code"><code>conteúdo bruto do código</code></pre>    <!-- /wp:code -->    
F) Separador
 
Uma linha contendo apenas "---" vira:
 
<!-- wp:separator -->    <hr class="wp-block-separator"/>    
<!-- /wp:separator -->    
G) Links e ênfase inline
 
Markdown [texto](url) vira <a href="url">texto</a>.
 
**negrito** vira <strong>...</strong> e *itálico* vira <em>...</em>.
 
Isso vale dentro de parágrafos, listas, citações e headings.
 
 
H) Imagens
 
Padrão Markdown ![alt](url) vira:
 
<!-- wp:image -->    <figure class="wp-block-image"><img src="url" alt="alt"/></figure>    
<!-- /wp:image -->    
I) Embeds
 
Uma URL sozinha em uma linha, de provedores suportados (YouTube, Vimeo, Twitter/X, etc.), vira wp:embed:
 
<!-- wp:embed {"url":"URL","type":"rich"} -->    <figure class="wp-block-embed"><div class="wp-block-embed__wrapper">URL</div></figure>    
<!-- /wp:embed -->    Caso não reconheça o provedor, deixe como parágrafo com link.
 
 
J) Linhas em branco múltiplas
 
Preserve quebras de parágrafo, mas não gere blocos vazios.
 
 
K) Normalização
 
Una linhas contínuas que pertencem ao mesmo parágrafo.
 
Remova espaços à direita no fim de linha.
 
Preserve acentuação e pontuação.
 
 
QUALIDADE E VALIDAÇÃO
 
A saída precisa poder ser colada no editor de código do WordPress e reabrir como blocos válidos.
 
Não misture HTML cru fora dos blocos, a menos que seja intencional usando <!-- wp:html --> quando estritamente necessário.
 
Não invente metadados. Use apenas {"level":N} em headings e {"ordered":true} em listas ordenadas, e {"url":"..."} em embeds quando aplicável.
 
 
FORMATO DE ENTRADA
Entre três crases, virá o texto puro a converter. Converta tudo conforme as regras:
 
Texto:`,
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
