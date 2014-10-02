<?php
/**
 * The template for displaying Author Archive pages.
 
 */

get_header();?>
<?php
if ( have_posts() )
	the_post();
?>
<section id="container">
	<?php if(get_option('afl_breadcrumbs_enable') == 'open'):?>

    <!--breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumb-line">
                <?php echo get_option('breadcrumbs_text'); ?> <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?><?php printf( __( 'Author Archives: %s', 'afl' ), get_the_author() ); ?>
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
                        <?php echo get_the_author().' Archives'?>
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
                print_author_info();
				if ( get_the_author_meta( 'description' ) ) echo '<hr>';
				rewind_posts();
				get_template_part( 'loop', 'author' );
				if (have_posts()) echo afl_pager();
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
