<?php
$categories = get_sub_field('categories'); // array of term IDs
?>

<?php if ($categories): ?>
	<section class="categories-grid">
		<div class="container">
			<div class="categories-grid__inner">
				<ul class="categories-grid__inner__list">
					<?php foreach ($categories as $term_id):
						$term = get_term($term_id);
						if (!$term || is_wp_error($term)) continue;
						?>
						<li class="categories-grid__inner__list__item white-card">
							<a href="<?php echo esc_url(get_term_link($term)); ?>">
								<span class="categories-grid__inner__list__item__icon"></span>
								<span class="categories-grid__inner__list__item__name"><?php echo esc_html($term->name); ?></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>
<?php endif; ?>
