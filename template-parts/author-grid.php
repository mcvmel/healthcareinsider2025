<?php
// Optional intro text from the block
$text = get_sub_field('text');

// Only authors
$authors = get_users([
    'role'    => 'author',
    'fields'  => 'ID',
    'orderby' => 'display_name',
    'order'   => 'ASC',
]);
?>

<section class="author-grid">
    <div class="container">
        <div class="author-grid__inner">
            <?php if ($text) : ?>
                <div class="author-grid__inner__text" data-aos="fade-up" data-aos-delay="100"><?php echo $text; ?></div>
            <?php endif; ?>

            <div class="author-grid__inner__grid" data-aos="fade" data-aos-delay="300">
                <?php foreach ($authors as $user_id) : ?>
                    <?php
                    $user_id      = (int) $user_id;
                    $display_name = get_the_author_meta('display_name', $user_id);
                    $headline     = get_field('user_headline', 'user_' . $user_id);
                    $author_url   = get_author_posts_url($user_id);

                    // --- IMAGE: EXACTLY like single/author templates ---
                    $author_image_raw = get_field('user_photo', 'user_' . $user_id, false);
                    $photo_url = '';
                    $photo_alt = $display_name;

                    if (is_numeric($author_image_raw)) {
                        $photo_url = wp_get_attachment_image_url((int)$author_image_raw, 'full');
                        $img_alt   = get_post_meta((int)$author_image_raw, '_wp_attachment_image_alt', true);
                        if (!empty($img_alt)) {
                            $photo_alt = $img_alt;
                        }
                    } elseif (is_array($author_image_raw) && !empty($author_image_raw['url'])) {
                        $photo_url = $author_image_raw['url'];
                        $photo_alt = !empty($author_image_raw['alt']) ? $author_image_raw['alt'] : $display_name;
                    } elseif (is_string($author_image_raw)) {
                        $photo_url = $author_image_raw;
                    }

                    // Final fallback (theme default, then Gravatar) — matches your single/author
                    if (!$photo_url) {
                        $theme_fallback = get_template_directory_uri() . '/static/images/default-author.png';
                        $grav_url       = get_avatar_url($user_id, ['size' => 256]);
                        $photo_url      = $grav_url ?: $theme_fallback;
                        $photo_alt      = $display_name;
                    }
                    ?>
                    <div class="author-grid__inner__grid__author">
                        <div class="author-grid__inner__grid__author__image">
                            <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($photo_alt); ?>" />
                        </div>

                        <div class="author-grid__inner__grid__author__info">
                            <p class="small-heading">
                                <a href="<?php echo esc_url($author_url); ?>">
                                    <?php echo esc_html($display_name); ?>
                                </a>
                            </p>
                            <?php if (!empty($headline)) : ?>
                                <p><?php echo esc_html($headline); ?></p>
                            <?php else : ?>
                                <p>Healthcare Writer</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
