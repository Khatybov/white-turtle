<section class="no-results not-found">
    <div class="post-content no-results-content">
        <h3 class="no-results-title">
            <?php _e ('Nothing Found', 'white-turtle'); ?>
        </h3>
        <p class="no-results-text"><?php whiteturtle_no_results_content (); ?></p>
        <?php if (!is_search ()): ?>
            <div class="no-results-search">
                <?php get_search_form (); ?>
            </div>
        <?php endif; ?>
    </div>
</section>