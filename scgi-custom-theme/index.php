<?php get_header(); ?>

<section class="page-content" style="padding: 100px 0;">
  <div class="container tc">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <div class="sec-sub"><?php the_content(); ?></div>
    <?php endwhile; endif; ?>
  </div>
</section>

<?php get_footer(); ?>
