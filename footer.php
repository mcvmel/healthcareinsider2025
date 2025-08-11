<?php
$text = get_field('email_cta_text', 'option');
$shortcode = get_field('email_cta_shortcode', 'option');
$disclaimer = get_field('email_cta_disclaimer', 'option');

$phone_number        = get_field('footer_options_phone_number', 'option');
$facebook_link       = get_field('footer_options_facebook_link', 'option');
$twitter_link        = get_field('footer_options_twitter_link', 'option');
$instagram_link      = get_field('footer_options_instagram_link', 'option');
$linkedin_link       = get_field('footer_options_linkedin_link', 'option');
$legal_links         = get_field('footer_options_legal_links', 'option');
$legal_disclaimer   = get_field('footer_options_disclaimer', 'option');
?>

<section class="email-cta">
    <div class="container">
        <section class="email-cta__inner">
            <div class="email-cta__inner__left">
                <?php if ($text) : ?>
                    <div class="email-cta__inner__left__text">
                        <?php echo $text; ?>
                    </div>
                <?php endif; ?>

                <?php if ($shortcode) : ?>
                    <div class="email-cta__inner__left__form">
                        <?php echo do_shortcode($shortcode); ?>
                    </div>
                <?php endif; ?>

                <?php if ($disclaimer) : ?>
                    <div class="email-cta__inner__left__disclaimer">
                        <?php echo $disclaimer; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</section>

<section class="footer">
    <div class="container">
        <div class="footer__top">
            <div class="footer__top__logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/static/images/healthcareinsider-logo-white.png" alt="Healthcare Insider">
                </a>
            </div>
            <div class="footer__top__utility">

                <div class="footer__top__utility__phone">
                    <img src="<?php echo get_template_directory_uri(); ?>/static/images/icon-phone.svg" alt="Phone Icon" class="site-header__utility__icon">

                    <?php if (!empty($phone_number)) : ?>
                        <a href="tel: <?php echo esc_html($phone_number); ?>"> <?php echo esc_html($phone_number); ?></a>
                    <?php endif; ?>
                </div>

                <button class="footer__top__utility__search" aria-label="Search">
                    <img src="<?php echo get_template_directory_uri(); ?>/static/images/icon-search.svg" alt="Search Icon" class="site-header__utility__icon">
                    Search
                </button>

                <div class="footer__top__utility__social">
                    <?php if (!empty($facebook_link)) : ?>
                        <a href="<?php echo esc_url($facebook_link); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/static/images/facebook-icon.png" alt="Facebook">
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($twitter_link)) : ?>
                        <a href="<?php echo esc_url($twitter_link); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/static/images/twitter-icon.png" alt="Twitter">
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($instagram_link)) : ?>
                        <a href="<?php echo esc_url($instagram_link); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/static/images/instagram-icon.png" alt="Instagram">
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($linkedin_link)) : ?>
                        <a href="<?php echo esc_url($linkedin_link); ?>" target="_blank" rel="noopener noreferrer">
                            <img src="<?php echo get_template_directory_uri(); ?>/static/images/linkedin-icon.png" alt="LinkedIn">
                        </a>
                    <?php endif; ?>
                </div>


            </div>
        </div>
        <div class="footer__navigation">
            <div class="footer__navigation__col">
                <p class="footer__navigation__col__title">Healthcare Articles</p>
                <?php
                wp_nav_menu([
                    'theme_location' => 'footer_1',
                    'menu_class' => 'footer-menu footer-1',
                ]);
                ?>
			</div>
			<div class="footer__navigation__col">
				<p class="footer__navigation__col__title">Resources</p>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer_2',
					'menu_class' => 'footer-menu footer-2',
				]);
				?>
			</div>
			<div class="footer__navigation__col">
				<p class="footer__navigation__col__title">Company</p>
				<?php
				wp_nav_menu([
					'theme_location' => 'footer_3',
					'menu_class' => 'footer-menu footer-3',
				]);
				?>
			</div>
        </div>
        <div class="footer__legal">
            <div class="footer__legal__links">
                <?php if (!empty($legal_links)) : ?>
                    <?php echo $legal_links; ?>
                <?php endif; ?>
            </div>
            <div class="footer__legal__copyright"><p>Copyright &copy; 2006-<?php echo date('Y'); ?> HealthCare, Inc.</p></div>
        </div>
        <div class="footer__disclaimer">
            <?php if (!empty($legal_disclaimer)) : ?>
                    <?php echo $legal_disclaimer; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="search-overlay">
    <button class="search-overlay__close js-close-search"></button>
    <div class="search-overlay__inner">
        <span class="h2">Search</span>
        <?php get_search_form(); ?>
    </div>
</section>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
