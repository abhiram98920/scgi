<?php
/**
 * Template Part: Courses Slider Tabs
 * Usage: get_template_part('template-parts/courses-slider')
 */

// Map taxonomy slug -> short JS key (must match main.js sliderPos keys)
$slider_key_map = array(
    'nursing'              => 'nursing',
    'physiotherapy'        => 'physio',
    'allied-health-science' => 'allied',
);

$cats = get_terms( array(
    'taxonomy'   => 'course_category',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
) );

if ( is_wp_error( $cats ) || empty( $cats ) ) {
    echo '<p style="color:rgba(255,255,255,0.6);text-align:center;padding:40px 0;">No course categories found. Add courses via the WordPress admin.</p>';
    return;
}
?>

<div class="courses-tabs">
    <?php foreach ( $cats as $idx => $cat ) : ?>
        <button class="tab-btn <?php echo $idx === 0 ? 'active' : ''; ?>"
                data-target="#tab-<?php echo esc_attr( $cat->slug ); ?>">
            <?php echo esc_html( $cat->name ); ?>
        </button>
    <?php endforeach; ?>
</div>

<?php foreach ( $cats as $idx => $cat ) :
    // Get the short JS key for this category slug
    $js_key = isset( $slider_key_map[ $cat->slug ] ) ? $slider_key_map[ $cat->slug ] : sanitize_key( $cat->slug );

    // Fetch courses in this category
    $courses = new WP_Query( array(
        'post_type'      => 'scgi_course',
        'posts_per_page' => -1,
        'tax_query'      => array( array(
            'taxonomy' => 'course_category',
            'field'    => 'slug',
            'terms'    => $cat->slug,
        ) ),
        'orderby' => 'menu_order',
        'order'   => 'ASC',
    ) );
?>
    <div class="tab-panel <?php echo $idx === 0 ? 'active' : ''; ?>" id="tab-<?php echo esc_attr( $cat->slug ); ?>">
        <div class="courses-slider-container">
            <div class="slider-arrow prev" onclick="moveSlider('<?php echo esc_js( $js_key ); ?>', -1)">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="slider-arrow next" onclick="moveSlider('<?php echo esc_js( $js_key ); ?>', 1)">
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="courses-slider-track">
                <div class="courses-grid" id="grid-<?php echo esc_attr( $js_key ); ?>">
                    <?php if ( $courses->have_posts() ) : while ( $courses->have_posts() ) : $courses->the_post();
                        $level       = get_post_meta( get_the_ID(), '_course_level', true ) ?: 'UG';
                        $short_desc  = get_post_meta( get_the_ID(), '_course_short_desc', true );
                        $is_paramed  = (bool) get_post_meta( get_the_ID(), '_course_is_paramed', true );
                        $thumb       = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
                    ?>
                        <a href="<?php the_permalink(); ?>" class="kmct-card reveal">
                            <div class="kc-img">
                                <?php if ( $thumb ) : ?>
                                    <img src="<?php echo esc_url( $thumb ); ?>"
                                         alt="<?php the_title_attribute(); ?>"
                                         loading="lazy">
                                <?php else : ?>
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/course-placeholder.jpg"
                                         alt="<?php the_title_attribute(); ?>"
                                         loading="lazy">
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
                        <p style="color:rgba(255,255,255,0.6);padding:40px 20px;">No courses in this category yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
