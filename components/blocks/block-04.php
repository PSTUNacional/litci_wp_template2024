<section>
    <div class="container">
        <div class="column">
        <?php if (isset($block_title)) { ?>
                <div class="block-header">
                    <h3><?= $block_title ?></h3>
                    <a class="see-more" href="<?=get_category_link($attributes['blockCategories'][0])?>">Veja mais</a>
                </div>
            <?php } ?>
            <div class="block-04">
                <div class="featured">
                    <?php
                    $post = $posts[0];
                    include __DIR__ . '/../units/unit-03.php';
                    ?>
                </div>
                <div class="grid">
                    <?php
                    $i = 1;
                    for ($i = 1; $i < 5; $i++) {
                        if(isset($posts[$i]))
                        {
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