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
    initProductFilter();
    initLiveSearch();
    initReviewSystem();
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










// ===================================
// 9. PRODUCTS FILTER
// ===================================

// function initProductFilter() {

//     const filter = document.getElementById('productFilter');
//     const container = document.getElementById('productContainer');

//     if (!filter || !container) return;

//     filter.addEventListener('change', function () {

//         let sort = this.value;

//         fetch(`/products/filter?sort=${sort}`)
//             .then(res => res.text())
//             .then(html => {
//                 container.innerHTML = html;

//                 // re-bind add-to-cart after reload
//                 initAddToCart();
//             });
//     });
// }

// with animation
/* ***
While filtering:

✔ Skeleton loading appears instantly
✔ No blank white screen

After response:

✔ Products fade in smoothly
✔ Clean modern transition
✔ Feels like Amazon / Flipkart

*****/
function initProductFilter() {

    const filter = document.getElementById('productFilter');
    const container = document.getElementById('productContainer');
    const skeleton = document.getElementById('productSkeleton');

    if (!filter || !container) return;

    filter.addEventListener('change', function () {

        let sort = this.value;

        // SHOW SKELETON
        container.style.display = "none";
        skeleton.style.display = "flex";

        fetch(`/products/filter?sort=${sort}`)
            .then(res => res.text())
            .then(html => {

                setTimeout(() => {

                    skeleton.style.display = "none";
                    container.innerHTML = html;

                    // SHOW PRODUCTS WITH FADE-IN
                    container.style.display = "flex";
                    container.classList.add("fade-in");

                    setTimeout(() => {
                        container.classList.remove("fade-in");
                    }, 400);

                    initAddToCart();

                }, 400); // fake delay for smooth UX

            });
    });
}










// ===================================
// 10. PRODUCTS SEARCH
// ===================================
function initLiveSearch() {

    const input = document.getElementById('productSearch');
    const container = document.getElementById('productContainer');

    if (!input || !container) return;

    let timer;

    input.addEventListener('input', function () {

        clearTimeout(timer);

        let query = this.value;

        timer = setTimeout(() => {

            fetch(`/products/search?q=${query}`)
                .then(res => res.text())
                .then(html => {

                    container.innerHTML = html;

                    // re-bind cart buttons after update
                    initAddToCart();
                });

        }, 400); // debounce delay
    });
}
















// ===================================
// 10. PRODUCTS REVIEWS
// ===================================
function initReviewSystem() {

    const stars = document.querySelectorAll('.star');
    const form = document.getElementById('reviewForm');
    const ratingInput = document.getElementById('ratingValue');
    const toast = document.getElementById('reviewToast');

    if (!form || !stars.length || !ratingInput || !toast) return;

    let selectedRating = 0;

    // ===============================
    // STAR RATING SYSTEM
    // ===============================
    stars.forEach(star => {

        star.addEventListener('mouseover', () => {
            highlight(star.dataset.value);
        });

        star.addEventListener('click', () => {
            selectedRating = parseInt(star.dataset.value);
            ratingInput.value = selectedRating * 2; // 1–10 system
            setActive(selectedRating);
        });

        star.addEventListener('mouseout', () => {
            setActive(selectedRating);
        });

    });

    function highlight(value) {
        stars.forEach(star => {
            star.classList.toggle(
                'hovered',
                star.dataset.value <= value
            );
        });
    }

    function setActive(value) {
        stars.forEach(star => {
            star.classList.toggle(
                'active',
                star.dataset.value <= value
            );
        });
    }

    // ===============================
    // PREVENT DOUBLE SUBMIT
    // ===============================
    let isSubmitting = false;

    // ===============================
    // AJAX FORM SUBMIT
    // ===============================
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (isSubmitting) return;

        if (!selectedRating) {
            showToast("Please select a rating ⭐");
            return;
        }

        isSubmitting = true;

        const btn = form.querySelector('button[type="submit"]');
        if (btn) btn.disabled = true;

        fetch(this.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": window.Laravel.csrfToken,
                "Accept": "application/json"
            },
            body: new FormData(this)
        })
        .then(async res => {

            const data = await res.json();

            if (!res.ok) {
                throw data;
            }

            return data;
        })
        .then(data => {

            if (data.success) {

                showToast("Review submitted successfully ⭐");

                form.reset();
                selectedRating = 0;
                setActive(0);
            }

        })
        .catch(err => {

            // Laravel validation or auth errors
            if (err.message) {
                showToast(err.message);
            } else {
                showToast("Something went wrong");
            }

        })
        .finally(() => {

            isSubmitting = false;
            if (btn) btn.disabled = false;

        });

    });

    // ===============================
    // TOAST NOTIFICATION
    // ===============================
    function showToast(message) {

        toast.innerText = message;
        toast.classList.add('show');

        setTimeout(() => {
            toast.classList.remove('show');
        }, 2500);
    }
}

