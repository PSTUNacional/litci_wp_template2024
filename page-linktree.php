<?php

/*
Template Name: Link Tree
*/

get_header();

?>
<style>
    html {
        margin-top: 0 !important;
    }

    main {
        margin-top: 24px;
    }

    body {
        background-color: #eee;
    }

    header {
        display: none;
    }

    #postsContainer {
        display: flex;
        flex-direction: column;
        gap: 8px;

        width: 100%;
    }

    .postsCard {
        display: flex;
        align-items: center;
        gap: 16px;
        background-color: #fff;
        border-radius: 12px;
        padding: 4px 12px 4px 4px;
        width: 100%;
        box-shadow: 0 1px 3px 0 #ccc;
    }

    .postsCard h3 {
        font-size: 12px;
        line-height: 1.4;
    }

    .postsCard h3 span {
        display: block;
        font-size: 8px;
        color: #c00;
    }

    .postsCard .fimg {
        background-position: center;
        aspect-ratio: 1;
        border-radius: 8px;
        min-width: 88px;
        max-width: 88px;
    }

    .container .logo {
        max-width: 180px;
        margin: auto;
        margin-bottom: 24px;
    }
</style>
<div class="content-area">
    <main>
        <div class="container" style="display:flex; flex-direction:column;">
            <?php
            if (function_exists('get_custom_logo')) {
                $custom_logo_id = get_theme_mod('custom_logo');
                $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
                echo '<img class="logo" src="' . esc_url($logo_url) . '" alt="Site Logo">';
            }
            ?>
            <h3 style="text-align:center; margin-bottom:24px"><?= _e('Latest posts', 'litci') ?></h3>
            <div id="postsContainer"></div>
        </div>
    </main>
    <script>
        const place = document.getElementById('postsContainer');
        const api = '<?= esc_url(get_site_url()); ?>' + '/wp-json/wp/v2/posts?per_page=12';

        fetch(api)
            .then(resp => {
                if (!resp.ok) {
                    throw new Error('Erro ao carregar os posts: ' + resp.statusText);
                }
                return resp.json();
            })
            .then(data => {
                data.forEach(post => {

                    const link = post['link'] + "?utm_source=instagram&utm_medium=linkbio";
                    const title = post['title']['rendered'] || 'Sem título';
                    const image = post['fimg_url']; 
                    const category = post['categories_names'] ? post['categories_names'][0] : 'Sem categoria';

                    const card = document.createElement("a");
                    card.className = "postsCard";
                    card.href = link;

                    card.innerHTML = `
                    <div class="fimg" style="background: url('${image}'); background-size: cover;"></div>
                    <h3><span>${category}</span>${title}</h3>
                    `;
                    place.append(card);
                });
            })
            .catch(error => {
                console.error('Erro ao buscar os posts:', error);
            });
    </script>

</div>