<?php
/**
 * taxonomy-course_category.php
 * Template for course category archive pages (/course-category/nursing, etc.)
 */

get_header();

$term = get_queried_object();

// Per-category banner image and title from Customizer
$banner_map = array(
    'nursing'               => array(
        'img'   => get_theme_mod( 'scgi_banner_nursing', get_template_directory_uri() . '/assets/images/banner-nursing.jpg' ),
        'title' => 'Nursing Department',
        'desc'  => get_theme_mod( 'scgi_dept_desc_nursing', 'Comprehensive nursing programmes accredited by INC and Karnataka State Nursing Council, preparing compassionate healthcare professionals.' ),
    ),
    'physiotherapy'         => array(
        'img'   => get_theme_mod( 'scgi_banner_physio', get_template_directory_uri() . '/assets/images/banner-physiotherapy.jpg' ),
        'title' => 'Physiotherapy Department',
        'desc'  => get_theme_mod( 'scgi_dept_desc_physio', 'RGUHS-affiliated physiotherapy programme with state-of-the-art rehabilitation labs and experienced clinical faculty.' ),
    ),
    'allied-health-science' => array(
        'img'   => get_theme_mod( 'scgi_banner_allied', get_template_directory_uri() . '/assets/images/banner-allied.jpg' ),
        'title' => 'Allied Health Sciences',
        'desc'  => get_theme_mod( 'scgi_dept_desc_allied', 'Specialised Allied Health programmes covering laboratory technology, operation theatre tech, and more.' ),
    ),
);

$dept = isset( $banner_map[ $term->slug ] ) ? $banner_map[ $term->slug ] : array(
    'img'   => get_template_directory_uri() . '/assets/images/banner-default.jpg',
    'title' => esc_html( $term->name ),
    'desc'  => '',
);
?>

<!-- INNER HERO -->
<?php get_template_part( 'template-parts/inner-hero', null, array(
    'title'     => $dept['title'],
    'image_url' => $dept['img'],
    'show_logos' => true,
) ); ?>

<!-- BREADCRUMB -->
<?php get_template_part( 'template-parts/breadcrumb', null, array(
    'items' => array(
        array( 'label' => 'Home',    'url' => home_url( '/' ) ),
        array( 'label' => 'Courses', 'url' => home_url( '/courses' ) ),
        array( 'label' => $dept['title'] ),
    ),
) ); ?>

<!-- DEPARTMENT INTRO -->
<?php if ( $dept['desc'] ) : ?>
<section class="dept-intro sec-bg-light">
    <div class="container tc" style="max-width:800px;">
        <div class="sec-label">About the Department</div>
        <p class="sec-sub"><?php echo esc_html( $dept['desc'] ); ?></p>
    </div>
</section>
<?php endif; ?>

<!-- COURSES GRID -->
<section class="courses-archive sec-bg-blue bg-pattern" style="padding:80px 0;">
    <div class="container">
        <div class="tc" style="margin-bottom:50px;">
            <div class="sec-label">Our Programmes</div>
            <h2 class="sec-title">Courses We Offer</h2>
        </div>

        <div class="courses-grid" style="display:flex;flex-wrap:wrap;gap:30px;justify-content:center;">
            <?php
            $courses = new WP_Query( array(
                'post_type'      => 'scgi_course',
                'posts_per_page' => -1,
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'tax_query'      => array( array(
                    'taxonomy' => 'course_category',
                    'field'    => 'slug',
                    'terms'    => $term->slug,
                ) ),
            ) );

            if ( $courses->have_posts() ) : while ( $courses->have_posts() ) : $courses->the_post();
                $level      = get_post_meta( get_the_ID(), '_course_level', true ) ?: 'UG';
                $short_desc = get_post_meta( get_the_ID(), '_course_short_desc', true );
                $is_paramed = (bool) get_post_meta( get_the_ID(), '_course_is_paramed', true );
                $thumb      = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
            ?>
                <a href="<?php the_permalink(); ?>" class="kmct-card reveal"
                   style="flex:0 0 320px; max-width:320px;">
                    <div class="kc-img">
                        <?php if ( $thumb ) : ?>
                            <img src="<?php echo esc_url( $thumb ); ?>"
                                 alt="<?php the_title_attribute(); ?>" loading="lazy">
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/course-placeholder.jpg"
                                 alt="<?php the_title_attribute(); ?>" loading="lazy">
                        <?php endif; ?>
                    </div>
                    <div class="kc-overlay"></div>
                    <div class="kc-content">
                        <?php if ( $is_paramed ) : ?>
                            <div class="paramed-badge">Paramedical</div>
                        <?php endif; ?>
                        <div class="kc-badge"><?php echo esc_html( $level ); ?></div>
                        <h3><?php the_title(); ?></h3>
                        <div class="kc-hidden">
                            <div class="kc-hidden-inner">
                                <?php if ( $short_desc ) : ?>
                                    <div class="kc-meta">
                                        <p style="font-size:0.8rem;line-height:1.4;opacity:0.9;">
                                            <?php echo esc_html( $short_desc ); ?>
                                        </p>
                                    </div>
                                <?php endif; ?>
                                <div class="kc-actions">
                                    <div class="kc-btn primary">Know More</div>
                                    <div class="kc-btn outline"><i class="fas fa-download"></i> Brochure</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            <?php endwhile; wp_reset_postdata();
            else : ?>
                <p style="color:rgba(255,255,255,.6);text-align:center;padding:40px;">
                    No courses found in this category.
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- CTA BAND -->
<?php get_template_part( 'template-parts/cta-band' ); ?>

<?php get_footer(); ?>
