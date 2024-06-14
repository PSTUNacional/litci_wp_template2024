<?php
setup_postdata($post);
?>
<article class="unit-02">
    <div class='column'>
        <?= lit_render_thumbnail($post, "large"); ?>
    </div>
    <div class="column">
        <a href="<?= the_permalink(); ?>" title="<?= the_title(); ?>" arial-label="<?= the_title(); ?>">
            <h3><?= the_title(); ?></h3>
        </a>
        <div class="excerpt"><?= the_excerpt(); ?></div>
        <div class="meta">
            <span class="sup-category"><?= escape_categories(wp_get_post_categories($post->ID)); ?>
            </span>
            <p class="post-date"><?= formatDate($post->post_date) ?></p>
        </div>
    </div>
</article>