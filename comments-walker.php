<?php

class Whiteturtle_Walker_Comment extends Walker_Comment {
    protected function html5_comment ($comment, $depth, $args) {
        global $post;

        $tag = ('div' === $args[ 'style' ]) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID (); ?>" <?php comment_class (
            ($this->has_children ? 'parent' : '') . ' ' . ($depth > 1 ? 'child' : '') . ' comment-wrapper',
            $comment
        ); ?>>

        <article id="div-comment-<?php comment_ID (); ?>" class="comment-body">

            <div class="comment-content">
                <?php comment_text (); ?>
            </div>

            <div class="comment-meta">

                <div class="comment-meta__row comment-meta__author vcard">
                    <span class="comment-author__name">
                        <?php echo whiteturtle_get_comment_meta_author ($comment, $args); ?>
                    </span>
                </div>
                <?php if ($post && $comment->user_id === $post->post_author): ?>
                    <div class="comment-meta__row comment-meta__info comment-meta__bypostauthor vcard">
                    <span class="comment-author__name">
                        <?php _e ('Comment by author', 'white-turtle') ?>
                    </span>
                        <?php echo whiteturtle_get_icon ('info'); ?>
                    </div>
                <?php endif; ?>
                <?php if ('0' == $comment->comment_approved) : ?>
                    <div class="comment-meta__moderation comment-meta__info comment-meta__row">
                        <span class="comment-awaiting-moderation">
                            <?php _e ('Your comment is awaiting moderation.', 'white-turtle'); ?>
                        </span>
                        <?php echo whiteturtle_get_icon ('info'); ?>
                    </div>
                <?php endif; ?>

                <div class="comment-meta__row">
                    <span class="comment-meta__date">
                        <?php echo whiteturtle_get_comment_meta_date ($comment) ?>
                    </span>
                    
                    <a href="<?php echo esc_url (get_comment_link ($comment, $args)); ?>"
                       title="<?php _e ('Link to comment', 'white-turtle') ?>"
                       class="comment-meta__link comment-meta__icon">
                        <?php echo whiteturtle_get_icon ('link'); ?>
                    </a>

                    <?php echo whiteturtle_get_comment_meta_reply_link ($args, $depth); ?>

                    <?php echo whiteturtle_get_comment_meta_edit_link () ?>
                </div>
            </div><!-- .comment-meta -->

        </article><!-- .comment-body -->
        <?php
    }

    protected function ping ($comment, $depth, $args) {
        $tag = ('div' == $args[ 'style' ]) ? 'div' : 'li';
        ?>
        <<?php echo $tag; ?> id="comment-<?php comment_ID (); ?>" <?php comment_class ('comment-wrapper', $comment); ?>>

        <article class="comment-body">

            <div class="comment-content">
                <p><?php _e ('Pingback:', 'white-turtle'); ?></p>
                <p><?php comment_author_link ($comment); ?></p>
            </div>

            <div class="comment-meta">
                <div class="comment-meta__row">

                    <span class="comment-meta__date">
                      <?php echo whiteturtle_get_comment_meta_date ($comment) ?>
                    </span>

                    <?php echo whiteturtle_get_comment_meta_edit_link () ?>

                </div>
            </div><!-- .comment-meta -->

        </article>
        <?php
    }
}