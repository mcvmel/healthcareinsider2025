<?php
/**
 * Index (Blog) – lists all categories + posts
 * @package healthcareinsider2025
 */

// --- UTM for blog index ---
$idx_base_url = 'https://www.healthcare.com/mp2/healthcare-insurance/survey/?utm_source=hci';

// We’re on the blog index; treat slug as "blog" (or "home" if it's the front page)
$idx_slug      = is_front_page() ? 'home' : 'blog';
$idx_campaign  = 'all-categories';
$idx_utm_params = [
	'utm_medium'   => sanitize_title($idx_slug),
	'utm_campaign' => sanitize_title($idx_campaign),
	'utm_content'  => 'sidebar',
];
$idx_full_url = add_query_arg($idx_utm_params, $idx_base_url);

get_header();
?>

<main id="primary" class="site-main">

	<!-- Generic hero (no category/term usage) -->
	<section class="image-with-text image-with-text--right ice-swoop">
		<div class="container">
			<div class="image-with-text__inner">

				<div class="image-with-text__inner__image">
					<img
						src="<?php echo esc_url(get_template_directory_uri() . '/static/images/category-fallback.png'); ?>"
						alt="Health Care Articles" />
				</div>

				<div class="image-with-text__inner__content">
					<h1>Healthcare Articles</h1>
					<p>Browse our latest articles and explore categories below.</p>
				</div>

			</div>
		</div>
	</section>

	<section class="archive-content-container">
		<div class="container">
			<div class="archive-content">

				<div class="archive-content__filter">
					<div>
						<span class="small-heading">Categories</span>
						<ul class="archive-content__filter__ul" data-simplebar data-simplebar-auto-hide="false">
							<?php
							$idx_categories = get_categories([
								'orderby'     => 'name',
								'order'       => 'ASC',
								'hide_empty'  => false, // set true to show only categories with posts
							]);

							foreach ($idx_categories as $idx_cat) :
								$idx_cat_link = get_category_link($idx_cat->term_id);
								?>
								<li>
									<a href="<?php echo esc_url($idx_cat_link); ?>">
										<?php echo esc_html($idx_cat->name); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
					<div class="archive-content__filter__download">
						<span class="small-heading">Searching For Health Plans?</span>
						<p>Explore ACA Marketplace or Short-Term Medical Health Plans</p>
						<div class="btn-container">
							<a href="<?php echo esc_url($idx_full_url); ?>" class="btn btn--secondary">Find Plans</a>
						</div>
					</div>
				</div>

				<?php
				// Modify main query to exclude categories 3095 and 198
				query_posts(array_merge($wp_query->query, array(
					'cat' => '-3095,-198'
				)));
				?>

				<div class="archive-content__post-content">
					<?php if (have_posts()) : ?>
						<?php while (have_posts()) : the_post(); ?>
							<article class="article-card article-card--long">
								<a href="<?php the_permalink(); ?>" class="article-card__image">
									<?php the_post_thumbnail('medium'); ?>
									<?php
									$idx_post_cats = get_the_category();
									if (!empty($idx_post_cats)) : ?>
										<span class="article-card__image__category">
                                            <?php echo esc_html($idx_post_cats[0]->name); ?>
                                        </span>
									<?php endif; ?>
								</a>
								<div class="article-card__content">
									<div class="article-card__content__date"><?php echo get_the_date(); ?></div>
									<a class="article-card__content__title" href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
									<div class="article-card__content__excerpt"><?php the_excerpt(); ?></div>
									<a href="<?php the_permalink(); ?>" class="article-card__content__link">Read More</a>
								</div>
							</article>
						<?php endwhile; ?>
					<?php else : ?>
						<p>No results found.</p>
					<?php endif; ?>

					<nav class="pagination">
						<?php echo paginate_links([
							'prev_text' => '',
							'next_text' => '',
						]); ?>
					</nav>
				</div>

			</div>
		</div>
	</section>

</main>

<?php get_footer(); ?>
