<?php
/**
 * The Template for displaying all single Team Members posts.
 */
get_header();
?>

<?php $team_member_qualifications = get_field('team_member_qualifications'); ?>
<?php $team_member_email = get_field('team_member_email'); ?>
<?php $team_member_location = get_field('team_member_location'); ?>
<?php $post_id_team_member_page = 21; ?>
<?php the_post(); ?>

<section id="container">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                <?php $imgurl = $src[0]; ?>
                <div class="post-img-wrapper-details img-thumbnail-detail">
                    <img class="img-responsive" src="<?php echo $imgurl; ?>"  alt="<?php echo $post->post_title ?>" />
                    <div class="label-wrapper">
                        <?php if (!empty($team_member_email)): ?>
                            <a class="team-member-email" href="mailto:<?php echo $team_member_email; ?>">
                                <div id="name_person_image">
                                    <p><?php echo $team_member_email; ?></p>
                                </div>
                            </a>
                        <?php endif; ?>
                        <div id="buttom_back"><a class="read-full" href="<?php echo get_permalink($post_id_team_member_page); ?>">&lt; Back to Team</a></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div id="team_rigth">
                    <div id="title_article"> <?php echo $post->post_title ?> </div>
                    <?php if (!empty($team_member_email)): ?>
                        <div id="button_select">
                            <?php echo $team_member_location; ?>
                        </div>
                    <?php endif; ?>
                    <div id="sub_title_article">
                        <?php echo $team_member_qualifications; ?>
                    </div>
                    <div id="description_article" class="radikal_light_team"> 
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Buckets -->
    <div class="fullwidth bg-buckets">
        <?php $post_home_id = 37; ?>
        <?php $first_bucket_post_id = get_field('first_bucket', $post_home_id); ?>
        <?php $first_bucket_post_id = isset($first_bucket_post_id[0]) ? $first_bucket_post_id[0] : $first_bucket_post_id; ?>
        <?php $second_bucket_post_id = get_field('second_bucket', $post_home_id); ?>
        <?php $second_bucket_post_id = isset($second_bucket_post_id[0]) ? $second_bucket_post_id[0] : $second_bucket_post_id; ?>
        <?php $third_bucket_post_id = get_field('third_bucket', $post_home_id); ?>
        <?php $third_bucket_post_id = isset($third_bucket_post_id[0]) ? $third_bucket_post_id[0] : $third_bucket_post_id; ?>
        <div class="container">
            <div class="row">
                <!-- First Bucket Data -->
                <?php $first_bucket_background_image = get_field('bucket_background_image', $first_bucket_post_id); ?>
                <?php $first_bucket_content = get_field('bucket_content', $first_bucket_post_id); ?>
                <?php $first_bucket_show_only_the_background_image = get_field('show_only_the_background_image', $first_bucket_post_id); ?>
                <?php $first_bucket_title = get_the_title($first_bucket_post_id); ?>
                <div class="col-xs-4 col-md-4 without-margin-right bucket_item without-margin-left-md">
                    <?php if ($first_bucket_show_only_the_background_image == 1): ?>
                        <img src="<?php echo $first_bucket_background_image ?>" alt="<?php echo $first_bucket_title; ?>" class="img-responsive img-full">
                    <?php else: ?>
                        <div class="widget_bgimage">
                            <div class="image">
                                <img src="<?php echo $first_bucket_background_image ?>" alt="<?php echo $first_bucket_title; ?>" class="img-responsive img-full">
                            </div>
                            <div class="content_widget_bgimage">
                                <div class="tile">
                                    <a href="#">   
                                        <?php echo $first_bucket_title ?>
                                    </a>
                                </div>
                                <div class="text">
                                    <?php echo $first_bucket_content ?>             
                                </div>
                            </div>
                        </div>   
                    <?php endif; ?>
                </div>
                <!-- End First Bucket Data -->
                <!-- Second Bucket Data -->
                <?php $second_bucket_background_image = get_field('bucket_background_image', $second_bucket_post_id); ?>
                <?php $second_bucket_content = get_field('bucket_content', $second_bucket_post_id); ?>
                <?php $second_bucket_show_only_the_background_image = get_field('show_only_the_background_image', $second_bucket_post_id); ?>
                <?php $second_bucket_title = get_the_title($second_bucket_post_id); ?>
                <div class="col-xs-4 col-md-4 without-margin-left without-margin-right bucket_item">
                    <?php if ($second_bucket_show_only_the_background_image == 1): ?>
                        <img src="<?php echo $second_bucket_background_image ?>" alt="<?php echo $second_bucket_title; ?>" class="img-responsive img-full">
                    <?php else: ?>
                        <div class="widget_bgimage">
                            <div class="image">
                                <img src="<?php echo $second_bucket_background_image ?>" alt="<?php echo $second_bucket_title; ?>" class="img-responsive img-full">
                            </div>
                            <div class="content_widget_bgimage">
                                <div class="tile">
                                    <a href="#">   
                                        <?php echo $second_bucket_title ?>
                                    </a>
                                </div>
                                <div class="text">
                                    <?php echo $second_bucket_content ?>             
                                </div>
                            </div>
                        </div>   
                    <?php endif; ?>
                </div>
                <!-- End Second Bucket Data -->
                <!-- Third Bucket Data -->
                <?php $third_bucket_background_image = get_field('bucket_background_image', $third_bucket_post_id); ?>
                <?php $third_bucket_content = get_field('bucket_content', $third_bucket_post_id); ?>
                <?php $third_bucket_show_only_the_background_image = get_field('show_only_the_background_image', $third_bucket_post_id); ?>
                <?php $third_bucket_title = get_the_title($third_bucket_post_id); ?>
                <div class="col-xs-4 col-md-4 without-margin-left without-margin-right bucket_item">
                    <?php if ($third_bucket_show_only_the_background_image == 1): ?>
                        <img src="<?php echo $third_bucket_background_image ?>" alt="<?php echo $third_bucket_title; ?>" class="img-responsive img-full">
                    <?php else: ?>
                        <div class="widget_bgimage">
                            <div class="image">
                                <img src="<?php echo $third_bucket_background_image ?>" alt="<?php echo $third_bucket_title; ?>" class="img-responsive img-full">
                            </div>
                            <div class="content_widget_bgimage">
                                <div class="tile">
                                    <a href="#">   
                                        <?php echo $third_bucket_title ?>
                                    </a>
                                </div>
                                <div class="text">
                                    <?php echo $third_bucket_content ?>             
                                </div>
                            </div>
                        </div>   
                    <?php endif; ?>
                </div>
                <!-- End Third Bucket Data -->
            </div>
        </div>
    </div>
    <!-- End Buckets -->
</section>
<?php get_footer(); ?>
