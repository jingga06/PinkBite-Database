<?php include 'header.php'; ?>

<!-- Contact Header -->
<section class="py-5 text-center" style="background-color: #ffe4f0;">
    <div class="container">
        <h2 style="color: #ff69b4;" data-aos="fade-down">Contact Us 💌</h2>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">You can contact us anytime, we are ready to hear your sweet story 💖</p>
    </div>
</section>

<!-- Contact Info & Form -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4" data-aos="fade-right">
                <h4 style="color: #ff69b4;">Contact Info</h4>
                <ul class="list-unstyled mt-3">
                    <li class="mb-3">
                        <i class="bi bi-geo-alt-fill me-2 text-danger"></i>
                        Jl. Kampus Hijau, President University, Cikarang
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-telephone-fill me-2 text-success"></i>
                        0877-8302-1100
                    </li>
                    <li class="mb-3">
                        <i class="bi bi-envelope-fill me-2 text-primary"></i>
                        contact@pinkbite.com
                    </li>
                </ul>
            </div>

            <div class="col-md-6" data-aos="fade-left">
                <h4 style="color: #ff69b4;">Send Massage 💬</h4>
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder=" " required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Gmail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Massage</label>
                        <textarea class="form-control" id="message" name="message" rows="4" placeholder=" " required></textarea>
                    </div>
                    <button type="submit" class="btn text-white rounded-pill px-4" style="background-color: #ff69b4;">Send 💌</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init();</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
