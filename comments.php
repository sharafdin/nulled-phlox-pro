<?php
/**
 * Comment template
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
 ?>

<?php
    // Do not delete these lines
    // if ( ! empty($_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
    //     die ('Please do not load this page directly. Thanks!');

    if ( post_password_required() ) { ?>
    <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'phlox-pro' ); ?></p>
<?php
        return;
    }
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
    <div id="comments" class="aux-comments">

        <h3 class="comments-title">
            <?php comments_number( __('No Responses', 'phlox-pro' ), __('One Response', 'phlox-pro' ), __('% Responses', 'phlox-pro' ) );?>
        </h3>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav class="aux-comments-navi comments-navi-primary">
            <div class="comments-pre-page"><?php previous_comments_link() ?></div>
            <div class="comment-next-page"><?php next_comments_link() ?></div>
        </nav>
        <?php endif; ?>

        <ol class="aux-commentlist skin-arrow-links">
            <?php wp_list_comments( array(
                'short_ping' => true,
                'callback'   => 'auxin_comment'
            ) ); ?>
        </ol>

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav class="aux-comments-navi comments-navi-secondary">
            <div class="comments-pre-page"><?php previous_comments_link() ?></div>
            <div class="comment-next-page"><?php next_comments_link() ?></div>
        </nav>
        <?php endif; ?>

    </div>

    <div class="clear"></div>

<?php else : // this is displayed if there are no comments so far ?>

    <?php if ( comments_open() ) : ?>
    <!-- If comments are open, but there are no comments. -->

    <?php elseif( get_post_type() == "post" || get_post_type() == "news" ) : // comments are closed ?>
    <!-- If comments are closed. -->
    <p class="nocomments"><?php _e("Comments are closed.", 'phlox-pro' ); ?></p>

    <?php endif; ?>

<?php endif; ?>


<?php
// Whether filling all fields is required or not.
$req = get_option( 'require_name_email' );

$author_label = $req ? esc_attr__('Name (required)'  , 'phlox-pro' ) : esc_attr__('Name'  , 'phlox-pro' );
$email_label  = $req ? esc_attr__('E-Mail (required)', 'phlox-pro' ) : esc_attr__('E-Mail', 'phlox-pro' );
$url_label  = esc_attr__('Website', 'phlox-pro' );
$textarea_label = esc_attr__('Comment', 'phlox-pro' );
$consent  = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

$comments_args = array(
    'must_log_in'          => '<p>'. sprintf( __("You must be %s logged in %s to post a comment", 'phlox-pro' ), '<a href="'.wp_login_url( get_permalink() ).'">', '</a>' ) .'</p>',
    'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'phlox-pro' ), self_admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
    // change the title of send button
    'label_submit'         => __('Submit' , 'phlox-pro' ) ,
    // change the title of the reply section
    'title_reply'          =>'<span>' . esc_html__('Leave a Comment', 'phlox-pro' ) . '</span>',
    // remove "Text or HTML to be displayed after the set of comment fields"
    'comment_notes_before' => '<p class="comment-notes"></p>',
    'comment_notes_after'  => '',
    // redefine your own textarea (the comment body)
    'comment_field'        => '<textarea name="comment" id="comment" cols="58" rows="10" placeholder="'. $textarea_label . '" ></textarea>',
    'fields'               => array(
        'author'   => '<input type="text"  name="author" id="author" placeholder="'. $author_label . '" value="'. esc_attr( $comment_author). '" size="22" '. ( $req ? "aria-required='true' required" : "" ) .' />',
        'email'    => '<input type="email" name="email"  id="email"  placeholder="'. $email_label . '" value="'. esc_attr( $comment_author_email). '" ' . ( $req ? "aria-required='true' required" : "" ) .' />',
        'url'      => '<input type="url"   name="url"    id="url"    placeholder="'. $url_label . '" value="'. esc_url( $comment_author_url). '" size="22" />',
        'cookies'  => '<div class="aux-form-cookies-consent comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" class="aux-checkbox" type="checkbox" value="yes"' . $consent . ' />' .
                     '<label for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment.', 'phlox-pro' ) . '</label></div>'
    )
);

// Whether to display cookie consent option on comment form
if( ! auxin_get_option( 'comment_cookie_consent_enabled', 1 ) ){
    $comments_args['fields']['cookies'] = '';
}

$comments_args = apply_filters(
    'auxin_default_comment_form',
    $comments_args,
    compact( 'author_label', 'email_label', 'url_label','textarea_label', 'consent', 'commenter', 'user_identity', 'req' )
);
comment_form( $comments_args );
