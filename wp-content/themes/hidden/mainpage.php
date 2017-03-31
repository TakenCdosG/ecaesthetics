<?php
/**
 * The main template file.
 * Template Name: MainPage
 *

 */
get_header();
?>

<?php $images = array(); ?>
<?php $num_photo = 7; ?>
<?php for ($i = 1; $i <= $num_photo; $i++): ?>
    <?php $tmp = get_field('image_' . $i); ?>
    <?php if ($tmp != false): ?>
        <?php $images[] = $tmp; ?>
    <?php endif; ?>
<?php endfor; ?>

<?php $lenght = count($images); ?>
<?php $key = rand(0, $lenght - 1); ?>
<?php $uri = $images[$key]; ?>

<?php //die(var_dump($images)); ?>

<?php $homepage_photos_text = get_field('homepage_photos_text'); ?>

<!-- First_Box -->
<?php $first_box_link = get_field('first_box_link'); ?>
<?php $first_box_text = get_field('first_box_text'); ?>
<!-- End First_Box -->

<!-- Second_Box -->
<?php $second_box_link = get_field('second_box_link'); ?>
<?php $second_box_text = get_field('second_box_text'); ?>
<!-- End Second_Box -->

<!-- Third_Box -->
<?php $third_box_link = get_field('third_box_link'); ?>
<?php $third_box_text = get_field('third_box_text'); ?>
<!-- End Third_Box -->

<!--container-->
<section id="container">
    <?php if (!empty($uri)): ?>
        <section class="container">
            <div id="" class="fullwidth no-sidebar">
                <ul class="slides">
                    <li>
                        <div id="header_image" style="background-image:url('<?php echo $uri ?>');
                             -webkit-background-size: cover;
                             -moz-background-size: cover;
                             -o-background-size: cover;
                             -ms-background-size: cover;
                             background-size: cover;
                             background-position: 50% 50%;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="option-wrapper">
                                            <div id="option">
                                                <div id="title_option">
                                                    <?php echo $homepage_photos_text; ?>
                                                </div>
                                                <a href="<?php echo $first_box_link; ?>">
                                                    <div id="" class="option">
                                                        <?php echo $first_box_text; ?>
                                                    </div>
                                                </a>
                                                <a href="<?php echo $second_box_link; ?>">
                                                    <div id="" class="option">
                                                        <?php echo $second_box_text; ?>
                                                    </div>
                                                </a>
                                                <a href="<?php echo $third_box_link; ?>">
                                                    <div id="" class="option">
                                                        <?php echo $third_box_text; ?>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
    <?php endif; ?>
    <?php $first_main_text = get_field('first_main_text'); ?>
    <?php if (!empty($first_main_text)): ?>
        <div class="container without-padding-bottom">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-text clearfix style_one_home">
                        <?php echo $first_main_text; ?>
                        <div class="clearfix visible-xs"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Buckets -->
    <?php $first_bucket_post_id = get_field('first_bucket'); ?>
    <?php $first_bucket_post_id = isset($first_bucket_post_id[0]) ? $first_bucket_post_id[0] : $first_bucket_post_id; ?>
    <?php $second_bucket_post_id = get_field('second_bucket'); ?>
    <?php $second_bucket_post_id = isset($second_bucket_post_id[0]) ? $second_bucket_post_id[0] : $second_bucket_post_id; ?>
    <?php $third_bucket_post_id = get_field('third_bucket'); ?>
    <?php $third_bucket_post_id = isset($third_bucket_post_id[0]) ? $third_bucket_post_id[0] : $third_bucket_post_id; ?>


    <?php $second_main_text = get_field('second_main_text'); ?>
    <?php if (!empty($second_main_text)): ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="main-text clearfix style_two_home">
                        <?php echo $second_main_text; ?>
                        <div class="clearfix visible-xs"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
<?php get_footer(); ?>
