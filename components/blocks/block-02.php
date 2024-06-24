<section>
    <div class="container">
        <div class="column">
            <?php if (isset($block_title)) { ?>
                <div class="block-header">
                    <h3><?= $block_title ?></h3>
                    <a class="see-more" href="<?=get_category_link($attributes['blockCategories'][0])?>">Veja mais</a>
                </div>
            <?php } ?>
            <div class="block-02">
                <?php
                for ($i = 0; $i < 4; $i++) {
                    if (isset($posts[$i])) {
                        $post = $posts[$i];
                        include __DIR__ . '/../units/unit-02.php';
                    };
                }
                ?>
            </div>
        </div>
    </div>
</section>