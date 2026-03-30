<?php get_header(); ?>

<!-- HERO -->
<section class="hero">
    <div class="hero-slider">
        <?php
        $sliders = new WP_Query( array( 'post_type' => 'scgi_slider', 'orderby' => 'menu_order', 'order' => 'ASC' ) );
        if ( $sliders->have_posts() ) : $i = 0; while ( $sliders->have_posts() ) : $sliders->the_post();
            $subtitle = get_post_meta( get_the_ID(), '_slider_subtitle', true );
            ?>
            <div class="slide <?php echo $i == 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"></div>
        <?php $i++; endwhile; wp_reset_postdata(); endif; ?>
    </div>
    <div class="hero-dots">
        <?php if ( $sliders->found_posts > 0 ) : for ( $j = 0; $j < $sliders->found_posts; $j++ ) : ?>
            <div class="hero-dot <?php echo $j == 0 ? 'active' : ''; ?>" data-index="<?php echo $j; ?>"></div>
        <?php endfor; endif; ?>
    </div>
    <div class="hero-overlay"></div>
    <div class="container">
        <div class="hero-content">
            <?php
            // Using the first slider for the static-looking text if there's no dynamic heading field
            if ( $sliders->have_posts() ) : $sliders->the_post();
                $subtitle = get_post_meta( get_the_ID(), '_slider_subtitle', true );
                $btn_text = get_post_meta( get_the_ID(), '_slider_btn_text', true );
                $btn_link = get_post_meta( get_the_ID(), '_slider_btn_link', true );
            ?>
                <h1><?php the_title(); ?></h1>
                <p class="hero-desc"><?php echo esc_html($subtitle); ?></p>
                <div class="hero-btns">
                    <a href="#courses" class="btn-gold"><i class="fas fa-graduation-cap"></i>Explore Courses</a>
                    <a href="javascript:void(0)" class="btn-ghost-white btn-hero-enq-mb" id="mobileEnqBtn"><i class="fas fa-paper-plane"></i>Enquire Now</a>
                </div>
            <?php wp_reset_postdata(); endif; ?>

            <div class="hero-pills">
                <a href="<?php echo esc_url(home_url('/course-category/nursing')); ?>" class="hero-pill"><i class="fas fa-heartbeat"></i>Nursing</a>
                <a href="<?php echo esc_url(home_url('/course-category/allied-health-science')); ?>" class="hero-pill"><i class="fas fa-microscope"></i>Allied Health Science</a>
                <a href="<?php echo esc_url(home_url('/course-category/physiotherapy')); ?>" class="hero-pill"><i class="fas fa-running"></i>Physiotherapy</a>
            </div>
            
            <div class="hero-badges-wrap reveal">
                <div class="hero-badge-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/INC-01.jpg" alt="INC-Approved" class="hero-badge-img">
                    <span>Approved by<br>Indian Nursing Council</span>
                </div>
                <div class="hero-badge-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/KSNC-01.jpg" alt="KSNC-Approved" class="hero-badge-img">
                    <span>Approved by<br>Karnataka State Nursing Council</span>
                </div>
                <div class="hero-badge-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/Karnataka state diploma in nursing examination board.png" alt="KSDNEB" class="hero-badge-img">
                    <span>Karnataka State Diploma in Nursing Examination Board (KSDNEB)</span>
                </div>
                <div class="hero-badge-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/Logo of Karnataka paramedical board.webp" alt="Paramedical-Board" class="hero-badge-img">
                    <span>Approved by<br>Karnataka Paramedical Board</span>
                </div>
                <div class="hero-badge-item">
                    <img src="<?php echo get_template_directory_uri(); ?>/KA-Govt-01.jpg" alt="Govt-Recognised" class="hero-badge-img">
                    <span>Recognised by<br>Govt of Karnataka</span>
                </div>
            </div>
        </div>

        <div class="hero-stats-panel hero-enquiry-form" id="heroFormPanel">
            <div class="hsp-title" style="font-size: 2.2rem; line-height: 1.2; margin-bottom: 20px; color: #fff; font-family: 'GT Super Ds', serif;">Begin Your <span style="color:var(--gold);">Success Story</span></div>
            <p class="hsp-subtitle">Select your preferred course & get expert guidance</p>
            <form id="heroForm" class="hero-form" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
                <input type="hidden" name="action" value="scgi_course_enquiry">
                <?php wp_nonce_field( 'scgi_form_submit', 'enquiry_nonce' ); ?>

                <!-- Category Custom Dropdown -->
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

                <!-- Course Custom Dropdown -->
                <div class="csd-wrap" style="margin-bottom:12px;">
                  <div class="csd" id="csd-course" data-value="">
                    <div class="csd-trigger"><span class="csd-label">Select Course Details</span><i class="fas fa-chevron-down csd-arrow"></i></div>
                    <ul class="csd-list" id="csd-course-list"></ul>
                  </div>
                </div>

                <!-- State Custom Dropdown -->
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

                <!-- City -->
                <input type="text" id="heroCity" name="city" class="hero-input" placeholder="Enter City" required>

                <!-- Hidden POST fields -->
                <input type="hidden" id="heroCategory" name="category">
                <input type="hidden" id="heroCourse" name="course">
                <input type="hidden" id="heroState" name="state">

                <button type="submit" class="btn-gold hero-submit" style="width: 100%; justify-content: center; margin-top: 10px;"><i class="fas fa-paper-plane"></i>Submit Details</button>
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
                <div class="m-num"><span class="counter" data-target="<?php echo esc_attr(get_theme_mod('scgi_years', '20')); ?>">0</span></div>
            </div>
            <div class="metrics-sep">/</div>
            <div class="metrics-item">
                <div class="m-lbl">Alumni</div>
                <div class="m-num"><span class="counter" data-target="<?php echo esc_attr(get_theme_mod('scgi_alumni', '5000')); ?>">0</span>+</div>
            </div>
            <div class="metrics-sep">/</div>
            <div class="metrics-item">
                <div class="m-lbl">Programmes</div>
                <div class="m-num"><span class="counter" data-target="<?php echo esc_attr(get_theme_mod('scgi_programmes', '10')); ?>">0</span>+</div>
            </div>
            <div class="metrics-sep">/</div>
            <div class="metrics-item">
                <div class="m-lbl">Labs</div>
                <div class="m-num"><span class="counter" data-target="<?php echo esc_attr(get_theme_mod('scgi_labs', '8')); ?>">0</span>+</div>
            </div>
        </div>
    </div>
</div>

<!-- ABOUT SECTION -->
<section class="about sec-bg-white reveal" id="about">
    <div class="container">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="about-grid">
                <div class="about-img-wrap">
                    <?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); else : ?>
                        <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&q=80" alt="SCGI Campus" />
                    <?php endif; ?>
                    <div class="estd-badge">
                        <div class="estd-num"><?php echo esc_html(get_theme_mod('scgi_estd', '2006')); ?></div>
                        <div class="estd-lbl">Established</div>
                    </div>
                </div>
                <div>
                    <div class="sec-label">At SCGI…</div>
                    <h2 class="sec-title"><?php the_title(); ?></h2>
                    <div class="sec-sub"><?php the_content(); ?></div>
                    <a href="#courses" class="btn-primary" style="margin-top:20px"><i class="fas fa-arrow-right"></i>Explore Our Courses</a>
                </div>
            </div>
            <?php 
            $points_raw = get_post_meta( get_the_ID(), '_about_points', true );
            if ( $points_raw ) : 
                $points = explode( "\n", str_replace( "\r", "", $points_raw ) );
            ?>
                <div class="about-points">
                    <?php foreach ( $points as $point ) : if ( trim($point) ) : ?>
                        <div class="ap"><i class="fas fa-check-circle"></i><?php echo esc_html( trim($point) ); ?></div>
                    <?php endif; endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endwhile; endif; ?>
    </div>
</section>

<!-- COURSES SECTION -->
<section class="courses sec-bg-blue reveal" id="courses">
    <div class="container">
        <div class="tc">
            <div class="sec-label">Our Programmes</div>
            <h2 class="sec-title">Courses We Offer</h2>
        </div>
        <div class="courses-tabs">
            <?php 
            $cats = get_terms( array('taxonomy' => 'course_category', 'hide_empty' => false) );
            foreach ( $cats as $idx => $cat ) : 
            ?>
                <button class="course-tab-btn <?php echo $idx == 0 ? 'active' : ''; ?>" data-target="#tab-<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
            <?php endforeach; ?>
        </div>

        <?php foreach ( $cats as $idx => $cat ) : ?>
            <div class="tab-panel <?php echo $idx == 0 ? 'active' : ''; ?>" id="tab-<?php echo esc_attr($cat->slug); ?>">
                <div class="courses-slider-container">
                    <div class="slider-arrow prev" onclick="moveSlider('<?php echo esc_attr($cat->slug); ?>', -1)"><i class="fas fa-chevron-left"></i></div>
                    <div class="slider-arrow next" onclick="moveSlider('<?php echo esc_attr($cat->slug); ?>', 1)"><i class="fas fa-chevron-right"></i></div>
                    <div class="courses-slider-track">
                        <div class="courses-grid" id="grid-<?php echo esc_attr($cat->slug); ?>" style="display: grid; grid-template-columns: repeat(<?php echo $courses->found_posts; ?>, 320px); gap: 30px;">
                            <?php
                            $courses = new WP_Query( array(
                                'post_type'      => 'scgi_course',
                                'tax_query'      => array( array( 'taxonomy' => 'course_category', 'field' => 'slug', 'terms' => $cat->slug ) ),
                                'orderby'        => 'menu_order',
                                'order'          => 'ASC'
                            ) );
                            if ( $courses->have_posts() ) : while ( $courses->have_posts() ) : $courses->the_post();
                                $slug = $post->post_name;
                                $is_paramed = in_array($slug, array('dmlt', 'dott', 'dhi', 'diploma-in-medical-laboratory-technology', 'diploma-in-operation-theatre-technology', 'diploma-in-health-inspector'));
                            ?>
                                <a href="<?php the_permalink(); ?>" class="kmct-card">
                                    <div class="kc-img"><?php the_post_thumbnail('medium'); ?></div>
                                    <div class="kc-overlay"></div>
                                    <div class="kc-content">
                                        <?php if ($is_paramed) : ?><div class="paramed-badge">Paramedical</div><?php endif; ?>
                                        <div class="kc-title"><?php the_title(); ?></div>
                                        <div class="kc-hidden">
                                            <div class="kc-hidden-inner">
                                                <div class="kc-actions"><div class="kc-btn primary">Know More</div></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile; wp_reset_postdata(); endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<!-- GALLERY SECTION -->
<section class="gallery sec-bg-blue bg-pattern" id="gallery">
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
                    <?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'large' ); endif; ?>
                </div>
            <?php endwhile; wp_reset_postdata(); else : ?>
                <p class="tc" style="color:rgba(255,255,255,0.6); margin-top:30px;">No gallery items found. Please add them in the WordPress admin.</p>
            <?php endif; ?>
        </div>
        <div class="tc" style="margin-top: 40px;">
            <a href="<?php echo esc_url(home_url('/gallery')); ?>" class="btn-ghost-white">View All Gallery <i class="fas fa-images" style="margin-left:8px;"></i></a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
