<?php
?>
<section>
    <div class="block-01">
        <div class="container">
            <?php
                $post = $posts[0];
                setup_postdata($post);
                include __DIR__ . '/../units/unit-01.php'; 
            ?>
        </div>
    </div>
</section>