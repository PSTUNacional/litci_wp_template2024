<?php get_header(); ?>
<div class="content-area">
    <main>

        <?php include(__DIR__ . '/components/blocks/block_01.php'); ?>


        <?php
        $args = array('numberposts' => 4, 'offset' => 5, 'category__not_in' => array(50), 'tag__not_in' => array(5));
        $posts = get_posts($args);
        include(__DIR__ . '/components/block_01.php');
        ?>

        <?php
        include(__DIR__ . '/components/opinion_block_01.php');
        ?>

    </main>
</div>

<?php get_footer(); ?>