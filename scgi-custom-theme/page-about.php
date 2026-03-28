<?php 
/**
 * Template Name: About Page
 */
get_header(); ?>

<!-- INNER HERO -->
<section class="inner-hero" style="background: linear-gradient(to top, rgba(13,36,99,0.85) 0%, transparent 50%), url('<?php echo get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1600&q=80'; ?>') center / cover;">
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

<!-- ABOUT OVERVIEW -->
<section class="about-overview sec-bg-light" id="about">
  <div class="container">
    <div class="about-grid-new">
      <div class="about-text-col">
        <div class="sec-label">ABOUT SCGI</div>
        <h2 class="sec-title"><?php echo esc_html(get_theme_mod('scgi_about_heading', 'Overview')); ?></h2>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="sec-sub"><?php the_content(); ?></div>
        <?php endwhile; endif; ?>
      </div>
      <div class="about-img-col">
        <?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); else : ?>
            <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&q=80" alt="SCGI Campus" />
        <?php endif; ?>
        <div class="img-accent-box"><i class="fas fa-play"></i></div>
      </div>
    </div>
  </div>
</section>

<!-- MISSION & VISION -->
<section class="mv-highlights sec-bg-blue bg-pattern">
  <div class="container">
    <h2 class="sec-title" style="margin-bottom: 50px;">Our Core Philosophy</h2>
    <div class="mv-grid">
      <div class="mv-card">
        <div class="mv-content">
          <h3>Mission</h3>
          <p><?php echo esc_html(get_theme_mod('scgi_mission', 'We aim to deliver a nurturing ground and a positive learning environment which ensures student well-being & academic success.')); ?></p>
        </div>
      </div>
      <div class="mv-card">
        <div class="mv-content">
          <h3>Vision</h3>
          <p><?php echo esc_html(get_theme_mod('scgi_vision', 'Promoting educational, cultural, social and charitable advancement for excellence.')); ?></p>
        </div>
      </div>
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
