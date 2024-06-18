<?php
setup_postdata($post);
?>
<article class="unit-04">
    <div class='column'>
        <?= lit_render_thumbnail($post, "large"); ?>
    </div>
    <div class="column">
        <a href="<?= the_permalink(); ?>" title="<?= get_the_title($post); ?>" arial-label="<?= get_the_title($post); ?>">
            <h4><?= get_the_title($post); ?></h4>
        </a>
        <div class="meta">
            <span class="sup-category"><?= escape_categories(wp_get_post_categories($post->ID)); ?></span>
            <p class="post-date"><?= formatDate($post->post_date) ?></p>
        </div>
    </div>
</article>