<div class="comments">
    <?php
    if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
        die ('Please do not load this page directly. Thanks!');
    if (post_password_required()) {
        echo 'This post is password protected. Enter the password to view comments.';
        return;
    }

    // List comments
    if (have_comments()) : ?>
        <hr class="post-divider"/>
        <!-- comments -->
        <a name="comments"></a>
        <div class="title-divider">
            <h3><?php comments_number('No Comments', 'One Comment', 'Comments <span class="comm-number">(%)</span>'); ?></h3>
        </div>
        <div class="comments">
            <ul class="comments-list">
                <?php
                //wp_list_comments('type=comment&callback=afl_comment');
                wp_list_comments('type=all&callback=afl_comment');
                ?>
            </ul>
        </div>
        <div class="comments-navigation clearfix">
            <div class="next-posts pull-left"><?php previous_comments_link('<i class="fa fa-angle-double-left"></i> Older Comments'); ?></div>
            <div class="prev-posts pull-right"><?php next_comments_link('Newer Comments <i class="fa fa-angle-double-right"></i>'); ?></div>
        </div>
    <?php

    else : // this is displayed if there are no comments so far

    endif;

    // Comment form
    if (comments_open() && get_option('default_comment_status') == 'open') :

        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true'" : '');
        $required_text = '';

        $args = array(
            'id_form' => 'commentform',
            'id_submit' => 'submit',
            'title_reply' => __('Leave Your Comment'),
            'title_reply_to' => __('Leave a Reply to %s'),
            'cancel_reply_link' => __('Cancel Reply'),
            'label_submit' => __('Submit Comment'),

            'comment_field' => '<p class="comment-form-comment"><label for="comment" class="sr-only">' . _x('Comment', 'noun') .
                '</label><textarea id="comment" class="form-control" placeholder="' . _x('Comment', 'noun') . ' *" name="comment" cols="45" rows="8" aria-required="true">' .
                '</textarea></p>',

            'must_log_in' => '<p class="must-log-in">' .
                sprintf(
                    __('You must be <a href="%s">logged in</a> to post a comment.'),
                    wp_login_url(apply_filters('the_permalink', get_permalink()))
                ) . '</p>',

            'logged_in_as' => '<p class="logged-in-as">' .
                sprintf(
                    __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>'),
                    admin_url('profile.php'),
                    $user_identity,
                    wp_logout_url(apply_filters('the_permalink', get_permalink()))
                ) . '</p>',

            'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published.') . ($req ? $required_text : '') . '</p>',

            'comment_notes_after' => '<p class="form-allowed-tags">' .
                sprintf(
                    __('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s'),
                    ' <code>' . allowed_tags() . '</code>'
                ) . '</p>',

            'fields' => apply_filters('comment_form_default_fields', array(

                    'author' =>
                        '<div class="row"><p class="comment-form-author col-sm-6">' .
                        '<label for="author" class="sr-only">' . __('Name', 'domainreference') . '</label> ' .
                        ($req ? '<span class="required sr-only">*</span>' : '') .
                        '<input id="author" class="form-control" name="author" type="text" placeholder="' . __('Name', 'domainreference') . ' *" value="' . esc_attr($commenter['comment_author']) .
                        '" size="30"' . $aria_req . ' /></p>',

                    'email' =>
                        '<p class="comment-form-email col-sm-6"><label for="email" class="sr-only">' . __('Email', 'domainreference') . '</label> ' .
                        ($req ? '<span class="required sr-only">*</span>' : '') .
                        '<input id="email" class="form-control" name="email" type="text" placeholder="' . __('Email', 'domainreference') . ' *" value="' . esc_attr($commenter['comment_author_email']) .
                        '" size="30"' . $aria_req . ' /></p></div>',

                    'url' =>
                        '<p class="comment-form-url"><label for="url" class="sr-only">' . __('Website', 'domainreference') . '</label>' .
                        '<input id="url" class="form-control" name="url" type="text" placeholder="' . __('Website', 'domainreference') . '" value="' . esc_attr($commenter['comment_author_url']) .
                        '" size="30" /></p>'
                )
            ),
        );

        echo '<hr class="post-divider"/>';

        if (!have_comments()) {
            echo '<h3>There are no comments yet, why not be the first</h3>';
        }

        comment_form($args);
        cancel_comment_reply_link();

        if (get_option('comment_registration') && !is_user_logged_in()) : ?>
            <p>You must be <a href="<?php echo wp_login_url(get_permalink()); ?>">logged in</a> to post a comment.</p>
        <?php endif; // If registration required and not logged in

    else :

    endif;

    // Messages
    if (get_option('default_comment_status') !== 'open') {
        if ('post' == get_post_type()) {
            echo '<hr class="post-divider"/>';
            echo '<h3>Comments are disabled</h3>';
        }
    } else {
        if (comments_open()) {
        } else {
            if ('post' == get_post_type()) {
                echo '<hr class="post-divider"/>';
                echo '<h3>Comments are closed</h3>';
            }
        }
    }

    ?>
</div>
