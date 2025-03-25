<article class="unit-07">
    <div class='column'>
        <div class="meta">
            <?php $cat = escape_categories(wp_get_post_categories($post->ID)); ?>
            <a class="sup-category" href="<?= get_category_link($cat['id']) ?>">
                <?= $cat['name']; ?>
            </a>
        </div>
        <a href="<?= get_the_permalink($post); ?>" title="<?= get_the_title($post); ?>" arial-label="<?= the_title(); ?>">
            <h2><?= get_the_title($post); ?></h2>
        </a>
        <div class="grid">
            <?= lit_render_thumbnail($post, "large"); ?>
            <div class="excerpt"><?= get_the_excerpt($post); ?></div>
        </div>
    </div>
</article>