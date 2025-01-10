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
                <td>' . $vinyl["title"] . '</td>
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