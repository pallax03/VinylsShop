<section>
    <h1>VinylsShop Dashboard</h1>
    <div class="callout">
        <p>Here you can manage the vinyls and albums in the shop.</p>
    </div>
</section>
<div class="div"></div>
<section>
    <h2 class="admin-vinyls-header">Vinyls</h2>
    <table summary="List of vinyls with actions for deleting, editing, and viewing details">
        <thead>
            <tr>
                <th scope="col">Stock</th>
                <th scope="col">Title</th>
                <th scope="col">Cost</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5">
                    <button id="btn-vinyls_add" class="add" aria-label="Add a new vinyl">
                        <span aria-hidden="true">
                            <i class="bi bi-plus"></i>
                        </span>
                    </button>
                </td>
            </tr>
            <?php foreach ($data["vinyls"] as $vinyl):
                echo ('<tr">
                <td> ' . $vinyl["stock"] . 'x</td>
                <td>' . $vinyl["title"] . '</td>
                <td>€' . $vinyl["cost"] . '</td>
                <td>
                    <a class="edit" aria-label="Edit vinyl details">
                        <span aria-hidden="true"><i class="bi bi-pencil"></i></span>
                    </a>
                </td>
            </tr>');
            endforeach;
            ?>
        </tbody>
    </table>
</section>
<div class="div"></div>
<form action="/vinyl" id="form-vinyl" method="post">
    <h2>Vinyl</h2>
    <ul>
        <li>
            <label for="input-discount_code">Code</label>
            <input type="text" name="discount_code" id="input-discount_code" placeholder="EXAMPLE10" aria-required="true" />
        </li>
        <li>
            <label for="input-percentage">Percentage</label>
            <input type="text" name="percentage" id="input-percentage" placeholder="%" aria-required="true" />
        </li>
        <li class="split">
            <label for="input-valid_from">From:</label>
            <input type="date" name="valid_from" id="input-valid_from" value="<?php echo date('Y-m-d'); ?>" aria-required="true" />
        </li>
        <li class="split">
            <label for="input-valid_until">Until:</label>
            <input type="date" name="valid_until" id="input-valid_until" value="<?php echo date('Y-m-d', strtotime('+1 month')); ?>" aria-required="true" />
        </li>
        <li id="li-form_reset" class="split">
            <div class="button">
                <i class="bi bi-x"></i>
                <button class="close" type="button" id="btn-coupon_reset" aria-label="Reset Form">Reset</button>
            </div>
        </li>
        <li class="split">
            <div class="button">
                <i class="bi bi-percent"></i>
                <button type="button" id="btn-coupon_submit" aria-label="Add Coupon">Add</button>
            </div>
        </li>
    </ul>
    <div class="callout">
        <p>If edit pressed, and want to add press reset!</p>
    </div>
</form>
<script src="/resources/js/vinyls.js"></script>
<div class="div"></div>
<section>
    <h2>Albums</h2>
    <table summary="List of albums with actions for deleting, editing, and viewing details">
        <thead>
            <tr>
                <th scope="col">Delete</th>
                <th scope="col">Title</th>
                <th scope="col">Artist</th>
                <th scope="col">Year</th>
                <th scope="col">Edit</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="5">
                    <button id="btn-albums_add" class="add" aria-label="Add a new album">
                        <span aria-hidden="true"><i class="bi bi-plus"></i></span>
                    </button>
                </td>
            </tr>
            <?php foreach ($data["albums"] as $album):
                echo ('<tr">
                <td>
                    <button class="delete" onclick="deleteUser()" aria-label="Delete album">
                        <span aria-hidden="true"><i class="bi bi-x"></i></span>
                    </button>
                </td>
                <td>' . $album["title"] . '</td>
                <td>' . $album["artist"] . '</td>
                <td>' . $album["cover"] . '</td>
                <td>
                    <a class="edit" aria-label="Edit album details">
                        <span aria-hidden="true"><i class="bi bi-pencil"></i></span>
                    </a>
                </td>
            </tr>');
            endforeach;
            ?>
        </tbody>
    </table>
</section>