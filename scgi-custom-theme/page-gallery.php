<?php
/**
 * Template Name: Gallery Page
 */
get_header();
the_post();
$banner_img = get_the_post_thumbnail_url( null, 'full' )
    ?: get_template_directory_uri() . '/assets/images/banner-gallery.jpg';
?>

<?php get_template_part( 'template-parts/inner-hero', null, array(
    'title'      => get_the_title(),
    'image_url'  => $banner_img,
    'show_logos' => false,
) ); ?>

<?php get_template_part( 'template-parts/breadcrumb', null, array(
    'items' => array(
        array( 'label' => 'Home',    'url' => home_url( '/' ) ),
        array( 'label' => get_the_title() ),
    ),
) ); ?>

<section class="gallery sec-bg-blue bg-pattern" style="padding:80px 0;">
    <div class="container">
        <div class="tc" style="margin-bottom:50px;">
            <div class="sec-label">Glimpses of SCGI</div>
            <h2 class="sec-title">Our Gallery</h2>
            <p class="sec-sub">A glimpse into our academic excellence, clinical training, and vibrant campus life.</p>
        </div>
        <div class="gallery-grid">
            <?php
            $gallery = new WP_Query( array(
                'post_type'      => 'scgi_gallery',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ) );
            if ( $gallery->have_posts() ) : while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
                <div class="gallery-item">
                    <?php if ( has_post_thumbnail() ) :
                        the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) );
                    endif; ?>
                </div>
            <?php endwhile; wp_reset_postdata();
            else : ?>
                <p class="tc" style="color:rgba(255,255,255,0.6);grid-column:1/-1;">No gallery items yet. Add them via WordPress admin → Gallery.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_template_part( 'template-parts/cta-band' ); ?>
<?php get_footer(); ?>
