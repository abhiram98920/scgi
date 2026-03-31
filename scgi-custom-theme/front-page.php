<?php get_header(); ?>

<!-- HERO -->
<section class="hero">
    <div class="hero-slider">
        <?php
        $sliders = new WP_Query( array(
            'post_type' => 'scgi_slider',
            'orderby'   => 'menu_order',
            'order'     => 'ASC',
            'posts_per_page' => -1,
        ) );
        $slide_count = 0;
        if ( $sliders->have_posts() ) : while ( $sliders->have_posts() ) : $sliders->the_post();
            $thumb = get_the_post_thumbnail_url( get_the_ID(), 'full' );
            if ( ! $thumb ) $thumb = get_template_directory_uri() . '/assets/images/hero-placeholder.jpg';
        ?>
            <div class="slide <?php echo $slide_count === 0 ? 'active' : ''; ?>"
                 style="background-image: url('<?php echo esc_url( $thumb ); ?>');">
            </div>
        <?php $slide_count++; endwhile; wp_reset_postdata(); endif; ?>
    </div>

    <div class="hero-dots">
        <?php for ( $j = 0; $j < $slide_count; $j++ ) : ?>
            <div class="hero-dot <?php echo $j === 0 ? 'active' : ''; ?>" data-index="<?php echo $j; ?>"></div>
        <?php endfor; ?>
    </div>

    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <?php
            // Fetch first slider for hero text fields
            $hero_slider = new WP_Query( array(
                'post_type'      => 'scgi_slider',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'posts_per_page' => 1,
            ) );
            if ( $hero_slider->have_posts() ) : $hero_slider->the_post();
                $subtitle    = get_post_meta( get_the_ID(), '_slider_subtitle', true );
                $btn_text    = get_post_meta( get_the_ID(), '_slider_btn_text', true ) ?: 'Explore Courses';
                $btn_link    = get_post_meta( get_the_ID(), '_slider_btn_link', true ) ?: '#courses';
            ?>
                <h1><?php the_title(); ?></h1>
                <p class="hero-desc"><?php echo esc_html( $subtitle ); ?></p>
                <div class="hero-btns">
                    <a href="<?php echo esc_url( $btn_link ); ?>" class="btn-gold">
                        <i class="fas fa-graduation-cap"></i><?php echo esc_html( $btn_text ); ?>
                    </a>
                    <a href="javascript:void(0)" class="btn-ghost-white btn-hero-enq-mb" id="mobileEnqBtn">
                        <i class="fas fa-paper-plane"></i>Enquire Now
                    </a>
                </div>
            <?php wp_reset_postdata(); endif; ?>

            <div class="hero-pills">
                <a href="<?php echo esc_url( get_term_link( 'nursing', 'course_category' ) ); ?>" class="hero-pill">
                    <i class="fas fa-heartbeat"></i>Nursing
                </a>
                <a href="<?php echo esc_url( get_term_link( 'allied-health-science', 'course_category' ) ); ?>" class="hero-pill">
                    <i class="fas fa-microscope"></i>Allied Health Science
                </a>
                <a href="<?php echo esc_url( get_term_link( 'physiotherapy', 'course_category' ) ); ?>" class="hero-pill">
                    <i class="fas fa-running"></i>Physiotherapy
                </a>
            </div>

            <?php get_template_part( 'template-parts/accreditation-logos' ); ?>
        </div>

        <!-- Hero Enquiry Panel -->
        <div class="hero-stats-panel hero-enquiry-form" id="heroFormPanel">
            <div class="hsp-title">Enquire & <span style="color:var(--gold);">Get Counselled</span></div>
            <p class="hsp-subtitle">Select your preferred course & get expert guidance</p>
            <form id="heroForm" class="hero-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
                <input type="hidden" name="action" value="scgi_course_enquiry">
                <?php wp_nonce_field( 'scgi_form_submit', 'enquiry_nonce' ); ?>

                <!-- Category Dropdown -->
                <div class="csd-wrap" style="margin-bottom:12px;">
                    <div class="csd" id="csd-category" data-value="">
                        <div class="csd-trigger"><span class="csd-label">Select Course Category</span><i class="fas fa-chevron-down csd-arrow"></i></div>
                        <ul class="csd-list">
                            <li data-value="Nursing">Nursing</li>
                            <li data-value="Physiotherapy">Physiotherapy</li>
                            <li data-value="Allied Health Science">Allied Health Science</li>
                        </ul>
                    </div>
                </div>

                <!-- Course Dropdown -->
                <div class="csd-wrap" style="margin-bottom:12px;">
                    <div class="csd" id="csd-course" data-value="">
                        <div class="csd-trigger"><span class="csd-label">Select Course Details</span><i class="fas fa-chevron-down csd-arrow"></i></div>
                        <ul class="csd-list" id="csd-course-list"></ul>
                    </div>
                </div>

                <!-- State Dropdown -->
                <div class="csd-wrap" style="margin-bottom:12px;">
                    <div class="csd" id="csd-state" data-value="">
                        <div class="csd-trigger"><span class="csd-label">Select State</span><i class="fas fa-chevron-down csd-arrow"></i></div>
                        <ul class="csd-list">
                            <li data-value="Karnataka">Karnataka</li>
                            <li data-value="Kerala">Kerala</li>
                            <li data-value="Tamil Nadu">Tamil Nadu</li>
                            <li data-value="Andhra Pradesh">Andhra Pradesh</li>
                            <li data-value="Maharashtra">Maharashtra</li>
                            <li data-value="Other">Other</li>
                        </ul>
                    </div>
                </div>

                <input type="text" id="heroCity" name="city" class="hero-input" placeholder="Enter City" required>
                <input type="hidden" id="heroCategory" name="category">
                <input type="hidden" id="heroCourse" name="course">
                <input type="hidden" id="heroState" name="state">

                <button type="submit" class="btn-gold hero-submit" style="width:100%; justify-content:center; margin-top:10px;">
                    <i class="fas fa-paper-plane"></i>Submit Details
                </button>
            </form>
        </div>
    </div>
</section>

<!-- METRICS ROW -->
<div class="metrics-row sec-bg-light reveal">
    <div class="container">
        <div class="metrics-flex">
            <div class="metrics-title"><div>College</div><div>Metrics</div></div>
            <div class="metrics-sep">/</div>
            <div class="metrics-item">
                <div class="m-lbl">Years of Academic Excellence</div>
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
</div>

<!-- ABOUT SECTION -->
<section class="about sec-bg-white reveal" id="about">
    <div class="container">
        <?php
        // Use front page post for about content
        $front_page_id = get_option( 'page_on_front' );
        if ( $front_page_id ) {
            $about_post = get_post( $front_page_id );
            setup_postdata( $about_post );
        }
        ?>
        <div class="about-grid">
            <div class="about-img-wrap">
                <?php
                $about_img = get_theme_mod( 'scgi_about_image', '' );
                if ( $about_img ) {
                    echo '<img src="' . esc_url( $about_img ) . '" alt="SCGI Campus">';
                } elseif ( $front_page_id && has_post_thumbnail( $front_page_id ) ) {
                    echo get_the_post_thumbnail( $front_page_id, 'large' );
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/assets/images/campus.jpg" alt="SCGI Campus">';
                }
                ?>
                <div class="estd-badge">
                    <div class="estd-num"><?php echo esc_html( get_theme_mod( 'scgi_estd', '2006' ) ); ?></div>
                    <div class="estd-lbl">Established</div>
                </div>
            </div>
            <div>
                <div class="sec-label">At SCGI…</div>
                <h2 class="sec-title"><?php echo esc_html( get_theme_mod( 'scgi_about_heading', 'A Legacy of Excellence in Healthcare Education' ) ); ?></h2>
                <p class="sec-sub"><?php echo wp_kses_post( get_theme_mod( 'scgi_about_text', 'Sri Channegowda Group of Institutions (SCGI), established in 2006, is a premier healthcare education institution affiliated to Rajiv Gandhi University of Health Sciences (RGUHS). Located in Kolar, Karnataka, SCGI brings together Nursing, Allied Health Science, and Physiotherapy — all under one campus.' ) ); ?></p>
                <a href="#courses" class="btn-primary" style="margin-top:20px"><i class="fas fa-arrow-right"></i>Explore Our Courses</a>
            </div>
        </div>
        <?php
        $points_raw = get_theme_mod( 'scgi_about_points', "RGUHS Affiliated Since 2006\nState-of-the-art Labs & Clinical Facilities\nExperienced Faculty with Healthcare Expertise\nOn-campus Hospital for Clinical Training\nPlacement Assistance for Graduates" );
        if ( $points_raw ) :
            $points = explode( "\n", str_replace( "\r", "", $points_raw ) );
        ?>
            <div class="about-points">
                <?php foreach ( $points as $point ) : if ( trim( $point ) ) : ?>
                    <div class="ap"><i class="fas fa-check-circle"></i><?php echo esc_html( trim( $point ) ); ?></div>
                <?php endif; endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- COURSES SECTION -->
<section class="courses sec-bg-blue reveal" id="courses">
    <div class="container">
        <div class="tc">
            <div class="sec-label">Our Programmes</div>
            <h2 class="sec-title">Courses We Offer</h2>
        </div>
        <?php get_template_part( 'template-parts/courses-slider' ); ?>
    </div>
</section>

<!-- ACCREDITATION MARQUEE -->
<div class="acc-band sec-bg-light">
    <div class="acc-label">Approved & Recognised by</div>
    <div class="acc-marquee-wrap">
        <div class="acc-marquee">
            <?php
            $logo_args = array(
                'post_type'      => 'scgi_logo',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
                'posts_per_page' => -1,
            );
            $logos = new WP_Query( $logo_args );
            // Output twice for seamless loop
            for ( $r = 0; $r < 2; $r++ ) {
                $logos->rewind_posts();
                if ( $logos->have_posts() ) : while ( $logos->have_posts() ) : $logos->the_post();
                    if ( has_post_thumbnail() ) :
            ?>
                    <div class="acc-logo-item">
                        <img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'medium' ) ); ?>"
                             alt="<?php the_title_attribute(); ?>"
                             loading="lazy">
                        <span><?php the_title(); ?></span>
                    </div>
            <?php   endif; endwhile; endif;
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

<!-- WHY SCGI -->
<section class="why-section sec-bg-white reveal">
    <div class="container">
        <div class="tc" style="margin-bottom:50px;">
            <div class="sec-label">Why Choose Us</div>
            <h2 class="sec-title"><?php echo esc_html( get_theme_mod( 'scgi_why_heading', 'Why Choose SCGI?' ) ); ?></h2>
            <p class="sec-sub"><?php echo esc_html( get_theme_mod( 'scgi_why_subtext', 'We combine academic excellence with real-world clinical training.' ) ); ?></p>
        </div>
        <div class="fac-grid">
            <?php
            $why_items_raw = get_theme_mod( 'scgi_why_items', "fa-hospital|On-campus Hospital|Hands-on clinical training in our on-campus hospital with real patients.\nfa-users|Expert Faculty|Experienced faculty with decades of healthcare & academic expertise.\nfa-flask|Modern Labs|State-of-the-art labs equipped for clinical, pathology & nursing training.\nfa-graduation-cap|RGUHS Affiliated|Recognised by Rajiv Gandhi University of Health Sciences since 2006.\nfa-briefcase|Placement Support|Active placement cell helping graduates find careers in leading hospitals.\nfa-globe|Globally Recognised|Our degrees are recognised for healthcare roles internationally." );
            $why_items = explode( "\n", str_replace( "\r", "", $why_items_raw ) );
            foreach ( $why_items as $item ) :
                $parts = explode( '|', trim( $item ) );
                if ( count( $parts ) < 3 ) continue;
                list( $icon, $title, $desc ) = $parts;
            ?>
                <div class="fac-card reveal">
                    <div class="fac-icon"><i class="fas <?php echo esc_attr( trim( $icon ) ); ?>"></i></div>
                    <h3><?php echo esc_html( trim( $title ) ); ?></h3>
                    <p><?php echo esc_html( trim( $desc ) ); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- GALLERY SECTION -->
<section class="gallery sec-bg-blue bg-pattern reveal" id="gallery">
    <div class="container">
        <div class="tc">
            <div class="sec-label">Glimpses of SCGI</div>
            <h2 class="sec-title">Gallery</h2>
            <p class="sec-sub">A glimpse into our academic excellence, clinical training, and vibrant campus life.</p>
        </div>
        <div class="gallery-grid">
            <?php
            $gallery = new WP_Query( array( 'post_type' => 'scgi_gallery', 'posts_per_page' => 6 ) );
            if ( $gallery->have_posts() ) : while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
                <div class="gallery-item">
                    <?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large', array( 'loading' => 'lazy' ) ); endif; ?>
                </div>
            <?php endwhile; wp_reset_postdata();
            else : ?>
                <p class="tc" style="color:rgba(255,255,255,0.6);margin-top:30px;">No gallery items found. Add them via the WordPress admin.</p>
            <?php endif; ?>
        </div>
        <div class="tc" style="margin-top:40px;">
            <a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>" class="btn-ghost-white">
                View All Gallery <i class="fas fa-images" style="margin-left:8px;"></i>
            </a>
        </div>
    </div>
</section>

<!-- CTA BAND -->
<?php get_template_part( 'template-parts/cta-band' ); ?>

<?php get_footer(); ?>
