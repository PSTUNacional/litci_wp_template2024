<?php
setup_postdata($post);
?>
<a href="<?= get_the_permalink($post); ?>" title="<?= get_the_title($post); ?>" arial-label="<?= get_the_title($post); ?>">
    <article class="unit-03">
        <img class="featured-image-container" src="<?=get_the_post_thumbnail_url($post->ID, 'large');?>"/>
        <div class="info">
            <h3><?= get_the_title($post); ?></h3>
            <div class="excerpt"><?= get_the_excerpt($post); ?></div>
            <div class="meta">
                <span class="sup-category" ><?= escape_categories(wp_get_post_categories($post->ID)); ?></span>
                <p class="post-date"><?= formatDate($post->post_date) ?></p>
            </div>
        </div>

    </article>
</a>
