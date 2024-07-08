<?php
setup_postdata($post);
?>
<article class="unit-06">
    <div class="column">
        <div class="meta">
            <span class="sup-category"><?= escape_categories(wp_get_post_categories($post->ID)); ?></span>
        </div>
        <a href="<?= get_the_permalink($post); ?>" title="<?= get_the_title($post); ?>" arial-label="<?= get_the_title($post); ?>">
            <h4><?= get_the_title($post); ?></h4>
        </a>
    </div>
</article>