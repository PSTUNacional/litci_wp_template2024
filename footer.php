<footer>
    <div class="container">
        <div class="column quarter">
            <?php if (get_theme_mod('footer_logo')) : ?>
                <div class="footer-logo">
                    <img src="<?php echo esc_url(get_theme_mod('footer_logo')); ?>" alt="<?php bloginfo('name'); ?>">
                </div>
            <?php endif; ?>
        </div>
        <div class="column quarter"></div>
        <div class="column quarter"></div>
        <div class="column quarter"></div>
    </div>
    <div class="bottom-line ta-center">
        <div class="container">
            Desenvolvido por Tiê.
        </div>
    </div>
    <?php wp_footer(); ?>
</footer>