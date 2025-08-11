<?php
// Get ACF fields
$text    = get_sub_field('text');
$link    = get_sub_field('link');
$authors = get_sub_field('authors'); // ACF Users field (IDs or User arrays)

// Link fallbacks
$link_url    = isset($link['url']) ? $link['url'] : '';
$link_title  = isset($link['title']) ? $link['title'] : '';
$link_target = isset($link['target']) ? $link['target'] : '_self';
?>

<section class="author-callout">
    <div class="container">
        <div class="author-callout__inner">
            <?php if ($text) : ?>
                <div class="author-callout__inner__text">
                    <?php echo $text; ?>
                    <?php if ($link_url && $link_title) : ?>
                        <div class="btn-container">
                            <a class="btn" href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
                                <?php echo esc_html($link_title); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($authors)) : ?>
                <div class="author-callout__inner__grid">
                    <?php foreach ($authors as $author) : ?>
                        <?php
                        // Handle both return formats: User ID or User Array
                        $user_id = (int) (is_array($author) && isset($author['ID']) ? $author['ID'] : $author);

                        // User fields
                        $display_name = get_the_author_meta('display_name', $user_id);
                        $headline     = get_field('user_headline', 'user_' . $user_id);

                        // --- IMAGE: EXACTLY like your working author/single templates ---
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

                        // Final fallback (theme default, then Gravatar) — to match your working logic
                        if (!$photo_url) {
                            $theme_fallback = get_template_directory_uri() . '/static/images/default-author.png';
                            $grav_url       = get_avatar_url($user_id, ['size' => 256]);
                            $photo_url      = $grav_url ?: $theme_fallback;
                            $photo_alt      = $display_name;
                        }
                        ?>
                        <div class="author-callout__inner__grid__author">
                            <div class="author-callout__inner__grid__author__image">
                                <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($photo_alt); ?>" />
                            </div>
                            <div class="author-callout__inner__grid__author__info">
                                <p class="small-heading"><?php echo esc_html($display_name); ?></p>
                                <?php if (!empty($headline)) : ?>
                                    <p><?php echo esc_html($headline); ?></p>
                                <?php else : ?>
                                    <p>Health Care Writer</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
