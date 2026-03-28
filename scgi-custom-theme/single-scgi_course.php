<?php get_header(); ?>

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

<!-- COURSE DETAIL CONTENT -->
<section class="detail-section sec-bg-light" style="padding-top: 80px;">
  <div class="container">
    <div class="detail-grid">
      <div class="detail-text">
        <h2 class="sec-title" style="margin-bottom: 24px;"><?php the_title(); ?></h2>
        <div class="sec-sub" style="margin-bottom: 30px; line-height: 1.8;"><?php the_content(); ?></div>
        <div style="display: flex; gap: 15px;">
          <a href="<?php echo esc_url(home_url('/contact')); ?>#enquire" class="btn-primary">Enquire Now</a>
          <a href="#" class="btn-outline">Download Brochure</a>
        </div>
      </div>
      <div class="detail-img">
        <?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); else : ?>
            <img src="https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?w=800&q=80" alt="<?php the_title(); ?>" />
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- WHY SECTION -->
<?php 
$why_text = get_post_meta( get_the_ID(), '_course_why_text', true );
$why_points_raw = get_post_meta( get_the_ID(), '_course_why_points', true );
if ( $why_text || $why_points_raw ) :
?>
<section class="why-section sec-bg-blue bg-pattern">
  <div class="container">
    <div class="tc" style="margin-bottom: 50px;">
      <h2 class="sec-title">Answer for Why <?php the_title(); ?></h2>
      <p class="sec-sub"><?php echo esc_html($why_text); ?></p>
    </div>
    <?php if ( $why_points_raw ) : 
        $points = explode( "\n", str_replace( "\r", "", $why_points_raw ) );
    ?>
    <div style="max-width: 900px; margin: 0 auto; line-height: 1.8; color: var(--text);">
      <ul style="list-style: none; padding: 0; margin-top: 15px; display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
        <?php foreach ( $points as $point ) : if ( trim($point) ) : ?>
            <li style="color: #fff;"><i class="fas fa-check-circle" style="color: var(--gold); margin-right: 10px;"></i> <?php echo esc_html( trim($point) ); ?></li>
        <?php endif; endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ELIGIBILITY SECTION -->
<?php 
$eligibility = get_post_meta( get_the_ID(), '_course_eligibility', true );
$exam_info = get_post_meta( get_the_ID(), '_course_exam_info', true );
if ( $eligibility || $exam_info ) :
?>
<section class="detail-section sec-bg-light">
  <div class="container">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 60px;">
      <div>
        <h3 style="font-family: 'GT Super Ds', serif; font-size: 1.8rem; color: var(--blue-dark); margin-bottom: 20px;">Eligibility</h3>
        <p style="line-height: 1.8;"><?php echo esc_html($eligibility); ?></p>
      </div>
      <div>
        <h3 style="font-family: 'GT Super Ds', serif; font-size: 1.8rem; color: var(--blue-dark); margin-bottom: 20px;">Eligibility for Examination</h3>
        <p style="line-height: 1.7; font-size: 0.95rem;"><?php echo esc_html($exam_info); ?></p>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- FACILITIES -->
<?php get_template_part( 'template-parts/facilities' ); ?>

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

<?php endwhile; endif; ?>

<?php get_footer(); ?>
