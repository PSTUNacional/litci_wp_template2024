<section style="background-color:
    <?= isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : 'inherit' ?>" class="<?= isset($attributes['isDark']) ? 'dark' : '' ?>">
    <div class="container" style="gap: 24px">
        <div class="column">
            <div class="block-header">
                <?php if (isset($block_title_one)) { ?>
                    <h3><?= $block_title_one ?></h3>
                <?php }
                if (isset($attributes['blockCategoriesOne'][0])) {
                ?>
                    <a class="see-more" href="<?= get_category_link($attributes['blockCategoriesOne'][0]) ?>"><?= _e('See more', 'litci')?></a>
                <?php } ?>
            </div>
            <div class="block-06 main">
                <?php
                $post = $posts_one[0];
                include __DIR__ . '/../units/unit-03.php';
                ?>
            </div>
            <div class="block-06 minor">
                <?php
                $post = $posts_one[1];
                include __DIR__ . '/../units/unit-04.php';
                $post = $posts_one[2];
                include __DIR__ . '/../units/unit-04.php';
                ?>
            </div>
        </div>
        <div class="column">
            <div class="block-header">
                <?php if (isset($block_title_two)) { ?>
                    <h3><?= $block_title_two ?></h3>
                <?php }
                if (isset($attributes['blockCategoriesTwo'][0])) {
                ?>
                    <a class="see-more" href="<?= get_category_link($attributes['blockCategoriesTwo'][0]) ?>"><?= _e('See more', 'litci')?></a>
                <?php } ?>
            </div>
            <div class="block-06 main">
                <?php
                $post = $posts_two[0];
                include __DIR__ . '/../units/unit-03.php';
                ?>
            </div>
            <div class="block-06 minor">
                <?php
                $post = $posts_two[1];
                include __DIR__ . '/../units/unit-04.php';
                $post = $posts_two[2];
                include __DIR__ . '/../units/unit-04.php';
                ?>
            </div>
        </div>
    </div>
</section>