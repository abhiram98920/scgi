jQuery(document).ready(function($) {
    // Mobile nav toggle
    $('#hbg').on('click', function() {
        $('#navMenu').toggleClass('open');
    });

    // Sticky header
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 40) {
            $('#hdr').addClass('sticky');
        } else {
            $('#hdr').removeClass('sticky');
        }
    });

    // Back to top
    const st = $('#st');
    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 400) {
            st.addClass('show');
        } else {
            st.removeClass('show');
        }
    });
    st.on('click', function() {
        $('html, body').animate({ scrollTop: 0 }, 'smooth');
    });

    // Open enquiry modal
    $(document).on('click', 'a[href="#enquire"], .btn-enq, .btn-hero-enq', function(e) {
        e.preventDefault();
        $('#enquiryModal').css('display', 'flex');
    });

    // AJAX: Dynamic Course Dropdown
    $('#modalCategory, #heroCategory').on('change', function() {
        const cat = $(this).val();
        const target = $(this).attr('id') === 'modalCategory' ? $('#modalCourse') : $('#heroCourse');
        
        target.html('<option value="">Loading...</option>');
        
        $.ajax({
            url: scgi_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'scgi_fetch_courses',
                category: cat,
                security: scgi_ajax.nonce
            },
            success: function(response) {
                const courses = JSON.parse(response);
                let html = '<option value="">Select Course Details</option>';
                courses.forEach(c => {
                    html += `<option value="${c}">${c}</option>`;
                });
                target.html(html);
            }
        });
    });

    // Hero Slider
    const slides = $('.hero-slider .slide');
    const dots = $('.hero-dot');
    let currentSlideIndex = 0;
    let slideInterval;

    function showHeroSlide(index) {
        if (slides.length === 0) return;
        slides.eq(currentSlideIndex).removeClass('active');
        dots.eq(currentSlideIndex).removeClass('active');
        currentSlideIndex = (index + slides.length) % slides.length;
        slides.eq(currentSlideIndex).addClass('active');
        dots.eq(currentSlideIndex).addClass('active');
    }

    function startSlideTimer() {
        slideInterval = setInterval(() => {
            showHeroSlide(currentSlideIndex + 1);
        }, 4000);
    }

    dots.each(function(idx) {
        $(this).on('click', function() {
            clearInterval(slideInterval);
            showHeroSlide(idx);
            startSlideTimer();
        });
    });

    if (slides.length > 0) startSlideTimer();

    // Course Gallery Filter (if applicable)
    $('.course-tab-btn').on('click', function() {
        $('.course-tab-btn').removeClass('active');
        $(this).addClass('active');
        const target = $(this).data('target');
        $('.tab-panel').removeClass('active');
        $(target).addClass('active');
    });
});
