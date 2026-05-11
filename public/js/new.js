// same js but with functions calling one by one in one DOMContentLoaded
document.addEventListener("DOMContentLoaded", function () {

    initNavbarScroll();
    initBackToTop();
    initHeroSlider();
    initProductQty();
    initAddToCart();
    initCartUpdate();
    initCounters();
    initAutoHideAlert();

});


// ===============================
// 1. NAVBAR SCROLL EFFECT
// ===============================
function initNavbarScroll() {

    const navbar = document.getElementById('mainNavbar');

    if (!navbar) return;

    window.addEventListener('scroll', function () {

        navbar.classList.toggle('scrolled', window.scrollY > 100);

    });
}


// ===============================
// 2. BACK TO TOP BUTTON
// ===============================
function initBackToTop() {

    const btn = document.getElementById("cont-backToTopBtn");

    if (!btn) return;

    window.addEventListener("scroll", function () {

        btn.classList.toggle("show", window.scrollY > 300);

    });

    btn.addEventListener("click", function () {

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });

    });
}


// ===============================
// 3. HERO SLIDER (OWL)
// ===============================
function initHeroSlider() {

    if ($(".hero-slider .owl-carousel").length) {

        $(".hero-slider .owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            nav: true,
            dots: false,
            navText: ["‹", "›"],
            responsive: {
                0: { items: 1 },
                768: { items: 1 },
                1000: { items: 1 }
            }
        });

    }
}


// ===============================
// 4. PRODUCT QUANTITY
// ===============================
function initProductQty() {

    const plus = document.querySelector('.qty-plus');
    const minus = document.querySelector('.qty-minus');
    const input = document.querySelector('.qty-input');

    if (!plus || !minus || !input) return;

    plus.addEventListener('click', () => {
        input.value = (parseInt(input.value) || 1) + 1;
    });

    minus.addEventListener('click', () => {
        let val = parseInt(input.value) || 1;
        if (val > 1) input.value = val - 1;
    });
}


// ===============================
// 5. ADD TO CART
// ===============================
function initAddToCart() {
    // we did not put it in meta but define it in script in app.blade.php
    // const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const csrfToken = window.Laravel.csrfToken;
    if (!csrfToken) return;

    document.querySelectorAll('.add-to-cart').forEach(btn => {

        btn.addEventListener('click', function (e) {

            e.preventDefault();

            let id = this.dataset.id;

            fetch('/add-to-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ id })
            })
                .then(res => res.json())
                .then(data => {

                    let cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.innerText = data.count;
                    }

                    let toastEl = document.getElementById('cartToast');
                    if (toastEl) {
                        let toast = new bootstrap.Toast(toastEl, { delay: 3000 });
                        toast.show();
                    }

                });

        });

    });
}


// ===============================
// 6. CART UPDATE / REMOVE
// ===============================
function initCartUpdate() {
    // we did not put it in meta but define it in script in app.blade.php
    // const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const csrfToken = window.Laravel.csrfToken;
    if (!csrfToken) return;

    document.addEventListener('click', function (e) {

        // QUANTITY UPDATE
        if (e.target.classList.contains('plus') || e.target.classList.contains('minus')) {

            let id = e.target.dataset.id;
            let input = document.querySelector(`.qty[data-id='${id}']`);

            if (!input) return;

            let qty = parseInt(input.value) || 1;

            qty = e.target.classList.contains('plus') ? qty + 1 : Math.max(1, qty - 1);

            input.value = qty;

            fetch('/update-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ id, qty })
            });
        }

        // REMOVE ITEM
        if (e.target.classList.contains('remove')) {

            let id = e.target.dataset.id;

            fetch('/remove-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ id })
            })
                .then(() => location.reload());
        }

    });
}


// ===============================
// 7. COUNTER ANIMATION
// ===============================
function initCounters() {

    const counters = document.querySelectorAll('.abt-counter');

    if (!counters.length) return;

    const runCounter = (counter) => {

        const target = +counter.getAttribute('data-count');
        let count = 0;
        const speed = target / 100;

        const update = () => {

            count += speed;

            if (count < target) {

                counter.innerText = target >= 1000
                    ? Math.floor(count).toLocaleString()
                    : Math.floor(count);

                requestAnimationFrame(update);

            } else {

                counter.innerText = target.toLocaleString();
            }
        };

        update();
    };

    const observer = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {
                runCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });

    }, { threshold: 0.5 });

    counters.forEach(counter => observer.observe(counter));
}


// ===================================
// 8. AUTO DISAPPEAR ORDER SUCCESS MSG
// ===================================
function initAutoHideAlert() {

    const alert = document.querySelector('.cont-auto-hide-alert');

    if (!alert) return;

    setTimeout(() => {

        alert.classList.remove('show');
        alert.classList.add('hide');

        setTimeout(() => {
            alert.remove();
        }, 500);

    }, 3000);
}