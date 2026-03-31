document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('hdr');
    const hbg = document.getElementById('hbg');
    const navMenu = document.getElementById('navMenu');
    const st = document.getElementById('st');

    // Mobile nav toggle
    if (hbg) {
        hbg.addEventListener('click', (e) => {
            e.stopPropagation();
            let nMenu = document.getElementById('navMenu') || document.querySelector('nav ul');
            if(nMenu) nMenu.classList.toggle('open');
            hbg.classList.toggle('active');
        });
    }

    // ── AUTO ACTIVE NAV ──
    (function setActiveNav() {
        const page = window.location.pathname.split('/').pop() || 'index.html';
        const coursePages = [
            'nursing.html','allied.html','physiotherapy.html',
            'nursing-gnm.html','nursing-bsc.html','nursing-pbbsc.html','nursing-msc.html',
            'allied-atott.html','allied-bmlt.html','allied-dmlt.html','allied-dott.html','allied-dhi.html',
            'physiotherapy-bpt.html'
        ];

        // Remove active from all nav links
        document.querySelectorAll('nav a').forEach(a => a.classList.remove('active'));

        if (coursePages.includes(page)) {
            // Highlight the "Courses" dropdown trigger
            document.querySelectorAll('nav a').forEach(a => {
                if (a.textContent.trim().startsWith('Courses')) a.classList.add('active');
            });
        } else {
            // Match by checking if the link's href filename matches current page
            document.querySelectorAll('nav a').forEach(a => {
                const href = (a.getAttribute('href') || '').split('/').pop().split('#')[0];
                if (href && href === page) a.classList.add('active');
            });
        }
    })();

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

    // ── FEW-CARDS SLIDER: hide arrows + center when < 3 cards on desktop ──
    function updateSliderArrows() {
        if (window.innerWidth <= 768) return; // mobile handled separately
        document.querySelectorAll('.courses-slider-container').forEach(container => {
            const grid = container.querySelector('.courses-grid');
            if (!grid) return;
            const cardCount = grid.children.length;
            if (cardCount < 3) {
                container.classList.add('cards-few');
            } else {
                container.classList.remove('cards-few');
            }
        });
    }
    // Run on load and whenever tabs switch
    updateSliderArrows();
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => setTimeout(updateSliderArrows, 50));
    });
    window.addEventListener('resize', updateSliderArrows);

    
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

    // ═══ CUSTOM DROPDOWN (csd) LOGIC ═══
    const coursesMap = {
        "Nursing": ["General Nursing and Midwifery (GNM)", "Basic B.Sc Nursing", "Post Basic B.Sc Nursing (P.B B.Sc Nursing)", "M.Sc Nursing"],
        "Physiotherapy": ["Bachelor of Physiotherapy (BPT)"],
        "Allied Health Science": ["Anaesthesia & Operation Theatre Technology (B.Sc AT & OTT)", "Medical Laboratory Technology (B.Sc MLT)", "Medical Laboratory Technology (DMLT)", "Operation Theatre Technology (DOTT)", "Health Inspector (DHI)"]
    };

    function initCsd(csdEl, hiddenInputId, onSelect) {
        if (!csdEl) return;
        const trigger = csdEl.querySelector('.csd-trigger');
        const list    = csdEl.querySelector('.csd-list');
        const label   = csdEl.querySelector('.csd-label');
        const hidden  = hiddenInputId ? document.getElementById(hiddenInputId) : null;

        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            // Close all other open csds
            document.querySelectorAll('.csd.open').forEach(el => { if (el !== csdEl) el.classList.remove('open'); });
            csdEl.classList.toggle('open');
        });

        if (list) {
            list.querySelectorAll('li').forEach(li => {
                li.addEventListener('click', () => {
                    const val  = li.getAttribute('data-value');
                    const text = li.textContent;
                    label.textContent = text;
                    csdEl.setAttribute('data-value', val);
                    csdEl.classList.add('has-value');
                    csdEl.classList.remove('open');
                    if (hidden) hidden.value = val;
                    list.querySelectorAll('li').forEach(l => l.classList.remove('selected'));
                    li.classList.add('selected');
                    if (onSelect) onSelect(val);
                });
            });
        }
    }

    // Populate course list dynamically
    function populateHeroCourseList(category) {
        const courseList = document.getElementById('csd-course-list');
        const courseCsd  = document.getElementById('csd-course');
        const courseLbl  = courseCsd ? courseCsd.querySelector('.csd-label') : null;
        const hidCourse  = document.getElementById('heroCourse');
        if (!courseList) return;
        courseList.innerHTML = '';
        if (coursesMap[category]) {
            coursesMap[category].forEach(c => {
                const li = document.createElement('li');
                li.setAttribute('data-value', c);
                li.textContent = c;
                li.addEventListener('click', () => {
                    if (courseLbl) courseLbl.textContent = c;
                    courseCsd.setAttribute('data-value', c);
                    courseCsd.classList.add('has-value');
                    courseCsd.classList.remove('open');
                    if (hidCourse) hidCourse.value = c;
                    courseList.querySelectorAll('li').forEach(l => l.classList.remove('selected'));
                    li.classList.add('selected');
                });
                courseList.appendChild(li);
            });
        }
        // Reset course selection
        if (courseLbl) courseLbl.textContent = 'Select Course Details';
        if (courseCsd) { courseCsd.removeAttribute('data-value'); courseCsd.classList.remove('has-value'); }
        if (hidCourse) hidCourse.value = '';
    }

    // Init all hero form csds
    initCsd(document.getElementById('csd-category'), 'heroCategory', (val) => { populateHeroCourseList(val); });
    initCsd(document.getElementById('csd-course'), 'heroCourse', null);
    initCsd(document.getElementById('csd-state'), 'heroState', null);

    // Close on outside click
    document.addEventListener('click', () => {
        document.querySelectorAll('.csd.open').forEach(el => el.classList.remove('open'));
    });

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

    // Toggle sub-submenus on mobile (only if clicking the chevron icon)
    document.querySelectorAll('.dropdown-submenu > a').forEach(link => {
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 991 && e.target.tagName.toLowerCase() === 'i') {
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
