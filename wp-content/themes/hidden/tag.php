<?php
/**
 * The template for displaying Tag Archive pages.
 *
 
 */
get_header();?>
<section id="container">
	<?php if(get_option('afl_breadcrumbs_enable') == 'open'):?>

    <!--breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumb-line">
                <?php echo get_option('breadcrumbs_text'); ?> <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?><?php printf(__('Tag Archives: %s', 'afl'), single_tag_title('', false));?>
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
                        <?php printf(__('Tags: %s', 'afl'), single_tag_title('', false));?>
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
				<?php get_template_part('loop', 'tag');
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
