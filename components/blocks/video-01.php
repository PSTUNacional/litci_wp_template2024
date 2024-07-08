<?php
$url = 'https://videos.litci.org/api/videos';
$json = file_get_contents($url);
$videos = json_decode($json, TRUE);
$videos = $videos['data'];
$groupedChannels = [];
foreach($videos as $video)
{
    $channelId = $video['channel_id'];
    if (!isset($groupedVideos[$channelId])) {
        $groupedVideos[$channelId] = [];
    }
    $groupedChannels[$channelId][] = $video;
}

$videos = [];
for($i = 0; $i < 3; $i++)
{
    foreach($groupedChannels as $c)
    {
        $videos[] = $c[$i];
    }
}

?>
<section class="video-block-01 video-section">
    <div class="container">
    <div class="block-header">
            <h3>Vídeos</h3>
            <a class="see-more" href="/videos">Veja mais</a>
        </div>
    </div>
    <div class="container">
        <div class="column ta-left video-grid">
            <div class="video-item" data-video="<?= $videos[0]['video_id'] ?>">
                <a href="<?=$videos[0]['url']?>" class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[0]['video_id'] ?>/hqdefault.jpg')"></a>
                <div class="video-info">
                    <!--<span class="badge primary"></span>-->
                    <a href="<?=$videos[0]['url']?>"><h3><?= $videos[0]['title'] ?></h3></a>
                    <span class="date"><?= date("d M Y", strtotime($videos[0]['publication_date'])) ?></span>
                    <!--<p class="description"><?= $videos[0]['description'] ?></p>-->
                    <!--<p class="duration"><?= $videos[0]['duration'] ?></p>-->
                </div>
            </div>
        </div>
        <div class="column video-grid">
            <div class="video-item" data-video="<?= $videos[1]['video_id'] ?>">
                <a href="<?=$videos[1]['url']?>" class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[1]['video_id'] ?>/hqdefault.jpg')"></a>
                <div class="video-info">
                    <!--<span class="badge primary"></span>-->
                    <a href="<?=$videos[1]['url']?>"><h3><?= $videos[1]['title'] ?></h3></a>
                    <span class="date"><?= date("d M Y", strtotime($videos[1]['publication_date'])) ?></span>
                    <!--<p class="description"><?= $videos[1]['description'] ?></p>-->
                    <!--<p class="duration"><?= $videos[1]['duration'] ?></p>-->
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top:var(--gap)">
        <div class="video-grid">
            <?php
            for($i=2; $i<6; $i++)
            { ?>
                <div class="video-item" data-video="<?= $videos[$i]['video_id'] ?>">
                    <a href="<?=$videos[$i]['url']?>" class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[$i]['video_id'] ?>/hqdefault.jpg')"></a>
                    <div class="video-info">
                        <!--<span class="badge primary"><?= $videos[$i]['channel_name'] ?></span>-->
                        <a href="<?=$videos[$i]['url']?>"><h3><?= $videos[$i]['title'] ?></h3></a>
                        <span class="date"><?= date("d M Y", strtotime($videos[$i]['publication_date'])) ?></span>
                        <!--<p class="description"><?= $videos[$i]['description'] ?></p>-->
                        <!--<p class="duration"><?= $videos[$i]['duration'] ?></p>-->
                    </div>
                </div>
            <?php
                }
            ?>
    </div>
    </div>
</section>