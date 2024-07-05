<?php

/*
Template Name: Bulletins
*/

get_header();

?>
<div class="content-area">
    <main>
        <div class="container">
            <div class="category-title">
                <?php custom_breadcrumbs() ?>
                <h1><?= __('Boletins') ?></h1>
            </div>
        </div>
        <style>
            #bulletins {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(228px, 1fr));
                gap: 24px;

            }

            .bulletinCard {
                padding: 12px;
                border-radius: 8px;
                background-color: #DCF8C6;
            }
        </style>
        <div class="container">
            <div id="bulletins"></div>
        </div>
    </main>
    <script src="wp-content/themes/litci/assets/js/story-slider.js"></script>
    <script>
        place = document.getElementById('bulletins')
        fetch('/wp-json/wp/v2/posts?per_page=50')
            .then(resp => resp.json())
            .then(data => {
                data.forEach(text => {
                    result = []
                    result['link'] = text['link']
                    result['title'] = text['title']['rendered']
                    let paragraphs = text['content']['rendered'].match(/<p>(.*?)<\/p>/g);

                    for (let i = 0; i < paragraphs.length; i++) {
                        if (
                            i !== 0
                            && paragraphs[i].length > 8
                            && paragraphs[i].length < 168
                        ) {
                            console.log(i)
                            result['author'] = paragraphs[i]
                            result['excerpt'] = paragraphs[i + 1]
                            break
                        }
                    }

                    console.log(result['author'])
                    console.log(result['excerpt'])

                    if(!result['author']){
                        result['author'] = 'LIT-CI'
                    }

                    if(!result['excerpt']){
                        result['excerpt'] = paragraphs[2]
                    }

                    b = document.createElement('div')
                    b.className = 'bulletinCard'
                    b.innerHTML = '<b>' + result['title'] + '</b><br/><br>' + result['author'] + '</br>' + result['excerpt'] + '<br/><br/>' + result['link']

                    place.append(b)
                })
            })
    </script>
</div>
<?php get_footer(); ?>