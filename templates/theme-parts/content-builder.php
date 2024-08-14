<?php $is_pass_protected = post_password_required(); ?>

<?php if ( ! $is_pass_protected ) : ?>

        <?php if ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php the_content(); ?>

        </article> <!-- end article -->
        <div class="clear"></div>

        <?php else : ?>

        <article id="post-not-found">
            <header>
                <h1><?php esc_html_e("Not Found", 'phlox-pro'); ?></h1>
            </header>

            <section class="entry-content">
                <p><?php esc_html_e("Sorry, but the requested resource was not found on this site.", 'phlox-pro'); ?></p>
            </section>

            <footer>
            </footer>
        </article>
        <div class="clear"></div>

        <?php endif; ?>

        <?php comments_template(); ?>

<?php else : ?>

    <?php echo get_the_password_form(); ?>

<?php endif; ?>
