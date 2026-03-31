<?php
/**
 * Template Part: Courses Slider Tabs
 * Usage: get_template_part('template-parts/courses-slider')
 */

// Exact category mapping to match index.html
$cats_source = array(
    array('slug' => 'nursing', 'name' => 'Nursing', 'js_key' => 'nursing'),
    array('slug' => 'physiotherapy', 'name' => 'Physiotherapy', 'js_key' => 'physio'),
    array('slug' => 'allied-health-science', 'name' => 'Allied Health Science', 'js_key' => 'allied'),
);
?>

<div class="courses-tabs">
    <?php foreach ( $cats_source as $idx => $cat ) : ?>
        <button class="tab-btn <?php echo $idx === 0 ? 'active' : ''; ?>" data-tab="<?php echo esc_attr( $cat['js_key'] ); ?>">
            <?php echo esc_html( $cat['name'] ); ?>
        </button>
    <?php endforeach; ?>
</div>

<?php foreach ( $cats_source as $idx => $cat ) :
    // Fetch courses in this category
    $courses = new WP_Query( array(
        'post_type'      => 'scgi_course',
        'posts_per_page' => -1,
        'tax_query'      => array( array(
            'taxonomy' => 'course_category',
            'field'    => 'slug',
            'terms'    => $cat['slug'],
        ) ),
        'orderby' => 'menu_order',
        'order'   => 'ASC',
    ) );
?>
    <div class="tab-panel <?php echo $idx === 0 ? 'active' : ''; ?>" id="tab-<?php echo esc_attr( $cat['js_key'] ); ?>">
        <div class="courses-slider-container">
            <div class="slider-arrow prev" onclick="moveSlider('<?php echo esc_js( $cat['js_key'] ); ?>', -1)">
                <i class="fas fa-chevron-left"></i>
            </div>
            <div class="slider-arrow next" onclick="moveSlider('<?php echo esc_js( $cat['js_key'] ); ?>', 1)">
                <i class="fas fa-chevron-right"></i>
            </div>
            <div class="courses-slider-track">
                <div class="courses-grid" id="grid-<?php echo esc_attr( $cat['js_key'] ); ?>">
                    <?php if ( $courses->have_posts() ) : while ( $courses->have_posts() ) : $courses->the_post();
                        $level       = get_post_meta( get_the_ID(), '_course_level', true ) ?: 'UG';
                        $short_desc  = get_post_meta( get_the_ID(), '_course_short_desc', true );
                        $thumb       = get_the_post_thumbnail_url( get_the_ID(), 'medium_large' );
                        if ( ! $thumb ) $thumb = get_template_directory_uri() . '/SCGI-Logo.png';
                    ?>
                        <a href="<?php the_permalink(); ?>" class="kmct-card reveal">
                            <div class="kc-img">
                                <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                            </div>
                            <div class="kc-overlay"></div>
                            <div class="kc-content">
                                <div class="kc-badge"><?php echo esc_html( $level ); ?></div>
                                <h3><?php the_title(); ?></h3>
                                <div class="kc-hidden">
                                    <div class="kc-hidden-inner">
                                        <div class="kc-meta">
                                            <p style="font-size:0.8rem; line-height:1.4; opacity:0.9;">
                                                <?php echo esc_html( $short_desc ); ?>
                                            </p>
                                        </div>
                                        <div class="kc-actions">
                                            <div class="kc-btn primary">Enquire Now</div>
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
