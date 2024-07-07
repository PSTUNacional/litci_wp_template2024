<?php get_header(); ?>
<?php
$featured_ids = [];
?>
<div class="content-area">
    <main>
            <div class="column">
                <?php if (have_posts()) : while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
        </div>
    </main>
</div>

<?php get_footer(); ?>