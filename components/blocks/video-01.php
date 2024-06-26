<?php
$url = 'https://videos.litci.org/api/videos';
$json = file_get_contents($url);
$videos = json_decode($json, TRUE);
$videos = $videos['data'];
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
                <div class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[0]['video_id'] ?>/hqdefault.jpg')"></div>
                <div class="video-info">
                    <!--<span class="badge primary"></span>-->
                    <h3><?= $videos[0]['title'] ?></h3>
                    <span class="date"><?= date("d M Y", strtotime($videos[0]['publication_date'])) ?></span>
                    <!--<p class="description"><?= $videos[0]['description'] ?></p>-->
                    <!--<p class="duration"><?= $videos[0]['duration'] ?></p>-->
                </div>
            </div>
        </div>
        <div class="column video-grid">
            <div class="video-item" data-video="<?= $videos[1]['video_id'] ?>">
                <div class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[1]['video_id'] ?>/hqdefault.jpg')"></div>
                <div class="video-info">
                    <!--<span class="badge primary"></span>-->
                    <h3><?= $videos[1]['title'] ?></h3>
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
                    <div class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[$i]['video_id'] ?>/hqdefault.jpg')"></div>
                    <div class="video-info">
                        <!--<span class="badge primary"><?= $videos[$i]['channel_name'] ?></span>-->
                        <h3><?= $videos[$i]['title'] ?></h3>
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
<script>
    videoheader = document.querySelector('.video-destak');
    video = document.querySelectorAll('.video-item')[0].dataset['video']

    videoItems = document.querySelectorAll('.video-item')
    videoItems.forEach(el => {
        el.addEventListener('click', () => {
            videoId = event.currentTarget.getAttribute('data-video')
            title = event.currentTarget.querySelector('h3').innerText
            description = event.currentTarget.querySelector('.description').innerText
            duration = event.currentTarget.querySelector('.duration').innerText

            videoheader.querySelector('.video-thumb').style.backgroundImage = "url('http://i3.ytimg.com/vi/" + videoId + "/maxresdefault.jpg')"
            videoheader.querySelector('h1').innerText = title
            videoheader.querySelector('#videoDescription').innerText = description
            videoheader.querySelector('#videoDuration span').innerText = duration
            video = videoId
            window.scrollTo(0, 0);
        })
    })
</script>