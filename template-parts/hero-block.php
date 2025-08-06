<?php
$hero_image = get_sub_field('image');
$hero_text = get_sub_field('text');
$hero_form_shortcode = get_sub_field('form_shortcode');
?>

<section class="hero-block">
	<div class="container">
		<div class="hero-block__inner">
			<div class="hero-block__inner__left">
				<?php if ($hero_image): ?>
					<div class="hero-block__inner__left__image">
						<img src="<?php echo esc_url($hero_image['url']); ?>" alt="<?php echo esc_attr($hero_image['alt']); ?>">
					</div>
				<?php endif; ?>
			</div>
			<div class="hero-block__inner__right">
				<?php if ($hero_text): ?>
					<div class="hero-block__inner__right__text">
						<?php echo $hero_text; ?>
					</div>
				<?php endif; ?>

				<?php if ($hero_form_shortcode): ?>
					<div class="hero-block__inner__right__form">
						<?php echo do_shortcode($hero_form_shortcode); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
