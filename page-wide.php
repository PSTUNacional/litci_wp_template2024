<?php
/*
Template Name: Wide
*/

get_header(); 
?>
<?php
$featured_ids = [];
?>
<div class="content-area">
    <main>
        <div class="column" style="gap:0">
            <?php
                if (have_posts()) {
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                }
            ?>
        </div>
    </main>
</div>

<?php get_footer(); ?>