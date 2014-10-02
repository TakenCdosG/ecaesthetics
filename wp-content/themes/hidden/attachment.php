<?php
/**
 * The template for displaying attachments.
 *
 
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
                <?php echo get_option('breadcrumbs_text'); ?> <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?>Attachments
            </div>
        </div>
    </div>

	<?php endif; ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <hr class="before-title"/>
                <div class="title-divider clearfix">
                    <h1 class="page-title">Attachments</h1>
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
                    <h3 class="post-heading"><?php the_title(); ?></h3>

        <div class="entry-attachment">
            <?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>
                <p class="attachment"><a data-rel="prettyPhoto" href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment"><img class="img-responsive" src="<?php echo $att_image[0];?>" width="<?php echo $att_image[1];?>" height="<?php echo $att_image[2];?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" /></a></p>
            <?php else : ?>
                <a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo esc_html( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
            <?php endif; ?>
        </div>


            <?php if($sidebar_pos == 'none') { ?></div><?php } ?>
	<?php if($sidebar_pos != 'none') { ?>
            </section>
			<?php get_sidebar('blog'); ?>
</div>
</div>
<?php } ?>
</section>

<?php get_footer(); ?>
