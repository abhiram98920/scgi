<?php get_header(); ?>

<?php 
  $banner_img = get_template_directory_uri() . '/assets/images/banner-courses-main.png'; 
  $page_title = 'Our Courses';
  
  if ( is_tax('course_category', 'nursing') ) {
      $banner_img = get_template_directory_uri() . '/assets/images/banner-nursing.png';
      $page_title = 'Nursing Department';
  } elseif ( is_tax('course_category', 'physiotherapy') ) {
      $banner_img = get_template_directory_uri() . '/assets/images/banner-physiotherapy.png';
      $page_title = 'Physiotherapy Department';
  } elseif ( is_tax('course_category', 'allied-health-science') ) {
      $banner_img = get_template_directory_uri() . '/assets/images/banner-allied-health.png';
      $page_title = 'Allied Health Sciences';
  }
?>

<!-- INNER HERO -->
<section class="inner-hero" style="background: linear-gradient(to top, rgba(13,36,99,0.85) 0%, transparent 50%), url('<?php echo esc_url($banner_img); ?>') center / cover;">
  <div class="container">
    <div class="hero-badges-wrap">
        <?php
        $logos = new WP_Query( array( 'post_type' => 'scgi_logo', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
        if ( $logos->have_posts() ) : while ( $logos->have_posts() ) : $logos->the_post();
            if ( has_post_thumbnail() ) : ?>
                <div class="hero-badge-item">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title_attribute(); ?>" class="hero-badge-img">
                    <span><?php the_title(); ?></span>
                </div>
            <?php endif; ?>
        <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
    <h1><?php echo esc_html($page_title); ?></h1>
  </div>
</section>

<!-- BREADCRUMB BAR -->
<div class="breadcrumb-bar">
  <div class="container">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> 
      <i class="fas fa-circle"></i> 
      <span>Courses</span>
    </div>
  </div>
</div>

<section class="courses-archive" style="padding: 80px 0;">
  <div class="container">
    <div class="tc" style="margin-bottom: 50px;">
        <h2 class="sec-title">Explore Our Programmes</h2>
        <p class="sec-sub">Specialized training in Nursing, Allied Health, and Physiotherapy.</p>
    </div>

    <div class="courses-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="kmct-card">
                <div class="kc-img"><?php the_post_thumbnail('medium'); ?></div>
                <div class="kc-overlay"></div>
                <div class="kc-content">
                    <h3><?php the_title(); ?></h3>
                    <div class="kc-hidden">
                        <div class="kc-hidden-inner"><div class="kc-btn primary">Know More</div></div>
                    </div>
                </div>
            </a>
        <?php endwhile; else : ?>
            <p>No courses found.</p>
        <?php endif; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
