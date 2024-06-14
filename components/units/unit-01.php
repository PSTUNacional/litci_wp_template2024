<?php
$post = $posts[0];
setup_postdata($post);
?>
<article class="unit-01">
    <div class='column'>
        <?= lit_render_thumbnail($post, "large"); ?>
    </div>
    <div class="column va-center">
        <a href="<?= the_permalink(); ?>" title="<?= the_title(); ?>" arial-label="<?= the_title(); ?>">
            <h2><?= the_title(); ?></h2>
        </a>
        <p><?= the_excerpt(); ?></p>
        <div class="meta">
            <span class="sup-category"><?= escape_categories(wp_get_post_categories($post->ID)); ?></span>
            <p class="post-date"><?= formatDate($post->post_date) ?></p>
        </div>
</article>