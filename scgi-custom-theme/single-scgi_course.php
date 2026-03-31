<?php
/**
 * single-scgi_course.php — Course Detail Page
 */
get_header();

if ( ! have_posts() ) { get_footer(); exit; }
the_post();

$why_text        = get_post_meta( get_the_ID(), '_course_why_text',    true );
$why_points_raw  = get_post_meta( get_the_ID(), '_course_why_points',  true );
$eligibility     = get_post_meta( get_the_ID(), '_course_eligibility', true );
$exam_info       = get_post_meta( get_the_ID(), '_course_exam_info',   true );
$level           = get_post_meta( get_the_ID(), '_course_level',       true ) ?: 'UG';
$duration        = get_post_meta( get_the_ID(), '_course_duration',    true );
$brochure_url    = get_post_meta( get_the_ID(), '_course_brochure_url', true );

// Banner image: use featured image, else default
$banner_img = get_the_post_thumbnail_url( null, 'full' )
    ?: get_template_directory_uri() . '/assets/images/banner-default.jpg';

// Get parent category for breadcrumb
$terms = get_the_terms( get_the_ID(), 'course_category' );
$parent_term = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
?>

<!-- INNER HERO -->
<?php get_template_part( 'template-parts/inner-hero', null, array(
    'title'      => get_the_title(),
    'image_url'  => $banner_img,
    'show_logos' => true,
) ); ?>

<!-- BREADCRUMB -->
<?php
$bc_items = array( array( 'label' => 'Home', 'url' => home_url( '/' ) ) );
if ( $parent_term ) {
    $bc_items[] = array( 'label' => $parent_term->name, 'url' => get_term_link( $parent_term ) );
}
$bc_items[] = array( 'label' => get_the_title() );
get_template_part( 'template-parts/breadcrumb', null, array( 'items' => $bc_items ) );
?>

<!-- COURSE DETAIL -->
<section class="detail-section sec-bg-light" style="padding:80px 0;">
    <div class="container">
        <div class="detail-grid">
            <div class="detail-text">
                <?php if ( $level || $duration ) : ?>
                    <div style="display:flex;gap:12px;margin-bottom:24px;flex-wrap:wrap;">
                        <?php if ( $level ) : ?>
                            <span style="background:var(--gold);color:var(--blue-dark);font-weight:700;font-size:0.8rem;padding:5px 14px;border-radius:6px;letter-spacing:0.5px;">
                                <?php echo esc_html( $level ); ?>
                            </span>
                        <?php endif; ?>
                        <?php if ( $duration ) : ?>
                            <span style="background:rgba(13,36,99,0.08);color:var(--blue-dark);font-weight:600;font-size:0.85rem;padding:5px 14px;border-radius:6px;">
                                <i class="fas fa-clock" style="margin-right:5px;"></i><?php echo esc_html( $duration ); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <h2 class="sec-title" style="margin-bottom:24px;"><?php the_title(); ?></h2>
                <div class="sec-sub" style="margin-bottom:30px;line-height:1.8;"><?php the_content(); ?></div>
                <div style="display:flex;gap:15px;flex-wrap:wrap;">
                    <a href="javascript:void(0)" class="btn-primary btn-enq">
                        <i class="fas fa-paper-plane"></i>Enquire Now
                    </a>
                    <?php if ( $brochure_url ) : ?>
                        <a href="<?php echo esc_url( $brochure_url ); ?>" class="btn-outline" target="_blank">
                            <i class="fas fa-download"></i>Download Brochure
                        </a>
                    <?php else : ?>
                        <a href="#" class="btn-outline">
                            <i class="fas fa-download"></i>Download Brochure
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="detail-img">
                <?php if ( has_post_thumbnail() ) :
                    the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) );
                else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/course-placeholder.jpg"
                         alt="<?php the_title_attribute(); ?>" loading="lazy">
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- WHY SECTION -->
<?php if ( $why_text || $why_points_raw ) : ?>
<section class="why-section sec-bg-blue bg-pattern" style="padding:80px 0;">
    <div class="container">
        <div class="tc" style="margin-bottom:50px;">
            <div class="sec-label">Benefits</div>
            <h2 class="sec-title">Why Choose <?php the_title(); ?>?</h2>
            <?php if ( $why_text ) : ?>
                <p class="sec-sub"><?php echo esc_html( $why_text ); ?></p>
            <?php endif; ?>
        </div>
        <?php if ( $why_points_raw ) :
            $points = array_filter( array_map( 'trim', explode( "\n", str_replace( "\r", "", $why_points_raw ) ) ) );
        ?>
            <ul style="list-style:none;padding:0;max-width:900px;margin:0 auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:15px;">
                <?php foreach ( $points as $p ) : ?>
                    <li style="color:#fff;">
                        <i class="fas fa-check-circle" style="color:var(--gold);margin-right:10px;"></i>
                        <?php echo esc_html( $p ); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- ELIGIBILITY SECTION -->
<?php if ( $eligibility || $exam_info ) : ?>
<section class="detail-section sec-bg-light" style="padding:80px 0;">
    <div class="container">
        <div class="tc" style="margin-bottom:50px;">
            <div class="sec-label">Admission</div>
            <h2 class="sec-title">Eligibility Criteria</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:60px;">
            <?php if ( $eligibility ) : ?>
                <div>
                    <h3 style="font-size:1.4rem;color:var(--blue-dark);margin-bottom:20px;font-weight:600;">
                        <i class="fas fa-user-graduate" style="color:var(--gold);margin-right:10px;"></i>General Eligibility
                    </h3>
                    <p style="line-height:1.8;"><?php echo wp_kses_post( nl2br( esc_html( $eligibility ) ) ); ?></p>
                </div>
            <?php endif; ?>
            <?php if ( $exam_info ) : ?>
                <div>
                    <h3 style="font-size:1.4rem;color:var(--blue-dark);margin-bottom:20px;font-weight:600;">
                        <i class="fas fa-file-alt" style="color:var(--gold);margin-right:10px;"></i>Examination Eligibility
                    </h3>
                    <p style="line-height:1.8;font-size:0.95rem;"><?php echo wp_kses_post( nl2br( esc_html( $exam_info ) ) ); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FACILITIES -->
<?php get_template_part( 'template-parts/facilities' ); ?>

<!-- CTA BAND -->
<?php get_template_part( 'template-parts/cta-band' ); ?>

<?php get_footer(); ?>
