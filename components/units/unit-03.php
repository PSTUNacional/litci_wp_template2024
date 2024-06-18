<?php
setup_postdata($post);
?>
<article class="unit-03">
    <?= lit_render_thumbnail($post, "large"); ?>
    <div class="info">
        <a href="<?= the_permalink(); ?>" title="<?= get_the_title($post); ?>" arial-label="<?= get_the_title($post); ?>">
            <h3><?= get_the_title($post); ?></h3>
        </a>
        <div class="excerpt"><?= get_the_excerpt($post); ?></div>
        <div class="meta">
            <span class="sup-category"><?= escape_categories(wp_get_post_categories($post->ID)); ?></span>
            <p class="post-date"><?= formatDate($post->post_date) ?></p>
        </div>
    </div>
</article>