<!-- FOOTER -->
<footer id="contact">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <?php 
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
        if ( has_custom_logo() ) {
            echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '">';
        } else {
            echo '<img src="' . get_template_directory_uri() . '/SCGI-Logo.png" alt="SCGI Logo">';
        }
        ?>
        <p><?php echo esc_html(get_theme_mod('scgi_footer_about', 'SCGI was established in 2006 and is affiliated to Rajiv Gandhi University of Health Sciences (RGUHS). Nestled in Kolar beside the Chennai–Bangalore highway, SCGI is a premier healthcare education institution with its own on-campus hospital.')); ?></p>
        <div class="footer-social">
          <a href="https://wa.me/<?php echo esc_attr(get_theme_mod('scgi_whatsapp', '919769002277')); ?>" class="soc-btn" target="_blank"><i class="fab fa-whatsapp"></i></a>
          <a href="<?php echo esc_url(get_theme_mod('scgi_facebook', '#')); ?>" class="soc-btn"><i class="fab fa-facebook-f"></i></a>
          <a href="<?php echo esc_url(get_theme_mod('scgi_instagram', '#')); ?>" class="soc-btn"><i class="fab fa-instagram"></i></a>
          <a href="<?php echo esc_url(get_theme_mod('scgi_youtube', '#')); ?>" class="soc-btn"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <div class="fc">
        <h5>Course Links</h5>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'fl',
            'fallback_cb'    => '__return_false',
        ) );
        ?>
      </div>

      <div class="fc">
        <h5>Quick Links</h5>
        <ul class="fl">
          <li><a href="<?php echo esc_url(home_url('/')); ?>"><i class="fas fa-chevron-right"></i>Home</a></li>
          <li><a href="<?php echo esc_url(home_url('/about-us')); ?>"><i class="fas fa-chevron-right"></i>About Us</a></li>
          <li><a href="<?php echo esc_url(home_url('/courses')); ?>"><i class="fas fa-chevron-right"></i>Courses</a></li>
          <li><a href="<?php echo esc_url(home_url('/gallery')); ?>"><i class="fas fa-chevron-right"></i>Gallery</a></li>
          <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><i class="fas fa-chevron-right"></i>Contact</a></li>
        </ul>
      </div>

      <div class="fc">
        <h5>Contact Us</h5>
        <div class="fci"><i class="fas fa-map-marker-alt"></i><span><?php echo esc_html(get_theme_mod('scgi_address', 'NH4 Bypass, Near Railway Gate, Kogilahally Village, Kolar, Karnataka – 563102')); ?></span></div>
        <div class="fci"><i class="fas fa-phone-alt"></i><a href="tel:<?php echo esc_attr(get_theme_mod('scgi_phone', '+919947915916')); ?>" style="color:rgba(255,255,255,.65)"><?php echo esc_html(get_theme_mod('scgi_phone_display', '+91 99479 15916 / 97690 02277')); ?></a></div>
        <div class="fci"><i class="fas fa-envelope"></i><a href="mailto:<?php echo esc_attr(get_theme_mod('scgi_email', 'info@scgi.in')); ?>" style="color:rgba(255,255,255,.65)"><?php echo esc_html(get_theme_mod('scgi_email', 'info@scgi.in')); ?></a></div>
      </div>
    </div>

    <div class="footer-bottom">
      <div>© <?php echo date('Y'); ?> Sri Channegowda Group of Institutions (SCGI), Kolar. All rights reserved.</div>
      <div>RGUHS Affiliated &nbsp;|&nbsp; Govt. of Karnataka Recognised | Developed by <a href="https://www.bten.in" target="_blank" style="color:inherit;text-decoration:none">BTen</a></div>
    </div>
  </div>
</footer>

<button id="st" aria-label="Back to top"><i class="fas fa-chevron-up"></i></button>

<!-- Enquiry Modal -->
<div id="enquiryModal" class="modal-overlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center; padding:20px;">
  <div class="modal-box" style="background:#fff; width:100%; max-width:500px; border-radius:12px; padding:30px; position:relative; box-shadow:0 10px 40px rgba(0,0,0,0.2);">
    <button onclick="document.getElementById('enquiryModal').style.display='none'" style="position:absolute; top:15px; right:20px; background:transparent; border:none; font-size:1.5rem; cursor:pointer; color:#555;">&times;</button>
    <h3 style="margin-bottom:20px; font-family:'GT Super Ds', serif; color:#0d2463;">Course Enquiry</h3>
    <form id="modalForm" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post">
      <input type="hidden" name="action" value="scgi_course_enquiry">
      <?php wp_nonce_field( 'scgi_form_submit', 'enquiry_nonce' ); ?>
      <div style="margin-bottom:15px;">
        <label style="display:block; font-size:0.85rem; font-weight:600; color:var(--blue-dark); margin-bottom:6px;">Select Category</label>
        <select id="modalCategory" name="category" class="modal-input" required>
          <option value="">Select Course Category</option>
          <?php
          $terms = get_terms( array('taxonomy' => 'course_category', 'hide_empty' => false) );
          foreach($terms as $term) {
              echo '<option value="'.esc_attr($term->name).'">'.esc_html($term->name).'</option>';
          }
          ?>
        </select>
      </div>
      <div style="margin-bottom:15px;">
        <label style="display:block; font-size:0.85rem; font-weight:600; color:var(--blue-dark); margin-bottom:6px;">Select Course</label>
        <select id="modalCourse" name="course" class="modal-input" required>
          <option value="">Select Course Details</option>
        </select>
      </div>
      <div style="margin-bottom:15px;">
        <label style="display:block; font-size:0.85rem; font-weight:600; color:var(--blue-dark); margin-bottom:6px;">Select State</label>
        <select id="modalState" name="state" class="modal-input" required>
          <option value="">Select State</option>
          <option value="Karnataka">Karnataka</option>
          <option value="Kerala">Kerala</option>
          <option value="Tamil Nadu">Tamil Nadu</option>
          <option value="Andhra Pradesh">Andhra Pradesh</option>
          <option value="Maharashtra">Maharashtra</option>
          <option value="Other">Other</option>
        </select>
      </div>
      <div style="margin-bottom:20px;">
        <label style="display:block; font-size:0.85rem; font-weight:600; color:var(--blue-dark); margin-bottom:6px;">Enter City</label>
        <input type="text" id="modalCity" name="city" class="hero-input" placeholder="Enter City" style="width:100%; padding:12px; border:1px solid #ccc; border-radius:6px; background:#f9f9f9; outline:none;" required>
      </div>
      <button type="submit" class="btn-gold hero-submit">Submit Enquiry</button>
    </form>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
