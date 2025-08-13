<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package healthcareinsider2025
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="single-hero">
			<div class="container">
				<div class="single-hero__inner">
					<h1 class="h2">
						<?php
						/* translators: %s: search query. */
						printf(esc_html__('Looks like that page can\'t be found. %s', 'healthcareinsider2025'), '<p style="margin-top: 20px;">Why not try a search?</p><span>' . get_search_query() . '</span>');
						?>
					</h1>
					<?php get_search_form(); ?>
				</div>
			</div>
		</section>

	</main><!-- #main -->

<?php
get_footer();
