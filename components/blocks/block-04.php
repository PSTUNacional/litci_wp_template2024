<section>
    <div class="container">
        <div class="block-header">
            <h3>Últimas notícias</h3>
            <a class="see-more">Veja mais</a>
        </div>
        <div class="block-04">
            <div class="featured">
                <?php
                $post = $posts[0];
                include __DIR__ . '/../units/unit-03.php';
                ?>
            </div>
            <div class="grid">
                <?php
                $i = 1;
                for ($i = 1; $i < 5; $i++) {
                    $post = $posts[$i];
                    include __DIR__ . '/../units/unit-04.php';
                }
                ?>
            </div>
        </div>
    </div>
</section>