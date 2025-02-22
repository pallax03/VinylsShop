<section>
    <h1>VinylsShop Dashboard</h1>
    <div class="callout">
        <p>Here you can manage the vinyls and albums in the shop.</p>
    </div>
</section>
<div class="div"></div>
<section>
    <h2 class="admin-vinyls-header">Vinyls</h2>
    <table>
        <caption>List of vinyls with actions for deleting, editing, and viewing details</caption>
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
            <?php foreach ($vinyls as $vinyl): ?>
                <tr id="tr-vinyl_<?php echo $vinyl['id_vinyl']?>" data-cost="<?php echo $vinyl['cost']?>" data-stock="<?php echo $vinyl['stock']?>">
                    <td>
                        <button class="delete" onclick="deleteVinyl(<?php echo $user['id_vinyl']; ?>)" aria-label="Delete vinyl">
                            <span aria-hidden="true"><i class="bi bi-x"></i></span>
                        </button>
                    </td>
                    <td> <?php echo $vinyl["stock"] ?> x</td>
                    <td> <?php echo $vinyl["title"] ?> </td>
                    <td> <?php echo $vinyl["cost"] ?> €</td>
                    <td>
                        <button aria-label="Edit Vinyl" onclick="loadVinyl(<?php echo $vinyl['id_vinyl']?>)" class="edit">
                            <span aria-hidden="true"><i class="bi bi-pencil"></i></span>
                        </button>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</section>
<section>
    <form class= "hidden" action="/vinyl" id="form-vinyl" method="post">
        <h2>Vinyl</h2>
        <ul>
            <li>
                <label for="input-stock">Stock</label>
                <input type="number" name="stock" min="0" step="1" id="input-stock" aria-required="true" />
            </li>
            <li>
                <label for="input-cost">Price</label>
                <input type="number" name="price" min="0" step="0.01" id="input-cost" placeholder="€" aria-required="true" />
            </li>
            <li id="li-form_reset" class="split">
                <div class="button">
                    <i class="bi bi-x"></i>
                    <button class="close" type="button" id="btn-vinyl_reset" aria-label="Reset Form">Reset</button>
                </div>
            </li>
            <li class="split">
                <div class="button">
                    <i class="bi bi-pencil"></i>
                    <button type="button" id="btn-vinyl_submit" aria-label="Edit Vinyl">Edit</button>
                </div>
            </li>
        </ul>
        <div class="callout">
            <p>If edit is pressed, and you wanted to add instead, press reset!</p>
        </div>
    </form>
</section>

<script src="/resources/js/vinyls.js"></script>
