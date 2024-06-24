<?php

/*
Template Name: Videos
*/

get_header();

$apiURL = 'https://videos.litci.org/api/channels';
$json = file_get_contents($apiURL);
$json = json_decode($json, TRUE);
$channels = $json['data'];

$contentList = [];

foreach ($channels as $channel) {
    $c = $channel['channel_id'];
    $contentList[$c]['name'] = $channel['name'];
    $contentList[$c]['url'] = $channel['url'];
    $contentList[$c]['videos'] = [];

    $api = 'https://videos.litci.org/api/videos/channel/' . $c;
    $json = file_get_contents($api);
    $videos = json_decode($json, TRUE);

    for ($i = 0; $i < 8; $i++) {
        if (isset($videos['data'][$i])) {
            array_push($contentList[$c]['videos'], $videos['data'][$i]);
        }
    }
}

?>
<div class="content-area">
    <main>
        <div class="container">
            <div class="category-title">
                <h1>Videos</h1>
            </div>
        </div>
        <?php
        foreach ($contentList as $channel) { ?>
            <section>
                <div class="container">
                    <div class="column">
                        <h3 class="section-title"><?= $channel['name'] ?></h3>
                        <hr/>
                        <div class="video-grid">
                            <?php
                            foreach ($channel['videos'] as $video) { ?>
                                <div class="video-item">
                                    <a class="video-thumb" href="<?= $video['url'] ?>">
                                        <div class="image" style="background-image:url('http://i3.ytimg.com/vi/<?= $video['video_id'] ?>/maxresdefault.jpg')"></div>
                                    </a>
                                    <div class="video-info">
                                        <a href="<?= $video['url'] ?>" class="title">
                                            <h4><?= $video['title'] ?></h4>
                                        </a>
                                        <p class="author"><?= $channel['name'] ?></p>
                                        <p class="description"><?= $video['description'] ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>

    </main>
    <script src="wp-content/themes/litci/assets/js/story-slider.js"></script>
</div>
<?php get_footer(); ?>