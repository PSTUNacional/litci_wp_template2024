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
            <?php
                $amount = isset($attributes['postAmount']) ? $attributes['postAmount'] : 3;
                $amount == 3 || $amount == 6 || $amount == 9
                    ? $columns = 'three-columns'
                    : $columns = 'four-columns';
            ?>
            <div class="block-10 <?=$columns?>">
                <?php
                
                for($i = 0; $i < $amount; $i++)
                {
                    $post = $posts[$i];
                    include __DIR__ . '/../units/unit-03.php';

                    isset($attributes['sortOption']) && $attributes['sortOption'] == 'menu_order'
                        ? $GLOBALS['featured_ids'][] = $post->ID
                        : '';
                }
               
                ?>
            </div>
        </div>
    </div>
</section>