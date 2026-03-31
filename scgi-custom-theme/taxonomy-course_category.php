<?php
/**
 * Template Part: Course Category Archive
 */
get_header(); 
$current_cat = get_queried_object();
?>

<!-- INNER HERO -->
<section class="inner-hero" style="background: linear-gradient(to top, rgba(13,36,99,0.85) 0%, transparent 50%), url('<?php echo get_template_directory_uri(); ?>/img/course-hero-bg.jpg') center / cover;">
  <div class="container">
    <h1><?php echo esc_html( $current_cat->name ); ?> Courses</h1>
  </div>
</section>

<!-- BREADCRUMB BAR -->
<div class="breadcrumb-bar">
  <div class="container">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> 
      <i class="fas fa-circle"></i> 
      <span>Courses</span>
      <i class="fas fa-circle"></i> 
      <span><?php echo esc_html( $current_cat->name ); ?></span>
    </div>
  </div>
</div>

<!-- OVERVIEW -->
<section style="padding: 70px 0 50px;">
  <div class="container tc" style="text-align: center;">
    <div class="sec-label" style="justify-content: center;">Our Academic Programmes</div>
    <h2 class="sec-title" style="margin-bottom: 20px;"><?php echo esc_html( $current_cat->name ); ?> Courses</h2>
    
    <div class="hero-badges-wrap reveal" style="margin:20px auto; justify-content: center;">
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
    
    <p class="sec-sub" style="margin: 0 auto 30px; font-size: 1.05rem; max-width: 800px;">
        <?php echo esc_html( $current_cat->description ?: 'Explore our comprehensive range of courses in ' . $current_cat->name . '.' ); ?>
    </p>
  </div>
</section>

<!-- COURSES GRID -->
<section class="sec-bg-blue bg-pattern" style="padding: 60px 0 100px;">
  <div class="container">
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 30px;">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
          $level      = get_post_meta( get_the_ID(), '_course_level', true ) ?: 'UG';
          $duration   = get_post_meta( get_the_ID(), '_course_duration', true ) ?: '3-4 Years';
          $short_desc = get_post_meta( get_the_ID(), '_course_short_desc', true ) ?: get_the_excerpt();
          $thumb      = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
      ?>
          <a href="<?php the_permalink(); ?>" class="kmct-card reveal">
            <div class="kc-img">
                <img src="<?php echo $thumb ?: 'https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?w=600&q=80'; ?>" alt="<?php the_title_attribute(); ?>">
            </div>
            <div class="kc-overlay"></div>
            <div class="kc-content">
              <div class="kc-badge"><?php echo esc_html( $level ); ?></div>
              <div class="kc-title"><?php the_title(); ?></div>
              <div class="kc-hidden">
                <div class="kc-hidden-inner">
                  <div class="kc-meta">
                    <div><p style="font-size:0.8rem; line-height:1.4; opacity:0.9;"><?php echo esc_html( $short_desc ); ?></p></div>
                    <div><i class="fas fa-clock"></i> <strong>Duration:</strong> <?php echo esc_html($duration); ?></div>
                  </div>
                  <div class="kc-actions">
                    <div class="kc-btn primary">Know More</div>
                    <div class="kc-btn outline"><i class="fas fa-download"></i> Brochure</div>
                  </div>
                </div>
              </div>
            </div>
          </a>
      <?php endwhile; endif; ?>
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
      <a href="<?php echo esc_url(home_url('/contact')); ?>#enquire" class="btn-gold"><i class="fas fa-paper-plane"></i> Enquire Now</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
