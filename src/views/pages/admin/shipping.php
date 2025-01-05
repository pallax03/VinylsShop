<form action="/shipping" method="post">
    <h2>Shipping Info</h2>
    <ul>
        <li>
            <label for="shipping_courier">Courier</label>
            <input type="text" name="shipping_courier" value="<? echo $_ENV['SHIPPING_COURIER']?>" id="input-shipping_courier">
        </li>
        <li class="split">
            <label for="shipping_cost">Cost</label>
            <input type="text" name="shipping_cost" value="<? echo $_ENV['SHIPPING_COST']?>" id="input-shipping_cost">
        </li>
        <li class="split">
            <label for="shipping_goal">Goal</label>
            <input type="text" name="shipping_goal" value="<? echo $_ENV['SHIPPING_GOAL']?>" id="input-shipping_goal">
        </li>
        <li>
            <div class="large button">
                <i class="bi bi-truck"></i>
                <input type="button" id="btn-shipping_submit" aria-label="Set Shipping" value="Set Shipping" />
            </div>
        </li>
    </ul>
</form>
<script>
    document.getElementById('btn-shipping_submit').addEventListener('click', function() {
        let form = document.querySelector('form');
        let formData = new FormData(form);
        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // NOTIFICATION
            redirect(window.location.href);
        })
        .catch(error => console.error(error));
    });
</script>