<div class="sidebar">
    <div class="sidebar-nav">
        <?php if (has_nav_menu ('primary')) : ?>
            <nav class="sidebar-menu" role="navigation">
                <?php wp_nav_menu (
                    array (
                        'theme_location' => 'primary',
                        'container' => false,
                        'menu_id' => 'nav-menu',
                        'menu_class' => 'nav-menu nav-menu-hidden',
                    )
                ); ?>
            </nav>
        <?php endif; ?>
        <div class="sidebar-controls">
            <button class="show-search"><span class="genericon genericon-search"></span></button>
            <?php if (is_active_sidebar ('sidebar')) : ?>
                <button class="show-widgets"><span class="genericon genericon-draggable"></span></button>
            <?php endif; ?>
        </div>
    </div>
    <div class="sidebar-content">
        <div class="menu-container">
        </div>
        <div class="search-container">
            <?php get_search_form (); ?>
        </div>
        <?php if (is_active_sidebar ('sidebar')) : ?>
            <div class="widgets-container" role="complementary">
                <h2 class="widgets-container-title">
                    <?php _e ('Widgets', 'white-turtle'); ?>
                </h2>
                <div class="widgets-container-content">
                    <?php dynamic_sidebar ('sidebar'); ?>
                </div>
            </div>
        <?php endif; ?>
    
    </div>
</div>