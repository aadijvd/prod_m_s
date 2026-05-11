//*****************************************************  full width slider
$(document).ready(function () {

    if ($(".hero-slider .owl-carousel").length) { //check
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
                0: {
                    items: 1
                },
                768: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }
        });
    }
});


//************************************************ */ scroll event
window.addEventListener('scroll', function () {
    let navbar = document.getElementById('mainNavbar');

    // a check
    if (!navbar) return;

    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

//************************************************ * back to top btn
document.addEventListener("DOMContentLoaded", function () {

    const btn = document.getElementById("cont-backToTopBtn");

    // SAFETY CHECK (IMPORTANT)
    if (!btn) return;

    // show/hide on scroll
    window.addEventListener("scroll", function () {
        if (window.scrollY > 300) {
            btn.classList.add("show");
        } else {
            btn.classList.remove("show");
        }
    });

    // smooth scroll to top
    btn.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

});

//******************************************************    Product Details Page
// PRODUCT DETAIL PAGE

document.addEventListener("DOMContentLoaded", function () {

    const plus = document.querySelector('.qty-plus');
    const minus = document.querySelector('.qty-minus');
    const input = document.querySelector('.qty-input');

    if (plus && minus && input) {

        plus.addEventListener('click', () => {
            input.value = parseInt(input.value) + 1;
        });

        minus.addEventListener('click', () => {
            if (input.value > 1) input.value--;
        });

    }

});


//******************************************************    add to cart
document.addEventListener("DOMContentLoaded", function () {

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
                // for simple div
                //             .then(res => res.json())
                //             .then(data => {

                //                 let cartCount = document.getElementById('cart-count');
                //                 if (cartCount) {
                //                     cartCount.innerText = data.count;
                //                 }

                //                 // show bootstrap message
                //                 let msgBox = document.getElementById('cart-message');

                //                 let alertDiv = document.createElement('div');
                //                 alertDiv.className = "alert alert-success alert-dismissible fade show shadow";
                //                 alertDiv.role = "alert";
                //                 alertDiv.innerHTML = `
                //     Added to cart successfully!
                // `;

                //                 msgBox.appendChild(alertDiv);

                //                 // remove after 3 seconds
                //                 setTimeout(() => {
                //                     alertDiv.classList.remove('show');
                //                     alertDiv.classList.add('hide');

                //                     setTimeout(() => {
                //                         alertDiv.remove();
                //                     }, 300);
                //                 }, 3000);

                //             });



                // for new bootstrap style
                .then(res => res.json())
                .then(data => {

                    let cartCount = document.getElementById('cart-count');
                    if (cartCount) {
                        cartCount.innerText = data.count;
                    }

                    // Bootstrap toast
                    let toastEl = document.getElementById('cartToast');
                    let toast = new bootstrap.Toast(toastEl, {
                        delay: 3000
                    });

                    toast.show();
                });

        });

    });

});




//******************************************************    cart update
document.addEventListener('click', function (e) {

    if (e.target.classList.contains('plus') || e.target.classList.contains('minus')) {

        let id = e.target.dataset.id;
        let input = document.querySelector(`.qty[data-id='${id}']`);
        if (!input) return; //check

        let qty = parseInt(input.value);

        if (e.target.classList.contains('plus')) qty++;
        else if (qty > 1) qty--;

        input.value = qty;

        fetch('/update-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                id,
                qty
            })
        });
    }

    if (e.target.classList.contains('remove')) {

        let id = e.target.dataset.id;

        fetch('/remove-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                id
            })
        })
            .then(() => location.reload());
    }

});




//******************************************************    product page stats
document.addEventListener("DOMContentLoaded", () => {

    const counters = document.querySelectorAll('.abt-counter');

    const runCounter = (counter) => {

        const target = +counter.getAttribute('data-count');
        let count = 0;

        const speed = target / 100;

        const updateCounter = () => {

            count += speed;

            if (count < target) {

                if (target >= 1000) {
                    counter.innerText = Math.floor(count).toLocaleString();
                } else {
                    counter.innerText = Math.floor(count);
                }

                requestAnimationFrame(updateCounter);

            } else {

                if (target >= 1000) {
                    counter.innerText = target.toLocaleString();
                } else {
                    counter.innerText = target;
                }
            }
        };

        updateCounter();
    };

    const observer = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) {

                runCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });

    }, {
        threshold: 0.5
    });

    counters.forEach(counter => {
        observer.observe(counter);
    });

});