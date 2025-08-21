<section style="background-color:
    <?= isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : 'inherit' ?>" class="<?= isset($attributes['isDark']) ? 'dark' : '' ?>">
    <div class="container">
        <div class="column">
            <div class="block-header">
                <?php if (isset($block_title)) { ?>
                    <h3><?= $block_title ?></h3>
                <?php } ?>
            </div>
            <div class="block-09">
                <?php
                $post = $propaganda[0];
                include __DIR__ . '/../units/unit-07.php';

                isset($attributes['sortOption']) && $attributes['sortOption'] == 'menu_order'
                    ? $GLOBALS['featured_ids'][] = $post->ID
                    : '';
                ?>
                <div class="block-header" style="margin-top:24px;">
                    <h3 class="last-news"><?= __('Últimas notícias') ?></h3>
                </div>
                <div class="news-line">
                    <?php
                    for ($i = 0; $i < 4; $i++) { 
                        $post = $posts[$i];
                        ?>
                        <article>
                            <a href="<?= get_the_permalink($post); ?>" title="<?= get_the_title($post); ?>" arial-label="<?= the_title(); ?>">
                                <h4><?= get_the_title($post); ?></h4>
                            </a>
                        </article>
                    <?php }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>