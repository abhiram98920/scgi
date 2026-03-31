<?php
/**
 * Template Name: About Page
 */
get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

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
        <div class="sec-label"><?php echo esc_html( get_theme_mod('scgi_about_label', 'ABOUT SCGI COLLEGE OF NURSING') ); ?></div>
        <h2 class="sec-title"><?php echo esc_html( get_theme_mod('scgi_about_title', 'Overview') ); ?></h2>
        <div class="sec-sub" style="margin-bottom: 24px;">
            <?php the_content(); ?>
        </div>
        
        <div class="hero-badges-wrap reveal" style="margin: 24px 0; justify-content: flex-start; gap: 20px;">
            <div class="hero-badge-item">
                <img src="<?php echo get_template_directory_uri(); ?>/inc-cropped.png" alt="INC-Approved" class="hero-badge-img">
                <span>Approved by<br>Indian Nursing Council</span>
            </div>
            <div class="hero-badge-item">
                <img src="<?php echo get_template_directory_uri(); ?>/ksnc-cropped.png" alt="KSNC-Approved" class="hero-badge-img">
                <span>Approved by<br>Karnataka State Nursing Council</span>
            </div>
            <div class="hero-badge-item">
                <img src="<?php echo get_template_directory_uri(); ?>/Karnataka state diploma in nursing examination board.png" alt="KSDNEB" class="hero-badge-img">
                <span>KSDNEB</span>
            </div>
            <div class="hero-badge-item">
                <img src="<?php echo get_template_directory_uri(); ?>/Logo of Karnataka paramedical board.webp" alt="Paramedical-Board" class="hero-badge-img">
                <span>Karnataka Paramedical Board</span>
            </div>
        </div>
      </div>
      <div class="about-img-col">
        <img src="<?php echo get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&q=80'; ?>" alt="SCGI Campus Building" />
        <div class="img-accent-box">
          <i class="fas fa-play"></i>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MISSION & VISION (HIGHLIGHTS STYLE) -->
<section class="mv-highlights sec-bg-blue bg-pattern">
  <div class="container">
    <h2 class="sec-title" style="margin-bottom: 50px;"><?php echo esc_html( get_theme_mod('scgi_mv_title', 'Our Core Philosophy') ); ?></h2>
    <div class="mv-grid">
      <div class="mv-card">
        <div class="mv-content">
          <h3>Mission</h3>
          <p><?php echo esc_html( get_theme_mod('scgi_mission_text', 'We aim to deliver a nurturing ground and a positive learning environment which ensures student well-being & academic success.') ); ?></p>
        </div>
      </div>
      <div class="mv-card">
        <div class="mv-content">
          <h3>Vision</h3>
          <p><?php echo esc_html( get_theme_mod('scgi_vision_text', 'Promoting educational, cultural, social and charitable advancement for excellence.') ); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- BANNER CTA -->
<?php get_template_part('template-parts/cta-band'); ?>

<!-- COUNSELLOR / CTA -->
<section class="cta-band" id="enquire" style="background: var(--blue-dark); padding: 80px 0;">
  <div class="container">
    <div class="sec-label" style="justify-content: center;"><?php echo esc_html( get_theme_mod('scgi_counsellor_label', 'Contact Our Counsellor') ); ?></div>
    <h2 class="sec-title" style="color: #fff; text-align: center; margin-bottom: 14px;"><?php echo esc_html( get_theme_mod('scgi_counsellor_title', 'Clarify all you doubts about the course, fees, college and more') ); ?></h2>
    <div class="cta-actions" style="margin-top: 36px; display: flex; justify-content: center; gap: 20px;">
      <a href="tel:<?php echo esc_attr( get_theme_mod('scgi_phone', '+919947915916') ); ?>" class="btn-gold"><i class="fas fa-phone-alt"></i>Call Now</a>
      <a href="https://wa.me/<?php echo esc_attr( str_replace(' ', '', get_theme_mod('scgi_whatsapp', '919769002277')) ); ?>" class="btn-outline-w" target="_blank"><i class="fab fa-whatsapp"></i>WhatsApp Us</a>
    </div>
  </div>
</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
