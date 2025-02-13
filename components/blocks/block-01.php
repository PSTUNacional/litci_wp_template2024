<?php
?>
<section style="background-color:
    <?= isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : 'inherit' ?>"
    class="<?= isset($attributes['isDark']) ? 'dark' : '' ?>">
    <div class="block-01">
        <div class="container">
            <?php
            $post = $posts[0];
            setup_postdata($post);
            include __DIR__ . '/../units/unit-01.php';

            isset($attributes['sortOption']) && $attributes['sortOption'] == 'menu_order'
                ? $GLOBALS['featured_ids'][] = $post->ID
                : '';
            ?>
        </div>
    </div>
</section>