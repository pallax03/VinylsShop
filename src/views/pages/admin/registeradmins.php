<form id="form-register">
    <h1> Add a new Admin </h1>
    <ul>
        <li>
            <label for="mail">Mail</label>
            <input type="email" id="input-admin_mail" name="mail" autocomplete="email" required />
        </li>
        <li>
            <label for="password">Password</label>
            <input type="password" id="input-admin_password" name="password" required />
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-person-fill"></i>
                <button class="animate" id="btn-admin_submit">Add</button>
            </div>
        </li>
    </ul>
</form>
<div class="callout">
    <p>Every admin has notifications by defaults.</p>
</div>
<script src="/resources/js/admin.js"></script>