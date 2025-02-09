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
            <?php
                $postAmount = isset($attributes['postAmount']) ? $attributes['postAmount'] : 4;
                $columnsAmount = isset($attributes['columns']) ? $attributes['columns'] : 3;
                $validColumns = [
                    2 => 'two-columns',
                    3 => 'three-columns',
                    4 => 'four-columns',
                    5 => 'five-columns'
                ];

                $columns = isset($validColumns[$columnsAmount]) ? $validColumns[$columnsAmount] : 'three-columns';
            ?>
            <div class="block-10 <?=$columns?>">
                <?php
                
                for($i = 0; $i < $postAmount; $i++)
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