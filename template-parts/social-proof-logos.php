<?php
$label = get_sub_field('label_text');
$logos = get_sub_field('logos'); // ACF Gallery field
?>

<?php if ($logos): ?>
	<section class="social-proof">
		<div class="container">
			<div class="social-proof__inner" data-aos="fade" data-aos-delay="10">
				<?php if ($label): ?>
					<p class="social-proof__inner__label"><?php echo esc_html($label); ?></p>
				<?php endif; ?>

				<ul class="social-proof__inner__logos">
					<?php foreach ($logos as $logo): ?>
						<li class="social-proof__inner__logos__item">
							<?php if (!empty($logo['url'])): ?>
								<img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt'] ?? ''); ?>" loading="lazy" />
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</section>
<?php endif; ?>
