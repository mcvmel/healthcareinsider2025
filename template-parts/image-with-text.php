<?php
$image = get_sub_field('image');
$text = get_sub_field('text');
$link = get_sub_field('link');
$image_position = get_sub_field('image_position');
?>

<section class="image-with-text image-with-text--<?php echo esc_attr($image_position); ?>">
    <div class="container">
        <div class="image-with-text__inner">

            <div class="image-with-text__inner__image" data-aos="fade" data-aos-delay="100">
                <?php if ( $image ) :
                    $id      = $image['ID'];
                    $alt     = isset( $image['alt'] ) ? $image['alt'] : '';
                    $mobile  = wp_get_attachment_image_src( $id, 'medium' ); // ~768px
                    $desktop = wp_get_attachment_image_src( $id, 'full' );   // full size
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
                <?php endif; ?>
            </div>

            <div class="image-with-text__inner__content" data-aos="fade" data-aos-delay="300">
                <?php echo $text; ?>

                <?php if ($link): ?>
                    <div class="btn-container btn-container--left">
                        <a href="<?php echo esc_url($link['url']); ?>" class="btn"<?php if ($link['target']) echo ' target="' . esc_attr($link['target']) . '"'; ?>>
                            <?php echo esc_html($link['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
