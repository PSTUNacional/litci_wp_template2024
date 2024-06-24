<section>
    <div class="container">
        <div class="column">
            <div class="block-header">
                <?php if (isset($block_title)) { ?>
                    <h3><?= $block_title ?></h3>
                <?php }
                if (isset($attributes['blockCategories'][0])) {
                ?>
                    <a class="see-more" href="<?= get_category_link($attributes['blockCategories'][0]) ?>">Veja mais</a>
                <?php } ?>
            </div>
            <div class="block-03">
                <div class="column quarter">
                    <?php
                    if (isset($posts[0])) {
                        $post = $posts[0];
                        include __DIR__ . '/../units/unit-02.php';
                    }
                    ?>
                </div>
                <div class="column half">
                    <?php
                    if (isset($posts[1])) {
                        $post = $posts[1];
                        include __DIR__ . '/../units/unit-02.php';
                    };
                    ?>
                </div>
                <div class="column quarter">
                    <?php
                    if (isset($posts[2])) {
                        $post = $posts[2];
                        include __DIR__ . '/../units/unit-03.php';
                    }

                    if (isset($posts[3])) {
                        $post = $posts[3];
                        include __DIR__ . '/../units/unit-03.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>