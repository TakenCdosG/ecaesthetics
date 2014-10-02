<?php get_header();?>
<section id="container">
	<?php if(get_option('afl_breadcrumbs_enable') == 'open'):?>

    <!--breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumb-line">
                <?php echo get_option('breadcrumbs_text'); ?> <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?><?php printf( __( 'Search Results: %s', 'afl' ), get_search_query() ); ?>
            </div>
        </div>
    </div>

	<?php endif; ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <hr class="before-title"/>
                <div class="title-divider clearfix">
                    <h1 class="page-title">
                        <?php printf( __( 'Search Results for: %s', 'twentythirteen' ), get_search_query() ); ?>
                    </h1>
                </div>
                <hr class="after-title"/>
            </div>
        </div>
    </div>

	<?php
	$sidebar_pos = get_option('afl_blog_sidebar_position', 'right');
	if($sidebar_pos != 'none') { ?>
	<div class="container">
        <div class="row">
            <section id="page-sidebar" class="align<?php echo $sidebar_pos; ?> <?php echo CONTENT_SPAN ?>">
	<?php } ?>
	<?php if($sidebar_pos == 'none') { ?><div class="container"><?php } ?>
				<?php if ( have_posts() ) : ?>
					<?php get_template_part( 'loop', 'search' );
                    if (have_posts()) {
                        if ( function_exists( 'afl_pager' ) ) {
                            echo afl_pager();
                        }
                        else {
                            echo '<div id="posts_navigation"><span id="nextlink">';
                            next_posts_link('&laquo; prev ' . get_option('wp_olderentries'));
                            echo '</span><span id="previouslink">';
                            previous_posts_link(get_option('wp_newerentries') . ' next &raquo;');
                            echo '</span></div>';
                        }
                    }?>
				<?php else : ?>
					<h3><?php _e( 'Nothing Found', 'afl' ); ?></h3>
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'verona' ); ?></p>
					<br/>
					<?php get_search_form(); ?>
				<?php endif; ?>
	<?php if($sidebar_pos == 'none') { ?></div><?php } ?>
	<?php if($sidebar_pos != 'none') { ?>
            </section>
			<?php get_sidebar('blog'); ?>
</div>
</div>
<?php } ?>
</section>

<?php get_footer(); ?>
