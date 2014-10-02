<?php
/**
 * The template for displaying Archive pages.
 
 */

get_header();

if ( have_posts() ) the_post();
?>
<section id="container">
	<?php if(get_option('afl_breadcrumbs_enable') == 'open'):?>

    <!--breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumb-line">
                <?php echo get_option('breadcrumbs_text'); ?> <a
                    href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?>
                <?php if (is_day()) : ?>
                    <?php printf(__('Daily: <span>%s</span>', 'afl'), get_the_date()); ?>
                <?php elseif (is_month()) : ?>
                    <?php printf(__('Monthly: <span>%s</span>', 'afl'), get_the_date('F Y')); ?>
                <?php
                elseif (is_year()) : ?>
                    <?php printf(__('Yearly: <span>%s</span>', 'afl'), get_the_date('Y')); ?>
                <?php
                else : ?>
                    <?php _e('Blog Archives', 'afl'); ?>
                <?php endif; ?>
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
                        <?php _e( 'Blog Archives', 'afl' ); ?>
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
					<?php rewind_posts();
					get_template_part( 'loop', 'archive' );
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
