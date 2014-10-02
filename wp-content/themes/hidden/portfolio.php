<?php
/**
 * The main template file.
 * Template Name: Portfolio
 *
 
 */

get_header(); ?>
<?php global $post;
$tmp_post = $post;
$per_page = get_option('posts_per_page');
$posts_count = wp_count_posts('post')->publish;
$paged = intval(get_query_var('paged'));
if(empty($paged) || $paged == 0) $paged = 1;
$i = 0;
?>
<!--container-->
<section id="container">
	<?php if(get_option('afl_breadcrumbs_enable') == 'open'):?>

    <!--breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumb-line">
                <?php echo get_option('breadcrumbs_text'); ?> <a href="<?php echo home_url(); ?>"><?php echo BREADCRUMBS_HOME_TEXT ?></a><?php echo BREADCRUMBS_DIVIDER ?><?php the_title();?>
            </div>
        </div>
    </div>

	<?php endif; ?>

    <div class="container">
        <div class="row">
            <?php
            $cur_id = get_queried_object_id(); /* Title */
            $pageTitle = get_post_meta($cur_id, 'pageTitle', true);
            $pageSlogan = get_post_meta($cur_id, 'pageSlogan', true);
            ?>
            <div class="col-sm-12">
                <hr class="before-title"/>
                <div class="title-divider clearfix">
                    <h1 class="page-title">
                        <?php // title
                        if ($pageTitle): echo $pageTitle;
                        else: echo get_the_title($cur_id); endif ?>
                    </h1>
                    <div class="clearfix visible-xs"></div>
                    <?php // slogan
                    if ($pageSlogan): echo '<small class="page-title-small">' . $pageSlogan . '</small>'; endif; ?>
                </div>
                <hr class="after-title"/>
            </div>
        </div>
    </div>

    <div class="container">
		<?php
		$portfolio_settings = get_portfolio_settings($post->ID);
		switch($portfolio_settings['num_cols']){
			case 2: $col_width = 'col-sm-6';break;
			case 4: $col_width = 'col-sm-3';break;
			default: $col_width = 'col-sm-4';break;
		}
		$orderby = 'date';
		$order = 'DESC';
		switch($portfolio_settings['portfolio_sort']){
			case 'Randomize': $orderby = 'rand'; $order = ''; break;
			case 'None':
			case '':break;
			default:
				$params = explode(' ', $portfolio_settings['portfolio_sort']);
				$orderby = strtolower($params[0]);
				$order = $params[1];
				break;
		}

		$args=array(
			'post_type' => 'portfolio',
			'posts_per_page' => 199,
			'orderby' => $orderby,
			'order' => $order
		);
		$temp = $wp_query;
		$wp_query = null;
		$wp_query = new WP_Query($args);
		$terms = get_terms('portfoliocat');

		if ($wp_query->have_posts()) :
		?>
        <!--filter-->
        <ul id="filtrable" class="clearfix page-type">
			<?php
			echo '<li class="current all"><a href="#" data-filter="*">All</a></li>';
			foreach ( $terms as $term ) {
				$filter_last_item = end($terms);
				echo '<li class="'.strtolower(str_replace(" ", "-", $term->name)).'"><a href="#" data-filter=".'.strtolower(str_replace(" ", "-", $term->name)).'">'.$term->name.'</a></li>';
			}
			?>
        </ul>

        <div class="clear"></div>

        <section class="row do-thumbs portfolio filtrable isotope">
			<?php $i=0;
			while ( $wp_query->have_posts() ) : $wp_query->the_post();
				$i++;
				$custom = get_post_custom($post->ID);
				$foliocatlist = get_the_term_list( $post->ID, 'portfoliocat', '', ', ', '' );
				$entrycategory = get_the_term_list( $post->ID, 'portfoliocat', '', '_', '' );
				$entrycategory = strip_tags($entrycategory);
				$entrycategory = strtolower($entrycategory);
				$entrycategory = str_replace(' ', '-', $entrycategory);
				$entrycategory = str_replace('_', ' ', $entrycategory);
				$entrytitle = get_the_title();
				$blogimageurl = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
				if($blogimageurl==""){
					$blogimageurl = get_template_directory_uri().'/images/blank.jpg';
				}
				?>
				<article data-id="id-<?php echo $post->ID; ?>" data-type="<?php echo $entrycategory ?>" class="<?php echo $col_width . ' ' . $entrycategory ?> isotope-item">
					<div class="do-img do-media">
						<?php  $src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
						<?php if (has_post_thumbnail()) {
						$imgurl = $src[0];
                            $default_attr = array(
                                'class'	=> "attachment-portfolio img-responsive",
                            );
						the_post_thumbnail('portfolio', $default_attr);
						//the_post_thumbnail('portfolio');
					} else {
						$imgurl = $blogimageurl;
						echo '<img class="img-responsive" src="'.$imgurl.'"  alt="'.$post->post_title.'" />';
					} ?>
						<div class="do-hover">
							<a class="do-img-link" href="<?php echo $imgurl ?>" data-rel="prettyPhoto"><i class="fa fa-search"></i></a>
							<a class="do-url-link" href="<?php the_permalink() ?>"><i class="fa fa-link"></i></a>
						</div>
					</div>
					<?php if(isset($portfolio_settings['portfolio_type'])&&$portfolio_settings['portfolio_type']==1) { ?>
						<h3 class="title"><a href="<?php the_permalink() ?>"><?php echo $post->post_title ?></a></h3>
						<div class="excerpt"><?php echo ((!empty($post->post_excerpt)) ? $post->post_excerpt : content()) ?></div>
						<a href="<?php the_permalink() ?>" class="read-more btn btn-info"><?php echo (get_option('afl_readmore') == '') ?  'Read More ...' : get_option('afl_readmore') ?></a>
					<?php } ?>
				</article>
                <?php endwhile; ?>
               <?php else : ?>
               <h3>Oops, we could not find what you were looking for...</h3>
               <?php endif; ?>

               <?php
               $wp_query = null;
               $wp_query = $temp;
               wp_reset_query();
               ?>
       </section>
    </div>
</section>

<?php get_footer(); ?>
