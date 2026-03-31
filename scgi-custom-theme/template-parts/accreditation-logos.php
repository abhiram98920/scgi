<?php
/**
 * Template Part: Accreditation Logos (Hero Badges)
 * Usage: get_template_part('template-parts/accreditation-logos')
 */
?>
<div class="hero-badges-wrap reveal">
    <?php
    $logos = new WP_Query( array(
        'post_type'      => 'scgi_logo',
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
        'posts_per_page' => -1,
    ) );
    if ( $logos->have_posts() ) : while ( $logos->have_posts() ) : $logos->the_post();
        if ( has_post_thumbnail() ) :
            $logo_url = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
    ?>
        <div class="hero-badge-item">
            <img src="<?php echo esc_url( $logo_url ); ?>"
                 alt="<?php the_title_attribute(); ?>"
                 class="hero-badge-img"
                 loading="lazy">
            <span><?php the_title(); ?></span>
        </div>
    <?php   endif; endwhile; wp_reset_postdata();
    else :
        // Fallback to static logos from theme directory
        $static_logos = array(
            array( 'img' => 'inc-cropped.png',    'label' => 'Approved by Indian Nursing Council' ),
            array( 'img' => 'ksnc-cropped.png',   'label' => 'Approved by Karnataka State Nursing Council' ),
            array( 'img' => 'ka-govt-cropped.png','label' => 'Recognised by Govt of Karnataka' ),
            array( 'img' => 'rguhs-cropped.png',  'label' => 'Affiliated to RGUHS' ),
        );
        foreach ( $static_logos as $logo ) :
    ?>
        <div class="hero-badge-item">
            <img src="<?php echo get_template_directory_uri() . '/' . esc_attr( $logo['img'] ); ?>"
                 alt="<?php echo esc_attr( $logo['label'] ); ?>"
                 class="hero-badge-img"
                 loading="lazy">
            <span><?php echo esc_html( $logo['label'] ); ?></span>
        </div>
    <?php endforeach; endif; ?>
</div>
