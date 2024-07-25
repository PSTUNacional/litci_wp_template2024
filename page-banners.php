<?php

/*
Template Name: Banner generator
*/

get_header();

?>
<div class="content-area">
    <main>
        <div class="container">
            <div class="category-title">
                <?php custom_breadcrumbs() ?>
                <h1><?= __('Banner generator') ?></h1>
            </div>
        </div>
        <style>
            #banner-container {
                width: 1080px;
                height: 1080px;
                background-color: #000;
                overflow: hidden;
                position: relative;
            }

            #banner-container #content {
                padding: 100px;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: end;
                position: relative;
                z-index: 2;
            }
            #banner-container #content .logo {
                position: absolute;
                z-index: 100;
                top:100px;
                right: 100px;
                max-width: 100px;
            }

            #story-container {
                width: 1080px;
                height: 1920px;
                background-color: #000;
                overflow: hidden;
                position: relative;
                font-size: 24px !important;
            }

            #story-container #content {
                padding: 100px 80px 240px 80px;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: end;
                position: relative;
                z-index: 2;
            }


            #story-container #content .logo {
                position: absolute;
                z-index: 100;
                top:100px;
                right: 80px;
                max-width: 140px;

            }

            #banner-container #content #category,
            #story-container #content #category {
                color: #fff;
                background: #c00;
                padding: 12px 24px;
                border-radius: 4px;
                width: fit-content;
                font-weight: 500;
                text-transform: uppercase;
                margin-bottom: 24px;
            }

            #banner-container #content h1 {
                color: #fff;
                font-weight: 900;
            }

            #story-container #content h1 {
                color: #fff;
                font-weight: 900;
                font-size: 3.5em;
            }

            #banner-container #content h4,
            #story-container #content h4 {
                color: #fff;
                font-weight: 300;
                margin-top: 48px;
                letter-spacing: 0.25em;
            }

            #banner-container #background,
            #story-container #background {
                position: absolute;
                z-index: 1;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            #banner-container #background #picture,
            #story-container #background #picture {
                width: 100%;
                height: 75%;
                position: absolute;
                z-index: 1;
                top: 0;
                left: 0;
                background-position: center;
                background-size: cover;
            }

            #banner-container #background #gradient,
            #story-container #background #gradient {
                width: 100%;
                height: 100%;
                position: absolute;
                z-index: 2;
                background: linear-gradient(#0000 30%, #000 75%);
            }

            .hide {
                width: 0px;
                height: 0px;
                overflow: hidden;
            }

            #result {
                display: flex;
                width: 100%;
                gap: 24px;
            }

            #result .item {
                display: flex;
                flex-direction: column;
                gap: 24px;
                justify-content: center;
                align-items: center;
            }

            #banner-result canvas,
            #story-result canvas {
                max-height: 320px;
                width: auto;
            }

            button {
                background-color: #fff;
                color: #999;
                border: 1px solid #999;
                border-radius: 4px;
                cursor: pointer;
                padding: 8px 24px;
                display: block;
            }

            .controls {
                width: 100%;
                display: flex;
                gap: 24px;
                margin: 24px 0;
            }
        </style>
        <div class="container">
            <div class="controls">
                <select></select>
                <button onclick="render()">Gerar</button>
            </div>
        </div>
        <div class="container">

            <div class="hide">
                <div id="banner-container">
                    <div id="content">
                        <img class="logo" src="<?= get_template_directory_uri() . '/assets/img/logo_white_shadow.png' ?>" />
                        <div id="category">Palestina</div>
                        <h1>Lorem ipsum</h1>
                        <h4>www.litci.org</h4>
                    </div>
                    <div id="background">
                        <div id="gradient"></div>
                        <div id="picture"></div>
                    </div>
                </div>
                <div id="story-container">
                    <div id="content">
                        <img class="logo" src="<?= get_template_directory_uri() . '/assets/img/logo_white_shadow.png' ?>" />
                        <div id="category">Cateroria</div>
                        <h1>Title</h1>
                        <h4>www.litci.org</h4>
                    </div>
                    <div id="background">
                        <div id="gradient"></div>
                        <div id="picture"></div>
                    </div>
                </div>
            </div>
            <div id="result">
                <div class="item">
                    <div id="banner-result"></div>
                    <button onclick="download('banner-result', 'LIT-Banner')">Download</button>
                </div>
                <div class="item">
                    <div id="story-result"></div>
                    <button onclick="download('story-result', 'LIT-Story')">Download</button>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js" type="text/javascript"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script>
        let posts
        if (window.location.href.includes('dev.')) {
            url = '/litci/wp-json/wp/v2/posts?per_page=50'
        } else {
            url = '/wp-json/wp/v2/posts?per_page=50'
        }
        fetch(url)
            .then(resp => resp.json())
            .then(data => {
                posts = data
                place = document.querySelector('select')
                data.forEach((post, index) => {
                    opt = document.createElement('option')
                    opt.value = index
                    opt.innerText = post['title']['rendered']
                    place.append(opt)
                })
            })
            .then(() => {
                renderContent(posts[0])
            })

        function render() {
            i = document.querySelector('select').value
            renderContent(posts[i])
        }

        function renderContent(post) {
            category = post['categories_names'][0]
            if (category == 'Destacada') {
                category = post['categories_names'][1]
            }
            title = post['title']['rendered'];
            image = post['fimg_url']

            banner = document.getElementById('banner-container')
            banner.querySelector('#content #category').innerText = category
            banner.querySelector('#content h1').innerText = title
            banner.querySelector('#background #picture').style.backgroundImage = 'url(\'' + image + '\')'

            story = document.getElementById('story-container')
            story.querySelector('#content #category').innerText = category
            story.querySelector('#content h1').innerText = title
            story.querySelector('#background #picture').style.backgroundImage = 'url(\'' + image + '\')'

            createImage('banner-container', 'banner-result', 1080, 1080)
            createImage('story-container', 'story-result', 1080, 1920)
        }

        function createImage(source, target, w, h) {
            html2canvas(document.getElementById(source), {
                    allowTaint: true,
                    useCORS: true,
                    width: w,
                    height: h,
                    scale: 1
                })
                .then(canvas => {
                    document.getElementById(target).innerHTML = ''
                    canvas.style.width = "auto"
                    canvas.style.height = "auto"
                    document.getElementById(target).appendChild(canvas)
                })
        }

        function download(source, name) {
            canvas = document.getElementById(source).querySelector('canvas')
            filename = name + '.png'
            var dataURL = canvas.toDataURL('image/png');
            // Create a temporary link element
            var link = document.createElement('a');
            link.href = dataURL;
            link.download = filename;

            // Append the link to the document
            document.body.appendChild(link);

            // Trigger the download by simulating a click
            link.click();

            // Remove the link from the document
            document.body.removeChild(link);
        }
    </script>
</div>
<?php get_footer(); ?>