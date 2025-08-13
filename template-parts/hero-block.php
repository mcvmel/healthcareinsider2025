<?php
$hero_image = get_sub_field('image');
$hero_text = get_sub_field('text');
$hero_form_shortcode = get_sub_field('form_shortcode');
?>

<section class="hero-block">
	<div class="container">
		<div class="hero-block__inner">
			<div class="hero-block__inner__left" data-aos="fade" data-aos-delay="100">
				<?php if ($hero_image): ?>
					<div class="hero-block__inner__left__image">
						<?php
						$id      = $hero_image['ID'];
						$alt     = isset($hero_image['alt']) ? $hero_image['alt'] : '';
						$mobile  = wp_get_attachment_image_src( $id, 'medium' ); // ~768px
						$desktop = wp_get_attachment_image_src( $id, 'full' );         // full size
						?>
						<picture>
							<source media="(max-width: 768px)" srcset="<?php echo esc_url( $mobile[0] ); ?>">
							<img
								src="<?php echo esc_url( $desktop[0] ); ?>"
								alt="<?php echo esc_attr( $alt ); ?>"
								width="<?php echo esc_attr( $desktop[1] ); ?>"
								height="<?php echo esc_attr( $desktop[2] ); ?>"
								loading="lazy"
								decoding="async"
							>
						</picture>
					</div>
				<?php endif; ?>
			</div>
			<div class="hero-block__inner__right" data-aos="fade-left" data-aos-delay="20">
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
				<div class="hero-block__inner__right__disclaimer">
					<p class="small-note">You will be taken to</p> <img src="<?php echo get_template_directory_uri(); ?>/static/images/healthcaredotcomlogo.png" alt="Healthcare.com" style="display: inline-block; margin: 0; max-height: 20px;
 width: auto;"> <p class="small-note">to finish your submission.</p>
				</div>
			</div>
		</div>
	</div>
</section>
