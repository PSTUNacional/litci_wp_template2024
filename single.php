<?php

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        $categories = get_the_category();
        $categoriesArr = [];
        $categories_id = [];
        foreach ($categories as $a) {
            array_push($categoriesArr, $a->name);
            $categories_id[] = $a->term_id;
        }
        $profile = get_avatar_url($post->post_author);
        $tags = get_the_tags();
        $post_id = get_the_ID();
    }
}

?>

<div class="content-area">
    <main>
        <div class="container">
            <div class="column">
                <article class="post" id=<?= $post->ID ?>>
                    <div class="container">
                        <div class="post-categories">
                            <span><?= $categories[0]->name; ?></span>
                        </div>
                        <h1><?php the_title(); ?></h1>
                        <?php
                        $tagline = get_post_meta(get_the_ID(), 'litci_post_tagline', true);
                        if ($tagline) { ?>
                            <h3 class="tagline"><?= $tagline ?></h3>
                        <?php }
                        ?>
                        <div class="socialmedia">
                            <a href="whatsapp://send?text=<?= the_title(); ?>%0A%0A<?= get_permalink(); ?>" data-action="share/whatsapp/share" class="wa share" target="_blank"><i class="fab fa-whatsapp"></i></a>
                            <a href="https://www.facebook.com/sharer.php?u=<?= urlencode(get_permalink()); ?>" class="fb share" target="_blank"> <i class="fab fa-facebook-f"></i></a>
                            <a href="https://twitter.com/intent/tweet?text=<?= urlencode(get_the_title()); ?>&url=<?= get_permalink(); ?>%0A%0A&via=litci" class="tw share" target="_blank"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>

                    <div class="thumbnail-container">
                        <?= the_post_thumbnail() ?>
                        <div class="caption">
                            <?= the_post_thumbnail_caption(); ?>
                        </div>
                    </div>

                    <?php
                    $political_author = get_post_meta(get_the_ID(), 'litci_post_political_author', true);

                    // Verifica se o valor existe e não está vazio antes de exibi-lo
                    if (! empty($political_author)) {
                    ?>
                        <div class="metainfo container">
                            <div class="author-box">
                                <div class="author-avatar" style="background-image:url('<?= $profile ?>')">
                                    <?php
                                    if (!$profile) { ?>
                                        <i class="fa fa-user"></i>
                                    <?php } ?>
                                </div>
                                <div class="info">
                                    <h4 class="author-line">
                                        <?php
                                        echo $political_author;
                                        ?>
                                    </h4>
                                    <span><?= get_the_date() ?></span>
                                </div>
                            </div>
                        </div>
                    <?php
                    } else { ?>
                        <div class="container" style="margin-bottom:24px">
                            <span style="margin-bottom:24px"><?= get_the_date() ?></span>
                            <hr />
                        </div>
                    <?php
                    }
                    ?>

                    <!-- Content -->
                    <div class="container" id="post-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
                $tags_id = array();
                if (is_array($tags) || is_object($tags)) {
                    foreach ($tags as $tag) {
                        $tags_id[] = $tag->term_id;
                    }
                }

                $args = array(
                    'tags__in'  => $tags_id,
                    'category__in' => $categories_id,
                    'post__not_in' => array($post_id),
                    'posts_per_page' => 4,
                    'ignore_sticky_posts' => 1
                );

                $related_posts = new WP_Query($args);

                ?>
                <div class="block-header">
                    <h3><?= _e('Read also', 'litci') ?></h3>
                </div>
                <div class="related-posts">
                    <?php

                    if ($related_posts->have_posts()) {
                        while ($related_posts->have_posts()) {
                            $related_posts->the_post();
                            include get_template_directory() . '/components/units/unit-04.php';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    let getPostInfo = () => {
        return ({
            id: "<?= get_the_ID() ?>",
            type: "<?= get_post_type() ?>",
            category: <?= json_encode($categoriesArr) ?>,
            origin: document.referrer
        })
    }
</script>
<?php get_footer(); ?>