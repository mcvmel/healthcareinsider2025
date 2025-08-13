<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package healthcareinsider2025
 */
$term = get_queried_object();
$image = get_field('category_featured_image', 'category_' . $term->term_id);


$base_url = 'https://www.healthcare.com/mp2/healthcare-insurance/survey/?utm_source=hci';

// Get slug for utm_medium
$slug = '';
if (is_singular()) {
	$slug = get_post_field('post_name', get_post());
} elseif (is_category() || is_tag() || is_tax()) {
	$term = get_queried_object();
	$slug = $term->slug;
} elseif (is_post_type_archive()) {
	$slug = get_post_type();
} elseif (is_home() || is_front_page()) {
	$slug = 'home';
}

// Get archive name for utm_campaign
$archive_name = '';
if (is_category() || is_tag() || is_tax()) {
	$archive_name = $term->name ?? '';
} elseif (is_post_type_archive()) {
	$archive_name = post_type_archive_title('', false);
} elseif (is_home() || is_front_page()) {
	$archive_name = 'Home';
} elseif (is_singular()) {
	$archive_name = get_the_title();
}

// Build UTM params
$utm_params = [
	'utm_medium'   => sanitize_title($slug),
	'utm_campaign' => sanitize_title($archive_name),
	'utm_content'  => 'sidebar'
];

// Full URL
$full_url = add_query_arg($utm_params, $base_url);

// Current archive term (category/tag/custom taxonomy)
$qo = get_queried_object();

// Build ACF context key for taxonomy terms: "{$taxonomy}_{$term_id}"
$acf_key = (isset($qo->taxonomy, $qo->term_id)) ? "{$qo->taxonomy}_{$qo->term_id}" : '';

// Get the selected posts from ACF (may return IDs or post objects)
$featured = $acf_key ? get_field('featured_category_posts', $acf_key) : [];

// Normalize to an array of post IDs
$featured_ids = [];
if (is_array($featured)) {
	foreach ($featured as $item) {
		if (is_object($item) && isset($item->ID)) {
			$featured_ids[] = (int) $item->ID;
		} elseif (is_numeric($item)) {
			$featured_ids[] = (int) $item;
		}
	}
}
// Only show up to 3
$featured_ids = array_slice(array_unique($featured_ids), 0, 3);

get_header();
?>

	<main id="primary" class="site-main">


		<section class="image-with-text image-with-text--right ice-swoop">
			<div class="container">
				<div class="image-with-text__inner">

					<div class="image-with-text__inner__image">
						<?php if (!empty($image) && is_array($image)) : ?>
							<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?: $term->name); ?>">
						<?php else : ?>
							<img src="<?php echo esc_url(get_template_directory_uri() . '/static/images/category-fallback.png'); ?>" alt="<?php echo esc_html($term->name); ?>" />
						<?php endif; ?>
					</div>

					<div class="image-with-text__inner__content">
						<span class="image-with-text__inner__content__breadcrumb"><img src="<?php echo get_template_directory_uri(); ?>/static/images/left-caret.png"
								   alt="left caret"><a href="/healthcare-articles/">Back To Health Care Articles</a></span>
						<h1><?php echo esc_html($term->name); ?></h1>
						<?php if (!empty($term->description)) : ?>
							<?php echo wp_kses_post(wpautop($term->description)); ?>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</section>


		<section class="archive-content-container">
			<div class="container">
				<div class="archive-content">
					<div class="archive-content__filter">
						<div>
							<span class="small-heading">More Categories</span>
							<ul class="archive-content__filter__ul" data-simplebar data-simplebar-auto-hide="false">
								<?php
								$categories = get_categories([
									'orderby' => 'name',
									'order'   => 'ASC',
									'hide_empty' => false, // set to true if you only want categories with posts
								]);

								foreach ($categories as $cat) :
									$cat_link = get_category_link($cat->term_id);
									?>
									<li>
										<a href="<?php echo esc_url($cat_link); ?>">
											<?php echo esc_html($cat->name); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="archive-content__filter__download">
							<span class="small-heading">Searching For Health Plans?</span>
							<p>Explore ACA Marketplace or Short-Term Medical Health Plans</p>
							<div class="btn-container">
								<a href="<?php echo esc_url($full_url); ?>" class="btn btn--secondary">Find Plans</a>
							</div>
						</div>
					</div>

					<div class="archive-content__post-content">

						<?php if (!empty($featured_ids)) : ?>
							<div class="archive-featured__grid">
								<?php
								$orig_post = $post; // preserve
								foreach ($featured_ids as $pid) :
									$post = get_post($pid);
									if (!$post) { continue; }
									setup_postdata($post);
									?>
									<article class="article-card">
										<a href="<?php the_permalink(); ?>" class="article-card__image">
											<?php
											if (has_post_thumbnail()) {
												the_post_thumbnail('medium');
											}
											$category = get_the_category();
											if (!empty($category)) : ?>
												<span class="article-card__image__category article-card__image__category--featured"><img src="<?php echo get_template_directory_uri(); ?>/static/images/icon-star.png"
																								 alt="left caret"> Featured</span>
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
								<?php endforeach;
								// reset
								$post = $orig_post;
								wp_reset_postdata();
								?>
							</div>
						<?php endif; ?>

						<?php if (have_posts()) :
							/* Start the Loop */
							while (have_posts()) :
								the_post(); ?>
								<article class="article-card article-card--long">
									<a href="<?php the_permalink(); ?>" class="article-card__image">
										<?php the_post_thumbnail('medium'); ?>
									</a>
									<div class="article-card__content">
										<div class="article-card__content__date"><?php echo get_the_date(); ?></div>
										<a class="article-card__content__title"
										   href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
										<div class="article-card__content__excerpt"><?php the_excerpt(); ?></div>
										<a href="<?php the_permalink(); ?>" class="article-card__content__link">Read
											More</a>
									</div>
								</article>
							<?php endwhile;
						else :?>
							<p>No results found.</p>
						<?php endif; ?>


						<nav class="pagination">
							<?php echo paginate_links(array(
								'prev_text' => '',
								'next_text' => '',
							)); ?>
						</nav>

					</div>
				</div>
			</div>
		</section>



	</main><!-- #main -->

<?php
get_footer();
