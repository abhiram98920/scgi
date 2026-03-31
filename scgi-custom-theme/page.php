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

<section class="page-content" style="padding: 100px 0;">
  <div class="container">
    <div class="content-body" style="line-height: 1.8; color: var(--text);">
        <?php the_content(); ?>
    </div>
  </div>
</section>

<!-- BANNER CTA -->
<?php get_template_part('template-parts/cta-band'); ?>

<!-- COUNSELLOR / CTA -->
<section class="cta-band" id="enquire" style="background: var(--blue-dark); padding: 80px 0;">
  <div class="container">
    <div class="tc" style="text-align: center;">
      <div class="sec-label" style="justify-content: center; color: var(--gold-pale);">Contact Our Counsellor</div>
      <h2 class="sec-title" style="color: #fff; text-align: center; margin-bottom: 14px;">Clarify all you doubts about the course, fees, college and more</h2>
      <div class="cta-actions" style="margin-top: 36px; display: flex; justify-content: center; gap: 20px;">
        <a href="tel:<?php echo esc_attr( get_theme_mod('scgi_phone', '+919947915916') ); ?>" class="btn-gold"><i class="fas fa-phone-alt"></i> Call Now</a>
        <a href="https://wa.me/<?php echo esc_attr( str_replace(' ', '', get_theme_mod('scgi_whatsapp', '919769002277')) ); ?>" class="btn-outline-w" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp Us</a>
      </div>
    </div>
  </div>
</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
