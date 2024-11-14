<?php

// Get Channels
$apiChannel = 'https://videos.litci.org/api/channels';
$json = file_get_contents($apiChannel);
$data = json_decode($json, TRUE);
$channels = $data['data'];

$videos = [];

// Get videos by Channel
$apiVideos = 'https://videos.litci.org/api/videos/channel/';
foreach($channels as $channel)
{
    $id = $channel['channel_id'];
    $json = file_get_contents($apiVideos . $id);
    $data = json_decode($json, TRUE);
    $videos[] = $data['data'][0];
}

?>
<section class="video-block-03 video-section dark">
    <div class="container">
        <div class="block-header">
            <h3>Vídeos</h3>
            <a class="see-more" href="/videos"><?= _e('See more', 'litci')?></a>
        </div>
    </div>
    <div class="container" style="margin-top:var(--gap)">
        <div class="video-grid">
            <?php
            foreach($videos as $video) {
                if (isset($video)) { ?>
                    <div class="video-item" data-video="<?= $video['video_id'] ?>">
                        <a href="<?= $video['url'] ?>" class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $video['video_id'] ?>/hqdefault.jpg')">
                            <div class="icon"><i class="material-icons">play_circle_filled</i></div>
                        </a>
                        <div class="video-info">
                            <!--<span class="badge primary"><?= $video['channel_name'] ?></span>-->
                            <a href="<?= $video['url'] ?>">
                                <h3><?= $video['title'] ?></h3>
                            </a>
                            <span class="date"><?= date("d M Y", strtotime($video['publication_date'])) ?></span>
                            <!--<p class="description"><?= $video['description'] ?></p>-->
                            <!--<p class="duration"><?= $video['duration'] ?></p>-->
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>