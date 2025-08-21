<section style="background-color:
    <?= isset($attributes['backgroundColor']) ? $attributes['backgroundColor'] : 'inherit' ?>" class="<?= isset($attributes['isDark']) ? 'dark' : '' ?>">
    <div class="container">
        <div class="column">
            <div class="block-header">
                <?php if (isset($block_title)) { ?>
                    <h3><?= $block_title ?></h3>
                <?php }
                if (isset($attributes['blockCategories'][0])) {
                ?>
                    <a class="see-more" href="<?= get_category_link($attributes['blockCategories'][0]) ?>">Veja mais</a>
                <?php } ?>
            </div>
            <div class="block-partners">
                <a href="https://cfriazanov.org/" target="_blank" class="card">
                    <img src="https://litci.org/pt/wp-content/uploads/2022/05/riazanov-e1653342282850-300x168.png" alt="Escola Davi Riazanov">
                </a>
                <a href="https://archivoleontrotsky.org/" target="_blank" class="card">
                    <img src="https://litci.org/pt/wp-content/uploads/2022/06/archivo-3-e1654633929865-300x168.png" alt="Archivo Leon Trostky">
                </a>
                <a href="https://marxismovivo.litci.org/" target="_blank" class="card">
                    <img src="https://litci.org/pt/wp-content/uploads/2022/05/marxismo-vivo-e1653342337533-300x168.png" alt="Marxismo Vivo">
                </a>
            </div>
        </div>
    </div>
</section>