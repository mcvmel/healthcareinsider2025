<?php
// Get ACF fields
$text    = get_sub_field('text');
$link    = get_sub_field('link');
$authors = get_sub_field('authors');

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
                        $user_id = is_array($author) && isset($author['ID']) ? $author['ID'] : $author;

                        // Grab user fields
                        $photo        = get_field('user_photo', 'user_' . $user_id);
                        $headline     = get_field('user_headline', 'user_' . $user_id);
                        $display_name = get_the_author_meta('display_name', $user_id);

                        // Safe image values
                        $photo_url = '';
                        $photo_alt = $display_name;

                        if (is_array($photo)) {
                            $photo_url = isset($photo['url']) ? $photo['url'] : '';
                            $photo_alt = !empty($photo['alt']) ? $photo['alt'] : $display_name;
                        } elseif (is_string($photo)) {
                            $photo_url = $photo;
                        }
                        ?>
                        <div class="author-callout__inner__grid__author">
                            <?php if ($photo_url) : ?>
                                <div class="author-callout__inner__grid__author__image">
                                    <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($photo_alt); ?>" />
                                </div>
                            <?php else : ?>
                                <div class="author-callout__inner__grid__author__image">
                                    <img src="<?php echo esc_url(get_template_directory_uri() . '/static/images/default-author.png'); ?>" alt="<?php echo esc_attr($display_name); ?>" />
                                </div>
                            <?php endif; ?>
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
