<?php
// ACF
$expert_text = get_sub_field('text');

// Get all users with the Expert Reviewer role
$expert_reviewers = get_users([
    'role'    => 'expert reviewer', // <-- use your actual role slug
    'fields'  => 'ID',
    'orderby' => 'display_name',
    'order'   => 'ASC',
]);
?>

<section class="reviewer-grid">
    <div class="container">
        <div class="reviewer-grid__inner">
            <?php if ($expert_text) : ?>
                <div class="reviewer-grid__inner__text" data-aos="fade-up" data-aos-delay="100"><?php echo $expert_text; ?></div>
            <?php endif; ?>

            <div class="reviewer-grid__inner__grid" data-aos="fade" data-aos-delay="300">
                <?php foreach ($expert_reviewers as $expert_id) : ?>
                    <?php
                    $expert_id      = (int) $expert_id;
                    $expert_name    = get_the_author_meta('display_name', $expert_id);
                    $expert_headline= get_field('user_headline', 'user_' . $expert_id);
                    $expert_url     = get_author_posts_url($expert_id);

                    // --- IMAGE: EXACTLY like your working author/single templates ---
                    $expert_image_raw = get_field('user_photo', 'user_' . $expert_id, false);
                    $expert_photo_url = '';
                    $expert_photo_alt = $expert_name;

                    if (is_numeric($expert_image_raw)) {
                        $expert_photo_url = wp_get_attachment_image_url((int)$expert_image_raw, 'full');
                        $img_alt          = get_post_meta((int)$expert_image_raw, '_wp_attachment_image_alt', true);
                        if (!empty($img_alt)) {
                            $expert_photo_alt = $img_alt;
                        }
                    } elseif (is_array($expert_image_raw) && !empty($expert_image_raw['url'])) {
                        $expert_photo_url = $expert_image_raw['url'];
                        $expert_photo_alt = !empty($expert_image_raw['alt']) ? $expert_image_raw['alt'] : $expert_name;
                    } elseif (is_string($expert_image_raw)) {
                        $expert_photo_url = $expert_image_raw;
                    }

                    // Final fallback (theme default, then Gravatar) — same as your working author partial
                    if (!$expert_photo_url) {
                        $theme_fallback   = get_template_directory_uri() . '/static/images/default-author.png';
                        $grav_url         = get_avatar_url($expert_id, ['size' => 256]);
                        $expert_photo_url = $grav_url ?: $theme_fallback;
                        $expert_photo_alt = $expert_name;
                    }
                    ?>
                    <div class="reviewer-grid__inner__grid__reviewer">
                        <div class="reviewer-grid__inner__grid__reviewer__image">
                            <img src="<?php echo esc_url($expert_photo_url); ?>" alt="<?php echo esc_attr($expert_photo_alt); ?>" />
                        </div>

                        <div class="reviewer-grid__inner__grid__reviewer__info">
                            <p class="small-heading">
                                <a href="<?php echo esc_url($expert_url); ?>">
                                    <?php echo esc_html($expert_name); ?>
                                </a>
                            </p>
                            <?php if (!empty($expert_headline)) : ?>
                                <p><?php echo esc_html($expert_headline); ?></p>
                            <?php else : ?>
                                <p>Expert Reviewer</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
