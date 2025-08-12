<?php
$cats_selected = get_sub_field('categories'); // array of term IDs
?>

<?php if ($cats_selected): ?>
	<section class="categories-grid">
		<div class="container">
			<div class="categories-grid__inner">
				<ul class="categories-grid__inner__list">
					<?php foreach ($cats_selected as $cat_term_id):
						$cat_term = get_term($cat_term_id);
						if (!$cat_term || is_wp_error($cat_term)) continue;

						// ACF term key (works for 'category' and custom taxonomies)
						$acf_term_key = $cat_term->taxonomy . '_' . $cat_term->term_id;

						// Pull category_icon (may be ID | array | URL)
						$icon_raw = function_exists('get_field') ? get_field('category_icon', $acf_term_key) : '';
						$icon_url = '';
						$icon_alt = $cat_term->name;

						if (is_numeric($icon_raw)) {
							$icon_url = wp_get_attachment_image_url((int)$icon_raw, 'thumbnail') ?: wp_get_attachment_image_url((int)$icon_raw, 'full');
							$alt_meta = get_post_meta((int)$icon_raw, '_wp_attachment_image_alt', true);
							if (!empty($alt_meta)) $icon_alt = $alt_meta;
						} elseif (is_array($icon_raw)) {
							// Prefer thumbnail size if available
							if (!empty($icon_raw['sizes']['thumbnail'])) {
								$icon_url = $icon_raw['sizes']['thumbnail'];
							} elseif (!empty($icon_raw['url'])) {
								$icon_url = $icon_raw['url'];
							}
							if (!empty($icon_raw['alt'])) {
								$icon_alt = $icon_raw['alt'];
							}
						} elseif (is_string($icon_raw)) {
							$icon_url = $icon_raw;
						}
						?>
						<li class="categories-grid__inner__list__item white-card">
							<a href="<?php echo esc_url(get_term_link($cat_term)); ?>">
                            <span class="categories-grid__inner__list__item__icon">
                                <?php if (!empty($icon_url)) : ?>
									<img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($icon_alt); ?>" />
								<?php endif; ?>
                            </span>
								<span class="categories-grid__inner__list__item__name">
                                <?php echo esc_html($cat_term->name); ?>
                            </span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>
<?php endif; ?>
