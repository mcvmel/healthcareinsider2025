<?php
// Get ACF fields
$text    = get_sub_field('text');
$link    = get_sub_field('link');
$card    = get_sub_field('card'); // Button Group field

// Link fallbacks
$link_url    = isset($link['url']) ? $link['url'] : '';
$link_title  = isset($link['title']) ? $link['title'] : '';
$link_target = isset($link['target']) ? $link['target'] : '_self';

// Conditional card classes
$card_classes = '';
if ($card === 'yes') {
    $card_classes = ' white-card white-card--no-hover';
}
?>

<section class="simple-cta">
    <div class="simple-cta__inner<?php echo $card_classes; ?>">
        <?php if ($text) :
            echo $text;
        endif; ?>

        <?php if ($link_url && $link_title) : ?>
            <div class="btn-container">
                <a class="btn" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                    <?php echo esc_html($link_title); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
