<?php
$text = get_sub_field('text');
$button = get_sub_field('button');
$logos = get_sub_field('logos'); // This is your gallery field with image IDs
?>

<section class="insurer-review">
    <div class="insurer-review__content">
        <?php if ($text): ?>
            <div class="insurer-review__content__text">
                <?php echo $text; ?>
            </div>
        <?php endif; ?>

        <?php if ($button): ?>
            <div class="btn-container">
                <a
                    href="<?php echo esc_url($button['url']); ?>"
                    class="btn"
                    target="<?php echo esc_attr($button['target'] ?: '_self'); ?>"
                >
                    <?php echo esc_html($button['title']); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($logos): ?>
        <div class="insurer-review__logos">
            <?php foreach ($logos as $logo):
                $logo_img = wp_get_attachment_image($logo['ID'], 'full');
                $logo_link = get_field('url', $logo['ID']); // assumes each image has a custom field "url"
                ?>
                <?php if ($logo_link): ?>
                <div class="white-card">
                    <a href="<?php echo esc_url($logo_link); ?>" class="insurer-review__logos__logo">
                        <?php echo $logo_img; ?>
                    </a>
                </div>

            <?php else: ?>
                <div class="white-card">
                    <div class="insurer-review__logos__logo">
                        <?php echo $logo_img; ?>
                    </div>
                </div>

            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
