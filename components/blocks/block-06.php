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
                    <a class="see-more" href="<?= get_category_link($attributes['blockCategories'][0]) ?>">Vee más</a>
                <?php } ?>
            </div>
            <div class="block-06 main">
                <?php
                for ($i = 0; $i < 2; $i++) {
                    if (isset($posts[$i])) {
                        $post = $posts[$i];
                        include __DIR__ . '/../units/unit-03.php';

                        isset($attributes['sortOption']) && $attributes['sortOption'] == 'menu_order'
                            ? $GLOBALS['featured_ids'][] = $post->ID
                            : '';
                    }
                }
                ?>
            </div>
            <div class="block-06 minor">
                <?php
                for ($i = 2; $i < 6; $i++) {
                    if (isset($posts[$i])) {
                        $post = $posts[$i];
                        include __DIR__ . '/../units/unit-04.php';

                        isset($attributes['sortOption']) && $attributes['sortOption'] == 'menu_order'
                            ? $GLOBALS['featured_ids'][] = $post->ID
                            : '';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>