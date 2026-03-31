<?php
/**
 * Template Name: About Page
 */
get_header();
the_post();
$banner_img = get_the_post_thumbnail_url( null, 'full' )
    ?: get_template_directory_uri() . '/assets/images/banner-about.jpg';
?>

<?php get_template_part( 'template-parts/inner-hero', null, array(
    'title'      => get_the_title(),
    'image_url'  => $banner_img,
    'show_logos' => false,
) ); ?>

<?php get_template_part( 'template-parts/breadcrumb', null, array(
    'items' => array(
        array( 'label' => 'Home', 'url' => home_url( '/' ) ),
        array( 'label' => get_the_title() ),
    ),
) ); ?>

<!-- ABOUT OVERVIEW -->
<section class="about-overview sec-bg-light" id="about">
    <div class="container">
        <div class="about-grid-new">
            <div class="about-text-col">
                <div class="sec-label">ABOUT SCGI</div>
                <h2 class="sec-title"><?php echo esc_html( get_theme_mod( 'scgi_about_heading', 'Overview' ) ); ?></h2>
                <div class="sec-sub"><?php the_content(); ?></div>
            </div>
            <div class="about-img-col">
                <?php if ( has_post_thumbnail() ) :
                    the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) );
                else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/campus.jpg" alt="SCGI Campus" loading="lazy">
                <?php endif; ?>
                <div class="img-accent-box"><i class="fas fa-play"></i></div>
            </div>
        </div>
    </div>
</section>

<!-- MISSION & VISION -->
<section class="mv-highlights sec-bg-blue bg-pattern">
    <div class="container">
        <h2 class="sec-title" style="margin-bottom:50px;text-align:center;">Our Core Philosophy</h2>
        <div class="mv-grid">
            <div class="mv-card reveal">
                <div class="mv-content">
                    <h3>Mission</h3>
                    <p><?php echo esc_html( get_theme_mod( 'scgi_mission', 'We aim to deliver a nurturing ground and a positive learning environment which ensures student well-being & academic success.' ) ); ?></p>
                </div>
            </div>
            <div class="mv-card reveal">
                <div class="mv-content">
                    <h3>Vision</h3>
                    <p><?php echo esc_html( get_theme_mod( 'scgi_vision', 'Promoting educational, cultural, social and charitable advancement for excellence.' ) ); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="sec-bg-light" style="padding:60px 0;">
    <div class="container">
        <div class="metrics-flex">
            <div class="metrics-item">
                <div class="m-lbl">Years of Excellence</div>
                <div class="m-num"><span class="counter" data-target="<?php echo esc_attr( get_theme_mod( 'scgi_years', '20' ) ); ?>">0</span></div>
            </div>
            <div class="metrics-sep">/</div>
            <div class="metrics-item">
                <div class="m-lbl">Alumni</div>
                <div class="m-num"><span class="counter" data-target="<?php echo esc_attr( get_theme_mod( 'scgi_alumni', '5000' ) ); ?>">0</span>+</div>
            </div>
            <div class="metrics-sep">/</div>
            <div class="metrics-item">
                <div class="m-lbl">Programmes</div>
                <div class="m-num"><span class="counter" data-target="<?php echo esc_attr( get_theme_mod( 'scgi_programmes', '10' ) ); ?>">0</span>+</div>
            </div>
            <div class="metrics-sep">/</div>
            <div class="metrics-item">
                <div class="m-lbl">Labs</div>
                <div class="m-num"><span class="counter" data-target="<?php echo esc_attr( get_theme_mod( 'scgi_labs', '8' ) ); ?>">0</span>+</div>
            </div>
        </div>
    </div>
</section>

<!-- FACILITIES -->
<?php get_template_part( 'template-parts/facilities' ); ?>

<!-- CTA BAND -->
<?php get_template_part( 'template-parts/cta-band' ); ?>

<?php get_footer(); ?>
