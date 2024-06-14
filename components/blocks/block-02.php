<section>
    <div class="container">
        <div class="column">
        <div class="block-header">
            <h3>Últimas notícias</h3>
            <a class="see-more">Veja mais</a>
        </div>
        <div class="block-02">
            <?php
            foreach($posts as $post)
            {
                include __DIR__ . '/../units/unit-02.php'; 
            } 
            ?>
        </div>
        </div>
    </div>
</section>