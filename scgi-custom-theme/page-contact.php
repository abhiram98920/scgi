<?php
/**
 * Template Name: Contact Page
 */
get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<!-- INNER HERO -->
<section class="inner-hero" style="background: linear-gradient(to top, rgba(13,36,99,0.85) 0%, transparent 50%), url('<?php echo get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : 'https://images.unsplash.com/photo-1523966211575-eb4a01e7dd51?w=1600&q=80'; ?>') center / cover;">
  <div class="container">
    <h1><?php the_title(); ?></h1>
  </div>
</section>

<!-- BREADCRUMB BAR -->
<div class="breadcrumb-bar">
  <div class="container">
    <div class="breadcrumb">
      <a href="<?php echo esc_url(home_url('/')); ?>">Home</a> 
      <i class="fas fa-circle"></i> 
      <span><?php the_title(); ?></span>
    </div>
  </div>
</div>

<!-- CONTACT SECTION -->
<div class="container" id="enquire" style="padding: 100px 0;">
  <div class="contact-grid">
    <div class="contact-form-side">
      <h2>Send a Message</h2>
      <?php 
      // If Contact Form 7 or similar is used, we'd put the shortcode here.
      // For now, we'll keep the static structure as requested for "Zero Deviation" parity,
      // but wrapping it for potential future dynamic use.
      ?>
      <form action="#" class="contact-form">
        <div class="form-row">
          <div class="form-group">
            <label>Name</label>
            <input type="text" placeholder="Your Name" required />
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" placeholder="Your Email" required />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Mobile Number</label>
            <input type="tel" placeholder="Mobile Number" required />
          </div>
          <div class="form-group">
            <label>Alternative Number</label>
            <input type="tel" placeholder="Alternative Number" />
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Course Category</label>
            <select id="contactCategory" name="category" required>
              <option value="">Select Category</option>
              <option value="Nursing">Nursing</option>
              <option value="Physiotherapy">Physiotherapy</option>
              <option value="Allied Health Science">Allied Health Science</option>
            </select>
          </div>
          <div class="form-group">
            <label>Select Course</label>
            <select id="contactCourse" name="course" required>
              <option value="">Select Course Details</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>State</label>
            <select id="contactState" name="state" required>
              <option value="">Select State</option>
              <option value="Karnataka">Karnataka</option>
              <option value="Kerala">Kerala</option>
              <option value="Tamil Nadu">Tamil Nadu</option>
              <option value="Andhra Pradesh">Andhra Pradesh</option>
              <option value="Maharashtra">Maharashtra</option>
              <option value="Other">Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>City</label>
            <input type="text" id="contactCity" name="city" placeholder="City" required />
          </div>
        </div>
        <div class="form-group">
          <label>Your Message</label>
          <textarea rows="5" placeholder="How can we help you?"></textarea>
        </div>
        <button type="submit" class="submit-btn">Submit Request</button>
      </form>
    </div>

    <div class="contact-info-side">
      <div class="info-item">
        <i class="fas fa-map-marker-alt"></i>
        <div class="info-content">
          <h4>Address</h4>
          <p><?php echo esc_html( get_theme_mod('scgi_address', 'NH4 Bypass, Near Railway Gate, Kogilahally Village, Dodda Hasala Gram Panchayath, Kolar, Karnataka – 563102') ); ?></p>
        </div>
      </div>
      <div class="info-item">
        <i class="fas fa-phone-alt"></i>
        <div class="info-content">
          <h4>Contact Number</h4>
          <p><a href="tel:<?php echo esc_attr( get_theme_mod('scgi_phone', '+919947915916') ); ?>"><?php echo esc_html( get_theme_mod('scgi_phone', '+91 99479 15916 / 97690 02277') ); ?></a></p>
        </div>
      </div>
      <div class="info-item">
        <i class="fas fa-envelope"></i>
        <div class="info-content">
          <h4>Email Address</h4>
          <p><a href="mailto:<?php echo esc_attr( get_theme_mod('scgi_email', 'info@scgi.in') ); ?>"><?php echo esc_html( get_theme_mod('scgi_email', 'info@scgi.in') ); ?></a></p>
        </div>
      </div>
      
      <div style="margin-top: 40px;">
        <h4 style="color: var(--blue-dark); margin-bottom: 20px;">Follow Us</h4>
        <div class="footer-social" style="margin-top: 0;">
          <a href="<?php echo esc_url( get_theme_mod('scgi_facebook', '#') ); ?>" class="soc-btn" style="border-color: #eee;"><i class="fab fa-facebook-f"></i></a>
          <a href="<?php echo esc_url( get_theme_mod('scgi_instagram', '#') ); ?>" class="soc-btn" style="border-color: #eee;"><i class="fab fa-instagram"></i></a>
          <a href="<?php echo esc_url( get_theme_mod('scgi_linkedin', '#') ); ?>" class="soc-btn" style="border-color: #eee;"><i class="fab fa-linkedin-in"></i></a>
          <a href="<?php echo esc_url( get_theme_mod('scgi_youtube', '#') ); ?>" class="soc-btn" style="border-color: #eee;"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CTA BAND (With Badges) -->
<section class="cta-band" style="background: var(--off-white); padding: 80px 0;">
  <div class="container">
    <div class="tc" style="text-align: center;">
      <div class="sec-label" style="justify-content: center; color: var(--blue);">Contact our Counsellor</div>
      <h2 class="sec-title" style="color: var(--blue-dark); text-align: center; margin-bottom: 14px;">Clarify all you doubts about the course, fees, college and more</h2>
      <div class="hero-badges-wrap reveal" style="margin-top:20px; justify-content: center;">
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
        <div class="hero-badge-item">
            <img src="<?php echo get_template_directory_uri(); ?>/ka-govt-cropped.png" alt="Govt-Recognised" class="hero-badge-img">
            <span>Recognised by Govt of Karnataka</span>
        </div>
      </div>
      <a href="tel:<?php echo esc_attr( get_theme_mod('scgi_phone', '+919947915916') ); ?>" class="btn-primary" style="margin-top: 30px; display: inline-block; padding: 14px 32px; background: var(--blue); color: #fff; border-radius: 6px; text-decoration: none; font-weight: 600;">
        <i class="fas fa-phone-alt" style="margin-right: 8px;"></i> Call Now
      </a>
    </div>
  </div>
</section>

<!-- BANNER CTA -->
<?php get_template_part('template-parts/cta-band'); ?>

<!-- MAP SECTION -->
<div style="line-height: 0;">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3882.847!2d77.9693!3d13.1358!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDA4JzA5LjAiTiA3N8KwNTgnMDkuNiJF!5e0!3m2!1sen!2sin!4v1" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
