<?php
$pageTitle = "Home | PinkBite";
include 'header.php';
include 'config.php'; 

$menuItems = [];
$result = mysqli_query($conn, "SELECT * FROM menu LIMIT 12"); 
while ($row = mysqli_fetch_assoc($result)) {
    $menuItems[] = $row;
}
?>

<!-- Hero Section -->
<section class="hero text-center py-5" style="background-color: #fff0f5;">
    <div class="container">
        <h2 style="font-size: 48px; color: #ff69b4;" data-aos="fade-up">୨ৎ Welcome to PinkBite Restaurant ୨ৎ</h2>
        <p class="mt-3" data-aos="fade-up" data-aos-delay="100">
            Enjoy our delicious meals served with love and a touch of pink! 💕
        </p>

    </div>
</section>

<!-- Our Specials (Slider from DB) -->
<section class="py-5" style="background-color: #ffe4ec;">
    <div class="container text-center">
        <h3 style="color: #ff69b4;" data-aos="fade-up">Our Specials</h3>

        <div id="carouselSpecials" class="carousel slide mt-4" data-bs-ride="false">
            <div class="carousel-inner">

                <?php
                $chunkedItems = array_chunk($menuItems, 3); 
                foreach ($chunkedItems as $i => $chunk) {
                    echo '<div class="carousel-item' . ($i === 0 ? ' active' : '') . '">';
                    echo '<div class="row justify-content-center">';
                    foreach ($chunk as $item) {
                        echo '
                            <div class="col-md-4 mb-3">
                                <img src="' . $item['image'] . '" class="food-img img-fluid rounded" alt="' . $item['name'] . '" style="max-height: 200px;">
                                <div class="food-name mt-2 fw-bold" style="color: #d63384;">' . $item['name'] . '</div>
                                <div class="food-price text-muted">Rp ' . number_format($item['price'], 0, ',', '.') . '</div>
                            </div>
                        ';
                    }
                    echo '</div></div>';
                }
                ?>

            </div>

            <!-- Arrows -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselSpecials" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-pink rounded-circle"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselSpecials" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-pink rounded-circle"></span>
            </button>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="py-5" style="background-color: #ffe4e1;">
    <div class="container text-center">
        <h3 style="color: #ff69b4;">A Little About PinkBite </h3>
        <p class="mt-3">PinkBite is a restaurant with a cheerful and sweet feel, serving food and drinks with a touch of pink that is full of love 💕</p>
    </div>
</section>

<!-- Visit Us -->
<section class="py-5 text-center">
    <h3 style="color: #ff69b4;">Visit Us</h3>
    <p class="mt-3">President University<br>Follow us on Instagram: @pinkbite.rest</p>
</section>

<?php include 'footer.php'; ?>

<!-- AOS & Bootstrap JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
