<footer>
    <ul>
        <li>
            <a href="https://www.unibo.it/it/studiare/dottorati-master-specializzazioni-e-altra-formazione/insegnamenti/insegnamento/2024/378225">
                <ul>
                    <li>
                        <img src="https://www.unibo.it/it/++theme++unibotheme.portale/img/header/sigillo1x_xl.png?v=2" alt="">
                    </li>
                    <li>
                        <p>8615</p>
                        <p> - </p>
                        <p>Final project of the course: Tecnologie Web (41731)</p>
                    </li>
                </ul>
            </a>
        </li>
        <li>
            <button class="darkmode" id="btn-darkmode">darkmode:</button>
        </li>
        <li>
            <ul>
                <li>
                    <a href="https://github.com/pallax03/TecnologieWeb-Progetto">
                        <div>
                            <i class="bi bi-github"></i>
                            <p>About Us</p>
                        </div>
                    </a>
                </li>
                <li>
                    <?php if (Session::isSuperUser()): ?>
                        <a href="/dashboard/users">
                            <p>Manage Users</p>
                        </a>
                    <?php else: ?>
                        <a href="/user">
                            <p>Login / Signup</p>
                        </a>
                    <?php endif; ?>
                </li>
                <li>
                    <a href="/coupons">
                        <p>Coupons</p>
                    </a>
                </li>
                <li>
                    <?php if (Session::isSuperUser()): ?>
                        <a href="/dashboard">
                            <p>Manage Vinyls</p>
                        </a>
                    <?php else: ?>
                        <a href="/cart">
                            <p>Cart</p>
                        </a>
                    <?php endif; ?>
                </li>
            </ul>
        </li>
        <li>
            <div class="div"></div>
        </li>
        <li>
            <a class="copyrights" href="">
                <p>Copyright © <?php echo date("Y"); ?> VinylsShop - All rights reserved</p>
                <p>IT</p>
                <p> - </p>
                <p>€</p>
            </a>
        </li>
    </ul>
</footer>