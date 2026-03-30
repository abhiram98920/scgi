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
        if (header) header.classList.toggle('sticky', scrolled);
        if (st) {
            st.classList.toggle('show', window.pageYOffset > 400);
            st.style.display = (window.pageYOffset > 400) ? 'flex' : 'none';
        }
    });

    if (st) {
        st.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

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

    // Dropdown handling for mobile
    document.querySelectorAll('.dropdown > a').forEach(link => {
        link.addEventListener('click', (e) => {
            if (window.innerWidth <= 991) {
                e.preventDefault();
                link.parentElement.classList.toggle('open');
            }
        });
    });
});
