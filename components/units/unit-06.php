<?php
setup_postdata($post);
?>
<article class="unit-06">
    <div class="column">
        <div class="meta">
            <a class="sup-category" href="<?=  get_category_link(wp_get_post_categories($post->ID)[0]) ?>"><?= escape_categories(wp_get_post_categories($post->ID)); ?></a>
        </div>
        <a href="<?= get_the_permalink($post); ?>" title="<?= get_the_title($post); ?>" arial-label="<?= get_the_title($post); ?>">
            <h4><?= get_the_title($post); ?></h4>
        </a>
    </div>
</article>