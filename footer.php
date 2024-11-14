<footer>
    <div class="container">
        <div class="column third">
            <?php if (get_theme_mod('footer_logo')) : ?>
                <div class="footer-logo">
                    <img src="<?php echo esc_url(get_theme_mod('footer_logo')); ?>" alt="<?php bloginfo('name'); ?>">
                </div>
            <?php endif; ?>
        </div>
        <div class="column third">
        <?php wp_nav_menu(
					array(
						'theme_location' => 'main_menu',
                        'depth'=> 1,
					)
				); ?>
        </div>
        <div class="socialmedia">
                <?php
					if(get_theme_mod('socialmedia_url_facebook')){
						echo '<a href="'.get_theme_mod('socialmedia_url_facebook').'" target="_blank" title="Facebook" aria-label="Facebook"><i class="fab fa-facebook"></i></a>';
					}
					if(get_theme_mod('socialmedia_url_instagram')){
						echo '<a href="'.get_theme_mod('socialmedia_url_instagram').'" target="_blank" title="Instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>';
					}
					if(get_theme_mod('socialmedia_url_twitter')){
						echo '<a href="'.get_theme_mod('socialmedia_url_twitter').'" target="_blank" title="Twitter" aria-label="Twitter"><i class="fab fa-twitter"></i></a>';
					}
					if(get_theme_mod('socialmedia_url_telegram')){
						echo '<a href="'.get_theme_mod('socialmedia_url_telegram').'" target="_blank" title="Telegram" aria-label="Telegram"><i class="fab fa-telegram"></i></a>';
					}
				?>
                </div>
        </div>
        <div class="column third"></div>
    </div>
    <div class="bottom-line ta-center">
        <div class="container">
            Desenvolvido por Tiê.
        </div>
    </div>
    <?php wp_footer(); ?>
</footer>