<?php get_header(); ?>

<!-- INNER HERO -->
<section class="inner-hero" style="background: linear-gradient(to top, rgba(13,36,99,0.85) 0%, transparent 50%), url('https://images.unsplash.com/photo-1576091160550-217359f42f8c?w=1600&q=80') center / cover;">
  <div class="container">
    <h1>Our Courses</h1>
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
