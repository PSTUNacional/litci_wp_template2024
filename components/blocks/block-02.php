<section>
    <div class="container">
        <div class="column">
            <div class="block-header">
                <?php if ($block_title) { ?>
                    <h3><?= $block_title ?></h3>
                <?php } ?>
                <a class="see-more">Veja mais</a>
            </div>
            <div class="block-02">
                <?php
                for ($i = 0; $i < 4; $i++) {
                    if (isset($posts[$i])) {
                        $post = $posts[$i];
                        include __DIR__ . '/../units/unit-02.php';
                    };
                }
                ?>
            </div>
        </div>
    </div>
</section>