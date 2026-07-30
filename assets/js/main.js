// Interactive Client Logic for Rithamaya Website

// Hero Banner Slider Logic
let slideIndex = 0;
let slideTimer = null;

function showSlides(n) {
    const heroSection = document.querySelector('.hero-section');
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.dot');
    
    if (slides.length === 0) return;
    
    if (n >= slides.length) slideIndex = 0;
    if (n < 0) slideIndex = slides.length - 1;
    
    slides.forEach(slide => {
        slide.classList.remove('active');
        slide.style.display = 'none';
    });
    
    dots.forEach(dot => dot.classList.remove('active'));
    
    const activeSlide = slides[slideIndex];
    activeSlide.style.display = 'block';
    void activeSlide.offsetWidth;
    activeSlide.classList.add('active');
    
    if (dots[slideIndex]) {
        dots[slideIndex].classList.add('active');
    }

    if (heroSection) {
        heroSection.classList.remove('hero-slide-honey', 'hero-slide-green', 'hero-slide-coral', 'hero-slide-amber');
        const theme = activeSlide.getAttribute('data-theme');
        if (theme) {
            heroSection.classList.add(theme);
        }
    }
}

function moveSlide(n) {
    slideIndex += n;
    showSlides(slideIndex);
    resetTimer();
}

function currentSlide(n) {
    slideIndex = n;
    showSlides(slideIndex);
    resetTimer();
}

function resetTimer() {
    clearInterval(slideTimer);
    slideTimer = setInterval(() => {
        slideIndex++;
        showSlides(slideIndex);
    }, 2000);
}

document.addEventListener('DOMContentLoaded', () => {
    // Start hero slider if present - 100% Automatic 2-Second Moving Slider
    const slides = document.querySelectorAll('.hero-slide');
    if (slides.length > 0) {
        showSlides(slideIndex);
        resetTimer();
    }

    // Mobile Navigation Menu Toggle
    const mobileToggle = document.querySelector('.mobile-toggle');
    const navMenu = document.querySelector('.nav-menu');

    if (mobileToggle && navMenu) {
        mobileToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            if (navMenu.classList.contains('active')) {
                navMenu.style.display = 'flex';
                navMenu.style.flexDirection = 'column';
                navMenu.style.position = 'absolute';
                navMenu.style.top = '100%';
                navMenu.style.left = '0';
                navMenu.style.right = '0';
                navMenu.style.background = '#ffffff';
                navMenu.style.padding = '20px';
                navMenu.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
            } else {
                navMenu.style.display = '';
            }
        });
    }

    // Auto-dismiss Alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Category Filter Buttons on Shop Page
    const catChips = document.querySelectorAll('.cat-chip');
    const productCards = document.querySelectorAll('.product-card');

    if (catChips.length > 0 && productCards.length > 0) {
        catChips.forEach(chip => {
            chip.addEventListener('click', (e) => {
                const category = chip.getAttribute('data-category');
                
                catChips.forEach(c => c.classList.remove('active'));
                chip.classList.add('active');

                productCards.forEach(card => {
                    const cardCat = card.getAttribute('data-category');
                    if (category === 'all' || cardCat === category) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    }
});

// Quantity Incrementation
function updateQty(btn, change) {
    const input = btn.parentNode.querySelector('.qty-input');
    if (input) {
        let val = parseInt(input.value) + change;
        if (val < 1) val = 1;
        input.value = val;
    }
}

// Promotional Offer Popup Logic
function closePromoModal() {
    const modal = document.getElementById('promoModal');
    if (modal) {
        modal.classList.remove('active');
        sessionStorage.setItem('promo_closed', 'true');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Show promo modal after 1.2 seconds if not closed in current session
    const modal = document.getElementById('promoModal');
    if (modal && !sessionStorage.getItem('promo_closed')) {
        setTimeout(() => {
            modal.classList.add('active');
        }, 1200);

        // Close on clicking backdrop
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closePromoModal();
            }
        });
    }
});
