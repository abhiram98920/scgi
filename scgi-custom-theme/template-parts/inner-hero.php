<?php
/**
 * Template Part: Inner Hero Banner
 * Usage: get_template_part('template-parts/inner-hero', null, $args)
 *
 * Accepts $args array:
 *   'title'      => Page/Term title (string)
 *   'image_url'  => Full URL of background image
 *   'show_logos' => true/false — show accreditation logos
 */
$title      = $args['title']      ?? get_the_title();
$image_url  = $args['image_url']  ?? get_the_post_thumbnail_url( null, 'full' );
$show_logos = $args['show_logos'] ?? true;

if ( ! $image_url ) {
    $image_url = get_template_directory_uri() . '/assets/images/banner-default.jpg';
}
?>
<section class="inner-hero" style="background: linear-gradient(to top, rgba(13,36,99,0.85) 0%, transparent 50%), url('<?php echo esc_url( $image_url ); ?>') center / cover no-repeat;">
    <div class="container">
        <?php if ( $show_logos ) : ?>
            <?php get_template_part( 'template-parts/accreditation-logos' ); ?>
        <?php endif; ?>
        <h1><?php echo esc_html( $title ); ?></h1>
    </div>
</section>
