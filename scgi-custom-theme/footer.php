<!-- FOOTER -->
<footer id="contact">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-brand">
        <?php
        $custom_logo_id = get_theme_mod( 'custom_logo' );
        $logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
        if ( has_custom_logo() ) {
            echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
        } else {
            echo '<img src="' . get_template_directory_uri() . '/SCGI-Logo.png" alt="SCGI Logo">';
        }
        ?>
        <p><?php echo esc_html( get_theme_mod( 'scgi_footer_about', 'SCGI was established in 2006 and is affiliated to Rajiv Gandhi University of Health Sciences (RGUHS). Nestled in Kolar beside the Chennai–Bangalore highway, SCGI is a premier healthcare education institution with its own on-campus hospital.' ) ); ?></p>
        <div class="footer-social">
          <a href="https://wa.me/<?php echo esc_attr( get_theme_mod( 'scgi_whatsapp', '919769002277' ) ); ?>" class="soc-btn" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>
          <a href="<?php echo esc_url( get_theme_mod( 'scgi_facebook', '#' ) ); ?>" class="soc-btn" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
          <a href="<?php echo esc_url( get_theme_mod( 'scgi_instagram', '#' ) ); ?>" class="soc-btn" target="_blank" rel="noopener"><i class="fab fa-instagram"></i></a>
          <a href="<?php echo esc_url( get_theme_mod( 'scgi_youtube', '#' ) ); ?>" class="soc-btn" target="_blank" rel="noopener"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <div class="fc">
        <h5>Nursing Courses</h5>
        <ul class="fl">
          <li><a href="<?php echo esc_url( home_url( '/nursing-gnm' ) ); ?>"><i class="fas fa-chevron-right"></i>General Nursing and Midwifery (GNM)</a></li>
          <li><a href="<?php echo esc_url( home_url( '/nursing-bsc' ) ); ?>"><i class="fas fa-chevron-right"></i>Basic B.Sc Nursing</a></li>
          <li><a href="<?php echo esc_url( home_url( '/nursing-pbbsc' ) ); ?>"><i class="fas fa-chevron-right"></i>Post Basic B.Sc Nursing (P.B B.Sc Nursing)</a></li>
          <li><a href="<?php echo esc_url( home_url( '/nursing-msc' ) ); ?>"><i class="fas fa-chevron-right"></i>Master of Science in Nursing (M.Sc Nursing)</a></li>
        </ul>
        <h5 style="margin-top:22px">Physio &amp; Allied Health</h5>
        <ul class="fl">
          <li><a href="<?php echo esc_url( home_url( '/physiotherapy-bpt' ) ); ?>"><i class="fas fa-chevron-right"></i>BPT</a></li>
          <li><a href="<?php echo esc_url( home_url( '/allied-bmlt' ) ); ?>"><i class="fas fa-chevron-right"></i>Medical Laboratory Technology (B.Sc MLT)</a></li>
          <li><a href="<?php echo esc_url( home_url( '/allied-atott' ) ); ?>"><i class="fas fa-chevron-right"></i>B.Sc AT &amp; OTT</a></li>
          <li class="footer-category-label">Paramedical Courses</li>
          <li><a href="<?php echo esc_url( home_url( '/allied-dmlt' ) ); ?>"><i class="fas fa-chevron-right"></i>Diploma in MLT</a></li>
          <li><a href="<?php echo esc_url( home_url( '/allied-dott' ) ); ?>"><i class="fas fa-chevron-right"></i>Diploma in OTT</a></li>
          <li><a href="<?php echo esc_url( home_url( '/allied-dhi' ) ); ?>"><i class="fas fa-chevron-right"></i>Diploma in Health Inspector</a></li>
        </ul>
      </div>

      <div class="fc">
        <h5>Quick Links</h5>
        <ul class="fl">
          <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fas fa-chevron-right"></i>Home</a></li>
          <li><a href="<?php echo esc_url( home_url( '/about-us' ) ); ?>"><i class="fas fa-chevron-right"></i>About Us</a></li>
          <li><a href="<?php echo esc_url( home_url( '/courses' ) ); ?>"><i class="fas fa-chevron-right"></i>Courses</a></li>
          <li><a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>"><i class="fas fa-chevron-right"></i>Gallery</a></li>
          <li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><i class="fas fa-chevron-right"></i>Contact</a></li>
        </ul>
      </div>

      <div class="fc">
        <h5>Contact Us</h5>
        <div class="fci"><i class="fas fa-map-marker-alt"></i><span><?php echo esc_html( get_theme_mod( 'scgi_address', 'NH4 Bypass, Near Railway Gate, Kogilahally Village, Dodda Hasala Gram Panchayath, Kolar, Karnataka – 563102' ) ); ?></span></div>
        <div class="fci"><i class="fas fa-phone-alt"></i><a href="tel:<?php echo esc_attr( get_theme_mod( 'scgi_phone', '+919947915916' ) ); ?>" style="color:rgba(255,255,255,.65)"><?php echo esc_html( get_theme_mod( 'scgi_phone_display', '+91 99479 15916 / 97690 02277' ) ); ?></a></div>
        <div class="fci"><i class="fas fa-envelope"></i><a href="mailto:<?php echo esc_attr( get_theme_mod( 'scgi_email', 'info@scgi.in' ) ); ?>" style="color:rgba(255,255,255,.65)"><?php echo esc_html( get_theme_mod( 'scgi_email', 'info@scgi.in' ) ); ?></a></div>
        <div style="margin-top:16px;border-radius:10px;overflow:hidden;line-height:0">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3882.847!2d77.9693!3d13.1358!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTPCsDA4JzA5LjAiTiA3N8KwNTgnMDkuNiJF!5e0!3m2!1sen!2sin!4v1" width="100%" height="148" style="border:0;filter:invert(.85) hue-rotate(180deg)" allowfullscreen="" loading="lazy" title="SCGI Location Map"></iframe>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div>© <?php echo date( 'Y' ); ?> Sri Channegowda Group of Institutions (SCGI), Kolar. All rights reserved.</div>
      <div class="footer-cred"><span>RGUHS Affiliated</span><span class="sep">|</span><span>Govt. of Karnataka Recognised</span><span class="sep">|</span><span>Developed by <a href="https://www.bten.in" target="_blank" rel="noopener">BTen</a></span></div>
    </div>
  </div>
</footer>

<button id="st" aria-label="Back to top"><i class="fas fa-chevron-up"></i></button>

<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
      document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
      this.classList.add('active');
      document.getElementById('tab-' + this.dataset.tab).classList.add('active');
    });
  });

  const st = document.getElementById('st');
  window.addEventListener('scroll', () => {
    if(st) st.classList.toggle('show', window.scrollY > 400);
    const hdr = document.getElementById('hdr');
    if(hdr) hdr.style.boxShadow = window.scrollY > 50 ? '0 4px 28px rgba(26,58,140,.18)' : '0 2px 20px rgba(26,58,140,.1)';
    if(hdr) {
        if(window.scrollY > 40) hdr.classList.add('sticky');
        else hdr.classList.remove('sticky');
    }
  });
  if(st) st.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const href = a.getAttribute('href');
      if(href === '#') return;
      const t = document.querySelector(href);
      if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth' }); }
    });
  });
</script>

<!-- Enquiry Modal -->
<div id="enquiryModal" class="modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:9999;align-items:center;justify-content:center;padding:20px;">
  <div class="modal-box" style="background:#fff;width:100%;max-width:500px;border-radius:12px;padding:30px;position:relative;box-shadow:0 10px 40px rgba(0,0,0,0.2);">
    <button onclick="document.getElementById('enquiryModal').style.display='none'" style="position:absolute;top:15px;right:20px;background:transparent;border:none;font-size:1.5rem;cursor:pointer;color:#555;">&times;</button>
    <h3 style="margin-bottom:20px;color:#0d2463;">Course Enquiry</h3>
    <form id="modalForm" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
      <input type="hidden" name="action" value="scgi_course_enquiry">
      <?php wp_nonce_field( 'scgi_form_submit', 'enquiry_nonce' ); ?>
      <div style="margin-bottom:15px;">
        <label style="display:block;font-size:.85rem;font-weight:600;color:var(--blue-dark);margin-bottom:6px;">Select Category</label>
        <select id="modalCategory" name="category" class="modal-input" required>
          <option value="">Select Course Category</option>
          <option value="Nursing">Nursing</option>
          <option value="Physiotherapy">Physiotherapy</option>
          <option value="Allied Health Science">Allied Health Science</option>
        </select>
      </div>
      <div style="margin-bottom:15px;">
        <label style="display:block;font-size:.85rem;font-weight:600;color:var(--blue-dark);margin-bottom:6px;">Select Course</label>
        <select id="modalCourse" name="course" class="modal-input" required>
          <option value="">Select Course Details</option>
        </select>
      </div>
      <div style="margin-bottom:15px;">
        <label style="display:block;font-size:.85rem;font-weight:600;color:var(--blue-dark);margin-bottom:6px;">Select State</label>
        <select id="modalState" name="state" class="modal-input" required>
          <option value="">Select State</option>
          <option>Karnataka</option><option>Kerala</option><option>Tamil Nadu</option>
          <option>Andhra Pradesh</option><option>Maharashtra</option><option>Other</option>
        </select>
      </div>
      <div style="margin-bottom:20px;">
        <label style="display:block;font-size:.85rem;font-weight:600;color:var(--blue-dark);margin-bottom:6px;">Enter City</label>
        <input type="text" id="modalCity" name="city" class="hero-input" placeholder="Enter City" style="width:100%;padding:12px;border:1px solid #ccc;border-radius:6px;background:#f9f9f9;outline:none;" required>
      </div>
      <button type="submit" class="btn-gold hero-submit">Submit Enquiry</button>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const enqButtons = document.querySelectorAll('a[href="#enquire"], .btn-enq, .btn-hero-enq');
    enqButtons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('enquiryModal').style.display = 'flex';
        autoPopulateModal();
      });
    });

    const coursesMap = {
      "Nursing": ["General Nursing and Midwifery (GNM)", "Basic B.Sc Nursing", "Post Basic B.Sc Nursing (P.B B.Sc Nursing)", "M.Sc Nursing"],
      "Physiotherapy": ["Bachelor of Physiotherapy (BPT)"],
      "Allied Health Science": ["Anaesthesia & Operation Theatre Technology (B.Sc AT & OTT)", "Medical Laboratory Technology (B.Sc MLT)", "Medical Laboratory Technology (DMLT)", "Operation Theatre Technology (DOTT)", "Health Inspector (DHI)"]
    };

    function populateCourses(catDropdown, courseDropdown, selectedCourse = "") {
      const cat = catDropdown.value;
      if(!courseDropdown) return;
      courseDropdown.innerHTML = '<option value="">Select Course Details</option>';
      if(coursesMap[cat]) {
        coursesMap[cat].forEach(c => {
          let opt = document.createElement('option');
          opt.value = c;
          opt.textContent = c;
          if (c === selectedCourse) opt.selected = true;
          courseDropdown.appendChild(opt);
        });
      }
    }

    function autoPopulateModal() {
      const path = window.location.pathname;
      const modalCat = document.getElementById('modalCategory');
      const modalCourse = document.getElementById('modalCourse');
      if(!modalCat || !modalCourse) return;
      
      let preCat = "";
      let preCourse = "";

      if(path.includes('nursing-gnm')) { preCat = "Nursing"; preCourse = "General Nursing and Midwifery (GNM)"; }
      else if(path.includes('nursing-bsc')) { preCat = "Nursing"; preCourse = "Basic B.Sc Nursing"; }
      else if(path.includes('nursing-pbbsc')) { preCat = "Nursing"; preCourse = "Post Basic B.Sc Nursing (P.B B.Sc Nursing)"; }
      else if(path.includes('nursing-msc')) { preCat = "Nursing"; preCourse = "M.Sc Nursing"; }
      else if(path.includes('nursing')) { preCat = "Nursing"; }
      else if(path.includes('physiotherapy-bpt')) { preCat = "Physiotherapy"; preCourse = "Bachelor of Physiotherapy (BPT)"; }
      else if(path.includes('physiotherapy')) { preCat = "Physiotherapy"; }
      else if(path.includes('allied-bmlt')) { preCat = "Allied Health Science"; preCourse = "Medical Laboratory Technology (B.Sc MLT)"; }
      else if(path.includes('allied-atott')) { preCat = "Allied Health Science"; preCourse = "Anaesthesia & Operation Theatre Technology (B.Sc AT & OTT)"; }
      else if(path.includes('allied-dmlt')) { preCat = "Allied Health Science"; preCourse = "Medical Laboratory Technology (DMLT)"; }
      else if(path.includes('allied-dott')) { preCat = "Allied Health Science"; preCourse = "Operation Theatre Technology (DOTT)"; }
      else if(path.includes('allied-dhi')) { preCat = "Allied Health Science"; preCourse = "Health Inspector (DHI)"; }
      else if(path.includes('allied')) { preCat = "Allied Health Science"; }

      if(preCat) {
        modalCat.value = preCat;
        populateCourses(modalCat, modalCourse, preCourse);
      }
    }

    const modalCat = document.getElementById('modalCategory');
    if(modalCat) {
      modalCat.addEventListener('change', () => {
        populateCourses(modalCat, document.getElementById('modalCourse'));
      });
    }

    const heroCat = document.getElementById('heroCategory');
    if(heroCat) {
      heroCat.addEventListener('change', () => {
        populateCourses(heroCat, document.getElementById('heroCourse'));
      });
    }

    const slides = document.querySelectorAll('.hero-slider .slide');
    const dots = document.querySelectorAll('.hero-dot');
    let currentSlideIndex = 0;
    let slideInterval;

    function showHeroSlide(index) {
      if(slides.length === 0) return;
      slides[currentSlideIndex].classList.remove('active');
      if(dots.length > 0) dots[currentSlideIndex].classList.remove('active');
      currentSlideIndex = (index + slides.length) % slides.length;
      slides[currentSlideIndex].classList.add('active');
      if(dots.length > 0) dots[currentSlideIndex].classList.add('active');
    }

    function startSlideTimer() {
      slideInterval = setInterval(() => {
        showHeroSlide(currentSlideIndex + 1);
      }, 4000);
    }

    dots.forEach((dot, idx) => {
      dot.addEventListener('click', () => {
        clearInterval(slideInterval);
        showHeroSlide(idx);
        startSlideTimer();
      });
    });

    if(slides.length > 0) startSlideTimer();

    const sliderPos = { nursing: 0, allied: 0, physio: 0 };
    window.moveSlider = function(category, direction) {
      const grid = document.getElementById('grid-' + category);
      if(!grid) return;
      const track = grid.parentElement;
      const card = grid.children[0];
      if(!card) return;
      
      const gap = window.innerWidth <= 768 ? 15 : 30;
      const cardWidth = card.offsetWidth + gap; 
      
      if (window.innerWidth <= 768) {
        const currentScroll = track.scrollLeft;
        const maxScroll = track.scrollWidth - track.clientWidth;
        let newScroll = currentScroll + (direction * cardWidth);
        if (newScroll < 0) newScroll = 0;
        if (newScroll > maxScroll) newScroll = maxScroll;
        track.scrollTo({ left: newScroll, behavior: 'smooth' });
      } else {
        const containerWidth = track.offsetWidth;
        const totalCards = grid.children.length;
        const visibleCount = Math.floor(containerWidth / cardWidth) || 1;
        const maxPos = Math.max(0, totalCards - visibleCount);
        sliderPos[category] += direction;
        if (sliderPos[category] < 0) sliderPos[category] = 0;
        if (sliderPos[category] > maxPos) sliderPos[category] = maxPos;
        grid.style.transform = `translateX(-${sliderPos[category] * cardWidth}px)`;
      }
    }
  });
</script>

<?php wp_footer(); ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/main.js"></script>
</body>
</html>
