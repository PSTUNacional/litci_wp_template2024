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
                    <a class="see-more" href="<?= get_category_link($attributes['blockCategories'][0]) ?>">Veja mais</a>
                <?php } ?>
            </div>
            <div class="block-socialmedia">
                <?php
                    $socialmedias = ['facebook', 'instagram', 'twitter', 'youtube', 'tiktok','whatsapp'];

                    foreach($socialmedias as $s)
                    {
                        if(isset($attributes[$s]))
                        {
                            echo '<a class="card '.$s.'" href="'.$attributes[$s].'"><span></span>'.ucfirst($s).'</a>';
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</section>