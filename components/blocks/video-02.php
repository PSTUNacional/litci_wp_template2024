<?php

$videoAmount = $attributes['videoAmount'];
$columns = $attributes['columns'];

$json = file_get_contents($url);
$videos = json_decode($json, TRUE);
$videos = $videos['data'];
$groupedChannels = [];
foreach ($videos as $video) {
    $channelId = $video['channel_id'];
    if (!isset($groupedVideos[$channelId])) {
        $groupedVideos[$channelId] = [];
    }
    $groupedChannels[$channelId][] = $video;
}

$videos = [];
for ($i = 0; $i < $videoAmount; $i++) {
    foreach ($groupedChannels as $c) {
        $videos[] = $c[$i];
    }
}

if(isset($channelData))
{
    $json = file_get_contents($channelData);
    $channel = json_decode($json, TRUE);
    $channel = $channel['data'];
}
?>
<section class="video-block-01 video-section dark">
    <div class="container">
        <div class="block-header">
            <h3>Vídeos</h3>
            <a class="see-more" href="/videos"><?= _e('See more', 'litci')?></a>
        </div>
    </div>
    <div class="container" style="margin-top:var(--gap)">
        <div class="video-grid" style='grid-template-columns: repeat(<?=$columns?>, 1fr)'>
            <?php
            for ($i = 0; $i < $videoAmount; $i++) {
                if (isset($videos[$i])) { ?>
                    <div class="video-item" data-video="<?= $videos[$i]['video_id'] ?>">
                        <a href="<?= $videos[$i]['url'] ?>" class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[$i]['video_id'] ?>/hqdefault.jpg')">
                            <div class="icon"><i class="material-icons">play_circle_filled</i></div>
                        </a>
                        <div class="video-info">
                            <!--<span class="badge primary"><?= $videos[$i]['channel_name'] ?></span>-->
                            <a href="<?= $videos[$i]['url'] ?>">
                                <h3><?= $videos[$i]['title'] ?></h3>
                            </a>
                            <span class="date"><?= date("d M Y", strtotime($videos[$i]['publication_date'])) ?></span>
                            <!--<p class="description"><?= $videos[$i]['description'] ?></p>-->
                            <!--<p class="duration"><?= $videos[$i]['duration'] ?></p>-->
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>