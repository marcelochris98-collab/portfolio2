document.addEventListener('DOMContentLoaded', () => {
    // 0. Bascule Mode Sombre / Mode Clair (avec sauvegarde localStorage)
    const themeToggle = document.getElementById('themeToggle');
    const rootHtml = document.documentElement;

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const currentTheme = rootHtml.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
            const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
            rootHtml.setAttribute('data-theme', nextTheme);
            try {
                localStorage.setItem('portfolio_theme', nextTheme);
            } catch (e) {
                // Ignorer si localStorage est bloqué
            }
        });
    }

    // 1. Navigation mobile (Hamburger)
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');
    const siteHeader = document.getElementById('siteHeader');
    const backToTop = document.getElementById('backToTop');

    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            const isOpen = navMenu.classList.toggle('active');
            hamburger.classList.toggle('active', isOpen);
            hamburger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        document.querySelectorAll('.nav-menu a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', 'false');
            });
        });

        document.addEventListener('click', (e) => {
            if (!navMenu.contains(e.target) && !hamburger.contains(e.target)) {
                navMenu.classList.remove('active');
                hamburger.classList.remove('active');
                hamburger.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // 2. Effet au scroll sur le Header & bouton Retour en haut
    const handleScroll = () => {
        const scrollY = window.scrollY;
        if (siteHeader) {
            siteHeader.classList.toggle('scrolled', scrollY > 24);
        }
        if (backToTop) {
            backToTop.classList.toggle('visible', scrollY > 360);
        }
    };

    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();

    if (backToTop) {
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }

    // 3. Système d'animation au scroll (IntersectionObserver)
    const revealElements = document.querySelectorAll('[data-reveal]');
    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const delay = parseInt(el.getAttribute('data-delay') || '0', 10);
                    setTimeout(() => {
                        el.classList.add('revealed');
                    }, delay);
                    obs.unobserve(el);
                }
            });
        }, {
            threshold: 0.12,
            rootMargin: '0px 0px -40px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));
    } else {
        revealElements.forEach(el => el.classList.add('revealed'));
    }

    // 4. Compteurs animés pour les statistiques
    const counters = document.querySelectorAll('.counter[data-target]');
    const animateCounter = (el) => {
        const target = parseInt(el.getAttribute('data-target') || '0', 10);
        if (!target) return;
        const duration = 1300;
        const startTime = performance.now();

        const step = (now) => {
            const progress = Math.min((now - startTime) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target);
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = target;
            }
        };
        requestAnimationFrame(step);
    };

    if ('IntersectionObserver' in window && counters.length > 0) {
        const counterObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });

        counters.forEach(c => counterObserver.observe(c));
    }

    // 5. Filtrage interactif des projets sur la page Portfolio
    const filterButtons = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('#portfolioGrid .portfolio-item');

    if (filterButtons.length > 0 && portfolioItems.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                const filter = btn.getAttribute('data-filter');
                portfolioItems.forEach(item => {
                    const category = item.getAttribute('data-category');
                    if (filter === 'all' || category === filter) {
                        item.classList.remove('is-hidden');
                        requestAnimationFrame(() => {
                            item.classList.add('revealed');
                        });
                    } else {
                        item.classList.add('is-hidden');
                    }
                });
            });
        });
    }

    // 6. Modal de détails des projets
    const projectModal = document.getElementById('projectModal');
    const modalBackdrop = document.getElementById('modalBackdrop');
    const modalClose = document.getElementById('modalClose');
    const openModalBtns = document.querySelectorAll('.open-project-modal');

    if (projectModal && openModalBtns.length > 0) {
        const modalImg = document.getElementById('modalImg');
        const modalCategory = document.getElementById('modalCategory');
        const modalLocation = document.getElementById('modalLocation');
        const modalYear = document.getElementById('modalYear');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const modalMetrics = document.getElementById('modalMetrics');
        const modalTechs = document.getElementById('modalTechs');
        const modalLink = document.getElementById('modalLink');

        const closeModal = () => {
            projectModal.classList.remove('active');
            projectModal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        openModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const title = btn.getAttribute('data-title') || '';
                const category = btn.getAttribute('data-category') || '';
                const location = btn.getAttribute('data-location') || 'Cameroun';
                const year = btn.getAttribute('data-year') || '2025';
                const desc = btn.getAttribute('data-desc') || '';
                const metrics = btn.getAttribute('data-metrics') || '';
                const techs = (btn.getAttribute('data-techs') || '').split(',');
                const img = btn.getAttribute('data-img') || '';

                if (modalImg) {
                    modalImg.src = img;
                    modalImg.alt = title;
                }
                if (modalCategory) modalCategory.textContent = category;
                if (modalLocation) modalLocation.innerHTML = `<i class="fas fa-location-dot"></i> ${location}`;
                if (modalYear) modalYear.innerHTML = `<i class="fas fa-calendar"></i> ${year}`;
                if (modalTitle) modalTitle.textContent = title;
                if (modalDesc) modalDesc.textContent = desc;
                if (modalMetrics) modalMetrics.textContent = metrics;

                if (modalTechs) {
                    modalTechs.innerHTML = '';
                    techs.forEach(t => {
                        const cleanTech = t.trim();
                        if (cleanTech) {
                            const span = document.createElement('span');
                            span.className = 'tech-tag';
                            span.textContent = cleanTech;
                            modalTechs.appendChild(span);
                        }
                    });
                }

                if (modalLink) {
                    modalLink.href = `contact.php?subject=${encodeURIComponent('Étude : ' + title)}`;
                }

                projectModal.classList.add('active');
                projectModal.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            });
        });

        if (modalClose) modalClose.addEventListener('click', closeModal);
        if (modalBackdrop) modalBackdrop.addEventListener('click', closeModal);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && projectModal.classList.contains('active')) {
                closeModal();
            }
        });
    }
});
