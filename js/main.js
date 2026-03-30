document.addEventListener('DOMContentLoaded', () => {
    const header = document.querySelector('header');
    const st = document.getElementById('st');

    // Scroll Logic
    window.addEventListener('scroll', () => {
        if (st) st.style.display = (window.pageYOffset > 500) ? 'flex' : 'none';
        header.classList.toggle('sticky', window.pageYOffset > 50);
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

    const revealElements = document.querySelectorAll('.reveal');
    revealElements.forEach(el => revealObserver.observe(el));
});
