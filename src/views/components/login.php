<form id="login_form" action="/login" method="post">
    <h1> Login / Signup </h1>
    <ul>
        <li>
            <label for="mail">Mail</label>
            <input type="email" id="mail" name="mail" autocomplete="email" required />
        </li>
        <li>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
        </li>
        <li>
            <label class="checkbox" for="remember">Stay signed:
                <input type="checkbox" id="remember" name="remember" />
                <span class="checkmark"><i class="bi bi-check"></i></span>
            </label>
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-person-fill"></i>
                <button class="animate" id="login_submit">logga daæi</button>
            </div>
        </li>
        <li>
            <div id="login_response"></div>
        </li>
    </ul>
</form>
<script src="/resources/js/auth.js"></script>