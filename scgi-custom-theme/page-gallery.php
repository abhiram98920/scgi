<?php 
/**
 * Template Name: Gallery Page
 */
get_header(); ?>

<!-- INNER HERO -->
<section class="inner-hero" style="background: linear-gradient(to top, rgba(13,36,99,0.85) 0%, transparent 50%), url('<?php echo get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : 'https://images.unsplash.com/photo-1541339907198-e08756ebafe3?w=1600&q=80'; ?>') center / cover;">
  <div class="container">
    <h1><?php the_title(); ?></h1>
  </div>
</section>

<!-- BREADCRUMB BAR -->
<div class="breadcrumb-bar">
  <div class="container">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> 
      <i class="fas fa-circle"></i> 
      <span><?php the_title(); ?></span>
    </div>
  </div>
</div>

<section class="gallery-section" style="padding: 80px 0;">
  <div class="container">
    <div class="gallery-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px;">
        <?php
        $gallery = new WP_Query( array( 'post_type' => 'scgi_gallery', 'posts_per_page' => -1 ) );
        if ( $gallery->have_posts() ) : while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
            <div class="gallery-item" style="position: relative; border-radius: 12px; overflow: hidden; height: 300px;">
                <?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large', array( 'style' => 'width:100%; height:100%; object-fit:cover;' ) ); endif; ?>
            </div>
        <?php endwhile; wp_reset_postdata(); else : ?>
            <p>No gallery items found. Please add them in the WordPress admin.</p>
        <?php endif; ?>
    </div>
  </div>
</section>

<!-- BANNER CTA -->
<section class="banner-cta">
  <div class="container flex-cta">
    <div class="cta-text">
      <h3>Guiding You Towards a Bright Career</h3>
      <p>Reach Out for Admissions, Queries & More</p>
    </div>
    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn-gold"><i class="fas fa-paper-plane"></i>Contact Us</a>
  </div>
</section>

<?php get_footer(); ?>
