<?php 
/**
 * Template Name: Contact Page
 */
get_header(); ?>

<!-- INNER HERO -->
<section class="inner-hero" style="background: linear-gradient(to top, rgba(13,36,99,0.85) 0%, transparent 50%), url('<?php echo get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=1600&q=80'; ?>') center / cover;">
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

<div class="contact-section">
  <div class="container">
    <div class="contact-grid">
      <div class="contact-form-wrap">
        <h2>Send Us a Message</h2>
        <p>Fill out the form below and our team will get back to you shortly.</p>
        
        <?php if ( isset($_GET['success']) ) : ?>
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                Your message has been sent successfully! Our team will contact you soon.
            </div>
        <?php endif; ?>

        <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" class="contact-form">
          <input type="hidden" name="action" value="scgi_contact">
          <?php wp_nonce_field( 'scgi_form_submit', 'contact_nonce' ); ?>
          
          <div class="form-row">
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" name="name" placeholder="Enter your name" required>
            </div>
            <div class="form-group">
              <label>Email Address</label>
              <input type="email" name="email" placeholder="Enter your email" required>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label>Mobile Number</label>
              <input type="tel" name="phone" placeholder="Enter mobile number" required>
            </div>
            <div class="form-group">
              <label>Alternative Number</label>
              <input type="tel" name="alt_phone" placeholder="Optional alternative number">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>State</label>
              <select name="state" required>
                <option value="">Select State</option>
                <option value="Karnataka">Karnataka</option>
                <option value="Kerala">Kerala</option>
                <option value="Tamil Nadu">Tamil Nadu</option>
                <option value="Andhra Pradesh">Andhra Pradesh</option>
                <option value="Other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <label>City</label>
              <input type="text" name="city" placeholder="Enter your city" required>
            </div>
          </div>

          <div class="form-group">
            <label>Your Message</label>
            <textarea name="message" rows="5" placeholder="How can we help you?"></textarea>
          </div>
          <button type="submit" class="btn-primary" style="width: 100%; justify-content: center;">Submit Request</button>
        </form>
      </div>

      <div class="contact-info-side">
        <div class="info-item">
          <i class="fas fa-map-marker-alt"></i>
          <div class="info-content">
            <h4>Address</h4>
            <p><?php echo esc_html(get_theme_mod('scgi_address', 'NH4 Bypass, Near Railway Gate, Kogilahally Village, Kolar, Karnataka – 563102')); ?></p>
          </div>
        </div>
        <div class="info-item">
          <i class="fas fa-phone-alt"></i>
          <div class="info-content">
            <h4>Contact Number</h4>
            <p><a href="tel:<?php echo esc_attr(get_theme_mod('scgi_phone', '+919947915916')); ?>"><?php echo esc_html(get_theme_mod('scgi_phone_display', '+91 99479 15916 / 97690 02277')); ?></a></p>
          </div>
        </div>
        <div class="info-item">
          <i class="fas fa-envelope"></i>
          <div class="info-content">
            <h4>Email Address</h4>
            <p><a href="mailto:<?php echo esc_attr(get_theme_mod('scgi_email', 'info@scgi.in')); ?>"><?php echo esc_html(get_theme_mod('scgi_email', 'info@scgi.in')); ?></a></p>
          </div>
        </div>
        
        <div style="margin-top: 40px;">
          <h4 style="color: var(--blue-dark); margin-bottom: 20px;">Follow Us</h4>
          <div class="footer-social" style="margin-top: 0;">
            <a href="<?php echo esc_url(get_theme_mod('scgi_facebook', '#')); ?>" class="soc-btn"><i class="fab fa-facebook-f"></i></a>
            <a href="<?php echo esc_url(get_theme_mod('scgi_instagram', '#')); ?>" class="soc-btn"><i class="fab fa-instagram"></i></a>
            <a href="https://wa.me/<?php echo esc_attr(get_theme_mod('scgi_whatsapp', '919769002277')); ?>" class="soc-btn"><i class="fab fa-whatsapp"></i></a>
            <a href="<?php echo esc_url(get_theme_mod('scgi_youtube', '#')); ?>" class="soc-btn"><i class="fab fa-youtube"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div style="line-height: 0;">
  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3882.847!2d77.9693!3d13.1358!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDA4JzA5LjAiTiA3N8KwNTgnMDkuNiJF!5e0!3m2!1sen!2sin!4v1" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>

<?php get_footer(); ?>
