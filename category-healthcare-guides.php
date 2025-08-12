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
						<h1><?php echo esc_html($term->name); ?></h1>
						<?php if (!empty($term->description)) : ?>
							<?php echo wp_kses_post(wpautop($term->description)); ?>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</section>


		<section class="search-results search-results--author">
			<div class="container">
				<div class="search-results__grid">
					<?php if (have_posts()) :
						/* Start the Loop */
						while (have_posts()) :
							the_post(); ?>
							<article class="article-card">
								<a href="<?php the_permalink(); ?>" class="article-card__image article-card__image--hc-guide">
									<?php the_post_thumbnail('medium'); ?>
									<?php
									$category = get_the_category();
									if ($category):
										?>
									<?php endif; ?>
								</a>
							</article>
						<?php endwhile;
					else :?>
						<p>No results found.</p>
					<?php endif; ?>
				</div>
			</div>
		</section>



	</main><!-- #main -->

<?php
get_footer();
