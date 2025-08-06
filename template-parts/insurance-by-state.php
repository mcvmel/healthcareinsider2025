<?php
$size = get_sub_field('size'); // 'small' or 'large'
$text = get_sub_field('text');
$form_shortcode = get_sub_field('form_shortcode');
?>

<section class="insurance-by-state<?php echo $size ? ' insurance-by-state--' . esc_attr($size) : ''; ?>">
    <div class="container">
        <div class="insurance-by-state__inner">
            <?php if ($text): ?>
                <div class="insurance-by-state__inner__text">
                    <?php echo $text; ?>
                </div>
            <?php endif; ?>

            <?php if ($form_shortcode): ?>
                <div class="insurance-by-state__inner__form">
                    <?php echo do_shortcode($form_shortcode); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
