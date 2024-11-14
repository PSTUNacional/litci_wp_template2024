<?php

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
for ($i = 0; $i < 3; $i++) {
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
            <a class="see-more" href="/videos">Vee más</a>
        </div>
    </div>
    <div class="container">
        <div class="column ta-left va-center video-grid">
            <?php
            if($isSingle){?>
                <h3><?= $channel['name']?></h3>
                    <p><?= $channel['description']?></p>
            <?php } else { ?>
            <div class="video-item" data-video="<?= $videos[0]['video_id'] ?>">
                <a href="<?= $videos[0]['url'] ?>" class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[0]['video_id'] ?>/hqdefault.jpg')"></a>
                <div class="video-info">
                    <!--<span class="badge primary"></span>-->
                    <a href="<?= $videos[0]['url'] ?>">
                        <h3><?= $videos[0]['title'] ?></h3>
                    </a>
                    <span class="date"><?= date("d M Y", strtotime($videos[0]['publication_date'])) ?></span>
                    <!--<p class="description"><?= $videos[0]['description'] ?></p>-->
                    <!--<p class="duration"><?= $videos[0]['duration'] ?></p>-->
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="column video-grid">
            <?php 
                $destak= $isSingle ? 0 : 1;
            ?>
            <div class="video-item" data-video="<?= $videos[$destak]['video_id'] ?>">
                <a href="<?= $videos[$destak]['url'] ?>" class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[$destak]['video_id'] ?>/hqdefault.jpg')"></a>
                <div class="video-info">
                    <!--<span class="badge primary"></span>-->
                    <a href="<?= $videos[$destak]['url'] ?>">
                        <h3><?= $videos[$destak]['title'] ?></h3>
                    </a>
                    <span class="date"><?= date("d M Y", strtotime($videos[$destak]['publication_date'])) ?></span>
                    <!--<p class="description"><?= $videos[$destak]['description'] ?></p>-->
                    <!--<p class="duration"><?= $videos[$destak]['duration'] ?></p>-->
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top:var(--gap)">
        <div class="video-grid">
            <?php
            $start = $isSingle ? 1 : 2;
            for ($i = $start; $i < 6; $i++) {
                if (isset($videos[$i])) { ?>
                    <div class="video-item" data-video="<?= $videos[$i]['video_id'] ?>">
                        <a href="<?= $videos[$i]['url'] ?>" class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[$i]['video_id'] ?>/hqdefault.jpg')"></a>
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