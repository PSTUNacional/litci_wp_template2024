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
                    <a class="see-more" href="<?= get_category_link($attributes['blockCategories'][0]) ?>"><?= _e('See more', 'litci')?></a>
                <?php } ?>
            </div>
            <div class="block-05">
                <div class="featured">
                    <?php
                    $post = $posts[0];
                    include __DIR__ . '/../units/unit-03.php';

                    isset($attributes['sortOption']) && $attributes['sortOption'] == 'menu_order'
                        ? $GLOBALS['featured_ids'][] = $post->ID
                        : '';
                    ?>
                </div>
                <div class="grid">
                    <?php
                    $i = 1;
                    for ($i = 1; $i < 4; $i++) {
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
    </div>
</section>