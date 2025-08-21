<section style="background-color:
    <?= isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : 'inherit' ?>" class="<?= isset($attributes['isDark']) ? 'dark' : '' ?>">
    <div class="container">
        <div class="column">
            <div class="block-header">
                <?php if (isset($block_title)) { ?>
                    <h3><?= $block_title ?></h3>
                <?php }
                if (isset($attributes['blockCategories'][0])) {
                ?>
                    <a class="see-more" href="<?= get_category_link($attributes['blockCategories'][0]) ?>"><?= _e('See more', 'litci') ?></a>
                <?php } ?>
            </div>
            <div class="block-12">
                <div class="column">
                    <?php
                    if (isset($posts[0])) {
                        $post = $posts[0];
                        include __DIR__ . '/../units/unit-08.php';

                        isset($attributes['sortOption']) && $attributes['sortOption'] == 'menu_order'
                            ? $GLOBALS['featured_ids'][] = $post->ID
                            : '';
                    } ?>
                </div>
                <div class="column video-grid">
                    <?php
                    $videoId = $attributes['videoId'];
                    $videoUrl = 'https://www.youtube.com/watch?v=' . $videoId;
                    $videoTitle = $attributes['videoTitle'];

                    ?>
                    <div class="video-item" data-video="<?= $videoId ?>">
                        <div class="video-info">
                            <span class="sup-category" href="">Video</span>
                            <a href="<?= $videoUrl ?>">
                                <h4><?= $videoTitle ?></h4>
                            </a>
                        </div>
                        <a href="<?= $videoUrl ?>" class="video-thumb" target="_blank" style="background-image:url('https://i.ytimg.com/vi/<?= $videoId ?>/hqdefault.jpg')">
                            <div class="icon"><i class="material-icons">play_circle_filled</i></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>