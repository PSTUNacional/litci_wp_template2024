<article class="unit-02">
    <div class='column'>
        <?= lit_render_thumbnail($post, "large"); ?>
    </div>
    <div class="column">
        <a href="<?= get_the_permalink($post); ?>" title="<?= get_the_title($post); ?>" arial-label="<?= the_title(); ?>">
            <h3><?= get_the_title($post); ?></h3>
        </a>
        <div class="excerpt"><?= get_the_excerpt($post); ?></div>
        <div class="meta">
            <?php $cat = escape_categories(wp_get_post_categories($post->ID)); ?>
            <a class="sup-category" href="<?= get_category_link($cat['id']) ?>">
                <?= $cat['name']; ?>
            </a>
            <p class="post-date"><?= formatDate($post->post_date) ?></p>
        </div>
    </div>
</article>