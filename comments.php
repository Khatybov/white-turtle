<?php
if (!post_type_supports (get_post_type (), 'comments') || post_password_required () || (!comments_open (
        ) && !get_comments_number ())
) {
    return;
}
?>
<div id="comments" class="post-comments">

    <?php if (have_comments ()) : ?>

        <h3 class="comments-title">
            <?php _e ('Comments:', 'white-turtle') ?>
        </h3>

        <?php whiteturtle_get_comments_pagination (); ?>

        <div class="comment-list">
            <?php
            wp_list_comments (
                array (
                    'style' => 'div',
                    'short_ping' => true,
                    'walker' => new Whiteturtle_Walker_Comment(),
                )
            );
            ?>
        </div>

        <?php whiteturtle_get_comments_pagination (); ?>

    <?php endif; ?>

    <?php if (!comments_open () && get_comments_number () && post_type_supports (get_post_type (), 'comments')) : ?>
        <p class="no-comments"><?php _e ('Comments are closed.', 'white-turtle'); ?></p>
    <?php endif; ?>

    <?php comment_form (
        array (
            'title_reply_before' => '<h5 id="comment-reply__title" class="comment-reply__title">',
            'title_reply_after' => '</h5>',
            'cancel_reply_before' => '<span class="comment-reply__link-cancel">',
            'cancel_reply_after' => '</span>',
            'class_submit' => 'form-submit__button',
        )
    ); ?>
</div><!-- .comments-area -->