<?php if (have_posts()) : ?>
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <?php $i = 0; ?>
        <?php $i++; ?>
        <?php $external_link = get_field('external_link'); ?>
        <div class="fullwidth">
            <div class="container">
                <div <?php post_class('blog-post clearfix row'); ?> id="post-<?php the_ID(); ?>">
                    <div class="col-sm-3">
                        <?php $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                        <?php $imgurl = $src[0]; ?>
                        <div class="post-img-wrapper-details img-thumbnail-detail">
                            <img class="img-responsive" src="<?php echo $imgurl; ?>"  alt="<?php echo $post->post_title ?>" />
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="press_rigth">
                            <div class="date_article"><?php print_post_date(); ?></div>
                            <div class="title_article"> <a href="<?php the_permalink() ?>"><?php echo $post->post_title ?> <?php if (!empty($team_member_qualifications)): ?> <span class="team_member_location"><?php echo $team_member_qualifications; ?> <?php endif; ?></span> </a> </div>
                            <div class="description_article" class="radikal_light_team">
                                <?php $post_excerpt = $post->post_excerpt; ?>
                                <?php if (!empty($post_excerpt)): ?>
                                    <?php echo $post_excerpt; ?>
                                <?php else: ?>
                                    <?php the_content(); ?>
                                <?php endif; ?>
                            </div>
                            <div class="read-more">
                                <?php if (!empty($external_link)): ?>
                                    <a target="_blank" href="<?php echo $external_link ?>">LEARN MORE <i class="fa fa-angle-right"></i></a>
                                <?php else: ?>
                                    <a href="<?php the_permalink() ?>">LEARN MORE</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <?php
                        if (($wp_query->current_post + 1) != $wp_query->post_count)
                            echo '<hr class="post-divider" />';
                        else
                            echo '<hr class="invisible" />';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
<?php else : ?>
    <h2 class="blog-title">Not Found</h2>
<?php endif; ?>
<div class="clear"></div>
