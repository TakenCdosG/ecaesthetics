<?php
/**
 * The template for displaying Category Archive pages.
 *
 
 */

get_header();?>

<!--container-->
<section id="container">
	<?php if(get_option('afl_breadcrumbs_enable') == 'open'):?>

    <!--breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumb-line">
                <?php echo get_option('breadcrumbs_text'); ?> <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?><?php echo single_cat_title();?>
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
                        <?php echo single_cat_title();?>
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
				<?php
				$category_description = category_description();
				if ( ! empty( $category_description ) )
					echo '<div class="archive-meta">' . $category_description . '</div>';

				/* Run the loop for the category page to output the posts.
				* If you want to overload this in a child theme then include a file
				* called loop-category.php and that will be used instead.
				*/
				get_template_part( 'loop', 'category' );
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
                    }
				?>
	<?php if($sidebar_pos == 'none') { ?></div><?php } ?>
	<?php if($sidebar_pos != 'none') { ?>
            </section>
			<?php get_sidebar('blog'); ?>
        </div>
    </div>
	<?php } ?>
</section>
<?php get_footer(); ?>
