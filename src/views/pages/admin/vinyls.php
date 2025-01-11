<h2 class="admin-vinyls-header">Vinyls</h2>
<table summary="List of vinyls with actions for deleting, editing, and viewing details">
    <thead>
        <tr>
            <th scope="col">Delete</th>
            <th scope="col">Title</th>
            <th scope="col">Info</th>
            <th scope="col">Cost</th>
            <th scope="col">Edit</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">
                <button id="btn-vinyls_add" class="add" aria-label="Add a new vinyl">
                    <span aria-hidden="true"><i class="bi bi-plus"></i></span>
                </button>
            </td>
        </tr>
        <?php foreach($data["vinyls"] as $vinyl):
            echo ('<tr">
                <td>
                    <button class="delete" onclick="deleteUser()" aria-label="Delete vinyl">
                        <span aria-hidden="true"><i class="bi bi-x"></i></span>
                    </button>
                </td>
                <td data-id="' . $vinyl["id_vinyl"] . '" data-stock="' . $vinyl["stock"] . '">' . $vinyl["title"] . '</td>
                <td> ' . $vinyl["type"] . ' - ' . $vinyl["inch"] . ' - ' . $vinyl["rpm"] . '</td>
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
<form class="hidden" action="/vinyl/edit">
    <h2>Update vinyl info</h2>
    <ul>
        <li>
            <label for="input-vinyl_stock">Stock</label>
            <input type="number" id="input-vinyl_stock" name="stock"/>
        </li>
        <li>
            <label for="input-vinyl_type">Type</label>
            <input type="text" name="type" id="input-vinyl_type"/>
        </li>
        <li>
            <label for="input-vinyl_inches">Inches</label>
            <input type="number" id="input-vinyl_inches" name="inches"/>
        </li>
        <li>
            <label for="input-vinyl_rpm">Rpm</label>
            <input type="number" id="input-vinyl_rpm" name="rpm"/>
        </li>
        <li id="li-form_reset" class="split">
            <div class="button">
                <i class="bi bi-x"></i>
                <button class="close" type="button" id="btn-user_reset" aria-label="Reset Form">Reset</button>
            </div>
        </li>
        <li class="split">
            <div class="button">
                <i class="bi bi-pencil"></i>
                <button type="button" id="btn-user_submit" aria-label="Edit Vinyl">Edit</button>
            </div>
        </li>
    </ul>
</form>