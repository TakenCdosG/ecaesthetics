<?php
/**
 * The Template for displaying all single Team Members posts.
 */
get_header();
?>

<?php the_post(); ?>
<section id="container">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="content-press">     
                    <div class="date_article"><?php print_post_date(); ?></div>
                    <div class="title_article"><h1 class="page-title"><?php echo $post->post_title ?></h1></div>
                    <div class="description_article" class="radikal_light_team"> 
                        <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                        <?php $imgurl = $src[0]; ?>
                        <div class="post-img-wrapper-details img-thumbnail-detail">
                            <img class="img-responsive" src="<?php echo $imgurl; ?>"  alt="<?php echo $post->post_title ?>" />
                        </div>
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
