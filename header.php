<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package healthcareinsider2025
 */
$phone_number = get_field('footer_options_phone_number', 'option');
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text"
       href="#primary"><?php esc_html_e('Skip to content', 'healthcareinsider2025'); ?></a>

    <header class="site-header">
        <div class="site-header__utility">
            <div class="container site-header__utility__inner">

                <div class="site-header__utility__phone">
                    <img src="<?php echo get_template_directory_uri(); ?>/static/images/icon-phone.svg" alt="Phone Icon"
                         class="site-header__utility__icon">
                    <?php if (!empty($phone_number)) : ?>
                        <a href="tel: <?php echo esc_html($phone_number); ?>"> <?php echo esc_html($phone_number); ?></a>
                    <?php endif; ?>
                </div>

                <button class="site-header__utility__search js-open-search" aria-label="Search">
                    <img src="<?php echo get_template_directory_uri(); ?>/static/images/icon-search.svg"
                         alt="Search Icon" class="site-header__utility__icon">
                    Search
                </button>

            </div>
        </div>

        <div class="site-header__main">
            <div class="container site-header__main__inner">

                <div class="site-header__main__logo">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/static/images/healthcareinsider-logo.png"
                             alt="Healthcare Insider">
                    </a>
                </div>

                <nav class="site-header__main__nav" role="navigation">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container' => 'div',
                        'container_class' => 'site-header__main__menu',
                        'menu_class' => 'site-header__main__menu__list',
                        'fallback_cb' => false,
                    ]);
                    ?>
                </nav>

            </div>
        </div>
    </header>

