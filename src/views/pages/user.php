<main>
    <?php if (Session::isLogged()): ?>
        <section aria-labelledby="user-info">
            <i class="bi bi-person-fill"></i>
            <h1>User</h1>
            <h2 id="user-mail"><?php echo $user['mail'] ?></h2>
            <p id="user-balance">Balance: <?php echo $user['balance'] ?> €</p>
            <a href="/logout">Logout</a>
            
            <!-- <div class="input-group">
                <div class="button">
                    <label for="">Address</label>
                    <i class="bi bi-geo-alt-fill"></i>
                    <button>
                        <i class="bi bi-caret-left-fill"></i>
                        <i class="bi bi-plus"></i>
                        <i class="bi bi-caret-right-fill"></i>
                    </button>
                </div>
                <div class="button">
                    <label for="">Payment</label>
                    <i class="bi bi-credit-card-fill"></i>
                    <button>
                        <i class="bi bi-caret-left-fill"></i>
                        <i class="bi bi-plus"></i>
                        <i class="bi bi-caret-right-fill"></i>
                    </button>
                </div>
            </div> -->
            
        </section>
        <section>
            <?php foreach ($orders as $order): ?>
                <?php include COMPONENTS . '/cards/orders.php' ?>
            <?php endforeach; ?>
        </section>
    <?php else: ?>
        <?php include COMPONENTS . 'login.php' ?>
    <?php endif; ?>
</main>