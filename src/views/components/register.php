<form id="form-register">
    <h1> Signup </h1>
    <ul>
        <li>
            <label for="mail">Mail</label>
            <input type="email" id="input-register_mail" name="mail" autocomplete="email" required />
        </li>
        <li>
            <label for="password">Password</label>
            <input type="password" id="input-register_password" name="password" required />
        </li>
        <li>
            <label class="checkbox" for="notifications">Notifications:
                <input type="checkbox" id="input-register_notifications" name="notifications" checked />
                <span class="checkmark"><i class="bi bi-check"></i></span>
            </label>
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-person-fill"></i>
                <button class="animate" id="btn-register_submit">Register</button>
            </div>
        </li>
        <li>
            <div class="message" id="div-register_response"></div>
        </li>
    </ul>
</form>