<?php
/**
 * Displays header media
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */


global $wp;
$url_parse = wp_parse_url(home_url( $wp->request ));
$path = $url_parse['path'];
$temp = end(explode('/',$path));
$con = str_replace('-','_',$temp);

global $wpdb;

$conPage = $wpdb->get_row("SELECT page FROM " . $wpdb->prefix . "link_pattern WHERE page_url='$temp' ");


$cpage = $conPage->page;

?>

<section id="intro" <?php if (!is_front_page()) { ?> style="height: 60vh;" <?php } ?>>
    <div class="intro-container">
        <div id="introCarousel" class="carousel  slide carousel-fade intro-carousel" data-ride="carousel">

            <ol class="carousel-indicators intro-carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">

                <?php

                if (is_front_page()) {

                    $all_images = get_all_header_data();
                    $i = 0;
                    foreach ($all_images as $headerImg) {
                        ?>
                        <div class="carousel-item<?php if ($i == 0) echo ' active'; ?>"
                             style="background-image: url('<?php echo $headerImg["url"]; ?>'); <?php if (!is_front_page()) { ?> height: 60vh; <?php } ?>">
                            <div class="carousel-container">
                                <div class="carousel-content">
                                </div>
                            </div>
                        </div>

                        <?php
                        $i++;
                    }

                } else {

                    global $wpdb;

                    $cimages = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "carousel_image WHERE page='$cpage' AND image<>'NaN' ");

                    if ($cimages) {
                        $i = 0;
                        foreach ($cimages as $cimage) {
                            $attachmentImg = wp_get_attachment_image_src($cimage->image, full);
                            if ($attachmentImg) {
                                ?>
                                <div class="carousel-item<?php if ($i == 0) echo ' active'; ?>"
                                     style="background-image: url('<?php echo $attachmentImg[0] ?>'); <?php if (!is_front_page()) { ?> height: 60vh; <?php } ?>">
                                    <div class="carousel-container">
                                        <div class="carousel-content">
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="carousel-item<?php if ($i == 0) echo ' active'; ?>"
                                     style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/wanabima%20683x1024.png'); <?php if (!is_front_page()) { ?> height: 60vh; <?php } ?>"></div>

                                <?php
                            }
                            $i++;
                        }
                    }else{
                        ?>
                        <div class="carousel-item<?php if ($i == 0) echo ' active'; ?>"
                             style="background-image: url('<?php echo get_template_directory_uri(); ?>/img/wanabima%20683x1024.png'); <?php if (!is_front_page()) { ?> height: 60vh; <?php } ?>"></div>

                        <?php
                    }
                }

                ?>

                <!-- has_header_video -->
                <?php if (is_front_page()) { ?>
                    <div class="carousel-item">
                        <div class="carousel-container">
                            <div class="carousel-content">
                                <video class="video-fluid intro-carousel-video" autoplay
                                       loop <?php if (!is_front_page()) { ?> style="height: 60vh;" <?php } ?>>
                                    <source src="<?php echo get_header_video_url(); ?>"
                                            type="video/mp4" <?php if (!is_front_page()) { ?> style="height: 60vh;" <?php } ?> />
                                </video>
                            </div>
                        </div>
                    </div>
                <?php } ?>


            </div>

            <a class="carousel-control-prev" href="#introCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon ion-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#introCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon ion-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
</section><!-- #intro -->