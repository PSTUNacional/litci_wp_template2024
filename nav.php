<header>
	<section class="top-bar">
		<div class="container">
			<i class="hamb fa fa-bars" onclick="openMobileMenu()"></i>
			<div class="custom-logo">
				<?php
				if (function_exists('the_custom_logo')) {
					the_custom_logo();
				}
				?>
			</div>
			<div class="search-icon mobile" onclick="openSearch()">
				<i class="material-icons">search</i>
			</div>
		</div>
	</section>

	<section class="lang-menu">
		<div class="container">
			<?php wp_nav_menu(
				array(
					'theme_location' => 'top_menu'
				)
			); ?>
		</div>
	</section>

	<section class="menu-area">
		<div class="container">
			<div class="custom-logo">
				<?php
				if (function_exists('the_custom_logo')) {
					the_custom_logo();
				}
				?>
			</div>
			<nav class="main-menu">
				<?php wp_nav_menu(
					array(
						'theme_location' => 'main_menu'
					)
				); ?>
				<div class="mobile">
					<hr />
					<ul>
						<li><a href="colabore" targe="_blank"><?= __('Envie sua matéria') ?></a></li>
						<li><a href="https://www.opiniaosocialista.com.br/contribua/?utm_source=opiniao&utm_medium=navmenu&campaign=regular" target="_blank"><?= __('Venha para LIT-QI'); ?></a></li>
					</ul>
					<hr />
					<p style="padding-left:24px;">Siga a <b>LIT-QI</b></p><br />
					<div class="social-media" style="padding-left:24px;">
						<a href="https://www.facebook.com/opiniaosocialista" target="_blank" title="Facebook" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
						<a href="https://www.instagram.com/opiniaosocialista/" target="_blank" title="Instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
						<a href="https://twitter.com/opsocialista" target="_blank" title="X / Twitter" aria-label="X/Twitter"><i class="fab fa-twitter"></i></a>
						<a target="_blank" href="https://t.me/JornalOpiniaoSocialistaPSTU"><i class="fab fa-telegram"></i></a>
					</div>
				</div>
			</nav>
			<div class="socialmedia">
				<?php
				if (get_theme_mod('socialmedia_url_facebook')) {
					echo '<a href="' . get_theme_mod('socialmedia_url_facebook') . '" target="_blank" title="Facebook" aria-label="Facebook"><i class="fab fa-facebook"></i></a>';
				}
				if (get_theme_mod('socialmedia_url_instagram')) {
					echo '<a href="' . get_theme_mod('socialmedia_url_instagram') . '" target="_blank" title="Instagram" aria-label="Instagram"><i class="fab fa-instagram"></i></a>';
				}
				if (get_theme_mod('socialmedia_url_twitter')) {
					echo '<a href="' . get_theme_mod('socialmedia_url_twitter') . '" target="_blank" title="Twitter" aria-label="Twitter"><i class="fab fa-twitter"></i></a>';
				}
				if (get_theme_mod('socialmedia_url_telegram')) {
					echo '<a href="' . get_theme_mod('socialmedia_url_telegram') . '" target="_blank" title="Telegram" aria-label="Telegram"><i class="fab fa-telegram"></i></a>';
				}
				?>
			</div>
			<div class="search-icon desktop" onclick="openSearch()">
				<i class="material-icons">search</i>
			</div>
			<div class="backdrop" onclick="openMobileMenu()"></div>
		</div>
		<div class="menu-search-bar">
			<div class="bar">
			<div class="container">
				<?php get_search_form(); ?>
			</div>
			</div>
			<div class="search-backdrop" onclick="openSearch()"></div>
		</div>
	</section>
</header>