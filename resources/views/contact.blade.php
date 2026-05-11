@extends('layouts.app')

@section('content')

<!-- Spacer -->
<div class="nav-spacer"></div>

<!-- Contact Section -->
<section class="cont-contact-section py-5">
    <div class="container">

        <!-- Heading -->
        <div class="text-center mb-5" data-aos="fade-down">
            <h6 class="cont-letter-spacing text-primary fw-bold text-uppercase">
                Get In Touch
            </h6>

            <h2 class="display-5 fw-bold">
                We'd Love To Hear From You
            </h2>

            <p class="text-muted col-lg-6 mx-auto">
                Have questions, suggestions, or need support? Send us a message and we’ll get back to you as soon as possible.
            </p>
        </div>

        <div class="row align-items-center g-5">

            <!-- Left Info -->
            <div class="col-lg-5" data-aos="fade-right">

                <div class="cont-contact-info-card shadow-lg">

                    <div class="cont-info-top">
                        <h3 class="fw-bold mb-3">
                            Contact Information
                        </h3>

                        <p class="mb-0">
                            Fill up the form and our team will get back to you within 24 hours.
                        </p>
                    </div>

                    <!-- Item -->
                    <div class="cont-info-item">
                        <div class="cont-icon-box">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>

                        <div>
                            <h5>Address</h5>
                            <p>Your Office Address Here</p>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="cont-info-item">
                        <div class="cont-icon-box">
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                        <div>
                            <h5>Email</h5>
                            <p>support@example.com</p>
                        </div>
                    </div>

                    <!-- Item -->
                    <div class="cont-info-item">
                        <div class="cont-icon-box">
                            <i class="fa-solid fa-phone"></i>
                        </div>

                        <div>
                            <h5>Phone</h5>
                            <p>+92 300 1234567</p>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Form -->
            <div class="col-lg-7" data-aos="fade-left">

                <div class="card cont-contact-card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-lg-5">

                        <form>

                            <div class="row">

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">
                                        Your Name
                                    </label>

                                    <input type="text"
                                        class="form-control cont-custom-input"
                                        placeholder="Enter your name">
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-semibold">
                                        Your Email
                                    </label>

                                    <input type="email"
                                        class="form-control cont-custom-input"
                                        placeholder="Enter your email">
                                </div>

                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Subject
                                </label>

                                <input type="text"
                                    class="form-control cont-custom-input"
                                    placeholder="Enter subject">
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Message
                                </label>

                                <textarea rows="5"
                                    class="form-control cont-custom-input"
                                    placeholder="Write your message..."></textarea>
                            </div>

                            <button class="btn btn-primary btn-lg w-100 cont-custom-btn">
                                <i class="bi bi-send-fill me-2"></i>
                                Send Message
                            </button>

                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection