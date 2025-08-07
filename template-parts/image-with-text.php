<?php
$image = get_sub_field('image');
$text = get_sub_field('text');
$link = get_sub_field('link');
$image_position = get_sub_field('image_position');
?>

<section class="image-with-text image-with-text--<?php echo esc_attr($image_position); ?>">
    <div class="container">
        <div class="image-with-text__inner">

            <div class="image-with-text__inner__image">
                <?php if ($image): ?>
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                <?php endif; ?>
            </div>

            <div class="image-with-text__inner__content">
                <?php echo $text; ?>

                <?php if ($link): ?>
                    <div class="btn-container">
                        <a href="<?php echo esc_url($link['url']); ?>" class="btn"<?php if ($link['target']) echo ' target="' . esc_attr($link['target']) . '"'; ?>>
                            <?php echo esc_html($link['title']); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
