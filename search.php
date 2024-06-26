<?php
/*
Template Name: Search Page
*/
?>
<?php
get_header(); ?>

<div class="content-area">
	<main>
		<div class="container">
			<div class="category-title">
				<?php custom_breadcrumbs() ?>
				<h1><?php
					/* translators: %s: search query. */
					printf(esc_html__('Resutlados para: %s', 'litci_theme'), '<span>' . get_search_query() . '</span>');
					?></h1>
			</div>
		</div>
		<div class="container result-list">
			<?php
			/* Start the Loop */
			if (have_posts()) {
				while (have_posts()) {
					the_post();
					include get_template_directory() . '/components/units/unit-02.php';
				}
				$big = 999999999;
				$pagination = paginate_links(array(
					'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
					'format'    => '?paged=%#%',
					'current'   => max(1, get_query_var('paged')),
					'total'     => $wp_query->max_num_pages,
					'mid_size'  => 2,
					'prev_text' => __('Anterior', 'litci_theme'),
					'next_text' => __('Próxima', 'litci_theme'),
					'type'      => 'array',
				));
				if (!empty($pagination)) {
					echo '<nav class="custom-pagination">';
					echo '<ul>';
					foreach ($pagination as $page_link) {
						echo '<li>' . $page_link . '</li>';
					}
					echo '</ul>';
					echo '</nav>';
				}
			} else {
				printf(esc_html__('Nenhum resultado encontrado =/'));
			}

			?>
		</div>
	</main>
</div>

<?php get_footer();
