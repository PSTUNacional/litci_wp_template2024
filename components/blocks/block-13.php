<section style="background-color:
    <?= isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : 'inherit' ?>" class="<?= isset($attributes['isDark']) ? 'dark' : '' ?>">
    <div class="container">
        <div class="column">
            <div class="block-header">
                <?php if (isset($block_title)) { ?>
                    <h3><?= $block_title ?></h3>
                <?php }
                if (isset($attributes['columnLeft']['blockCategories'][0])) {
                ?>
                    <!---<a class="see-more" href="<?= get_category_link($attributes['blockCategories'][0]) ?>">Veja mais</a>-->
                <?php } ?>
            </div>
            <div class="block-13">
                <div class="column">
                    <?php
                    $post = $postsLeft[0];
                    include __DIR__ . '/../units/unit-07.php';

                    isset($attributes['columnLeft']['sortOption']) && $attributes['columnLeft']['sortOption'] == 'menu_order'
                        ? $GLOBALS['featured_ids'][] = $post->ID
                        : '';
                    ?>
                    <div class="post-grid">
                        <?php

                        for ($i = 1; $i < 4; $i++) {
                            if (isset($postsLeft[$i])) {
                                $post = $postsLeft[$i];
                                include __DIR__ . '/../units/unit-05.php';
                                isset($attributes['columnLeft']['sortOption']) && $attributes['columnLeft']['sortOption'] == 'menu_order'
                                    ? $GLOBALS['featured_ids'][] = $post->ID
                                    : '';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="separator"></div>
                <div class="column">
                    <div class="video-story-container">
                        <?php
                        foreach ($videos as $video) {
                            $url = 'https://www.youtube.com/embed/' . $video;
                        ?>
                            <div class="video-story">
                                <iframe
                                    src="<?= $url ?>"
                                    frameborder="0"
                                    allowfullscreen></iframe>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="post-grid">
                        <?php

                        for ($i = 0; $i < 3; $i++) {
                            if (isset($postsRight[$i])) {
                                $post = $postsRight[$i];
                                include __DIR__ . '/../units/unit-05.php';
                                isset($attributes['sortOption']) && $attributes['sortOption'] == 'menu_order'
                                    ? $GLOBALS['featured_ids'][] = $post->ID
                                    : '';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>