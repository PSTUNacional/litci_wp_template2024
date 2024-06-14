<section>
    <div class="container">
        <div class="column">
            <div class="block-header">
                <h3>Últimas notícias</h3>
                <a class="see-more">Veja mais</a>
            </div>
            <div class="block-03">
                <div class="column quarter">
                    <?php
                    $post = $posts[0];
                    include __DIR__ . '/../units/unit-02.php';
                    ?>
                </div>
                <div class="column half">
                    <?php
                    $post = $posts[1];
                    include __DIR__ . '/../units/unit-03.php';
                    ?>
                </div>
                <div class="column quarter">
                    <?php
                    $post = $posts[2];
                    include __DIR__ . '/../units/unit-04.php';

                    $post = $posts[3];
                    include __DIR__ . '/../units/unit-04.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>