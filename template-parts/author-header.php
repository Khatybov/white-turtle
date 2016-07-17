<?php
$name = get_the_author_meta ('display_name');
$avatar = get_avatar (get_the_author_meta ('ID'));
$url = get_the_author_meta ('user_url');
?>
<header class="archive-header author-header">
    <div class="author-header__columns">
        <?php if ($avatar): ?>
            <div class="author-header__column author-header__column-left">
                <?php if ($avatar): ?>
                    <div class="author-header__avatar"><?php echo $avatar; ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <div class="author-header__column author-header__column-right">
            <?php whiteturtle_page_title (); ?>
            <?php whiteturtle_archive_description (); ?>
        </div>
    </div>
    <?php if ($url): ?>
        <div class="author-header__meta">
            <div class="author-header__url">
                <a href="<?php echo esc_url ($url) ?>" target="_blank" title="<?php echo $name ?>">
                    <span class="genericon genericon-website"></span>
                </a>
            </div>
        </div>
    <?php endif; ?>
</header>
