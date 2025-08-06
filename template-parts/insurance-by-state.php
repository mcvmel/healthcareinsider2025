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
            <div class="insurance-by-state__inner__disclaimer">
                <p class="small-note">You will be taken to</p> <img src="<?php echo get_template_directory_uri(); ?>/static/images/healthcaredotcomlogowhite.png" alt="Healthcare.com" style="display: inline-block; margin: 0; max-height: 20px;
 width: auto;"> <p class="small-note">to finish your submission.</p>
            </div>
        </div>
    </div>
</section>
