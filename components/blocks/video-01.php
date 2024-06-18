<?php
$url = 'https://data.pstu.org.br/src/Api/YoutubeContent.php?method=listall&results=4';
$json = file_get_contents($url);
$videos = json_decode($json, TRUE);
?>
<section class="video-block-01 video-section">
    <div class="container">
    <div class="block-header">
            <h3>Vídeos</h3>
            <a class="see-more">Veja mais</a>
        </div>
    </div>
    <div class="container">
        <div class="column">
            <div class="video-item only-thumb" data-video="<?= $videos[0]['video_id'] ?>">
                <div class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[0]['video_id'] ?>/mqdefault.jpg')"></div>
                <div class="video-info">
                    <span class="badge primary"><?= $videos[0]['channel_name'] ?></span>
                    <h3><?= $videos[0]['title'] ?></h3>
                    <span class="date"><?= date("d M Y", strtotime($videos[0]['date'])) ?></span>
                    <p class="description"><?= $videos[0]['description'] ?></p>
                    <p class="duration"><?= $videos[0]['duration'] ?></p>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="video-item only-thumb" data-video="<?= $videos[1]['video_id'] ?>">
                <div class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[1]['video_id'] ?>/mqdefault.jpg')"></div>
                <div class="video-info">
                    <span class="badge primary"><?= $videos[1]['channel_name'] ?></span>
                    <h3><?= $videos[1]['title'] ?></h3>
                    <span class="date"><?= date("d M Y", strtotime($videos[1]['date'])) ?></span>
                    <p class="description"><?= $videos[1]['description'] ?></p>
                    <p class="duration"><?= $videos[1]['duration'] ?></p>
                </div>
            </div>
            <div class="video-item only-thumb" data-video="<?= $videos[2]['video_id'] ?>">
                <div class="video-thumb" style="background-image:url('https://i.ytimg.com/vi/<?= $videos[2]['video_id'] ?>/mqdefault.jpg')"></div>
                <div class="video-info">
                    <span class="badge primary"><?= $videos[2]['channel_name'] ?></span>
                    <h3><?= $videos[2]['title'] ?></h3>
                    <span class="date"><?= date("d M Y", strtotime($videos[2]['date'])) ?></span>
                    <p class="description"><?= $videos[2]['description'] ?></p>
                    <p class="duration"><?= $videos[2]['duration'] ?></p>
                </div>
            </div>
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