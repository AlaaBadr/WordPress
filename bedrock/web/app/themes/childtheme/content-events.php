<?php
/**
 * Template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php if ( is_sticky() ) : ?>
            <hgroup>
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                <h3 class="entry-format"><?php _e( 'Featured', 'twentyeleven' ); ?></h3>
            </hgroup>
        <?php else : ?>
            <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
        <?php endif; ?>
    </header><!-- .entry-header -->

    <?php the_post_thumbnail( array( 500, 400 ) ); ?>

    <?php if ( is_search() ) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?>
            <p>Event Date: <?php echo get_post()->event_date; ?></p>
            <pre>From: <?php echo get_post()->start_time; ?>          To: <?php echo get_post()->end_time; ?></pre>
            <?php
            wp_link_pages(
                array(
                    'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>',
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

    <footer class="entry-meta">
        <?php $show_sep = false; ?>
        <?php if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) : // Hide category text when not supported ?>
            <?php
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );
            if ( $categories_list ) :
                ?>
                <span class="cat-links">
					<?php
                    printf( __( '<span class="%1$s">Posted in</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
                    $show_sep = true;
                    ?>
			</span>
            <?php endif; // End if categories ?>
        <?php endif; // End if is_object_in_taxonomy( get_post_type(), 'category' ) ?>
        <?php if ( is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) : // Hide tag text when not supported ?>
            <?php
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list( '', __( ', ', 'twentyeleven' ) );
            if ( $tags_list ) :
                if ( $show_sep ) :
                    ?>
                    <span class="sep"> | </span>
                <?php endif; // End if $show_sep ?>
                <span class="tag-links">
					<?php
                    printf( __( '<span class="%1$s">Tagged</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
                    $show_sep = true;
                    ?>
			</span>
            <?php endif; // End if $tags_list ?>
        <?php endif; // End if is_object_in_taxonomy( get_post_type(), 'post_tag' ) ?>

        <?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
