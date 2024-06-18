<article class="unit-01">
    <div class='column'>
        <?= lit_render_thumbnail($post, "large"); ?>
    </div>
    <div class="column va-center">
        <a href="<?= get_the_permalink($post); ?>" title="<?= get_the_title($post); ?>" arial-label="<?= the_title(); ?>">
            <h2><?= get_the_title($post); ?></h2>
        </a>
        <p><?= get_the_excerpt($post); ?></p>
        <div class="meta">
            <span class="sup-category"><?= escape_categories(wp_get_post_categories($post->ID)); ?></span>
            <p class="post-date"><?= formatDate($post->post_date) ?></p>
        </div>
</article>