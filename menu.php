<?php
$pageTitle = "Menu | PinkBite";
include 'header.php';
include 'config.php';
?>

<section class="py-5" style="background-color: #fff0f5;">
    <div class="container text-center">
        <h2 style="color: #ff69b4;" data-aos="fade-up">୨ৎ Our Menu ୨ৎ</h2>
        <p class="mb-4" data-aos="fade-up" data-aos-delay="100">
        Special menu options with a touch of pink colour 💗
        </p>

        <div class="row g-4">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM menu");
            while ($row = mysqli_fetch_assoc($query)) {
            ?>
                <div class="col-md-4 col-sm-6" data-aos="zoom-in">
                    <div class="card border-0 shadow-sm h-100 rounded-4">
                        <img src="<?= $row['image'] ?>" class="card-img-top rounded-top-4" alt="<?= $row['name'] ?>" style="height: 230px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-pink fw-bold"><?= $row['name'] ?></h5>
                            <p class="card-text text-muted">Rp <?= number_format($row['price'], 0, ',', '.') ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>

<!-- AOS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
