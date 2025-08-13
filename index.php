<?php
/**
 * Index (Blog) – lists all categories + posts
 * @package healthcareinsider2025
 */

// --- UTM for blog index ---
$idx_base_url = 'https://www.healthcare.com/healthcare-insurance/survey/?utm_source=hci';

// Determine the relevant page ID (front page or posts page on blog index)
if ( is_front_page() ) {
	$idx_page_id = (int) get_option( 'page_on_front' );
} elseif ( is_home() ) {
	$idx_page_id = (int) get_option( 'page_for_posts' );
} else {
	$idx_page_id = 0;
}

// Current path + last segment (works on blog index/home too)
$req_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
$path    = trim( wp_parse_url( home_url( $req_uri ), PHP_URL_PATH ), '/' );
$segment = $path ? basename( $path ) : ( is_front_page() ? 'home' : 'blog' );

// First four “words” from the segment
$words      = preg_split( '/[^a-z0-9]+/i', (string) $segment, -1, PREG_SPLIT_NO_EMPTY );
$first_four = array_slice( $words, 0, 4 );
$base_slug  = strtolower( implode( '-', $first_four ) );

// Fallback if empty
if ( $base_slug === '' ) {
	$base_slug = is_front_page() ? 'home' : 'blog';
}

$idx_utm_medium = $base_slug . '-' . $idx_page_id;

// Campaign & content
$idx_campaign   = 'all-categories';
$idx_utm_params = array(
	'utm_medium'   => $idx_utm_medium,
	'utm_campaign' => sanitize_title( $idx_campaign ),
	'utm_content'  => 'sidebar',
);

$idx_full_url = add_query_arg( $idx_utm_params, $idx_base_url );

get_header();
?>

<main id="primary" class="site-main">

	<!-- Generic hero (no category/term usage) -->
	<section class="image-with-text image-with-text--right ice-swoop">
		<div class="container">
			<div class="image-with-text__inner">

				<div class="image-with-text__inner__image" data-aos="fade-left" data-aos-delay="100">
					<img
						src="<?php echo esc_url(get_template_directory_uri() . '/static/images/category-fallback.png'); ?>"
						alt="Healthcare Articles" />
				</div>

				<div class="image-with-text__inner__content" data-aos="fade" data-aos-delay="300">
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
