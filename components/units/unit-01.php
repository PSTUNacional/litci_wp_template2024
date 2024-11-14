<article class="unit-01">
    <div class='column'>
        <span class="sup-category mobile"><?= escape_categories(wp_get_post_categories($post->ID)); ?></span>
        <a href="<?= get_the_permalink($post); ?>" class="mobile" title="<?= get_the_title($post); ?>" arial-label="<?= the_title(); ?>">
            <h2><?= get_the_title($post); ?></h2>
        </a>
        <?= lit_render_thumbnail($post, "large"); ?>
    </div>
    <div class="column va-center">
        <a href="<?= get_the_permalink($post); ?>" class="desktop" title="<?= get_the_title($post); ?>" arial-label="<?= the_title(); ?>">
            <h2><?= get_the_title($post); ?></h2>
        </a>
        <p><?= get_the_excerpt($post); ?></p>
        <div class="meta">
            <a class="sup-category desktop" href="<?=  get_category_link(wp_get_post_categories($post->ID)[0]) ?>"><?= escape_categories(wp_get_post_categories($post->ID)); ?></a>
            <p class="post-date"><?= formatDate($post->post_date) ?></p>
        </div>
</article>