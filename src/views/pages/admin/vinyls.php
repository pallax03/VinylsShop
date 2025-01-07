<h2 class="admin-vinyls-header">Vinyls</h2>
<table summary="List of vinyls with actions for deleting, editing, and viewing details">
    <thead>
        <tr>
            <th scope="col">Delete</th>
            <th scope="col">Album Title</th>
            <th scope="col">Type</th>
            <th scope="col">Inch</th>
            <th scope="col">Rpm</th>
            <th scope="col">Cost</th>
            <th scope="col">Edit</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="7">
                <a id="add" class="add" href="/dashboard/add/user" aria-label="Add a new vinyl">
                    <span aria-hidden="true">+</span>
                </a>
            </td>
        </tr>
        <?php foreach($data["vinyls"] as $vinyl):
            echo ('<tr class="vinyl-record">
                <td>
                    <button class="delete" onclick="deleteUser()" aria-label="Delete vinyl">
                        <span aria-hidden="true">x</span>
                    </button>
                </td>
                <td>' . $vinyl["title"] . '</td>
                <td>' . $vinyl["type"] . '</td>
                <td>' . $vinyl["inch"] . '</td>
                <td>' . $vinyl["rpm"] . '</td>
                <td>€' . $vinyl["cost"] . '</td>
                <td>
                    <a class="edit" aria-label="Edit vinyl details">
                        <span aria-hidden="true"><i class="bi bi-pencil"></i></span>
                    </a>
                </td>
            </td>');
        endforeach;
        ?>
    </tbody>
</table>