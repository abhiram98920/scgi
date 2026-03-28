<!-- OUR FACILITY -->
<section class="fac-section sec-bg-light">
  <div class="container">
    <div class="tc">
      <h2 class="sec-title">Our <em>Facility</em></h2>
    </div>
    <div class="fac-grid">
      <?php
      $facilities = new WP_Query( array( 'post_type' => 'scgi_logo', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
      if ( $facilities->have_posts() ) : while ( $facilities->have_posts() ) : $facilities->the_post(); ?>
        <div class="fac-item">
          <div class="fac-icon"><?php the_post_thumbnail('thumbnail'); ?></div>
          <h4><?php the_title(); ?></h4>
          <p><?php the_content(); ?></p>
        </div>
      <?php endwhile; wp_reset_postdata(); else : ?>
        <p>No facilities found. Please add them in the Logos CPT with a "Facility" tag (or similar logic).</p>
      <?php endif; ?>
    </div>
  </div>
</section>
