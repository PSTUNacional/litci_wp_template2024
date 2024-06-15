<?php

get_header();

if (have_posts()) {
    while (have_posts()) {
        the_post();
        $categories = get_the_category();
        $categoriesArr = [];
        foreach ($categories as $a) {
            array_push($categoriesArr, $a->name);
        }
        $profile = get_avatar_url($post->post_author);
    }
}
?>

<div class="content-area">
    <main>
        <div class="container">
            <article class="post" id=<?= $post->ID ?>>
                <div class="container">
                    <div class="post-categories">
                        <span><?= $categories[0]->name; ?></span>
                    </div>
                    <h1><?php the_title(); ?></h1>
                    <h3 class="tagline">
                        <?php
                        $tagline = get_post_meta($post->ID, 'post_tagline', true);
                        if (!$tagline == '') {
                            echo $tagline;
                        }
                        ?>
                    </h3>
                </div>

                <div class="thumbnail-container">
                    <?= the_post_thumbnail() ?>
                    <div class="caption">
                        <?= the_post_thumbnail_caption(); ?>
                    </div>
                </div>

                <!-- Author Box -->
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
                                echo the_author_meta('display_name', $post->post_author);
                                if (get_the_author_meta('description') !== '') {
                                    echo '<span style="font-weight:300">, ' . get_the_author_meta('description') . '</span>';
                                }
                                ?>
                            </h4>
                            <span><?= get_the_date() ?></span>
                        </div>
                    </div>
                    <div class="socialmedia">
                        <a href="whatsapp://send?text=<?= the_title(); ?>%0A%0A<?= get_permalink(); ?>" data-action="share/whatsapp/share" class="wa share" target="_blank"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://www.facebook.com/sharer.php?u=<?= urlencode(get_permalink()); ?>" class="fb share" target="_blank"> <i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?text=<?= urlencode(the_title()); ?>&url=<?= get_permalink(); ?>%0A%0A&via=opiniaosocialista" class="tw share" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <!-- Content -->
                <div class="container" id="post-content">
                    <?php the_content(); ?>
                </div>
            </article>
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