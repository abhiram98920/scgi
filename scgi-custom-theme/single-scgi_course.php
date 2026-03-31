<?php
/**
 * Template Part: Single Course Detail
 */
get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $duration = get_post_meta(get_the_ID(), '_course_duration', true) ?: '3.5 YEARS';
    $eligibility_short = get_post_meta(get_the_ID(), '_course_eligibility_short', true) ?: '10+2 YEARS';
    $excellence = get_post_meta(get_the_ID(), '_course_excellence', true) ?: '16 YEARS';
    $campus_size = get_post_meta(get_the_ID(), '_course_campus_size', true) ?: '5+ ACRE';
    
    $hero_desc = get_post_meta(get_the_ID(), '_course_hero_desc', true) ?: get_the_excerpt();
    $full_desc = get_the_content();
    
    $why_title = get_post_meta(get_the_ID(), '_course_why_title', true) ?: 'Answer for Why ' . get_the_title();
    $why_text = get_post_meta(get_the_ID(), '_course_why_text', true);
    $why_list = get_post_meta(get_the_ID(), '_course_why_list', true);
    
    $eligibility_full = get_post_meta(get_the_ID(), '_course_eligibility_full', true);
    $exam_eligibility = get_post_meta(get_the_ID(), '_course_exam_eligibility', true);
?>

<!-- INNER HERO -->
<section class="inner-hero" style="background-image: linear-gradient(to top, rgba(13,36,99,0.9) 0%, rgba(13,36,99,0.3) 60%, transparent 100%), url('<?php echo $thumb ?: 'https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?w=1600&q=80'; ?>');">
  <div class="container">
    <div class="inner-hero-content">
      <h1><?php the_title(); ?></h1>
      <?php if ( $hero_desc ) : ?>
        <p class="inner-hero-desc"><?php echo esc_html( $hero_desc ); ?></p>
      <?php endif; ?>
      <div class="inner-hero-btns">
        <a href="<?php echo esc_url(home_url('/contact')); ?>#enquire" class="btn-hero-enq">Enquire Now</a>
        <a href="#" class="btn-hero-brochure"><i class="fas fa-circle-dot" style="font-size:0.75em;"></i> Download Brochure</a>
      </div>
    </div>
  </div>
</section>

<!-- COUNTER BAR -->
<div class="inner-counter-bar">
  <div class="inner-counter-wrap">
    <div class="inner-counter-item">
      <span class="inner-counter-num"><?php echo esc_html($duration); ?></span>
      <span class="inner-counter-lbl">Duration</span>
    </div>
    <div class="inner-counter-item">
      <span class="inner-counter-num"><?php echo esc_html($eligibility_short); ?></span>
      <span class="inner-counter-lbl">Eligibility</span>
    </div>
    <div class="inner-counter-item">
      <span class="inner-counter-num"><?php echo esc_html($excellence); ?></span>
      <span class="inner-counter-lbl">Excellence</span>
    </div>
    <div class="inner-counter-item">
      <span class="inner-counter-num"><?php echo esc_html($campus_size); ?></span>
      <span class="inner-counter-lbl">Campus</span>
    </div>
  </div>
</div>

<!-- BREADCRUMB BAR -->
<div class="breadcrumb-bar">
  <div class="container">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> 
      <i class="fas fa-circle"></i> 
      <?php 
      $terms = get_the_terms( get_the_ID(), 'course_category' );
      if ( $terms && ! is_wp_error( $terms ) ) :
          $term = array_shift( $terms );
          echo '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
          echo '<i class="fas fa-circle"></i>';
      endif;
      ?>
      <span><?php the_title(); ?></span>
    </div>
  </div>
</div>

<!-- COURSE DETAIL CONTENT -->
<section class="detail-section sec-bg-light" style="padding-top: 80px;">
  <div class="container">
    <div class="detail-grid">
      <div class="detail-text">
        <h2 class="sec-title" style="margin-bottom: 24px;"><?php the_title(); ?></h2>
        
        <div class="hero-badges-wrap reveal" style="margin-bottom:30px; justify-content: flex-start;">
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
                <span>KSDNEB</span>
            </div>
            <div class="hero-badge-item">
                <img src="<?php echo get_template_directory_uri(); ?>/Logo of Karnataka paramedical board.webp" alt="Paramedical-Board" class="hero-badge-img">
                <span>Karnataka Paramedical Board</span>
            </div>
        </div>

        <div class="sec-sub" style="margin-bottom: 30px; line-height: 1.8;">
            <?php echo $full_desc; ?>
        </div>
        
        <div style="display: flex; gap: 15px;">
          <a href="<?php echo esc_url(home_url('/contact')); ?>#enquire" class="btn-primary">Enquire Now</a>
          <a href="#" class="btn-outline">Download Brochure</a>
        </div>
      </div>
      <div class="detail-img reveal">
        <img src="<?php echo $thumb ?: 'https://images.unsplash.com/photo-1581594693702-fbdc51b2763b?w=800&q=80'; ?>" alt="<?php the_title_attribute(); ?>" />
      </div>
    </div>
  </div>
</section>

<!-- WHY SECTION -->
<?php if ( $why_text || $why_list ) : ?>
<section class="why-section sec-bg-blue bg-pattern">
  <div class="container">
    <div class="tc" style="margin-bottom: 50px;">
      <h2 class="sec-title"><?php echo esc_html( $why_title ); ?></h2>
      <?php if ( $why_text ) : ?>
        <p class="sec-sub"><?php echo esc_html( $why_text ); ?></p>
      <?php endif; ?>
    </div>
    <?php if ( $why_list ) : 
        $list_items = explode("\n", str_replace("\r", "", $why_list));
    ?>
    <div style="max-width: 900px; margin: 0 auto; line-height: 1.8; color: var(--text);">
      <p>To convince you further, here are some more reasons why you should consider this course:</p>
      <ul style="list-style: none; padding: 0; margin-top: 15px; display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
        <?php foreach ( $list_items as $item ) : if ( trim($item) == '' ) continue; ?>
            <li><i class="fas fa-check-circle" style="color: var(--gold); margin-right: 10px;"></i> <?php echo esc_html(trim($item)); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ELIGIBILITY SECTION -->
<section class="detail-section sec-bg-light">
  <div class="container">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px;">
      <div>
        <h3 style="font-family: 'GT Super Ds', serif; font-size: 1.8rem; color: var(--blue-dark); margin-bottom: 20px;">Eligibility</h3>
        <p style="line-height: 1.8;"><?php echo esc_html( $eligibility_full ?: 'Contact us for detailed eligibility criteria.' ); ?></p>
      </div>
      <div>
        <h3 style="font-family: 'GT Super Ds', serif; font-size: 1.8rem; color: var(--blue-dark); margin-bottom: 20px;">Eligibility for Examination</h3>
        <p style="line-height: 1.7; font-size: 0.95rem;"><?php echo esc_html( $exam_eligibility ?: 'Students should have 80% attendance in theory and practicals.' ); ?></p>
      </div>
    </div>
  </div>
</section>

<!-- BANNER CTA -->
<?php get_template_part('template-parts/cta-band'); ?>

<!-- OUR FACILITY -->
<section class="fac-section sec-bg-light">
  <div class="container">
    <div class="tc">
      <h2 class="sec-title">Our <em>Facility</em></h2>
    </div>
    <div class="fac-grid">
      <div class="fac-item">
        <div class="fac-icon"><i class="fas fa-building"></i></div>
        <h4>Hostel</h4>
        <p>Separate secure hostel for Girls within the college Premises and separate hostel for boys</p>
      </div>
      <div class="fac-item">
        <div class="fac-icon"><i class="fas fa-laptop-code"></i></div>
        <h4>Digital Classroom</h4>
        <p>Facilitators at SCGI believe in technology friendly teaching method. All Classrooms are equipped with projectors and interactive boards</p>
      </div>
      <div class="fac-item">
        <div class="fac-icon"><i class="fas fa-user-graduate"></i></div>
        <h4>Placement Cell</h4>
        <p>Our students are spread all over India and abroad as successful Nursing professional. Placement guidance will be provided by our Placement cell.</p>
      </div>
      <div class="fac-item">
        <div class="fac-icon"><i class="fas fa-microscope"></i></div>
        <h4>Labs</h4>
        <p>Nursing Foundation Lab • Maternity &amp; Child Health Lab • Community Health Nursing Lab • Nutrition Lab • Anatomy Lab • Microbiology &amp; Biochemistry Lab • Computer Lab</p>
      </div>
      <div class="fac-item">
        <div class="fac-icon"><i class="fas fa-chalkboard-teacher"></i></div>
        <h4>Trained Tutor</h4>
        <p>Multi disciplinary programmes supported by experienced &amp; dedicated teachers</p>
      </div>
      <div class="fac-item">
        <div class="fac-icon"><i class="fas fa-book-reader"></i></div>
        <h4>Library &amp; Research Centre</h4>
        <p>Adequate collection of library books with internet facilities</p>
      </div>
      <div class="fac-item">
        <div class="fac-icon"><i class="fas fa-palette"></i></div>
        <h4>Arts &amp; Culture</h4>
        <p>Various cultural activities are organised and it helps to enhance the skills of our students.</p>
      </div>
      <div class="fac-item">
        <div class="fac-icon"><i class="fas fa-hospital-alt"></i></div>
        <h4>Own Hospital</h4>
        <p>We have our own hospital which is equipped with advanced equipments.</p>
      </div>
    </div>
  </div>
</section>

<!-- COUNSELLOR CTA -->
<section class="cta-band" style="background: var(--blue-dark); padding: 80px 0;">
  <div class="container">
    <div class="tc">
      <div class="sec-label" style="justify-content: center; color: var(--gold-pale);">Contact our Counsellor</div>
      <h2 class="sec-title" style="color: #fff; text-align: center; margin-bottom: 14px;">Clarify all you doubts about the course, fees, college and more</h2>
      <a href="<?php echo esc_url(home_url('/contact')); ?>#enquire" class="btn-gold" style="margin-top: 30px;"><i class="fas fa-phone-alt"></i> Contact Us</a>
    </div>
  </div>
</section>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
