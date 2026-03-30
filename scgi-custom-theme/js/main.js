document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('hdr');
    const hbg = document.getElementById('hbg');
    const navMenu = document.getElementById('navMenu');
    const st = document.getElementById('st');

    // Mobile nav toggle
    if (hbg && navMenu) {
        hbg.addEventListener('click', () => {
            navMenu.classList.toggle('open');
            hbg.classList.toggle('active');
        });
    }

    // Scroll Logic (Sticky Header & Back to top)
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset > 50;
        if (header) {
            header.classList.toggle('sticky', scrolled);
            header.style.boxShadow = scrolled ? '0 4px 28px rgba(26,58,140,.18)' : '0 2px 20px rgba(26,58,140,.1)';
        }
        if (st) {
            st.classList.toggle('show', window.pageYOffset > 400);
        }
    });

    if (st) {
        st.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', e => {
            const href = a.getAttribute('href');
            if (href === '#') return;
            const t = document.querySelector(href);
            if (t) {
                e.preventDefault();
                t.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // REVEAL ON SCROLL
    const revealOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, revealOptions);

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
    
    // COUNTER ANIMATION
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.getAttribute('data-target'));
                let current = 0;
                const duration = 2000; // 2 seconds
                const increment = Math.ceil(target / (duration / 16)); // ~60fps
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        el.innerText = target;
                        clearInterval(timer);
                    } else {
                        el.innerText = current;
                    }
                }, 16);
                counterObserver.unobserve(el);
            }
        });
    }, { threshold: 0.3, rootMargin: '0px 0px -20px 0px' });

    document.querySelectorAll('.counter').forEach(c => counterObserver.observe(c));

    // Enquiry Modal Logic
    const enqButtons = document.querySelectorAll('a[href="#enquire"], .btn-enq, .btn-hero-enq');
    const modal = document.getElementById('enquiryModal');
    
    if (modal) {
        enqButtons.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                modal.style.display = 'flex';
                autoPopulateModal();
            });
        });
    }

    const coursesMap = {
        "Nursing": ["General Nursing and Midwifery (GNM)", "Basic B.Sc Nursing", "Post Basic B.Sc Nursing (P.B B.Sc Nursing)", "M.Sc Nursing"],
        "Physiotherapy": ["Bachelor of Physiotherapy (BPT)"],
        "Allied Health Science": ["Anaesthesia & Operation Theatre Technology (B.Sc AT & OTT)", "Medical Laboratory Technology (B.Sc MLT)", "Medical Laboratory Technology (DMLT)", "Operation Theatre Technology (DOTT)", "Health Inspector (DHI)"]
    };

    function populateCourses(catDropdown, courseDropdown, selectedCourse = "") {
        const cat = catDropdown.value;
        if (!courseDropdown) return;
        courseDropdown.innerHTML = '<option value="">Select Course Details</option>';
        if (coursesMap[cat]) {
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
        if (!modalCat || !modalCourse) return;
        
        let preCat = "";
        let preCourse = "";

        if (path.includes('nursing-gnm')) { preCat = "Nursing"; preCourse = "General Nursing and Midwifery (GNM)"; }
        else if (path.includes('nursing-bsc')) { preCat = "Nursing"; preCourse = "Basic B.Sc Nursing"; }
        else if (path.includes('nursing-pbbsc')) { preCat = "Nursing"; preCourse = "Post Basic B.Sc Nursing (P.B B.Sc Nursing)"; }
        else if (path.includes('nursing-msc')) { preCat = "Nursing"; preCourse = "M.Sc Nursing"; }
        else if (path.includes('nursing')) { preCat = "Nursing"; }
        else if (path.includes('physiotherapy-bpt')) { preCat = "Physiotherapy"; preCourse = "Bachelor of Physiotherapy (BPT)"; }
        else if (path.includes('physiotherapy')) { preCat = "Physiotherapy"; }
        else if (path.includes('allied-bmlt')) { preCat = "Allied Health Science"; preCourse = "Medical Laboratory Technology (B.Sc MLT)"; }
        else if (path.includes('allied-atott')) { preCat = "Allied Health Science"; preCourse = "Anaesthesia & Operation Theatre Technology (B.Sc AT & OTT)"; }
        else if (path.includes('allied-dmlt')) { preCat = "Allied Health Science"; preCourse = "Medical Laboratory Technology (DMLT)"; }
        else if (path.includes('allied-dott')) { preCat = "Allied Health Science"; preCourse = "Operation Theatre Technology (DOTT)"; }
        else if (path.includes('allied-dhi')) { preCat = "Allied Health Science"; preCourse = "Health Inspector (DHI)"; }
        else if (path.includes('allied')) { preCat = "Allied Health Science"; }

        if (preCat) {
            modalCat.value = preCat;
            populateCourses(modalCat, modalCourse, preCourse);
        }
    }

    const modalCat = document.getElementById('modalCategory');
    if (modalCat) {
        modalCat.addEventListener('change', () => {
            populateCourses(modalCat, document.getElementById('modalCourse'));
        });
    }

    // Course Slider Logic
    const sliderPos = { nursing: 0, allied: 0, physio: 0 };
    window.moveSlider = function(category, direction) {
        const grid = document.getElementById('grid-' + category);
        if (!grid) return;
        const track = grid.parentElement;
        const card = grid.children[0];
        if (!card) return;
        
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

    // Toggle sub-submenus on mobile
    document.querySelectorAll('.dropdown-submenu > a').forEach(link => {
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 991) {
                e.preventDefault();
                e.stopPropagation();
                link.parentElement.classList.toggle('open');
            }
        });
    });

    // Fix for 1st level dropdown on mobile
    document.querySelectorAll('.dropdown > a').forEach(link => {
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 991) {
                e.preventDefault();
                link.parentElement.classList.toggle('open');
            }
        });
    });
});
