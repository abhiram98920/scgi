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
        if ( ! $thumb ) $thumb = get_template_directory_uri() . '/SCGI-Logo.png'; // Fallback
    ?>
        <div class="slide <?php echo $slide_count === 0 ? 'active' : ''; ?>" style="background-image: url('<?php echo esc_url( $thumb ); ?>');"></div>
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
      // Use the first slider's content for the hero text
      $logos = new WP_Query( array('post_type' => 'scgi_slider', 'posts_per_page' => 1) );
      if ( $logos->have_posts() ) : $logos->the_post();
          $subtitle   = get_post_meta(get_the_ID(), '_slider_subtitle', true);
          $highlight  = get_post_meta(get_the_ID(), '_slider_highlight', true);
          $btn_text   = get_post_meta(get_the_ID(), '_slider_btn_text', true) ?: 'Explore Courses';
          $btn_link   = get_post_meta(get_the_ID(), '_slider_btn_link', true) ?: '#courses';
      ?>
        <h1><?php the_title(); ?> <?php if($highlight) echo '<span style="color:var(--gold);">'.esc_html($highlight).'</span>'; ?></h1>
        <p class="hero-desc"><?php echo esc_html( $subtitle ); ?></p>
        <div class="hero-btns">
          <a href="<?php echo esc_url($btn_link); ?>" class="btn-gold"><i class="fas fa-graduation-cap"></i><?php echo esc_html($btn_text); ?></a>
          <a href="javascript:void(0)" class="btn-ghost-white btn-hero-enq-mb" id="mobileEnqBtn"><i class="fas fa-paper-plane"></i>Enquire Now</a>
        </div>
      <?php wp_reset_postdata(); endif; ?>

      <div class="hero-pills">
        <a href="<?php echo esc_url( home_url( '/nursing' ) ); ?>" class="hero-pill"><i class="fas fa-heartbeat"></i>Nursing</a>
        <a href="<?php echo esc_url( home_url( '/allied' ) ); ?>" class="hero-pill"><i class="fas fa-microscope"></i>Allied Health Science</a>
        <a href="<?php echo esc_url( home_url( '/physiotherapy' ) ); ?>" class="hero-pill"><i class="fas fa-running"></i>Physiotherapy</a>
      </div>

      <div class="hero-badges-wrap reveal" style="margin-top: 30px;">
        <div class="hero-badge-item">
          <img src="<?php echo get_template_directory_uri(); ?>/inc-cropped.png" alt="INC-Approved" class="hero-badge-img">
          <span>Approved by<br>Indian Nursing Council</span>
        </div>
        <div class="hero-badge-item">
          <img src="<?php echo get_template_directory_uri(); ?>/ksnc-cropped.png" alt="KSNC-Approved" class="hero-badge-img">
          <span>Approved by<br>Karnataka State Nursing Council</span>
        </div>
        <div class="hero-badge-item">
          <img src="<?php echo get_template_directory_uri(); ?>/Karnataka state diploma in nursing examination board.png" alt="KSDNEB" class="hero-badge-img">
          <span>Karnataka State Diploma in Nursing Examination Board (KSDNEB)</span>
        </div>
      </div>
    </div>

    <!-- Hero Enquiry Panel -->
    <div class="hero-stats-panel hero-enquiry-form" id="heroFormPanel">
      <div class="hsp-title">Enquire & <span style="color:var(--gold);">Get Counselled</span></div>
      <p class="hsp-subtitle">Select your preferred course & get expert guidance</p>
      <form id="heroForm" class="hero-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <input type="hidden" name="action" value="scgi_course_enquiry">
        <?php wp_nonce_field( 'scgi_form_submit', 'enquiry_nonce' ); ?>
        
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

        <div class="csd-wrap" style="margin-bottom:12px;">
          <div class="csd" id="csd-course" data-value="">
            <div class="csd-trigger"><span class="csd-label">Select Course Details</span><i class="fas fa-chevron-down csd-arrow"></i></div>
            <ul class="csd-list" id="csd-course-list"></ul>
          </div>
        </div>

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

        <button type="submit" class="btn-gold hero-submit" style="width:100%; justify-content:center; margin-top:10px;"><i class="fas fa-paper-plane"></i> Submit Details</button>
      </form>
    </div>
  </div>
</section>

<!-- METRICS ROW -->
<div class="metrics-row sec-bg-light">
  <div class="container">
    <div class="metrics-flex">
      <div class="metrics-title">
        <div>College</div>
        <div>Metrics</div>
      </div>
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

<!-- ABOUT -->
<section class="about sec-bg-blue bg-pattern" id="about">
  <div class="container">
    <div class="about-grid">
      <div class="about-img-wrap">
        <?php
        $about_img = get_theme_mod( 'scgi_about_image', 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&q=80' );
        ?>
        <img src="<?php echo esc_url($about_img); ?>" alt="SCGI Campus, Kolar" />
        <div class="estd-badge">
          <div class="estd-num"><?php echo esc_html(get_theme_mod('scgi_estd', '2006')); ?></div>
          <div class="estd-lbl">Established</div>
        </div>
      </div>
      <div>
        <div class="sec-label"><?php echo esc_html(get_theme_mod('scgi_about_label', 'At SCGI')); ?></div>
        <h2 class="sec-title"><?php echo esc_html(get_theme_mod('scgi_about_heading', 'Building a Legacy of Healthcare Excellence')); ?></h2>
        <p class="sec-sub"><?php echo esc_html(get_theme_mod('scgi_about_text', 'SCGI has scripted success stories in the field of education and was established in the year 2006. We are affiliated to Rajiv Gandhi University of Health Sciences (RGUHS). SCGI is nestled in Kolar with own hospital, situated just beside the Chennai–Bangalore highway.')); ?></p>
        <p class="sec-sub" style="margin-top:12px"><?php echo esc_html(get_theme_mod('scgi_about_text_2', 'At SCGI, we believe that education is not limited to just academics. We aim to teach the upcoming generations that learning and developing their individual skills are for providing quality care, responsibility and respect within the society.')); ?></p>
        <a href="#courses" class="btn-primary" style="margin-top:10px"><i class="fas fa-arrow-right"></i>Explore Our Courses</a>
      </div>
    </div>
    <div class="acc-marquee-v2">
      <div class="acc-track-v2">
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Recognised by the Government of Karnataka</div>
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Affiliated to Rajiv Gandhi University of Health Sciences (RGUHS)</div>
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Approved by Indian Nursing Council (INC) &amp; Karnataka State Nursing Council</div>
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Approved by Karnataka State Diploma in Nursing Examination Board (KSDNEB)</div>
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Approved By Karnataka Paramedical Board</div>
        <!-- Duplicate for loop -->
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Recognised by the Government of Karnataka</div>
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Affiliated to Rajiv Gandhi University of Health Sciences (RGUHS)</div>
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Approved by Indian Nursing Council (INC) &amp; Karnataka State Nursing Council</div>
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Approved by Karnataka State Diploma in Nursing Examination Board (KSDNEB)</div>
        <div class="acc-v2-item"><i class="fas fa-check-circle"></i>Approved By Karnataka Paramedical Board</div>
      </div>
    </div>
  </div>
</section>

<!-- ACCREDITATION BAR -->
<section class="accreditation-bar sec-bg-light">
  <div class="container">
    <div class="acc-flex">
      <div class="acc-title-side">
        <div class="acc-label">INSTITUTIONAL CREDENTIALS</div>
        <h2 class="acc-heading">Accreditation &amp; Affiliations</h2>
      </div>
      <div class="acc-divider"></div>
      <div class="acc-marquee-wrap">
        <div class="acc-marquee-track">
          <?php
          $logos = array(
              array('img' => 'ka-govt-cropped.png', 'alt' => 'Govt. of Karnataka'),
              array('img' => 'rguhs-cropped.png', 'alt' => 'RGUHS'),
              array('img' => 'inc-cropped.png', 'alt' => 'INC'),
              array('img' => 'ksnc-cropped.png', 'alt' => 'KSNC'),
              array('img' => 'Logo%20of%20Karnataka%20paramedical%20board.webp', 'alt' => 'Karnataka Paramedical Board'),
              array('img' => 'Karnataka%20state%20diploma%20in%20nursing%20examination%20board.png', 'alt' => 'KSDNEB')
          );
          // Output twice for seamless loop
          for ($i = 0; $i < 2; $i++) {
              foreach ($logos as $logo) {
                  echo '<img src="' . get_template_directory_uri() . '/' . $logo['img'] . '" alt="' . esc_attr($logo['alt']) . '" class="acc-marquee-img">';
              }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- COURSES -->
<section class="courses sec-bg-blue bg-pattern" id="courses">
  <div class="container">
    <div class="tc">
      <div class="sec-label">Our Programmes</div>
      <h2 class="sec-title">Courses We Offer</h2>
      <p class="sec-sub">Choose from a wide range of undergraduate, postgraduate, and diploma programmes in Nursing, Allied Health Science, and Physiotherapy — all under one campus.</p>
    </div>
    <?php get_template_part( 'template-parts/courses-slider' ); ?>
  </div>
</section>

<!-- BANNER CTA -->
<?php get_template_part( 'template-parts/cta-band' ); ?>

<!-- OUR FACILITIES (Icon Grid) -->
<section class="fac-section sec-bg-light" id="facilities">
  <div class="container">
    <div class="tc" style="margin-bottom: 50px;">
      <div class="sec-label"><?php echo esc_html(get_theme_mod('scgi_fac_label', 'Campus Life')); ?></div>
      <h2 class="sec-title"><?php echo esc_html(get_theme_mod('scgi_fac_heading', 'Our Facilities')); ?></h2>
      <p class="sec-sub"><?php echo esc_html(get_theme_mod('scgi_fac_sub', 'At SCGI, every facility is thoughtfully designed to support the holistic growth of our students — academically, clinically, and personally.')); ?></p>
    </div>
    <div class="fac-grid">
      <?php
      $fac_items_raw = get_theme_mod( 'scgi_fac_items', "fa-building|Hostel|Separate secure hostel for Girls within the college Premises and separate hostel for boys\nfa-laptop-code|Digital Classroom|Facilitators at SCGI believe in technology friendly teaching method. All Classrooms are equipped with projectors and interactive boards\nfa-user-graduate|Placement Cell|Our students are spread all over India and abroad as successful Nursing professional. Placement guidance will be provided by our Placement cell.\nfa-microscope|Labs|Nursing Foundation Lab • Maternity & Child Health Lab • Community Health Nursing Lab • Nutrition Lab • Anatomy Lab • Microbiology & Biochemistry Lab • Computer Lab" );
      $fac_items = explode( "\n", str_replace( "\r", "", $fac_items_raw ) );
      foreach ( $fac_items as $item ) :
          $parts = explode( '|', trim( $item ) );
          if ( count( $parts ) < 3 ) continue;
          list( $icon, $title, $desc ) = $parts;
      ?>
          <div class="fac-item">
            <div class="fac-icon"><i class="fas <?php echo esc_attr( trim( $icon ) ); ?>"></i></div>
            <h4><?php echo esc_html( trim( $title ) ); ?></h4>
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

<?php get_footer(); ?>
