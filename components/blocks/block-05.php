<section>
    <div class="container">
        <div class="column">
            <div class="block-header">
                <?php if (isset($block_title)) { ?>
                    <h3><?= $block_title ?></h3>
                <?php } ?>
                <a class="see-more" href="<?=get_category_link($attributes['blockCategories'][0])?>">Veja mais</a>
            </div>
            <div class="block-05">
                <div class="featured">
                    <?php
                    $post = $posts[0];
                    include __DIR__ . '/../units/unit-03.php';
                    ?>
                </div>
                <div class="grid">
                    <?php
                    $i = 1;
                    for ($i = 1; $i < 4; $i++) {
                        if (isset($posts[$i])) {
                            $post = $posts[$i];
                            include __DIR__ . '/../units/unit-04.php';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>