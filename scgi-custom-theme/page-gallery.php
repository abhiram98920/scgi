<?php
/**
 * Template Name: Gallery Page
 */
get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<!-- INNER HERO -->
<section class="inner-hero" style="background: linear-gradient(to top, rgba(13,36,99,0.85) 0%, transparent 50%), url('<?php echo get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1600&q=80'; ?>') center / cover;">
  <div class="container">
    <h1>Campus Glimpses</h1>
  </div>
</section>

<!-- BREADCRUMB BAR -->
<div class="breadcrumb-bar">
  <div class="container">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> 
      <i class="fas fa-circle"></i> 
      <span>Gallery</span>
    </div>
  </div>
</div>

<section style="padding: 100px 0;">
  <div class="container">
    <div class="sec-label" style="justify-content: center;"><?php echo esc_html( get_theme_mod('scgi_gallery_label', 'Campus Life') ); ?></div>
    <h2 class="sec-title" style="text-align: center; margin-bottom: 50px;"><?php echo esc_html( get_theme_mod('scgi_gallery_title', 'Photo Gallery') ); ?></h2>
    
    <div class="hero-badges-wrap reveal" style="margin-top:20px; justify-content: center;">
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
        <div class="hero-badge-item">
            <img src="<?php echo get_template_directory_uri(); ?>/ka-govt-cropped.png" alt="Govt-Recognised" class="hero-badge-img">
            <span>Recognised by Govt of Karnataka</span>
        </div>
    </div>
    
    <div class="gallery-grid reveal">
      <?php 
      // If there are gallery images attached to the page, display them.
      // Otherwise, show the default placeholders from gallery.html.
      $images = get_post_meta( get_the_ID(), '_gallery_images', true );
      if ( $images && is_array( $images ) ) :
          foreach ( $images as $img_id ) :
              $img_url = wp_get_attachment_image_url( $img_id, 'large' );
              ?>
              <div class="gallery-item">
                <img src="<?php echo esc_url( $img_url ); ?>" alt="SCGI Campus" />
              </div>
              <?php
          endforeach;
      else : ?>
          <div class="gallery-item"><img src="https://images.unsplash.com/photo-1576091160550-217359f42f8c?w=800&q=80" alt="SCGI Lab" /></div>
          <div class="gallery-item"><img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&q=80" alt="Smart Classroom" /></div>
          <div class="gallery-item"><img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800&q=80" alt="Medical Training" /></div>
          <div class="gallery-item"><img src="https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?w=800&q=80" alt="SCGI Students" /></div>
          <div class="gallery-item"><img src="https://images.unsplash.com/photo-1591453089816-0fbb971b454c?w=800&q=80" alt="Computer Lab" /></div>
          <div class="gallery-item"><img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&q=80" alt="Learning Center" /></div>
          <div class="gallery-item"><img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&q=80" alt="SCGI Campus" /></div>
          <div class="gallery-item"><img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?w=800&q=80" alt="Institutional Facility" /></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
