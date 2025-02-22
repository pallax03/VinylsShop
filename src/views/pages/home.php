<section class="margin-top no-padding">
    <h2 class="home-title">Welcome to VinylsShop</h2>
    <?php if(isset($vinyls) && !empty($vinyls)): ?>
        <?php
            for ($i=1; $i <= 3; $i++) { 
                include COMPONENTS . 'carousel.php'; 
            }
        ?>
    <?php else: ?>
        <p>There are no vinyls available at the moment!</p>
    <?php endif; ?>
</section>
<article class="home-article">
    <h2>Why buy on VinylsShop?</h2>
    <p>We are the best option of vinyl e-commerce</p>
    <div>
        <section>
            <div>
                <i class="bi bi-lightning-charge-fill"></i>
                <h3>Fast shipping</h3>
            </div>
            <p>Your orders are handled by Amazon, which means you'll receive your vinyl records quickly.</p>
        </section>
        <section>
            <div>
                <i class="bi bi-megaphone-fill"></i>
                <h3>Great prices</h3>
            </div>
            <p>Take advantage of great prices on vinyl and all other products available for purchase.</p>
        </section>
        <section>
            <div>
                <i class="bi bi-shield-shaded"></i>
                <h3>Safe payments</h3>
            </div>
            <p>Pay safely using our checkout: you can pay with major credit cards or using your profile balance.</p>
        </section>
    </div>
</article>

<script src="/resources/js/home.js"></script>