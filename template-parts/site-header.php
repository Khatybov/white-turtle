<?php
$site_url = esc_url (home_url ('/'));
$site_title = get_bloginfo ('name');
$site_description = get_bloginfo ('description', 'display');

$is_home = is_front_page () && is_home ();
?>

<header id="site-header" class="site-header">
    <?php if (function_exists ('the_custom_logo') && get_theme_mod( 'custom_logo' )): ?>
        <div class="site-header__column site-header__column-left">
            <?php the_custom_logo (); ?>
        </div>
    <?php endif; ?>
    <div class="site-header__column site-header__column-right">
        <?php if ($is_home): ?>
            <h1 class="site-title">
                <a href="<?php echo esc_url (home_url ('/')); ?>" class="site-title__link" rel="home">
                    <?php bloginfo ('name'); ?>
                </a>
            </h1>
        <?php else: ?>
            <p class="site-title">
                <a href="<?php echo esc_url (home_url ('/')); ?>" class="site-title__link" rel="home">
                    <?php bloginfo ('name'); ?>
                </a>
            </p>
        <?php endif; ?>
        <?php if ($site_description) : ?>
            <p class="site-description">
                <?php echo $site_description; ?>
            </p>
        <?php endif; ?>
    </div>
</header><!-- #site-header -->